<?php
/**
 * Address Model
 *
 * @author Del
 */

namespace Delatbabel\Contacts\Models;

use Config;
use DB;
use Delatbabel\Applog\Models\Auditable;
use Delatbabel\Fluents\Fluents;
use Delatbabel\Keylists\Models\Keyvalue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Address Model
 *
 * Contains addresses which may map to contacts or companies.
 */
class Address extends Model
{
    use SoftDeletes, Fluents, Auditable;

    /** @var array */
    protected $guarded = ['id'];

    protected $casts = [
        'extended_data'     => 'array',
    ];

    /**
     * Many:Many relationship with Contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function contacts()
    {
        return $this->belongsToMany('Delatbabel\Contacts\Models\Contact')
            ->withPivot(['address_type', 'status', 'start_date', 'end_date']);
    }

    /**
     * Many:Many relationship with Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany('Delatbabel\Contacts\Models\Company')
            ->withPivot(['address_type', 'status', 'start_date', 'end_date']);
    }

    /**
     * Model bootstrap
     *
     * Geocode on save if enabled.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Bail out if geocoding runs in the background.
        if (config('contacts.geocode.background')) {
            return;
        }

        // If geocoding is not backgrounded then do it on every save
        static::saving(function ($model) {
            return $model->geocode();
        });
    }

    /**
     * Claim up to $limit addresses to process for geocoding
     *
     * @param	integer		$claim_owner
     * @param	integer		$limit
     * @return	integer		Number of messages claimed
     */
    public static function claim($claim_owner, $limit=0)
    {
        if (empty($limit)) {
            $limit = config('contacts.geocode.limit');
        }

        // Get a raw PDO connection
        /** @var \PDO $pdo */
        $pdo = DB::getPdo();

        // Note the correct order here:  begin, lock, commit, unlock.
        $pdo->beginTransaction();
        $pdo->exec("LOCK TABLES addresses WRITE");
        $sth = $pdo->prepare("
            UPDATE `addresses`
                SET `lock_owner`=$claim_owner
                WHERE `geocode_status`='pending'
                    AND `lock_owner` IS NULL
                LIMIT $limit
        ");
        $sth->execute();
        $count = $sth->rowCount();
        $pdo->commit();
        $pdo->exec("UNLOCK TABLES");
        return $count;
    }

    /**
     * Return a count of available and unprocessed addresses.
     *
     * @return	integer
     */
    public static function get_count()
    {
        $count = static::where('geocode_status', '=', 'pending')
            ->whereNull('lock_owner')
            ->count();
        return $count;
    }

    /**
     * Process claimed addresses.
     *
     * This function will actually attempt to do the geocoding of the addresses
     * that have been claimed by $claim_owner.
     *
     * @param	integer		$claim_owner
     * @return	integer		Count of addresses we have tried to geocode
     */
    public static function process_claim($claim_owner)
    {
        $addresses = static::where('lock_owner', '=', $claim_owner)->get();
        $count     = 0;

        // Cycle through each message to be sent.
        /** @var Address $address */
        foreach ($addresses as $address) {

            // Attempt to geocode.
            $address->geocode();

            // Unlock the address.  If it was not geocoded then another
            // process will pick it up and try again later.
            $address->lock_owner = null;
            $address->save();
            $count++;
        }

        // Return the count of addresses we have tried to process.
        return $count;
    }

    /**
     * Geocode the provided street address into a latitude and longitude.
     *
     * @return Address provides a fluent interface.
     */
    public function geocode()
    {
        // Bail out if geocoding is disabled or already complete
        if (! config('contacts.geocode.enable')) {
            $this->geocode_status = 'disabled';
            return $this;
        }

        if ($this->geocode_status == 'complete') {
            return $this;
        }

        // Bail out if there is no street address, we can't geocode those.
        if (empty($this->street)) {
            $this->geocode_status = 'failed';
            return $this;
        }

        // Build query array
        $query   = [];
        $query[] = $this->street       ?: '';
        $query[] = $this->suburb       ?: '';
        $query[] = $this->city         ?: '';
        if (! empty($this->state_code)) {
            $query[] = $this->state_code;
        } else {
            $query[] = $this->state_name   ?: '';
        }
        $query[] = $this->postal_code  ?: '';
        if (! empty($this->country_code)) {
            $query[] = $this->country_code;
        } else {
            $query[] = $this->country_name   ?: '';
        }

        // Build query string from the array
        $query = trim(implode(',', array_filter($query)));
        $query = str_replace(' ', '+', $query);

        // Build url
        $url = config('contacts.geocode.url');
        $url .= '?address=' . $query;
        if (config('contacts.geocode.use_api_key')) {
            $url .= '&key=' . config('contacts.geocode.api_key');
        }

        // Try to get geocoded address
        // FIXME -- replace this with a call to GuzzleHttp.
        try {
            $geocode = file_get_contents($url);
        } catch (\Exception $e) {
            // timeouts and stuff
            return $this;
        }

        // If we get an empty result, don't try this one again, because it will always
        // get an empty result.  At the very least if the address can be geocoded, Google
        // will return an error which we will put in extended_data (e.g. API limit
        // exceeded, etc).
        if (empty($geocode)) {
            $this->geocode_status='failed';
            return $this;
        }

        $output = json_decode($geocode);

        // Can't use a mutator inside an event function so do this instead.
        $extended_data            = json_decode($this->extended_data, true);
        $extended_data['geocode'] = $output;
        $this->extended_data      = json_encode($extended_data);

        // If we got a ZERO_RESULTS status then fail
        if (! empty($output->status) && ($output->status == 'ZERO_RESULTS')) {
            $this->geocode_status='failed';
            return $this;
        }

        // If we got output but nothing in the results then this is probably an API
        // limit error or some such.  Leave it as pending and try again later.
        if (count($output->results) == 0 || empty($output->results[0])) {
            return $this;
        }

        // Grab the first result from the google return result (which is an array).
        $result = $output->results[0];
        if ($geo = $result->geometry) {
            $this->lat = $geo->location->lat;
            $this->lng = $geo->location->lng;
        }

        // Get the place ID and formatted address if we have one
        if (! empty($result->place_id)) {
            $this->place_id = $result->place_id;
        }
        if (! empty($result->formatted_address)) {
            $this->formatted_address = $result->formatted_address;
        }

        // Read through the address_components to see what other columns we can fill
        // This means ferreting through a types array within each address_components
        // which is not highly efficient but it works.
        $components = $result->address_components;
        foreach ($components as $component) {
            $types = $component->types;

            if (in_array('locality', $types)) {
                $this->suburb = $component->long_name;
            }
            if (in_array('sublocality', $types)) {
                $this->suburb = $component->long_name;
            }
            if (in_array('country', $types)) {
                $this->country_name = $component->long_name;
                $this->country_code = $component->short_name;
            }
            if (in_array('postal_code', $types)) {
                $this->postal_code = $component->long_name;
            }
            if (in_array('administrative_area_level_1', $types)) {
                $this->state_name = $component->long_name;
                $this->state_code = $component->short_name;
            }
        }

        // Update the status
        $this->geocode_status = 'complete';

        return $this;
    }

    /**
     * Get all of the address types (categories).
     *
     * Returns a key => value array, e.g.
     * billing => Billing
     * Suitable for use in pull-down lists.
     *
     * @return array
     */
    public static function getTypes()
    {
        return Keyvalue::getKeyValuesByType('address-types');
    }

    /**
     * Get all of the address statuses (categories).
     *
     * Returns a key => value array, e.g.
     * current => Current
     * Suitable for use in pull-down lists.
     *
     * @return array
     */
    public static function getStatuses()
    {
        return Keyvalue::getKeyValuesByType('address-statuses');
    }
}
