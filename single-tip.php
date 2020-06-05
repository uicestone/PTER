<?php the_post(); $post = get_post();
ensure_user_cap_on($post);
get_header(); ?>

<div class="inner-head">
    <div class="container">
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <p class="description">
            <?php the_subtitle(); ?>
        </p>
        <div class="breadcrumb">
			<?php $question_type = wp_get_object_terms(get_the_ID(), 'question_type')[0]; ?>
            <ul class="clearfix">
                <li class="ib"><a href="<?=site_url_ml()?>"><?=__('首页', 'bingo')?></a></li>
                <?php if ($question_type): ?>
                <li class="ib"><a href="<?=site_url_ml('question_type_desc/' . $question_type->slug)?>"><?=$question_type->name?></a></li>
                <?php endif; ?>
                <li class="ib current-page"><a href=""><?=__('技巧', 'bingo')?></a></li>
            </ul>
        </div>
    </div><!-- End container -->
</div><!-- End Inner Page Head -->

<?php get_template_part('content-top-copyright'); ?>

<article class="post single<?=has_tag('free-trial') ? ' free-trial' : ''?>">
    <div class="container">
        <div class="row">
            <div class="add-courses box entry">
                <img src="<?=get_stylesheet_directory_uri()?>/assets/img/logo-bingo.png" alt="" class="fl add-courses-icon">
                <span class="add-courses-title ln-tr"><?php the_title(); ?></span>
                <div class="content">
                    <?php the_content(); ?>
                </div>
            </div>
        </div><!-- End main row -->
    </div><!-- End container -->
</article><!-- End Single Article -->

<?php if (in_array($post->post_name, array('pte-reading', 'pte-writing')) && current_user_can(str_replace('pte-', 'view_', $post->post_name))): ?>
<article class="post single">
    <div class="container" style="padding:0">
		<?=do_shortcode('[video width="1280" height="720" mp4="' . site_url() . '/wp-content/uploads/videos/' . $post->post_name . '.mp4"][/video]')?>
    </div><!-- End container -->
</article><!-- End Single Article -->
<?php endif; ?>

<?php if ((has_tag('free-trial') || ($post->post_name === 'pte-reading' && !current_user_can('view_reading')) || ($post->post_name === 'pte-writing' && !current_user_can('view_writing'))) && $welcome_pages = get_posts(array('post_type' => 'page', 'name' => 'welcome'))): $welcome_page = $welcome_pages[0]; ?>
<div class="features-section">
    <div class="container">
        <blockquote>
            <p><?=__('收费视频未显示，要观看，请在下方订阅包含视频课程的学习包', 'bingo')?></p>
            <p><?=__('若您已经购买，请前往', 'bingo')?><strong><a href="<?=site_url_ml('profile')?>"><?=__('个人中心', 'bingo')?></a></strong><?=__('激活该视频，并在24小时内学习完毕', 'bingo')?></p>
        </blockquote>
    </div>
</div>
<section class="full-section features-section fancy-shadow" style="padding-top:0">
    <div class="container">
        <h3 class="section-title"><?=get_the_title($welcome_page)?></h3>
        <p class="section-description">
            <?=get_the_subtitle($welcome_page)?>
        </p><!-- End Section Description -->
        <p><a href="<?=pll_home_url()?>/pricing-table/" class="btn subscribe"><?=__('立即订阅', 'bingo')?></a></p>
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

<?php endif; ?>

<?php get_footer(); ?>
