<?php

namespace App\Repository;

use App\Entity\AuctionTranslatable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AuctionTranslatable>
 *
 * @method AuctionTranslatable|null find($id, $lockMode = null, $lockVersion = null)
 * @method AuctionTranslatable|null findOneBy(array $criteria, array $orderBy = null)
 * @method AuctionTranslatable[]    findAll()
 * @method AuctionTranslatable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuctionTranslatableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuctionTranslatable::class);
    }

    public function save(AuctionTranslatable $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AuctionTranslatable $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AuctionTranslatable[] Returns an array of AuctionTranslatable objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AuctionTranslatable
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
