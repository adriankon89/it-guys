<?php

namespace App\Repository;

use App\Entity\ItGuy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ItGuy>
 *
 * @method ItGuy|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItGuy|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItGuy[]    findAll()
 * @method ItGuy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItGuyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItGuy::class);
    }

    public function getItGuysWithCompetencies(): mixed
    {
        return $this->createQueryBuilder('t')
            ->select('itGuy, c')
            ->from('App\Entity\ItGuy', 'itGuy')
            ->leftJoin('itGuy.competencies', 'c')
            ->getQuery()
            ->getResult();
    }
}
