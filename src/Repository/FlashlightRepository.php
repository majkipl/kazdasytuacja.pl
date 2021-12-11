<?php

namespace App\Repository;

use App\Entity\Flashlight;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Flashlight>
 *
 * @method Flashlight|null find($id, $lockMode = null, $lockVersion = null)
 * @method Flashlight|null findOneBy(array $criteria, array $orderBy = null)
 * @method Flashlight[]    findAll()
 * @method Flashlight[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlashlightRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Flashlight::class);
    }

    /**
     * @param Flashlight $entity
     * @param bool $flush
     * @return void
     */
    public function save(Flashlight $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Flashlight $entity
     * @param bool $flush
     * @return void
     */
    public function remove(Flashlight $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
