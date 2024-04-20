<?php

return [

    'sales_order' => 'Sales Order',
    'sales_orders' => 'Sales Orders',

    'tab' => [
        'details' => [
            'title' => 'Detail',
            'description' => 'Detail Pesanan penjualan',
            'detail' => [
                'title' => 'Detail',
                'fields' => [
                    'series' => 'Seri',
                    'posting_date' => 'Tanggal Posting',
                    'delivery_date' => 'Tanggal Pengiriman',
                    'customer' => 'Pelanggan',
                    'order_type' => 'Tipe Pesanan',
                    'customer_purchase_order' => 'Pesanan Pembelian Pelanggan',
                ],
            ],
            'account' => [
                'title' => 'Account Dimensions',
                'fields' => [
                    'cost_center' => 'Pusat Biaya',
                    'project' => 'Proyek',
                    'source' => 'Sumber',
                    'campaign' => 'Kampanye',
                ],
            ],
            'currency' => [
                'title' => 'Mata Uang dan Daftar Harga',
                'fields' => [
                    'currency' => 'Mata Uang',
                    'price_list' => 'Daftar harga',
                    'ignore_pricing_rule' => 'Abaikan Aturan Penetapan Harga',
                ],
            ],
            'items' => [
                'title' => 'Item',
                'fields' => [
                    'scan_barcode' => 'Scan Barcode',
                    'set_source_warehouse' => 'Set Sumber Gudang',
                    'item' => 'Item',
                    'quantity' => 'Kuantitas',
                    'basic_rate' => 'Harga Dasar',
                    'total_rate' => 'Harga Total',
                    'total_net_weight' => 'Berat Total',
                    'total_qty' => 'Total Kuantitas',
                    'total_amount' => 'Jumlah Total',
                ],
            ],
            'taxes' => [
                'title' => 'Pajak',
                'fields' => [
                    'tax_category' => 'Kategori Pajak',
                    'shipping_rule' => 'Aturan Pengiriman',
                    'incoterm' => 'International Commercial Terms',
                    'sales_taxes_and_charges_template' => 'Template Pajak dan Biaya Penjualan',
                    'sales_taxes_and_charges' => 'Pajak dan Biaya Penjualan',
                    'type' => 'Tipe',
                    'account_head' => 'Kepala Akun',
                    'rate' => 'Tarif',
                    'amount' => 'Jumlah',
                    'total' => 'Total',
                    'total_taxes_and_charges' => 'Total Pajak dan Biaya',
                ],
            ],
            'total' => [
                'title' => 'Total',
                'fields' => [
                    'grand_total' => 'Total Keseluruhan',
                    'rounding_adjustment' => 'Penyesuaian Pembulatan',
                    'rounded_total' => 'Total Dibulatkan',
                    'advance_paid' => 'Pembayaran Muka',
                ],
            ],
            'discount' => [
                'title' => 'Diskon Tambahan',
                'fields' => [
                    'apply_discount_on' => 'Terapkan Tambahan Akun Pada',
                    'coupon_code' => 'Kode Kupon',
                    'discount_percentage' => 'Persentase Diskon Tambahan',
                    'discount_amount' => 'Jumlah Diskon Tambahan',
                ],
            ],
        ],
    ],
    'options' => [
        'order_type' => [
            'sales' => 'Penjualan',
            'maintenance' => 'Pemeliharaan',
            'shopping_chart' => 'Grafik Belanja',
        ],
    ],
];
