<?php

namespace App\Repository;

use App\Entity\ItGuy;
use App\Entity\TimeSheet;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TimeSheet>
 *
 * @method TimeSheet|null find($id, $lockMode = null, $lockVersion = null)
 * @method TimeSheet|null findOneBy(array $criteria, array $orderBy = null)
 * @method TimeSheet[]    findAll()
 * @method TimeSheet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimeSheetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TimeSheet::class);
    }

    public function findItGuyBookedTerms(ItGuy $itGuy, DateTimeInterface $availableFrom)
    {
        return $this->createQueryBuilder('t')
        ->where('t.itguy = :itguy')
        ->andWhere('t.to_date >= :to_date')
        ->setParameter('itguy', $itGuy)
        ->setParameter('to_date', $availableFrom->format('Y-m-d'))
        ->getQuery()
        ->getResult();


    }
}
