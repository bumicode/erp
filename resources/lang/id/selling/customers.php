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

    'customer' => 'Konsumen',
    'customers' => 'Konsumen',

    'tab' => [
        'details' => 'Detail',
        'contact' => 'Kontak',
        'address' => 'Alamat',
        'tax' => 'Pajak',
        'accounting' => 'Akuntansi',
        'sales_team' => 'Tim Penjualan',
        'settings' => 'Pengaturan',
    ],

    'field' => [
        'detail' => [
            'salutation' => 'Sapaan',
            'territory' => 'Wilayah',
            'name' => 'Nama Konsumen',
            'gender' => 'Jenis Kelamin',
            'customer_type' => 'Tipe Konsumen',
            'customer_group' => 'Grup Konsumen',
            'from_lead' => 'Dari Lead',
            'from_opportunity' => 'Dari Kesempatan',
            'customer_manager' => 'Manager Konsumen',

            'internal_customer' => [
                'title' => 'Konsumen Internal',
                'description' => 'Menandakan bahwa konsumen merupakan konsumen internal',
                'action' => 'Tandai sebagai Konsumen Internal',
            ],

            'more_information' => [
                'title' => 'Informasi Tambahan',
                'field' => [
                    'market_segment' => 'Segmen Pasar',
                    'industry' => 'Industri',
                    'website' => 'Situs Web',
                    'content' => 'Konten',
                ],
            ],
        ],
        'contact_address' => [
            'title' => 'Alamat Utama dan Kontak',
            'description' => 'Pilih, untuk membuat konsumen dapat dicari dengan menggunakan bidang ini',
            'field' => [
                'address' => 'Alamat Utama',
                'address_hint' => 'Pilih ulang, jika alamat yang dipilih diubah setelah disimpan',
                'contact' => 'Kontak Utama',
                'contact_hint' => 'Pilih ulang, jika kontak yang dipilih diubah setelah disimpan',
            ],
        ],
        'tax' => [
            'title' => 'Pajak',
            'field' => [
                'tax_number' => 'Nomor Pajak',
                'tax_category' => 'Kategori Pajak',
                'tax_withholding_category' => 'Kategori Pemotongan Pajak',
            ],
        ],
        'accounting' => [
            'title' => 'Batas Kredit dan Persyaratan Pembayaran',
            'field' => [
                'payment_term_template' => 'Template Persyaratan Pembayaran Default',
            ],
        ],
    ],

    'created_success' => 'Konsumen berhasil dibuat!',
    'updated_success' => 'Konsumen berhasil diperbarui!',
    'deleted_success' => 'Konsumen berhasil dihapus!',

];
