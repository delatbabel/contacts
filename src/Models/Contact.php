<?php
/**
 * Contact Model
 *
 * @author Del
 */

namespace Delatbabel\Contacts\Models;

use Carbon\Carbon;
use Delatbabel\Applog\Models\Auditable;
use Delatbabel\Fluents\Fluents;
use Delatbabel\Keylists\Models\Keyvalue;
use Delatbabel\NestedCategories\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Contact Model
 *
 * Contains contacts which may map to companies.
 */
class Contact extends Model
{
    use SoftDeletes, Fluents, Auditable;

    /** @var array */
    protected $guarded = ['id'];

    protected $casts = [
        'extended_data'     => 'array',
    ];

    /**
     * Many:Many relationship with Address
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function addresses()
    {
        return $this->belongsToMany('Delatbabel\Contacts\Models\Address')
            ->withPivot(['address_type', 'status', 'start_date', 'end_date']);
    }

    /**
     * Many:Many relationship with Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function category()
    {
        return $this->belongsTo('Delatbabel\NestedCategories\Models\Category');
    }

    /**
     * Many:1 relationship with Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('Delatbabel\Contacts\Models\Company');
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
        static::saving(function ($model) {
            return $model->fillFullName()->fillCompanyName();
        });
    }

    // Mutators to ensure that nullable fields are correctly set to null not zero or empty

    /**
     * Set the company_id attribute
     *
     * @param $value
     * @link https://laravel.com/docs/5.1/eloquent-mutators#accessors-and-mutators
     */
    public function setCompanyIdAttribute($value)
    {
        if (empty($value)) {
            $value = null;
        }
        $this->attributes['company_id'] = $value;
    }

    /**
     * Set the category_id attribute
     *
     * @param $value
     * @link https://laravel.com/docs/5.1/eloquent-mutators#accessors-and-mutators
     */
    public function setCategoryIdAttribute($value)
    {
        if (empty($value)) {
            $value = null;
        }
        $this->attributes['category_id'] = $value;
    }

    /**
     * Attempt to capitalise a name.
     *
     * @param       string  $str
     * @return      string
     */
    public function capitaliseName($str)
    {
        // exceptions to standard case conversion
        $all_lowercase = 'De La|De Las|Der|Van|Von|Van De|Van Der|Vit De|Von|Ten|Or|And';

        // addresses, essay titles ... and anything else
        $all_uppercase = 'Po|Rr|Se|Sw|Ne|Nw';
        $prefixes      = "Mc|Mac";
        $suffixes      = "'S";

        // captialize all first letters
        $str = preg_replace_callback('/\\b(\\w)/',
            function ($matches) {
                return strtoupper($matches[1]);
            },
            strtolower(trim($str))
        );

        // capitalize acronymns and initialisms e.g. PO
        $str = preg_replace_callback("/\\b($all_uppercase)/",
            function ($matches) {
                return strtoupper($matches[1]);
            },
            $str
        );

        // decapitalize short words e.g. van der
        $str = preg_replace_callback("/\\b($all_lowercase)/",
            function ($matches) {
                return strtolower($matches[1]);
            },
            $str
        );

        // capitalize letter after certain name prefixes e.g 'Mc'
        $str = preg_replace_callback("/\\b($prefixes)(\\w)/",
            function ($matches) {
                return $matches[1] . strtoupper($matches[2]);
            },
            $str
        );

        // decapitalize certain word suffixes e.g. 's
        $str = preg_replace_callback("/(\\w)($suffixes)\\b/",
            function ($matches) {
                return $matches[1] . strtolower($matches[2]);
            },
            $str
        );

        return $str;
    }

