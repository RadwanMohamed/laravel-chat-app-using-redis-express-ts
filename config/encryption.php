<?php

/**
 * encryption config
 */
return [
    'ENCRYPT_METHOD' => env('ENCRYPT_METHOD', 'AES-256-CBC'),
    'secret_key' => env('SECRET_KEY', 'default'),
    'secret_IV' => env('SECRET_IV', 'default'),
];
