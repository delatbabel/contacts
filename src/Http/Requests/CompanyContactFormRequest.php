<?php

namespace Delatbabel\Contacts\Http\Requests;

use App\Http\Requests\Request;

/**
 * Validate Request for Contact form in Company's Contact tab
 *
 * Class CompanyContactFormRequest
 */
class CompanyContactFormRequest extends Request
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
            'first_name'    => 'required',
            'last_name'     => 'required',
            'email'         => 'required',
            'category_id'   => 'required',
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
            'category_id'   => 'type',
        ];
    }
}
