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
	 *
	 */
	function __construct( $singular, $plural, $args = array() ) {
		$this->taxonomy_singular = $singular;
		$this->taxonomy_plural   = $plural;
		$this->taxonomy_args     = $args;

		if( ! taxonomy_exists( strtolower( $singular ) ) && validate_taxonomy_name( srttolower( $singular ) ) ) {
			add_action( 'init', array( $this, 'register_taxonomy' ) );
		}
	}

	/*
	 * @todo finish validation against list of reserved
	 */
	function validate_taxonomy_name( $singular ) {
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
			if( $singular === $reserved_taxonomy )
				return false;
		}
		return $singular;
	}

	/*
	 *
	 */
	function register_taxonomy() {
		$singular   = $this->taxonomy_singular;
		$plural = $this->taxonomy_plural;

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
			'not_found'                  => __( 'No ' . strtolower( $plural ) . ' found', '_s' ),
			'popular_items'              => __( 'Popular ' . strtolower( $plural ), '_s' ),
			'separate_items_with_commas' => __( 'Separate ' . strtolower( $plural ) . ' with commas', '_s' ),
			'add_or_remove_items'        => __( 'Add or remove ' . strtolower( $plural ) ),
			'choose_from_most_used'      => __( 'Choose from the most used ' . strtolower( $plural ) ),
			'not_found'                  => __( 'No ' . strtolower( $plural ) . ' found.', '_s' ),
		);

		$defaults = array(
			'label'                 => '',
			'labels'                => $labels,
			// 'description'           => '',
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