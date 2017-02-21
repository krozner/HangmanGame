<?php

namespace Hangman\Bundle\AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Hangman\Bundle\AppBundle\Entity\Category;
use Hangman\Bundle\AppBundle\Entity\Word;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use League\Csv\Reader;

class LoadWords implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $collection = $manager
            ->getRepository("HangmanAppBundle:Category")
            ->fetchAll();

        $filePath = $this->container->get('kernel')->getRootDir() . '/Resources/files/words.csv';

        $words = Reader::createFromPath($filePath)->fetchAll();

        foreach($words as list($categoryName, $word, $hint))
        {
            if(! ($category = $collection->getCategory($categoryName)))
            {
                $category = new Category();
                $category
                    ->setName($categoryName);

                $manager->persist($category);
                $manager->flush();

                $collection->append($category);
            }

            $entity = new Word();
            $entity
                ->setCategory($category)
                ->setWord($word)
                ->setHint($hint);

            $manager->persist($entity);
        }

        $manager->flush();
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 0;
    }

}
