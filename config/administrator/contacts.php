<?php

/**
 * Contacts model config
 *
 * @link https://github.com/ddpro/admin/blob/master/docs/model-configuration.md
 */

return array(

    'title' => 'Contacts',

    'single' => 'contact',

    'model' => '\Delatbabel\Contacts\Models\Contact',

    /**
     * The display columns
     */
    'columns' => array(
        'id',
        'sorted_name' => array(
            'title' => 'Name',
        ),
    ),

    /**
     * The filter set
     */
    'filters' => array(
        'sorted_name' => array(
            'title' => 'Name',
        ),
    ),

    /**
     * The editable fields
     */
    'edit_fields' => array(
        'first_name' => array(
            'title' => 'First Name',
            'type' => 'text',
        ),
        'last_name' => array(
            'title' => 'Last Name',
            'type' => 'text',
        ),
        'sort_order' => array(
            'title' => 'Sort Order',
            'type' => 'enum',
            'options' => array(
                'en'    => 'English: Lastname, Firstname',
                'cn'    => 'Asian: Firstname Lastname',
                'nl'    => 'NL/DE/ZA: Lastname (van/von/der), Firstname')
        ),
        'company' => array(
            'title' => 'Company',
            'type' => 'relationship',
            'name_field' => 'name',
        ),
        'position' => array(
            'title' => 'Position',
            'type' => 'text',
        ),
        'email' => array(
            'title' => 'Email',
            'type' => 'text',
        ),
        'phone' => array(
            'title' => 'Phone',
            'type' => 'text',
        ),
        'mobile' => array(
            'title' => 'Mobile Phone',
            'type' => 'text',
        ),
        'fax' => array(
            'title' => 'Fax',
            'type' => 'text',
        ),
        'timezone' => array(
            'title' => 'Time Zone',
            'type' => 'text',
        ),
        'categories' => array(
            'title' => 'Categories',
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
