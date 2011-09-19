<?php
namespace Xi\Zend\Mvc\View;

use Zend_View_Helper_Abstract;

/**
 * A shortcut for creating a URL based on only the route name.
 * 
 * @category   Xi
 * @package    Zend
 * @subpackage Mvc
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */
class UrlToRouteHelper extends Zend_View_Helper_Abstract
{
    /**
     * @param string $route
     * @return string
     */
    public function urlToRoute($route)
    {
        return $this->view->url(array(), $route, true);
    }
}