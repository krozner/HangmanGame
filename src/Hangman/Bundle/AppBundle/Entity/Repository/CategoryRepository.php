<?php

namespace Hangman\Bundle\AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Hangman\Bundle\AppBundle\Entity\Category;
use Hangman\Bundle\AppBundle\Entity\Collection\CategoryCollection;

class CategoryRepository extends EntityRepository
{
    /**
     * @return CategoryCollection|Category[]
     */
    public function fetchAll() : CategoryCollection
    {
        return new CategoryCollection($this->findAll());
    }

    /**
     * @return CategoryCollection|Category[]
     */
    public function fetchAvailable()
    {
        $results = $this->getEntityManager()
            ->getRepository("HangmanAppBundle:Category")
            ->createQueryBuilder('c')
            ->join('HangmanAppBundle:Word', 'w', 'WITH', 'w.category = c')
            ->groupBy('c.id')
            ->getQuery()
            ->getResult();

        return new CategoryCollection($results);
    }
}