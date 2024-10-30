<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://limecall.com
 * @since      1.0.0
 *
 * @package    Limecall_Widget
 * @subpackage Limecall_Widget/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Limecall_Widget
 * @subpackage Limecall_Widget/admin
 * @author     Limecall <contact@limecall.com>
 */
class Limecall_Widget_Admin {
    private $plugin_name;
    private $version;
    /**
	 * Initialize the class and set its properties.
	 */
    public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}
    /**
	 * Register the stylesheets for the admin area.
	 */
    public function enqueue_styles() {
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/limecall-admin.css', array(), $this->version, 'all' );
    }
    /**
	 * Register the JavaScript for the admin area.
	 */
    public function enqueue_scripts() {   
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/limecall-admin.js', array( 'jquery' ), $this->version, false );
    }
    /**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
     */
    public function add_plugin_admin_menu() {
        add_options_page( __('LimeCall settings', $this->plugin_name), 'LimeCall', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
	    );
    }
    /**
	 * Add settings action link to the plugins page.
	 */
    public function add_action_links( $links ) {
         $settings_link = array(
	    '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
	   );
	   return array_merge(  $settings_link, $links );
    }
    /**
	 * Render the settings page for this plugin.
	 */
    public function display_plugin_setup_page() {
		include_once( 'parts/limecall-admin-display.php' );
	}
    /**
	*  Save the plugin options
	*/
    public function options_update() {
		register_setting( $this->plugin_name, $this->plugin_name, array($this, 'validate') );
	}
    /**
	 * Validate all options fields
	 */
    public function validate($input) {
        // All checkboxes inputs
		$valid = array();

		// Cleanup
		$valid['code_limecall'] = (isset($input['code_limecall']) && !empty($input['code_limecall'])) ? $input['code_limecall'] : '';
		$valid['active_limecall'] = (isset($input['active_limecall']) && !empty($input['active_limecall'])) ? 1 : 0;
		$valid['show_limecall_logged_users'] = (isset($input['show_limecall_logged_users']) && !empty($input['show_limecall_logged_users'])) ? 1 : 0;

		if ( !strpos($valid['code_limecall'], 'limecall.com') || !preg_match('/<script[\s\S]*?>[\s\S]*?<\/script>/', $valid['code_limecall']) ) {
			$valid['code_limecall'] = '';

			add_settings_error(
                'login_button_primary_color',
                'login_button_primary_color_texterror',
                __('Please enter a valid Limecall code.', $this->plugin_name),
                'error'
            );
		}

		return $valid;

	}
}