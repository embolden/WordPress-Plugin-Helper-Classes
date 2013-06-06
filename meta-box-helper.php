<?php
class Meta_Box_Helper {
	/**
	 * TODO: Write a description for this
	 *
	 * @since USBContentSharing 0.1
	 */

	protected $meta_args = array();

	public function __construct( $args ) {
		if( ! is_admin() )
			return;

		$this->meta_args = $args;

		add_action( 'add_meta_boxes', array( $this, 'add' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}


	/**
	 * TODO: Write a description for this
	 *
	 * @since USBContentSharing 0.1
	 */
	public function add() {
		extract( $this->meta_args );

		switch( $field_type ) {
			case 'checkbox':
				// $callback = $this->checkbox_callback();
				$callback = array( &$this, 'checkbox_callback' );
				break;
		}

		// var_dump( $callback );
		foreach( $post_type as $type )
			add_meta_box( $id, $title, $callback, $type, $context, $priority );
	}


	/**
	 * TODO: Write a description for this
	 *
	 * @since USBContentSharing 0.1
	 */
	public function checkbox_callback( ) {
		global $post;
		extract( $this->meta_args );
		extract( $callback_args );
		$value = get_post_meta( $post->ID, $meta_key, true );
		$noncename = $callback_id . '_nonce';
		wp_nonce_field( basename( __FILE__ ), $noncename );
		?>
			<label for="<?php echo $id; ?>">
				<input type="checkbox" id="<?php echo $id; ?>" name="<?php echo $id; ?>" <?php checked( $value, 'on' ); ?>>
				<?php echo $label_text; ?>
			</label>
		<?php
	}


	/**
	 * TODO: Write a description for this
	 *
	 * @since USBContentSharing 0.1
	 */
	public function save( $post_id ) {
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return; 

		if( ! current_user_can( 'edit_post', $post_id ) )
			wp_die('edit');

		extract( $this->meta_args );
		$noncename = $callback_args['callback_id'] . '_nonce';

		if ( ! isset( $_POST[$noncename] ) || ! wp_verify_nonce( $_POST[$noncename], basename( __FILE__ ) ) )
			return;

		$checked = isset( $_POST[$id] ) && $_POST[$id] ? 'on' : 'off';

		update_post_meta( $post_id, $meta_key, $checked );
	}
}
?>