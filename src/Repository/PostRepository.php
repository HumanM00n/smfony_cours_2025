<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findOldPosts(int $nb = 5): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p.slug, p.title, p.createdAt
            FROM App\Entity\Post p
            WHERE p.active = :status
            ORDER BY p.createdAt ASC'
        )
        ->setParameter('status', true)
        ->setMaxResults($nb)
        ;
        return $query->getResult();
    }
}
