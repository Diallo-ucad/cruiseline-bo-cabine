<?php

declare(strict_types=1);
namespace App\Repository;

use App\Entity\CabinType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CabinType|null find($id, $lockMode = null, $lockVersion = null)
 * @method CabinType|null findOneBy(array $criteria, array $orderBy = null)
 * @method CabinType[]    findAll()
 * @method CabinType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CabinTypeRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, CabinType::class);
	}

	/**
	 * @throws ORMException
	 * @throws OptimisticLockException
	 */
	public function add(CabinType $entity, bool $flush = true): void
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
	public function remove(CabinType $entity, bool $flush = true): void
	{
		$this->_em->remove($entity);
		if ($flush) {
			$this->_em->flush();
		}
	}

	public function findByCategoryId($value)
	{
		return $this->createQueryBuilder('c')
            ->andWhere('c.CabinCategory = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
	}

	/*
	public function findOneBySomeField($value): ?CabinType
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
