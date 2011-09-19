<?php
namespace Xi\Zend\Mvc\DependencyInjection;

use Zend_Application_Bootstrap_Bootstrap as Bootstrap,
    Xi\Zend\Mvc\Service,
    \Xi\Zend\Mvc\ActionController\ServicefulActionController;

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
        return new $class($this);
    }
}