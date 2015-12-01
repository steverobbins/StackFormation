<?php

namespace StackFormation\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShowLiveCommand extends AbstractCommand
{

    protected function configure()
    {
        $this
            ->setName('stack:show-live')
            ->setDescription('Show parameters and outputs from live stacks')
            ->addArgument(
                'stack',
                InputArgument::REQUIRED,
                'Stack'
            );
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $this->interact_askForLiveStack($input, $output);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $stack = $input->getArgument('stack');
        $output->writeln("Stack '$stack':");


        $output->writeln('');
        $output->writeln("=== STACK TAGS ===");

        $tags = $this->stackManager->getTags($stack);

        $rows = [];
        foreach ($tags as $key => $value) {
            $value = strlen($value) > 100 ? substr($value, 0, 100)."..." : $value;
            $rows[] = [$key, $value];
        }

        $table = new \Symfony\Component\Console\Helper\Table($output);
        $table
            ->setHeaders(array('Key', 'Value'))
            ->setRows($rows)
        ;
        $table->render();


        $output->writeln('');
        $output->writeln("=== PARAMETERS ===");

        $outputs = $this->stackManager->getParameters($stack);

        $rows = [];
        foreach ($outputs as $key => $value) {
            $value = strlen($value) > 100 ? substr($value, 0, 100)."..." : $value;
            $rows[] = [$key, $value];
        }

        $table = new \Symfony\Component\Console\Helper\Table($output);
        $table
            ->setHeaders(array('Key', 'Value'))
            ->setRows($rows)
        ;
        $table->render();


        $output->writeln('');
        $output->writeln("=== RESOURCES ===");

        $resources = $this->stackManager->getResources($stack);

        $rows = [];
        foreach ($resources as $key => $value) {
            $value = strlen($value) > 100 ? substr($value, 0, 100)."..." : $value;
            $rows[] = [$key, $value];
        }

        $table = new \Symfony\Component\Console\Helper\Table($output);
        $table
            ->setHeaders(array('Key', 'Value'))
            ->setRows($rows)
        ;
        $table->render();

        $output->writeln('');
        $output->writeln("=== OUTPUTS ===");

        $outputs = $this->stackManager->getOutputs($stack);

        $rows = [];
        foreach ($outputs as $key => $value) {
            $value = strlen($value) > 100 ? substr($value, 0, 100)."..." : $value;
            $rows[] = [$key, $value];
        }

        $table = new \Symfony\Component\Console\Helper\Table($output);
        $table
            ->setHeaders(array('Key', 'Value'))
            ->setRows($rows)
        ;
        $table->render();
    }
}
