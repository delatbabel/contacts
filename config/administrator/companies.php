<?php

/**
 * Companies model config
 *
 * @link https://github.com/ddpro/admin/blob/master/docs/model-configuration.md
 */

return array(

    'title' => 'Companies',

    'single' => 'company',

    'model' => '\Delatbabel\Contacts\Models\Company',

    /**
     * The display columns
     */
    'columns' => array(
        'id',
        'company_name' => array(
            'title' => 'Company Name',
        ),
        'contact_name' => array(
            'title' => 'Contact Name',
        ),
    ),

    /**
     * The filter set
     */
    'filters' => array(
        'company_name' => array(
            'title' => 'Company Name',
        ),
    ),

    /**
     * The editable fields
     */
    'edit_fields' => array(
        'company_name' => array(
            'title' => 'Company Name',
            'type' => 'text',
        ),
        'contact_name' => array(
            'title' => 'Contact Name',
            'type' => 'text',
        ),
        'contact_phone' => array(
            'title' => 'Contact Phone',
            'type' => 'text',
        ),
        'phone' => array(
            'title' => 'Company Phone',
            'type' => 'text',
        ),
        'mobile' => array(
            'title' => 'Company Mobile Phone',
            'type' => 'text',
        ),
        'fax' => array(
            'title' => 'Company Fax',
            'type' => 'text',
        ),
        'website' => array(
            'title' => 'Company Website',
            'type' => 'text',
        ),
        'category' => array(
            'title' => 'Category',
            'type' => 'relationship',
            'name_field' => 'name',
            'name_sort_order' => 'name',
        ),
        'notes' => array(
            'title' => 'Notes',
            'type' => 'textarea',
        ),
        'extended_data' => array(
            'title' => 'Extended Data',
            'type' => 'textarea',
        ),
    ),

    'form_width' => 400,
);
