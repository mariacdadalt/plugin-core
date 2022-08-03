<?php


namespace Plugin\Core\Abstractions;


use Psr\Container\ContainerInterface;

/**
 * The classes that extends this will hook with wordpress.
 */
abstract class Abstract_Subscriber
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

	public abstract function subscribe();
}
