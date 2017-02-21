<?php
namespace Hangman\Bundle\AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HangmanRebuildCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('hangman:rebuild');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Rebuilding database...");

        $this->getApplication()
            ->find('doctrine:migrations:execute')
            ->run(new ArrayInput(['--down' => true, 'version' => 20000000000000]), $output);

        $this->getApplication()
            ->find('doctrine:migrations:migrate')
            ->run(new ArrayInput([]), $output);

        $output->writeln("Doctrine data fixtures load");
        $this->getApplication()
            ->find('doctrine:fixtures:load')
            ->run(new ArrayInput(['--append' => true ]), $output);

        $output->writeln("Done");
    }
}
