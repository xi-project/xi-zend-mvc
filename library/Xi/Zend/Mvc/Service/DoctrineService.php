<?php
namespace Xi\Zend\Mvc\Service;

/**
 * A service base class associated with a Doctrine EntityManager
 */
class DoctrineService implements \Xi\Zend\Mvc\Service
{
    /**
     * This constant is used by ActionControllerLocator to discover a suitable
     * locator for this class. The locator will be provided as a constructor
     * argument.
     */
    const LOCATOR = 'Xi\Zend\Mvc\DependencyInjection\DoctrineServiceLocator';
    
    /**
     * @var DependencyInjection\DoctrineServiceLocator
     */
    private $serviceLocator;
    
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
        $this->serviceLocator = $serviceLocator;
        $this->em = $serviceLocator->getEntityManager();
    }
    
    /**
     * @return DependencyInjection\DoctrineServiceLocator 
     */
    protected function getServiceLocator()
    {
        return $this->serviceLocator;
    }
    
    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->em;
    }
    
    /**
     * @return void
     */
    protected function init()
    {
    }
}
