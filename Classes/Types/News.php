<?php
namespace Arndtteunissen\SocialMediaFields\Types;

/*******************************************************************************
 * Copyright notice
 *
 * (c) 2017 arndtteunissen <dev@arndtteunissen.de>
 * All rights reserved
 ******************************************************************************/

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\FrontendRestrictionContainer;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Frontend\Resource\FileCollector;

/**
 * Class News
 */
class News extends AbstractType
{
    /**
     * @var int
     */
    protected $priority = 5;

    /**
     * This is the default renderer and should have the lowest priority.
     *
     * @return bool
     */
    public function shouldRender(): bool
    {
        $gp = GeneralUtility::_GP('tx_news_pi1');

        return is_array($gp) && isset($gp['news']) && (int)$gp['news'] > 0;
    }

    /**
     * @throws \UnexpectedValueException
     */
    public function generate()
    {
        $uid = (int)GeneralUtility::_GP('tx_news_pi1')['news'];
        $row = $this->getNewsRow($uid);

        if ($row) {
            $this->generateOpenGraphTags($row);
            $this->generateTwitterTags($row);

            // Hook to render additional tags.
            if (isset($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tx_socialmediafields']['types']['news'])
                && is_array(
                    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tx_socialmediafields']['types']['news']
                )
            ) {
                foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tx_socialmediafields']['types']['news'] as $hook) {
                    $params = [
                        'row' => $row
                    ];

                    GeneralUtility::callUserFunction($hook, $params, $this);
                }
            }
        }
    }

    /**
     * @param array $row
     */
    protected function generateOpenGraphTags(array $row)
    {
        // Generate title
        $title = $this->getPageRenderer()->getTitle();
        if (isset($row['tx_socialmediafields_opengraph_headline']) && strlen($row['tx_socialmediafields_opengraph_headline'])) {
            $title = $row['tx_socialmediafields_opengraph_headline'];
        }
        $this->addOpenGraphTag('og:title', (string)$title);

        // Generate description
        $description = strip_tags($row['teaser']);
        if ($row['description']) {
            $description = $row['description'];
        } elseif (isset($row['tx_socialmediafields_opengraph_description']) && strlen($row['tx_socialmediafields_opengraph_description'])) {
            $description = $row['tx_socialmediafields_opengraph_description'];
        }
        $this->addOpenGraphTag('og:description', (string)$description);

        // Generate image
        $fileCollector = GeneralUtility::makeInstance(FileCollector::class);
        $fileCollector->addFilesFromRelation('tx_news_domain_model_news', 'tx_socialmediafields_opengraph_images', $row);
        if ($files = $fileCollector->getFiles()) {
            /** @var FileReference $file */
            foreach ($files as $file) {
                // Add the file only if it is an image.
                if ($file->getType() === 2) {
                    $this->addOpenGraphTag('og:image', $this->getPageRenderer()->getBaseUrl() . $file->getPublicUrl());
                }
            }
        } elseif (isset(
            $this->getTyposcriptFrontendController()->tmpl->setup['plugin.']['tx_socialmediafields.']['settings.']['opengraph.']
        )) {
            if (isset(
                $this->getTyposcriptFrontendController(
                )->tmpl->setup['plugin.']['tx_socialmediafields.']['settings.']['opengraph.']['defaultImage.']
            )) {
                $this->addOpenGraphTag(
                    'og:image',
                    $this->getTyposcriptFrontendController()->cObj->stdWrap(
                        $GLOBALS['TSFE']->tmpl->setup['config.']['tx_socialmediafields.']['settings.']['opengraph.']['defaultImage.']
                    )
                );
            } elseif ($this->getTyposcriptFrontendController(
            )->tmpl->setup['plugin.']['tx_socialmediafields.']['settings.']['opengraph.']['defaultImage']
            ) {
                $imagePath = $this->getTyposcriptFrontendController(
                )->tmpl->setup['plugin.']['tx_socialmediafields.']['settings.']['opengraph.']['defaultImage'];
                $imagePath = GeneralUtility::getFileAbsFileName($imagePath);

                // Only if the files exists. Then it does not exist, GeneralUtility::getFileAbsFileName returns a blank string.
                if ($imagePath) {
                    $imagePath = substr($imagePath, strlen(PATH_site));
                    $this->addOpenGraphTag(
                        'og:image',
                        $this->getPageRenderer()->getBaseUrl() . ltrim(
                            $this->getTyposcriptFrontendController()->absRefPrefix,
                            '/'
                        ) . GeneralUtility::createVersionNumberedFilename($imagePath)
                    );
                }
            }
        }
    }

