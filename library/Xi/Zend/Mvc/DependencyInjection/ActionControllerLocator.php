<?php
namespace Xi\Zend\Mvc\DependencyInjection;

use Xi\Zend\Mvc\Service,
    Xi\Zend\Mvc\Presenter;

/**
 * A service locator that provides the ActionController its default component
 * dependencies, the Service and Presenter. Will also create separate locators
 * for the Service and Presenter to consume.
 */
class ActionControllerLocator extends AbstractActionControllerServiceLocator
{
    /**
     * Override this to set a default service class name that will be used in
     * case the autodiscovered one does not exist.
     * 
     * @var string fully qualified class name
     */
    protected $defaultServiceClass = 'Xi\Zend\Mvc\Service\DoctrineService';
    
    /**
     * Override this to set a default presenter class name that will be used in
     * case the autodiscovered one does not exist.
     * 
     * @var string fully qualified class name
     */
    protected $defaultPresenterClass = 'Xi\Zend\Mvc\Presenter\ZendViewPresenter';
    
    /**
     * @var string fully qualified class name
     */
    protected $serviceLocatorClass = 'Xi\Zend\Mvc\DependencyInjection\DoctrineServiceLocator';
    
    /**
     * @var string fully qualified class name
     */
    protected $presenterLocatorClass = 'Xi\Zend\Mvc\DependencyInjection\ZendViewPresenterLocator';
    
    public function init()
    {
        parent::init();
        $c = $c;
        
        $c['serviceLocatorClass'] = $this->serviceLocatorClass;
        $c['presenterLocatorClass'] = $this->presenterLocatorClass;
        $c['defaultServiceClass'] = $this->defaultServiceClass;
        $c['defaultPresenterClass'] = $this->defaultPresenterClass;
        
        $c['actionControllerLocator'] = $this;
        $c['serviceLocator'] = function($c) {
            $class = $c['serviceLocatorClass'];
            return new $class($c['actionController']);
        };
        $c['presenterLocator'] = function($c) {
            $class = $c['presenterLocatorClass'];
            return new $class($c['actionController']);
        };
        
        $c['serviceClass'] = function($c) {
            return $c['actionControllerLocator']->pickBetweenClasses(
                $c['actionController']->getServiceClassName(),
                $c['defaultServiceClass']
            );
        };
        $c['presenterClass'] = function($c) {
            return $c['actionControllerLocator']->pickBetweenClasses(
                $c['actionController']->getPresenterClassName(),
                $c['defaultPresenterClass']
            );
        };
        
        $c['service'] = $c->share(function($c) {
            $class = $c['serviceClass'];
            return new $class($c['serviceLocator']);
        });
        $c['presenter'] = $c->share(function($c) {
            $class = $c['presenterClass'];
            return new $class($c['presenterLocator']);
        });
    }
    
    /**
     * Accepts two fully qualified class names and returns the former unless it
     * doesn't exist and there's a default declared.
     * 
     * NOTE: For use by container resources. Should be protected but isn't due
     * to PHP 5.3 scoping issues.
     * 
     * @param string $implicit
     * @param string $default 
     * @return string
     */
    public function pickBetweenClasses($implicit, $default)
    {
        if (!class_exists($implicit) && (null !== $default)) {
            return $default;
        }
        return $implicit;
    }
    
    /**
     * Retrieve the Service instance related to the associated ActionController
     * or a default Service if one does not exist.
     * 
     * @return Service
     */
    public function getService()
    {
        return $this->container['service'];
    }
    
    /**
     * Retrieve the Presenter instance related to the associated ActionController
     * or a default Presenter if one does not exist.
     * 
     * @return Presenter
     */
    public function getPresenter()
    {
        return $this->container['presenter'];
    }
}