<?php


namespace Plugin\Core\Abstractions;


abstract class Abstract_Plugin
{

    public function get_subscribers(): array
    {
        $reflection_class = new \ReflectionClass( get_called_class() );

        $class_array = [];
        foreach (glob(dirname( $reflection_class->getFileName() ) . '/Services/**/*_Subscriber.php') as $file ) {
            $class_array[] = core_tokenizer( $file );
        }
        return $class_array;
    }

    public function get_definers(): array
    {
        $reflection_class = new \ReflectionClass( get_called_class() );

        $class_array = [];
        foreach (glob(dirname( $reflection_class->getFileName() ) . '/Services/**/*_Definer.php') as $file ) {
            $class_array[] = core_tokenizer( $file );
        }
        return $class_array;
    }

    public function get_runners(): array
    {
        $reflection_class = new \ReflectionClass( get_called_class() );

        $class_array = [];
        foreach (glob(dirname( $reflection_class->getFileName() ) . '/Services/**/*_Runner.php') as $file ) {
            $class_array[] = core_tokenizer( $file );
        }
        return $class_array;
    }

    public function get_components(): array
    {
        $reflection_class = new \ReflectionClass( get_called_class() );

        $component_array = [];
        foreach (glob(dirname( $reflection_class->getFileName() ) . '/Components/**/*_Component.php') as $file ) {
            $component_class = core_tokenizer( $file );
            $component_array[ $component_class::key() ] = $component_class;
        }
        return $component_array;
    }

    public function get_cpts(): array
    {
        $reflection_class = new \ReflectionClass( get_called_class() );

        $class_array = [];
        foreach (glob(dirname( $reflection_class->getFileName() ) . '/Services/**/*_CPT.php') as $file ) {
            $class_array[] = core_tokenizer( $file );
        }
        return $class_array;
    }

    abstract function set_constants(): void;

    abstract function get_dependencies(): array;
}
