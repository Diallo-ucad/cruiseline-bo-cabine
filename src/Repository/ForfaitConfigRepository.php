<?php

declare(strict_types=1);
namespace App\Repository;

use App\Entity\ForfaitConfig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ForfaitConfig>
 *
 * @method ForfaitConfig|null find($id, $lockMode = null, $lockVersion = null)
 * @method ForfaitConfig|null findOneBy(array $criteria, array $orderBy = null)
 * @method ForfaitConfig[]    findAll()
 * @method ForfaitConfig[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForfaitConfigRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, ForfaitConfig::class);
	}

	public function add(ForfaitConfig $entity, bool $flush = false): void
	{
		$this->getEntityManager()->persist($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

    public function addAll(ForfaitConfig $entity, bool $flush = false)
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
        return $entity->getId();
    }

	public function remove(ForfaitConfig $entity, bool $flush = false): void
	{
		$this->getEntityManager()->remove($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}



    public function findOneByAllFields($portId, $companyId, $boatId, $categoryId, $typeCabineId): array
    {
        return $this->createQueryBuilder('f')
            ->where('f.bateau_id = :boatId')
            ->andWhere('f.port_id = :portId')
            ->andWhere('f.companyId = :companyId')
            ->andWhere('f.cabinCategory = :cabinCategory')
            ->andWhere('f.cabinType = :cabinType')
            ->setParameter('boatId', $boatId)
            ->setParameter('portId', $portId)
            ->setParameter('companyId', $companyId)
            ->setParameter('cabinCategory', $categoryId)
            ->setParameter('cabinType', $typeCabineId)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
       ;
   }

	//    /**
//     * @return ForfaitConfig[] Returns an array of ForfaitConfig objects
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

//    public function findOneBySomeField($value): ?ForfaitConfig
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
