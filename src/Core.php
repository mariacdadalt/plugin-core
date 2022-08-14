<?php

// phpcs:disable WordPress.PHP.DevelopmentFunctions

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

        /**
         * Filter the list subscribers that power the plugin
         *
         * @param string[] $subscribers The class names of subscribers that will be instantiated
         */
        $this->subscribers = apply_filters(self::FILTER_SUBSCRIBERS, $this->subscribers);

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

        /**
        * Force activate the required plugins.
        */
        add_filter(
            'option_active_plugins',
            static function ($plugins) {
                /*
                * Occasionally it seems a boolean can be passed in here.
                */
                if (! is_array($plugins)) {
                    return $plugins;
                }

                return core()->filterActivePlugins($plugins);
            },
            10,
            1
        );

        /**
        * Remove the option to deactivate the plugins that are required.
        */
        add_filter(
            'plugin_action_links',
            [ $this, 'filterActionLinks'],
            99,
            2
        );
    }

    /**
     * This function is used to register new plugins with the same DI Container.
     * @param AbstractPlugin $plugin
     */
    public function registerPlugin(AbstractPlugin $plugin): void
    {
        $plugin->defineConstants();
        $this->subscribers = array_merge($this->subscribers, $plugin->subscribers());
        $this->definers = array_merge($this->definers, $plugin->definers());
        $this->cpts = array_merge($this->cpts, $plugin->cpts());
        $this->runners = array_merge($this->runners, $plugin->runners());
        $this->dependencies = array_merge($this->dependencies, $plugin->dependencies());
        $this->components = array_merge($this->components, $plugin->components());
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

        $builder = new ContainerBuilder();
        $builder->useAutowiring(true);
        $builder->useAnnotations(false);
        foreach ($this->definers as $definer) {
            $builder->addDefinitions(( new $definer() )->define());
        }

        $this->container = $builder->build();
    }

    /**
    * Changes the array of active plugins to force active the ones that
    * are required.
    *
    * @param array $plugins
    * @return array
    * @throws Exception
    */
    public function filterActivePlugins(array $plugins): array
    {
        // Add our force-activated plugins
        $plugins = array_merge((array) $plugins, $this->dependencies);

        // Deduplicate
        $plugins = array_unique($plugins);

        return $plugins;
    }

    public function filterActionLinks(array $actions, string $pluginFile): array
    {
        if (in_array($pluginFile, $this->dependencies, true)) {
            unset($actions['deactivate']);
        }

        return $actions;
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
     * @return Core
     * @throws Exception
     */
    public static function instance(): self
    {
        if (! isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**************************************
     * HELPER FUNCTIONS
     **************************************/

    /**
    * Helper function to dump data in a readable way.
    *
    * @param $data
    */
    public function debug($data): void //phpcs:ignore
    {
        highlight_string("<?php\n\$data =\n" . var_export($data, true) . ";\n?>");
    }

    /**
    * Shorthand function for showing possible arguments for
    * a component.
    *
    * @param $key
    * @throws Exception
    */
    public function showComponentArgs(string $key): void
    {
        $component = core()->component($key);
        core()->debug($component->context());
    }

    /**
    * Helper function to concatenate an array of arguments
    *
    * @param array|null $attrs
    * @param string $prefix
    * @return string
    */
    public function concatAttrs(array $attrs = null, string $prefix = ''): string
    {

        if (empty($attrs)) {
            return '';
        }
        $out = [];
        $prefix = empty($prefix) ? '' : rtrim($prefix, '-') . '-';
        foreach ($attrs as $key => $value) {
            if (is_array($value)) {
                $out[] = core()->concatAttrs($value, $key);
                continue;
            }

            $out[] = sprintf('%s="%s"', $prefix . $key, esc_attr($value));
        }

        return implode(' ', $out);
    }

    /**
    * Shorthand function to get a component and render it;
    * @param string $key
    * @param array $args
    * @param string $view
    * @throws Exception
    */
    public function renderComponent(string $key, array $args = [], string $view = ''): void
    {
        $component = core()->component($key);
        echo esc_html($component->render($view, $args));
    }

    /**
    * This function will return your constant value, or a default value, if not defined.
    *
    * @param $name
    * @param null $default
    * @return object
    */
    public function constant(string $name, object $default = null): object
    {

        if (! defined($name)) {
            return $default;
        }

        $value = constant($name);

        if (empty($value)) {
            return $default;
        }

        $valueStr = strtolower(trim($value));
        if ('false' === $valueStr || 'true' === $valueStr) {
            return filter_var($valueStr, FILTER_VALIDATE_BOOLEAN);
        }

        if (is_numeric($value)) {
            return ( $value - 0 );
        }

        return $value;
    }

    /**
     * This function lists the currently defined constants.
     * Other possible categories are: all, core, pcre
     *
     * @param string $category Default for 'user'.
     */
    public function showDefinedConstants(string $category = 'user'): void
    {
        echo "<pre style='background-color:white'>";
        if ('all' === $category) {
            print_r(get_defined_constants(true));
        } else {
            $constants = get_defined_constants(true);
            print_r($constants[$category]);
        }
        echo "</pre>";
    }

    /**
     * This function will get a class name from a file name.
     * @see https://stackoverflow.com/questions/7153000/get-class-name-from-file/44654073
     *
     * @param $file
     * @return string
     */
    public function tokenizer(string $file): string
    {

        $fopen = fopen($file, 'r');
        $namespace = '';
        $class = $buffer = '';
        $i = 0;

        while (!$class) {
            if (feof($fopen)) {
                break;
            }

            $buffer .= fread($fopen, 512);
            $tokens = token_get_all($buffer);

            if (strpos($buffer, '{') === false) {
                continue;
            }

            for (; $i < count($tokens); $i++) {
                if ($tokens[$i][0] === T_NAMESPACE) {
                    for ($index = $i + 1; $index < count($tokens); $index++) {
                        if ($tokens[$index] === ';') {
                            break;
                        }
                        if ($tokens[$index][1] === ' ') {
                            continue;
                        }
                        $namespace .= $tokens[$index][1];
                    }
                }
                if ($tokens[$i][0] === T_CLASS) {
                    for ($index = $i + 1; $index < count($tokens); $index++) {
                        if ($tokens[$index] === '{') {
                            $class = $tokens[$i + 2][1];
                        }
                    }
                }
            }
        }

        return '\\' . $namespace . '\\' . $class;
    }
}
