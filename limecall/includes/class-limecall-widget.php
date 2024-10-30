<?php

/**
 * The file that defines the core plugin class
 */

class Limecall_Widget {
    protected $loader;
    protected $plugin_name;
    protected $version;
    /**
	 * Define the core functionality of the plugin.
	 */
    public function __construct() {
        $this->plugin_name = 'limecall-widget';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
    }
    /**
	 * Load the required dependencies for this plugin.
	 */
    private function load_dependencies() {
        /**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-limecall-widget-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-limecall-widget-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-limecall-widget-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-limecall-widget-public.php';

		$this->loader = new Limecall_Widget_Loader();
    }
    /**
	 * Define the locale for this plugin for internationalization.
	 */
    private function set_locale() {
        $plugin_i18n = new Limecall_Widget_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}
    /**
	 * Register all of the hooks related to the admin area functionality of the plugin.
     */
    private function define_admin_hooks() {

		$plugin_admin = new Limecall_Widget_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Save/Update our plugin options
		$this->loader->add_action('admin_init', $plugin_admin, 'options_update');

		// Add menu item
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );

		// Add Settings link to the plugin
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' );
		$this->loader->add_filter( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links' );

	}
    /**
	 * Register all of the hooks related to the public-facing functionality of the plugin.
     */
    private function define_public_hooks() {

		$plugin_public = new Limecall_Widget_Public( $this->get_plugin_name(), $this->get_version() );

		// The following actions are commented out as we won't need any added style or script to our plugin
		// $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		// $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'init', $plugin_public, 'init_limecall_injection' );

	}
    /**
	 * Run the loader to execute all of the hooks with WordPress.
     */
    public function run() {
		$this->loader->run();
	}
    /**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
     */
    public function get_plugin_name() {
		return $this->plugin_name;
	}
    /**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 */
    public function get_loader() {
		return $this->loader;
	}
    /**
	 * Retrieve the version number of the plugin.
	 */
    public function get_version() {
		return $this->version;
	}

}