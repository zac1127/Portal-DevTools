<?php


namespace Portal\Tools;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class BuildCommand extends Command
{

    public function configure()
    {

        $this->setName('build')
            ->setDescription('Builds a module of the portal')
            ->addArgument('component', InputArgument::REQUIRED, 'Item to build.');


    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $cmd = "D:\Development\Portal\portal-service\test\database\orange\database-restore.cmd";

        $process = new Process($cmd);
        $process->run(function ($type, $line) use ($output) {
            $output->write($line);
        });

        $output->writeln('<comment>You\'re database is ready!</comment>');
    }

}