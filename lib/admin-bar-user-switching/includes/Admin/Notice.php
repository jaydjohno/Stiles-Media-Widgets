<?php


namespace AdminBarUserSwitching\Admin;

defined('ABSPATH') || exit;

class Notice
{
    /**
     * Notice constructor.
     */
    public function __construct()
    {
        add_action( 'admin_notices', array( $this, 'error' ) );
    }

    /**
     * Deactivates the plugin and throws and error message when User Switching plugin not active
     *
     * @return void
     */
    public function error()
    {
        if ( ! class_exists( 'user_switching' ) ) {
            deactivate_plugins(ABUS_PLUGIN_SLUG . '/' . ABUS_PLUGIN_SLUG . '.php', ABUS_PLUGIN_SLUG . '.php');

            $html = '
                <div class="error">
                    <p>' . __( 'In order to use the <strong>User Switching in Admin Bar</strong> feature, you need to ensure you activate the user switching feature. The reason for this, is that it
                    requires the "User Switching" feature in order to work. Please activate the
                    "User Switching" feature, then enable this feature again. <strong>If the feature is activated, disable it and re-activate after you have turned the feature back on</strong>.', 'smt' ) . '</p>
                </div>
            ';

            echo $html;
        }
    }
}
