<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
    'lkpp' => [
        'kode_klpd' => env('KODE_KLPD'),
        'kode_lpse' => env('KODE_LPSE'),
        'isb_sirup_anggaran_penyedia' => env('ISB_SIRUP_ANGGARAN_PENYEDIA'),
        'isb_sirup_penyedia_terumumkan' => env('ISB_SIRUP_PENYEDIA_TERUMUMKAN'),
        'isb_sirup_penyedia_lokasi' => env('ISB_SIRUP_PENYEDIA_LOKASI'),
        'isb_spse_tender_pengumuman' => env('ISB_SPSE_TENDER_PENGUMUMAN'),
        'isb_spse_nontender_pengumuman' => env('ISB_SPSE_NONTENDER_PENGUMUMAN'),
        'isb_spse_tender_spmk' => env('ISB_SPSE_TENDER_SPMK'),
        'isb_spse_nontender_spmk' => env('ISB_SPSE_NONTENDER_SPMK'),
        'isb_spse_tender_kontrak' => env('ISB_SPSE_TENDER_KONTRAK'),
        'isb_spse_nontender_kontrak' => env('ISB_SPSE_NONTENDER_KONTRAK'),
        'isb_spse_tender_selesai' => env('ISB_SPSE_TENDER_SELESAI'),
        'isb_spse_nontender_selesai' => env('ISB_SPSE_NONTENDER_SELESAI'),
        'isb_sikap_penyedia' => env('ISB_SIKAP_PENYEDIA'),
    ],

];
