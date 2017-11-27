<?php

/*
 * Copyright notice
 *
 * (c) 2017 arndtteunissen <dev@arndtteunissen.de>
 * All rights reserved
 */

defined('TYPO3_MODE') || die();

call_user_func(
    function ($extKey) {
        // Read extension configuration
        if (!is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extKey])) {
            $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extKey] = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extKey]);
        }

        if (TYPO3_MODE === 'FE') {
            $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][] = \Arndtteunissen\SocialMediaFields\Hooks\PageRendererHook::class . '->renderPostProcess';
        }

        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$extKey] = [
            'types' => [
                'pages' => Arndtteunissen\SocialMediaFields\Types\Pages::class
            ]
        ];

        if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('news')) {
            $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$extKey]['types']['news'] = Arndtteunissen\SocialMediaFields\Types\News::class;
        }
    },
    $_EXTKEY
);
