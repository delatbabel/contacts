<?php
/**
 * Contacts model config
 *
 * @link https://github.com/ddpro/admin/blob/master/docs/model-configuration.md
 */
return [
    'title'              => 'Contacts',
    'single'             => 'Contact',
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
            'title'        => 'Type',
            'type'         => 'relationship',
            'relationship' => 'category',
            'select'       => '(:table).name',
        ],
        'display_last_login' => [
            'title' => 'Last Login'
        ]
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
            'title'                 => 'Type',
            'type'                  => 'relationship',
            'name_field'            => 'name',
            'options_sort_field'    => 'name',
            'options_filter'        => '\Delatbabel\NestedCategories\Helpers\CategoryHelper::filterCategoriesByParentSlug',
            'options_filter_params' => ['contact-types']
        ],
    ],
    /**
     * The editable fields
     */
    'form_request'       => App\Modules\Contacts\Requests\ContactFormRequest::class,
    'edit_fields'        => [
        'first_name'    => [
            'title' => 'First Name <span class="text-danger">*</span>',
            'type'  => 'text',
        ],
        'last_name'     => [
            'title' => 'Last Name <span class="text-danger">*</span>',
            'type'  => 'text',
        ],
        'email'         => [
            'title' => 'Email <span class="text-danger">*</span>',
            'type'  => 'text',
        ],
        'company'       => [
            'title'              => 'Company <span class="text-danger">*</span>',
            'type'               => 'relationship',
            'name_field'         => 'company_name',
            'options_sort_field' => 'company_name',
        ],
        'category'      => [
            'title'           => 'Type <span class="text-danger">*</span>',
            'type'            => 'relationship',
            'name_field'      => 'name',
            'name_sort_order' => 'name',
            'options_filter'  => '\Delatbabel\Contacts\Helpers\ContactHelper::getContactTypes'
        ],
        'position'      => [
            'title' => 'Position',
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
    'controller_handler' => \Delatbabel\Contacts\Http\Controllers\ContactController::class,
];
