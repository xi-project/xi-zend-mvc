<?php
namespace Xi\Zend\Mvc\ActionDispatcher;

use Xi\Zend\Mvc\ActionController;

abstract class AbstractActionDispatcher implements ActionDispatcher
{
    /**
     * @var ActionController
     */
    private $actionController;
    
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
     * @return \Zend_Controller_Request_Abstract
     */
    protected function getRequest()
    {
        return $this->getActionController()->getRequest();
    }
}