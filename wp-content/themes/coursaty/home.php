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
            <input type="text" name="course-name" id="course-name" placeholder="搜索题型和技巧">
            <div class="select-category ib">
                <select class="dropdown" name="post_type" id="course-category">
                    <option value="any" selected="selected">全部</option>
                    <option value="question_model">题型</option>
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

<section class="full-section latest-courses-section">
    <div class="container">
        <h3 class="section-title">Look at Our Latest Courses</h3>
        <p class="section-description">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem quam, adipiscing condimentum tristique vel, eleifend sed turpis. Pellentesque cursus arcu id magna euismod in elementum purus molestie
        </p><!-- End Section Description -->
    </div>
    <div class="section-content latest-courses-content fadeInDown-animation">
        <div class="container">
            <div class="row">
                <div id="courses-slider" class="flexslider">
                    <ul class="slides">
                        <li class="course-slide-item clearfix">
                            <div class="col-md-12">
                                <div class="course">
                                    <div class="featured-badge"><span>special</span></div>
                                    <div class="course-image">
                                        <div class="details-overlay">
                                            <span class="place">
                                                <i class="fa fa-map-marker"></i>
                                                <span class="text">Place : Alexandria, Miami</span>
                                            </span>
                                            <span class="time">
                                                <i class="fa fa-clock-o"></i>
                                                <span class="text">Time : 7 Dec, 2015</span>
                                            </span>
                                        </div><!-- End Course Overlay -->
                                        <img src="<?=get_stylesheet_directory_uri()?>/assets/img/content/course-slider-img-1-270x178.jpg" class="img-responsive" alt="">
                                    </div><!-- End Course Image -->
                                    <div class="course-info">
                                        <h3 class="course-title"><a href="13-single-course.html" class="ln-tr">Course Name Here</a></h3>
                                        <p class="course-description">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem quam, adipiscing.
                                        </p>
                                        <div class="buttons">
                                            <a href="13-single-course.html" class="btn grad-btn orange-btn read-btn">Read More</a>
                                            <a href="13-single-course.html" class="btn grad-btn subscribe-btn">Subscribe</a>
                                        </div>
                                    </div>
                                </div><!-- End Course -->
                            </div><!-- End col-md-12 -->
                        </li><!-- End 1st Slide -->
                        <li class="course-slide-item clearfix">
                            <div class="col-md-12">
                                <div class="course">
                                    <div class="course-image">
                                        <div class="details-overlay">
                                            <span class="place">
                                                <i class="fa fa-map-marker"></i>
                                                <span class="text">Place : Alexandria, Miami</span>
                                            </span>
                                            <span class="time">
                                                <i class="fa fa-clock-o"></i>
                                                <span class="text">Time : 7 Dec, 2015</span>
                                            </span>
                                        </div><!-- End Course Overlay -->
                                        <img src="<?=get_stylesheet_directory_uri()?>/assets/img/content/course-slider-img-2-270x178.jpg" class="img-responsive" alt="">
                                    </div><!-- End Course Image -->
                                    <div class="course-info">
                                        <h3 class="course-title"><a href="13-single-course.html" class="ln-tr">Course Name Here</a></h3>
                                        <p class="course-description">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem quam, adipiscing.
                                        </p>
                                        <div class="buttons">
                                            <a href="13-single-course.html" class="btn grad-btn orange-btn read-btn">Read More</a>
                                            <a href="13-single-course.html" class="btn grad-btn subscribe-btn">Subscribe</a>
                                        </div>
                                    </div>
                                </div><!-- End Course -->
                            </div><!-- End col-md-12 -->
                        </li><!-- End 2nd Slide -->
                        <li class="course-slide-item clearfix">
                            <div class="col-md-12">
                                <div class="course">
                                    <div class="course-image">
                                        <div class="details-overlay">
                                            <span class="place">
                                                <i class="fa fa-map-marker"></i>
                                                <span class="text">Place : Alexandria, Miami</span>
                                            </span>
                                            <span class="time">
                                                <i class="fa fa-clock-o"></i>
                                                <span class="text">Time : 7 Dec, 2015</span>
                                            </span>
                                        </div><!-- End Course Overlay -->
                                        <img src="<?=get_stylesheet_directory_uri()?>/assets/img/content/course-slider-img-3-270x178.jpg" class="img-responsive" alt="">
                                    </div><!-- End Course Image -->
                                    <div class="course-info">
                                        <h3 class="course-title"><a href="13-single-course.html" class="ln-tr">Course Name Here</a></h3>
                                        <p class="course-description">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem quam, adipiscing.
                                        </p>
                                        <div class="buttons">
                                            <a href="13-single-course.html" class="btn grad-btn orange-btn read-btn">Read More</a>
                                            <a href="13-single-course.html" class="btn grad-btn subscribe-btn">Subscribe</a>
                                        </div>
                                    </div>
                                </div><!-- End Course -->
                            </div><!-- End col-md-12 -->
                        </li><!-- End 3rd Slide -->
                        <li class="course-slide-item clearfix">
                            <div class="col-md-12">
                                <div class="course">
                                    <div class="course-image">
                                        <div class="details-overlay">
                                            <span class="place">
                                                <i class="fa fa-map-marker"></i>
                                                <span class="text">Place : Alexandria, Miami</span>
                                            </span>
                                            <span class="time">
                                                <i class="fa fa-clock-o"></i>
                                                <span class="text">Time : 7 Dec, 2015</span>
                                            </span>
                                        </div><!-- End Course Overlay -->
                                        <img src="<?=get_stylesheet_directory_uri()?>/assets/img/content/course-slider-img-4-270x178.jpg" class="img-responsive" alt="">
                                    </div><!-- End Course Image -->
                                    <div class="course-info">
                                        <h3 class="course-title"><a href="13-single-course.html" class="ln-tr">Course Name Here</a></h3>
                                        <p class="course-description">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem quam, adipiscing.
                                        </p>
                                        <div class="buttons">
                                            <a href="13-single-course.html" class="btn grad-btn orange-btn read-btn">Read More</a>
                                            <a href="13-single-course.html" class="btn grad-btn subscribe-btn">Subscribe</a>
                                        </div>
                                    </div>
                                </div><!-- End Course -->
                            </div><!-- End col-md-12 -->
                        </li><!-- End 4th Slide -->
                        <li class="course-slide-item clearfix">
                            <div class="col-md-12">
                                <div class="course">
                                    <div class="featured-badge"><span>special</span></div>
                                    <div class="course-image">
                                        <div class="details-overlay">
                                            <span class="place">
                                                <i class="fa fa-map-marker"></i>
                                                <span class="text">Place : Alexandria, Miami</span>
                                            </span>
                                            <span class="time">
                                                <i class="fa fa-clock-o"></i>
                                                <span class="text">Time : 7 Dec, 2015</span>
                                            </span>
                                        </div><!-- End Course Overlay -->
                                        <img src="<?=get_stylesheet_directory_uri()?>/assets/img/content/course-slider-img-2-270x178.jpg" class="img-responsive" alt="">
                                    </div><!-- End Course Image -->
                                    <div class="course-info">
                                        <h3 class="course-title"><a href="13-single-course.html" class="ln-tr">Course Name Here</a></h3>
                                        <p class="course-description">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem quam, adipiscing.
                                        </p>
                                        <div class="buttons">
                                            <a href="13-single-course.html" class="btn grad-btn orange-btn read-btn">Read More</a>
                                            <a href="13-single-course.html" class="btn grad-btn subscribe-btn">Subscribe</a>
                                        </div>
                                    </div>
                                </div><!-- End Course -->
                            </div><!-- End col-md-12 -->
                        </li><!-- End 5th Slide -->
                        <li class="course-slide-item clearfix">
                            <div class="col-md-12">
                                <div class="course">
                                    <div class="course-image">
                                        <div class="details-overlay">
                                            <span class="place">
                                                <i class="fa fa-map-marker"></i>
                                                <span class="text">Place : Alexandria, Miami</span>
                                            </span>
                                            <span class="time">
                                                <i class="fa fa-clock-o"></i>
                                                <span class="text">Time : 7 Dec, 2015</span>
                                            </span>
                                        </div><!-- End Course Overlay -->
                                        <img src="<?=get_stylesheet_directory_uri()?>/assets/img/content/course-slider-img-3-270x178.jpg" class="img-responsive" alt="">
                                    </div><!-- End Course Image -->
                                    <div class="course-info">
                                        <h3 class="course-title"><a href="13-single-course.html" class="ln-tr">Course Name Here</a></h3>
                                        <p class="course-description">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem quam, adipiscing.
                                        </p>
                                        <div class="buttons">
                                            <a href="13-single-course.html" class="btn grad-btn orange-btn read-btn">Read More</a>
                                            <a href="13-single-course.html" class="btn grad-btn subscribe-btn">Subscribe</a>
                                        </div>
                                    </div>
                                </div><!-- End Course -->
                            </div><!-- End col-md-12 -->
                        </li><!-- End 6th Slide -->
                        <li class="course-slide-item clearfix">
                            <div class="col-md-12">
                                <div class="course">
                                    <div class="course-image">
                                        <div class="details-overlay">
                                            <span class="place">
                                                <i class="fa fa-map-marker"></i>
                                                <span class="text">Place : Alexandria, Miami</span>
                                            </span>
                                            <span class="time">
                                                <i class="fa fa-clock-o"></i>
                                                <span class="text">Time : 7 Dec, 2015</span>
                                            </span>
                                        </div><!-- End Course Overlay -->
                                        <img src="<?=get_stylesheet_directory_uri()?>/assets/img/content/course-slider-img-4-270x178.jpg" class="img-responsive" alt="">
                                    </div><!-- End Course Image -->
                                    <div class="course-info">
                                        <h3 class="course-title"><a href="13-single-course.html" class="ln-tr">Course Name Here</a></h3>
                                        <p class="course-description">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem quam, adipiscing.
                                        </p>
                                        <div class="buttons">
                                            <a href="13-single-course.html" class="btn grad-btn orange-btn read-btn">Read More</a>
                                            <a href="13-single-course.html" class="btn grad-btn subscribe-btn">Subscribe</a>
                                        </div>
                                    </div>
                                </div><!-- End Course -->
                            </div><!-- End col-md-12 -->
                        </li><!-- End 7th Slide -->
                        <li class="course-slide-item clearfix">
                            <div class="col-md-12">
                                <div class="course">
                                    <div class="course-image">
                                        <div class="details-overlay">
                                            <span class="place">
                                                <i class="fa fa-map-marker"></i>
                                                <span class="text">Place : Alexandria, Miami</span>
                                            </span>
                                            <span class="time">
                                                <i class="fa fa-clock-o"></i>
                                                <span class="text">Time : 7 Dec, 2015</span>
                                            </span>
                                        </div><!-- End Course Overlay -->
                                        <img src="<?=get_stylesheet_directory_uri()?>/assets/img/content/course-slider-img-1-270x178.jpg" class="img-responsive" alt="">
                                    </div><!-- End Course Image -->
                                    <div class="course-info">
                                        <h3 class="course-title"><a href="13-single-course.html" class="ln-tr">Course Name Here</a></h3>
                                        <p class="course-description">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem quam, adipiscing.
                                        </p>
                                        <div class="buttons">
                                            <a href="13-single-course.html" class="btn grad-btn orange-btn read-btn">Read More</a>
                                            <a href="13-single-course.html" class="btn grad-btn subscribe-btn">Subscribe</a>
                                        </div>
                                    </div>
                                </div><!-- End Course -->
                            </div><!-- End col-md-12 -->
                        </li><!-- End 8th Slide -->
                    </ul><!-- End ul Items -->
                </div><!-- End Courses Slider -->
            </div><!-- End 1st row -->
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="add-courses">
                        <img src="<?=get_stylesheet_directory_uri()?>/assets/img/icons/addcourse-icon.png" alt="" class="fl add-courses-icon">
                        <a href="#" class="add-courses-title ln-tr">You Are an Instructor ? Add Your Courses Now !</a>
                        <p class="add-courses-description">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem quam, adipiscing condimentum tristique vel, eleifend sed turpis. Pellentesque cursus arcu id magna euismod in elementum purus molestie.
                        </p>
                    </div><!-- End Add Courses -->
                </div>
            </div><!-- End 2nd row -->
        </div><!-- End Container -->
    </div><!-- End Latest-Courses Section Content -->
