<?php

namespace Portal\Tools;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class ClearCommand extends Command
{

    public function configure()
    {

        $this->setName('clear')
            ->setDescription('Builds a module of the portal')
            ->addArgument('name', InputArgument::REQUIRED);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        //Get the paths for portal view and portal service
        $redis_path = App::get("redis");

        // array of commands to be executed
        $commands = [];

        // Clear redis.
        if($input->getArgument('name') == "redis")
        {
            // make sure the path is correct.
            if( ! file_exists($redis_path))
            {
                $output->writeln('<error>Redis path is incorrect</error>');
                exit(1);
            }

            // Set consecutive commands.
            $commands = [
                'cd '. $redis_path,
                'redis-cli.exe flushall'
            ];
        }


        if(empty($commands))
        {
            $output->writeln('<comment> The command you entered is invalid...</comment>');
            exit(1);
        }

        // process the commands.
        $process = new Process(implode(' && ', $commands));
        $process->setTimeout(99999);
        $process->run(function ($type, $line) use ($output) {
            $output->write($line);
        });

    }
}