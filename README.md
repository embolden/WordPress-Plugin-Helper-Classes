````php
// Custom post type args
$movie_args = array(
	'exclude_from_search' => true,
	'menu_position' => 5,
	'capability_type' => 'post',
	'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' ),
	'capabilities' => array( 'create_posts' => false ),
);
// Register CPT
$usb_post = new CustomPostType( 'Movie', 'Movies', $movie_args );
````