<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Shop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * @extends ServiceEntityRepository<Category>
 *
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     * @param CacheInterface $cache
     */
    public function __construct(ManagerRegistry $registry, private CacheInterface $cache)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * @param Category $entity
     * @param bool $flush
     * @return void
     */
    public function save(Category $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Category $entity
     * @param bool $flush
     * @return void
     */
    public function remove(Category $entity, bool $flush = false): void
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
        $cacheKey = 'categories';

        return $this->cache->get($cacheKey, function (ItemInterface $item) {

            $item->expiresAfter(31536000);

            $categoriesAll = $this->findAll();

            $categories = [];

            /** @var Shop $item */
            foreach ($categoriesAll as $item) {
                $categories[$item->getId()] = $item->getName();
            }

            return $categories;
        });
    }
}
