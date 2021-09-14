<?php


namespace WPillar\Core\Classes;


class ACF_Conditional_Logic_Group
{
    protected array $conditional_logics;

    public function build() : array {

        $logics = [];

        foreach ( $this->conditional_logics as $logic ) {
            $logics[] = $logic->build();
        }
    }

    public function add_conditional_logic( ACF_Conditional_Logic $conditional ) : void {
        $this->conditional_logics[] = $conditional;
    }

}