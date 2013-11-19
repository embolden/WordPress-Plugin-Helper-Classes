<?php
/**
 * Custom Post Type Helper
 */
if( ! class_exists( 'Custom_Post_Type' ) ) :
class Custom_Post_Type {

	private $post_type_singular;
	private $post_type_plural;
	private $post_type_args;

	/**
	 * @todo : Document me!
	 */
	function __construct( $singular, $plural, $args = array() ) {
		$this->set_post_type_singular( $singular );
		$this->set_post_type_plural( $plural );
		$this->set_post_type_args( $args );
		$error = false;

		$singular = strtolower( $singular );

		if( ! $error && post_type_exists( $singular ) ) {
			new WP_Error( 'custom_post_type_exists', __( 'The post type that you have chosen already exists.', '_s' ) );
		}

		if( ! $error && post_type_name_is_not_reserved( $singular ) ) {
			new WP_Error( 'custom_post_type_reserved', __( 'The post type that you have chosen is reserved by WordPress.' ) );
		}

		if( ! $error ) {
			add_action( 'init', array( $this, 'register_post_type' ) );
		}else {
			throw new Exception( $error->get_error_message() );
		}
	}

	/**
	 * @todo: Document me!
	 */
	function set_post_type_singular( $singular ) {
		$this->post_type_singular = $singular;
	}

	/**
	 * @todo: Document me!
	 */
	function get_post_type_singular() {
		return $this->post_type_singular;
	}

	/**
	 * @todo: Document me!
	 */
	function set_post_type_plural( $plural ) {
		$this->post_type_plural = $plural;
	}

	/**
	 * @todo: Document me!
	 */
	function get_post_type_plural() {
		return $this->post_type_plural;
	}

	/**
	 * @todo: Document me!
	 */
	function set_post_type_args( $args ) {
		$this->post_type_args = $args;
	}

	/**
	 * @todo: Document me!
	 */
	function get_post_type_args() {
		return $this->post_type_args;
	}

	/**
	 * @todo : Document me!
	 */
	function post_type_name_is_not_reserved( $new_post_type ) {
		$reserved_post_types = array(
			'post',
			'page',
			'attachment',
			'revision',
			'nav_menu_item',
			'action',
			'order',
		);

		foreach( $reserved_post_types as $reserved_post_type ) {
			if( $new_post_type === $reserved_post_type ) {
				return false;
			}
		}

		return $new_post_type;
	}

	/**
	 * @todo : Document me!
	 */
	function register_post_type() {
		$singular         = $this->get_post_type_singular();
		$plural           = $this->get_post_type_plural();
		$lowercase_plural = strtolower( $plural );

		$labels = array(
			'name'                => _x( $plural, 'Post Type General Name', '_s' ),
			'singular_name'       => _x( $singular, 'Post Type Singular Name', '_s' ),
			'menu_name'           => __( $plural, '_s' ),
			'parent_item_colon'   => __( 'Parent ' . $singular . ':', '_s' ),
			'all_items'           => __( 'All ' . $plural, '_s' ),
			'view_item'           => __( 'View ' . $singular, '_s' ),
			'add_new_item'        => __( 'Add New ' . $singular, '_s' ),
			'add_new'             => __( 'New ' . $singular, '_s' ),
			'edit_item'           => __( 'Edit ' . $singular , '_s' ),
			'update_item'         => __( 'Update ' . $plural, '_s' ),
			'search_items'        => __( 'Search ' . $plural, '_s' ),
			'not_found'           => __( 'No ' . $lowercase_plural . ' found', '_s' ),
			'not_found_in_trash'  => __( 'No ' . $lowercase_plural . ' found in Trash', '_s' ),
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

		register_post_type( str_replace( ' ', '-', strtolower( $singular ) ), $args );
	}
}
endif;
?>