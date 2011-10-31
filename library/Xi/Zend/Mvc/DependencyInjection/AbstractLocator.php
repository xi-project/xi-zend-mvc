<?php
namespace Xi\Zend\Mvc\DependencyInjection;

use Pimple;

/**
 * An abstract implementation of the Service Locator pattern. Provides a bundle
 * of dependencies for other classes to consume.
 * 
 * This gets passed to constructors of Services and other classes
 * that need dependencies. Services shall receive dependencies ONLY through
 * this class and NEVER through globals or static methods.
 * 
 * This class is meant to be subclassed and filled with getters for all kinds
 * of useful things. The getters should provide type information.
 * 
 * The implementations of the getters should just retrieve their artifacts
 * from the Pimple container. The container should be initialized
 * in init(). See http://pimple.sensiolabs.org/ for inspiration on how
 * to set up the container.
 */
class AbstractLocator
{
    /**
     * @var Pimple
     */
    protected $container;
    
    public function __construct(Pimple $container = null)
    {
        $this->container = (null === $container) ? new Pimple : $container;
        $this->init($this->container);
    }
    
    /**
     * Inserts things (or functions to create the things) exposed by getters.
     * 
     * @param Pimple $container the container for this locator
     */
    public function init($container)
    {
    }
}