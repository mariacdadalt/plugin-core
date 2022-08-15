<?php

declare(strict_types=1);

namespace Plugin\Core\Abstractions;

use Psr\Container\ContainerInterface;
use DI\FactoryInterface;

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
    public function __construct(FactoryInterface $container)
    {

        $this->container = $container;
    }

    abstract public function subscribe();
}
