<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @version       1.0.0
 * @package       JLT_Author_Bio
 * @license       Copyright JLT_Author_Bio
 */

if ( ! function_exists( 'jltauthorbio_options' ) ) {
	/**
	 * Get setting database option
	 *
	 * @param string $section default section name jltauthorbio_general .
	 * @param string $key .
	 * @param string $default .
	 *
	 * @return string
	 */
	function jltauthorbio_options( $option, $section, $default = '' ) {

	    $options = get_option( $section );

	    if ( isset( $options[$option] ) ) {
	        return $options[$option];
	    }

	    return $default;
	}
}


if ( ! function_exists( 'jltauthorbio_exclude_pages' ) ) {
	/**
	 * Get exclude pages setting option data
	 *
	 * @return string|array
	 *
	 * @version 1.0.0
	 */
	function jltauthorbio_exclude_pages() {
		return jltauthorbio_option( 'jltauthorbio_triggers', 'exclude_pages', array() );
	}
}


if ( ! function_exists( 'jltauthorbio_exclude_pages' ) ) {
	/**
	 * Get exclude pages except setting option data
	 *
	 * @return string|array
	 *
	 * @version 1.0.0
	 */
	function jltauthorbio_exclude_pages_except() {
		return jltauthorbio_option( 'jltauthorbio_triggers', 'exclude_pages_except', array() );
	}
}




/** 
 * Modify User Contact Methods
 */
function jltauthorbio_contact_methods( $user_contact ){

    /* Add user contact methods */
    $user_contact['facebook'] = __('Facebook Username'); 
    $user_contact['twitter'] = __('Twitter Username'); 
    $user_contact['linkedin'] = __('Linkedin Username'); 
    $user_contact['googleplus'] = __('Google Plus Username'); 
    $user_contact['pinterest'] = __('Pinterest Username'); 
    $user_contact['thumbler'] = __('Thumbler Username'); 
    $user_contact['flickr'] = __('Flickr Username'); 
    $user_contact['instagram'] = __('Instagram Username'); 
    $user_contact['dribbble'] = __('Dribbble Username'); 
    $user_contact['youtube'] = __('Youtube Username'); 

    /* Remove user contact methods */
    unset($user_contact['yim']);
    unset($user_contact['aim']);
    unset($user_contact['jabber']);

    return $user_contact;
}

add_filter('user_contactmethods', 'jltauthorbio_contact_methods');