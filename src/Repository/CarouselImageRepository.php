<?php

namespace App\Repository;

use App\Entity\CarouselImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CarouselImage>
 */
class CarouselImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarouselImage::class);
    }

    public function findCarouselImage() : array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.isPublished = :published')
            ->setParameter('published', true)
            ->orderBy('c.orderImage', 'ASC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
            ;
    }

    //    /**
    //     * @return CarouselImage[] Returns an array of CarouselImage objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?CarouselImage
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
