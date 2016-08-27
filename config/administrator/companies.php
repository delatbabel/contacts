<?php

/**
 * Companies model config
 *
 * @link https://github.com/ddpro/admin/blob/master/docs/model-configuration.md
 */

return [

    'title' => 'Companies',

    'single' => 'company',

    'model' => '\Delatbabel\Contacts\Models\Company',

    /**
     * The display columns
     */
    'columns' => [
        'id',
        'company_name' => [
            'title' => 'Company Name',
        ],
        'contact_name' => [
            'title' => 'Contact Name',
        ],
    ],

    /**
     * The filter set
     */
    'filters' => [
        'company_name' => [
            'title' => 'Company Name',
        ],
    ],

    /**
     * The editable fields
     */
    'edit_fields' => [
        'company_name' => [
            'title' => 'Company Name',
            'type'  => 'text',
        ],
        'contact_name' => [
            'title' => 'Contact Name',
            'type'  => 'text',
        ],
        'contact_phone' => [
            'title' => 'Contact Phone',
            'type'  => 'text',
        ],
        'phone' => [
            'title' => 'Company Phone',
            'type'  => 'text',
        ],
        'mobile' => [
            'title' => 'Company Mobile Phone',
            'type'  => 'text',
        ],
        'fax' => [
            'title' => 'Company Fax',
            'type'  => 'text',
        ],
        'website' => [
            'title' => 'Company Website',
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
