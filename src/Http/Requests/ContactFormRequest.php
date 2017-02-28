<?php

namespace Delatbabel\Contacts\Http\Requests;

use App\Http\Requests\Request;

/**
 * Validate Request for Contact form
 *
 * Class ContactFormRequest
 * @package Delatbabel\Contacts\Http\Requests
 */
class ContactFormRequest extends Request
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
        return [
            'first_name' => 'required',
            'last_name'  => 'required',
        ];
    }
}
