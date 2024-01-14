<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Game>
 *
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
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
            ->join('g.categories', 'category')
            ->where('g.title LIKE :title')
            ->setParameter('title', '%' . $params['title'] . '%');

        if (!empty($params['category'])) {
            $categoryQueries = [];
            foreach ($params['category'] as $category) {
                $categoryQueries[] = "(category.label = '" . $category . "')";
            }
            $categoryQuery = implode(' OR ', $categoryQueries);
            $query->andWhere($categoryQuery);
        }

        if (!empty($params['sort'])) {
            $query->orderBy($params['sort']['criteria'], $params['sort']['order']);
        }
        $query->addOrderBy('g.title', 'ASC');

        $query = $query->getQuery();
        return $query->getResult();
    }
}
