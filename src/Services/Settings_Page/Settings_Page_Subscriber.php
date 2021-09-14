<?php

namespace WPillar\Core\Services\Settings_Page;

use WPillar\Core\Abstractions\Abstract_Subscriber;

class Settings_Page_Subscriber extends Abstract_Subscriber
{
    public const LOCAL_LANG_CODE = WPILLAR_LANG;

    public const PARENT_SLUG = 'step-main-menu';
    public const OPTIONS_SLUG = 'step-options-page';
    public const SETTINGS_SLUG = 'step-settings-page';

    public const FILTER_RENDER_RUNNER_PAGE = 'wpillar/core/services/settings-page/runners';

    public function subscribe()
    {
        add_action(
            'acf/init',
            function () {
                acf_add_options_page(
                    [
                        'page_title'  => __( 'Options Page', self::LOCAL_LANG_CODE ),
                        'menu_title'  => __( 'Options', self::LOCAL_LANG_CODE ),
                        'menu_slug'   => self::OPTIONS_SLUG,
                        'capability'  => 'manage_options',
                        'autoload'    => true,
                        'parent_slug' => self::PARENT_SLUG,
                        'position'    => '0.5'
                    ]
                );
            }
        );

        add_action(
            'admin_menu',
            function () {
                add_menu_page(
                    __( 'WPillar', self::LOCAL_LANG_CODE ),
                    __( 'WPillar', self::LOCAL_LANG_CODE ),
                    'manage_options',
                    self::PARENT_SLUG,
                    function() {
                        echo $this->container->get( Settings_Controller::class )->render( 'WPillar' );
                    },
                    '',
                    100
                );

                add_submenu_page(
                    self::PARENT_SLUG,
                    __( 'General Settings', self::LOCAL_LANG_CODE ),
                    __( 'General Settings', self::LOCAL_LANG_CODE ),
                    'manage_options',
                    self::SETTINGS_SLUG,
                    function() {
                        echo $this->container->get( Settings_Controller::class )->render();
                    },
                    -10
                );
            }
        );
    }
}
