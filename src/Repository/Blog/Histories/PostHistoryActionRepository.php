<?php

namespace App\Repository\Blog\Histories;

use App\Entity\Blog\Histories\PostHistoryAction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PostHistoryAction>
 *
 * @method PostHistoryAction|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostHistoryAction|null findOneBy(array $criteria, array $orderBy = null)
 *
 * @psalm-suppress LessSpecificImplementedReturnType
 *
 * @method PostHistoryAction[] findAll()
 * @method PostHistoryAction[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostHistoryActionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostHistoryAction::class);
    }

    public function save(PostHistoryAction $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PostHistoryAction $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PostHistoryAction[] Returns an array of PostHistoryAction objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PostHistoryAction
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
