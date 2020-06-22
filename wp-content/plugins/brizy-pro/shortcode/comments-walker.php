<?php
/**
 * This class outputs custom comment walker for HTML5 friendly WordPress comment and threaded replies.
 */
class BrizyPro_Shortcode_CommentsWalker extends Walker_Comment {

	/**
	 * Starts the list before the elements are added.
	 *
	 * @since 2.7.0
	 *
	 * @see Walker::start_lvl()
	 * @global int $comment_depth
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param int    $depth  Optional. Depth of the current comment. Default 0.
	 * @param array  $args   Optional. Uses 'style' argument for type of HTML list. Default empty array.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1;

		switch ( $args['style'] ) {
			case 'div':
				break;
			case 'ol':
				$output .= '<ol class="brz-comments-children">' . "\n";
				break;
			case 'ul':
			default:
				$output .= '<ul class="brz-comments-children">' . "\n";
				break;
		}
	}

	/**
	 * Outputs a comment in the HTML5 format.
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {

		$skin           = $args['skin'];
		$tag            = ( 'div' === $args['style'] ) ? 'div' : 'li';
		$parent_classes = 'brz-comments brz-comments__skin-' . $skin . ( $this->has_children ? ' brz-parent' : '' );
		?>
        <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $parent_classes, $comment ); ?>>
		<?php

		call_user_func( [ $this, $skin ], $comment, $depth, $args );

	}

	protected function skin1( $comment, $depth, $args ) {

        $this->get_avatar( $comment, $args ); ?>

        <ul class="brz-ul brz-comments__right-date">
            <li class="brz-li brz-comments__name">
                <?php comment_author_link( $comment ) ?>
            </li>
            <li class="brz-li brz-comments__date">
	            <?php $this->comment_date( $comment, $args ); ?>
            </li>

            <?php $this->replay_link( $args, $depth ); ?>

	        <?php $this->comment_text( $comment, $depth, $args ); ?>
        </ul>
        <?php
	}

	protected function skin2( $comment, $depth, $args ) {

        $this->get_avatar( $comment, $args ); ?>

        <ul class="brz-ul brz-comments__right-date">
            <li class="brz-li brz-comments__name-date">
                <span class="brz-span brz-comments__name">
                    <?php comment_author_link( $comment ) ?>
                </span>
                <span class="brz-span brz-comments__date">
                   <?php $this->comment_date( $comment, $args ); ?>
                </span>
            </li>

	        <?php $this->comment_text( $comment, $depth, $args ); ?>

	        <?php $this->replay_link( $args, $depth ); ?>
        </ul>
        <?php
	}

	protected function skin3( $comment, $depth, $args ) {

		$this->get_avatar( $comment, $args ); ?>

        <ul class="brz-ul brz-comments__right-date">
            <li class="brz-li brz-comments__name">
                <?php comment_author_link( $comment ); ?>
            </li>
            <li class="brz-li brz-comments__date">
				<?php $this->comment_date( $comment, $args ); ?>
            </li>

			<?php $this->comment_text( $comment, $depth, $args, true ); ?>

        </ul>
		<?php
	}

	protected function skin4( $comment, $depth, $args ) {

		?>

        <ul class="brz-ul brz-comments__right-date">
            <li class="brz-li brz-comments__name-date">
                <span class="brz-span brz-comments__name">
                    <?php comment_author_link( $comment ); ?>
                </span>
                <span class="brz-span brz-comments__date">
                    <?php $this->comment_date( $comment, $args ); ?>
                </span>
            </li>

			<?php $this->get_avatar( $comment, $args, 'li' ); ?>

			<?php $this->comment_text( $comment, $depth, $args, true ); ?>
        </ul>

		<?php
	}

	protected function comment_date( $comment, $args ) {
	    ?>
        <a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
            <span class="brz-span">
                <?php echo get_comment_date( '', $comment ); ?>,&nbsp;
            </span>
	        <?php echo get_comment_time(); ?>
        </a>
        <?php
    }

    protected function comment_text( $comment, $depth, $args, $replay = false ) {
	    if ( '0' == $comment->comment_approved ) : ?>
            <li class="brz-comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'brizy' ); ?></li>
        <?php else: ?>
            <li class="brz-li brz-comments__text">
                <?php comment_text(); ?>
                <?php if ( $replay ) : ?>
                    <?php $this->replay_link( $args, $depth, '', '' ) ?>
                <?php endif; ?>
            </li>
        <?php endif;
    }

	private function get_avatar( $comment, $args, $tag = 'div' ) {

		$comment_author_url  = get_comment_author_url( $comment );
		$avatar              = get_avatar( $comment, $args['avatar_size'], '', '', array( 'class' => 'brz-img brz-comments__logo-img' ) );

		if ( ! empty( $comment_author_url ) ) {
			$avatar = '<a href="' . $comment_author_url . '" rel="external nofollow">' . $avatar . '</a>';
		}

		echo '<' . $tag . ' class="brz-comments__logo">' . $avatar . '</' . $tag . '>';
    }

    private function replay_link( $args, $depth, $before = '<li class="brz-li brz-comments__reply">', $after = '</li>' ) {

	    $link = get_comment_reply_link(
		    array_merge(
			    $args,
			    array(
				    'depth'     => $depth,
				    'max_depth' => $args['max_depth'],
				    'before'    => $before,
				    'after'     => $after
			    )
		    ),
            null,
            null
	    );

	    echo str_replace( 'comment-reply-link', 'comment-reply-link brz-a', $link );
    }
}
