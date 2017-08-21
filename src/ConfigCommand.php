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
            ->addArgument('action');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {

        if($input->getArgument('action') == NULL) {
            $paths = $this->buildTable();
            $table = new Table($output);
            $table->setHeaders(['Path Name', 'Path', 'Correct?'])
                ->setRows($paths)
                ->render();
        }

        if($input->getArgument('action') === 'fix') {
            $commands = [
                'cd %homepath%/AppData/Roaming/Composer/vendor/portal/devtools',
                'start "' . App::get('file_editor') . '" ./config.php'
            ];

            // process the commands.
            $process = new Process(implode(' && ', $commands));
            $process->setTimeout(99999);
            $process->run(function ($type, $line) use ($output) {
                $output->write($line);
            });
        }

    }

    /**
     * @return array
     */
    public function buildTable()
    {
        // get the file paths from the DI container.
        $paths = App::getRegistry();
        $table = [];
        foreach($paths as $key => $path){
            $table[] = [$key, $path, file_exists($path) ? "true" : "false"];
        }
        return $table;
    }

}