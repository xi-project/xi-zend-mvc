<?php
namespace Xi\Zend\Mvc\DependencyInjection;

use Zend_Application_Bootstrap_Bootstrap as Bootstrap,
    Xi\Zend\Mvc\Service,
    Xi\Zend\Mvc\Presenter,
    Xi\Zend\Mvc\ActionController\ServicefulActionController,
    Xi\Zend\Mvc\ActionController\PresentableActionController;

/**
 * A reasonable default service locator that provides
 * the entity manager at least. The action controller base class creates
 * one of these by default. Feel free to subclass and add lots more
 * typehinted getters.
 */
class DefaultServiceLocator extends AbstractServiceLocator
{
    /**
     * @var Bootstrap
     */
    private $bootstrap;
    
    /**
     * Override this to set a default service class name that will be used in
     * case the autodiscovered one does not exist.
     * 
     * @var string fully qualified class name
     */
    protected $defaultServiceClass;
    
    /**
     * Override this to set a default presenter class name that will be used in
     * case the autodiscovered one does not exist.
     * 
     * @var string fully qualified class name
     */
    protected $defaultPresenterClass;
    
    public function __construct(Bootstrap $bootstrap)
    {
        $this->bootstrap = $bootstrap;
        parent::__construct();
    }
    
    public function init()
    {
        $this->container['bootstrap'] = $this->bootstrap;
        $this->container['entityManager'] = $this->container->share(function($c) {
            return $c['bootstrap']->getResource('doctrine')->getEntityManager();
        });
    }
    
    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->container['entityManager'];
    }
    
    /**
     * @param ServicefulActionController $actionController
     * @return Service
     */
    public function getService(ServicefulActionController $actionController)
    {
        $class = $actionController->getServiceClassName();
        if (!class_exists($class) && (null !== $this->defaultServiceClass)) {
            $class = $this->defaultServiceClass;
        }
        return new $class($this);
    }
    
    /**
     * @param PresentableActionController $actionController
     * @return Presenter | false
     */
    public function getPresenter(PresentableActionController $actionController)
    {
        $class = $actionController->getPresenterClassName();
        if (!class_exists($class) && (null !== $this->defaultPresenterClass)) {
            $class = $this->defaultPresenterClass;
        }
        return new $class($actionController, $this);
    }
}