<?php

if ( post_password_required() ) {
	return;
}

?>

<div id="comments" class="brz-comments-area">

	<?php

	if ( have_comments() ) :
		?>
		<h2 class="brz-comments-title">
			<?php
				$comments_number = get_comments_number();
				if ( '1' === $comments_number ) {
					/* translators: %s: post title */
					printf( _x( 'One Reply to &ldquo;%s&rdquo;', 'comments title', 'brizy' ), get_the_title() );
				} else {
					printf(
					/* translators: 1: number of comments, 2: post title */
						_nx(
							'%1$s Reply to &ldquo;%2$s&rdquo;',
							'%1$s Replies to &ldquo;%2$s&rdquo;',
							$comments_number,
							'comments title',
							'brizy'
						),
						number_format_i18n( $comments_number ),
						get_the_title()
					);
				}
			?>
		</h2>

		<ul class="brz-comments">
			<?php
				wp_list_comments(
					array(
						'walker'     => new BrizyPro_Shortcode_CommentsWalker(),
						'short_ping' => true
					)
				);
			?>
		</ul>

		<?php
			the_comments_pagination(
				array(
					'prev_text' => '<span class="brz-screen-reader-text">' . __( 'Previous', 'brizy' ) . '</span>',
					'next_text' => '<span class="brz-screen-reader-text">' . __( 'Next', 'brizy' ) . '</span>',
				)
			);

	endif; // Check for have_comments().

	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
		<p class="brz-no-comments"><?php _e( 'Comments are closed.', 'brizy' ); ?></p>
		<?php
	else :

		$commenter     = wp_get_current_commenter();
		$req           = get_option( 'require_name_email' );
		$aria_req      = ( $req ? " aria-required='true'" : '' );
		$user          = wp_get_current_user();
		$user_identity = $user->exists() ? $user->display_name : '';
		$required_text = sprintf( ' ' . __( 'Required fields are marked %s', 'brizy' ), '<span class="required">*</span>' );

		$fields = array(

			'author' =>
				'<p class="brz-comment-form-author">
					<label for="author">' . __( 'Name', 'brizy' ) .
					( $req ? '<span class="required">*</span>' : '' ) .
					'</label>' .
					'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />
				</p>',

			'email' =>
				'<p class="brz-comment-form-email">
					<label for="email">' . __( 'Email', 'brizy' ) .
						( $req ? '<span class="required">*</span>' : '' ) .
					'</label>' .
					'<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />
				</p>',

			'url' =>
				'<p class="brz-comment-form-url">
					<label for="url">' . __( 'Website', 'brizy' ) . '</label>' .
					'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />
				</p>',
		);

		$args = array(
			'id_form'            => 'brz-comment-form',
			'class_form'         => 'brz-form brz--comment__form-reply-body',
			'id_submit'          => 'brz-submit',
			'class_submit'       => 'brz-submit',
			'submit_field'       => '<p class="brz-form-submit">%1$s %2$s</p>',
			'title_reply_before' => '<h3 id="reply-title" class="brz-comment-reply-title">',

			'comment_field' =>
				'<p class="brz-comment-form-comment">
					<label for="comment">' . _x( 'Comment', 'noun', 'brizy' ) . '</label>
					<textarea name="comment" cols="45" rows="8" aria-required="true"></textarea>
				</p>',

			'must_log_in' =>
				'<p class="brz-must-log-in">' .
					sprintf(
						__( 'You must be <a href="%s">logged in</a> to post a comment.', 'brizy' ),
						wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
					) .
				'</p>',

			'logged_in_as' =>
				'<p class="brz-logged-in-as">' .
					sprintf(
						__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'brizy' ),
						admin_url( 'profile.php' ),
						$user_identity,
						wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) )
					) .
				'</p>',

			'comment_notes_before' =>
				'<p class="comment-notes">' .
					__( 'Your email address will not be published.', 'brizy' ) . ( $req ? $required_text : '' ) .
				'</p>',

			'fields' => apply_filters( 'comment_form_default_fields', $fields ),
		);

		ob_start(); ob_clean();

		comment_form( $args );

		$form = ob_get_clean();

		echo str_replace( 'class="comment-respond"', 'class="brz-comment-respond"', $form );

	endif;
	?>
</div>
