<?php

namespace App\Repository;

use App\Entity\ForfaitTraductions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ForfaitTraductions>
 *
 * @method ForfaitTraductions|null find($id, $lockMode = null, $lockVersion = null)
 * @method ForfaitTraductions|null findOneBy(array $criteria, array $orderBy = null)
 * @method ForfaitTraductions[]    findAll()
 * @method ForfaitTraductions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForfaitTraductionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ForfaitTraductions::class);
    }

    public function add(ForfaitTraductions $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ForfaitTraductions $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ForfaitTraductions[] Returns an array of ForfaitTraductions objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ForfaitTraductions
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
