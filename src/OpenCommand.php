<?php


namespace Portal\Tools;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;


class OpenCommand extends Command
{

    public function configure()
    {

        $this->setName('open')
            ->setDescription('Opens commonly used files')
            ->addArgument('name', InputArgument::REQUIRED);

    }

    public function execute(InputInterface $input, OutputInterface $output)
    {

        if($input->getArgument('name') == "peggy") {

            if ( ! file_exists(App::get('database_restore_path') . "/database-restore.cmd")) {

                $output->writeln('The path to your database restore is incorrect.');
                exit(1);

            }

            $open = "\"" . App::get('file_editor') . "\" \"" . App::get('database_restore_path') . "/database-restore.cmd\"";
        }

        // processes the commands
        $process = new Process($open);
        $process->setTimeout(99999);
        $process->run(function ($type, $line) use ($output) {
            $output->write($line);
        });


    }

}