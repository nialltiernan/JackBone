<?php

namespace App\Repository;

use App\Entity\EmojiCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EmojiCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmojiCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmojiCategory[]    findAll()
 * @method EmojiCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmojiCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmojiCategory::class);
    }
}
