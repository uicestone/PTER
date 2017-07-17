<?php get_header(); ?>

<div class="tp-banner-container">
    <div class="tp-banner">
        <ul>
            <?php foreach (get_posts(array('tag' => 'headline')) as $index => $post): ?>
            <li data-transition="random" data-slotamount="7" data-masterspeed="1500">
                <!-- MAIN IMAGE -->
                <?=get_the_post_thumbnail($post, 'headline', array('alt' => 'slidebg' . ($index + 1), 'data-bgfit' => 'cover', 'data-bgposition' => 'left top', 'data-bgrepeat' => 'no-repeat'))?>
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
                    <h2 class="slide-title"><?=get_the_title($post)?></h2>
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
                    <p class="slide-description"><?=get_the_subtitle($post)?></p>
                </div>
            </li>
            <?php endforeach; ?>
        </ul><!-- end ul elements -->
    </div><!-- end tp-banner -->
</div><!-- End Home Slider Container -->

<div class="clearfix"></div>

<div class="course-search fancy-shadow">
    <div class="container">
        <form action="<?=site_url()?>/" id="course-search-form" class="clearfix">
            <input type="text" name="s" id="course-name" placeholder="搜索题型和技巧">
            <div class="select-category ib">
                <select class="dropdown" name="post_type" id="course-category">
                    <option value="any" selected="selected">全部</option>
                    <option value="question_type_desc">题型</option>
                    <option value="tip">技巧</option>
                </select>
            </div><!-- End Select Category -->

            </div><!-- End Select Country -->
            <button type="submit" id="search-btn" class="grad-btn ln-tr">搜索</button>
        </form><!-- End Sourse Search Form -->
    </div>
</div><!-- End Course Container -->

<div class="clearfix"></div>

<?php $welcome_pages = get_posts(array('post_type' => 'page', 'name' => 'welcome')); if ($welcome_pages): $welcome_page = $welcome_pages[0]; ?>
<section class="full-section features-section fancy-shadow">
    <div class="container">
        <h3 class="section-title"><?=get_the_title($welcome_page)?></h3>
        <p class="section-description">
            <?=get_the_subtitle($welcome_page)?>
        </p><!-- End Section Description -->
    </div>
    <div class="section-content features-content fadeInDown-animation">
        <div class="container">
            <div class="row">
	            <?php foreach (get_posts(array('category_name' => 'service')) as $post): ?>
                <div class="col-md-3 col-xs-6">
                    <div class="feature-box">
                        <div class="icon">
                            <?=get_the_post_thumbnail($post, 'thumbnail', array('class' => 'es-tr'))?>
                        </div><!-- End Icon -->
                        <h5 class="feature-title"><?=get_the_title($post)?></h5>
                        <p class="feature-description">
                            <?=get_the_subtitle($post)?>
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

<?php $mentor_pages = get_posts(array('post_type' => 'page', 'name' => 'mentor')); if ($mentor_pages): $mentor_page = $mentor_pages[0]; ?>
<section class="full-section instructors-section fancy-shadow">
    <div class="container">
        <h3 class="section-title"><?=get_the_title($mentor_page)?></h3>
        <p class="section-description">
            <?=get_the_subtitle($mentor_page)?>
        </p><!-- End Section Description -->
    </div>
    <div class="section-content instructors-content fadeInDown-animation">
        <div class="container">
            <div class="row">
                <?php foreach (get_posts(array('category_name' => 'mentor')) as $post): ?>
                <div class="col-md-3 col-xs-6">
                    <div class="instructor">
                        <div class="avatar">
                            <?=get_the_post_thumbnail($post, 'mentor', array('class' => 'img-responsive'))?>
                        </div><!-- End Avatar -->
                        <div class="instructor-info">
                            <p class="name"><?=get_the_title($post)?></p>
                            <span class="position"><?=get_the_subtitle($post)?></span>
                            <div class="social-icons">
                                <ul class="clearfix">
                                    <li><a href="#" class="fb-icon es-tr"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#" class="tw-icon es-tr"><i class="fa fa-envelope-o"></i></a></li>
                                    <li><a href="#" class="tw-icon es-tr"><i class="fa fa-weixin"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- End Instructor Box -->
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div><!-- End Instructors Section Content -->
</section><!-- End Our Instructors Container -->

<div class="clearfix"></div>
<?php endif; ?>

<?php get_footer(); ?>

