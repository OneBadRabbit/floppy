<?PHP

defined ( 'ABSPATH' ) OR exit;

/*
 * Plugin Name: OBR Floppy
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
add_action ( 'admin_menu' , 'obr_add_new' );

function obr_add_new() { 
    
    add_menu_page( 
        'AWP Floppy',
        'AWP Floppy',
        'manage_options',
        'awpfloppy',
        'awp_create_cards',
        plugin_dir_url( __FILE__ . 'images/obrFloppy_icon.png',
        20
    );

)

function obr_admin_enqueue ( $hook ) {
    if ('edit.php' != $hook ) { 
        return;
    }
    wp_enqueue_script ( 'style.css', plugin_dir_url( __FILE__ ) . '/css/style.css', array(), '1.0.0' );

}


add_action ( 'admin_enqueue_scripts', 'obr_admin_enqueue' );

/*
 * Get New Card Form
*/

function obr_create_cards () { 

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

function obr_list_cards () { 

    global $wpdb;

    echo 'I am Showing the Created Cards List ';

    $query = "SELECT * FROM flippityFlop";
    // Run & Build table

}


/*
 * Shortcodes
 * 
*/

add_shortcode( 'obrshort', 'obr_shortcode' );

function obr_shortcode ( $atts = [], $flippinID = null ) { 

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

    $sql = "CREATE TABLE flippityFlop ( 
        flippinID           INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        flippinName         VARCHAR(50),
        flippinQuestion     VARCHAR(255),
        flippinAnswer       VARCHAR(255),
        flippinType         VARCHAR(5)
        )
    ";

    require_once ( ABSPATH . 'wp-admin/includes/upgrade.php' );
    if ( dbDelta ( $sql ) ) { 
        echo 'Installed Ok!';
    }
    
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