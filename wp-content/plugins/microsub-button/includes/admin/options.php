<?php
/**
 * Options Page
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Register the options page.
 */
function microsub_register_options_page() {

	add_options_page(
		esc_html__( 'Microsub', 'microsub-button' ),
		esc_html__( 'Microsub', 'microsub-button' ),
		'manage_options',
		'microsub-button',
		'microsub_options_page'
	);

}
add_action( 'admin_menu', 'microsub_register_options_page' );

/**
 * Register setting, setting groups, and setting fields.
 */
function microsub_register_settings() {

	register_setting( 'microsub_options', 'microsub_options' );

	add_settings_section(
		'microsub',
		esc_html__( 'Button settings', 'microsub-button' ),
		'microsub_settings',
		'microsub-button'
	);

	add_settings_field(
		'microsub_account_id',
		esc_html__( 'Account Id', 'microsub-button' ),
		'microsub_settings_field_account_id',
		'microsub-button',
		'microsub'
	);

	add_settings_field(
		'microsub_button_caption',
		esc_html__( 'Button Caption', 'microsub-button' ),
		'microsub_settings_field_button_caption',
		'microsub-button',
		'microsub'
	);

	add_settings_field(
		'microsub_button_eyes',
		esc_html__( 'Show Eyes', 'microsub-button' ),
		'microsub_settings_field_button_eyes',
		'microsub-button',
		'microsub'
	);

	add_settings_field(
		'microsub_button_filter',
		esc_html__( 'Article Filter', 'microsub-button' ),
		'microsub_settings_field_button_filter',
		'microsub-button',
		'microsub'
	);

}
add_action( 'admin_init', 'microsub_register_settings' );

/**
 * Output the description for Head Code.
 */
function microsub_settings() {

	printf(
		'<p>%s</p>',
		wp_kses(
			__( 'Sign up and create an account at https://microsub.io to get your account id.' ),
			array( 'code' => array() )
		)
	);

}

/**
 * Output the field for Account Id.
 */
function microsub_settings_field_account_id() {

	$options = get_option( 'microsub_options' );

	?>

	<input
		id="$microsub_account_id"
		type="text"
		name="microsub_options[microsub_account_id]"
		class="large-text code"
		placeholder="<?php esc_attr_e( 'Paste your account id here&hellip;', 'microsub-button' ); ?>"
		value="<?php echo esc_attr_e( $options['microsub_account_id'] ); ?>"
	></input>

	<?php

}

/**
 * Output the field for Button Caption.
 */
function microsub_settings_field_button_caption() {

	$options = get_option( 'microsub_options' );

	?>

	<input
    		id="microsub_button_caption"
    		type="text"
    		name="microsub_options[microsub_button_caption]"
    		class="large-text code"
    		placeholder="<?php esc_attr_e( 'E.g. &ldquo;Support Us&rdquo;', 'microsub-button' ); ?>"
    		value="<?php echo esc_attr_e( $options['microsub_button_caption'] ); ?>"
    	></input>
    	<?php
}

/**
 * Output the field for Button Eyes.
 */
function microsub_settings_field_button_eyes() {

	$options = get_option( 'microsub_options' );

	?>

	<input
    		id="microsub_button_eyes"
    		type="checkbox"
    		name="microsub_options[microsub_button_eyes]"
    		value="1"
    		<?php checked(isset($options['microsub_button_eyes'])); ?>
    	></input><br/><?php echo esc_html__('If the button has a pair of mouse tracking eyes.'); ?>
    	<?php
}

/**
 * Output the field for Article Filter.
 */
function microsub_settings_field_button_filter() {

	$options = get_option( 'microsub_options' );

	?>

	<textarea
    		id="microsub_button_filter"
    		name="microsub_options[microsub_button_filter]"
    		class="large-text code"
    		placeholder="<?php esc_attr_e( 'Comma separated items (e.g. author names)', 'microsub-button' ); ?>"
    	><?php echo esc_attr_e( $options['microsub_button_filter'] ); ?></textarea>
    	<?php
}

/**
 * Output the options page.
 */
function microsub_options_page() {

	$message = sprintf(
		wp_kses(
			__( 'If you&rsquo;ve found this plugin useful or interesting, please <a href=\"%s\" target=\"_blank\">let us know</a> your opinion.', 'microsub-button' ),
			array( 'a' => array(
				'href'   => array(),
				'target' => array()
			) )
		),
		'https://microsub.io'
	);

	?>

	<div class="wrap">
		<h2><?php esc_html_e( 'Microsub', 'microsub-button' ); ?></h2>

		<form action="options.php" method="post">
			<?php

			settings_fields( 'microsub_options' );
			do_settings_sections( 'microsub-button' );
			submit_button();

			?>
		</form>

		<p><?php echo $message; ?></p>
	</div>

	<?php

}
