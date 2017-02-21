<?php

namespace Hangman\Bundle\AppBundle\Model;

use Hangman\Bundle\AppBundle\Entity\Game;

class GamePlay
{
    private $alphabet, $game, $guessedWord, $originWord;

    /**
     * @param Game $game
     */
    public function __construct(Game $game)
    {
        $this->alphabet = range('a', 'z');

        $this->game = $game;
        $this->originWord = strtolower($game->getWord()->getWord());

        $this->maskWord();
    }

    /**
     * @return string
     */
    public function getGuessedWord()
    {
        return $this->guessedWord;
    }

    /**
     * @return Game
     */
    public function getGame() : Game
    {
        return $this->game;
    }

    /**
     * @param string $letter
     */
    public function guess($letter)
    {
        if(! in_array($letter = strtolower($letter), $this->alphabet)) {
            throw new \InvalidArgumentException('Invalid letter. Only valid characters are a-z');
        }

        if($this->isGameOver()) {
            return;
        }

        /** do not take any action for repeated letter */
        if(in_array($letter, $this->getGame()->getCharactersGuessed())) {
            return;
        }

        $this->getGame()->addCharacterGuessed($letter);

        if(false === strpos($this->originWord, $letter))
        {
            $this->decrementTriesLeft();
        }
        else {
            $this->maskWord();
        }
    }

    private function decrementTriesLeft()
    {
        $left = $this->getGame()->getTriesLeft();
        $this->getGame()->setTriesLeft(--$left);
    }

    private function maskWord()
    {
        $characters = $this->getGame()->getCharactersGuessed();

        $guessedWord = [];
        foreach(str_split($this->originWord) as $letter) {
            $guessedWord[] = in_array($letter, $characters)
                ? $letter
                : '.';
        }

        $this->guessedWord = implode('', $guessedWord);
    }

    /**
     * @return bool
     */
    public function isGameOver()
    {
        return ($this->originWord === $this->getGuessedWord() || $this->getGame()->getTriesLeft() == 0);
    }
}