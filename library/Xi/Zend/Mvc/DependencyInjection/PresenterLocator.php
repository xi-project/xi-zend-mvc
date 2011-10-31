<?php
namespace Xi\Zend\Mvc\DependencyInjection;

use Xi\Zend\Mvc\Service;

/**
 * Provides an ActionController's Service instance to a Presenter
 */
class PresenterLocator extends AbstractActionControllerServiceLocator
{
    public function init($c)
    {
        parent::init($c);
        
        $c['actionControllerService'] = $c->share(function($c) {
            return $c['actionController']->getService();
        });
    }
    
    /**
     * Gets the Service instance associated with the ActionController for this
     * Presenter.
     * 
     * @return Service
     */
    public function getActionControllerService()
    {
        return $this->container['actionControllerService'];
    }
}