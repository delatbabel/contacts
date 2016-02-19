<?php
/**
 * Contact Model
 *
 * @author Del
 */

namespace Delatbabel\Contacts\Models;

use Delatbabel\Fluents\Fluents;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Delatbabel\Applog\Models\Auditable;
use Delatbabel\Keylists\Models\Keyvalue;
use Delatbabel\NestedCategories\Models\Category;

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
    public function categories()
    {
        return $this->belongsToMany('Delatbabel\NestedCategories\Models\Category');
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
        static::creating(function ($model) {
            return $model->fillFullName()->fillCompanyName();
        });
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
        $prefixes = "Mc|Mac";
        $suffixes = "'S";

        // captialize all first letters
        $str = preg_replace_callback('/\\b(\\w)/',
            function ($matches) {return strtoupper($matches[1]); },
            strtolower(trim($str))
        );

        // capitalize acronymns and initialisms e.g. PO
        $str = preg_replace_callback("/\\b($all_uppercase)/",
            function ($matches) {return strtoupper($matches[1]); },
            $str
        );

        // decapitalize short words e.g. van der
        $str = preg_replace_callback("/\\b($all_lowercase)/",
            function ($matches) {return strtolower($matches[1]); },
            $str
        );

        // capitalize letter after certain name prefixes e.g 'Mc'
        $str = preg_replace_callback("/\\b($prefixes)(\\w)/",
            function ($matches) {return $matches[1] . strtoupper($matches[2]); },
            $str
        );

        // decapitalize certain word suffixes e.g. 's
        $str = preg_replace_callback("/(\\w)($suffixes)\\b/",
            function ($matches) {return $matches[1] . strtolower($matches[2]); },
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
        if (! empty($this->full_name)) {
            return $this;
        }

        $cfn = $this->capitaliseName($this->first_name);
        $cln = $this->capitaliseName($this->last_name);
        $this->full_name = $cfn . ' ' . $cln;

        switch ($this->sort_order) {
            case 'nl':
                $ln_split = explode(' ', $cln);
                $end = array_pop($ln_split);
                array_unshift($ln_split, $end);
                $sort_ln = implode(' ', $ln_split);
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
            ->leaves();

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
}
