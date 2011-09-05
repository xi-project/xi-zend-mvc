<?php
namespace Xi\Zend\Mvc\Service;

/**
 * A somewhat convenient service base class.
 */
abstract class AbstractService
{
    /**
     * The Doctrine entity manager.
     * 
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;
    
    public function __construct(DefaultServiceLocator $sl) {
        $this->em = $sl->getEntityManager();
    }
}
