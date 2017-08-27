<?php


namespace Portal\Tools;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Portal\Tools\App;

class UpdateCommand extends Command
{


    public function configure()
    {

        $this->setName('update')
            ->setDescription('Builds a module of the portal')
            ->addArgument('module', InputArgument::OPTIONAL);


    }

    public function execute(InputInterface $input, OutputInterface $output)
    {

        $portal_service = 'cd /D' . App::get('portal_service_path');
        $portal_view = 'cd /D' . App::get('portal_view_path');

        if($input->getArgument('module') === "all")
        {

            $output->writeln("Updating your portal...");

            //update portal-service and portal-view
            $commands = [
				'cd D:/',
                $portal_service,
                'git checkout develop',
                'git pull --progress -v --no-rebase "origin"',
                $portal_view,
                'git checkout develop',
                'git pull --progress -v --no-rebase "origin"'
            ];

        }

        if($input->getArgument('module') === "portal-view")
        {
            $output->writeln("Updating portal view...");

            //update portal-view
            $commands = [
				'cd D:/',
                $portal_view,
                'git checkout develop',
                'git pull --progress -v --no-rebase "origin"'
            ];

        }

        if($input->getArgument('module') === "portal-service")
        {
            $output->writeln("Updating portal service...");

            //update portal-service
            $commands = [
				'cd D:/',
                $portal_service,
                'git checkout develop',
                'git pull --progress -v --no-rebase "origin"'
            ];

        }


        if($input->getArgument('module') === NULL)
        {
            $output->writeln("Updating your portal devtools...");

            //update portal devtools
            $commands = [
                'composer global update portal/devtools:dev-master --prefer-source'
            ];
        }

        if(empty($commands))
        {
            $output->write('The command you entered is invalid.');
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