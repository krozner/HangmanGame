<?php

namespace Hangman\Bundle\AppBundle\Entity\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Hangman\Bundle\AppBundle\Entity\Category;
use Hangman\Util\IteratorTrait;

class CategoryCollection implements \IteratorAggregate
{
    private $categories;

    /**
     * @param array $categories
     */
    public function __construct(array $categories)
    {
        $this->categories = new class implements \ArrayAccess, \Iterator
        {
            use IteratorTrait;

            /**
             * @var array [crc32] => key
             */
            private $keys = [];

            public function offsetExists($offset)
            {
                return isset($this->keys[$offset]);
            }

            public function offsetGet($offset)
            {
                return $this->offsetExists($offset)
                    ? $this->storage[$this->keys[$offset]]
                    : null;
            }

            public function offsetSet($offset, $value)
            {
                $this->keys[$offset] = $this->key();
                $this->storage[$this->key()] = $value;
                $this->next();
            }

            public function offsetUnset($offset)
            {
                throw new \RuntimeException('Not implemented yet');
            }
        };

        foreach($categories as $category) {
            if(! $category instanceof Category) {
                throw new \InvalidArgumentException(__CLASS__ . ' can append only Category entity');
            }
            $this->append($category);
        }
    }

    /**
     * @param Category $category
     */
    public function append(Category $category)
    {
        $this->categories->offsetSet(crc32($category->getName()), $category);
    }

    /**
     * @return ArrayCollection|Category[]
     */
    public function getIterator() {
        return $this->categories;
    }

    /**
     * @param string $name
     * @return Category|null
     */
    public function getCategory(string $name) :? Category
    {
        return $this->categories->offsetExists($index = crc32($name))
            ? $this->categories->offsetGet($index)
            : null;
    }
}