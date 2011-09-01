<?php
namespace Xi\Zend\Mvc\ActionDispatcher;

/**
 * Allows ActionController actions to decide which HTTP methods to recieve. This
 * is implemented as an extended naming convention for the action methods: an
 * action method may be suffixed with a HTTP method name.
 * 
 * Examples:
 *  indexAction: will not care about the HTTP method
 *  createActionPut: will only receive PUT requests
 *  updateActionPost: will only receive POST requests
 */
class RestfulActionDispatcher extends AbstractActionDispatcher
{
    /**
     * @param string $action
     * @return string | false
     */
    protected function getActionMethod($action)
    {
        $candidates = $this->getActionMethodCandidates($action);
        foreach ($candidates as $candidate) {
            if ($this->hasActionControllerMethod($candidate)) {
                return $candidate;
            }
        }
        return false;
    }
    
    /**
     * Get an array of ActionController method names to try for a given $action
     * 
     * @param string $action
     * @return array
     */
    protected function getActionMethodCandidates($action)
    {
        return array(
            $action . $this->getFormattedRequestMethod(),
            $action
        );
    }
    
    /**
     * @return null|string
     */
    protected function getFormattedRequestMethod()
    {
        if ($method = $this->getRequestMethod()) {
            return ucfirst(strtolower($method));
        }
    }
    
    /**
     * Returns the HTTP request method from the request object or null if this
     * was not an HTTP request
     * 
     * @return null|string
     */
    protected function getRequestMethod()
    {
        $request = $this->getRequest();
        if (is_callable(array($request, 'getMethod'))) {
            return $request->getMethod();
        }
    }
}