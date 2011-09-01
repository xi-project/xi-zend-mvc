<?php
namespace Xi\Zend\Mvc\ActionDispatcher;

use Xi\Zend\Mvc\ActionController;

/**
 * An abstract ActionDispatcher implementation. Allows extenders to easily
 * manipulate parts of the dispatch process. Allows the ActionController to
 * optionally provide arguments for an action method call.
 * 
 * @see dispatch()
 * @see getActionArguments()
 */
abstract class AbstractActionDispatcher implements ActionDispatcher
{
    /**
     * @var ActionController
     */
    private $actionController;
    
    /**
     * @var array
     */
    private $actionControllerMethods;
    
    /**
     * @param ActionController $actionController
     */
    public function __construct($actionController)
    {
        $this->actionController = $actionController;
    }
    
    /**
     * @return ActionController
     */
    public function getActionController()
    {
        return $this->actionController;
    }
    
    /**
     * @return array
     */
    protected function getActionControllerMethods()
    {
        if (null === $this->actionControllerMethods) {
            $this->actionControllerMethods = get_class_methods($this->getActionController());
        }
        return $this->actionControllerMethods;
    }
    
    /**
     * @param string $method
     * @return boolean
     */
    protected function hasActionControllerMethod($method)
    {
        return in_array($method, $this->getActionControllerMethods());
    }
    
    /**
     * @return \Zend_Controller_Request_Abstract
     */
    protected function getRequest()
    {
        return $this->getActionController()->getRequest();
    }
    
    /**
     * Splits the execution of an action into three parts: select an appropriate
     * action method, find appropriate action arguments and dispatch the action.
     * 
     * If an action method was not found, throws a 404 exception.
     * 
     * @param string $action
     * @return void
     * @throws Zend_Controller_Action_Exception
     */
    public function dispatch($action)
    {
        $actionController = $this->getActionController();
        $actionController->preDispatch();
        if ($actionController->getRequest()->isDispatched()) {
            // If pre-dispatch hooks introduced a redirect then stop dispatch
            // @see ZF-7496
            if (!($actionController->getResponse()->isRedirect())) {
                // preDispatch() didn't change the action, so we can continue
                $actionMethod = $this->getActionMethod($action);
                $actionArguments = $this->getActionArguments();
                if ($actionMethod) {
                    $this->dispatchAction($actionMethod, $actionArguments);
                } else {
                    $this->actionNotFound($action, $actionArguments);
                }
            }
            $actionController->postDispatch();
        }
    }
    
    /**
     * Does no manipulation on the action method by default
     * 
     * @param string $action
     * @return string | false
     */
    protected function getActionMethod($action)
    {
        return $action;
    }
    
    /**
     * Allows the ActionController to provide arguments for dispatching an
     * action method
     * 
     * @return array
     */
    protected function getActionArguments()
    {
        if ($this->hasActionControllerMethod('getActionArguments')) {
            return $this->getActionController()->getActionArguments();
        }
        return array();
    }
    
    /**
     * Dispatches the given action method with the given arguments
     * 
     * @param string $method
     * @param array $arguments 
     */
    protected function dispatchAction($method, $arguments)
    {
        call_user_func_array(array($this->getActionController(), $method), $arguments);
    }
    
    /**
     * Responds to a situation where a suitable action method was not found
     * 
     * @param string $action
     * @param array $arguments
     * @throws Zend_Controller_Action_Exception
     */
    protected function actionNotFound($action, $arguments)
    {
        throw new \Zend_Controller_Action_Exception(sprintf('Action "%s" does not exist', $action), 404);
    }
}