<?php


namespace Plugin\Core\Abstractions;

/**
 * Interface ISubscriber. The classes that implements this interface
 * will hook with wordpress.
 * @package Plugin\Core\Abstractions
 */
interface ISubscriber
{
    public function subscribe();
}
