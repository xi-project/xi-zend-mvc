<?php
namespace Xi\Zend\Mvc;

use Zend_Controller_Front,
    Zend_Controller_Exception,
    Zend_Controller_Dispatcher_Interface,
    Exception,
    DirectoryIterator;

/**
 * Alters default FrontController behaviour to scan modules directories for
 * PHP 5.3 namespace support
 */
class FrontController extends Zend_Controller_Front
{
    /**
     * Singleton instance.
     *
     * @return Zend_Controller_Front
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
    
    /**
     * Specify a directory as containing modules
     *
     * Iterates through the directory, adding any subdirectories as modules;
     * the subdirectory within each module named after {@link $_moduleControllerDirectoryName}
     * will be used as the controller directory path.
     *
     * @param  string $path
     * @return Zend_Controller_Front
     */
    public function addModuleDirectory($path)
    {
        try{
            $dir = new DirectoryIterator($path);
        } catch(Exception $e) {
            throw new Zend_Controller_Exception("Directory $path not readable", 0, $e);
        }
        
        foreach ($dir as $file) {
            if ($file->isDot() || !$file->isDir()) {
                continue;
            }

            $module = $this->getModuleName($file);

            // Don't use SCCS directories as modules
            if (preg_match('/^[^a-z]/i', $module) || ('CVS' == $module)) {
                continue;
            }

            $moduleDir = $file->getPathname() . DIRECTORY_SEPARATOR . $this->getModuleControllerDirectoryName();
            $this->addControllerDirectory($moduleDir, $module);
        }

        return $this;
    }
    
    /**
     * Assumes the file to be a reference to a module root folder called
     * <Name>Module. Returns the <Name> part.
     * 
     * @param \SplFileInfo $file
     * @return string
     */
    protected function getModuleName($file)
    {
        return lcfirst(current(sscanf($file->getFilename(), "%[^M]Module")));
    }

    /**
     * Return the dispatcher object. Overridden to default to Xi's
     * ControllerDispatcher.
     *
     * @return Zend_Controller_Dispatcher_Interface
     */
    public function getDispatcher()
    {
        /**
         * Instantiate the default dispatcher if one was not set.
         */
        if (!$this->_dispatcher instanceof Zend_Controller_Dispatcher_Interface) {
            $this->_dispatcher = new ControllerDispatcher();
        }
        return $this->_dispatcher;
    }
}