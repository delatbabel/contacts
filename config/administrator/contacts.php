<?php

/**
 * Contacts model config
 *
 * @link https://github.com/ddpro/admin/blob/master/docs/model-configuration.md
 */

return [

    'title' => 'Contacts',

    'single' => 'contact',

    'model' => '\Delatbabel\Contacts\Models\Contact',

    'server_side'   => true,

    /**
     * The display columns
     */
    'columns' => [
        'id',
        'sorted_name' => [
            'title'     => 'Name',
        ],
        'company' => [
            'title'     => 'Company',
            'type'      => 'relationship',
            'select'    => "(:table).company_name",
        ],
        'category' => [
            'title'     => 'Category',
            'type'      => 'relationship',
            'select'    => '(:table).name',
        ],
    ],

    /**
     * The filter set
     */
    'filters' => [
        'sorted_name' => [
            'title'         => 'Name',
        ],
        'company' => [
            'type'          => 'relationship',
            'title'         => 'Company',
            'name_field'    => 'company_name',
        ],
        'category' => [
            'title'         => 'Category',
            'type'          => 'relationship',
            'name_field'    => 'name',
        ],
    ],

    /**
     * The editable fields
     */
    'edit_fields' => [
        'first_name' => [
            'title' => 'First Name',
            'type'  => 'text',
        ],
        'last_name' => [
            'title' => 'Last Name',
            'type'  => 'text',
        ],
        'sort_order' => [
            'title'   => 'Sort Order',
            'type'    => 'enum',
            'options' => [
                'en'    => 'English: Lastname, Firstname',
                'cn'    => 'Asian: Firstname Lastname',
                'nl'    => 'NL/DE/ZA: Lastname (van/von/der), Firstname']
        ],
        'company' => [
            'title'              => 'Company',
            'type'               => 'relationship',
            'name_field'         => 'company_name',
            'options_sort_field' => 'company_name',
        ],
        'position' => [
            'title' => 'Position',
            'type'  => 'text',
        ],
        'email' => [
            'title' => 'Email',
            'type'  => 'text',
        ],
        'phone' => [
            'title' => 'Phone',
            'type'  => 'text',
        ],
        'mobile' => [
            'title' => 'Mobile Phone',
            'type'  => 'text',
        ],
        'fax' => [
            'title' => 'Fax',
            'type'  => 'text',
        ],
        'timezone' => [
            'title' => 'Time Zone',
            'type'  => 'text',
        ],
        'category' => [
            'title'           => 'Category',
            'type'            => 'relationship',
            'name_field'      => 'name',
            'name_sort_order' => 'name',
        ],
        'notes' => [
            'title' => 'Notes',
            'type'  => 'textarea',
        ],
        'extended_data' => [
            'title' => 'Extended Data',
            'type'  => 'textarea',
        ],
    ],

    'form_width' => 400,
];
