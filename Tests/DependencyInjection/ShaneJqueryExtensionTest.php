<?php

namespace Shane\JqueryBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Shane\JqueryBundle\DependencyInjection\ShaneJqueryExtension;
use Shane\JqueryBundle\DependencyInjection\Configuration;

class ShowJqueryExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->extension = new ShaneJqueryExtension();
        $this->container = new ContainerBuilder();
    }

    public function testDefaultValueIsSetForConfiguration()
    {
        $this->extension->load(array(), $this->container);

        $this->assertEquals(Configuration::DEFAULT_VERSION, $this->container->getParameter(ShaneJqueryExtension::PARAMETER_VERSION));
    }

    public function testDefaultVersionIsOverridenWithUpdatedVersion()
    {
        $version = '6.2.1';
        $arguments = array('jquery_management' => array('version' => $version));
        $this->extension->load($arguments, $this->container);

        $this->assertEquals($version, $this->container->getParameter(ShaneJqueryExtension::PARAMETER_VERSION));
    }
}
