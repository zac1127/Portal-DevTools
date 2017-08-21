<?php


namespace Portal\Tools;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Process\Process;


class ConfigCommand extends Command
{

    public function configure()
    {

        $this->setName('config')
            ->setDescription('Manage your configs.')
            ->addArgument('action', InputArgument::REQUIRED);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {

        if($input->getArgument('action') == 'paths') {
            $paths = $this->buildTable();
            $table = new Table($output);
            $table->setHeaders(['Path Name', 'Path', 'Correct?'])
                ->setRows($paths)
                ->render();
        }

    }

    public function buildTable()
    {
        $paths = App::getRegistry();
        $table = [];
        foreach($paths as $key => $path){
            $table[] = [$key, $path, file_exists($path) ? "true" : "false"];
        }
        return $table;
    }

}