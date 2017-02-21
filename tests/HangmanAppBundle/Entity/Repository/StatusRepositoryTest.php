<?php

namespace Tests\HangmanAppBundle\Entity\Repository;

use Hangman\Bundle\AppBundle\Entity\GameStatus;

class StatusRepositoryTest extends RepositoryTestCase
{
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->repository = $this->entityManager->getRepository("HangmanAppBundle:GameStatus");
    }

    public function testGettingGameStatus()
    {
        $this->assertTrue($this->repository->getStatus(GameStatus::BUSY) instanceof GameStatus);
    }

    public function testCountRequirementStatuses()
    {
        $this->assertCount(3, $this->repository->findAll());
    }
}