<?php

namespace Hangman\Bundle\AppBundle\Exception;

use Hangman\Bundle\AppBundle\Model\GamePlay;

class GameOverException extends \Exception
{
    private $gamePlay;

    /**
     * @param GamePlay $gamePlay
     */
    public function __construct(GamePlay $gamePlay)
    {
        $isSuccess = $gamePlay->getGame()->getStatus()->isSuccess();
        $this->gamePlay = $gamePlay;

        parent::__construct("Game over. You " . ($isSuccess ? "win" : "lose"));
    }

    public function getGamePlay() : GamePlay {
        return $this->gamePlay;
    }
}