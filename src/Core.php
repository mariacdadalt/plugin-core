<?php

namespace Plugin\Core;

use DI\ContainerBuilder;
use Plugin\Core\Abstractions\Abstract_Plugin;
use Psr\Container\ContainerInterface;
use Plugin\Core\Abstractions\IPlugin;

final class Core
{
    public const FILTER_DEFINERS = 'plugin/core/definers';
    public const FILTER_SUBSCRIBERS = 'plugin/core/subscribers';

    /**
     * @var self
     */
    private static Core $instance;

    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * Array of Abstract_Subscriber classes' names.
     *
     * @var string[]
     */
    private array $subscribers = [];

    /**
     * Array of Abstract_Definer classes' names.
     *
     * @var string[]
     */
    private array $definers = [];

    /**
     * Array of Abstract_CPT classes' names.
     *
     * @var string[]
     */
    private array $cpts = [];

    /**
     * Array of Script_Runner classes' names.
     *
     * @var string[]
     */
    private array $runners = [];

    /**
     * Array of plugin names to activate by default.
     *
     * @var string[]
     */
    private array $dependencies = [];

    private array $components = [];

    /**
     * Function that inits the plugin.
     */
    public function init() {
        $this->init_container();
    }

    /**
     * This function is used to register new plugins with the same DI Container.
     * @param IPlugin $plugin
     */
    public function register_plugin( Abstract_Plugin $plugin ) {
        $this->subscribers = array_merge( $this->subscribers, $plugin->get_subscribers() );
        $this->definers    = array_merge( $this->definers, $plugin->get_definers() );
        $this->cpts    = array_merge( $this->cpts, $plugin->get_cpts() );
        $plugin->set_constants();
        $this->runners   = array_merge( $this->runners, $plugin->get_runners() );
        $this->dependencies = array_merge( $this->dependencies, $plugin->get_dependencies() );
        $this->components = array_merge( $this->components, $plugin->get_components() );
    }

    public function get_component( string $key ) {
        return new $this->components[$key];
    }

    /**
     * Return the list of Runners in the application.
     * @return string[]
     */
    public function get_runners() : array {
        return $this->runners;
    }

    /**
     * Return the list of Dependencies in the application.
     * @return string[]
     */
    public function get_dependencies() : array {
        return $this->dependencies;
    }

    /**
     * Inits the DI Container
     *
     * @throws \Exception
     */
    private function init_container() : void {

        /**
         * Filter the list of definers that power the plugin
         *
         * @param string[] $definers The class names of definers that will be instantiated
         */
        $this->definers = apply_filters( self::FILTER_DEFINERS, $this->definers );

        /**
         * Filter the list subscribers that power the plugin
         *
         * @param string[] $subscribers The class names of subscribers that will be instantiated
         */
        $this->subscribers = apply_filters( self::FILTER_SUBSCRIBERS, $this->subscribers );

        $builder = new ContainerBuilder();
        $builder->useAutowiring( true );
        $builder->useAnnotations( false );
        $builder->addDefinitions( ... array_map( static function ( $classname ) {
            return ( new $classname() )->define();
        }, $this->definers ) );

        $this->container = $builder->build();

        foreach ( $this->subscribers as $subscriber_class ) {
            ( new $subscriber_class( $this->container ) )->subscribe();
        }

        add_action(
            'init',
            function () {
                foreach ( $this->cpts as $cpt_class ) {
                    ( new $cpt_class )->register();
                }
            }
        );
    }

    /**
     * Returns the container.
     *
     * @return ContainerInterface
     */
    public function container(): ContainerInterface {
        return $this->container;
    }

    /**
     * Cloning is forbidden.
     */
    public function __clone() {
        _doing_it_wrong( __FUNCTION__, 'Cloning is forbidden.', '1.0' );
    }

    /**
     * Unserializing instances of this class is forbidden.
     */
    public function __wakeup() {
        _doing_it_wrong( __FUNCTION__, 'Wakeup is forbidden.', '1.0' );
    }

    /**
     *
     * @return Core
     * @throws Exception
     */
    public static function instance() {

        if ( ! isset( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
