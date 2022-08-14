<?php

declare(strict_types=1);

namespace Plugin\Core\Services\Renderer;

use Plugin\Core\Abstractions\AbstractDefiner;
use Plugin\Core\Abstractions\AbstractRenderer;

/**
 * This class defines Dependency Injection for the Renderer Class
 */
class RendererDefiner extends AbstractDefiner
{
    public function define(): array
    {
        return [
            AbstractRenderer::class => \DI\create(MustacheRenderer::class),
        ];
    }
}
