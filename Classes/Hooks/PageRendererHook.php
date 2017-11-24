<?php
namespace Arndtteunissen\SocialMediaFields\Hooks;

/*******************************************************************************
 * Copyright notice
 *
 * (c) 2017 arndtteunissen <dev@arndtteunissen.de>
 * All rights reserved
 ******************************************************************************/

use Arndtteunissen\SocialMediaFields\Rendering\TypeRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class PageRendererHooks
 */
class PageRendererHook
{
    /**
     * Render the social media tags.
     *
     * @param array $params
     * @return string
     */
    public function renderPostProcess(array $params)
    {
        $renderer           = GeneralUtility::makeInstance(TypeRenderer::class);
        $params['metaTags'] = array_merge($params['metaTags'], $renderer->render());
    }
}
