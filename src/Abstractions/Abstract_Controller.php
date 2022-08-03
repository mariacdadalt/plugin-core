<?php

namespace Plugin\Core\Abstractions;


abstract class Abstract_Controller
{
    /**
     * The renderer passed to the controller in the provider.
     *
     * @var Abstract_Renderer
     */
    protected $renderer;

    /**
     * The directory where the class is. Apply to its child.
     *
     * @var string
     */
    protected $dir_name;

    /**
     * Controller constructor.
     * The best way to change the Renderer for a controller is by
     * making a child of this class and giving it a Rendered that is a
     * child of the Abstract_Renderer.
     *
     * @param Abstract_Renderer $renderer
     */
    public function __construct( Abstract_Renderer $renderer ) {
        $this->renderer = $renderer;
        $this->dir_name = $this->getName();
    }

    /**
     * Inside function that returns the name of the class controller.
     *
     * @return mixed|string
     */
    protected function getName() {
        $path = explode( '\\', get_class( $this ) );
        array_pop( $path );
        return array_pop( $path );
    }

    /**
     * default:
     * [
     *    'content' => []
     * ]
     *
     * @param array $args
     */
    public function set_args( array $args = [] ) {
        $context = [
            'context' => array_merge(
                [
                    'content' => '',
                ],
                $args
            ),
        ];
        $this->renderer->set_args( $context );
    }

    protected function set_sub_directory() {
        $this->renderer->set_sub_directory( 'Services/' . $this->dir_name . '/Views' );
    }

    /**
     * Call $this->renderer->render() for views inside the Controller folder.
     *
     * @param string $view Use this parameter to render a view different than index.
     *
     * @return string
     */
    public function render( $view = 'Index' ) {
        $this->set_args();
        $this->set_sub_directory();
        return $this->renderer->render( $view );
    }

    /**
     * Call $this->renderer->shared() for views inside the Shared folder.
     *
     * @param string $view Use this parameter to render a view different than index.
     *
     * @return string
     */
    public function shared( $view = 'Index' ) {
        $this->set_args();
        $this->renderer->set_shared_dir( 'Shared_Views' );
        return $this->renderer->shared( $view );
    }
}
