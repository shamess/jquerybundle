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

        $this->application = new Application();
        $this->application->add(new DownloadjQueryCommand("2.1.0", $this->jQueryDirectoryLocation, $this->guzzle));
    }

    public function testWritesFilesToResourcesFolder()
    {
        $this->setUpGuzzleMockForSuccessful();

        $command = $this->application->find('jquery:download');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array('command' => $command->getName()));

        $this->assertFileExists($this->jQueryDirectoryLocation . 'jquery.js');
        $this->assertStringEqualsFile($this->jQueryDirectoryLocation . 'jquery.js', $this->jQueryContents);

        $this->assertFileExists($this->jQueryDirectoryLocation . 'jquery.min.js');
        $this->assertStringEqualsFile($this->jQueryDirectoryLocation . 'jquery.min.js', $this->jQueryContents);

        $this->assertRegExp('/jQuery version 2.1.0 has been downloaded/', $commandTester->getDisplay());
    }

    public function tearDown()
    {
        if (file_exists($this->jQueryDirectoryLocation . 'jquery.js')) {
            unlink($this->jQueryDirectoryLocation . 'jquery.js');
            unlink($this->jQueryDirectoryLocation . 'jquery.min.js');
        }

        m::close();
    }

    public function testShouldReturnMessageWhenjQueryVersionIsntAvailable()
    {
        $this->guzzle
            ->shouldReceive('get')
            ->once()
            ->andReturn($this->guzzle);
        $this->guzzle
            ->shouldReceive('getStatusCode')
            ->once()
            ->andReturn(404);

        $command = $this->application->find('jquery:download');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array('command' => $command->getName()));

        $this->assertRegExp('/Unable to find version 2.1.0 of jQuery/', $commandTester->getDisplay());
    }

    public function setUpGuzzleMockForSuccessful()
    {
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
        $this->guzzle
            ->shouldReceive('getStatusCode')
            ->once()
            ->andReturn(200);
    }
}
