<?php

namespace Shane\JqueryBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DownloadjQueryCommand extends Command
{
    /**
     * @var string
     */
    private $version;

    /**
     * @var \GuzzleHttp\Client
     */
    private $guzzle;

    /**
     * @var string
     */
    private $writeLocation;

    public function __construct($version, $writeLocation, \GuzzleHttp\Client $guzzle)
    {
        $this->version = $version;
        $this->writeLocation = $writeLocation;
        $this->guzzle = $guzzle;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('jquery:download')
            ->setDescription('Download jQuery from jQuery.com and place it in the resources folder');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fileLocations = $this->getFileLocations();

        $jquery = $this->guzzle->get('http://code.jquery.com/jquery-' . $this->version . '.js')->getBody();
        file_put_contents($this->writeLocation . '/' . $fileLocations['readable'], $jquery);

        $jqueryMin = $this->guzzle->get('http://code.jquery.com/jquery-' . $this->version . '.min.js')->getBody();
        file_put_contents($this->writeLocation . '/' . $fileLocations['minified'], $jqueryMin);
    }

    public function getFileLocations()
    {
        return array(
            'minified' => 'jquery.min.js',
            'readable' => 'jquery.js',
        );
    }
}
