<?php

namespace App\Repository;

use App\Entity\RendezVous;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * @extends ServiceEntityRepository<RendezVous>
 *
 * @method RendezVous|null find($id, $lockMode = null, $lockVersion = null)
 * @method RendezVous|null findOneBy(array $criteria, array $orderBy = null)
 * @method RendezVous[]    findAll()
 * @method RendezVous[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RendezVousRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RendezVous::class);
    }

    public function save(RendezVous $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RendezVous $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return RendezVous[] Returns an array of RendezVous objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RendezVous
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function getByDate(\Datetime $date)
{
    $from = new \DateTime($date->format("Y-m-d ")."00:00:00");
    $to   = new \DateTime($date->format("Y-m-d")." 23:59:59");

    $qb = $this->createQueryBuilder("e");
    $qb
        ->andWhere('e.date BETWEEN :from AND :to')
        ->setParameter('from', $from )
        ->setParameter('to', $to)
    ;
    $result = $qb->getQuery()->getResult();

    return $result;
}
public function gettoday(\Datetime $date)
{
    $from = new \DateTime($date->format("Y-m-d H:i").":00");
    $to   = new \DateTime($date->format("Y-m-d")." 23:59:59");

    $qb = $this->createQueryBuilder("e");
    $qb
        ->andWhere('e.date BETWEEN :from AND :to')
        ->setParameter('from', $from )
        ->setParameter('to', $to)
    ;
    $result = $qb->getQuery()->getResult();

    return $result;
}
    public function getPending(\Datetime $date)
{
    $from = new \DateTime($date->format("Y-m-d")." 23:59:59");
    $qb = $this->createQueryBuilder("e");
    $qb
        ->andWhere('e.date > =:from ')
        ->setParameter('from', $from )
        ;
    $result = $qb->getQuery()->getResult();

    return $result;
}

}
