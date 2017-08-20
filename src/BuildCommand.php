<?php


namespace Portal\Tools;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
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
            ->addArgument('name', InputArgument::REQUIRED)
            ->addArgument('type', InputArgument::OPTIONAL)
            ->addArgument('viewName', InputArgument::OPTIONAL);


    }

    public function execute(InputInterface $input, OutputInterface $output)
    {


        //Get the paths for portal view and portal service
        $portal_view_path = App::get("portal_view_path");
        $database_restore_path = App::get("database_restore_path");


        // array of commands to be executed
        $commands = [];

        // Building the view.
        if($input->getArgument('name') == "view")
        {
            // make sure the path is correct.
            if( ! file_exists($portal_view_path))
            {
                $output->writeln('<error>Portal view path is incorrect</error>');
                exit(1);
            }

            if($input->getArgument('type') == "module")
            {
                $portal_view_path .= ' '. $input->getArgument('type') . ' ' . $input->getArgument('viewName');
            }

            $commands = [
                'cd D:/',
                'powershell -Command ' . $portal_view_path
            ];
        }

        //Restoring the database.
        if($input->getArgument('name') == "database")
        {
            // make sure the path is correct.
            if( ! file_exists($database_restore_path .'\\database-restore.cmd'))
            {
                $output->writeln('<error>Database restore path is incorrect</error>');
                exit(1);
            }

            $commands = [
                'chdir /D ' . $database_restore_path,
                'powershell -Command ./database-restore.cmd RunAs'
            ];

            $output->writeln('<comment>Changing directories...</comment>');
            $output->writeln($commands);

        }

        $process = new Process(implode(' && ', $commands));
        $process->setTimeout(99999);
        $process->run(function ($type, $line) use ($output) {
            $output->write($line);
        });

    }
}