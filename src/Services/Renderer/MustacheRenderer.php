<?php

declare(strict_types=1);

namespace Plugin\Core\Services\Renderer;

use Plugin\Core\Abstractions\AbstractRenderer;
use Mustache_Engine;
use Mustache_Loader_FilesystemLoader;

class MustacheRenderer extends AbstractRenderer
{
    /**
     * @var Mustache_Engine
     */
    private $engine;

    public function __construct(string $baseDir)
    {
        $this->engine = new Mustache_Engine(
            [
                'cache' => null,
                'loader' => new Mustache_Loader_FilesystemLoader(
                    $baseDir,
                    [
                        'extension' => '.html',
                    ]
                ),
                'entity_flags' => ENT_QUOTES,
            ]
        );
    }

    public function render(array $args = [], string $view = 'Index'): string
    {
        return $this->engine->render($this->subDirectory . '/' . $view, $args);
    }

    public function shared(array $args = [], string $view = 'Index'): string
    {
        return $this->engine->render($this->sharedDir . '/' . $view, $args);
    }
}
