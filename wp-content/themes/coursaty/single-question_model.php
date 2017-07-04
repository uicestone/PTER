<?php get_header(); the_post(); ?>

<div class="inner-head">
    <div class="container">
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <p class="description">
            <?php the_subtitle(); ?>
        </p>
    </div><!-- End container -->
</div><!-- End Inner Page Head -->

<div class="clearfix"></div>

<article class="post">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="entry-sidebar">
                    <div class="course-details">
                        <span class="entry-icon"><i class="fa fa-flag"></i></span>
                        <h4 class="ib">题型概览</h4>
                        <div class="center">
                            <span class="icon"><i class="fa fa-building"></i></span>
                            <span class="text">题型数量：</span>
                        </div><!-- center icon -->
                        <div class="course-id">
                            <span class="icon"><i class="fa fa-exclamation-circle"></i></span>
                            <span class="text">分数占比：</span>
                        </div><!-- course ID -->
                        <div class="place">
                            <span class="icon"><i class="fa fa-map-marker"></i></span>
                            <span class="text">难度系数：</span>
                        </div><!-- place icon -->
                        <div class="date">
                            <span class="icon"><i class="fa fa-clock-o"></i></span>
                            <span class="text">时间占比：</span>
                        </div><!-- date icon -->
                        <a href="#" class="btn grad-btn orange-btn join-btn">立即订阅技巧</a>
                    </div><!-- End Course Details -->
                </div><!-- End Sidebar Entry -->
            </div><!-- End col-md-3 -->
            <div class="col-md-9">
                <div class="entry clearfix">
                    <span class="entry-icon"><i class="fa fa-microphone"></i></span>
                    <h4 class="overview ib">题型概述</h4>
                    <div class="content">
						<?php the_content(); ?>
                    </div>
                </div><!-- End Entry -->
            </div><!-- End col-md-12 -->
        </div><!-- End row -->
    </div><!-- End container -->
</article>

<div class="clearfix"></div>

<section class="full-section latest-courses-section">
    <div class="container">
        <h3 class="section-title">技巧</h3>
        <p class="section-description">
            订阅会员后可以学习全部技巧
        </p><!-- End Section Description -->
    </div>
    <div class="section-content post latest-courses-content alt fadeInDown-animation">
        <div class="container">
            <div class="row">
				<?php foreach (get_posts(array(
					'post_type' => 'tip',
					'tax_query' => array(
						array(
							'taxonomy' => 'question_model',
							'field' => 'slug',
							'terms' => wp_get_object_terms(get_the_ID(), 'question_model')[0]->slug
						)
					)
				)) as $post): ?>
                <div class="add-courses box entry">
                    <img src="<?=get_stylesheet_directory_uri()?>/assets/img/icons/addcourse-icon.png" alt="" class="fl add-courses-icon">
                    <span class="add-courses-title ln-tr"><?=get_the_title($post)?></span>
                    <div class="content">
						<?=wpautop(do_shortcode($post->post_content))?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div><!-- End row -->
        </div><!-- End Container -->
    </div><!-- End Latest-Courses Section Content -->
</section><!-- End Courses Section -->

<?php get_footer(); ?>
