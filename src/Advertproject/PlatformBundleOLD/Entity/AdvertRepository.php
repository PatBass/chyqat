<?php

namespace Advertproject\PlatformBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * AdvertRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdvertRepository extends EntityRepository
{
    public function getAdverts($page, $nbPerPage)
    {
        $qb = $this
            ->createQueryBuilder('a')
            ->leftJoin('a.image', 'i')
            ->addSelect('i')
            ->leftJoin('a.categories', 'c')
            ->addSelect('c')
            ->orderBy('a.date', 'DESC')
        ;
        $query = $qb -> getQuery();

        $query
            -> setFirstResult(($page - 1)* $nbPerPage)
            -> setMaxResults($nbPerPage)
        ;

        return new Paginator($query, true);
    }

    public function getAdvertWithApplications()
    {
        $qb = $this
            -> createQueryBuilder('a')
            -> leftJoin('a.applications', 'app')
            -> addSelect('app')
        ;

        return $qb
            -> getQuery()
            -> getResult()
        ;
    }

    public function getAdvertWithCategories(array $categoryNames)
    {
        $qb = $this
            -> createQueryBuilder('a')
            -> join('a.categories', 'c')
            -> addSelect('c')
        ;

        $qb->where($qb -> expr()-> in('c.name', $categoryNames));

        return $qb
            -> getQuery()
            -> getResult()
        ;
    }

    public function getApplicationsWithAdvert($limit)
    {
        $qb = $this
            -> createQueryBuilder('a')
            -> join('a.advert', 'adv')
            -> addSelect('adv')
        ;

        $qb -> setMaxResults($limit);

        return $qb
            -> getQuery()
            -> getResult()
        ;
    }

    public function getPublishedQueryBuilder()
    {
        return $this
            -> createQueryBuilder('a')
            -> where('a.published = :published')
            -> setParameter('published', true)
        ;
    }

    public function findAdvertsWithNoApplicationAndBefore(\Datetime $date)
    {
        $qb = $this
            -> createQueryBuilder('a')
            -> where('a.updatedAt < :date')
            -> orWhere('a.updatedAt IS NULL AND a.date < :date')
            -> andWhere('a.applications IS EMPTY')
            -> setParameter('date', $date)
        ;
        return $qb
            -> getQuery()
            -> getResult()
        ;
    }
}
