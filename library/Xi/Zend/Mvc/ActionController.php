<?php
namespace Xi\Zend\Mvc;

use Xi\Zend\Mvc\ActionDispatcher\StatefulActionDispatcher;

/**
 * Provides a concrete ActionController implementation intended to be extended
 * directly by modules. Implements the Serviceful and Stateful behaviours.
 */
class ActionController extends ActionController\AbstractActionController
    implements ActionController\ServicefulActionController,
        ActionController\StatefulActionController
{
    /**
     * @var DependencyInjection\DefaultServiceLocator
     */
    private $serviceLocator;
    
    /**
     * Override in a child class to provide a name for a service locator class
     * to associate this ActionController with.
     * 
     * @var string
     */
    protected $serviceLocatorClass;
    
    /**
     * @var Service
     */
    private $service;
    
    /**
     * Override in a child class to provide a name for a service class to
     * associate this ActionController with.
     * 
     * @var string
     */
    protected $serviceClass;
    
    /**
     * @var null|boolean|string
     */
    private $state;
    
    /**
     * The default service locator.
     * 
     * @return DependencyInjection\DefaultServiceLocator
     */
    public function getServiceLocator()
    {
        if (null === $this->serviceLocator) {
            $this->serviceLocator = $this->createServiceLocator();
        }
        return $this->serviceLocator;
    }
    
    /**
     * @return DependencyInjection\DefaultServiceLocator
     */
    protected function createServiceLocator()
    {
        if (null !== $this->serviceLocatorClass) {
            $class = $this->serviceLocatorClass;
            return new $class($this->getInvokeArg('bootstrap'));
        }
        return new DependencyInjection\DefaultServiceLocator($this->getInvokeArg('bootstrap'));
    }
    
    /**
     * Provides the associated Service instance as a parameter to actions
     * 
     * @return array(Service)
     */
    public function getActionArguments()
    {
        return array(
            $this->getService()
        );
    }
    
    /**
     * Gets the associated Service instance. If one is not set, retrieves one
     * from the associated service locator. The service locator will in turn
     * refer to getServiceClassName() in order to determine which service to
     * instantiate.
     * 
     * @return Service
     */
    public function getService()
    {
        if (null === $this->service) {
            $this->service = $this->getServiceLocator()->getService($this);
        }
        return $this->service;
    }
    
    /**
     * Provides the declared service class name if one exists. If not, replaces
     * "Controller" with "Service" in the name of this class and returns it; eg.
     * "ExampleModule\Controller\UserController" becomes 
     * "ExampleModule\Service\UserService". Implementors are free to replace the
     * default behaviour with their own discovery logic
     * 
     * Used by the service locator to determine which service to instantiate.
     * 
     * @return string
     */
    public function getServiceClassName()
    {
        if (null !== $this->serviceClass) {
            return $this->serviceClass;
        }
        return $this->serviceClass = str_replace("Controller", "Service", get_class($this));
    }
    
    /**
     * @param null|boolean|string $state
     * @return StatefulActionController
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }
    
    /**
     * @return null|boolean|string
     */
    public function getState()
    {
        return $this->state;
    }
    
    /**
     * @return StatefulActionDispatcher 
     */
    protected function getDefaultActionDispatcher()
    {
        return new StatefulActionDispatcher($this);
    }
}