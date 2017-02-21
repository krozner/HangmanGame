<?php

namespace Hangman\Bundle\AppBundle\Model\SerializeDecorator;

use Hangman\Bundle\AppBundle\Model\GamePlay;
use JMS\Serializer\Annotation as Serializer;

class GamePlaySerialize
{
    /**
     * @Serializer\Exclude()
     */
    private $gamePlay;

    /**
     * @param GamePlay $gamePlay
     */
    public function __construct(GamePlay $gamePlay)
    {
        $this->gamePlay = $gamePlay;
    }

    /**
     * @Serializer\VirtualProperty()
     */
    public function getId()
    {
        return $this->gamePlay->getGame()->getId();
    }

    /**
     * *word*: representation of the word that is being guessed.
     *  Should contain dots for letters that have not been guessed yet (e.g. aw.so..)
     *
     * @Serializer\VirtualProperty()
     */
    public function getWord()
    {
        return $this->gamePlay->getGuessedWord();
    }

    /**
     * @Serializer\VirtualProperty()
     */
    public function getTriesLeft()
    {
        return $this->gamePlay->getGame()->getTriesLeft();
    }

    /**
     * @Serializer\VirtualProperty()
     */
    public function getStatus()
    {
        return $this->gamePlay->getGame()->getStatus()->getName();
    }

    /**
     * @Serializer\VirtualProperty()
     */
    public function getOrigin()
    {
        return new WordSerialize($this->gamePlay->getGame()->getWord());
    }

}