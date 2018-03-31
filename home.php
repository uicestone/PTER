<?php get_header(); ?>

<?php $banners = get_posts(array('tag' => 'headline')); ?>
<div class="tp-banner-container">
    <div class="tp-banner">
        <ul>
            <?php foreach ($banners as $index => $banner): ?>
            <li data-transition="random" data-slotamount="7" data-masterspeed="1500">
                <!-- MAIN IMAGE -->
                <?=get_the_post_thumbnail($banner, 'headline', array('alt' => 'slidebg' . ($index + 1), 'data-bgfit' => 'cover', 'data-bgposition' => 'left top', 'data-bgrepeat' => 'no-repeat'))?>
                <!-- LAYERS -->
                <!-- LAYER NR. 1 -->
                <div class="tp-caption sft skewtoleft tp-resizeme start white"
                    data-y="245"
                    data-x="center"
                    data-hoffset="0"
                    data-start="300"
                    data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                    data-speed="500"
                    data-easing="Power3.easeInOut"
                    data-endspeed="300"
                    style="z-index: 2">
                    <h2 class="slide-title"><?=get_the_title($banner)?></h2>
                </div>
                <!-- LAYER NR. 2 -->
                <div class="tp-caption black randomrotate skewtoleft tp-resizeme start"
                    data-x="center"
                    data-hoffset="0"
                    data-y="270"
                    data-speed="500"
                    data-start="1300"
                    data-easing="Power3.easeInOut"
                    data-splitin="none"
                    data-splitout="none"
                    data-elementdelay="0.1"
                    data-endelementdelay="0.1"
                    data-endspeed="500" style="z-index: 99; white-space: pre-line;">
                    <p class="slide-description"><?=get_the_subtitle($banner)?></p>
                </div>
                <div class="tp-caption black randomrotate skewtoleft tp-resizeme start"
                     data-x="center"
                     data-hoffset="0"
                     data-y="430"
                     data-speed="500"
                     data-start="1300"
                     data-easing="Power3.easeInOut"
                     data-splitin="none"
                     data-splitout="none"
                     data-elementdelay="0.1"
                     data-endelementdelay="0.1"
                     data-endspeed="500" style="z-index:99">
                    <a href="<?=site_url('exercise/repeat-sentence-%E7%BB%83%E4%B9%A01/?tag=free-trial')?>/tip/?tag=free-trial" class="btn">免费体验</a>
                    <a href="<?=site_url('exam/模拟题1/')?>" class="btn">模考</a>
                    <a href="<?=site_url('exercise_pack/课程1')?>" class="btn">宾果23天课</a>
                </div>
            </li>
            <?php endforeach; ?>
        </ul><!-- end ul elements -->
    </div><!-- end tp-banner -->
</div><!-- End Home Slider Container -->

<?php foreach ($banners as $index => $banner): ?>
<section class="full-section banner" style="background-image:url('<?=get_the_post_thumbnail_url($banner)?>')">
    <div class="container">
        <h3 class="section-title"><?=get_the_title($banner)?></h3>
        <p class="section-description">
			<?=get_the_subtitle($banner)?>
        </p><!-- End Section Description -->
        <div class="banner-actions">
			<?php if ($index === 0): ?>
            <a href="<?=site_url('tip/?tag=free-trial')?>" class="btn">免费体验</a>
			<?php elseif ($index === 1): ?>
            <a href="<?=site_url('exam/模拟题1/')?>" class="btn">模考</a>
			<?php elseif ($index === 2): ?>
            <a href="<?=site_url('exercise_pack/课程1/')?>" class="btn">宾果23天课</a>
            <?php endif; ?>
        </div>
    </div>
</section>
<div class="clearfix"></div>
<?php endforeach; ?>

<section class="full-section features-section fancy-shadow">
    <div class="container">
        <a href="<?=site_url('pricing-table')?>"><img style="max-width:100%" src="<?=get_stylesheet_directory_uri()?>/assets/img/pricing-table-3.png"></a>
    </div>
</section><!-- End Features Section -->

<?php $welcome_pages = get_posts(array('post_type' => 'page', 'name' => 'welcome')); if ($welcome_pages): $welcome_page = $welcome_pages[0]; ?>
<section class="full-section features-section fancy-shadow">
    <div class="container">
        <h3 class="section-title"><?=get_the_title($welcome_page)?></h3>
        <p class="section-description">
            <?=get_the_subtitle($welcome_page)?>
        </p><!-- End Section Description -->
        <p><a href="<?=site_url()?>/pricing-table/" class="btn subscribe">立即订阅</a></p>
    </div>
    <div class="section-content features-content fadeInDown-animation">
        <div class="container">
            <div class="row">
	            <?php foreach (get_posts(array('category_name' => 'service')) as $service): ?>
                <div class="col-md-3 col-xs-6">
                    <div class="feature-box">
                        <div class="icon">
                            <?=get_the_post_thumbnail($service, 'thumbnail', array('class' => 'es-tr'))?>
                        </div><!-- End Icon -->
                        <h5 class="feature-title"><?=get_the_title($service)?></h5>
                        <p class="feature-description">
                            <?=wpautop($service->post_excerpt)?>
                        </p>
                    </div><!-- End Features Box -->
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div><!-- End Features Section Content -->
</section><!-- End Features Section -->

<div class="clearfix"></div>
<?php endif; ?>

<?php $recommended_posts = get_posts(array('post_type' => array('post', 'tip'), 'tag' => 'recommended', 'posts_per_page' => 4, 'orderby' => 'menu_order', 'order' => 'asc')); if ($recommended_posts): ?>
<section class="full-section instructors-section fancy-shadow">
    <div class="container">
        <h3 class="section-title">推荐阅读</h3>
        <p class="section-description">

        </p><!-- End Section Description -->
    </div>
    <div class="section-content instructors-content fadeInDown-animation">
        <div class="container">
            <div class="row">
                <?php foreach ($recommended_posts as $recommended_post): ?>
                <div class="col-md-3 col-xs-6">
                    <div class="instructor">
                        <div class="avatar">
                            <a href="<?=get_permalink($recommended_post)?>"><?=get_the_post_thumbnail($recommended_post, 'mentor', array('class' => 'img-responsive'))?></a>
                        </div><!-- End Avatar -->
                        <div class="instructor-info">
                            <p class="name"><a href="<?=get_permalink($recommended_post)?>"><?=get_the_title($recommended_post)?></a></p>
                            <span class="position"><?=get_the_subtitle($recommended_post)?></span>
                        </div>
                    </div><!-- End Instructor Box -->
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div><!-- End Instructors Section Content -->
</section><!-- End Our Instructors Container -->
<?php endif; ?>

<?php get_footer(); ?>

