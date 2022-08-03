<?php

namespace Plugin\Core\Abstractions;


use Plugin\Core\Classes\Mustache_Renderer;

abstract class Abstract_Component
{
    /**
     * The renderer passed to the controller in the provider.
     *
     * @var Abstract_Renderer
     */
    protected Abstract_Renderer $renderer;

    /**
     * The directory where the class is. Apply to its child.
     *
     * @var string
     */
    protected string $dir_name;

    protected bool $has_content = false;

    abstract static function key() : string;
    abstract function defaults() : array;

    public function __construct() {
        $obj = new \ReflectionClass($this);
        $this->renderer = new Mustache_Renderer( dirname( $obj->getFileName() ) );
        $this->dir_name = $this->getName();
    }

    /**
     * Inside function that returns the name of the class.
     *
     * @return mixed|string
     */
    protected function getName() {
        $path = explode( '\\', get_class( $this ) );
        array_pop( $path );
        return array_pop( $path );
    }

    /**
     * Call $this->renderer->render() for views inside the Component folder.
     *
     * @param string $view Use this parameter to render a view different than index.
     *
     * @return string
     */
    public function render( $view = '', $args = [] ) {
        if( empty( $view ) ) {
            $view = $this->dir_name .'_View';
        }
        $this->set_args( $args );

        if( $this->has_content ) {
            return $this->renderer->render( $view );
        }

        return '';
    }

    private function parse_args( array $args ) : array {
        return array_merge( $this->defaults(), $args );
    }

    public function get_context( $args = [] ) : array {

        return array_merge(
            [
                'classes' => '',
                'content' => '',
                'attributes' => ''
            ],
            $this->parse_args( $args )
        );
    }

    protected function set_args( array $args = [] ) {
        $context = [
            'context' => $this->get_context( $args ),
        ];

        if( ! empty( $context['context']['content'] ) ) {
            $this->has_content = true;
        }

        if( is_array( $context['context']['attributes'] ) ) {
            $context['context']['attributes'] = core_concat_attrs( $context['context']['attributes'] );
        }

        $this->renderer->set_args( $context );
    }
}