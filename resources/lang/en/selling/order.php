<?php

return [

    'sales_order' => 'Sales Order',
    'sales_orders' => 'Sales Orders',

    'tab' => [
        'details' => [
            'title' => 'Detail',
            'detail' => [
                'title' => 'Detail',
                'description' => 'This section contains general information about the sales order, such as order number, date, customer details, and shipping address.',
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
                'description' => 'Account Dimensions refer to specific accounting categories or segments used for tracking and analyzing sales transactions, such as department, project, or cost center.',
                'fields' => [
                    'cost_center' => 'Cost Center',
                    'project' => 'Project',
                    'source' => 'Source',
                    'campaign' => 'Campaign',
                ],
            ],
            'currency' => [
                'title' => 'Currency and Price List',
                'description' => 'This section specifies the currency in which the sales order is conducted and the applicable price list for the items.',
                'fields' => [
                    'currency' => 'Currency',
                    'price_list' => 'Price List',
                    'ignore_pricing_rule' => 'Ignore Pricing Rule',
                ],
            ],
            'items' => [
                'title' => 'Items',
                'description' => ' Items section lists all the products or services included in the sales order, along with their quantities, prices, and total amounts.',
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
                'description' => 'This part displays any applicable taxes or tax rates that are applied to the sales order items.',
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
                'description' => 'This section displays the total amount of the sales order, including any discounts, taxes, and rounding adjustments.',
                'fields' => [
                    'grand_total' => 'Grand Total',
                    'rounding_adjustment' => 'Rounding Adjustment',
                    'rounded_total' => 'Rounded Total',
                    'advance_paid' => 'Advance Paid',
                ],
            ],
            'discount' => [
                'title' => 'Additional Discount',
                'description' => 'This section allows you to apply additional discounts to the sales order.',
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
