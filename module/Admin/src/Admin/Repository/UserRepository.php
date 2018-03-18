<?php

/**
 * Created by PhpStorm.
 * User: Thai Duc
 * Date: 14-Mar-18
 * Time: 1:27 AM
 */
namespace Admin\Repository;


use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function getAll(array $data){

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('p')->from('\Admin\Entity\User','p')
                            ->orderBy('p.level','DESC')
                            ->setMaxResults($data['ItemCountPerPage'])
                            ->setFirstResult(($data['CurrentPageNumber']-1)*$data['ItemCountPerPage'] );
        $product = $qb->getQuery();
        return $product;
    }
}