<?php
/**
Plugin Name: Ingot for Caldera Ninja Forms
Version: 0.0.2
Plugin URI:  http://IngotHQ.com
Description: A/B Testing For Ninja Forms
Author:      Ingot LLC
Author URI:  http://IngotHQ.com
 */

/**
 * Copyright 2016 Ingot LLC
 *
 * Licensed under the terms of the GNU General Public License version 2 or later
 */

add_action( 'plugins_loaded', 'ingot_nf_load' );
function ingot_nf_load(){
	if ( class_exists( 'Caldera_Forms_Forms' ) && defined( 'INGOT_VER' ) && version_compare( PHP_VERSION, '5.4.0', '>=' ) && version_compare( INGOT_VER, '1.3.1-b-1', '>=' )) {
		include_once __DIR__ . '/vendor/autoload.php';
		include_once __DIR__ . '/nf.php';

		define( 'INGOT_nf_VER', '0.0.2' );
		define( 'INGOT_nf_CORE',  __FILE__ );
	}
}

