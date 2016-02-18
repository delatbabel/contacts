<?php
/**
 * Contact Model
 *
 * @author Del
 */

namespace Delatbabel\Contacts\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * Contact Model
 *
 * Contains contacts which may map to companies.
 */
class Contact extends Model
{
    use SoftDeletes;

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
}
