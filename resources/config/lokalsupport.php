<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Lokal Koder Support configurations
    |--------------------------------------------------------------------------
    |
    | Configuration definition use by lokalkoder/support package.
    |
    */
    'hasher' => [
        'sponge' => env('HASHER_SPONGE', null),
    ]
];
