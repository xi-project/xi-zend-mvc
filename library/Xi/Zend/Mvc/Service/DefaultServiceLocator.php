<?php
namespace Xi\Zend\Mvc\Service;

/**
 * A reasonable default service locator that provides
 * the entity manager at least. The action controller base class creates
 * one of these by default. Feel free to subclass and add lots more
 * typehinted getters.
 */
class DefaultServiceLocator extends \Xi\Zend\Mvc\DependencyInjection\AbstractServiceLocator
{
    private $bootstrap;
    
    public function __construct(\Zend_Application_Bootstrap_Bootstrap $bootstrap)
    {
        $this->bootstrap = $bootstrap;
    }
    
    public function init()
    {
        $this->container['bootstrap'] = $this->bootstrap;
        $this->container['entityManager'] = function($c) {
            return $c['bootstrap']->getResource('doctrine')->getEntityManager();
        };
    }
    
    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->container['entityManager'];
    }
}