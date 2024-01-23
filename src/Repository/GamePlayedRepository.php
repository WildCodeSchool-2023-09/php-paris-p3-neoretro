<?php

namespace App\Repository;

use App\Entity\GamePlayed;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GamePlayed>
 *
 * @method GamePlayed|null find($id, $lockMode = null, $lockVersion = null)
 * @method GamePlayed|null findOneBy(array $criteria, array $orderBy = null)
 * @method GamePlayed[]    findAll()
 * @method GamePlayed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GamePlayedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GamePlayed::class);
    }

    public function findByPlayer(int $userId): array
    {
        // return $this
        //     ->createQueryBuilder('gp')
        //     ->where('player = :id')
        //     ->orderBy('')
        //     ->getQuery()
        //     ->getResult();
        return [];
    }

//    /**
//     * @return GamePlayed[] Returns an array of GamePlayed objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GamePlayed
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
