<?php

return [

    'stock_entry' => 'Stock Entry',
    'stock_entries' => 'Stock Entries',

    'tab' => [
        'details' => [
            'title' => 'Details',
            'description' => 'Stock Entry Details',
            'fields' => [
                'series' => 'Series',
                'posting_at' => 'Posting At',
                'stock_entry_type' => 'Stock Entry Type',
            ],
            'action' => [
                'is_inspection_required' => 'Is Inspection Required',
            ],
        ],

        'items' => [
            'title' => 'Items',
            'description' => 'Stock Entry Items',
            'fields' => [
                'source_warehouse' => 'Source Warehouse',
                'target_warehouse' => 'Target Warehouse',
                'item' => 'Item',
                'quantity' => 'Quantity',
                'basic_rate' => 'Basic Rate',
                'total' => [
                    'title' => 'Total',
                    'outgoing' => 'Total Outgoing Value (Consumption)',
                    'incoming' => 'Total Incoming Value (Receipt)',
                    'net' => 'Total Value Difference (Incoming - Outgoing',
                ],
            ],
        ],

        'additional_cost' => [
            'title' => 'Additional Cost',
            'description' => 'Stock Entry Additional Cost',
            'fields' => [
                'expense_account' => 'Expense Account',
                'amount' => 'Amount',
                'description' => 'Description',
                'total' => 'Total Additional Cost',
            ],
        ],

        'supplier_info' => [
            'title' => 'Supplier Info',
            'description' => 'Stock Entry Supplier Info',
            'fields' => [],
        ],

        'accounting_dimension' => [
            'title' => 'Accounting Dimension',
            'description' => 'Stock Entry Accounting Dimension',
            'fields' => [],
        ],

        'other_info' => [
            'title' => 'Other Info',
            'description' => 'Stock Entry Other Info',
            'fields' => [],
        ],
    ],
];
