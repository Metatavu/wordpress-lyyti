<?php
/*
 * Created on May 22, 2018
 * Plugin Name: Wordpress Lyyti integration
 * Description: Wordpress integration for Lyyti
 * Version: 0.0.1
 * Author: Metatavu Oy
 */

  defined ( 'ABSPATH' ) || die ( 'No script kiddies please!' );
  
  require_once(LYYTI_PLUGIN_DIR . '/vendor/autoload.php');
  require_once(__DIR__ . '/settings/settings.php');
  require_once(__DIR__ . '/shortcodes/lyyti-shortcodes.php');
 
?>
