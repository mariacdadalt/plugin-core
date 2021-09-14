<?php

namespace WPillar\Core\Abstractions;


use WPillar\Core\Classes\ACF_Conditional_Logic_Group;

abstract class Abstract_ACF_Field
{
    protected string $label = '';
    protected string $name = '';
    protected string $instructions = '';
    protected bool $required = false;
    protected array $conditional_logic_groups = [];

    public function __construct( string $label, string $name ) {
        $this->label = $label;
        $this->name = $name;
    }

    public function build() : array {
        return [
            'key' => $this->key(),
            'label' => $this->label,
            'name' => $this->name,
            'type' => $this->type(),
            'instructions' => $this->instructions,
            'required' => (int) $this->required,
            'conditional_logic' => $this->conditional_logic(),
            'wrapper' => $this->wrapper
        ];
    }

    public function key() : string {
        return '';
    }

    protected abstract function type() : string;

    protected function conditional_logic() {
        if( empty( $this->conditional_logic_groups ) ) {
            return 0;
        }

        $logic_groups = [];

        foreach ( $this->conditional_logic_groups as $logic_group ) {
            $logic_groups[] = $logic_group->build();
        }
    }

    public function add_conditional_logic_group( ACF_Conditional_Logic_Group $conditional_group ) : void {
        $this->conditional_logic_groups[] = $conditional_group;
    }
}