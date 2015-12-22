<?php

namespace Acme\SearchBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Acme\SearchBundle\Models\Search as SearchService;

class SearchCommand extends ContainerAwareCommand
{
protected function configure()
{
    $this
        ->setName('search')
        ->setDescription('Search files content by given string')
        ->addArgument(
            'string',
            InputArgument::OPTIONAL,
            'What are you looking for?'
        )->addArgument(
            'location',
            InputArgument::OPTIONAL,
            'If set, it will search in the given directory, if not , it will search in the base working directory.'
        )
        ->addOption(
            'short',
            null,
            InputOption::VALUE_NONE,
            'If set, the task will only display the files that contain the searched string'
        );
}

protected function execute(InputInterface $input, OutputInterface $output)
{
    $searchString = $input->getArgument('string');
    $location = $input->getArgument('location');

    if ($searchString) {

        $shortOutput = false;
        $searchDirectory = '';

        if ($location) {

            $searchDirectory = $location;

        }


        if ($input->getOption('short')) {

            $shortOutput = true;

        }

        $searchService = new SearchService();

        $text = $searchService->searchText($searchString, $searchDirectory, $shortOutput);

    } else {

    }



    $output->writeln($text);
}

}