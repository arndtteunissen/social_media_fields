<?php

/**
 * Copyright notice
 *
 * (c) 2017 arndtteunissen <dev@arndtteunissen.de>
 * All rights reserved
 */
defined('TYPO3_MODE') || die();

$ll = 'LLL:EXT:social_media_fields/Resources/Private/Language/locallang_db.xlf:';

if (isset($GLOBALS['TCA']['tx_news_domain_model_news'])) {
    $tempColumns = [
        'tx_socialmediafields_opengraph_headline'    => [
            'label'   => $ll . 'tx_news_domain_model_news.tx_socialmediafields_opengraph_headline',
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
            'label'   => $ll . 'tx_news_domain_model_news.tx_socialmediafields_opengraph_description',
            'exclude' => 1,
            'config'  => [
                'type'        => 'text',
                'default'     => '',
                'cols'        => 40,
                'rows'        => 3,
                'placeholder' => '__row|teaser',
                'max'         => 255,
                'mode'        => 'useOrOverridePlaceholder'
            ],
        ],
        'tx_socialmediafields_opengraph_images'      => [
            'label'   => $ll . 'tx_news_domain_model_news.tx_socialmediafields_opengraph_images',
            'exclude' => 1,
            'config'  => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('tx_socialmediafields_opengraph_images'),
        ],

        'tx_socialmediafields_twitter_headline'    => [
            'label'   => $ll . 'tx_news_domain_model_news.tx_socialmediafields_twitter_headline',
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
            'label'   => $ll . 'tx_news_domain_model_news.tx_socialmediafields_twitter_description',
            'exclude' => 1,
            'config'  => [
                'type'        => 'text',
                'default'     => '',
                'cols'        => 40,
                'rows'        => 3,
                'placeholder' => '__row|teaser',
                'max'         => 255,
                'mode'        => 'useOrOverridePlaceholder'
            ],
        ],
        'tx_socialmediafields_twitter_images'      => [
            'label'   => $ll . 'tx_news_domain_model_news.tx_socialmediafields_twitter_images',
            'exclude' => 1,
            'config'  => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('tx_socialmediafields_twitter_images'),
        ],
    ];

    // Palettes
    $GLOBALS['TCA']['tx_news_domain_model_news']['palettes']['tx_socialmediafields_opengraph'] = [
        'showitem' => 'tx_socialmediafields_opengraph_headline,--linebreak--,tx_socialmediafields_opengraph_description,--linebreak--,tx_socialmediafields_opengraph_images,',
    ];

    $GLOBALS['TCA']['tx_news_domain_model_news']['palettes']['tx_socialmediafields_twitter'] = [
        'showitem' => 'tx_socialmediafields_twitter_headline,--linebreak--,tx_socialmediafields_twitter_description,--linebreak--,tx_socialmediafields_twitter_images,',
    ];

    $typeExtend = '--div--;' . $ll . 'tx_news_domain_model_news.div.socialmedia,
    --palette--;' . $ll . 'tx_news_domain_model_news.palettes.socialmedia_opengraph;tx_socialmediafields_opengraph,
    --palette--;' . $ll . 'tx_news_domain_model_news.palettes.socialmedia_twitter;tx_socialmediafields_twitter,';

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_news_domain_model_news', $tempColumns);
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tx_news_domain_model_news', $typeExtend);

    unset($tempColumns);
    unset($typeExtend);
}
