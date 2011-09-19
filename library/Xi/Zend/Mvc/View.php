<?php
namespace Xi\Zend\Mvc;

/**
 * Overrides Zend_View's default path scheme.
 * 
 * Zend_View uses views/scripts/, views/helpers/, views/filters/,
 * but \Xi\Zend\Mvc\View uses Resources/views and View/*Helper.
 */
class View extends \Zend_View
{
    // Zend_View requires internal variables to start with an underscore
    protected $_helperClassSuffix = array();
    
    public function init()
    {
        $this->addHelperPath(__DIR__ . '/ViewHelper', '\Xi\Zend\Mvc\ViewHelper');
    }
    
    public function addBasePath($path, $classPrefix = 'Zend_View')
    {
        $path = rtrim($path, '/');
        $path = rtrim($path, '\\');
        $path .= DIRECTORY_SEPARATOR;
        if (strpos($classPrefix, '\\') !== false) {
            $classPrefix = rtrim($classPrefix, '\\') . '\\';
        } else {
            $classPrefix = rtrim($classPrefix, '_') . '_';
        }
        
        if (strpos($path, 'Resources/views') !== false) {
            $modulePath = dirname(dirname($path)) . DIRECTORY_SEPARATOR;

            $this->addScriptPath($path);
            $this->addHelperPath($modulePath . 'View', $classPrefix);
            $this->addFilterPath($modulePath . 'View', $classPrefix);
        } else {
            $this->addScriptPath($path . 'scripts');
            $this->addHelperPath($path . 'helpers', $classPrefix . 'Helper');
            $this->addFilterPath($path . 'filters', $classPrefix . 'Filter');
        }
        return $this;
    }
    
    /**
     * Overridden to look for helpers named like "FooHelper" first.
     * Falls back to default behavior.
     */
    public function __call($name, $args)
    {
        if (!isset($this->_helperClassSuffix[$name])) {
            try {
                $this->getHelper($name . 'Helper');
                $this->_helperClassSuffix[$name] = 'Helper';
            } catch (\Zend_Loader_Exception $e) {
                $this->_helperClassSuffix[$name] = '';
            }
        }
        
        $helper = $this->getHelper($name . $this->_helperClassSuffix[$name]);
        return call_user_func_array(array($helper, $name), $args);
    }
}