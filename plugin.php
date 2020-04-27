<?php

/**
 * Plugin Name: MailChimp for Gutenberg Forms
 * Plugin URI: https://www.gutenbergforms.com
 * Description: Mailchimp Addon for Gutenberg Forms lets you connect Mailchimp with your form. You can send leads to any of your lists in Mailchimp when a user submits the form.
 * Author: munirkamal
 * Author URI: https://cakewp.com/
 * Version: 1.0.0
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: cwp-gutenberg-forms-mailchimp-addon
 */
if ( ! function_exists( 'gutenbergformsmailchimpaddon' ) ) {
    // Create a helper function for easy SDK access.
    function gutenbergformsmailchimpaddon() {
        global $gutenbergformsmailchimpaddon;

        if ( ! isset( $gutenbergformsmailchimpaddon ) ) {
            // Include Freemius SDK.
            if ( file_exists( dirname( dirname( __FILE__ ) ) . '/forms-gutenberg/freemius/start.php' ) ) {
                // Try to load SDK from parent plugin folder.
                require_once dirname( dirname( __FILE__ ) ) . '/forms-gutenberg/freemius/start.php';
            } else if ( file_exists( dirname( dirname( __FILE__ ) ) . '/forms-gutenberg-premium/freemius/start.php' ) ) {
                // Try to load SDK from premium parent plugin folder.
                require_once dirname( dirname( __FILE__ ) ) . '/forms-gutenberg-premium/freemius/start.php';
            } else {
                require_once dirname(__FILE__) . '/freemius/start.php';
            }

            $gutenbergformsmailchimpaddon = fs_dynamic_init( array(
                'id'                  => '5959',
                'slug'                => 'cwp_gf_mailchimp',
                'type'                => 'plugin',
                'public_key'          => 'pk_28ef52963d0cc7b0b960d9c196da6',
                'is_premium'          => false,
                'has_paid_plans'      => false,
                'is_org_compliant'    => false,
                'parent'              => array(
                    'id'         => '5958',
                    'slug'       => 'forms-gutenberg',
                    'public_key' => 'pk_e4b04fdf3f1b35034e9031212ef90',
                    'name'       => 'Gutenberg Forms',
                ),
                'menu'                => array(
                    'first-path'     => 'plugins.php',
                    'account'        => false,
                    'support'        => false,
                ),
            ) );
        }

        return $gutenbergformsmailchimpaddon;
    }
}

function gutenbergformsmailchimpaddon_is_parent_active_and_loaded() {
    // Check if the parent's init SDK method exists.
    return function_exists( 'cwp_gf_fs' );
}

function gutenbergformsmailchimpaddon_is_parent_active() {
    $active_plugins = get_option( 'active_plugins', array() );

    if ( is_multisite() ) {
        $network_active_plugins = get_site_option( 'active_sitewide_plugins', array() );
        $active_plugins         = array_merge( $active_plugins, array_keys( $network_active_plugins ) );
    }

    foreach ( $active_plugins as $basename ) {
        if ( 0 === strpos( $basename, 'forms-gutenberg/' ) ||
             0 === strpos( $basename, 'forms-gutenberg-premium/' )
        ) {
            return true;
        }
    }

    return false;
}

function gutenbergformsmailchimpaddon_init() {
    if ( gutenbergformsmailchimpaddon_is_parent_active_and_loaded() ) {
        // Init Freemius.
        gutenbergformsmailchimpaddon();
        

        // Signal that the add-on's SDK was initiated.
        do_action( 'gutenbergformsmailchimpaddon_loaded' );

        // Parent is active, add your init code here.

    } else {
        // Parent is inactive, add your error handling here.
    }
}

if ( gutenbergformsmailchimpaddon_is_parent_active_and_loaded() ) {
    // If parent already included, init add-on.
    gutenbergformsmailchimpaddon_init();
} else if ( gutenbergformsmailchimpaddon_is_parent_active() ) {
    // Init add-on only after the parent is loaded.
    add_action( 'cwp_gf_fs_loaded', 'gutenbergformsmailchimpaddon_init' );
} else {
    // Even though the parent is not activated, execute add-on for activation / uninstall hooks.
    gutenbergformsmailchimpaddon_init();
}

require_once plugin_dir_path( __FILE__ ) . 'dist/init.php';