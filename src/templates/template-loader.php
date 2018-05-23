<?php
  namespace Metatavu\Lyyti;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  require_once(LYYTI_PLUGIN_DIR . '/src/dependencies/classes/gamajo/template-loader/class-gamajo-template-loader.php');
  
  if (!class_exists( 'Metatavu\Lyyti\TemplateLoader' ) ) {
    
    /**
     * Template loader for Lyyti
     */
    class TemplateLoader extends \Lyyti_Gamajo_Template_Loader {

      /**
       * Constructor
       */
      public function __construct() {
        $this->filter_prefix = 'lyyti';
        $this->theme_template_directory = 'lyyti';
        $this->plugin_directory = LYYTI_PLUGIN_DIR;
        $this->plugin_template_directory = 'default-templates';
      }
    }
  }
  
?>
