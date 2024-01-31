<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Game>
 *
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $by, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $by, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function search(array $params): array
    {
        $query = $this->createQueryBuilder('g')
            ->leftJoin('g.gamesPlayed', 'gp')
            ->where('g.isVisible = :isVisible')
            ->setParameter('isVisible', $params['isVisible']);

        if (!empty($params['title'])) {
            $query->where('g.title LIKE :title')
                  ->setParameter('title', '%' . $params['title'] . '%');
        }

        if (!empty($params['categories']) && !$params['categories']->isEmpty()) {
            $categoryQueries = [];

            foreach ($params['categories'] as $category) {
                $categoryQueries[] = "(c.label = '" . $category->getLabel() . "')";
            }

            $categoryQuery = implode(' OR ', $categoryQueries);

            $query->join('g.categories', 'c');
            $query->andWhere($categoryQuery);
        }

        if (!empty($params['sort_by']) && !empty($params['sort_order'])) {
            $query->orderBy('g.' . $params['sort_by'], $params['sort_order']);
        }

        $query
            ->addSelect('SUM(gp.duration) AS totalTimePlayed');

        if (!empty($params['userId'])) {
            $query
                ->andWhere('gp.player = :userId')
                ->setParameter('userId', $params['userId'])
                ->groupBy('gp.player.id');
        }

        $query
            ->groupBy('g.id')
            ->addOrderBy('g.id', 'DESC');

        $games = $query->getQuery()->getResult();

        return $games;
    }
}
