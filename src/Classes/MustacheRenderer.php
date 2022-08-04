<?php

declare(strict_types=1);

namespace Plugin\Core\Classes;

use Plugin\Core\Abstractions\AbstractRenderer;
use Mustache_Engine;
use Mustache_Loader_FilesystemLoader;

class MustacheRenderer extends AbstractRenderer
{
    /**
     * @var Mustache_Engine
     */
    private $mEngine;

    /**
     * @var array
     */
    private $args;

    public function __construct(string $dirName)
    {

        $this->mEngine = new Mustache_Engine(
            [
                'cache' => null,
                'loader' => new Mustache_Loader_FilesystemLoader(
                    $dirName,
                    [
                        'extension' => '.html',
                    ]
                ),
                'entity_flags' => ENT_QUOTES,
            ]
        );

        $this->args = [
            'context' => [],
        ];
    }

    public function args(array $args): void
    {
        $this->args = array_merge($this->args, $args);
    }

    public function render(string $view = 'Index'): string
    {
        return $this->mEngine->render($this->subDirectory . '/' . $view, $this->args['context']);
    }

    public function shared(string $view = 'Index'): string
    {
        return $this->mEngine->render($this->sharedDir . '/' . $view, $this->args['context']);
    }
}
