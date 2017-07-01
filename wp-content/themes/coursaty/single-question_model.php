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
                <div id="single-slider" class="alt flexslider">
                    <ul class="slides">
                        <li><div class="image"><img src="<?=get_stylesheet_directory_uri()?>/assets/img/content/single-2-slide-1-870x352.jpg" alt="" class="img-responsive"></div></li>
                        <li><div class="image"><img src="<?=get_stylesheet_directory_uri()?>/assets/img/content/single-2-slide-2-870x352.jpg" alt="" class="img-responsive"></div></li>
                    </ul><!-- End ul elements -->
                </div><!-- End Single Slider -->
            </div><!-- End col-md-12 -->
        </div><!-- End row -->
    </div><!-- End container -->

    <div class="clearfix"></div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="entry clearfix">
                    <span class="entry-icon"><i class="fa fa-microphone"></i></span>
                    <h4 class="overview ib">题型概述</h4>
                    <div class="content">
                        <?php the_content(); ?>
                    </div>
                </div><!-- End Entry -->
            </div><!-- End col-md-12 -->
        </div><!-- End row -->
    </div><!-- End Container -->
</article>

<div class="clearfix"></div>

<section class="full-section latest-courses-section">
    <div class="container">
        <h3 class="section-title">技巧</h3>
        <p class="section-description">
            技巧描述，如何购买
        </p><!-- End Section Description -->
    </div>
    <div class="section-content latest-courses-content alt fadeInDown-animation">
        <div class="container">
            <div class="row">
                <div id="courses-slider" class="flexslider">
                    <ul class="slides">
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
                        <li class="course-slide-item clearfix" id="post-<?=$post->ID?>">
                            <div class="col-md-12">
                                <div class="course">
                                    <?php if (get_post_meta($post->ID, 'free', true)): ?>
                                    <div class="featured-badge"><span>免费试学</span></div>
                                    <?php endif; ?>
                                    <div class="course-image">
                                        <div class="details-overlay">
                                            <span class="place">
                                                <i class="fa fa-map-marker"></i>
                                                <span class="text">难度指数：<?=get_post_meta($post->ID, 'difficulty', true)?></span>
                                            </span>
                                            <span class="time">
                                                <i class="fa fa-clock-o"></i>
                                                <span class="text">提分指数：<?=get_post_meta($post->ID, 'gain', true)?></span>
                                            </span>
                                        </div><!-- End Course Overlay -->
                                        <?=get_the_post_thumbnail($post, 'medium', array('class' => 'img-responsive'))?>
                                    </div><!-- End Course Image -->
                                    <div class="course-info">
                                        <h3 class="course-title"><a href="<?=get_the_permalink($post)?>" class="ln-tr"><?=get_the_title($post)?></a></h3>
                                        <p class="course-description">
                                            <?=get_the_subtitle($post)?>
                                        </p>
                                        <div class="buttons">
                                            <a href="#" class="btn grad-btn orange-btn read-btn">立即订阅</a>
                                        </div>
                                    </div>
                                </div><!-- End Course -->
                            </div><!-- End col-md-12 -->
                        </li><!-- End 1st Slide -->
                        <?php endforeach; ?>
                    </ul><!-- End ul Items -->
                </div><!-- End Courses Slider -->
            </div><!-- End row -->
        </div><!-- End Container -->
    </div><!-- End Latest-Courses Section Content -->
</section><!-- End Courses Section -->

<?php get_footer(); ?>
