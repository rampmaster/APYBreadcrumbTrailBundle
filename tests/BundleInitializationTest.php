<?php

namespace APY\BreadcrumbTrailBundle\Tests;

use APY\BreadcrumbTrailBundle\APYBreadcrumbTrailBundle;
use Nyholm\BundleTest\TestKernel;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

class BundleInitializationTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return TestKernel::class;
    }

    protected static function createKernel(array $options = []): KernelInterface
    {
        /**
         * @var TestKernel $kernel
         */
        $kernel = parent::createKernel($options);
        $kernel->addTestBundle(APYBreadcrumbTrailBundle::class);
        $kernel->handleOptions($options);

        return $kernel;
    }

    public function testServicesAreRegisteredToContainer()
    {
        $container = self::bootKernel()->getContainer();

        $this->assertTrue($container->has(\APY\BreadcrumbTrailBundle\BreadcrumbTrail\Trail::class));
        $this->assertTrue($container->has( \APY\BreadcrumbTrailBundle\EventListener\BreadcrumbListener::class));
        //$this->assertTrue($container->hasParameter('apy_breadcrumb_trail.template'));
    }
}
