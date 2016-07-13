<?php
/**
 * Object for tracking groups in Ninja Forms session
 *
 * @package   ingot_nf
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 Josh Pollock
 */

namespace ingot\addon\nf;


class session {

	/** @var  int */
	public $group;

	/** @var  int */
	public $variant;

	/**
	 * session constructor.
	 *
	 * @param int $group
	 * @param int $variant
	 */
	public function __construct( $group, $variant ) {
		$this->group = $group;
		$this->variant = $variant;
	}
}