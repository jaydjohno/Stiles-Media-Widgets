<?php

use AdminBarUserSwitching\Plugin as AdminBarUserSwitchingPlugin;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/functions/abus-core-functions.php';

// Define ABUS_PLUGIN_FILE
if (!defined('ABUS_PLUGIN_FILE')) {
    define('ABUS_PLUGIN_FILE', __FILE__);
}

// Define ABUS_PLUGIN_DIR
if (!defined('ABUS_PLUGIN_DIR')) {
    define('ABUS_PLUGIN_DIR', __DIR__);
}

// Define ABUS_PLUGIN_URL
if (!defined('ABUS_PLUGIN_URL')) {
    define('ABUS_PLUGIN_URL', plugins_url('', __FILE__) . '/');
}

// Define ABUS_PLUGIN_VERSION
if (!defined('ABUS_PLUGIN_VERSION')) {
    define('ABUS_PLUGIN_VERSION', '1.2');
}

// Define ABUS_PLUGIN_SLUG
if (!defined('ABUS_PLUGIN_SLUG')) {
    define('ABUS_PLUGIN_SLUG', 'admin-bar-user-switching');
}

/**
 * Main instance of AdminBarUserSwitching\.
 *
 * @return AdminBarUserSwitchingPlugin
 */
function AdminBarUserSwitching() {
    return AdminBarUserSwitchingPlugin::instance();
}

// Global for backwards compatibility.
$GLOBALS[ABUS_PLUGIN_SLUG] = AdminBarUserSwitching();
