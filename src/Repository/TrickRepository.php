<?php

namespace App\Repository;

use App\Entity\Trick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Trick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trick[]    findAll()
 * @method Trick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trick::class);
    }

	/**
	 * Récupère toutes les figures.
	 *
	 * @param $start
	 * @param $end
	 *
	 * @return Trick[]
	 */
    public function trickPagination(int $start,int $end): array
    {
    	return $this->createQueryBuilder('t')
		    ->setFirstResult($start)
		    ->setMaxResults($end)
		    ->orderBy('t.create_at', 'DESC')
		    ->getQuery()
		    ->getResult()
		    ;
    }

    public function numberTotalTricks()
    {
    	return $this->createQueryBuilder('t')
    	    ->select('count(t)')
	        ->getQuery()
		    ->getSingleScalarResult();

    }

    // /**
    //  * @return Trick[] Returns an array of Trick objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Trick
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
