#WordPress Plugin Helper Classes
These helper classes have been designed for use in simple plugins.

##Installation
###Step 1
Download the `class-custom-post-type.php` and `class-custom-taxonomy.php` files and put it into an `includes/` directory of your plugin.  Add a `require_once` to the top of your plugin file to include the helper classes.

```php
require_once( 'includes/class-custom-post-type.php' );
require_once( 'includes/class-custom-taxonomy.php' );
```

###Second 2
In your plugin file, declare the appropriate arguments.  You can view all the possible parameters on the codex page for [post types](http://codex.wordpress.org/Function_Reference/register_post_type) and [taxonomies](http://codex.wordpress.org/Function_Reference/register_taxonomy).

```php
// Custom post type arguments
$movie_args = array(
	'exclude_from_search' => true,
	'menu_position'       => 5,
	'capability_type'     => 'post',
	'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' ),
	'capabilities'        => array( 'create_posts' => false ),
	'taxonomies'          => array( 'actors' ),
);

$actors_args = array(
	'heirarchial'   => false,
	'show_tagcloud' => false,
);
```

###Step 3
If registering a custom taxonomy a group of post types must also be declared.  These post types will be assigned our custom taxonomy.

````php
// Post Types
$post_types = array( 'movie' );
````


###Step 4
In your plugin file, declare a new instance of the helper class and pass the singular name, plural name, and the list of arguments.

```php
// Register CPT
$movie_cpt = new Custom_Post_Type( 'Movie', 'Movies', $movie_args );

// Register Taxonomy
$actors_tax = new Custom_Taxonomy( 'Actor', 'Actors', $post_types, $actors_args );
```
