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
        'id' => [
            'title' => 'ID',
        ],
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
            'type' => 'text',
        ],
        'contact_name' => [
            'title' => 'Contact Name',
            'type' => 'text',
        ],
        'contact_phone' => [
            'title' => 'Contact Phone',
            'type' => 'text',
        ],
        'phone' => [
            'title' => 'Company Phone',
            'type' => 'text',
        ],
        'mobile' => [
            'title' => 'Company Mobile Phone',
            'type' => 'text',
        ],
        'fax' => [
            'title' => 'Company Fax',
            'type' => 'text',
        ],
        'website' => [
            'title' => 'Company Website',
            'type' => 'text',
        ],
        'accounts_email' => [
            'title' => 'Accounts Email',
            'type' => 'text',
        ],
        'invoice_email' => [
            'title' => 'Invoice Email',
            'type' => 'text',
        ],
        'established' => [
            'title' => 'Established',
            'type' => 'text',
        ],
        'size' => [
            'title' => 'Size',
            'type' => 'text',
        ],
        'facebook' => [
            'title' => 'Facebook',
            'type' => 'text',
        ],
        'instagram' => [
            'title' => 'Instagram',
            'type' => 'text',
        ],
        'linkedin' => [
            'title' => 'Linkedin',
            'type' => 'text',
        ],
        'logo' => [
            'title' => 'Logo',
            'type' => 'image',
            'naming' => 'random',
            'length' => 20,
            'location' => 'uploads/companies/'
        ],
        'current_project_list' => [
            'title' => 'Current Project List',
            'type' => 'arraytext',
        ],
        'past_project_list' => [
            'title' => 'Past Project List',
            'type' => 'arraytext',
        ],
        'category' => [
            'title' => 'Category',
            'type' => 'relationship',
            'name_field' => 'name',
            'name_sort_order' => 'name',
            'options_filter' => '\Delatbabel\Contacts\Helpers\CompanyHelper::getCompanyTypes'
        ],
        'notes' => [
            'title' => 'Notes',
            'type' => 'textarea',
        ],
        'extended_data' => [
            'title' => 'Extended Data',
            'type' => 'json',
            'height' => '400',
        ],
    ],
    'form_width' => 400,
    'controller_handler' => \Delatbabel\Contacts\Http\Controllers\CompanyController::class,
];
