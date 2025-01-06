<?php
// config/momo.php

return [
    'partner_code' => env('MOMO_PARTNER_CODE'),
    'access_key' => env('MOMO_ACCESS_KEY'),
    'secret_key' => env('MOMO_SECRET_KEY'),
    'ipn_url' => env('APP_URL') . '/checkout/momo-ipn',
    'redirect_url' => env('APP_URL') . '/checkout/momo-return',

];
