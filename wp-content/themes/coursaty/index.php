<?php get_header(); ?>

<section class="blog listview">
	<div class="container">
		<div class="row">
			<?php if(have_posts()): while (have_posts()): the_post(); ?>
			<div class="col-md-12">
				<div class="blogpost clearfix fadeInDown-animation">
					<div class="blogpost-image">
						<?php the_post_thumbnail('post-thumbnail', array('class' => 'img-responsive')); ?>
					</div><!-- End Post Image -->
					<div class="blogpost-info clearfix">
						<h3 class="blogpost-title fl">
							<span class="post-type-icon"><i class="fa fa-comment"></i></span>
							<a href="<?php the_permalink(); ?>" class="ln-tr"><?php the_title(); ?></a>
						</h3>
						<div class="meta fr">
							<div class="date ib">
								<span class="icon"><i class="fa fa-clock-o"></i></span>
								<span class="text"><?php the_date(); ?></span>
							</div><!-- date icon -->
						</div><!-- End Meta -->
						<p class="blogpost-description">
							<?php the_excerpt(); ?>
						</p>
						<div class="buttons fr">
							<a href="<?php the_permalink(); ?>" class="btn grad-btn orange-btn read-btn">查看详情</a>
						</div>
					</div>
				</div><!-- End post -->
			</div><!-- End col-md-12 -->
			<?php endwhile; ?>
			<div class="col-md-12 pagination">
				<?php

				$paginate_links = paginate_links(array(
					'base' => str_replace( 99999, '%#%', esc_url( get_pagenum_link( 99999 ) ) ),
					'type' => 'list',
					'format'=>'/%n%/page/%#%',
					'prev_text' => '&laquo;',
					'next_text' => '&raquo;',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $wp_query->max_num_pages)
				);

				$paginate_links = str_replace('<li>', '<li class="ib">', $paginate_links);

				echo $paginate_links;

				?>
			</div>
			<?php else: ?>
				<div style="text-align:center">没有找到任何内容</div>
			<?php endif; ?>
		</div><!-- End row -->
	</div><!-- End container -->
</section><!-- End Blog 1 Listview -->

<?php get_footer(); ?>
