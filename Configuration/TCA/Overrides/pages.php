<?php

/*
 * Copyright notice
 *
 * (c) 2017 arndtteunissen <dev@arndtteunissen.de>
 * All rights reserved
 */

defined('TYPO3_MODE') || die();

$ll = 'LLL:EXT:social_media_fields/Resources/Private/Language/locallang_db.xlf:';

$columns = [
    'tx_socialmediafields_opengraph_headline'    => [
        'label'   => $ll . 'pages.tx_socialmediafields_opengraph_headline',
        'exclude' => 1,
        'config'  => [
            'type'        => 'input',
            'size'        => 30,
            'eval'        => 'trim',
            'max'         => 150,
            'default'     => '',
            'placeholder' => '__row|title',
            'mode'        => 'useOrOverridePlaceholder'
        ],
    ],
    'tx_socialmediafields_opengraph_description' => [
        'label'   => $ll . 'pages.tx_socialmediafields_opengraph_description',
        'exclude' => 1,
        'config'  => [
            'type'        => 'text',
            'default'     => '',
            'cols'        => 40,
            'rows'        => 3,
            'max'         => 255,
            'placeholder' => '__row|description',
            'mode'        => 'useOrOverridePlaceholder'
        ],
    ],
    'tx_socialmediafields_opengraph_images'      => [
        'label'   => $ll . 'pages.tx_socialmediafields_opengraph_images',
        'exclude' => 1,
        'config'  => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('tx_socialmediafields_opengraph_images'),
    ],

    'tx_socialmediafields_twitter_headline'    => [
        'label'   => $ll . 'pages.tx_socialmediafields_twitter_headline',
        'exclude' => 1,
        'config'  => [
            'type'        => 'input',
            'size'        => 30,
            'eval'        => 'trim',
            'max'         => 150,
            'default'     => '',
            'placeholder' => '__row|title',
            'mode'        => 'useOrOverridePlaceholder'
        ],
    ],
    'tx_socialmediafields_twitter_description' => [
        'label'   => $ll . 'pages.tx_socialmediafields_twitter_description',
        'exclude' => 1,
        'config'  => [
            'type'        => 'text',
            'default'     => '',
            'cols'        => 40,
            'rows'        => 3,
            'max'         => 255,
            'placeholder' => '__row|description',
            'mode'        => 'useOrOverridePlaceholder'
        ],
    ],
    'tx_socialmediafields_twitter_images'      => [
        'label'   => $ll . 'pages.tx_socialmediafields_twitter_images',
        'exclude' => 1,
        'config'  => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('tx_socialmediafields_twitter_images'),
    ],
];

// Palettes
$GLOBALS['TCA']['pages']['palettes']['tx_socialmediafields_opengraph']                  = [
    'showitem' => 'tx_socialmediafields_opengraph_headline,--linebreak--,tx_socialmediafields_opengraph_description,--linebreak--,tx_socialmediafields_opengraph_images,',
];
$GLOBALS['TCA']['pages_language_overlay']['palettes']['tx_socialmediafields_opengraph'] = $GLOBALS['TCA']['pages']['palettes']['tx_socialmediafields_opengraph'];

$GLOBALS['TCA']['pages']['palettes']['tx_socialmediafields_twitter']                  = [
    'showitem' => 'tx_socialmediafields_twitter_headline,--linebreak--,tx_socialmediafields_twitter_description,--linebreak--,tx_socialmediafields_twitter_images,',
];
$GLOBALS['TCA']['pages_language_overlay']['palettes']['tx_socialmediafields_twitter'] = $GLOBALS['TCA']['pages']['palettes']['tx_socialmediafields_twitter'];

$typeExtend = '--div--;' . $ll . 'pages.div.socialmedia,--palette--;' . $ll . 'pages.palettes.socialmedia_opengraph;tx_socialmediafields_opengraph,
--palette--;' . $ll . 'pages.palettes.socialmedia_twitter;tx_socialmediafields_twitter,';
$typeList   = '1,6,7';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $columns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages', $typeExtend, $typeList);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages_language_overlay', $columns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages_language_overlay', $typeExtend, $typeList);

unset($columns);
unset($typeExtend);
