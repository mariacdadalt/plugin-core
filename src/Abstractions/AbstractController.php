<?php

declare(strict_types=1);

namespace Plugin\Core\Abstractions;

abstract class AbstractController
{
    /**
     * The renderer passed to the controller in the provider.
     *
     * @var AbstractRenderer
     */
    protected $renderer;

    /**
     * The name of the class, without namespaces and "Controller"
     *
     * @var string
     */
    protected $className;

    protected $args = [];

    /**
     * Controller constructor.
     * The best way to change the Renderer for a controller is by
     * making a child of this class and giving it a Rendered that is a
     * child of the Abstract_Renderer.
     *
     * @param AbstractRenderer $renderer
     */
    public function __construct(AbstractRenderer $renderer)
    {
        $this->className = $this->className();
        $this->renderer = $renderer;
    }

    /**
     * Inside function that returns the name of the class controller.
     *
     * @return mixed|string
     */
    protected function className()
    {
        $path = explode('\\', get_class($this));
        array_pop($path);
        return array_pop($path);
    }

    /**
     * default:
     * [
     *    'content' => []
     * ]
     *
     * @param array $args
     */
    protected function args(array $args = [])
    {
        $this->args = [
            'context' => array_merge(
                [
                    'content' => '',
                ],
                $args
            ),
        ];
    }

    protected function subDirectory()
    {
        $this->renderer->subDirectory('Services/' . $this->className . '/Views');
    }

    /**
     * Call $this->renderer->render() for views inside the Controller folder.
     *
     * @param string $view Use this parameter to render a view different than index.
     *
     * @return string
     */
    public function render(array $args = [], string $view = 'Index'): string
    {
        $this->args($args);
        $this->subDirectory();
        core()->log($this->renderer);
        return $this->renderer->render($this->args['context'], $view);
    }

    /**
     * Call $this->renderer->shared() for views inside the Shared folder.
     *
     * @param string $view Use this parameter to render a view different than index.
     *
     * @return string
     */
    public function shared(array $args = [], string $view = 'Index'): string
    {
        $this->args($args);
        $this->renderer->sharedDir('Services/Shared/Views');
        return $this->renderer->shared($this->args['context'], $view);
    }
}
