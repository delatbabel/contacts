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

/**
 * Contact Model
 *
 * Contains contacts which may map to companies.
 */
class Contact extends Model
{
    use SoftDeletes, Fluents;

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
     * Get all of the contact types (categories).
     *
     * Returns a id => value array, e.g.
     * 31 => Customer
     * Suitable for use in pull-down lists, and for storage as category_id
     * in the foreign key field in the pivot tables.
     *
     * @return array
     */
    public static function getCategories()
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
}
