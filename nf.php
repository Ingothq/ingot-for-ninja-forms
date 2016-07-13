<?php

use \ingot\addon\nf\cookies\tracking;
use \ingot\addon\nf\admin;
use \ingot\testing\utility\group;
use \ingot\addon\nf\cookies\init;


/**
 * When form submit starts register conversion if we can
 *
 * @since 0.0.2
 */
add_action( 'ninja_forms_before_pre_process', function( ){
	$session_detail = \Ninja_Forms::instance()->session->get( 'ingot-nf' );
	if( is_object( $details = json_decode( $session_detail ) ) ){
		ingot_register_conversion( $details->variant, $details->group );
		\Ninja_Forms::instance()->session->set( 'ingot-nf', false );
	}

});




/**
 * Load admin
 *
 * @since 0.0.2
 */
add_action( 'admin_init', function(  ) {
	new admin( plugin_dir_url( __FILE__ ) . 'assets/admin.js'  );
});

/**
 * Allow our click type
 *
 * @since 0.0.2
 */
add_filter( 'ingot_allowed_click_types', function(  $types ){
	$types[ 'form-nf'    ]     = [
		'name'        => __( 'Ninja Forms', 'ingot' ),
		'description' => __( 'Find which Ninja Forms converts the best', 'ingot' ),
	];

	return $types;
});

/**
 * Add our template
 *
 * @since 0.0.2
 */
add_filter( 'ingot_click_type_ui_urls', function( $urls ){
	$urls[ 'form-nf' ] = plugin_dir_url( __FILE__ ) . '/assets/ninja-forms.html';
	return $urls;
});

/**
 * Add translation strings to UI
 *
 * @since 0.0.2
 */
add_filter( 'ingot_ui_translation_strings', function( $strings ){
	$strings[ 'forms' ][ 'nf' ] = [
		'form' => esc_html__( 'Form', 'ingot-ninja-forms' ),
		'add_form' => esc_html__( 'Add Form', 'ingot-ninja-forms' ),
	];

	return $strings;

});

add_action( 'ingot_loaded', function(){
	include_once __DIR__ . '/vendor/autoload.php';
	\ingot\addon\nf\cookies\init::check();
});


/**
 * Add our callback function for rendering the form in front-end
 *
 * @since 0.0.2
 */
add_filter( 'ingot_click_test_custom_render_callback', function( $cb, $type ){
	if( 'form-nf' == $type ){
		$cb = 'ingot_nf_cb';

	}
	return $cb;
}, 10, 2);


/**
 * Callback to render the form
 *
 * @since 0.0.2
 *
 * @param array $group Group config
 *
 * @return string
 */
function ingot_nf_cb( $group ){
	include_once __DIR__ . '/classes/render.php';

	$variant_id = init::get_variant( $group[ 'ID' ] );
	$ui = new ingot\addon\nf\render( $group, $variant_id );
	return $ui->get_html();
}

/**
 * On presave set cookie tracking
 *
 * @since 0.0.2
 */
add_filter( 'ingot_crud_update', function( $data, $id, $what ){
	if( 'group' == $what ){
		$sub_type = group::sub_type( $data );
		if( 'form-nf' == $sub_type ){

			$tracking = tracking::get_instance()->is_tracking( $id );
			if( ! $tracking ) {
				tracking::get_instance()->add_to_tracking( $id );
				tracking::get_instance()->save();
			}

		}
	}

	return $data;
}, 10, 3);
