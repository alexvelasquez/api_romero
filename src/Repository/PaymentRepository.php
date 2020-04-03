<?php

namespace App\Repository;


use Doctrine\ORM\EntityRepository;

class PaymentRepository extends EntityRepository
{
    public function findAllPaymentCategory($category, $cuota): array
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('p') 
            ->from('App:Payment','p')
            ->innerJoin('App:Player', 'j','WITH', 'p.player = j.playerId')
            ->where('j.category = :category and p.cuota = :cuota')
            ->setParameter(':category',$category)
            ->setParameter(':cuota',$cuota);
        return $qb->getQuery()->getResult();
    }

    public function findAllNotPaymentCategory($category, $cuota): array
    {   
        $em = $this->getEntityManager();
        //query exists
        $sub = $em->createQueryBuilder();
        $sub->select("p")
            ->from("App:Payment","p")
            ->where('p.cuota = :cuota and p.player = j.playerId');
        //query
        $qb = $em->createQueryBuilder();
        $qb->select('j') 
            ->from('App:Player','j')
            ->where('j.category = :category')
            ->andwhere($qb->expr()->not($qb->expr()->exists($sub->getDQL())))
            ->setParameter(':category',$category)
            ->setParameter(':cuota',$cuota);

        return $qb->getQuery()->getResult();
    }

    public function findAllCountPayment()
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('count(distinct(j.playerId))') 
        ->from('App:Payment','p')
        ->innerJoin('App:Player', 'j','WITH', 'p.player = j.playerId');
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findAllCountNotPayment()
    {   
        $em = $this->getEntityManager();
        //query exists
        $sub = $em->createQueryBuilder();
        $sub->select("p")
            ->from("App:Payment","p")
            ->where('p.player = j.playerId');
        //query
        $qb = $em->createQueryBuilder();
        $qb->select('count(j)') 
            ->from('App:Player','j')
            ->andwhere($qb->expr()->not($qb->expr()->exists($sub->getDQL())));

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findAllTotalValue()
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('SUM(p.value)') 
            ->from('App:Payment','p');
        return $qb->getQuery()->getSingleScalarResult();
    }
}
        // construct a subselect joined with an entity that have a relation with the first table as example user