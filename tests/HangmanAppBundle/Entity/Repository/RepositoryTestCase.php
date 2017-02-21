<?php

namespace Tests\HangmanAppBundle\Entity\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RepositoryTestCase extends KernelTestCase
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    protected function setUp()
    {
        self::bootKernel();

        $this->entityManager = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }


    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}