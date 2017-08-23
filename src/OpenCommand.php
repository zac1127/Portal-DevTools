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

        if($input->getArgument('name') === "peggy") {

            if ( ! file_exists(App::get('database_restore_path') . "/database-restore.cmd")) {

                $output->writeln('The path to your database restore is incorrect.');
                exit(1);

            }

            $open = "\"" . App::get('file_editor') . "\" \"" . App::get('database_restore_path') . "/database-restore.cmd\"";
        }

        if($input->getArgument('name') === "portal") {

            $open = 'start  "" http://localhost';
        }

        if($input->getArgument('name') === "hitachi") {

            $open = 'start  "" https://hitachi.mattersight.com/idm/psf.exe';
        }

        if($input->getArgument('name') === "confluence") {

            $open = 'start  "" https://confluence.mattersight.local/display/dev/Portal+Application+Team+Home';
        }

        if($input->getArgument('name') === "citrix") {

            $open = 'start  "" https://citrix.mattersight.local/vpn/index.html';
        }

        if($input->getArgument('name') === "artifactory") {

            $open = 'start  "" https://svnmirror.mattersight.local/uploadbuilds.php';
        }

        if($input->getArgument('name') === "jira") {

            $open = 'start  "" https://jira.mattersight.com';
        }

        if($input->getArgument('name') === "jenkins") {

            $open = 'start  "" https://jenkinsdev.mattersight.local/';
        }


        if($input->getArgument('name') === "ssms") {

            if ( ! file_exists(App::get('ssms'))) {

                $output->writeln('The path to your SSMS is incorrect.');
                exit(1);

            }

            $open = '"'.App::get('ssms').'"';
        }



        if(empty($open))
        {
            $output->writeln("The command you entered is invalid");
            exit(1);
        }

        // processes the commands
        $process = new Process($open);
        $process->setTimeout(99999);
        $process->run(function ($type, $line) use ($output) {
            $output->write($line);
        });
        exit(1);


    }

}