<?php

namespace App\Repository;

use App\Entity\CabinCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CabinCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method CabinCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method CabinCategory[]    findAll()
 * @method CabinCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CabinCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CabinCategory::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(CabinCategory $entity, bool $flush = true): void
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
    public function remove(CabinCategory $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    /**
     * get category by companyId and boatId
     * @param $compagnie_id
     * @param $bateau_id
     * @return float|int|mixed|string
     */

    public function findByCompanyIdAndBoatId($compagnie_id, $bateauId, $lang)
    {
        return $this->createQueryBuilder('c')
            ->where('c.compagnie_id = :compagnie_id')
            ->andWhere('c.bateauId = :bateauId')
            ->andWhere('c.langue = :lang')
            ->setParameter('compagnie_id', $compagnie_id, )
            ->setParameter('bateauId', $bateauId)
            ->setParameter('lang', $lang)
            ->orderBy('c.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;

    }

    // /**
    //  * @return CabinCategory[] Returns an array of CabinCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CabinCategory
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
