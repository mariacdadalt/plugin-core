<?php


namespace Plugin\Core\Classes;


class ACF_Conditional_Logic
{
    protected string $field = '';
    protected string $operator = '';
    protected string $value = '';

    const OP_HAS_ANY_VALUE = '!=empty';
    const OP_HAS_NO_VALUE = '==empty';
    const OP_IS_EQUAL_TO = '==';
    const OP_IS_NOT_EQUAL_TO = '!=';
    const OP_MATCHES_PATTERN = '==pattern';
    const OP_CONTAINS = '==contains';

    public function __construct(string $field, string $operator, string $value) {
        $this->field = $field;
        $this->value = $value;
        $this->operator = $operator;
    }

    public function build() : array {
        return [
            'field' => $this->field,
            'operator' => $this->operator,
            'value' => $this->value
        ];
    }

}