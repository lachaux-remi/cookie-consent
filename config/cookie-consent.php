<?php

return [
    /*
     * Use this setting to enable the cookie consent dialog.
     */
    'enabled' => env('COOKIE_CONSENT_ENABLED', true),
    /*
     * The name of the cookie in which we store if the user
     * has agreed to accept the conditions.
     */
    'cookie_name' => 'cookie_consent',
    /*
     * Set the cookie duration in days.
     * The validity period of this consent is 13 months maximum.
     * Default is 30 * 20.
     */
    'cookie_lifetime' => 30 * 13,
];