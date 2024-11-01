<?php
/*
Plugin Name: WPServeur Helper
Plugin URI: http://
Description: Outils et liens utiles WPServeur
Version: 1.0
Author: Christophe Asselin de Beauville
Author URI: https://www.woltbase.com
License: GPL3
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
define( 'WPSH_PATH', plugin_dir_path( __FILE__ ) );
require_once('functions/functions.php');

/******************************************************************/

/* Ajoute une notice à l'activation du plugin */
function wpsh_notice_activated() {
  $user_id = get_current_user_id();
  if ( !get_user_meta( $user_id, 'wpsh_notice_dismissed' ) ) {
    ?>
    <div class="notice wps-h-notice is-dismissible">
        <p>Félicitations, vous avez activé le plugin <strong>WPSeveur Helper</strong> ! Cliquez sur le bouton suivant pour accéder à la page du plugin :</p>
        <p><a href="/wp-admin/admin.php?page=wpserveur-helper" class="wps-h-btn">WPServeur Helper</a></p>
        <?php echo '<p class="dismissNotice"><a href="' . add_query_arg( array( 'wpsh-dismissed' => 'true' )) . '">Cacher cette boîte définitivement</a></p>'; ?>
    </div>
    <?php
  }
}
add_action( 'admin_notices', 'wpsh_notice_activated' );
function wpsh_notice_dismissed() {
  $user_id = get_current_user_id();
  if (isset($_GET['wpsh-dismissed'])){
    if ($_GET['wpsh-dismissed'] == "true"){
      add_user_meta( $user_id, 'wpsh_notice_dismissed', 'true', true );
    }
  }
  else {
    $_GET['wpsh-dismissed'] = "";
  }
}
add_action( 'admin_init', 'wpsh_notice_dismissed' );

/******************************************************************/

add_action('admin_menu', 'wpsh_setup_menu');

function wpsh_setup_menu(){
        add_menu_page( 'WPServeur Helper Page', 'WPServeur Helper', 'manage_options', 'wpserveur-helper', 'wpsh_init', 'dashicons-wordpress-alt' );
}
/******************************************************************/

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'wpsh_action_links' );
function wpsh_action_links( $links ) {
   $links[] = '<a href="https://www.wpserveur.net/?refwps=206" target="blank">WPServeur</a>';
   return $links;
}

/******************************************************************/

/* Ajoute du style au plugin */
function wpsh_script() {
    wp_enqueue_style( 'wps_style', plugins_url( '/assets/css/wps_style.css', __FILE__ ) );
}
add_action( 'admin_enqueue_scripts', 'wpsh_script' );
?>
