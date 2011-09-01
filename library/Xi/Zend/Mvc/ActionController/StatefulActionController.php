<?php
namespace Xi\Zend\Mvc\ActionController;

use Xi\Zend\Mvc\ActionDispatcher\StatefulActionDispatcher;

/**
 * An ActionController that can communicate a resulting state from an action.
 * Uses a StatefulActionDispatcher to allow setting the state based on the 
 * return value from the action.
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
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }
    
    /**
     * @return null|boolean|string
     */
    public function getState()
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