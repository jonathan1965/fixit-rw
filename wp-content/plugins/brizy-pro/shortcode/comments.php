<?php

class BrizyPro_Shortcode_Comments extends Brizy_Shortcode_AbstractShortcode {

	private $atts = [];

	public function __construct() {
		parent::__construct();

		add_action( 'template_redirect', [ $this, '_action_template_redirect' ], 9 );
//		add_action( 'option_thread_comments', [ $this, '_action__return_true' ] );
//		add_action( 'option_thread_comments_depth', [ $this, '_action_thread_comments_depth' ] );
	}

	/**
	 * Get shortcode name
	 *
	 * @return string
	 */
	public function getName() {
		return 'comments';
	}

	/**
	 * @param $atts
	 * @param null $content
	 *
	 * @return mixed|string
	 */
	public function render( $atts, $content = null ) {

		$this->atts = $atts;

		add_action( 'wp_list_comments_args', [ $this, '_action_wp_list_comments_args' ] );
		add_action( 'comments_template', [ $this, '_action_comments_template' ] );
		add_action( 'comments_template_query_args', [ $this, '_action_comments_template_query_args' ] );

		ob_start(); ob_clean();

		comments_template();

		$ob_get_clean = ob_get_clean();

		return $ob_get_clean;
	}

	public function _action_wp_list_comments_args( $args ) {
		return array_merge( $args, $this->atts );
	}

	public function _action_comments_template() {
		return implode( DIRECTORY_SEPARATOR, [ BRIZY_PRO_PLUGIN_PATH, 'templates', 'comments.php' ] );
	}

	public function _action_comments_template_query_args( $comment_args ) {

		$comment_args['number'] = $this->atts['limit'];
		$cpage                  = get_query_var( 'cpage' );
		$get_query_var          = ( empty( $cpage ) ? 1 : $cpage ) - 1;
		$comment_args['offset'] = $comment_args['number'] * $get_query_var;

		return $comment_args;
	}

	public function _action__return_true() {
		return true;
	}

	public function _action_comments_per_page() {
		return $this->atts['limit'];
	}

	public function _action_thread_comments_depth() {
		return 5; //$this->atts['thread'];
	}

	public function _action_template_redirect() {

		$pid = Brizy_Editor::get()->currentPostId();

		try {
			$use_editor = Brizy_Editor_Post::get( $pid )->uses_editor();
		} catch ( Exception $e ) {
			$use_editor = false;
		}

		if ( ! Brizy_Admin_Templates::getTemplate() && ! $use_editor ) {
			return;
		}

		add_action( 'option_page_comments', [ $this, '_action__return_true' ] );

		return;
	}
}