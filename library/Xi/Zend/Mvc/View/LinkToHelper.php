<?php
namespace Xi\Zend\Mvc\View;

use Zend_View_Helper_Abstract;

/**
 * @category   Xi
 * @package    Zend
 * @subpackage Mvc
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */
class LinkToHelper extends Zend_View_Helper_Abstract
{
    /**
     * @param string $url
     * @param string $content
     * @param array $attributes
     * @return string
     */
    public function linkTo($url, $content, $attributes = array())
    {
        return $this->view->element(
            'a',
            $this->view->translate($content),
            array('href' => $url) + $attributes
        );
    }
}