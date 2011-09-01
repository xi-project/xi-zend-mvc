<?php
namespace Xi\Zend\Mvc\ActionController;

use Xi\Zend\Mvc\ActionDispatcher\StandardActionDispatcher;

/**
 * Implements the standard Zend_Controller_Action behaviour using an
 * ActionDispatcher. Included here for completeness; should probably not be used
 * for other than legacy and/or backwards compatibility reasons.
 */
class StandardActionController extends AbstractActionController
{
    /**
     * @return StandardActionDispatcher 
     */
    protected function getDefaultActionDispatcher()
    {
        return new StandardActionDispatcher($this);
    }
}