<?php

return [
    'app' => [
        'name' => 'Claude PHP SDK',
    ],

    'sidebar' => [
        // single item without any sub-items
        'introduction' => 'Introduction',
        // nested items
        [
            'title' => 'Getting Started',
            'items' => [
                'overview' => 'Overview',
                'installation' => 'Installation',
                'quickstart' => 'Quick Start',
                'configuration' => 'Configuration',
            ]
        ],
    ],
];
