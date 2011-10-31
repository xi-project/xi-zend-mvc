<?php
namespace Xi\Zend\Mvc\DependencyInjection;

use Zend_Application_Bootstrap_Bootstrap as Bootstrap;

/**
 * Provides Doctrine-related dependencies to a DoctrineService
 */
class DoctrineServiceLocator extends AbstractActionControllerServiceLocator
{
    public function init()
    {
        $this->container['bootstrap'] = $this->container->share(function($c) {
            return $c['actionController']->getInvokeArg('bootstrap');
        });
        $this->container['doctrineBootstrapResource'] = $this->container->share(function($c) {
            return $c['bootstrap']->getResource('doctrine');
        });
        $this->container['entityManager'] = $this->container->share(function($c) {
            return $c['doctrineBootstrapResource']->getEntityManager();
        });
    }
    
    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->container['entityManager'];
    }
}