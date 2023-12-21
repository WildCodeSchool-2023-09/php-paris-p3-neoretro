<?php

namespace App\Repository;

use App\Entity\GamePicture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GamePicture>
 *
 * @method GamePicture|null find($id, $lockMode = null, $lockVersion = null)
 * @method GamePicture|null findOneBy(array $criteria, array $orderBy = null)
 * @method GamePicture[]    findAll()
 * @method GamePicture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GamePictureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GamePicture::class);
    }

//    /**
//     * @return GamePicture[] Returns an array of GamePicture objects
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

//    public function findOneBySomeField($value): ?GamePicture
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
