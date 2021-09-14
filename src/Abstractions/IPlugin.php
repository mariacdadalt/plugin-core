<?php


namespace WPillar\Core\Abstractions;

interface IPlugin {

    public static function get_subscribers() : array;
    public static function get_definers() : array;

    public static function set_constants() : void;
    public static function get_runners() : array;
    public static function get_dependencies() : array;
}
