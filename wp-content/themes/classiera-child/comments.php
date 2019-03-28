<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Classiera
 * @since Classiera 1.0
 */
?>
<?php

	/*
	Do not delete these lines.
	Prevent access to this file directly
	*/

	defined( 'ABSPATH' ) or die(wp_kses( __( 'Please do not load this page directly. Thanks!', 'classiera' ), $allowed ));	

	if ( post_password_required() ) { ?>	
		<div class="notice">
			<p class="bottom"><?php esc_html_e( 'This post is password protected. Enter the password to view comments.', 'classiera' ); ?></p>
		</div>	
	<?php
		return;
	}
$caticoncolor="";
$category_icon_code ="";
$category_icon="";
$category_icon_color="";
global $allowed;
global $redux_demo;	
$classieraProfileURL = $redux_demo['profile'];
require('inc/class-wp-bootstrap-comment-walker.php');	
?>
<div class="border-section border comments">
<?php
if ( comments_open()) :
	if ((is_page() || is_single()) && ( ! is_home() && ! is_front_page())):
?>
	<div class="user-comments">
		<?php if ( have_comments()){?>
		<ul class="media-list">
		<?php
			wp_list_comments(				
				array(
					'style'         => 'ul',
					'short_ping'    => true,
					'avatar_size'   => '64',
					'walker'        => new Bootstrap_Comment_Walker(),
				)
			);
		?>
		</ul>
		<?php } ?>
 	</div>

	<!-- Button trigger modal -->
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#comments-modal"><?php _e('Leave New Comment', 'classiera');?></button>

	<!-- Modal -->
	<div class="modal fade" id="comments-modal" tabindex="-1" role="dialog" aria-labelledby="commentsModal">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title text-uppercase" id="commentsModal"><?php esc_html_e( 'Leave a Comment','classiera' ); ?></h4>
	      </div>
	      <div class="modal-body">
	        
			<div class="comment-form">
				<div class="classiera--loader">
					<img src="<?php echo get_template_directory_uri().'/images/loader180.gif' ?>">
				</div>
				<div class="comment-form-heading">
					<p><?php esc_html_e( 'Your email address will not be published. required fields are marked','classiera' ); ?> <span class="text-danger">*</span></p>
					<div class="alert alert-success comment-success">
						<?php esc_html_e('Success! Thanks for your comment. We appreciate your response.', 'classiera') ?>
					</div>
					<div class="alert alert-danger comment-error">
						<?php esc_html_e('You might have left one of the fields blank, or be posting too quickly', 'classiera') ?>
					</div>
				</div>
				<!--Form-->
				<form action="<?php echo get_option( 'siteurl' ); ?>/wp-comments-post.php" method="post" id="commentform" class="addComment">
					<div class="form-group">
						<div class="form-inline row">
							<?php if ( is_user_logged_in()){ ?>
							<?php $classieraCurUser = wp_get_current_user();?>
							<div class="col-sm-12"><p>
							<?php esc_html_e( 'Logged in as', 'classiera' );?>					
							<a href="<?php echo esc_url($classieraProfileURL); ?>">
								<?php echo esc_attr($classieraCurUser->user_login);?>
							</a>&nbsp;
							<a href="<?php echo wp_logout_url(get_option('siteurl')); ?>" title="<?php wp_kses(__( 'Log out of this account', 'classiera' ), $allowed); ?>"><?php esc_html_e( 'Log out &raquo;', 'classiera' ); ?></a>
							</p></div>
							<?php }else{ ?>
							<div class="form-group col-sm-7">
								<label class="text-capitalize"> <?php esc_html_e( 'Name','classiera' ); ?>: <span class="text-danger">*</span> </label>
								<div class="inner-addon left-addon">
									<input type="text" name="author" class="form-control form-control-sm" placeholder="<?php esc_html_e( 'Enter name','classiera' ); ?>" data-error="<?php esc_html_e( 'name required','classiera' ); ?>" required value="<?php echo esc_attr( $comment_author ); ?>">
									<div class="help-block with-errors"></div>
								</div>
							</div><!--Name-->
							<div class="form-group col-sm-7">
								<label class="text-capitalize"><?php esc_html_e( 'Email','classiera' ); ?> : <span class="text-danger">*</span></label>
								<div class="inner-addon left-addon">
									<input type="text" name="email" class="form-control form-control-sm" placeholder="<?php esc_html_e( 'Enter email','classiera' ); ?>" data-error="<?php esc_html_e( 'email required','classiera' ); ?>" required value="<?php echo esc_attr( $comment_author_email ); ?>">
									<div class="help-block with-errors"></div>
								</div>
							</div><!--eMAIL-->
							<?php } ?>
							<div class="form-group col-sm-12">
								<label class="text-capitalize"><?php esc_html_e( 'Message','classiera' ); ?> : <span class="text-danger">*</span></label>
								<div class="inner-addon">
									<textarea data-error="<?php esc_html_e( 'Type your comment here', 'classiera') ?>" name="comment" placeholder="<?php esc_html_e( 'Type your comment here...', 'classiera') ?>" required></textarea>
									<div class="help-block with-errors"></div>
								</div>
							</div><!--Message-->
						</div>
					</div><!--form-group-->
					<?php comment_id_fields(); ?>
					<?php do_action( 'comment_form', $post->ID ); ?>
					
					  <div class="modal-footer">
					  	<button type="submit" name="submit" class="btn btn-primary" value="<?php esc_attr_e( 'Send', 'classiera' ); ?>"><?php esc_html_e( 'Post Comment','classiera' ); ?></button>
					    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
					    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
					  </div>
					</div>
					

				</form>
				<!-- End Form -->
				
			</div><!--comment-form-->

	      </div>
	     <!--  <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary">Save changes</button>
	      </div>
	    </div> -->
	  </div>
	</div>

	<div class="hidden"><?php paginate_comments_links(); ?></div>

<?php
	endif;
endif;
?>	
</div>