<?php
namespace Xi\Zend\Mvc;

interface Presenter
{
    public function __construct(ActionController $actionController, DependencyInjection\DefaultServiceLocator $serviceLocator);
    
    /**
     * @return ActionController
     */
    public function getActionController();
    
    /**
     * @return DependencyInjection\DefaultServiceLocator
     */
    public function getServiceLocator();
    
    /**
     * Perform actions such that a view corresponding to the given action-status
     * pair will be rendered as the result of the currently running action. Can
     * defer rendering to action helpers, eg. ViewRenderer.
     * 
     * @param string $action action name
     * @param null|boolean|string $status
     * @return void
     */
    public function display($action, $status);
}