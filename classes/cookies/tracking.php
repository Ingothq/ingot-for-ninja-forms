<?php
/**
 * Track forms via cookie
 *
 * @package   ingot_nf
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 Josh Pollock
 */

namespace ingot\addon\nf\cookies;




use ingot\testing\crud\group;

class tracking extends \ingot\testing\cookies\tracking {


	protected  $option_key = '_ingot_nf_tracking';

	/**
	 * @var tracking
	 */
	protected static $instance;

	/**
	 *
	 * @return tracking
	 */
	public static function get_instance(){
		if( null === static::$instance ){
			static::$instance = new self();
		}

		return static::$instance;
	}
	

}
