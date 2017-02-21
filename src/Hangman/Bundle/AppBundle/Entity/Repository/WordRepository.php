<?php

namespace Hangman\Bundle\AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Hangman\Bundle\AppBundle\Entity\Category;
use Hangman\Bundle\AppBundle\Entity\Word;

class WordRepository extends EntityRepository
{
    /**
     * @param Category|null $category
     * @return Word|null
     */
    public function getRandomWord(Category $category = null) :? Word
    {
        $builder = $this->getEntityManager()
            ->getRepository("HangmanAppBundle:Word")
            ->createQueryBuilder('w')
            ->addSelect('RAND() as HIDDEN rand')
            ->orderBy('rand')
            ->setMaxResults(1);

        if($category) {
            $builder
                ->andWhere('w.category = ?1')
                ->setParameter(1, $category);
        }

        return $builder->getQuery()->getSingleResult();
    }
}