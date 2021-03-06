<?php

namespace StackFormation\Command\Stack;

use StackFormation\Helper\Decorator;
use StackFormation\Stack;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends \StackFormation\Command\AbstractCommand
{

    protected function configure()
    {
        $this
            ->setName('stack:list')
            ->setDescription('List all stacks')
            ->addOption(
                'nameFilter',
                null,
                InputOption::VALUE_OPTIONAL,
                'Name Filter (regex). Example --nameFilter \'/^foo/\''
            )
            ->addOption(
                'statusFilter',
                null,
                InputOption::VALUE_OPTIONAL,
                'Name Filter (regex). Example --statusFilter \'/IN_PROGRESS/\''
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $nameFilter = $input->getOption('nameFilter');
        $statusFilter = $input->getOption('statusFilter');

        $stacks = $this->getStackFactory()->getStacksFromApi(false, $nameFilter, $statusFilter);

        $rows = [];
        foreach ($stacks as $stackName => $stack) { /* @var $stack Stack */
            $rows[] = [$stackName, Decorator::decorateStatus($stack->getStatus())];
        }

        $table = new Table($output);
        $table
            ->setHeaders(['Name', 'Status'])
            ->setRows($rows);
        $table->render();
    }
}
