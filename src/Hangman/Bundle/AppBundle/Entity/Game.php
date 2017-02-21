<?php

namespace Hangman\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="hangman_game")
 */
class Game
{
    const START_TRIES = 11;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="game_id")
     */
    private $id;

    /**
     * @var Word
     *
     * @ORM\ManyToOne(targetEntity="Hangman\Bundle\AppBundle\Entity\Word")
     * @ORM\JoinColumn(name="word_id", referencedColumnName="word_id")
     */
    private $word;

    /**
     * @ORM\Column(type="integer", name="tries_left", nullable=false)
     */
    private $triesLeft;

    /**
     * @var GameStatus
     *
     * @ORM\ManyToOne(targetEntity="Hangman\Bundle\AppBundle\Entity\GameStatus")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="status_id")
     */
    private $status;

    /**
     * @ORM\Column(type="text", name="characters_guessed", nullable=true)
     */
    private $charactersGuessed = '';

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Word
     */
    public function getWord() : Word
    {
        return $this->word;
    }

    /**
     * @param Word $word
     * @return $this
     */
    public function setWord(Word $word)
    {
        $this->word = $word;
        return $this;
    }

    /**
     * @return int
     */
    public function getTriesLeft() : int
    {
        return $this->triesLeft;
    }

    /**
     * @param int $triesLeft
     * @return $this
     */
    public function setTriesLeft(int $triesLeft)
    {
        $this->triesLeft = $triesLeft;
        return $this;
    }

    /**
     * @return GameStatus
     */
    public function getStatus() : GameStatus
    {
        return $this->status;
    }

    /**
     * @param GameStatus $status
     * @return $this
     */
    public function setStatus(GameStatus $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    private $characters = null;

    /**
     * @return array
     */
    public function getCharactersGuessed()
    {
        if(! is_array($this->characters)) {
            $this->characters = unserialize($this->charactersGuessed);
        }

        return $this->characters ?: [];
    }

    /**
     * @param array $characters
     * @return $this
     */
    public function setCharactersGuessed(array $characters)
    {
        $this->characters = array_map('strtolower', $characters);
        $this->charactersGuessed = serialize($this->characters);
        return $this;
    }

    /**
     * @param string $letter
     * @return $this
     */
    public function addCharacterGuessed($letter)
    {
        $characters = $this->getCharactersGuessed();
        $characters[] = $letter;
        $this->setCharactersGuessed($characters);
        return $this;
    }
}