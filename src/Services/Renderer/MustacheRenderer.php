<?php

declare(strict_types=1);

namespace Plugin\Core\Services\Renderer;

use Plugin\Core\Abstractions\AbstractRenderer;
use Mustache_Engine;
use Mustache_Loader_FilesystemLoader;

class MustacheRenderer extends AbstractRenderer
{
    /**
     * @var array
     */
    private $args;

    public function __construct()
    {
        $this->args = [
            'context' => [],
        ];
    }

    public function engine(): Mustache_Engine
    {
        return new Mustache_Engine(
            [
                'cache' => null,
                'loader' => new Mustache_Loader_FilesystemLoader(
                    $this->baseDir,
                    [
                        'extension' => '.html',
                    ]
                ),
                'entity_flags' => ENT_QUOTES,
            ]
        );
    }

    public function args(array $args): void
    {
        $this->args = array_merge($this->args, $args);
    }

    public function render(string $view = 'Index'): string
    {
        return $this->engine()->render($this->subDirectory . '/' . $view, $this->args['context']);
    }

    public function shared(string $view = 'Index'): string
    {
        return $this->engine()->render($this->sharedDir . '/' . $view, $this->args['context']);
    }
}
