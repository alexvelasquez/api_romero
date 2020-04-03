<?php

namespace App\Repository;


use Doctrine\ORM\EntityRepository;

class CuotaRepository extends EntityRepository
{

    public function findAllCuotaAnio($from, $end): array
    {

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('c',"sum(p.value) as total") 
            ->from('App:Cuota', 'c')
            ->leftJoin('App:Payment', 'p', 'WITH','c.cuotaId = p.cuota')
            ->where('c.date BETWEEN :from AND :end')
            ->setParameter(':from',$from)
            ->setParameter(':end',$end)
            ->groupBy('c')
            ->orderBy('c.date','DESC');
        return $qb->getQuery()->getArrayResult();
    }
}