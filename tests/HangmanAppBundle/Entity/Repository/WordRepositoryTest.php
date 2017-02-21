<?php

namespace Tests\HangmanAppBundle\Entity\Repository;

use Hangman\Bundle\AppBundle\Entity\Word;

class WordRepositoryTest extends RepositoryTestCase
{

    public function testGettingRandomWord()
    {
        $word = $this->entityManager
            ->getRepository("HangmanAppBundle:Word")
            ->getRandomWord();

        $this->assertTrue($word instanceof Word);
    }

}