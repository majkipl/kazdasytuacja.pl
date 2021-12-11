<?php

namespace App\Repository;

use App\Entity\Gender;
use App\Entity\Shop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * @extends ServiceEntityRepository<Shop>
 *
 * @method Shop|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shop|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shop[]    findAll()
 * @method Shop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     * @param CacheInterface $cache
     */
    public function __construct(ManagerRegistry $registry, private CacheInterface $cache)
    {
        parent::__construct($registry, Shop::class);
    }

    /**
     * @param Shop $entity
     * @param bool $flush
     * @return void
     */
    public function save(Shop $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Shop $entity
     * @param bool $flush
     * @return void
     */
    public function remove(Shop $entity, bool $flush = false): void
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
        $cacheKey = 'shops';

        return $this->cache->get($cacheKey, function (ItemInterface $item) {

            $item->expiresAfter(31536000);

            $shopsAll = $this->findAll();

            $shops = [];

            /** @var Shop $item */
            foreach ($shopsAll as $item) {
                $shops[$item->getId()] = $item->getName();
            }

            return $shops;
        });
    }
}
