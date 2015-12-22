<?php

namespace Acme\SearchBundle\Tests;

//require realpath('vendor/autoload.php');

use Acme\SearchBundle\Command\SearchCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class SearchCommandTest extends \PHPUnit_Framework_TestCase
{
    // ...
    public function testSearchingFileContent()
    {
        $application = new Application();
        $application->add(new SearchCommand());

        $command = $application->find('search');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'      => $command->getName(),
            'string'         => 'can not hide from unit tests',
            'location' => realpath(dirname(__FILE__))
        ));

        $this->assertContains('can not hide from unit tests', $commandTester->getDisplay());
    }

}