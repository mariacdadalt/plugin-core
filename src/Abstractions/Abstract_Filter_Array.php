<?php


namespace Plugin\Core\Abstractions;


abstract class Abstract_Filter_Array
{
    protected $args = [];

    abstract function change( array $value ) : array;

    protected function change_it(): bool
    {
        return false;
    }

    final function filter(array $value, $args = []) : array
    {
        $this->args = $args;
        if ( $this->change_it() ) {
            return $this->change( $value );
        }
        return $value;
    }
}
