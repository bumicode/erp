<?php

return [

    'sales_order' => 'Sales Order',
    'sales_orders' => 'Sales Orders',

    'tab' => [
        'details' => [
            'title' => 'Detail',
            'description' => 'Sales order details',
            'detail' => [
                'title' => 'Detail',
                'fields' => [
                    'series' => 'Series',
                    'posting_date' => 'Posting Date',
                    'delivery_date' => 'Delivery Date',
                    'customer' => 'Customer',
                    'order_type' => 'Order Type',
                    'customer_purchase_order' => 'Customer Purchase Order',
                ],
            ],
            'account' => [
                'title' => 'Account Dimensions',
                'fields' => [
                    'cost_center' => 'Cost Center',
                    'project' => 'Project',
                    'source' => 'Source',
                    'campaign' => 'Campaign',
                ],
            ],
            'currency' => [
                'title' => 'Currency and Price List',
                'fields' => [
                    'currency' => 'Currency',
                    'price_list' => 'Price List',
                    'ignore_pricing_rule' => 'Ignore Pricing Rule',
                ],
            ],
            'items' => [
                'title' => 'Items',
                'fields' => [
                    'scan_barcode' => 'Scan Barcode',
                    'set_source_warehouse' => 'Set Source Warehouse',
                    'item' => 'Item',
                    'quantity' => 'Quantity',
                    'basic_rate' => 'Basic Rate',
                    'total_rate' => 'Total Rate',
                    'total_net_weight' => 'Total Net Weight',
                    'total_qty' => 'Total Quantity',
                    'total_amount' => 'Total Amount',
                ],
            ],
            'taxes' => [
                'title' => 'Taxes',
                'fields' => [
                    'tax_category' => 'Tax Category',
                    'shipping_rule' => 'Shipping Rule',
                    'incoterm' => 'International Commercial Terms',
                    'sales_taxes_and_charges_template' => 'Sales Taxes and Charges Template',
                    'sales_taxes_and_charges' => 'Sales Taxes and Charges',
                    'type' => 'Type',
                    'account_head' => 'Account Head',
                    'rate' => 'Rate',
                    'amount' => 'Amount',
                    'total' => 'Total',
                    'total_taxes_and_charges' => 'Total Taxes and Charges',
                ],
            ],
            'total' => [
                'title' => 'Total',
                'fields' => [
                    'grand_total' => 'Grand Total',
                    'rounding_adjustment' => 'Rounding Adjustment',
                    'rounded_total' => 'Rounded Total',
                    'advance_paid' => 'Advance Paid',
                ],
            ],
            'discount' => [
                'title' => 'Additional Discount',
                'fields' => [
                    'apply_discount_on' => 'Apply Additional Account On',
                    'coupon_code' => 'Coupon Code',
                    'discount_percentage' => 'Additional Discount Percentage',
                    'discount_amount' => 'Additional Discount Amount',
                ],
            ],
        ],
    ],
    'options' => [
        'order_type' => [
            'sales' => 'Sales',
            'maintenance' => 'Maintenance',
            'shopping_chart' => 'Shopping Chart',
        ],
    ],
];
