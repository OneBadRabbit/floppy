<?PHP

defined ( 'ABSPATH' ) OR exit;

/*
 * Plugin Name: AWP Floppy
 * Plugin Url: https://onebadrabbit.com
 * Description: Extremely simplified flash card tool. Accepts images and text as questions and answers.
 * Version: 1.0.0
 * Requires at least: 6.0
 * Requires PHP: 7.2
 * Author: OneBadRabbit
 * Author Url: https://onebadrabbit.com
 * License: GPL v2 or later
 * License Url: https://www.gnu.org/licenses/gpl-2.0.html
 * text-domain: awp-floppy
 */

/*
 * Admin Menu?
*/
add_action ( 'admin_menu' , 'awp_add_new' );

function awp_add_new() { 
    
    add_menu_page( 
        'AWP Floppy',
        'AWP Floppy',
        'manage_options',
        'awpfloppy',
        'awp_create_cards',
        plugin_dir_url( __FILE__ . 'images/awpFloppy_icon.png',
        20
    );

)

/*
 * Get New Card Form
*/

function awp_create_cards () { 

    if ( !$_POST ) { 
        $values = array();
    } else { 
        $values = $_POST;
    }
    
    if ( current_user_can ( 'edit_posts' ) ) { 

        echo ' I am Creating a New Card ';
        include ( plugin_dir_url . "include/forms/newCardForm.php" );

    } else {

        echo " You are Not Allowed! ";

    }

}

/*
 * Show Card List w/ shortcodes
*/

function awp_list_cards () { 

    echo 'I am Showing the Created Cards List ';

}


/*
 * Shortcodes
 * 
*/

add_shortcode( 'awpshort', 'awp_shortcode' );

function awp_shortcode ( $atts = [], $awpID = null ) { 

    global $wpdb;

    // Go Get & Return Card Content for Post Page

}

/*
 * activate plugin
*/

function init() { 

    global $wpdb;

    // Make Me Install
    if ( ! current_user_can ( 'activate_plugins' ) ) { 
        return;
    }

    $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
    check_admin_referer( "activate-plugin_{$plugin}" );

    // Install Database Tables

    // Exit with actions taken - Comment out when done.
    exit( var_dump( $_GET ) );

}

/*
 * Deactivate plugin
*/

function shushIt() { 

    // Make Me Go Silent
    if ( ! current_user_can ( 'activate_plugins' ) ) { 
        return;
    }
    
    $plugin = isset ( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
    check_admin_referer( "deactivate-plugin_{$plugin]" );

    flush_rewrite_rules();

    // Exit with actions taken - Comment out when done.
    exit( var_dump( $_GET ) );

}

/*
 * Uninstall plugin
*/

function killIt() { 

    global $wpdb;

    if ( ! current_user_can ( 'activate_plugins' ) ) { 
        return;
    }

    // Death to You!
    // But.... Deactivate me First to flush cache

    shushIt();

    check_admin_referer ( 'bulk-plugins' );

    if ( __FILE__ != WP_UNINSTALL_PLUGIN ) { 
        return;
    }

    // Drop Database
    //$drop_query = "DROP TABLE flippityflop";

    // Exit with actions taken - Comment out when done.s
    exit( var_dump ( $_GET ) );

}

/*
 * Register Hooks
*/

register_activation_hook ( __FILE__, 'init' );
register_deactivation_hook ( __FILE__, 'shushIt' );
register_uninstall_hook ( __FILE__, 'killIt' );

?>