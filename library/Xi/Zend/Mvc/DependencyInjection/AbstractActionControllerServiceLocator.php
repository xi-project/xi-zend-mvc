<?php
namespace Xi\Zend\Mvc\DependencyInjection;

use Xi\Zend\Mvc\ActionController;

abstract class AbstractActionControllerServiceLocator extends AbstractLocator
{
    /**
     * @var ActionController
     */
    private $actionController;
    
    public function __construct(ActionController $actionController)
    {
        $this->actionController = $actionController;
        parent::__construct();
    }
    
    public function init($c)
    {
        $c['actionController'] = $this->actionController;
    }
}