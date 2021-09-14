<?php


namespace WPillar\Core\Abstractions;


use Psr\Container\ContainerInterface;

abstract class Abstract_Subscriber implements ISubscriber
{
    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * Abstract_Subscriber constructor.
     */
    public function __construct( ContainerInterface $container ) {
        $this->container = $container;
    }
}
