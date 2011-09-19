<?php
namespace Xi\Zend\Mvc\View;

use Zend_View_Helper_Abstract;

/**
 * @category   Xi
 * @package    Zend
 * @subpackage Mvc
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */
class LinkToRouteHelper extends Zend_View_Helper_Abstract
{
    /**
     * @param string $route
     * @param string $content optional, defaults to $route
     * @param array $attributes
     * @return string
     */
    public function linkToRoute($route, $content = null, $attributes = array())
    {
        if (null === $content) {
            $content = $route;
        }
        return $this->view->linkTo(
            $this->view->urlToRoute($route),
            $content,
            $attributes
        );
    }
}