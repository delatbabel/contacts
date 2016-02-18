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

/**
 * Address Model
 *
 * Contains addresses which may map to contacts or companies.
 */
class Address extends Model
{
    use SoftDeletes, Fluents;

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
     * Geocode the provided street address into a latitude and longitude.
     *
     * @return Address provides a fluent interface.
     */
    public function geocode()
    {
        // Build query array
        $query = [];
        $query[] = $this->street       ?: '';
        $query[] = $this->suburb       ?: '';
        $query[] = $this->city         ?: '';
        $query[] = $this->state        ?: '';
        $query[] = $this->post_code    ?: '';
        $query[] = $this->country_name ?: '';

        // Build query string from the array
        $query = trim( implode(',', array_filter($query)) );
        $query = str_replace(' ', '+', $query);

        // Build url
        $url = Config::get('geocode.url');
        $url .= '?address=' . $query;
        if (Config::get('geocode.use_api_key')) {
            $url .= '&key=' . Config::get('geocode.api_key');
        }

        // Try to get geocoded address
        // FIXME -- replace this with a call to GuzzleHttp.
        if ( $geocode = file_get_contents($url) ) {
            $output = json_decode($geocode);
            if ( count($output->results) && isset($output->results[0]) ) {
                if ( $geo = $output->results[0]->geometry ) {
                    $this->lat = $geo->location->lat;
                    $this->lng = $geo->location->lng;
                }
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
