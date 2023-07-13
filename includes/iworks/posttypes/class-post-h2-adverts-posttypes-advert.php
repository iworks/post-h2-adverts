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

if ( class_exists( 'iworks_post_h2_adverts_posttypes_advert' ) ) {
	return;
}

require_once( dirname( dirname( __FILE__ ) ) . '/class-post-h2-adverts-posttypes.php' );

class iworks_post_h2_adverts_posttypes_advert extends iworks_post_h2_adverts_posttypes {

	protected $post_type_name = 'iworks_h2_advert';

	public function __construct() {
		parent::__construct();
		/*
		 * hooks
		 */
		add_action( 'wp_body_open', array( $this, 'action_wp_body_open_turn_on_replacement' ) );
		add_filter( "manage_{$this->get_name()}_posts_columns", array( $this, 'add_columns' ) );
		add_action( 'manage_posts_custom_column', array( $this, 'custom_columns' ), 10, 2 );
		/**
		 * fields
		 */
		$this->fields = array(
			'basic' => array(
				'after_h2'      => array(
					'label' => __( 'After H2', 'iworks-h2-adverts' ),
					'type'  => 'number',
					'args'  => array(
						'default' => 1,
					),
				),
				'button_label'  => array(
					'label' => __( 'Button Label', 'iworks-h2-adverts' ),
				),
				'button_url'    => array(
					'label' => __( 'Button URL', 'iworks-h2-adverts' ),
				),
				'button_target' => array(
					'label' => __( 'Open in', 'iworks-h2-adverts' ),
					'type'  => 'radio',
					'args'  => array(
						'options' => array(
							'_blank' => __( 'New Tab', 'iworks-h2-adverts' ),
							'same'   => __( 'Same Tab', 'iworks-h2-adverts' ),
						),
						'default' => '_blank',
					),
				),
				'position'      => array(
					'type'  => 'radio',
					'label' => __( 'Position', 'iworks-h2-adverts' ),
					'args'  => array(
						'options' => array(
							'left'  => __( 'Left', 'iworks-h2-adverts' ),
							'right' => __( 'Right', 'iworks-h2-adverts' ),
						),
						'default' => 'left',
					),
				),
			),
		);
		/**
		 * add class to metaboxes
		 */
		foreach ( array_keys( $this->fields ) as $name ) {
			$key = sprintf( 'postbox_classes_%s_%s', $this->get_name(), $name );
			add_filter( $key, array( $this, 'add_defult_class_to_postbox' ) );
		}
	}

	public function action_wp_body_open_turn_on_replacement() {
		if ( ! is_single() ) {
			return;
		}
		add_filter( 'the_content', array( $this, 'filter_the_content_add_h2_advert' ) );
	}

	public function register() {
		$parent       = 'edit.php';
		$this->labels = array(
			'name'                  => _x( 'H2 Adverts', 'H2 Advert General Name', 'iworks-h2-adverts' ),
			'singular_name'         => _x( 'H2 Advert', 'H2 Advert Singular Name', 'iworks-h2-adverts' ),
			'menu_name'             => __( 'iworks-h2-adverts', 'iworks-h2-adverts' ),
			'name_admin_bar'        => __( 'H2 Advert', 'iworks-h2-adverts' ),
			'archives'              => __( 'H2 Adverts', 'iworks-h2-adverts' ),
			'attributes'            => __( 'Item Attributes', 'iworks-h2-adverts' ),
			'all_items'             => __( 'H2 Adverts', 'iworks-h2-adverts' ),
			'add_new_item'          => __( 'Add New H2 Advert', 'iworks-h2-adverts' ),
			'add_new'               => __( 'Add New H2 Advert', 'iworks-h2-adverts' ),
			'new_item'              => __( 'New H2 Advert', 'iworks-h2-adverts' ),
			'edit_item'             => __( 'Edit H2 Advert', 'iworks-h2-adverts' ),
			'update_item'           => __( 'Update H2 Advert', 'iworks-h2-adverts' ),
			'view_item'             => __( 'View H2 Advert', 'iworks-h2-adverts' ),
			'view_items'            => __( 'View H2 Adverts', 'iworks-h2-adverts' ),
			'search_items'          => __( 'Search person', 'iworks-h2-adverts' ),
			'not_found'             => __( 'Not found', 'iworks-h2-adverts' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'iworks-h2-adverts' ),
			'featured_image'        => __( 'Featured Image', 'iworks-h2-adverts' ),
			'set_featured_image'    => __( 'Set featured image', 'iworks-h2-adverts' ),
			'remove_featured_image' => __( 'Remove featured image', 'iworks-h2-adverts' ),
			'use_featured_image'    => __( 'Use as featured image', 'iworks-h2-adverts' ),
			'insert_into_item'      => __( 'Insert into item', 'iworks-h2-adverts' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'iworks-h2-adverts' ),
			'items_list'            => __( 'Items list', 'iworks-h2-adverts' ),
			'items_list_navigation' => __( 'Items list navigation', 'iworks-h2-adverts' ),
			'filter_items_list'     => __( 'Filter items list', 'iworks-h2-adverts' ),
		);
		$args         = array(
			'label'                => __( 'H2 Advert', 'iworks-h2-adverts' ),
			'labels'               => $this->labels,
			'supports'             => array( 'title', 'editor', 'thumbnail', 'revision' ),
			'hierarchical'         => false,
			'public'               => false,
			'show_ui'              => true,
			'show_in_menu'         => $parent,
			'show_in_admin_bar'    => true,
			'show_in_nav_menus'    => true,
			'can_export'           => true,
			'has_archive'          => false,
			'exclude_from_search'  => true,
			'publicly_queryable'   => false,
			'register_meta_box_cb' => array( $this, 'register_meta_boxes' ),
		);
		$args         = apply_filters( 'iworks-h2-adverts_register_person_post_type_args', $args );
		register_post_type( $this->post_type_name, $args );
	}

