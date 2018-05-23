<?php
  namespace Metatavu\Lyyti\Settings;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  if (!class_exists( '\Metatavu\Lyyti\Settings\SettingsUI' ) ) {

    /**
     * UI for settings
     */
    class SettingsUI {

      /**
       * Constructor
       */
      public function __construct() {
        add_action('admin_init', array($this, 'adminInit'));
        add_action('admin_menu', array($this, 'adminMenu'));
      }

      /**
       * Admin menu action. Adds admin menu page
       */
      public function adminMenu() {
        add_options_page (__( "Lyyti Settings", 'lyyti' ), __( "Lyyti Settings", 'lyyti' ), 'manage_options', 'lyyti', [$this, 'settingsPage']);
      }

      /**
       * Admin init action. Registers settings
       */
      public function adminInit() {
        register_setting('lyyti', 'lyyti');
        add_settings_section('api', __( "API", 'lyyti' ), null, 'lyyti');
        $this->addOption('api', 'url', 'api-url', __( "API URL", 'lyyti'));
        $this->addOption('api', 'text', 'public-key', __( "Public Key", 'lyyti'));
        $this->addOption('api', 'text', 'private-key', __( "Private Key", 'lyyti'));
      }

      /**
       * Adds new option
       * 
       * @param string $group option group
       * @param string $type option type
       * @param string $name option name
       * @param string $title option title
       */
      private function addOption($group, $type, $name, $title) {
        add_settings_field($name, $title, array($this, 'createFieldUI'), 'lyyti', $group, [
          'name' => $name, 
          'type' => $type
        ]);
      }

      /**
       * Prints field UI
       * 
       * @param array $opts options
       */
      public function createFieldUI($opts) {
        $name = $opts['name'];
        $type = $opts['type'];
        $value = Settings::getValue($name);
        echo "<input id='$name' name='" . 'lyyti' . "[$name]' size='42' type='$type' value='$value' />";
      }

      /**
       * Prints settings page
       */
      public function settingsPage() {
        if (!current_user_can('manage_options')) {
          wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }

        echo '<div class="wrap">';
        echo "<h2>" . __( "Lyyti", 'lyyti') . "</h2>";
        echo '<form action="options.php" method="POST">';
        settings_fields('lyyti');
        do_settings_sections('lyyti');
        submit_button();
        echo "</form>";
        echo "</div>";
      }
    }

  }
  
  if (is_admin()) {
    $settingsUI = new SettingsUI();
  }

?>