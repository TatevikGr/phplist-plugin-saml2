<?php

if (!class_exists('simplesaml')) {
    if (file_exists(__DIR__ . '/../../../simplesaml.php')) {
        include_once __DIR__ . '/../../../simplesaml.php';
    }
}

if (class_exists('simplesaml')) {
    $settings = [
        'saml_idp' => simplesaml::getSetting('saml_idp'),
    ];
} else {
    $settings = [];
}
$key = $settings['saml_idp'] ?? 'https://sso.phplist.com:8443/realms/phplist';

/**
 * SAML 2.0 remote IdP metadata for SimpleSAMLphp.
 *
 * Remember to remove the IdPs you don't use from this file.
 *
 * See: https://simplesamlphp.org/docs/stable/simplesamlphp-reference-idp-remote
 */
$metadata[$key] = [
    'SingleSignOnService' => [
        [
            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
            'Location' => $key . '/protocol/saml',
        ],
    ],
    'SingleLogoutService'  => $key . '/protocol/saml',
    'certData' => trim(str_replace(
        ["-----BEGIN CERTIFICATE-----", "-----END CERTIFICATE-----", "\n", "\r"],
        '',
        file_get_contents(__DIR__ . '/../cert/saml-remote-idp.crt')
    )),
];
