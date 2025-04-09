<?php

namespace APY\BreadcrumbTrailBundle\Tests\EventListener;

use APY\BreadcrumbTrailBundle\APYBreadcrumbTrailBundle;
use APY\BreadcrumbTrailBundle\BreadcrumbTrail\Trail;
use APY\BreadcrumbTrailBundle\Tests\Fixtures\ControllerWithAttributes;
use APY\BreadcrumbTrailBundle\Tests\Fixtures\ResetTrailAttribute;
use Nyholm\BundleTest\TestKernel;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class BreadcrumbListenerTest extends KernelTestCase
{
    /** @var BreadcrumbListener */
    private $listener;

    /** @var Trail */
    private $breadcrumbTrail;

    protected static function getKernelClass(): string
    {
        return TestKernel::class;
    }

    protected static function createKernel(array $options = []): KernelInterface
    {
        /** @var TestKernel $kernel */
        $kernel = parent::createKernel($options);
        $kernel->addTestBundle(APYBreadcrumbTrailBundle::class);
        $kernel->handleOptions($options);

        return $kernel;
    }

    protected function setUpTest(): void
    {
        $kernel = self::bootKernel();
        $this->listener = $kernel->getContainer()->get(\APY\BreadcrumbTrailBundle\EventListener\BreadcrumbListener::class);
        $this->breadcrumbTrail = $kernel->getContainer()->get(\APY\BreadcrumbTrailBundle\BreadcrumbTrail\Trail::class);
    }

    /**
     * @requires PHP >= 8.0
     */
    public function testAttributes()
    {
        $this->setUpTest();

        $controller = new ControllerWithAttributes();
        $kernelEvent = $this->createControllerEvent($controller);
        $this->listener->onKernelController($kernelEvent);

        self::assertCount(3, $this->breadcrumbTrail);
    }

    /**
     * @requires PHP >= 8.0
     */
    public function testResetTrailAttribute()
    {
        $this->setUpTest();

        $controller = new ResetTrailAttribute();
        $kernelEvent = $this->createControllerEvent($controller);
        $this->listener->onKernelController($kernelEvent);

        self::assertCount(1, $this->breadcrumbTrail);
    }

    protected function getBundleClass(): string
    {
        return APYBreadcrumbTrailBundle::class;
    }

    /**
     * @return ControllerEvent
     */
    private function createControllerEvent($controller)
    {
        $callable = \is_callable($controller) ? $controller : [$controller, 'indexAction'];

        return new ControllerEvent(self::$kernel, $callable, new Request(), HttpKernelInterface::MAIN_REQUEST);
    }
}
