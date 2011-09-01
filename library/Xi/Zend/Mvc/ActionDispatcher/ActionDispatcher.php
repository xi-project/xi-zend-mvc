<?php
namespace Xi\Zend\Mvc\ActionDispatcher;

/**
 * Encapsulates the ActionController's action dispatch process
 */
interface ActionDispatcher
{
    /**
     * @return Xi\Zend\Mvc\ActionController
     */
    public function getActionController();
    
    /**
     * Dispatch the requested action on the associated ActionController. The
     * action is a method name formatted by the controller dispatcher, such as
     * 'indexAction'.
     * 
     * @param string $action
     * @return void
     */
    public function dispatch($action);
}