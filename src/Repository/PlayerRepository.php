<?php

namespace App\Repository;


use Doctrine\ORM\EntityRepository;

class PlayerRepository extends EntityRepository
{

    public function findAllCount()
    {   
        $em = $this->getEntityManager();
        //query exists
        $qb = $em->createQueryBuilder();
        $qb->select("count(p)")
            ->from("App:Player","p");

        return $qb->getQuery()->getSingleScalarResult();
    }
}