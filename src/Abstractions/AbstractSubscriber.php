<?php

declare(strict_types=1);

namespace Plugin\Core\Abstractions;

use Psr\Container\ContainerInterface;

/**
 * The classes that extends this will hook with WordPress.
 */
abstract class AbstractSubscriber
{
    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * Abstract_Subscriber constructor.
     */
    public function __construct(ContainerInterface $container)
    {

        $this->container = $container;
    }

    abstract public function subscribe();
}
