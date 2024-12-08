<?php

return [
    'autolink' => [
        'allowed_protocols' => ['https'], // defaults to ['https', 'http', 'ftp']
        'default_protocol' => 'https', // defaults to 'http'
    ],
    'disallowed_raw_html' => [
        'disallowed_tags' => ['title', 'textarea', 'style', 'xmp', 'iframe', 'noembed', 'noframes', 'script', 'plaintext'],
    ],
    'external_link' => [
        'internal_hosts' => 'claude.yojanamagazine.online', // COMPULSORY
        'open_in_new_window' => true,
        'html_class' => 'external-link',
        'nofollow' => '',
        'noopener' => 'external',
        'noreferrer' => 'external',
    ],
    'table' => [
        'wrap' => [
            'enabled' => false,
            'tag' => 'div',
            'attributes' => [],
        ],
        'alignment_attributes' => [
            'left'   => ['align' => 'left'],
            'center' => ['align' => 'center'],
            'right'  => ['align' => 'right'],
        ],
    ],
];
