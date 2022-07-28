<?php

declare(strict_types=1);
namespace App\Repository;

use App\Entity\ForfaitContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ForfaitContent>
 *
 * @method ForfaitContent|null find($id, $lockMode = null, $lockVersion = null)
 * @method ForfaitContent|null findOneBy(array $criteria, array $orderBy = null)
 * @method ForfaitContent[]    findAll()
 * @method ForfaitContent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForfaitContentRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, ForfaitContent::class);
	}

	public function add(ForfaitContent $entity, bool $flush = false): void
	{
		$this->getEntityManager()->persist($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

	public function remove(ForfaitContent $entity, bool $flush = false): void
	{
		$this->getEntityManager()->remove($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

	public function findByForfaitId($value): array
	{
		return $this->createQueryBuilder('f')
            ->andWhere('f.forfait = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            //->setMaxResults(10)
           ->getQuery()
            ->getResult()
        ;
	}

	//    /**
//     * @return ForfaitContent[] Returns an array of ForfaitContent objects
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

//    public function findOneBySomeField($value): ?ForfaitContent
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
