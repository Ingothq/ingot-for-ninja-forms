<?php
/**
 * Output forms
 *
 * @package   ingot_nf
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 Josh Pollock
 */


namespace ingot\addon\nf;

use ingot\addon\nf\session;


class render extends \ingot\ui\render\click_tests\click {

	protected $form_id;

	/**
	 * Make HTML for to output and set in the html property of this class
	 *
	 * @since 0.0.2
	 *
	 * @access protected
	 */
	protected function make_html() {
		$group = $this->get_group()[ 'ID' ];
		$this->form_id = $this->get_variant_content();
		$session = new session(  $group, $this->get_chosen_variant_id() );
		\Ninja_Forms::instance()->session->set( 'ingot-nf', wp_json_encode( $session )  );
		ob_start();
		echo ninja_forms_display_form( $this->form_id );

		$this->html = ob_get_clean();
		

	}


}
