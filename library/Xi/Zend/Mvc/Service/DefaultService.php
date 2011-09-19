<?php
namespace Xi\Zend\Mvc\Service;

/**
 * A somewhat convenient service base class.
 */
class DefaultService implements \Xi\Zend\Mvc\Service
{
    /**
     * The Doctrine entity manager.
     * 
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;
    
    /**
     * @param DependencyInjection\ServiceLocator $serviceLocator
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
