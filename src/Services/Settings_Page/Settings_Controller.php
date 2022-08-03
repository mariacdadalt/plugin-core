<?php


namespace Plugin\Core\Services\Settings_Page;


use Plugin\Core\Abstractions\Core_Controller;

class Settings_Controller extends Core_Controller
{
    public function set_args(array $args = []) {
        $settings = array(
            [
                'name' => __( 'Registered Runners', Settings_Page_Subscriber::LOCAL_LANG_CODE ),
                'html' => '<p>' . __( 'This page exists as a way for you to trigger Runners without the use of a WP_CLI command', Settings_Page_Subscriber::LOCAL_LANG_CODE ) . '</p>',
            ],
        );

        $settings = apply_filters(Settings_Page_Subscriber::FILTER_RENDER_RUNNER_PAGE, $settings);

        $args = [
            'settings' => $settings,
        ];

        parent::set_args($args);
    }

}
