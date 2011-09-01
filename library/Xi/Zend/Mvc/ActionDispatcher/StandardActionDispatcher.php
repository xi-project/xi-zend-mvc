<?php
namespace Xi\Zend\Mvc\ActionDispatcher;

/**
 * Emulates the standard ZF action dispatch process. Included here for
 * completeness; should probably not be used for other than legacy and/or
 * backwards compatibility reasons.
 */
class StandardActionDispatcher extends AbstractActionDispatcher
{
    /**
     * @var array
     */
    protected $_classMethods;
    
    public function dispatch($action)
    {
        $actionController = $this->getActionController();
        $actionController->preDispatch();
        if ($actionController->getRequest()->isDispatched()) {
            if (null === $this->_classMethods) {
                $this->_classMethods = get_class_methods($actionController);
            }

            // If pre-dispatch hooks introduced a redirect then stop dispatch
            // @see ZF-7496
            if (!($actionController->getResponse()->isRedirect())) {
                // preDispatch() didn't change the action, so we can continue
                if ($actionController->getInvokeArg('useCaseSensitiveActions') || in_array($action, $this->_classMethods)) {
                    if ($actionController->getInvokeArg('useCaseSensitiveActions')) {
                        trigger_error('Using case sensitive actions without word separators is deprecated; please do not rely on this "feature"');
                    }
                    $actionController->$action();
                } else {
                    $actionController->__call($action, array());
                }
            }
            $actionController->postDispatch();
        }
    }
}