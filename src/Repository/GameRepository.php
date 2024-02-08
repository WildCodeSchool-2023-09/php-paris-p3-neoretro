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
        $query = $this->createQueryBuilder('g');

        if (!empty($params)) {
            $query
                ->andWhere('g.isVisible = :isVisible')
                ->setParameter('isVisible', $params['isVisible']);

            if (isset($params['title'])) {
                $query
                    ->andWhere('g.title LIKE :title')
                    ->setParameter('title', '%' . $params['title'] . '%');
            }

            if (!empty($params['categories']) && !$params['categories']->isEmpty()) {
                $categoryQueries = [];

                foreach ($params['categories'] as $category) {
                    $categoryQueries[] =
                        "(mc.label = '" . $category->getLabel() . "' OR oc.label = '" . $category->getLabel() . "')"
                    ;
                }

                $categoryQuery = implode(' OR ', $categoryQueries);

                $query->join('g.mainCategory', 'mc');
                $query->leftJoin('g.optionalCategory', 'oc');
                $query->andWhere($categoryQuery);
            }

            if (isset($params['sort_by']) && isset($params['sort_order'])) {
                $query->orderBy('g.' . $params['sort_by'], $params['sort_order']);
            }
        } else {
            $query->andWhere('g.isVisible = 1');
        }

        $query->addOrderBy('g.id', 'DESC');

        return $query->getQuery()->getResult();
    }
}
