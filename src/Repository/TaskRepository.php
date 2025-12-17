<?php

namespace App\Repository;

use App\DTO\CreateTask;
use App\Entity\Status;
use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    private ManagerRegistry $managerRegistry;

    public function __construct(ManagerRegistry $registry, ManagerRegistry $managerRegistry)
    {
        parent::__construct($registry, Task::class);
        $this->managerRegistry = $managerRegistry;
    }

    public function createTask(CreateTask $createTask): Task
    {
        /** @var StatusRepository $statusRepository */
        $statusRepository = $this->managerRegistry->getRepository(Status::class);
        $status = $statusRepository->findOneBy(['id' => $createTask->statusId]);

        $task = new Task()
            ->setTitle($createTask->title)
            ->setDescription($createTask->description)
            ->setStatus($status);

        $this->getEntityManager()->persist($task);
        $this->getEntityManager()->flush();

        return $task;
    }

    //    /**
    //     * @return Task[] Returns an array of Task objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Task
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
