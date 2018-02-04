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

wp_enqueue_script('waveform');
wp_enqueue_script('waveform-record');
wp_enqueue_script('waveform-emitter');

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

<article class="post<?=has_tag('free-trial') ? ' free-trial' : ''?>">
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

<section class="post" style="padding-top:20px">
	<div class="container">
		<div class="row comment-form answer-form entry">
			<div class="addcomment-title">
				<span class="icon"><i class="fa fa-comments-o"></i></span>
				<span class="text">试音</span>
			</div><!-- End Title -->
			<form method="post" action="/" id="answer-form">
				<div class="row">
					<div class="col-md-12">
						<div class="input">
							<div class="post-content">
								<div id="top-bar" class="playlist-top-bar">
									<div class="playlist-toolbar">
										<div class="btn-group">
											<span class="btn-record btn btn-info disabled">
												<i class="fa fa-microphone"></i>
											</span>
											<span class="btn-play btn btn-success">
												<i class="fa fa-play"></i>
											</span>
											<span class="btn-stop btn">
												<i class="fa fa-stop"></i>
											</span>
											<span class="btn-clear btn btn-danger">
												<i class="fa fa-trash"></i>
											</span>
											<!--<span title="Download the current work as Wav file"
												  class="btn btn-download btn-primary">
												<i class="fa fa-download"></i>
											</span>-->
										</div>
									</div>
								</div>
								<div id="playlist"></div>
							</div>
						</div>
					</div>
				</div>
			</form><!-- End form -->
		</div><!-- End comment form -->
		<div class="row">
			<a href="<?php the_permalink(); ?>?start=speaking" class="btn btn-block primary-btn orange-btn">开始考试</a>
		</div>
	</div>
</section>

<?php get_footer(); ?>
