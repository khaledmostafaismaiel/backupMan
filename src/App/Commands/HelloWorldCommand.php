<?php
namespace Console\App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelloWorldCommand extends Command
{
    protected function configure()
    {
        $this->setName("helloWorld")
                ->setHelp("First console command hello world")
                ->setDescription("hello world description")
                ->addArgument("username",InputArgument::REQUIRED,"write your name");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf("hello world!, %s",$input->getArgument("username") ));

        return 0;
    }
}