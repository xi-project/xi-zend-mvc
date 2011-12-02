<?php
namespace Xi\Zend\Mvc;

use Zend_Controller_Dispatcher_Standard,
    Zend_Controller_Request_Abstract;

class ControllerDispatcher extends Zend_Controller_Dispatcher_Standard
{
    /**
     * Returns TRUE if the Zend_Controller_Request_Abstract object can be
     * dispatched to a controller.
     *
     * Use this method wisely. By default, the dispatcher will fall back to the
     * default controller (either in the module specified or the global default)
     * if a given controller does not exist. This method returning false does
     * not necessarily indicate the dispatcher will not still dispatch the call.
     *
     * @param Zend_Controller_Request_Abstract $action
     * @return boolean
     */
    public function isDispatchable(Zend_Controller_Request_Abstract $request)
    {
        $className = $this->getFullyQualifiedControllerClass($request);
        
        return $className && class_exists($className);
    }
    
    /**
     * Attempts to retrieve the fully qualified controller name for the provided
     * request.
     * 
     * @param Zend_Controller_Request_Abstract $request
     * @return string
     */
    public function getFullyQualifiedControllerClass(Zend_Controller_Request_Abstract $request)
    {
        return $this->asFullyQualifiedClassName(parent::getControllerClass($request));
    }
    
    /**
     * Attempts to retrieve the fully qualified default controller name for the
     * provided request.
     *
     * @param Zend_Controller_Request_Abstract $request
     * @return string
     */
    public function getDefaultControllerClass(Zend_Controller_Request_Abstract $request)
    {
        return $this->asFullyQualifiedClassName(parent::getDefaultControllerClass($request));
    }
    
    /**
     * @param string|false $className
     * @return string|false
     */
    protected function asFullyQualifiedClassName($className)
    {
        if (!$className) {
            return false;
        }
        
        return $this->formatClassName($this->_curModule, $className);
    }
    

    /**
     * Format action class name
     *
     * @param string $moduleName Name of the current module
     * @param string $className Name of the action class
     * @return string Formatted class name
     */
    public function formatClassName($moduleName, $className)
    {
        return sprintf("%s\\%s\\%s",
                $moduleName,
                $this->getModuleControllerDirectoryName(),
                $className);
    }
    
    /**
     * @return string
     */
    protected function getModuleControllerDirectoryName()
    {
        return $this->getFrontController()->getModuleControllerDirectoryName();
    }

    /**
     * Format the module name.
     *
     * @param string $unformatted
     * @return string
     */
    public function formatModuleName($unformatted)
    {
        return ucfirst($this->_formatName($unformatted)."Module");
    }

    /**
     * Formats a string from a URI into a PHP-friendly name.
     *
     * By default, replaces words separated by the word separator character(s)
     * with camelCaps. If $isAction is false, it also preserves replaces words
     * separated by the path separation character with an underscore, making
     * the following word Title cased. All non-alphanumeric characters are
     * removed.
     *
     * @param string $unformatted
     * @param boolean $isAction Defaults to false
     * @return string
     */
    protected function _formatName($unformatted, $isAction = false)
    {
        // preserve directories
        if (!$isAction) {
            $segments = explode($this->getPathDelimiter(), $unformatted);
        } else {
            $segments = (array) $unformatted;
        }

        foreach ($segments as $key => $segment) {
            $segment        = str_replace($this->getWordDelimiter(), ' ', strtolower($segment));
            $segment        = preg_replace('/[^a-z0-9 ]/', '', $segment);
            $segments[$key] = str_replace(' ', '', ucwords($segment));
        }

        return implode('\\', $segments);
    }

    /**
     * Add a single path to the controller directory stack
     *
     * @param string $path
     * @param string $module
     * @return Zend_Controller_Dispatcher_Standard
     */
    public function addControllerDirectory($path, $module = null)
    {
        if (null !== $module) {
            $module = $this->formatModuleName($module);
        }
        return parent::addControllerDirectory($path, $module);
    }
}