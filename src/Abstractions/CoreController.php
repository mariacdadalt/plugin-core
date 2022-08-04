<?php

declare(strict_types=1);

namespace Plugin\Core\Abstractions;

use Plugin\Core\Classes\MustacheRenderer;

/**
 * Class Core_Controller implements Abstract Controller passing the src folder of the plugin.
 * @package Plugin\Core\Classes
 */
abstract class CoreController extends AbstractController
{
    public function __construct()
    {

        parent::__construct(new MustacheRenderer(dirname(__DIR__)));
    }
}
