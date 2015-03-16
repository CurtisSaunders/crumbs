<?php namespace Coreplex\Crumbs\Tests;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Coreplex\Crumbs\Container;
use Coreplex\Crumbs\Components\Crumb as Crumb;
use Coreplex\Crumbs\Renderers\Basic as BasicRenderer;

class RendererTest extends PHPUnit_Framework_TestCase {

    /**
     * Setup resources and dependencies.
     *
     * @return void
     */
    public function setUp()
    {

    }

    /**
     * Close mockery.
     *
     * @return void
     */
    public function tearDown()
    {
        m::close();
    }

    public function testRendererOutputsNonEmptyString()
    {
        $container = $this->makeContainer();

        $container->append('Google', '//www.google.com');

        $renderer = new BasicRenderer;

        $this->assertNotEmpty($renderer->render($container));
    }

    public function makeContainer()
    {
        return new Container(new Crumb, new BasicRenderer);
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object
     * @param string $methodName
     * @param array  $parameters
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

}