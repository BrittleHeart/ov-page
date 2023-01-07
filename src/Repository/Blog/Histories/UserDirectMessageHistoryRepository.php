<?php

namespace App\Repository\Blog\Histories;

use App\Entity\Blog\Histories\UserDirectMessageHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserDirectMessageHistory>
 *
 * @method UserDirectMessageHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserDirectMessageHistory|null findOneBy(array $criteria, array $orderBy = null)
 *
 * @psalm-suppress LessSpecificImplementedReturnType
 *
 * @method UserDirectMessageHistory[] findAll()
 * @method UserDirectMessageHistory[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserDirectMessageHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserDirectMessageHistory::class);
    }

    public function save(UserDirectMessageHistory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserDirectMessageHistory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return UserDirectMessageHistory[] Returns an array of UserDirectMessageHistory objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserDirectMessageHistory
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
