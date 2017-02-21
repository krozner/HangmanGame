<?php

namespace Tests\HangmanAppBundle\Entity\Repository;

use Hangman\Bundle\AppBundle\Entity\Word;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class WordRepositoryTest extends KernelTestCase
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp()
    {
        self::bootKernel();

        $this->entityManager = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testGettingRandomWord()
    {
        $word = $this->entityManager
            ->getRepository("HangmanAppBundle:Word")
            ->getRandomWord();

        $this->assertTrue($word instanceof Word);
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}