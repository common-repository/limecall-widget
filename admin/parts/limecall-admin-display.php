<?php
/* This file is used to markup the admin-facing aspects of the plugin.
*/
?>
<div class="wrap limecallwrap">

    <h1 class="plugin-title">
        <?php echo esc_html( get_admin_page_title() ); ?>
    </h1>
    <p class="find-limecall">
        <img src="<?php echo plugins_url('../imgs/find-limecall-icon.png', __FILE__);?>" alt="Find  Limecall Code in Dashboard on" class="find-limecall-check">
        <span><?php _e( 'Find  Limecall Code in Dashboard on ', $this->plugin_name ); ?> <a href="https://app.limecall.com/widgets" target="_blank">LimeCall.com</a></span>
    </p>
    <p class="settings">
        <img src="<?php echo plugins_url('../imgs/settings-icon.png', __FILE__);?>" alt="LimeCall Settings" class="settings-img">
        <span><?php _e( 'Settings ', $this->plugin_name ); ?></span>
    </p>
    
    <form method="post" name="cleanup_options" action="options.php" class="plugin-form">

        <?php
			// Default values
			$defaults = array (
				'active_limecall' => true,
				'show_limecall_logged_users' => true,
				'code_limecall' => ''
			);
        
			$options = get_option($this->plugin_name, $defaults);
			$options = wp_parse_args( $options, $defaults );

			// Cleanup
			$active_limecall = $options['active_limecall'];
			$show_limecall_logged_users = $options['show_limecall_logged_users'];
			$code_limecall = $options['code_limecall'];
		?>

        <?php
			settings_fields( $this->plugin_name );
			do_settings_sections( $this->plugin_name );
		?>
        <div class="full">
            <div class="field">
                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-active_limecall" name="<?php echo $this->plugin_name; ?>[active_limecall]" value="1" <?php checked($active_limecall, 1); ?> />
                <label for="<?php echo $this->plugin_name; ?>-active_limecall"></label>
                <span><?php _e('Display Limecall on website', $this->plugin_name); ?></span>
            </div>
            <div class="field">
                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-show_limecall_logged_users" name="<?php echo $this->plugin_name; ?>[show_limecall_logged_users]" value="1" <?php checked($show_limecall_logged_users, 1); ?> />
                <label for="<?php echo $this->plugin_name; ?>-show_limecall_logged_users"></label>
                <span><?php _e('Display Limecall to logged Users', $this->plugin_name); ?></span>
            </div>
        </div>

        <div class="field-textarea">
            <h2>
                <img src="<?php echo plugins_url('../imgs/insert-limecall.png', __FILE__);?>" alt="Insert LimeCall" class="insert-img"><span><?php _e( 'Insert Limecall code:', $this->plugin_name ); ?></span>
            </h2>
            <textarea name="<?php echo $this->plugin_name;?>[code_limecall]" id="<?php echo $this->plugin_name;?>-code_limecall" cols="50" rows="12" placeholder="<?php _e( 'Add LimeCall code here', $this->plugin_name ); ?>"><?php if(!empty($code_limecall)) echo $code_limecall;?></textarea>
        </div>
        
        <div class="buttons">
            <?php submit_button(__('Save', $this->plugin_name), 'primary','submit', TRUE); ?>
            <p class="submit">
                <a href="http://limecall.com/contact-us/" class="button button-primary" target="_blank">Contact us</a>
            </p>
            <p class="submit">
                <a href="http://limecall.com/how-it-works/" class="button button-primary" target="_blank">how it works</a>
            </p>
        </div>

    </form>

</div>