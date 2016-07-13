<?php

/**
 * Setup admin for Ninja Forms testing
 *
 * @package   ingot_nf
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 Josh Pollock
 */

namespace ingot\addon\nf;

class admin {

	/**
	 * URL for the JS file
	 *
	 * @since 0.0.2
	 *
	 * @var string
	 */
	protected $url;

	/**
	 * admin constructor.
	 *
	 * @sicne 0.2.0
	 *
	 * @param string $url URL for the JS file
	 */
	public function __construct( $url ){

		$this->url = $url;
		add_action( 'admin_enqueue_scripts', [ $this, 'register_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'load_scripts' ] );
	}

	/**
	 * Register script
	 *
	 * @since 0.0.2
	 *
	 * @uses "admin_enqueue_scripts" action
	 */
	public function register_scripts(){
		wp_register_script( 'ingot-form-nf',  $this->url, [ 'ingot-admin-app' ]  );
		wp_localize_script( 'ingot-form-nf', 'INGOT_FORM_NF', $this->vars() );
	}

	/**
	 * Enqueue script
	 *
	 * @since 0.0.2
	 *
	 * @uses "admin_enqueue_scripts" action
	 *
	 * @param string $hook
	 */
	public function load_scripts( $hook ){
		if( 'toplevel_page_ingot-admin-app' == $hook ) {
			wp_enqueue_script( 'ingot-form-nf' );
		}

	}

	/**
	 * Prepare ID/names of forms to be localized
	 *
	 * @since 0.0.2
	 *
	 * @return array
	 */
	protected function vars(){
		$vars = [ 'forms' => [] ];
		$forms = $forms = \Ninja_Forms::instance()->forms( )->get_all();

		foreach ( $forms as $form ){
			$_form = Ninja_Forms()->form( $form );
			$vars[ 'forms' ][] = [
				'form_id' => $form,
				'name' => $_form->get_setting( 'form_title')
			];

		}

		return $vars;
	}
}
