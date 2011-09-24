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
     * Format the string for an HTML element.
     *
     * @param  string             $element    tag name (eg. "em")
     * @param  string|false|null  $content    non-string for an empty element
     * @param  array              $attributes
     * @return string
     */
    public function element($element, $content = null, array $attributes = array())
    {
        if (is_string($content) || is_numeric($content)) {
            return sprintf($this->elementFormat, $element, $this->formatAttributes($attributes), $content);
        } else {
            return sprintf($this->emptyElementFormat, $element, $this->formatAttributes($attributes));
        }
    }

    /**
     * Format attributes for an HTML element
     *
     * @param array
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
