<?php

namespace Tests\HangmanAppBundle\Entity\Collection;

use Hangman\Bundle\AppBundle\Entity\Category;
use Hangman\Bundle\AppBundle\Entity\Collection\CategoryCollection;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class CategoryCollectionTest extends TestCase
{
    public function testGettingCategoryByName()
    {
        $category = $this->createMock(Category::class, ['getName']);
        $category
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('CategoryUniqueName'));

        $collection = new CategoryCollection([ $category ]);

        $this->assertTrue($collection->getCategory('CategoryUniqueName') instanceof Category);
    }
}