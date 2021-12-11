<?php

namespace App\Repository;

use App\Entity\Gender;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\DependencyInjection\EnvVarLoaderInterface;
use Symfony\Component\DependencyInjection\ParameterBag\EnvPlaceholderParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * @extends ServiceEntityRepository<Gender>
 *
 * @method Gender|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gender|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gender[]    findAll()
 * @method Gender[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GenderRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     * @param CacheInterface $cache
     */
    public function __construct(ManagerRegistry $registry, private CacheInterface $cache)
    {
        parent::__construct($registry, Gender::class);
    }

    /**
     * @param Gender $entity
     * @param bool $flush
     * @return void
     */
    public function save(Gender $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Gender $entity
     * @param bool $flush
     * @return void
     */
    public function remove(Gender $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function findToSelectHtml()
    {
        $cacheKey = 'genders';

        return $this->cache->get($cacheKey, function (ItemInterface $item) {

            $item->expiresAfter(31536000);

            $gendersAll = $this->findAll();

            $genders = [];

            /** @var Gender $item */
            foreach ($gendersAll as $item) {
                $genders[$item->getId()] = $item->getName();
            }

            return $genders;
        });
    }
}
