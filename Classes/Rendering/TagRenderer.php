<?php
namespace Arndtteunissen\SocialMediaFields\Rendering;

/*******************************************************************************
 * Copyright notice
 *
 * (c) 2017 arndtteunissen <dev@arndtteunissen.de>
 * All rights reserved
 ******************************************************************************/

use TYPO3\CMS\Fluid\Core\ViewHelper\TagBuilder;

/**
 * Class TagRenderer
 */
class TagRenderer
{
    /**
     * Tag builder instance
     *
     * @var TagBuilder
     */
    protected $tag = null;

    /**
     * name of the tag to be created by this view helper
     *
     * @var string
     */
    protected $tagName = '';

    /**
     * Names of all registered tag attributes
     *
     * @var array
     */
    private $tagAttributes = [];

    /**
     * @param TagBuilder $tag
     * @return void
     */
    public function injectTag(TagBuilder $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Initializes the class.
     *
     * @return void
     */
    public function initialize()
    {
        $this->tag->reset();
    }

    /**
     * @param string $tagName
     */
    public function setTagName($tagName)
    {
        $this->tagName = $tagName;
    }

    /**
     * @param array $tagAttributes
     */
    public function setTagAttributes(array $tagAttributes)
    {
        $this->tagAttributes = $tagAttributes;
    }

    /**
     * @param string $name
     * @param string $value
     * @return void
     */
    public function addAttribute($name, $value)
    {
        $this->tagAttributes[$name] = $value;
    }

    /**
     * Renders the whole tag.
     *
     * @param string $content
     * @return string
     */
    public function render($content = '')
    {
        $this->tag->setTagName($this->tagName);
        $this->tag->setContent($content);
        $this->tag->addAttributes($this->tagAttributes);

        return $this->tag->render();
    }
}
