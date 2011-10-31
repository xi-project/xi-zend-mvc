<?php
namespace Xi\Zend\Mvc\Service;

use Doctrine\ORM\EntityRepository;

/**
 * Extends DoctrineService with EntityRepository convenience methods
 */
class DoctrineRepositoryService extends DoctrineService
{
    /**
     * @var string entity class name recognized by Doctrine
     */
    protected $entityName;
    
    /**
     * @return EntityRepository
     */
    protected function getEntityRepository()
    {
        return $this->getEntityManager()->getRepository($this->entityName);
    }
}
