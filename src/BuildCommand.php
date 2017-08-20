<?php


namespace Portal\Tools;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BuildCommand extends Command
{

    public function configure()
    {
        parent::configure(); // TODO: Change the autogenerated stub

        $this->setName('build')
            ->setDescription('Builds a module of the portal')
            ->addArgument('component', InputArgument::REQUIRED, 'Build Item.');


    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output); // TODO: Change the autogenerated stub

        $output->writeLn('Hello World');
    }

}