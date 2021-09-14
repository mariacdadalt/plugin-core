<?php


namespace WPillar\Core\Abstractions;

/**
 * Interface ISubscriber. The classes that implements this interface
 * will hook with wordpress.
 * @package WPillar\Core\Abstractions
 */
interface ISubscriber
{
    public function subscribe();
}
