<?php
namespace Xi\Zend\Mvc\ActionDispatcher;

/**
 * Allows a StatefulActionController to present a state using the action
 * method's return value.
 */
class StatefulActionDispatcher extends RestfulActionDispatcher
{
    public function dispatch($action)
    {
        // Reset the ActionController's state before dispatch
        $this->getActionController()->setStatus(null);
        parent::dispatch($action);
    }
    
    protected function dispatchAction($method, $arguments)
    {
        // Capture a non-null return value as the new state
        $result = parent::dispatchAction($method, $arguments);
        if (null !== $result) {
            $this->getActionController()->setStatus($result);
        }
        return $result;
    }
}