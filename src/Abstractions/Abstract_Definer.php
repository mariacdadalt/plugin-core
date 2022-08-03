<?php


namespace Plugin\Core\Abstractions;


/**
 * The classes that extends this
 * will define dependencies for the PHP_DI.
 */
abstract class Abstract_Definer
{
	public abstract function define();
}
