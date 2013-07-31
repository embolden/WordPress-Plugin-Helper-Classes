<?php
/*
 * Custom Post Type Helper
 */
if( ! class_exists( 'CustomPostType' ) ) :
class CustomPostType {

	public $post_type_name;
	public $post_type_plural;
	public $post_type_args;

	function __construct( $name, $plural, $args = array() ) {
		$this->post_type_name = $name;
		$this->post_type_plural = $plural;
		$this->post_type_args = $args;

		if( ! post_type_exists( strtolower( $name ) ) ) {
			add_action( 'init', array( $this, 'register_post_type' ) );
		}
	}

	function register_post_type() {
		$name = $this->post_type_name;
		$plural = $this->post_type_plural;

		$labels = array(
			'name'                => _x( $plural, 'Post Type General Name', '_s' ),
			'singular_name'       => _x( $name, 'Post Type Singular Name', '_s' ),
			'menu_name'           => __( $plural, '_s' ),
			'parent_item_colon'   => __( 'Parent ' . $name . ':', '_s' ),
			'all_items'           => __( 'All ' . $plural, '_s' ),
			'view_item'           => __( 'View ' . $name, '_s' ),
			'add_new_item'        => __( 'Add New ' . $name, '_s' ),
			'add_new'             => __( 'New ' . $name, '_s' ),
			'edit_item'           => __( 'Edit ' . $name , '_s' ),
			'update_item'         => __( 'Update ' . $plural, '_s' ),
			'search_items'        => __( 'Search ' . $plural, '_s' ),
			'not_found'           => __( 'No ' . strtolower( $plural ) . ' found', '_s' ),
			'not_found_in_trash'  => __( 'No ' . strtolower( $plural ) . ' found in Trash', '_s' ),
		);

		$defaults = array(
			'label'                 => '',
			'labels'                => $labels,
			'description'           => '',
			'public'                => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'show_in_menu'          => true,
			'show_in_admin_bar'     => true,
			'menu_position'         => 30,
			'menu_icon'             => null,
			'capability_type'       => 'post',
			'capabilities'          => array(),
			'map_meta_cap'          => true,
			'hierarchical'          => false,
			'supports'              => array(),
			'register_meta_box_cb'  => '',
			'taxonomies'            => array(),
			'has_archive'           => false,
			'rewrite'               => true,
			'query_var'             => true,
			'can_export'            => true,
		);

		$args = wp_parse_args( $this->post_type_args, $defaults );

		register_post_type( str_replace( ' ', '-', strtolower( $name ) ), $args );
	}
}
endif;
?>