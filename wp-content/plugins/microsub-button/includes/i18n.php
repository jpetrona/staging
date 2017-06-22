<?php
/**
 * Internationalization
 */

function microsub_load_textdomain() {

	load_plugin_textdomain( 'microsub-button', false, MICROSUB_PATH . 'languages' );

}
add_action( 'plugins_loaded', 'microsub_load_textdomain' );
