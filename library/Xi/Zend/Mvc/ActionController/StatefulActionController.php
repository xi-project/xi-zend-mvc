<?php
namespace Xi\Zend\Mvc\ActionController;

use Xi\Zend\Mvc\ActionDispatcher\StatefulActionDispatcher;

/**
 * An ActionController that can communicate a resulting state from an action.
 * Uses a StatefulActionDispatcher to allow setting the state based on the 
 * return value from the action.
 */
interface StatefulActionController
{
    /**
     * @param null|boolean|string $status
     * @return StatefulActionController
     */
    public function setStatus($status);
    
    /**
     * @return null|boolean|string
     */
    public function getStatus();
    
    /**
     * @return StatefulActionDispatcher 
     */
    public function getActionDispatcher();
}