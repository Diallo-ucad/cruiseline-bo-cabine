<?php

namespace App\Repository;

use App\Entity\ForfaitTypeTraductions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ForfaitTypeTraductions>
 *
 * @method ForfaitTypeTraductions|null find($id, $lockMode = null, $lockVersion = null)
 * @method ForfaitTypeTraductions|null findOneBy(array $criteria, array $orderBy = null)
 * @method ForfaitTypeTraductions[]    findAll()
 * @method ForfaitTypeTraductions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForfaitTypeTraductionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ForfaitTypeTraductions::class);
    }

    public function add(ForfaitTypeTraductions $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ForfaitTypeTraductions $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ForfaitTypeTraductions[] Returns an array of ForfaitTypeTraductions objects
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

//    public function findOneBySomeField($value): ?ForfaitTypeTraductions
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
