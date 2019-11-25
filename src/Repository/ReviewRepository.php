<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\AbstractQuery;

/**
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    /**
     * Calculates average score by hotelId and, optionally, dates range
     * @param $hotelId
     * @param $from
     * @param $to
     * @return int|mixed
     */
    public function getAverageScoreForHotel($hotelId, $from, $to)
    {
        try {
            $qb = $this->createQueryBuilder('r')
                ->select('avg(r.score)');
            if (!empty($hotelId)) {
                $qb
                    ->andWhere($qb->expr()->eq('r.hotel_id', ':hotel_id'))
                    ->setParameter('hotel_id', $hotelId, Type::INTEGER);
            }
            if (!empty($from)) {
                $qb
                    ->andWhere($qb->expr()->gte('r.date', ':from'))
                    ->setParameter('from', $from, Type::DATETIME);
            }
            if (!empty($to)) {
                $qb
                    ->andWhere($qb->expr()->lte('r.date', ':to'))
                    ->setParameter('to', $to, Type::DATETIME);
            }
            return $qb
                ->getQuery()
                ->getResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
        } catch (\Throwable $t) {
            return 0;
        }
    }
}
