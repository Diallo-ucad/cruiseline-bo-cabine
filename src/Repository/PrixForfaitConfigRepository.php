<?php

namespace App\Repository;

use App\Entity\PrixForfaitConfig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PrixForfaitConfig|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrixForfaitConfig|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrixForfaitConfig[]    findAll()
 * @method PrixForfaitConfig[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrixForfaitConfigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PrixForfaitConfig::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(PrixForfaitConfig $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(PrixForfaitConfig $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    public function findByForfaitConfig($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.forfaitConfig = :forfaitConfig')
            ->setParameter('forfaitConfig', $value)
            ->orderBy('p.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }



    // /**
    //  * @return PrixForfaitConfig[] Returns an array of PrixForfaitConfig objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PrixForfaitConfig
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
