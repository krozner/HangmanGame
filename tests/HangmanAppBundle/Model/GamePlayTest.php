<?php

namespace Hangman\Bundle\AppBundle\Model;

use Hangman\Bundle\AppBundle\Entity\Game;
use Hangman\Bundle\AppBundle\Entity\Word;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class GamePlayTest extends TestCase
{
    public function testGuessLetter()
    {
        $word = new Word();
        $word->setWord('abcd');

        $game = new Game();
        $game
            ->setTriesLeft(11)
            ->setWord($word);

        $gamePlay = new GamePlay($game);
        $gamePlay->guess('a');

        $this->assertTrue($gamePlay->getGuessedWord() === 'a...');
    }
}