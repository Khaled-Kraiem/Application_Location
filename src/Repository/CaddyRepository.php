<?php

namespace App\Repository;

use App\Entity\Caddy;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Caddy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Caddy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Caddy[]    findAll()
 * @method Caddy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaddyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Caddy::class);
    }

    public function getMyCaddy(User $ConnectedUser)
    {
        $ConnectedUserID = $ConnectedUser->getId();

        $req = $this->getEntityManager()->createQuery("SELECT c from App:Caddy c 
              WHERE c.locateur = '$ConnectedUserID'");
        return $req->getResult();
    }

    public function getNbrCaddy(User $ConnectedUser)
    {
        $ConnectedUserID = $ConnectedUser->getId();

        $req = $this->getEntityManager()->createQuery(" SELECT COUNT (c) from App:Caddy c 
              WHERE c.locateur = '$ConnectedUserID'");
        return $req->getResult();
    }


    // /**
    //  * @return Caddy[] Returns an array of Caddy objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Caddy
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
