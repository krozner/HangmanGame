<?php

namespace Tests\HangmanAppBundle\Entity\Repository;

use Hangman\Bundle\AppBundle\Entity\Collection\CategoryCollection;

class CategoryRepositoryTest extends RepositoryTestCase
{

    public function testGettingWordsCategories()
    {
        $collection = $this->entityManager
            ->getRepository("HangmanAppBundle:Category")
            ->fetchAll();

        $this->assertTrue($collection instanceof CategoryCollection);
    }

}