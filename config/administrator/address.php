<?php
/**
 * Address model config
 *
 * @link https://github.com/ddpro/admin/blob/master/docs/model-configuration.md
 */
return [
    'title'              => 'Addresses',
    'single'             => 'address',
    'model'              => \Delatbabel\Contacts\Models\Address::class,
    /**
     * The display columns
     */
    'columns'            => [
        'id'   => [
            'title' => 'ID',
        ],
        'street'       => [
            'title' => 'Street',
        ],
        'city'         => [
            'title' => 'City',
        ],
        'country_name' => [
            'title' => 'country_name',
        ],
    ],
    /**
     * The editable fields
     */
    'form_request'       => \Delatbabel\Contacts\Http\Requests\AddressFormRequest::class,
    'edit_fields'        => [
        'street'        => [
            'title' => 'Street  <span class="text-danger">*</span>',
            'type'  => 'text',
        ],
        'suburb'        => [
            'title' => 'Suburb/Location/District',
            'type'  => 'text',
        ],
        'city'          => [
            'title' => 'City',
            'type'  => 'text',
        ],
        'state_name'    => [
            'title' => 'State Name',
            'type'  => 'text',
        ],
        'postal_code'   => [
            'title' => 'Postal code',
            'type'  => 'text',
        ],
        'country_code'  => [
            'title' => 'Country <span class="text-danger">*</span>',
        ],
        'contact_name'  => [
            'title' => 'Contact Name',
            'type'  => 'text',
        ],
        'contact_phone' => [
            'title' => 'Contact Phone',
            'type'  => 'text',
        ],
    ],
    'controller_handler' => \Delatbabel\Contacts\Http\Controllers\AddressController::class,
];
