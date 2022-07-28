<?php

declare(strict_types=1);
namespace App\Repository;

use App\Entity\Forfait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Forfait>
 *
 * @method Forfait|null find($id, $lockMode = null, $lockVersion = null)
 * @method Forfait|null findOneBy(array $criteria, array $orderBy = null)
 * @method Forfait[]    findAll()
 * @method Forfait[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForfaitRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Forfait::class);
	}

	public function add(Forfait $entity, bool $flush = false): void
	{
		$this->getEntityManager()->persist($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
            //For updating idTypePrestation field like ('codeTypeForfait+idCompany+idForfait' => 100020001)
            $entity->setTypePrestationId(self::createPrestationId($entity));
            $this->getEntityManager()->flush();
		}
	}

	public function remove(Forfait $entity, bool $flush = false): void
	{
		$this->getEntityManager()->remove($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

	public function findByTypeForfaitId($value): array
	{
		return $this->createQueryBuilder('f')
            ->andWhere('f.type_forfait = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult();
	}

    /**
     * Function that performe to make allways four digits
     * @param $value
     * @return string
     */
    public function formatNumber($value){
        $nbDigit = strlen((string) $value);
        switch ($nbDigit){
            case 1:
                $value = "000".$value;
                break;
            case 2:
                $value = "00".$value;
                break;
            case 3:
                $value = "0".$value;
                break;
            default:
                return $value;
        }
        return $value;
    }
    /**
     * Function that allow to generate idTypePrestation used by backend developper
     * @param $entity
     * @return string
     */
    public function  createPrestationId($entity){
      $forfaitId = self::formatNumber($entity->getId());
      $companyId = self::formatNumber($entity->getCompanyId());

      //Set companyId to 3 digit only
      if(strlen($companyId) == 4){
          $companyId = substr($companyId, 1);
      }

      $codeTypeForfait =  $entity->getTypeForfait()->getCode();
      $idTypePrestation = $codeTypeForfait.$companyId.$forfaitId;

      return $idTypePrestation;
    }


    /**
     * Find forfait by TypeForfait and companyId
     * @param $typeForfait
     * @param $companyId
     * @return array
     */
    public function findByCompanyIdAndForfaitType($typeForfait, $companyId): array
    {
        return $this->createQueryBuilder('f')
            ->where('f.type_forfait = :typeForfait')
            ->andWhere('f.companyId = :companyId')
            ->setParameter('typeForfait', $typeForfait)
            ->setParameter('companyId', $companyId)
            ->orderBy('f.id', 'ASC')
            //->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
    }

//    public function findOneBySomeField($value): ?Forfait
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
