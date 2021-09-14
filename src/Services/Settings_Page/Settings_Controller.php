<?php


namespace WPillar\Core\Services\Settings_Page;


use WPillar\Core\Abstractions\Core_Controller;

class Settings_Controller extends Core_Controller
{
    public function set_args(array $args = []) {
        $settings = array(
            [
                'name' => __('Registered Runners', ROPE_LANG),
                'html' => '<p>' . __('This page exists as a way for you to trigger Runners without the use of a WP_CLI command', ROPE_LANG) . '</p>',
            ],
        );

        $settings = apply_filters(Settings_Page_Subscriber::FILTER_RENDER_RUNNER_PAGE, $settings);

        $args = [
            'settings' => $settings,
        ];

        parent::set_args($args);
    }

}
