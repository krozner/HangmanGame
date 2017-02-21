<?php

namespace Hangman\Bundle\AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Hangman\Bundle\AppBundle\Entity\Game;
use Hangman\Bundle\AppBundle\Exception\GameOverException;
use Hangman\Bundle\AppBundle\Model\SerializeDecorator\GamePlaySerialize;

class HangmanApiController extends Controller
{
    /**
     * @return \Hangman\Bundle\AppBundle\Service\GameManager
     */
    private function gameManager()
    {
        return $this->get('hangman.service.game_manager');
    }

    /**
     * @Post("/api/game", name="hangman_api_start_game")
     * @View()
     */
    public function startAction()
    {
        $gamePlay = $this->gameManager()->createGamePlay();
        return new GamePlaySerialize($gamePlay);
    }

    /**
     * @Put("/api/game/{game}/{letter}", name="hangman_api_game_guess")
     * @View()
     */
    public function guessAction(Game $game, $letter)
    {
        try
        {
            $gamePlay = $this->gameManager()->play($game, $letter);

            return new GamePlaySerialize($gamePlay);

        } catch(GameOverException $e)
        {
            return [
                'word' => $e->getGamePlay()->getGuessedWord(),
                'game_over' => $e->getMessage()
            ];
        }
    }

}
