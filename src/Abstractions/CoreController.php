<?php

declare(strict_types=1);

namespace Plugin\Core\Abstractions;

use Plugin\Core\Services\Renderer\MustacheRenderer;

class CoreController extends AbstractController
{
    public function __construct()
    {
        parent::__construct(new MustacheRenderer(dirname(__DIR__)));
    }
}
