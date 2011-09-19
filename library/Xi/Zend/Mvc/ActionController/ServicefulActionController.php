<?php
namespace Xi\Zend\Mvc\ActionController;

use Xi\Zend\Mvc\Service\DefaultServiceLocator;

interface ServicefulActionController
{
    /**
     * @return array(Service)
     */
    public function getActionArguments();
    
    /**
     * @return DefaultServiceLocator
     */
    public function getServiceLocator();
    
    /**
     * Retrieve a Service object for this controller.
     * 
     * @return Service
     */
    public function getService();
    
    /**
     * Used by the service locator to determine which service to instantiate.
     * 
     * @return string
     */
    public function getServiceClassName();
}