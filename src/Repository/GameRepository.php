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
            ->join('g.categories', 'category');

        if (!empty($params['title'])) {
            $query
                ->where('g.title LIKE :title')
                ->setParameter('title', '%' . $params['title'] . '%');
        }

        if (!empty($params['categories']) && !$params['categories']->isEmpty()) {
            $categoryQueries = [];

            foreach ($params['categories'] as $category) {
                $categoryQueries[] = "(category.label = '" . $category->getLabel() . "')";
            }

            $categoryQuery = implode(' OR ', $categoryQueries);
            $query->andWhere($categoryQuery);
        }

        if (!empty($params['sort_by']) && !empty($params['sort_order'])) {
            $query->orderBy('g.' . $params['sort_by'], $params['sort_order']);
        }

        $query->addOrderBy('g.id', 'ASC');

        return $query->getQuery()->getResult();
    }
}
