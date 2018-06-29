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
            ->addArgument('type', InputArgument::OPTIONAL, 'Ex. Module')
            ->addArgument('moduleName', InputArgument::OPTIONAL, 'Module to build Ex. Legacy');

    }

    public function execute(InputInterface $input, OutputInterface $output)
    {


        //Get the paths for portal view and portal service
        $portal_view_path = App::get("build_view_path");
        $database_restore_path = App::get("database_restore_path");
        $az_database_path = App::get("az_database_path");
        $user_database_path = App::get("user_database_path");
        $wam_database_path = App::get("wam_database_path");
        $dbPrefix = App::get("database_prefix");


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

            if($input->getArgument('type') == "app") {
			
				$portal_view_path .= ' '. $input->getArgument('type');

			
			} else {
				
				$portal_view_path .= ' '. $input->getArgument('type') . ' ' . $input->getArgument('moduleName');
				
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
        }

        //Restoring the database.
        if(strtolower($input->getArgument('name')) == "azdb")
        {
            // make sure the path is correct.
            if( ! file_exists($az_database_path .'\\AzServiceDatabase.exe'))
            {
                $output->writeln('<error>Database restore path is incorrect</error>');
                exit(1);
            }

            $commands = [
                'chdir /D ' . $az_database_path,
                '.\AzServiceDatabase.exe "server=localhost;database='.$dbPrefix.'Por;trusted_connection=true"'
            ];

            $output->writeln('<comment>Changing directories...</comment>');
        }

        //Restoring the database.
        if(strtolower($input->getArgument('name')) == "userdb")
        {
            // make sure the path is correct.
            if( ! file_exists($user_database_path .'\\MattersightUserServiceDatabaseTest.exe'))
            {
                $output->writeln('<error>Database restore path is incorrect</error>');
                exit(1);
            }

            $commands = [
                'chdir /D ' . $user_database_path,
                '.\MattersightUserServiceDatabaseTest.exe "server=localhost;database='.$dbPrefix.'Por;trusted_connection=true"'
            ];

            $output->writeln('<comment>Changing directories...</comment>');
        }


        //Restoring the database.
        if(strtolower($input->getArgument('name')) == "wamdb")
        {
            // make sure the path is correct.
            if( ! file_exists($wam_database_path .'\\Mattersight.Portal.WamServiceDatabaseTest.exe'))
            {
                $output->writeln('<error>Database restore path is incorrect</error>');
                exit(1);
            }

            $commands = [
                'chdir /D ' . $wam_database_path,
                '.\Mattersight.Portal.WamServiceDatabaseTest.exe "server=localhost;database='.$dbPrefix.'Wam;trusted_connection=true"'
            ];

            $output->writeln('<comment>Changing directories...</comment>');
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