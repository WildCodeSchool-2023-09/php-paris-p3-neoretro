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

    public function findBestScoresByGame(int $gameId, int $limit = null): array
    {
        $subQuery = $this
            ->createQueryBuilder('sub')
            ->select('MAX(sub.score)')
            ->andWhere('sub.player = gp.player')
            ->andWhere('sub.game = :gameId')
            ->getDQL();

        $query = $this
            ->createQueryBuilder('gp')
            ->join('gp.game', 'g')
            ->where('g.id = :gameId')
            ->setParameter('gameId', $gameId)
            ->groupBy('gp.player', 'g.id', 'gp.id')
            ->having('gp.score = (' . $subQuery . ')')
            ->orderBy('gp.score', 'DESC');

        if ($limit) {
            $query->setMaxResults($limit);
        }

        return $query
            ->getQuery()
            ->getResult();
    }

    public function findBestGamesScoresByUser(int $userId, int $limit = null): array
    {
        $subQuery = $this
            ->createQueryBuilder('sub')
            ->select('MAX(sub.score)')
            ->andWhere('sub.player = :userId')
            ->andWhere('sub.game = gp.game')
            ->getDQL();

        $query = $this
            ->createQueryBuilder('gp')
            ->innerJoin('gp.game', 'g')
            ->where('gp.player = :userId')
            ->setParameter('userId', $userId)
            ->groupBy('gp.game', 'gp.id', 'g.id')
            ->having('gp.score = (' . $subQuery . ')')
            ->orderBy('gp.score', 'DESC');

        if ($limit) {
            $query->setMaxResults($limit);
        }

        return $query
            ->getQuery()
            ->getResult();
    }

    public function findPersonalBestByGame(int $userId, int $gameId): ?GamePlayed
    {
        return $this
            ->createQueryBuilder('gp')
            ->andWhere('gp.player = :userId')
            ->andWhere('gp.game = :gameId')
            ->setParameter('userId', $userId)
            ->setParameter('gameId', $gameId)
            ->orderBy('gp.score', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findGlobalBestGameScores(int $limit = 8): array
    {
        $subQuery = $this
            ->createQueryBuilder('sub')
            ->select('MAX(sub.score)')
            ->andWhere('sub.game = gp.game')
            ->getDQL();

        $query = $this
            ->createQueryBuilder('gp')
            ->innerJoin('gp.game', 'g')
            ->groupBy('gp.game', 'gp.id', 'g.id')
            ->having('gp.score = (' . $subQuery . ')')
            ->orderBy('gp.score', 'DESC');

        if ($limit) {
            $query->setMaxResults($limit);
        }

        return $query
            ->getQuery()
            ->getResult();
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
