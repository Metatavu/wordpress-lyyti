<?php
/*
 * Created on May 22, 2018
 * Plugin Name: Wordpress Lyyti integration
 * Description: Wordpress integration for Lyyti
 * Version: 1.0.0
 * Author: Metatavu Oy
 */

  defined ( 'ABSPATH' ) || die ( 'No script kiddies please!' );
  
  if (!defined('LYYTI_PLUGIN_DIR')) {
    define( 'LYYTI_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
  }

  require_once(__DIR__ . '/src/lyyti.php');
 
  add_action('plugins_loaded', function() {
    load_plugin_textdomain('lyyti', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );
  });

?>