    /**
     * Fill the full_name attribute from the first_name and last_name.
     *
     * Also attempt proper capitalisation.
     *
     * If this full name is already populated, then this does nothing.
     *
     * @return Contact provides a fluent interface.
     */
    public function fillFullName()
    {
        $cfn             = $this->capitaliseName($this->first_name);
        $cln             = $this->capitaliseName($this->last_name);
        $this->full_name = $cfn . ' ' . $cln;

        switch ($this->sort_order) {
            case 'nl':
                $ln_split = explode(' ', $cln);
                $end      = array_pop($ln_split);
                array_unshift($ln_split, $end);
                $sort_ln           = implode(' ', $ln_split);
                $this->sorted_name = $sort_ln . ', ' . $cfn;
                break;

            case 'cn':
                $this->sorted_name = $cfn . ' ' . $cln;
                break;

            case 'en':
                $this->sorted_name = $cln . ', ' . $cfn;
                break;

            default:
                $this->sorted_name = $cln . ', ' . $cfn;
                break;
        }

        return $this;
    }

    /**
     * Fill the company_name attribute from the company_id.
     *
     * If this company name is already populated, then this does nothing.
     *
     * @return Contact provides a fluent interface.
     */
    public function fillCompanyName()
    {
        if (! empty($this->company_name)) {
            return $this;
        }
        if (empty($this->company_id)) {
            return $this;
        }

        $company = Company::find($this->company_id);

        $this->company_name = $company->company_name;

        return $this;
    }

    /**
     * Get all of the contact types (categories).
     *
     * Returns a id => value array, e.g.
     * 31 => Customer
     * Suitable for use in pull-down lists, and for storage as category_id
     * in the foreign key field in the pivot tables.
     *
     * @return array
     */
    public static function getContactTypes()
    {
        $categories = Category::where('slug', '=', 'contact-types')
            ->first()
            ->getLeaves();

        /** @var array $result */
        $result = [];

        /** @var Category $category */
        foreach ($categories as $category) {
            $result[$category->id] = $category->name;
        }

        return $result;
    }

    /**
     * Get the name ordering rules.
     *
     * Returns a key => value array, e.g.
     * en => English Convention: Smith, John
     * Suitable for use in pull-down lists.
     *
     * @return array
     */
    public static function getNameOrderRules()
    {
        return Keyvalue::getKeyValuesByType('name-order');
    }

    /**
     * Get the current address for the contact.
     *
     * @param array $addressTypes
     * @return Address|null
     */
    public function getCurrentAddress($addressTypes = null)
    {
        // Provide some sensible default for addressTypes
        if (empty($addressTypes)) {
            $addressTypes = ['contact', 'billing', 'shipping', 'home', 'office'];
        }

        // Cycle through the address types until we get a hit
        foreach ($addressTypes as $addressType) {
            $address = $this->addresses()
                ->wherePivot('address_type', '=', $addressType)
                ->wherePivot('status', '=', 'current')
                ->first();
            if (! empty($address)) {
                return $address;
            }
        }

        // No hits, return null
        return null;
    }

    /**
     * Set the current address for the contact
     *
     * This sets the current address for the contact to be $address_id and expires
     * any previous address of that same type.
     *
     * @param        $address_id
     * @param string $addressType
     * @return $this
     */
    public function setCurrentAddress($address_id, $addressType='contact')
    {
        $current_address = $this->getCurrentAddress([$addressType]);

        // If this is already the current address, do nothing and return.
        if ($current_address->id == $address_id) {
            return $this;
        }

        // Set the old address to be previous and make this the current address
        $this->addresses()->updateExistingPivot($current_address->id, [
            'status'    => 'previous',
            'end_date'  => Carbon::yesterday(),
        ]);
        $this->addresses()->attach($address_id, [
            'address-type'  => $addressType,
            'status'        => 'current',
            'start_date'    => Carbon::today(),
        ]);

        return $this;
    }

    /**
     * Add a current address for the contact
     *
     * This sets the current address for the contact to be $address_id but does not
     * expire any previous address of that same type.
     *
     * @param        $address_id
     * @param string $addressType
     * @return $this
     */
    public function addCurrentAddress($address_id, $addressType='contact')
    {
        $current_address = $this->getCurrentAddress([$addressType]);

        // If this is already the current address, do nothing and return.
        if ($current_address->id == $address_id) {
            return $this;
        }

        // Make this the current address
        $this->addresses()->attach($address_id, [
            'address-type'  => $addressType,
            'status'        => 'current',
            'start_date'    => Carbon::today(),
        ]);

        return $this;
    }
}
