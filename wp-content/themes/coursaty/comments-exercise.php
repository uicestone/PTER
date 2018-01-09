<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<?php if (have_comments()): ?>
<ul class="comments-list">
	<?php while (have_comments()): the_comment(); $replies = get_comments(array('status' => 'approve', 'number' => 5, 'post_id' => get_the_ID(), 'parent' => get_comment_ID())); ?>
		<li class="comment<?=$replies ? ' haschild' : ''?>">
			<div class="comment-body clearfix">
				<div class="avatar fl">
					<img src="<?=get_stylesheet_directory_uri()?>/assets/img/avatar/student.gif" alt="">
				</div><!-- end avatar -->
				<div class="content">
					<div class="author clearfix">
						<div class="meta fl">
							<a href="#" class="name"><?php comment_author() ?></a>
							<span class="date"><?php comment_date() ?></span>
						</div>
					</div><!-- end author details -->
					<div class="text">
						<?php comment_text() ?>
					</div><!-- end text -->
				</div><!-- end content -->
			</div><!-- End main comment -->
			<?php  if ($replies): ?>
			<ul class="children">
				<?php foreach ($replies as $reply): the_comment(); ?>
				<li class="comment">
					<div class="comment-body clearfix">
						<div class="avatar fl">
							<img src="<?=get_stylesheet_directory_uri()?>/assets/img/avatar/teacher.jpg" alt="">
						</div><!-- end avatar -->
						<div class="content">
							<div class="author clearfix">
								<div class="meta fl">
									<a href="#" class="name"><?php comment_author() ?></a>
									<span class="date"><?php comment_date(); ?></span>
								</div>
							</div><!-- end author details -->
							<div class="text">
								<?php comment_text(); ?>
							</div><!-- end text -->
						</div><!-- end content -->
					</div><!-- End main comment -->
				</li><!-- End child comment item/tree -->
				<?php endforeach; ?>
			</ul><!-- End child comments -->
			<?php endif; ?>
		</li><!-- End Comment item/tree -->
	<?php endwhile; ?>
</ul>
<?php endif; ?>
