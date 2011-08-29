<?php
namespace Xi\Zend\Mvc;

/**
 * Overrides Zend_View's default path scheme.
 * 
 * Zend_View uses views/scripts/, views/helpers/, views/filters/,
 * but \Xi\Zend\Mvc\View uses Resources/views and ViewHelpers/.
 */
class View extends \Zend_View
{
    public function addBasePath($path, $classPrefix = 'Zend_View')
    {
        $path        = rtrim($path, '/');
        $path        = rtrim($path, '\\');
        $path       .= DIRECTORY_SEPARATOR;
        if (strpos($classPrefix, '\\') !== false) {
            $classPrefix = rtrim($classPrefix, '\\') . '\\';
        } else {
            $classPrefix = rtrim($classPrefix, '_') . '_';
        }
        
        if (strpos($path, 'Resources/views') !== false) {
            $modulePath = dirname(dirname($path));

            $this->addScriptPath($path);
            $this->addHelperPath($modulePath . 'ViewHelpers', $classPrefix . 'Helper');
            $this->addFilterPath($modulePath . 'ViewFilters', $classPrefix . 'Filter');
        } else {
            $this->addScriptPath($path . 'scripts');
            $this->addHelperPath($path . 'helpers', $classPrefix . 'Helper');
            $this->addFilterPath($path . 'filters', $classPrefix . 'Filter');
        }
        return $this;
    }
}