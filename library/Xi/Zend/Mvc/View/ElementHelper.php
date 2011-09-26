<?php

namespace Xi\Zend\Mvc\View;

use Zend_View_Helper_Abstract;

/**
 * Renders XHTML elements.
 *
 * @category   Xi
 * @package    Zend
 * @subpackage Mvc
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */
class ElementHelper extends Zend_View_Helper_Abstract
{
    /**
     * @var string
     */
    protected $elementFormat = '<%1$s%2$s>%3$s</%1$s>';

    /**
     * @var string
     */
    protected $emptyElementFormat = '<%1$s%2$s />';

    /**
     * @var string
     */
    private $element;

    /**
     * @var mixed
     */
    private $content;

    /**
     * @var array
     */
    private $attributes = array();

    /**
     * Format the string for an HTML element.
     *
     * @param  string             $element    tag name (eg. "em")
     * @param  string|false|null  $content    non-string for an empty element
     * @param  array              $attributes
     * @return ElementHelper
     */
    public function element($element, $content = null,
        array $attributes = array()
    ) {
        $this->element    = $element;
        $this->content    = $content;
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (is_string($this->content) || is_numeric($this->content)) {
            return sprintf(
                $this->elementFormat,
                $this->element,
                $this->formatAttributes($this->attributes), $this->content
            );
        } else {
            return sprintf(
                $this->emptyElementFormat,
                $this->element, $this->formatAttributes($this->attributes)
            );
        }
    }

    /**
     * @param  string        $content
     * @return ElementHelper
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param  array         $attributes
     * @return ElementHelper
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Format attributes for an HTML element
     *
     * @param  array  $attribs
     * @return string
     */
    protected function formatAttributes(array $attribs)
    {
        $xhtml = '';
        foreach ((array) $attribs as $key => $val) {
            if ($key && $val) {
                $key = $this->view->escape($key);
                if (is_array($val)) {
                    $val = implode(' ', $val);
                }
                $val = $this->view->escape($val);
                $xhtml .= " $key=\"$val\"";
            }
        }
        return $xhtml;
    }
}
