<?php
/*

Copyright 2023-PLUGIN_TILL_YEAR Marcin Pietrzak (marcin@iworks.pl)

this program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( class_exists( 'iworks_post_h2_adverts_posttypes_post' ) ) {
	return;
}

require_once( dirname( dirname( __FILE__ ) ) . '/class-post-h2-adverts-posttypes.php' );

class iworks_post_h2_adverts_posttypes_post extends iworks_post_h2_adverts_posttypes {

	protected $post_type_name = 'post';

	public function __construct() {
		parent::__construct();
		/**
		 * hooks
		 */
		add_action( 'add_meta_boxes', array( $this, 'register_meta_boxes' ) );
		add_action( 'load-post-new.php', array( $this, 'prepare_admin_resouces' ) );
		add_action( 'load-post.php', array( $this, 'prepare_admin_resouces' ) );
		/**
		 * fields
		 */
		$this->fields = array(
			'basic' => array(),
		);
	}

	public function action_admin_enqueue_scripts() {
		global $iworks_post_h2_adverts_options;
		wp_enqueue_style( $iworks_post_h2_adverts_options->get_option_name( 'admin-common' ) );
	}

	public function prepare_admin_resouces() {
		add_action( 'admin_enqueue_scripts', array( $this, 'action_admin_enqueue_scripts' ) );
		$list = apply_filters( 'iworks-h2-adverts/get/list/array', array() );
		for ( $i = 1; $i < apply_filters( 'iworks-h2-adverts/get/max/number/h2', 0 ); $i++ ) {
			$this->fields['basic'][ $this->get_after_h2_name( $i ) ] = array(
				'type'  => 'select',
				'label' => sprintf(
					__( 'After H2 - %d', 'iworks-h2-posts' ),
					$i
				),
				'args'  => array(
					'options' => wp_parse_args(
						$list,
						array(
							'auto' => __( 'Auto', 'iworks-h2-adverts' ),
							'hide' => __( 'Hide', 'iworks-h2-adverts' ),
						)
					),
					'default' => 'show',
				),
			);
		}
	}

	public function register() {
	}

	public function save_post_meta( $post_id, $post, $update ) {
		$result = $this->save_post_meta_fields( $post_id, $post, $update, $this->fields );
	}

	public function register_meta_boxes( $post ) {
		add_meta_box( 'basic', __( 'H2 Adverts Configuration', 'iworks-h2-posts' ), array( $this, 'basic' ), $this->post_type_name );
	}

	public function basic( $post ) {
		$this->get_meta_box_content( $post, $this->fields, __FUNCTION__ );
	}

}