    /**
     * @param array $row
     * @throws \UnexpectedValueException
     */
    protected function generateTwitterTags(array $row)
    {
        // Generate twitter card
        if (isset(
            $this->getTyposcriptFrontendController()->tmpl->setup['plugin.']['tx_socialmediafields.']['settings.']['twitter.']['card']
        )) {
            $this->addTwitterTag(
                'twitter:card',
                $this->getTyposcriptFrontendController()->tmpl->setup['plugin.']['tx_socialmediafields.']['settings.']['twitter.']['card']
            );
        }

        // Generate twitter card
        if (isset(
            $this->getTyposcriptFrontendController()->tmpl->setup['plugin.']['tx_socialmediafields.']['settings.']['twitter.']['site']
        )) {
            $this->addTwitterTag(
                'twitter:site',
                $this->getTyposcriptFrontendController()->tmpl->setup['plugin.']['tx_socialmediafields.']['settings.']['twitter.']['site']
            );
        }

        // Generate title
        $title = $this->getPageRenderer()->getTitle();
        if (isset($row['tx_socialmediafields_twitter_headline']) && strlen($row['tx_socialmediafields_twitter_headline'])) {
            $title = $row['tx_socialmediafields_twitter_headline'];
        }
        $this->addTwitterTag('twitter:title', (string)$title);

        // Generate description
        $description = strip_tags($row['teaser']);
        if ($row['description']) {
            $description = $row['description'];
        } elseif (isset($row['tx_socialmediafields_twitter_description']) && strlen($row['tx_socialmediafields_twitter_description'])) {
            $description = $row['tx_socialmediafields_twitter_description'];
        }
        $this->addTwitterTag('twitter:description', (string)$description);

        // Generate image
        $fileCollector = GeneralUtility::makeInstance(FileCollector::class);
        $fileCollector->addFilesFromRelation('tx_news_domain_model_news', 'tx_socialmediafields_twitter_images', $row);
        if ($files = $fileCollector->getFiles()) {
            /** @var FileReference $file */
            foreach ($files as $file) {
                // Add the file only if it is an image.
                if ($file->getType() === 2) {
                    $this->addTwitterTag('twitter:image', $this->getAbsoluteImagePath($file->getPublicUrl()));
                }
            }
        } elseif (isset(
            $this->getTyposcriptFrontendController()->tmpl->setup['plugin.']['tx_socialmediafields.']['settings.']['twitter.']
        )) {
            if (isset(
                $this->getTyposcriptFrontendController(
                )->tmpl->setup['plugin.']['tx_socialmediafields.']['settings.']['twitter.']['defaultImage.']
            )) {
                $this->addTwitterTag(
                    'twitter:image',
                    $this->getTyposcriptFrontendController()->cObj->stdWrap(
                        $GLOBALS['TSFE']->tmpl->setup['config.']['tx_socialmediafields.']['settings.']['twitter.']['defaultImage.']
                    )
                );
            } elseif ($this->getTyposcriptFrontendController(
            )->tmpl->setup['plugin.']['tx_socialmediafields.']['settings.']['twitter.']['defaultImage']
            ) {
                $imagePath = $this->getTyposcriptFrontendController(
                )->tmpl->setup['plugin.']['tx_socialmediafields.']['settings.']['twitter.']['defaultImage'];
                $imagePath = GeneralUtility::getFileAbsFileName($imagePath);

                // Only if the files exists. Then it does not exist, GeneralUtility::getFileAbsFileName returns a blank string.
                if ($imagePath) {
                    $imagePath = substr($imagePath, strlen(PATH_site));
                    $this->addTwitterTag(
                        'twitter:image',
                        $this->getAbsoluteImagePath(GeneralUtility::createVersionNumberedFilename($imagePath))
                    );
                }
            }
        }
    }

    /**
     * @param string $property
     * @param string $content
     */
    protected function addOpenGraphTag(string $property, string $content)
    {
        if ($content) {
            $this->addTag(
                'meta',
                [
                    'property' => $property,
                    'content'  => $content
                ]
            );
        }
    }

    /**
     * @param string $name
     * @param string $content
     */
    protected function addTwitterTag(string $name, string $content)
    {
        if ($content) {
            $this->addTag(
                'meta',
                [
                    'name'    => $name,
                    'content' => $content
                ]
            );
        }
    }

    /**
     * @param int $uid
     * @return array
     * @throws \UnexpectedValueException
     */
    protected function getNewsRow(int $uid): array
    {
        if (VersionNumberUtility::convertVersionNumberToInteger(TYPO3_branch) >= VersionNumberUtility::convertVersionNumberToInteger(
                '8.7'
            )
        ) {
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_news_domain_model_news');
            $queryBuilder->setRestrictions(GeneralUtility::makeInstance(FrontendRestrictionContainer::class));
            $news = $queryBuilder->select('*')
                                 ->from('tx_news_domain_model_news')
                                 ->where($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT)))
                                 ->execute()
                                 ->fetch();
        } else {
            $news = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow(
                '*',
                'tx_news_domain_model_news',
                'uid=' . $uid . $GLOBALS['TSFE']->cObj->enableFields('tx_news_domain_model_news')
            );
        }

        return $news ?: [];
    }
}
