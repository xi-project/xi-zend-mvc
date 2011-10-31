<?php
namespace Xi\Zend\Mvc\Service;

/**
 * A service base class associated with a Doctrine EntityManager
 */
class DoctrineService implements \Xi\Zend\Mvc\Service
{
    /**
     * The Doctrine entity manager.
     * 
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;
    
    /**
     * @param DependencyInjection\DoctrineServiceLocator $serviceLocator
     */
    public function __construct($serviceLocator)
    {
        $this->em = $serviceLocator->getEntityManager();
    }
    
    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->em;
    }
}
