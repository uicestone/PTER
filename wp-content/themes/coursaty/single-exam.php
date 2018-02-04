<?php
global $post;
if(!has_tag('free-trial') && !in_array($post->post_name, ['pte-reading', 'pte-writing'])
    && !(is_limited_free(get_current_user_id()) && has_tag('limited-free'))) {
    redirect_pricing_table('view_exercises');
}

if ($_GET['start'] === 'speaking') {
    $user = wp_get_current_user();

    // create a paper, set speaking start time
    $paper_id = wp_insert_post(array(
        'post_type' => 'paper',
        'post_title' => $user->display_name . '的' . get_the_title() . '试卷',
        'post_status' => 'private'
    ));
	add_post_meta($paper_id, 'exam_id', get_the_ID());
    add_post_meta($paper_id, 'time_start_speaking', time());

    // find out first exercise in speaking of this exam
	$exercises = get_field('speaking');
	header('Location: ' . get_the_permalink($exercises[0]->ID) . '?exam_id=' . get_the_ID()); exit;
}

get_header(); the_post(); ?>

<div class="inner-head">
    <div class="container">
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <p class="description">
            <?php the_subtitle(); ?>
        </p>
        <div class="breadcrumb">
			<?php $question_type = wp_get_object_terms(get_the_ID(), 'question_type')[0]; ?>
            <ul class="clearfix">
                <li class="ib"><a href="<?=site_url()?>">首页</a></li>
                <?php if ($question_type): ?>
                <li class="ib"><a href="<?=site_url()?>/question_type_desc/<?=$question_type->slug?>"><?=$question_type->name?></a></li>
                <?php endif; ?>
                <li class="ib current-page"><a href="">考试</a></li>
            </ul>
        </div>
    </div><!-- End container -->
</div><!-- End Inner Page Head -->

<div class="copyright-header container">
    <p>All Rights Reserved &copy; Bingo Training Pty. Ltd. ABN 64 618 887 951, ACN 618 887 951</p>
	<?php if (is_limited_free(get_current_user_id())): ?>
        <hr>
        <p style="font-weight:normal">
            您是限时免费订阅用户，将于
			<?php $expires_at = get_user_meta(get_current_user_id(), 'service_tips_valid_before', true); ?>
            <span class="count-down" data-expires-at="<?=$expires_at?>">
            <?=date('Y-m-d H:i:s', $expires_at + get_option( 'gmt_offset' ) * HOUR_IN_SECONDS)?>
        </span>
            过期，请了解我们的<a href="<?=site_url('profile')?>" target="_blank">优惠政策</a>，并及时<a href="<?=site_url('pricing-table')?>">订阅</a></p>
	<?php endif; ?>
</div>

<div class="clearfix"></div>

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

<div class="features-section">
    <div class="container">
        <h1>试音</h1>
    </div>
</div>
<section class="full-section features-section fancy-shadow" style="padding-top:0">
    <div class="section-content features-content fadeInDown-animation">
        <div class="container">
            <h1><a href="<?php the_permalink(); ?>?start=speaking">开始考试</a></h1>
        </div>
    </div><!-- End Features Section Content -->
</section><!-- End Features Section -->

<?php get_footer(); ?>
