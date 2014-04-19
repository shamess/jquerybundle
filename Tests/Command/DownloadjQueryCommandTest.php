<?php

namespace Shane\JqueryBundle\Tests\Command;

use Mockery as m;
use Shane\JqueryBundle\Command\DownloadjQueryCommand;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Application;

class DownloadjQueryCommandTest extends \PHPUnit_Framework_TestCase
{
    private $jQueryContents = "some foo bar";
    private $jQueryDirectoryLocation = "./";

    public function setUp()
    {
        $this->guzzle = m::mock('GuzzleHttp\Client');
        $this->guzzle
            ->shouldReceive('get')
            ->with('http://code.jquery.com/jquery-2.1.0.js')
            ->once()
            ->andReturn($this->guzzle);
        $this->guzzle
            ->shouldReceive('get')
            ->with('http://code.jquery.com/jquery-2.1.0.min.js')
            ->once()
            ->andReturn($this->guzzle);
        $this->guzzle
            ->shouldReceive('getBody')
            ->twice()
            ->andReturn($this->jQueryContents);

        $this->application = new Application();
        $this->application->add(new DownloadjQueryCommand("2.1.0", $this->jQueryDirectoryLocation, $this->guzzle));
    }

    public function testWritesFilesToResourcesFolder()
    {

        $command = $this->application->find('jquery:download');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array('command' => $command->getName()));

        $this->assertFileExists($this->jQueryDirectoryLocation . 'jquery.js');
        $this->assertStringEqualsFile($this->jQueryDirectoryLocation . 'jquery.js', $this->jQueryContents);

        $this->assertFileExists($this->jQueryDirectoryLocation . 'jquery.min.js');
        $this->assertStringEqualsFile($this->jQueryDirectoryLocation . 'jquery.min.js', $this->jQueryContents);
    }

    public function tearDown()
    {
        unlink($this->jQueryDirectoryLocation . 'jquery.js');
        unlink($this->jQueryDirectoryLocation . 'jquery.min.js');

        m::close();
    }
}
