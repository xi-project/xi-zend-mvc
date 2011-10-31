<?php
namespace Xi\Zend\Mvc\DependencyInjection;

use Zend_Application_Bootstrap_Bootstrap as Bootstrap;

/**
 * Provides Doctrine-related dependencies to a DoctrineService
 */
class DoctrineServiceLocator extends AbstractActionControllerServiceLocator
{
    public function init($c)
    {
        parent::init($c);
        
        $c['bootstrap'] = $c->share(function($c) {
            return $c['actionController']->getInvokeArg('bootstrap');
        });
        $c['doctrineBootstrapResource'] = $c->share(function($c) {
            return $c['bootstrap']->getResource('doctrine');
        });
        $c['entityManager'] = $c->share(function($c) {
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