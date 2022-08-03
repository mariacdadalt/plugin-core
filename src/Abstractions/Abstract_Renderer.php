<?php


namespace Plugin\Core\Abstractions;


abstract class Abstract_Renderer
{
    protected $sub_directory;
    protected $shared_dir;

    public function set_sub_directory( $dir ) {
        $this->sub_directory = $dir;
    }

    public function set_shared_dir( $dir ) {
        $this->shared_dir = $dir;
    }

    public abstract function set_args( $args );

    public abstract function render();

    public abstract function shared();
}
