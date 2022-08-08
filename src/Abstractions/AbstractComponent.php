<?php

declare(strict_types=1);

namespace Plugin\Core\Abstractions;

use Plugin\Core\Classes\MustacheRenderer;

abstract class AbstractComponent
{
    /**
     * The renderer passed to the controller in the provider.
     *
     * @var AbstractRenderer
     */
    protected AbstractRenderer $renderer;

    /**
     * The directory where the class is. Apply to its child.
     *
     * @var string
     */
    protected string $dirName;

    protected bool $hasContent = false;

    abstract protected function key(): string;
    abstract protected function defaults(): array;

    public function __construct()
    {

        $obj = new \ReflectionClass($this);
        $this->renderer = new MustacheRenderer(dirname($obj->getFileName()));
        $this->dirName = $this->dirName();
    }

    /**
     * Inside function that returns the name of the class.
     *
     * @return string
     */
    protected function dirName(): string
    {

        $path = explode('\\', get_class($this));
        array_pop($path);
        return array_pop($path);
    }

    /**
     * Call $this->renderer->render() for views inside the Component folder.
     *
     * @param string $view Use this parameter to render a view different than index.
     *
     * @return string
     */
    public function render(string $view = '', array $args = []): string
    {

        if (empty($view)) {
            $view = $this->dirName . '_View';
        }
        $this->args($args);

        if ($this->hasContent) {
            return $this->renderer->render($view);
        }

        return '';
    }

    private function parseArgs(array $args): array
    {

        return array_merge($this->defaults(), $args);
    }

    public function context(array $args = []): array
    {

        return array_merge(
            [
                'classes' => '',
                'content' => '',
                'attributes' => '',
            ],
            $this->parseArgs($args)
        );
    }

    protected function args(array $args = []): void
    {

        $context = [
            'context' => $this->context($args),
        ];

        if (! empty($context['context']['content'])) {
            $this->hasContent = true;
        }

        if (is_array($context['context']['attributes'])) {
            $context['context']['attributes'] =
            core()->concatAttrs($context['context']['attributes']);
        }

        $this->renderer->args($context);
    }
}
