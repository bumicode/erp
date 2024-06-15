<?php

return [

    'stock_entry' => 'Entri Stok',
    'stock_entries' => 'Entri Stok',

    'tab' => [
        'details' => [
            'title' => 'Detail',
            'description' => 'Detail Entri Stok',
            'fields' => [
                'series' => 'Seri',
                'posting_at' => 'Tanggal Posting',
                'stock_entry_type' => 'Tipe Entri Stok',
            ],
            'action' => [
                'is_inspection_required' => 'Diperlukan Pemeriksaan',
            ],
        ],

        'items' => [
            'title' => 'Barang',
            'description' => 'Barang Entri Stok',
            'fields' => [
                'source_warehouse' => 'Gudang Asal',
                'target_warehouse' => 'Gudang Tujuan',
                'item' => 'Barang',
                'quantity' => 'Kuantitas',
                'basic_rate' => 'Tarif Dasar',
                'total' => [
                    'title' => 'Total',
                    'outgoing' => 'Total Nilai Keluar (Konsumsi)',
                    'incoming' => 'Total Nilai Masuk (Penerimaan)',
                    'net' => 'Selisih Nilai Total (Masuk - Keluar)',
                ],
            ],
        ],

        'additional_cost' => [
            'title' => 'Biaya Tambahan',
            'description' => 'Biaya Tambahan Entri Stok',
            'fields' => [
                'expense_account' => 'Akun Pengeluaran',
                'amount' => 'Jumlah',
                'description' => 'Deskripsi',
                'total' => 'Total Biaya Tambahan',
            ],
        ],

        'supplier_info' => [
            'title' => 'Info Pemasok',
            'description' => 'Info Pemasok Entri Stok',
            'fields' => [],
        ],

        'accounting_dimension' => [
            'title' => 'Dimensi Akuntansi',
            'description' => 'Dimensi Akuntansi Entri Stok',
            'fields' => [],
        ],

        'other_info' => [
            'title' => 'Info Lainnya',
            'description' => 'Info Lainnya Entri Stok',
            'fields' => [],
        ],
    ],
];
