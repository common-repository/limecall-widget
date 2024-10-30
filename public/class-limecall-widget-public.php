<?php

/**
 * The public-facing functionality of the plugin.
 */
class Limecall_Widget_Public {
    private $plugin_name;
    private $version;
    /**
	 * Initialize the class and set its properties.
	 */
    public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->limecall_options = get_option($this->plugin_name);
	}
    /**
	 * Register the stylesheets for the public-facing side of the site.
     */
    public function enqueue_styles() {
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/limecall-public.css', array(), $this->version, 'all' );
    }
    public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/limecall-public.js', array( 'jquery' ), $this->version, false );
	}
    public function init_limecall_injection() {
		// If LimeCall widget is enabled
		if ($this->limecall_options['active_limecall']) {
			// If user sets LimeCall code
			if ($this->limecall_options['code_limecall']) {
				// If show_limecall_logged_users is true, show widget to everybody
				if ($this->limecall_options['show_limecall_logged_users']) {
					add_action( 'wp_footer', array( $this, 'inject_limecall' ), 10 );	
				} else {
					// If show_limecall_logged_users is false, don't show widget to logged in users
					if ( !is_user_logged_in() ) {
						add_action( 'wp_footer', array( $this, 'inject_limecall' ), 10 );
					} 
				}			
			}
		}
	}
    public function inject_limecall() {
		echo $this->limecall_options['code_limecall'];
	}
    
}