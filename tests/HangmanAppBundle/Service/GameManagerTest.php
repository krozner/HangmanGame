<?php

namespace Tests\HangmanAppBundle\Service;

use Hangman\Bundle\AppBundle\Entity\Game;
use Hangman\Bundle\AppBundle\Entity\GameStatus;
use Hangman\Bundle\AppBundle\Entity\Word;
use Hangman\Bundle\AppBundle\Model\GamePlay;
use Hangman\Bundle\AppBundle\Service\GameManager;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Tests\TestUtil\DoctrineMockTrait;

class GameManagerTest extends TestCase
{
    use DoctrineMockTrait;

    /**
     * @var GameManager
     */
    private $gameManager;

    public function setUp()
    {
        $repository = $this->getEntityRepositoryMock([
            'getRandomWord' => $this->returnValue(new Word()),
            'getStatus' => $this->returnValue(new GameStatus()),
            'getFail' => $this->returnValue(new GameStatus()),
            'getSuccess' => $this->returnValue(new GameStatus()),
        ]);

        $this->gameManager = $this->getMockBuilder(GameManager::class)
            ->setConstructorArgs([
                $this->getDoctrineRegistryMock($repository)
            ])
            ->setMethods([
                'add', 'update'
            ])
            ->getMock();

        $this->gameManager
            ->expects($this->any())
            ->method('add')
            ->willReturn(null);

        $this->gameManager
            ->expects($this->any())
            ->method('update')
            ->willReturn(null);
    }

    public function testCreateGameEntity()
    {
        $gamePlay = $this->gameManager->createGamePlay();

        $this->assertTrue($gamePlay instanceof GamePlay, 'GameManager cannot create GamePlay');
        $this->assertTrue($gamePlay->getGame()->getTriesLeft() == Game::START_TRIES);
    }

    /**
     * @expectedException \Hangman\Bundle\AppBundle\Exception\GameOverException
     */
    public function testGameOverException()
    {
        $game = new Game();
        $game
            ->setWord(new Word())
            ->setTriesLeft(0);

        $this->gameManager->play($game, 'a');
    }
}