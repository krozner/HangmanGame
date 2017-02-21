<?php

namespace Hangman\Util;

trait IteratorTrait
{
    private $position = 0;
    protected $storage = [];

    /**
     * @return mixed
     */
    public function current() {
        return isset($this->storage[$this->position])
             ? $this->storage[$this->position]
             : null;
    }

    public function next() {
        ++$this->position;
    }

    /**
     * @return int
     */
    public function key() {
        return $this->position;
    }

    /**
     * @return bool
     */
    public function valid() {
        return isset($this->storage[$this->position]);
    }

    public function rewind() {
        $this->position = 0;
    }
}