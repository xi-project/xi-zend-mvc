<?php
namespace Xi\Zend\Mvc\Action\Helper;

class ViewRenderer extends \Zend_Controller_Action_Helper_ViewRenderer
{
    protected function _generateDefaultPrefix()
    {
        if (null === $this->_actionController) {
            return parent::_generateDefaultPrefix();
        }
        
        $class = get_class($this->_actionController);
        
        $matches = array();
        if (preg_match('/^(.+)\\\\Controller\\\\[^\\\\]+$/', $class, $matches)) {
            $module = $matches[1];
            return $module . '\\View';
        } else {
            return parent::_generateDefaultPrefix();
        }
    }
}