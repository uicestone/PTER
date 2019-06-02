<?php get_header(); ?>

<div class="inner-head">
    <div class="container">
        <h1 class="entry-title"><?=__('技巧', 'bingo')?></h1>
        <p class="description">
            <?=__('订阅会员后可以学习全部技巧', 'bingo')?>
        </p>
    </div><!-- End container -->
</div><!-- End Inner Page Head -->

<div class="clearfix"></div>

<section>
    <div class="section-content post latest-courses-content listview alt fadeInDown-animation">
        <div class="container latest-courses-section no-slider">
            <div class="row">
				<?php while (have_posts()): the_post(); ?>
				<div class="course col-xs-offset-2 col-md-8 clearfix">
					<?php if (has_tag('limited-free') && is_limited_free()) { ?><div class="featured-badge"><span><?=__('限时免费', 'bingo')?></span></div><?php } ?>
					<?php if (has_tag('free-trial')) { ?><div class="featured-badge"><span><?=__('免费试用', 'bingo')?></span></div><?php } ?>
					<div class="course-image">
						<!--<div class="details-overlay">
							<span class="place">
								<i class="fa fa-map-marker"></i>
								<span class="text">Place : Alexandria, Miami</span>
							</span>
							<span class="time">
								<i class="fa fa-clock-o"></i>
								<span class="text">Time : 7 Dec, 2015</span>
							</span>
						</div>-->
						<img src="<?=get_stylesheet_directory_uri()?>/assets/img/logo-bingo.png" alt="" class="img-responsive">
					</div>
					<div class="course-info">
						<h3 class="course-title"><a href="<?php the_permalink(); ?>" class="ln-tr"><?php the_title(); ?></a></h3>
						<p class="course-description">
							<?php the_excerpt(); ?>
						</p>
						<!--<div class="details fl">
							<div class="date ib">
								<span class="icon"><i class="fa fa-clock-o"></i></span>
								<span class="text">Time : 7 Dec, 2014</span>
							</div>
							<div class="place ib">
								<span class="icon"><i class="fa fa-map-marker"></i></span>
								<span class="text">Place : Alex, Miami</span>
							</div>
							<div class="center ib">
								<span class="icon"><i class="fa fa-building"></i></span>
								<span class="text">Yat Academy</span>
							</div>
						</div>
						<div class="buttons fr">
							<a href="#" class="btn grad-btn orange-btn read-btn">Read More</a>
							<a href="#" class="btn grad-btn subscribe-btn">Subscribe</a>
						</div>-->
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
