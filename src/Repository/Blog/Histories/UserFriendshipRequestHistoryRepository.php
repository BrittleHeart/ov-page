<?php

namespace App\Repository\Blog\Histories;

use App\Entity\Blog\Histories\UserFriendshipRequestHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserFriendshipRequestHistory>
 *
 * @method UserFriendshipRequestHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserFriendshipRequestHistory|null findOneBy(array $criteria, array $orderBy = null)
 *
 * @psalm-suppress LessSpecificImplementedReturnType
 *
 * @method UserFriendshipRequestHistory[] findAll()
 * @method UserFriendshipRequestHistory[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserFriendshipRequestHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserFriendshipRequestHistory::class);
    }

    public function save(UserFriendshipRequestHistory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserFriendshipRequestHistory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return UserFriendshipRequestHistory[] Returns an array of UserFriendshipRequestHistory objects
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

//    public function findOneBySomeField($value): ?UserFriendshipRequestHistory
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
