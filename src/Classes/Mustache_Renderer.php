<?php

namespace WPillar\Core\Classes;

use WPillar\Core\Abstractions\Abstract_Renderer;
use \Mustache_Engine;
use \Mustache_Loader_FilesystemLoader;

class Mustache_Renderer extends Abstract_Renderer
{
    /**
     * @var Mustache_Engine
     */
    private $m;

    /**
     * @var array
     */
    private $args;

    public function __construct( string $dir_name ) {
        $this->m = new Mustache_Engine(
            [
                'cache'        => null,
                'loader'       => new Mustache_Loader_FilesystemLoader(
                    $dir_name,
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

    public function set_args($args)
    {
        $this->args = array_merge( $this->args, $args );
    }

    public function render( $view = 'Index' )
    {
        return $this->m->render( $this->sub_directory . '/' . $view, $this->args['context'] );
    }

    public function shared( $view = 'Index' )
    {
        return $this->m->render( $this->shared_dir . '/' . $view, $this->args['context'] );
    }
}
