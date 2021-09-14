<?php


namespace WPillar\Core\Classes;


use WPillar\Core\Abstractions\Abstract_ACF_Field;

class ACF_Field_Text extends Abstract_ACF_Field
{
    protected string $default_value = '';
    protected string $placeholder = '';
    protected string $prepend = '';
    protected string $append = '';
    protected string $maxlength = '';

    protected function type(): string
    {
        return 'text';
    }

    public function build(): array
    {
        return array_merge(
            parent::build(),
            [
                'default_value' => $this->default_value,
                'placeholder' => $this->placeholder,
                'prepend' => $this->prepend,
                'append' => $this->append,
                'maxlength' => $this->maxlength
            ]
        );
    }

    public function set_default_value( string $value ) : void {
        $this->default_value = $value;
    }
}