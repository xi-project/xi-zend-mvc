<?php
namespace Xi\Zend\Mvc\ActionController;

use Xi\Zend\Mvc\ActionDispatcher\ActionDispatcher;

/**
 * Delegates the action dispatch process to an ActionDispatcher. The choice of
 * a dispatcher is left to implementors.
 */
abstract class AbstractActionController extends \Zend_Controller_Action
{
    /**
     * @var ActionDispatcher
     */
    protected $actionDispatcher;
    
    /**
     * Dispatch the requested action using an ActionDispatcher.
     *
     * @param string $action Method name of action
     * @return void
     */
    public function dispatch($action)
    {
        // Notify helpers of action preDispatch state
        $this->_helper->notifyPreDispatch();

        $this->getActionDispatcher()->dispatch($action);

        // whats actually important here is that this action controller is
        // shutting down, regardless of dispatching; notify the helpers of this
        // state
        $this->_helper->notifyPostDispatch();
    }
    
    /**
     * @return ActionDispatcher
     */
    protected function getActionDispatcher()
    {
        if (null === $this->actionDispatcher) {
            $this->actionDispatcher = $this->getDefaultActionDispatcher();
        }
        return $this->actionDispatcher;
    }
    
    /**
     * @return ActionDispatcher
     */
    abstract protected function getDefaultActionDispatcher();
}