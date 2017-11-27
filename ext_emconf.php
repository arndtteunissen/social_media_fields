<?php

/*
 * Copyright notice
 *
 * (c) 2017 arndtteunissen <dev@arndtteunissen.de>
 * All rights reserved
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'Social Media Fields',
    'description' => 'Adds social media features to TYPO3 pages.',
    'category' => 'fe',
    'constraints' => [
        'depends' => [
            'php' => '7.1.0-7.1.99',
            'typo3' => '7.6.0-8.7.99'
        ],
        'suggests' => [
            'tx_news' => '*'
        ]
    ],
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => false,
    'author' => 'Arndtteunissen',
    'author_email' => 'dev@arndtteunissen.de',
    'author_company' => 'Arndtteunissen',
    'autoload' => [
        'psr-4' => [
            'Arndtteunissen\\SocialMediaFields\\' => 'Classes/'
        ]
    ]
];