<?php


namespace WPillar\Core\Abstractions;

use WPillar\Core\Classes\Mustache_Renderer;

/**
 * Class Core_Controller implements Abstract Controller passing the src folder of the plugin.
 * @package Step\Core\Classes
 */
abstract class Core_Controller extends Abstract_Controller
{
    public function __construct() {
        parent::__construct( new Mustache_Renderer( dirname(__DIR__ ) ) );
    }
}
