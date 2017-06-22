<?php
/**
 * Post Meta
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Register post meta box.
 */
function microsub_post_meta_register( $post_type = null ) {

	$args = array(
		'id'        => 'microsub-button',
		'title'     => esc_html__( 'Microsub Button', 'microsub-button' ),
		'post_type' => $post_type,
		'context'   => 'normal',
		'priority'  => 'low',
		'fields'    => array(
			'_microsub_account_id' => array(
				'name'       => esc_html__( 'Account Id', 'microsub-button' ),
				'desc'       => wp_kses(
					__( 'You need to get one on https://microsub.io', 'microsub-button' ),
					array( 'code' => array() )
				),
				'type'       => 'text',
				'allow_html' => false,
				'attributes' => array(
					'placeholder' => esc_attr__( 'Paste your account id here&hellip;', 'microsub-button' )
				),
				'class'      => 'code'
			),
			'_microsub_button_caption' => array(
				'name'       => esc_html__( 'Button Caption', 'microsub-button' ),
				'desc'       => wp_kses(
					__( 'The button caption.', 'microsub-button' ),
					array( 'code' => array() )
				),
				'type'       => 'text',
				'allow_html' => false,
				'attributes' => array(
					'placeholder' => esc_attr__( 'E.g. &ldquo;Support Us&rdquo;', 'microsub-button' )
				),
				'class'      => 'code'
			),
			'_microsub_button_eyes' => array(
				'name'       => esc_html__( 'Show Eyes', 'microsub-button' ),
				'desc'       => wp_kses(
					__( 'If the button has a pair of mouse tracking eyes.', 'microsub-button' ),
					array( 'code' => array() )
				),
				'type'       => 'checkbox',
				'class'      => 'code'
			),
            '_microsub_button_filter' => array(
                'name'       => esc_html__( 'Article Filter', 'microsub-button' ),
                'desc'       => wp_kses(
                    __( 'Comma separated items (e.g. author names)', 'microsub-button' ),
                    array( 'code' => array() )
                ),
                'type'       => 'textare',
                'allow_html' => false,
                'attributes' => array(
                    'placeholder' => esc_attr__( 'Required substrings to show the button', 'microsub-button' )
                ),
                'class'      => 'code'
            )
		)
	);

	new CT_Meta_Box( $args );

}

function microsub_post_meta_enable() {

	$post_types = get_post_types( array( 'public' => true ) );

	foreach ( $post_types as $post_type ) {
		microsub_post_meta_register( $post_type );
	}

}
add_action( 'admin_init', 'microsub_post_meta_enable' );
