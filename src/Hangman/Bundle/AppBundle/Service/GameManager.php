<?php

namespace Hangman\Bundle\AppBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry as DoctrineRegistry;
use Hangman\Bundle\AppBundle\Entity\Category;
use Hangman\Bundle\AppBundle\Entity\Game;
use Hangman\Bundle\AppBundle\Entity\GameStatus;
use Hangman\Bundle\AppBundle\Entity\Word;
use Hangman\Bundle\AppBundle\Exception\GameOverException;
use Hangman\Bundle\AppBundle\Model\GamePlay;

class GameManager
{
    private $doctrine;

    /**
     * @param DoctrineRegistry $doctrine
     */
    public function __construct(DoctrineRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param bool $createAndSave
     * @return GamePlay
     */
    public function createGamePlay($createAndSave = true) : GamePlay
    {
        $status = $this->doctrine
            ->getRepository("HangmanAppBundle:GameStatus")
            ->getStatus(GameStatus::BUSY);

        $word = $this->getRandomWord();

        $game = new Game();
        $game
            ->setTriesLeft(Game::START_TRIES)
            ->setWord($word)
            ->setStatus($status);

        if($createAndSave) {
            $this->add($game);
        }

        return new GamePlay($game);
    }

    /**
     * @param Game $game
     */
    public function add(Game $game)
    {
        $this->doctrine->getManager()->persist($game);
        $this->doctrine->getManager()->flush();
    }

    /**
     * @param Game $game
     */
    public function update(Game $game)
    {
        $this->doctrine->getManager()->merge($game);
        $this->doctrine->getManager()->flush();
    }

    /**
     * @param Category|null $category
     * @return Word
     */
    public function getRandomWord(Category $category = null) : Word
    {
        $word = $this->doctrine
            ->getRepository("HangmanAppBundle:Word")
            ->getRandomWord($category);

        if(null === $word) {
            throw new \RuntimeException('There is no words in database');
        }

        return $word;
    }

    /**
     * @param Game $game
     * @param string $letter
     * @return GamePlay
     * @throws GameOverException
     */
    public function play(Game $game, $letter)
    {
        $gamePlay = new GamePlay($game);
        $gamePlay->guess($letter);

        if($gamePlay->isGameOver())
        {
            $repository = $this->doctrine->getRepository("HangmanAppBundle:GameStatus");

            $status = ($game->getTriesLeft() == 0)
                ? $repository->getFail()
                : $repository->getSuccess();

            $game->setStatus($status);

            $this->update($game);

            throw new GameOverException($gamePlay);
        }

        $this->update($game);

        return $gamePlay;
    }

}