<?php
namespace Xi\Zend\Mvc\ActionController;

use Xi\Zend\Mvc\ActionDispatcher\StatefulActionDispatcher;

/**
 * An ActionController that can communicate a resulting state from an action.
 */
class StatefulActionController extends AbstractActionController
{
    /**
     * @var null|boolean|string
     */
    private $state;
    
    /**
     * @param null|boolean|string $state
     * @return StatefulActionController
     */
    protected function setState($state)
    {
        $this->state = $state;
        return $this;
    }
    
    /**
     * @return null|boolean|string
     */
    protected function getState()
    {
        return $this->state;
    }
    
    /**
     * @return StatefulActionDispatcher 
     */
    protected function getDefaultActionDispatcher()
    {
        return new StatefulActionDispatcher($this);
    }
}