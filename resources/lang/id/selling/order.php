<?php

return [

    'sales_order' => 'Pesanan Penjualan',
    'sales_orders' => 'Pesanan Penjualan',

    'tab' => [
        'details' => [
            'title' => 'Detail',
            'detail' => [
                'title' => 'Detail',
                'description' => 'Bagian ini berisi informasi umum tentang pesanan penjualan, seperti nomor pesanan, tanggal, detail pelanggan, dan alamat pengiriman.',
                'fields' => [
                    'series' => 'Seri',
                    'posting_date' => 'Tanggal Posting',
                    'delivery_date' => 'Tanggal Pengiriman',
                    'customer' => 'Pelanggan',
                    'order_type' => 'Jenis Pesanan',
                    'customer_purchase_order' => 'Pesanan Pembelian Pelanggan',
                ],
            ],
            'account' => [
                'title' => 'Dimensi Akun',
                'description' => 'Dimensi Akun merujuk pada kategori atau segmen akuntansi tertentu yang digunakan untuk melacak dan menganalisis transaksi penjualan, seperti departemen, proyek, atau pusat biaya.',
                'fields' => [
                    'cost_center' => 'Pusat Biaya',
                    'project' => 'Proyek',
                    'source' => 'Sumber',
                    'campaign' => 'Kampanye',
                ],
            ],
            'currency' => [
                'title' => 'Mata Uang dan Daftar Harga',
                'description' => 'Bagian ini menentukan mata uang yang digunakan dalam pesanan penjualan dan daftar harga yang berlaku untuk barang.',
                'fields' => [
                    'currency' => 'Mata Uang',
                    'price_list' => 'Daftar Harga',
                    'ignore_pricing_rule' => 'Abaikan Aturan Penentuan Harga',
                ],
            ],
            'items' => [
                'title' => 'Barang',
                'description' => 'Bagian Barang mencantumkan semua produk atau layanan yang termasuk dalam pesanan penjualan, beserta jumlahnya, harga, dan jumlah total.',
                'fields' => [
                    'scan_barcode' => 'Pindai Kode Batang',
                    'set_source_warehouse' => 'Atur Gudang Sumber',
                    'item' => 'Barang',
                    'quantity' => 'Kuantitas',
                    'basic_rate' => 'Tarif Dasar',
                    'total_rate' => 'Tarif Total',
                    'total_net_weight' => 'Berat Bersih Total',
                    'total_qty' => 'Jumlah Total',
                    'total_amount' => 'Jumlah Total',
                ],
            ],
            'taxes' => [
                'title' => 'Pajak',
                'description' => 'Bagian ini menampilkan pajak atau tarif pajak yang berlaku yang diterapkan pada barang pesanan penjualan.',
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
                'description' => 'Bagian ini menampilkan jumlah total pesanan penjualan, termasuk diskon, pajak, dan penyesuaian pembulatan.',
                'fields' => [
                    'grand_total' => 'Total Keseluruhan',
                    'rounding_adjustment' => 'Penyesuaian Pembulatan',
                    'rounded_total' => 'Total Pembulatan',
                    'advance_paid' => 'Pembayaran Muka',
                ],
            ],
            'discount' => [
                'title' => 'Diskon Tambahan',
                'description' => 'Bagian ini memungkinkan Anda untuk memberikan diskon tambahan pada pesanan penjualan.',
                'fields' => [
                    'apply_discount_on' => 'Terapkan Diskon Tambahan Pada',
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
            'shopping_chart' => 'Troli Belanja',
        ],
    ],
];

