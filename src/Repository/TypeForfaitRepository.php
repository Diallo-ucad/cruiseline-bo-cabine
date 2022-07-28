<?php

declare(strict_types=1);
namespace App\Repository;

use App\Entity\TypeForfait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeForfait>
 *
 * @method TypeForfait|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeForfait|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeForfait[]    findAll()
 * @method TypeForfait[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeForfaitRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, TypeForfait::class);
	}

	public function add(TypeForfait $entity, bool $flush = false): void
	{
		$this->getEntityManager()->persist($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
			$titreTypeForfait = $entity->getTitre();
			$finalCode = (int) self::buildCode($titreTypeForfait);
			$entity->setCode($finalCode);
			$this->getEntityManager()->flush();
		}
	}

	public function remove(TypeForfait $entity, bool $flush = false): void
	{
		$this->getEntityManager()->remove($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

	/**
	 * performe code relative to selected type forfait title
	 * @param $typeForfaitTitle
	 * @return string
	 */
	public function buildCode($typeForfaitTitle)
	{
		$code = 0;
		switch ($typeForfaitTitle) {
			case 'Boissons':
				$code = 10;

				break;
			case 'Wifi':
				$code = 11;

				break;
            case 'Autre':
                $code = 13;

                break;
		    default:
			$code = 0;
	}

		return $code;
	}

	//    /**
//     * @return TypeForfait[] Returns an array of TypeForfait objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TypeForfait
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
