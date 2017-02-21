<?php

namespace Hangman\Bundle\AppBundle\Model\SerializeDecorator;

use Hangman\Bundle\AppBundle\Entity\Word;
use JMS\Serializer\Annotation as Serializer;

class WordSerialize
{
    /**
     * @Serializer\Exclude()
     * @var Word
     */
    private $word;

    public function __construct(Word $word)
    {
        $this->word = $word;
    }

    /**
     * @Serializer\VirtualProperty()
     */
    public function getWord() {
        return $this->word->getWord();
    }

    /**
     * @Serializer\VirtualProperty()
     */
    public function getHint() {
        return $this->word->getHint();
    }

    /**
     * @Serializer\VirtualProperty()
     */
    public function getCategory() {
        return $this->word->getCategory()->getName();
    }

}