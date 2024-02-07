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

    public function findGlobalBestScoresByGame(int $gameId, int $limit = null): array
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

    public function findPersonalBestScoreByGame(int $gameId, int $userId): ?array
    {
        return $this
            ->createQueryBuilder('gp')
            ->select('gp.score')
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

    public function findTotalTimePlayed(int $gameId, int $userId): ?array
    {
        return $this
            ->createQueryBuilder('gp')
            ->select('SUM(gp.duration) AS totalTimePlayed')

            ->andWhere('gp.game = :game')
            ->andWhere('gp.player = :user')
            ->setParameter('game', $gameId)
            ->setParameter('user', $userId)

            ->getQuery()
            ->getOneOrNullResult();
    }
}