	public function save_post_meta( $post_id, $post, $update ) {
		$result = $this->save_post_meta_fields( $post_id, $post, $update, $this->fields );
	}

	public function register_meta_boxes( $post ) {
		add_meta_box( 'basic', __( 'H2 Advertal data', 'iworks-h2-adverts' ), array( $this, 'basic' ), $this->post_type_name );
	}

	public function basic( $post ) {
		$this->get_meta_box_content( $post, $this->fields, __FUNCTION__ );
	}

	/**
	 * Get custom column values.
	 *
	 * @since 1.0.0
	 *
	 * @param string $column Column name,
	 * @param integer $post_id Current post id (person),
	 *
	 */
	public function custom_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'after_h2':
			case 'position':
				$meta_name = $this->options->get_option_name( 'basic_' . $column );
				echo get_post_meta( $post_id, $meta_name, true );
				break;
		}
	}

	/**
	 * change default columns
	 *
	 * @since 1.0.0
	 *
	 * @param array $columns list of columns.
	 * @return array $columns list of columns.
	 */
	public function add_columns( $columns ) {
		unset( $columns['date'] );
		$columns['after_h2'] = __( '# H2', 'iworks-h2-adverts' );
		$columns['position'] = __( 'Position', 'iworks-h2-adverts' );
		return $columns;
	}

	/**
	 *
	 * @since 1.0.0
	 */
	public function filter_the_content_add_h2_advert( $content ) {
		if ( ! is_single() ) {
			return $content;
		}
		if ( ! is_main_query() ) {
			return $content;
		}
		if ( preg_match_all( '@(<h2.+</h2>)@', $content, $matches ) ) {
			$max  = count( $matches[0] );
			$args = array(
				'post_type'        => $this->post_type_name,
				'posts_per_page'   => 1,
				'orderby'          => 'rand',
				'fields'           => 'ids',
				'meta_query'       => array(
					'after_h2' => array(
						'key'   => $this->options->get_option_name( 'basic_after_h2' ),
						'value' => 0,
					),
				),
				'suppress_filters' => true,
			);
			for ( $i = 1; $i <= $max; $i++ ) {
				$args['meta_query']['after_h2']['value'] = $i;
				$query                                   = new WP_Query( $args );
				if ( $query->have_posts() ) {
					$unit = $this->get_unit( $query->posts[0] );
					if ( ! empty( $unit ) ) {
						$h2      = $matches[1][ $i - 1 ];
						$re      = sprintf( '@%s@', preg_replace( '/\?/', '\\?', $h2 ) );
						$content = preg_replace( $re, $h2 . $unit, $content );
					}
				}
			}
		}
		return $content;
	}

	private function get_unit( $post_id ) {
		$content      = '';
		$button_label = get_post_meta( $post_id, $this->options->get_option_name( 'basic_button_label' ), true );
		if ( empty( $button_label ) ) {
			return $content;
		}
		$button_url = get_post_meta( $post_id, $this->options->get_option_name( 'basic_button_url' ), true );
		if ( empty( $button_url ) ) {
			return $content;
		}
		/**
		 * classes
		 */
		$classes = array(
			'iworks-unit',
			'iworks-unit-#POSITION#',
		);
		/**
		 * target
		 */
		$button_target = get_post_meta( $post_id, $this->options->get_option_name( 'basic_button_target' ), true );
		if ( '_blank' === $button_target ) {
			$classes[] = 'iworks-unit-target_blank';
		}
		/**
		 * content
		 */
		$content  = '<!-- Unit: #ID# -->';
		$content .= sprintf(
			'<a class="#CLASS#" href="%s"%s>',
			esc_url( $button_url ),
			'_blank' === $button_target ? ' target="_blank"' : ''
		);
		if ( has_post_thumbnail( $post_id ) ) {
			$classes[] = 'iworks-unit-thumbnail';
			$content  .= get_the_post_thumbnail( $post_id );
		}
		$content .= '<div class="iworks-unit-content">';
		// $content .= sprintf(
			// '<p class="iworks-unit-title">%s</p>',
			// get_the_title( $post_id )
		// );
		$content .= get_the_content( null, false, $post_id );
		$content .= '<div class="iworks-unit-content-buttons">';
		$content .= sprintf(
			'<span class="button iworks-unit-button">%s</span>',
			esc_html( $button_label )
		);
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</a>';
		$content .= '<!-- /Unit: #ID# -->';
		/**
		 * replace CLASS
		 */
		$class   = esc_attr( implode( ' ', $classes ) );
		$content = preg_replace( '/#CLASS#/', $class, $content );
		/**
		 * replace: ID
		 */
		$content = preg_replace(
			'/#ID#/',
			$post_id,
			$content
		);
		/**
		 * replace: POSITION
		 */
		$content = preg_replace( '/#POSITION#/', get_post_meta( $post_id, $this->options->get_option_name( 'basic_position' ), true ), $content );
		/**
		 * return
		 */
		return $content;
	}
}

