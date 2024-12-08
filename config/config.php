<?php

/**
 * Default Configuration;
 * 
 * used as a fallback for the locale configuration as well as core unchanged configuration
 * like url, github links, etc.
 */
return [
    // application
    'app' => [
        'name' => 'Claude PHP SDK',
        'url' => $_ENV['APP_URL'] ?? 'https://claude.yojanamagazine.online',
        'env' => $_ENV['APP_ENV'] ?? 'production',
        'github' => 'https://github.com/namankumar80510/claude-sdk',
        'docs_github' => 'https://github.com/namankumar80510/claude-docs',
    ],

    // i18n
    'i18n' => [
        'default_locale' => 'en',
        'supported_locales' => ['en' => 'English', 'hi' => 'हिंदी'],
    ],
];
