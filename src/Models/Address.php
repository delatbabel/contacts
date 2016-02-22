<?php
/**
 * Address Model
 *
 * @author Del
 */

namespace Delatbabel\Contacts\Models;

use Delatbabel\Fluents\Fluents;
use Delatbabel\Keylists\Models\Keyvalue;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Config;
use Delatbabel\Applog\Models\Auditable;

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
     * Ensure that the full_name field is filled even if it isn't initially provided.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            return $model->geocode();
        });
    }

    /**
     * Geocode the provided street address into a latitude and longitude.
     *
     * @return Address provides a fluent interface.
     */
    public function geocode()
    {
        // Bail out if geocoding is disabled.
        if (! Config::get('contacts.geocode.enable')) {
            return $this;
        }

        // Build query array
        $query = [];
        $query[] = $this->street       ?: '';
        $query[] = $this->suburb       ?: '';
        $query[] = $this->city         ?: '';
        $query[] = $this->state_name   ?: '';
        $query[] = $this->postal_code  ?: '';
        $query[] = $this->country_name ?: '';

        // Build query string from the array
        $query = trim(implode(',', array_filter($query)));
        $query = str_replace(' ', '+', $query);

        // Build url
        $url = Config::get('contacts.geocode.url');
        $url .= '?address=' . $query;
        if (Config::get('contacts.geocode.use_api_key')) {
            $url .= '&key=' . Config::get('contacts.geocode.api_key');
        }

        // Try to get geocoded address
        // FIXME -- replace this with a call to GuzzleHttp.
        $geocode = file_get_contents($url);

        if (empty($geocode)) {
            return $this;
        }

        $output = json_decode($geocode);
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
