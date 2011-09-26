<?php
namespace Xi\Zend\Mvc\Presenter;

use Xi\Zend\Mvc\ActionController,
    Zend_View,
    Zend_Controller_Action_Helper_ViewRenderer;

class ZendViewPresenter extends AbstractPresenter
{
    /**
     * The script action name to pass to the view renderer when the action has a
     * status. First parameter is the action name, the second one is the status.
     *
     * @var string
     */
    protected $scriptActionFormat = "%s/%s";

    /**
     * @var string
     */
    protected $successStatusString = 'success';

    /**
     * @var string
     */
    protected $failureStatusString = 'failure';
    
    /**
     * @return \Zend_Controller_Action_Helper_ViewRenderer
     */
    public function getViewRenderer()
    {
        return $this->getActionController()->getHelper('ViewRenderer');
    }

    /**
     * Displays a view based on an action name and a status.
     *
     * @param string action name
     * @param null|boolean|string status
     * @return void
     */
    public function display($action, $status)
    {
        $this->preDisplay();
        
        $status = $this->statusToString($status);
        $method = $this->findDisplayMethod($action, $status);

        if ($method) {
            $this->displayActionStatus($method, $this->getDisplayArguments());
            $this->setScriptAction($action, $status);
        } else {
            $this->displayMethodNotFound($action, $status);
        }

        $this->postDisplay();
    }
    
    /**
     * @param string $action
     * @param null|boolean|string $status
     * @return string|false
     */
    protected function findDisplayMethod($action, $status)
    {
        foreach($this->getDisplayMethods($action, $status) as $method) {
            if (method_exists($this, $method)) {
                return $method;
            }
        }
        return false;
    }
    
    /**
     * Get an array of arguments to pass to the display method
     * 
     * @return array(Xi\Zend\Mvc\Service, Zend_View)
     */
    protected function getDisplayArguments()
    {
        return array_merge($this->getActionController()->getService(), $this->getViewRenderer()->view);
    }
    
    /**
     * @param string $method
     * @param array $arguments
     * @return mixed method return value
     */
    protected function displayActionStatus($method, $arguments)
    {
        return call_user_func_array(array($this, $method), $arguments);
    }
    
    /**
     * Set the view renderer's script action
     * 
     * @param string $action
     * @param null|boolean|string $status
     * @return self
     */
    protected function setScriptAction($action, $status)
    {
        $scriptAction = $this->formatScriptAction($action, $status);
        $this->getViewRenderer()->setScriptAction($scriptAction);
        return $this;
    }
    
    /**
     * Template method for behaviour when a display method could not be found.
     * 
     * @param string $action
     * @param type $status 
     */
    protected function displayMethodNotFound($action, $status)
    {}

    /**
     * Template method ran before display
     *
     * @return void
     */
    public function preDisplay()
    {}

    /**
     * Template method ran after display
     *
     * @return void
     */
    public function postDisplay()
    {}
    
    /**
     * @param string $action
     * @param string $status
     * @return array methods
     */
    public function getDisplayMethods($action, $status)
    {
        $action = ucfirst($action);
        $status = ucfirst($status);

        return array(
            'display' . $action . $status,
            'display' . $action
        );
    }
    
    /**
     * Retrieve the view script's action component based on action name and
     * status
     *
     * @param string $action
     * @param string $status
     * @return string
     */
    protected function formatScriptAction($action, $status)
    {
        if (null === $status) {
            return $action;
        }
        return sprintf($this->scriptActionFormat, $action, $status);
    }

    /**
     * Format status value as a string
     *
     * @param string|boolean|null
     * @return string|null
     * @throws UnexpectedValueException on unsupported status type
     */
    public function statusToString($status)
    {
        if (is_string($status)) {
            return strlen($status) ? $status : null;
        }

        switch (true) {
            case null === $status:  return null;
            case true == $status;   return $this->successStatusString;
            case false == $status:  return $this->failureStatusString;
        }

        $error = sprintf("Invalid action status provided: null, boolean or string expected, %s given.", gettype($status));
        throw new UnexpectedValueException($error);
    }
}