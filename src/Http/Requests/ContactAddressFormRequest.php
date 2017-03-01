<?php

namespace Delatbabel\Contacts\Http\Requests;

use Delatbabel\Keylists\Models\Keytype;
use App\Http\Requests\Request;

/**
 * Validate address form in contact page
 *
 * Class ContactAddressFormRequest
 * @package Delatbabel\Contacts\Http\Requests
 */
class ContactAddressFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $addressRules = new AddressFormRequest();
        $typeID       = Keytype::where('name', 'address-types')->firstOrFail()->id;
        $statusID     = Keytype::where('name', 'address-statuses')->firstOrFail()->id;

        return array_merge($addressRules->rules(), [
            'address_type' => "required|exists:keyvalues,keyvalue,keytype_id,{$typeID}",
            'status'       => "required|exists:keyvalues,keyvalue,keytype_id,{$statusID}",
            'start_date'   => 'date_format:Y-m-d',
            'end_date'     => 'date_format:Y-m-d|after:start_date',
        ]);
    }
}
