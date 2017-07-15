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
                    <img src="<?=get_stylesheet_directory_uri()?>/assets/img/icons/addcourse-icon.png" alt="" class="fl add-courses-icon">
                    <span class="add-courses-title ln-tr"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
                    <div class="content">
						<?php the_content(); ?>
                    </div>
                </div>
                <?php endwhile; ?>
            </div><!-- End row -->
        </div><!-- End Container -->
    </div><!-- End Latest-Courses Section Content -->
</section><!-- End Courses Section -->

<?php get_footer(); ?>
