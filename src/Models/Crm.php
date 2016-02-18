<?php
/**
 * Crm Model
 *
 * @author Del
 */

namespace Delatbabel\Contacts\Models;

use Delatbabel\Fluents\Fluents;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * Crm Model
 *
 * Contains data used by CRM synchronisation.
 */
class Crm extends Model
{
    use SoftDeletes, Fluents;

    /** @var array */
    protected $guarded = ['id'];

    protected $casts = [
        'parameters'        => 'array',
        'extended_data'     => 'array',
    ];
}
