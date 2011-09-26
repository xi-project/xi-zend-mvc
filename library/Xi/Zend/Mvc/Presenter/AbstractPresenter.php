<?php
namespace Xi\Zend\Mvc\Presenter;

use Xi\Zend\Mvc\ActionController,
    Xi\Zend\Mvc\DependencyInjection\DefaultServiceLocator;

abstract class AbstractPresenter implements \Xi\Zend\Mvc\Presenter
{
    /**
     * @var ActionController
     */
    private $actionController;
    
    /**
     * @var DefaultServiceLocator $serviceLocator 
     */
    private $serviceLocator;
    
    public function __construct(ActionController $actionController, DefaultServiceLocator $serviceLocator)
    {
        $this->actionController = $actionController;
        $this->serviceLocator = $serviceLocator;
        $this->init();
    }
    
    /**
     * @return ActionController
     */
    public function getActionController()
    {
        return $this->actionController;
    }
    
    /**
     * @return DefaultServiceLocator 
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
    
    /**
     * Template method ran on construction
     * 
     * @return void
     */
    public function init()
    {}
}