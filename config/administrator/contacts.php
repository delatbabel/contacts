<?php
/**
 * Contacts model config
 *
 * @link https://github.com/ddpro/admin/blob/master/docs/model-configuration.md
 */
return [
    'title'              => 'Contacts',
    'single'             => 'contact',
    'model'              => \Delatbabel\Contacts\Models\Contact::class,
    'server_side'        => true,
    /**
     * The display columns
     */
    'columns'            => [
        'id'   => [
            'title' => 'ID',
        ],
        'sorted_name' => [
            'title' => 'Name',
        ],
        'company'     => [
            'title'        => 'Company',
            'type'         => 'relationship',
            'relationship' => 'company',
            'select'       => "(:table).company_name",
        ],
        'category'    => [
            'title'        => 'Category',
            'type'         => 'relationship',
            'relationship' => 'category',
            'select'       => '(:table).name',
        ],
    ],
    /**
     * The filter set
     */
    'filters'            => [
        'sorted_name' => [
            'title' => 'Name',
        ],
        'company'     => [
            'type'       => 'relationship',
            'title'      => 'Company',
            'name_field' => 'company_name',
        ],
        'category'    => [
            'title'      => 'Category',
            'type'       => 'relationship',
            'name_field' => 'name',
        ],
    ],
    /**
     * The editable fields
     */
    'form_request'       => \App\Http\Requests\ContactFormRequest::class,
    'edit_fields'        => [
        'first_name'    => [
            'title' => 'First Name <span class="text-danger">*</span>',
            'type'  => 'text',
        ],
        'last_name'     => [
            'title' => 'Last Name <span class="text-danger">*</span>',
            'type'  => 'text',
        ],
        'company'       => [
            'title'              => 'Company',
            'type'               => 'relationship',
            'name_field'         => 'company_name',
            'options_sort_field' => 'company_name',
        ],
        'position'      => [
            'title' => 'Position',
            'type'  => 'text',
        ],
        'email'         => [
            'title' => 'Email',
            'type'  => 'text',
        ],
        'phone'         => [
            'title' => 'Phone',
            'type'  => 'text',
        ],
        'mobile'        => [
            'title' => 'Mobile Phone',
            'type'  => 'text',
        ],
        'fax'           => [
            'title' => 'Fax',
            'type'  => 'text',
        ],
        'timezone'      => [
            'title' => 'Time Zone',
            'type'  => 'text',
        ],
        'category'      => [
            'title'           => 'Category',
            'type'            => 'relationship',
            'name_field'      => 'name',
            'name_sort_order' => 'name',
        ],
        'notes'         => [
            'title' => 'Notes',
            'type'  => 'textarea',
        ],
        'extended_data' => [
            'title'  => 'Extended Data',
            'type'   => 'json',
            'height' => '400',
        ],
    ],
    'controller_handler' => \App\Http\Controllers\ContactController::class,
];
