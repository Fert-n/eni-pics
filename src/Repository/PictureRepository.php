<?php

namespace App\Repository;

use App\Entity\Picture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Picture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Picture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Picture[]    findAll()
 * @method Picture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PictureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Picture::class);
    }

    // /**
    //  * @return Picture[] Returns an array of Picture objects
    //  */

    public function findPictureByTagName(?string $name, array $ordersBy = [], int $limit = 30)
    {
        if (!$name) {
            return $this->findBy([], $ordersBy, $limit);
        }

        $queryBuilder = $this->createQueryBuilder('p')
            ->join('p.tags','t')
            ->andWhere('t.name = :name')
            ->setParameters([
                'name' => $name
            ])
        ;

        foreach ($ordersBy as $field => $name) {
            $queryBuilder->addOrderBy('p.'.$field, $name);
        }

        return $queryBuilder
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Picture
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
