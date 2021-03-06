<?php
namespace Xi\Zend\Mvc\DependencyInjection;

use Xi\Zend\Mvc\Service;

/**
 * Provides Zend_View-related dependencies to a Presenter
 */
class ZendViewPresenterLocator extends PresenterLocator
{
    public function init($c)
    {
        parent::init($c);
        
        $c['viewRenderer'] = $c->share(function($c) {
            return $c['actionController']->getHelper('ViewRenderer');
        });
    }
    
    /**
     * @return \Zend_Controller_Action_Helper_ViewRenderer
     */
    public function getViewRenderer()
    {
        return $this->container['actionController']->getHelper('ViewRenderer');
    }
}