<?php

declare(strict_types=1);

namespace Plugin\Core;

use DI\ContainerBuilder;
use Plugin\Core\Abstractions\AbstractComponent;
use Plugin\Core\Abstractions\AbstractPlugin;
use Psr\Container\ContainerInterface;

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
    public function init()
    {

        $this->initContainer();
    }

    /**
     * This function is used to register new plugins with the same DI Container.
     * @param AbstractPlugin $plugin
     */
    public function registerPlugin(AbstractPlugin $plugin): void
    {
        $plugin->defineConstants();
        $this->subscribers = array_merge($this->subscribers, $plugin->loadSubscribers());
        $this->definers = array_merge($this->definers, $plugin->loadDefiners());
        $this->cpts = array_merge($this->cpts, $plugin->loadCpts());
        $this->runners = array_merge($this->runners, $plugin->loadRunners());
        $this->dependencies = array_merge($this->dependencies, $plugin->loadDependencies());
        $this->components = array_merge($this->components, $plugin->loadComponents());
    }

    public function component(string $key): AbstractComponent
    {

        return new $this->components[$key]();
    }

    /**
     * Inits the DI Container
     *
     * @throws \Exception
     */
    private function initContainer(): void
    {

        /**
         * Filter the list of definers that power the plugin
         *
         * @param string[] $definers The class names of definers that will be instantiated
         */
        $this->definers = apply_filters(self::FILTER_DEFINERS, $this->definers);

        /**
         * Filter the list subscribers that power the plugin
         *
         * @param string[] $subscribers The class names of subscribers that will be instantiated
         */
        $this->subscribers = apply_filters(self::FILTER_SUBSCRIBERS, $this->subscribers);

        $builder = new ContainerBuilder();
        $builder->useAutowiring(true);
        $builder->useAnnotations(false);
        $builder->addDefinitions(... array_map(static function (string $classname): void {
            ( new $classname() )->define();
        }, $this->definers));

        $this->container = $builder->build();

        foreach ($this->subscribers as $subscriberClass) {
            ( new $subscriberClass($this->container) )->subscribe();
        }

        add_action(
            'init',
            function () {
                foreach ($this->cpts as $cptClass) {
                    ( new $cptClass() )->register();
                }
            }
        );
    }

    /**
     * Returns the container.
     *
     * @return ContainerInterface
     */
    public function container(): ContainerInterface
    {

        return $this->container;
    }

    /**
     * Cloning is forbidden.
     */
    public function __clone()
    {

        _doing_it_wrong(__FUNCTION__, 'Cloning is forbidden.', '1.0');
    }

    /**
     * Unserializing instances of this class is forbidden.
     */
    public function __wakeup()
    {

        _doing_it_wrong(__FUNCTION__, 'Wakeup is forbidden.', '1.0');
    }

    /**
     *
     * @return Plugin/Core/Core
     * @throws Exception
     */
    public static function instance(): Core
    {

        if (! isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
