<?php
namespace Xi\Zend\Mvc;

use Xi\Zend\Mvc\ActionDispatcher\StatefulActionDispatcher;

/**
 * Provides a concrete ActionController implementation intended to be extended
 * directly by modules. Implements the Serviceful, Stateful and Presentable
 * behaviours.
 */
class ActionController extends ActionController\AbstractActionController
    implements ActionController\ServicefulActionController,
        ActionController\StatefulActionController,
        ActionController\PresentableActionController
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
     * @var Presenter | false
     */
    private $presenter;
    
    /**
     * Override in a child class to provide a name for a presenter class to
     * associate this ActionController with.
     * 
     * @var string
     */
    protected $presenterClass;
    
    /**
     * @var null|boolean|string
     */
    private $status;
    
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
     * @return StatefulActionDispatcher 
     */
    protected function getDefaultActionDispatcher()
    {
        return new StatefulActionDispatcher($this);
    }
    
    /**
     * Provides access to helpers to outside parties; mainly Services and
     * Presenters, if needed.
     * 
     * @param string $helper
     * @return Zend_Controller_Action_Helper_Abstract
     */
    public function getHelper($helper)
    {
        return $this->_helper->getHelper($helper);
    }
    
    /**
     * Informs the associated presenter of the current action name and status
     * 
     * @return void
     */
    public function postDispatch()
    {
        $this->getPresenter()->display(
            $this->getRequest()->getActionName(),
            $this->getStatus()
        );
    }
    
    
    /**
     * Gets the associated Presenter instance. If one is not set, retrieves one
     * from the associated service locator. The service locator will in turn
     * refer to getPresenterClassName() in order to determine which Presenter to
     * instantiate.
     * 
     * @return Presenter
     */
    public function getPresenter()
    {
        if (null === $this->presenter) {
            $this->presenter = $this->getServiceLocator()->getPresenter($this);
        }
        return $this->presenter;
    }
    
    /**
     * Provides the declared presenter class name if one exists. If not, finds one
     * using getDefaultAssociatedClassName().
     * 
     * Used by the service locator to determine which presenter to instantiate.
     * 
     * @return string
     */
    public function getPresenterClassName()
    {
        if (null !== $this->presenterClass) {
            return $this->presenterClass;
        }
        return $this->presenterClass = $this->getAssociatedClassName("Presenter");
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
     * Provides the declared service class name if one exists. If not, finds one
     * using getDefaultAssociatedClassName().
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
        return $this->serviceClass = $this->getAssociatedClassName("Service");
    }
    
    /**
     * If not, replaces "Controller" with $type in the name of this class and
     * returns it; eg. "ExampleModule\Controller\UserController" becomes 
     * "ExampleModule\Service\UserService". Implementors are free to replace the
     * default behaviour with their own discovery logic.
     * 
     * @param string $type
     * @param string $alternate optional
     * @return string fully qualified class name
     */
    protected function getAssociatedClassName($type, $alternate = null)
    {
        return str_replace("Controller", $type, get_class($this));
    }
    
    /**
     * @param null|boolean|string $status
     * @return ActionController
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
    
    /**
     * @return null|boolean|string
     */
    public function getStatus()
    {
        return $this->status;
    }
}