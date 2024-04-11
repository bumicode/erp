<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Customer
    |--------------------------------------------------------------------------
    |
    | The following language lines are used for various purposes related to customers.
    | You are free to modify these language lines according to your application's
    | requirements.
    |
    */

    'customer' => 'Customer',
    'customers' => 'Customers',

    'tab' => [
        'details' => 'Details',
        'contact' => 'Contact',
        'address' => 'Address',
        'tax' => 'Tax',
        'accounting' => 'Accounting',
        'sales_team' => 'Sales Team',
        'settings' => 'Settings',
    ],

    'field' => [
        'detail' => [
            'salutation' => 'Salutation',
            'territory' => 'Territory',
            'name' => 'Customer Name',
            'gender' => 'Gender',
            'customer_type' => 'Customer Type',
            'customer_group' => 'Customer Group',
            'from_lead' => 'From Lead',
            'from_opportunity' => 'From Opportunity',
            'customer_manager' => 'Customer Manager',

            'internal_customer' => [
                'title' => 'Internal Customer',
                'description' => 'Marks that the customer is an internal customer',
                'action' => 'Mark as Internal Customer',
            ],

            'more_information' => [
                'title' => 'More Information',
                'field' => [
                    'market_segment' => 'Market Segment',
                    'industry' => 'Industry',
                    'website' => 'Website',
                    'content' => 'Content',
                ],
            ],
        ],
        'contact_address' => [
            'title' => 'Primary Address and Contact',
            'description' => 'Select, to make the customer searchable with these fields',
            'field' => [
                'address' => 'Primary Address',
                'address_hint' => 'Reselect, if the chosen address is edited after save',
                'contact' => 'Primary Contact',
                'contact_hint' => 'Reselect, if the chosen contact is edited after save',
            ],
        ],
        'tax' => [
            'title' => 'Tax',
            'field' => [
                'tax_number' => 'Tax Number',
                'tax_category' => 'Tax Category',
                'tax_withholding_category' => 'Tax Withholding Category',
            ],
        ],
        'accounting' => [
            'title' => 'Credit Limit and Payment Terms',
            'field' => [
                'payment_term_template' => 'Default Payment Terms Template',
            ],
        ],
    ],

    'created_success' => 'Customer created successfully!',
    'updated_success' => 'Customer updated successfully!',
    'deleted_success' => 'Customer deleted successfully!',

];
