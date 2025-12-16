<?php

namespace App\Repository;

use App\DTO\CreateFolder;
use App\Entity\Folder;
use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Folder>
 */
class FolderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Folder::class);
    }

    public function createFolder(CreateFolder $createFolder): Folder
    {
        $folder = new Folder()
            ->setTitle($createFolder->title)
            ->setDescription($createFolder->description);

        $this->getEntityManager()->persist($folder);
        $this->getEntityManager()->flush();

        return $folder;
    }

    public function attachTask(Folder $folder, Task $task): Folder
    {
        $folder->getTasks()->add($task);

        $this->getEntityManager()->persist($folder);
        $this->getEntityManager()->flush();

        return $folder;
    }

    //    /**
    //     * @return Folder[] Returns an array of Folder objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Folder
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
