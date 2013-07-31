#Custom Post Type Helper

##First Step
Download the `cpt-helper.php` file and put it into the `inc/` directory.  Add a `require` to the plugin file to include it.
````php
require( 'inc/cpt-helper.php' );
````
##Second Step
In your plugin file, declare post type arguments.  You can view all the possible parameters on the codex page: http://codex.wordpress.org/Function_Reference/register_post_type
````php
// Custom post type args
$movie_args = array(
	'exclude_from_search' => true,
	'menu_position' => 5,
	'capability_type' => 'post',
	'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' ),
	'capabilities' => array( 'create_posts' => false ),
);
````
##Third Step
In your plugin file, register your custom post type
```php
// Register CPT
$movie_cpt = new CustomPostType( 'Movie', 'Movies', $movie_args );
````