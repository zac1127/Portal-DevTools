<?php


namespace Portal\Tools;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Process\Process;


class CommitCommand extends Command
{

    public function configure()
    {

        $this->setName('commit')
            ->setDescription('Commit to a branch.')
            ->addArgument('name', InputArgument::REQUIRED)
            ->addArgument('commit_message', InputArgument::REQUIRED);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {

        $branch = $input->getArgument('name');
        $commit_message = $input->getArgument('commit_message');

        $commands = [
            'git status',
            'git fetch',
            'git add .',
            'git stash save',
            'git checkout ' . $branch,
            'git stash pop',
            'git commit -m "' . $commit_message . '"',
            'git push',
            'git checkout develop',
        ];

        // process the commands.
        $process = new Process(implode(' && ', $commands));
        $process->setTimeout(99999);
        $process->run(function ($type, $line) use ($output) {
            $output->write($line);
        });

    }

}