</section><!-- End Courses Section -->

<div class="clearfix"></div>

<section class="full-section misc-section fadeInDown-animation">
    <div class="container">
        <div class="row">
            <div class="col-md-6 basic-slider-box">
                <div class="blog-posts">
                    <h6 class="head-title">Latest News</h6>
                    <div class="basic-slider flexslider">
                        <ul class="slides">
                            <li class="post-slide-item">

                                <div class="post clearfix">
                                    <div class="image-post fl">
                                        <img src="<?=get_stylesheet_directory_uri()?>/assets/img/content/posts-slider-img-1-172x126.jpg" alt="">
                                        <div class="post-date">
                                            <span class="day">9</span>
                                            <span class="month">Nov</span>
                                        </div>
                                    </div><!-- End Post Image/Date -->
                                    <div class="post-content">
                                        <h3 class="post-title"><a href="25-blog-single-right-sidebar.html" class="ln-tr">Lorem ipsum post title.</a></h3>
                                        <div class="meta">
                                            <div class="author ib">
                                                <span class="author-icon"><i class="fa fa-user"></i></span>
                                                <span>By : </span><a href="#" class="ln-tr">Begha</a>
                                            </div><!-- End Author -->
                                            <div class="comments ib">
                                                <span class="comments-icon"><i class="fa fa-comments"></i></span>
                                                <span>Comments : </span><a href="#" class="ln-tr">22</a>
                                            </div><!-- End Comments -->
                                        </div><!-- End Meta -->
                                        <p class="post-description">
                                            Lorem ipsum dolor sit amet, conssectfetufar adipiscing elit. Integer lorem quam, adipcing condimentum tristique.
                                        </p>
                                        <a href="#" class="read-more ln-tr">Read More</a>
                                    </div><!-- End Post Content -->
                                </div><!-- End 1st Post -->

                                <div class="post clearfix">
                                    <div class="image-post fl">
                                        <img src="<?=get_stylesheet_directory_uri()?>/assets/img/content/posts-slider-img-2-172x126.jpg" alt="">
                                        <div class="post-date">
                                            <span class="day">9</span>
                                            <span class="month">Nov</span>
                                        </div>
                                    </div><!-- End Post Image/Date -->
                                    <div class="post-content">
                                        <h3 class="post-title"><a href="25-blog-single-right-sidebar.html" class="ln-tr">Lorem ipsum post title.</a></h3>
                                        <div class="meta">
                                            <div class="author ib">
                                                <span class="author-icon"><i class="fa fa-user"></i></span>
                                                <span>By : </span><a href="#" class="ln-tr">Begha</a>
                                            </div><!-- End Author -->
                                            <div class="comments ib">
                                                <span class="comments-icon"><i class="fa fa-comments"></i></span>
                                                <span>Comments : </span><a href="#" class="ln-tr">22</a>
                                            </div><!-- End Comments -->
                                        </div><!-- End Meta -->
                                        <p class="post-description">
                                            Lorem ipsum dolor sit amet, conssectfetufar adipiscing elit. Integer lorem quam, adipcing condimentum tristique.
                                        </p>
                                        <a href="#" class="read-more ln-tr">Read More</a>
                                    </div><!-- End Post Content -->
                                </div><!-- End 2nd Post -->

                            </li><!-- End 1st Post Slide Item -->

                            <li class="post-slide-item">

                                <div class="post clearfix">
                                    <div class="image-post fl">
                                        <img src="<?=get_stylesheet_directory_uri()?>/assets/img/content/posts-slider-img-2-172x126.jpg" alt="">
                                        <div class="post-date">
                                            <span class="day">9</span>
                                            <span class="month">Nov</span>
                                        </div>
                                    </div><!-- End Post Image/Date -->
                                    <div class="post-content">
                                        <h3 class="post-title"><a href="25-blog-single-right-sidebar.html" class="ln-tr">Lorem ipsum post title.</a></h3>
                                        <div class="meta">
                                            <div class="author ib">
                                                <span class="author-icon"><i class="fa fa-user"></i></span>
                                                <span>By : </span><a href="#" class="ln-tr">Begha</a>
                                            </div><!-- End Author -->
                                            <div class="comments ib">
                                                <span class="comments-icon"><i class="fa fa-comments"></i></span>
                                                <span>Comments : </span><a href="#" class="ln-tr">22</a>
                                            </div><!-- End Comments -->
                                        </div><!-- End Meta -->
                                        <p class="post-description">
                                            Lorem ipsum dolor sit amet, conssectfetufar adipiscing elit. Integer lorem quam, adipcing condimentum tristique.
                                        </p>
                                        <a href="#" class="read-more ln-tr">Read More</a>
                                    </div><!-- End Post Content -->
                                </div><!-- End 1st Post -->

                                <div class="post clearfix">
                                    <div class="image-post fl">
                                        <img src="<?=get_stylesheet_directory_uri()?>/assets/img/content/posts-slider-img-1-172x126.jpg" alt="">
                                        <div class="post-date">
                                            <span class="day">9</span>
                                            <span class="month">Nov</span>
                                        </div>
                                    </div><!-- End Post Image/Date -->
                                    <div class="post-content">
                                        <h3 class="post-title"><a href="25-blog-single-right-sidebar.html" class="ln-tr">Lorem ipsum post title.</a></h3>
                                        <div class="meta">
                                            <div class="author ib">
                                                <span class="author-icon"><i class="fa fa-user"></i></span>
                                                <span>By : </span><a href="#" class="ln-tr">Begha</a>
                                            </div><!-- End Author -->
                                            <div class="comments ib">
                                                <span class="comments-icon"><i class="fa fa-comments"></i></span>
                                                <span>Comments : </span><a href="#" class="ln-tr">22</a>
                                            </div><!-- End Comments -->
                                        </div><!-- End Meta -->
                                        <p class="post-description">
                                            Lorem ipsum dolor sit amet, conssectfetufar adipiscing elit. Integer lorem quam, adipcing condimentum tristique.
                                        </p>
                                        <a href="#" class="read-more ln-tr">Read More</a>
                                    </div><!-- End Post Content -->
                                </div><!-- End 2nd Post -->

                            </li><!-- End 2nd Post Slide Item -->
                        </ul><!-- End ul Items -->
                    </div><!-- End Posts Slider -->
                </div><!-- End Blog Posts/Latest News -->
            </div><!-- End col-md-6 -->
            <div class="col-md-6">
                <h6 class="head-title">Why Coursaty</h6>
                <div id="accordion-container" class="accordion">
                    <h4 class="accordion-header ln-tr">What Is Coursaty?</h4>
                    <div class="accordion-content">
                        <p>
                            Duis dapibus aliquam mi, eget euismod scelerisque ut. Vivamus at elit quis urna adipiscing , Curabitur vitae velit in neque dictum blandit. Duis dapibus aliquam mi, eget euismod sceler ut, Duis dapibus aliquam mi, eget euismod scelerisque at elit quis urna adipiscing.
                        </p>
                    </div><!-- End 1st Item -->
                    <h4 class="accordion-header ln-tr">Why Should I Buy Coursaty?</h4>
                    <div class="accordion-content">
                        <p>
                            Duis dapibus aliquam mi, eget euismod scelerisque ut. Vivamus at elit quis urna adipiscing , Curabitur vitae velit in neque dictum blandit. Duis dapibus aliquam mi, eget euismod sceler ut, Duis dapibus aliquam mi, eget euismod scelerisque at elit quis urna adipiscing.
                        </p>
                    </div><!-- End 2nd Item -->
                    <h4 class="accordion-header ln-tr">What Is Coursaty Features?</h4>
                    <div class="accordion-content">
                        <p>
                            Duis dapibus aliquam mi, eget euismod scelerisque ut. Vivamus at elit quis urna adipiscing , Curabitur vitae velit in neque dictum blandit. Duis dapibus aliquam mi, eget euismod sceler ut, Duis dapibus aliquam mi, eget euismod scelerisque at elit quis urna adipiscing.
                        </p>
                    </div><!-- End 3rd Item -->
                </div><!-- End Accordion Container -->
            </div><!-- End col-md-6 -->
        </div><!-- End row -->
    </div><!-- End container -->
</section><!-- End MISC Section -->

<?php get_footer(); ?>

