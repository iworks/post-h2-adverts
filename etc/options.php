<?php

function iworks_post_h2_adverts_options() {
	$options = array();
	//$parent = SET SOME PAGE;
	/**
	 * main settings
	 */
	$options['index'] = array(
		'version'    => '0.0',
		'page_title' => __( 'Configuration', 'post-h2-adverts' ),
		'menu'       => 'options',
		// 'parent' => $parent,
		'options'    => array(),
		'metaboxes'  => array(),
		'pages'      => array(),
	);
	return $options;
}

