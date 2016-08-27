<?php
/**
 * Company Model
 *
 * @author Del
 */

namespace Delatbabel\Contacts\Models;

use Delatbabel\Applog\Models\Auditable;
use Delatbabel\Fluents\Fluents;
use Delatbabel\NestedCategories\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Company Model
 *
 * Contains companies, which may have many contacts and addresses.
 */
class Company extends Model
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('Delatbabel\NestedCategories\Models\Category');
    }

    /**
     * 1:Many relationship with Contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function contacts()
    {
        return $this->hasMany('Delatbabel\Contacts\Models\Contact');
    }

    /**
     * Get all of the company types (categories).
     *
     * Returns a id => value array, e.g.
     * 31 => Customer
     * Suitable for use in pull-down lists, and for storage as category_id
     * in the foreign key field in the pivot tables.
     *
     * @return array
     */
    public static function getCompanyTypes()
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
