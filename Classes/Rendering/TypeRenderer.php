<?php
namespace Arndtteunissen\SocialMediaFields\Rendering;

/*******************************************************************************
 * Copyright notice
 *
 * (c) 2017 arndtteunissen <dev@arndtteunissen.de>
 * All rights reserved
 ******************************************************************************/

use Arndtteunissen\SocialMediaFields\Types\AbstractType;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class TypeRenderer
 */
class TypeRenderer
{
    /**
     * @return array
     */
    public function render(): array
    {
        $tags = [];
        $renderType = $this->esimateTypeRenderer($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['social_media_fields']['types']);

        if ($renderType !== null) {
            $tags = $this->renderType($renderType);
        }

        return $tags;
    }

    /**
     * @param array $types
     * @return AbstractType|null
     */
    protected function esimateTypeRenderer(array $types)
    {
        $sortedTypes = [];
        $renderType = null;

        foreach ($types as $className) {
            if (class_exists($className) && is_subclass_of($className, AbstractType::class)) {
                /** @var AbstractType $type */
                $type = GeneralUtility::makeInstance($className);
                $sortedTypes[$type->getPriority()] = $type;
            }
        }

        krsort($sortedTypes);

        /** @var AbstractType $type */
        foreach ($sortedTypes as $type) {
            if ($type->shouldRender()) {
                $renderType = $type;
                break;
            }
        }

        return $renderType;
    }

    /**
     * @param AbstractType $type
     * @return array
     */
    protected function renderType(AbstractType $type)
    {
        $tags = [];

        $type->initialize();

        if ($type->shouldRender()) {
            $type->generate();
            $tags = $type->render();
        }

        return $tags;
    }
}
