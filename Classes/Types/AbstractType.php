<?php
namespace Arndtteunissen\SocialMediaFields\Types;

/*******************************************************************************
 * Copyright notice
 *
 * (c) 2017 arndtteunissen <dev@arndtteunissen.de>
 * All rights reserved
 ******************************************************************************/

use Arndtteunissen\SocialMediaFields\Rendering\TagRenderer;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Service\EnvironmentService;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Class AbstractType
 */
abstract class AbstractType implements SingletonInterface
{
    /**
     * The priority of that type. Higher number means higher priority.
     *
     * @var int
     */
    protected $priority = 1;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var array
     */
    protected $platforms = [];

    /**
     * @var array
     */
    private $tags = [];

    public function initialize()
    {
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
    }

    /**
     * Return true, if this type should be render the social media tags.
     *
     * @return bool
     */
    abstract public function shouldRender(): bool;

    /**
     * This method should generate the tags and add it using the method addTag().
     */
    abstract public function generate();

    /**
     * @return array
     */
    public function render(): array
    {
        $tags = [];

        /** @var TagRenderer $tag */
        foreach ($this->tags as $tag) {
            $tags[] = $tag->render();
        }

        return $tags;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @param string $tagName
     * @param array $attributes
     */
    protected function addTag(string $tagName, array $attributes)
    {
        /** @var TagRenderer $tag */
        $tag = $this->objectManager->get(TagRenderer::class);
        $tag->setTagName($tagName);
        $tag->setTagAttributes($attributes);

        $this->tags[] = $tag;
    }

    /**
     * @return TypoScriptFrontendController
     */
    protected function getTyposcriptFrontendController()
    {
        return $GLOBALS['TSFE'];
    }

    /**
     * @return PageRenderer
     */
    protected function getPageRenderer()
    {
        return GeneralUtility::makeInstance(PageRenderer::class);
    }

    /**
     * @param string $imageUrl
     * @param bool $absolute
     * @return string
     * @throws \UnexpectedValueException
     */
    protected function getImagePath(string $imageUrl, $absolute = true): string
    {
        $environmentService = GeneralUtility::makeInstance(EnvironmentService::class);
        $parsedUrl          = parse_url($imageUrl);
        // no prefix in case of an already fully qualified URL
        if (isset($parsedUrl['host'])) {
            $uriPrefix = '';
        } elseif ($environmentService->isEnvironmentInFrontendMode()) {
            $uriPrefix = $GLOBALS['TSFE']->absRefPrefix;
        } else {
            $uriPrefix = GeneralUtility::getIndpEnv('TYPO3_SITE_PATH');
        }

        if ($absolute) {
            // If full URL has no scheme we add the same scheme as used by the site
            // so we have an absolute URL also usable outside of browser scope (e.g. in an email message)
            if (isset($parsedUrl['host']) && !isset($parsedUrl['scheme'])) {
                $uriPrefix = (GeneralUtility::getIndpEnv('TYPO3_SSL') ? 'https:' : 'http:') . $uriPrefix;
            }

            return GeneralUtility::locationHeaderUrl($uriPrefix . $imageUrl);
        }

        return $uriPrefix . $imageUrl;
    }
}
