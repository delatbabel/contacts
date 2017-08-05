<?php

namespace Delatbabel\Contacts\Http\Requests;

use App\Http\Requests\Request;
use Delatbabel\Keylists\Models\Keytype;

/**
 * Validate Request for Address form - Create/Update
 *
 * Class AddressFormRequest
 * @package Delatbabel\Contacts\Http\Requests
 */
class AddressFormRequest extends Request
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
        $countryID = Keytype::where('name', 'countries')->firstOrFail()->id;

        return [
            'street'       => 'required',
            'city'         => 'required_without:suburb',
            'suburb'       => 'required_without:city',
            'postal_code'  => 'numeric',
            'country_code' => "required|exists:keyvalues,keyvalue,keytype_id,{$countryID}",
        ];
    }

    /**
     * Custom nice name
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'country_code' => 'country',
        ];
    }
}
