<?php


namespace WPillar\Core\Abstractions;


abstract class Abstract_Filter_String
{
    protected $args = [];

    abstract function change( string $value ) : string;

    protected function change_it(): bool
    {
        return false;
    }

    final function filter( string $value, $args = [] ) : string
    {
        $this->args = $args;
        if ( $this->change_it() ) {
            return $this->change( $value );
        }
        return $value;
    }
}
