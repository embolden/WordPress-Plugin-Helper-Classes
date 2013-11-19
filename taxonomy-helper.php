<?php
/*
 * Custom Taxonomy Helper
 */
if( ! class_exists( 'CustomTaxonomy' ) ) :
class CustomTaxonomy {

	public $taxonomy_singular;
	public $taxonomy_plural;
	public $taxonomy_args;

	/*
	 * @todo : Document me!
	 */
	function __construct( $singular, $plural, $args = array() ) {
		$this->taxonomy_singular = $singular;
		$this->taxonomy_plural   = $plural;
		$this->taxonomy_args     = $args;

		$singular = strtolower( $singular );

		if( taxonomy_exists( $singular ) ) {
			return new WP_Error( 'custom_taxonomy_exists', __( 'The taxonomy that you have chosen already exists.', '_s' ) )
		}

		if( $this->taxonomy_name_is_not_reserved( $singular ) ) {
			return new WP_Error( 'custom_taxonomy_reserved', __( 'The taxonomy that you have chosen is reserved by WordPress.', '_s' ) );
		}

		add_action( 'init', array( $this, 'register_taxonomy' ) );
	}

	/*
	 * @todo : Document me!
	 */
	function taxonomy_name_is_not_reserved( $singular ) {
		$reserved_taxonomies = array(
			'attachment,'
			'attachment_id,'
			'author,'
			'author_name,'
			'calendar,'
			'cat,'
			'category,'
			'category__and,'
			'category__in,'
			'category__not_in,'
			'category_name,'
			'comments_per_page,'
			'comments_popup,'
			'customize_messenger_channel,'
			'customized,'
			'cpage,'
			'day,'
			'debug,'
			'error,'
			'exact,'
			'feed,'
			'hour,'
			'link_category,'
			'm,'
			'minute,'
			'monthnum,'
			'more,'
			'name,'
			'nav_menu,'
			'nonce,'
			'nopaging,'
			'offset,'
			'order,'
			'orderby,'
			'p,'
			'page,'
			'page_id,'
			'paged,'
			'pagename,'
			'pb,'
			'perm,'
			'post,'
			'post__in,'
			'post__not_in,'
			'post_format,'
			'post_mime_type,'
			'post_status,'
			'post_tag,'
			'post_type,'
			'posts,'
			'posts_per_archive_page,'
			'posts_per_page,'
			'preview,'
			'robots,'
			's,'
			'search,'
			'second,'
			'sentence,'
			'showposts,'
			'static,'
			'subpost,'
			'subpost_id,'
			'tag,'
			'tag__and,'
			'tag__in,'
			'tag__not_in,'
			'tag_id,'
			'tag_slug__and,'
			'tag_slug__in,'
			'taxonomy,'
			'tb,'
			'term,'
			'theme,'
			'type,'
			'w,'
			'withcomments,'
			'withoutcomments,'
			'year',
		);
		
		foreach( $reserved_taxonomies as $reserved_taxonomy ) {
			if( $singular === $reserved_taxonomy ) {
				return false;
			}
		}

		return $singular;
	}

	/*
 	 * @todo : Document me!
	 */
	function register_taxonomy() {
		$singular         = $this->taxonomy_singular;
		$plural           = $this->taxonomy_plural;
		$lowercase_plural = strtolower( $plural );

		$labels = array(
			'name'                       => _x( $plural, 'Taxonomy General Name', '_s' ),
			'singular_name'              => _x( $singular, 'Taxonomy Singular Name', '_s' ),
			'menu_name'                  => __( $plural, '_s' ),
			'all_items'                  => __( 'All ' . $plural, '_s' ),
			'edit_item'                  => __( 'Edit ' . $singular , '_s' ),
			'view_item'                  => __( 'View ' . $singular, '_s' ),
			'update_item'                => __( 'Update ' . $plural, '_s' ),
			'add_new_item'               => __( 'Add New ' . $singular, '_s' ),
			'parent_item'                => __( 'Parent ' . $singular, '_s' ),
			'parent_item_colon'          => __( 'Parent ' . $singular . ':', '_s' ),
			'search_items'               => __( 'Search ' . $plural, '_s' ),
			'not_found'                  => __( 'No ' . $lowercase_plural . ' found', '_s' ),
			'popular_items'              => __( 'Popular ' . $lowercase_plural, '_s' ),
			'separate_items_with_commas' => __( 'Separate ' . $lowercase_plural . ' with commas', '_s' ),
			'add_or_remove_items'        => __( 'Add or remove ' . $lowercase_plural ),
			'choose_from_most_used'      => __( 'Choose from the most used ' . $lowercase_plural ),
			'not_found'                  => __( 'No ' . $lowercase_plural . ' found.', '_s' ),
		);

		$defaults = array(
			'label'                 => '',
			'labels'                => $labels,
			'public'                => true,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'show_tagcloud'         => true,
			'show_admin_column'     => false,
			'hierarchical'          => false,
			'update_count_callback' => null,
			'query_var'             => true,
			'rewrite'               => true,
			'capabilities'          => array(),
			'sort'                  => null,
		);

		$args = wp_parse_args( $this->taxonomy_args, $defaults );

		register_taxonomy( str_replace( ' ', '-', strtolower( $singular ) ), $args );
	}
}
endif;
?>