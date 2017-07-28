<?php get_header(); ?>

<div class="inner-head">
    <div class="container">
        <h1 class="entry-title">技巧</h1>
        <p class="description">
            订阅会员后可以学习全部技巧
        </p>
    </div><!-- End container -->
</div><!-- End Inner Page Head -->

<div class="clearfix"></div>

<section>
    <div class="section-content post latest-courses-content alt fadeInDown-animation">
        <div class="container">
            <div class="row">
				<?php while (have_posts()): the_post(); ?>
                <div class="add-courses box entry">
                    <img src="<?=get_stylesheet_directory_uri()?>/assets/img/logo-bingo.png" alt="" class="fl add-courses-icon">
                    <span class="add-courses-title ln-tr"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
                    <div class="content">
						<?php the_excerpt(); ?>
                    </div>
                </div>
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
            </div><!-- End row -->
        </div><!-- End Container -->
    </div><!-- End Latest-Courses Section Content -->
</section><!-- End Courses Section -->

<?php get_footer(); ?>
