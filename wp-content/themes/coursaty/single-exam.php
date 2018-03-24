<?php
if(!has_tag('free-trial') && !in_array($post->post_name, ['pte-reading', 'pte-writing'])
    && !(is_limited_free(get_current_user_id()) && has_tag('limited-free'))) {
    redirect_pricing_table('view_exercises');
}

$user = wp_get_current_user();

if (isset($_POST['start'])) {

	$paper = get_posts(array('post_type'=>'paper', 'post_status'=>'private', 'author'=>$user->ID, 'meta_key'=>'submitted_at', 'meta_compare'=>'NOT EXISTS'))[0];

	if (!$paper) {
		// create a paper, set speaking start time
		$paper_id = wp_insert_post(array(
			'post_type' => 'paper',
			'post_title' => $user->display_name . '的' . get_the_title() . '试卷',
			'post_status' => 'private'
		));
		add_post_meta($paper_id, 'exam_id', get_the_ID());
		$paper = get_post($paper_id);
	}

	header('Location: ' . get_the_permalink() . '?paper_id=' . $paper->ID . '&section=speaking' . (isset($_GET['finish']) ? '&finish=true' : '')); exit;
}

if (isset($_POST['restart'])) {
	$paper = get_posts(array('post_type'=>'paper', 'post_status'=>'private', 'author'=>$user->ID, 'meta_key'=>'submitted_at', 'meta_compare'=>'NOT EXISTS'))[0];
	wp_delete_post($paper->ID);
	header('Location: ' . get_the_permalink()); exit;
}

$paper = get_post($_GET['paper_id']);

// exam exercises
if ($_GET['section']) {
	$sections = ['speaking', 'writing', 'reading', 'break', 'listening'];
	$exam = get_post();
	$section = $_GET['section'];
	$section_exercises = get_field($section);
	$exercise_index = isset($_GET['exercise_index']) ? $_GET['exercise_index'] : 0;
	$exercise = $section_exercises[$exercise_index];

	$question_type = wp_get_object_terms($exercise->ID, 'question_type')[0];

	if (!$paper || $paper->post_status !== 'private') {
		exit('Exam was not started. Go back to <a href="' . get_the_permalink() . '">exam front page</a>.');
	}

	if (isset($_POST['answer'])) {
		// save answer to paper
		update_post_meta($paper->ID, 'answer_' . $section . '_' . $exercise_index, $_POST['answer']);
		if (isset($_POST['current_exercise_time_left']) && is_numeric($_POST['current_exercise_time_left']) && in_array($question_type->slug, array('summarise-spoken-text', 'swt'))) {
			$section_start_time = get_post_meta($paper->ID, 'time_start_' . $section, true);
			$section_start_time -= $_POST['current_exercise_time_left'];
			update_post_meta($paper->ID, 'time_start_' . $section, $section_start_time);
		}
		echo json_encode(get_post_meta($paper->ID, 'answer_' . $section . '_' . $exercise_index, true));
		exit;
	}

	$answer = get_post_meta($paper->ID, 'answer_' . $section . '_' . $exercise_index, true);

	// roll back rejection
	$current_paper_section = get_post_meta($paper->ID, 'section', true);
	$current_paper_exercise_index = get_post_meta($paper->ID, 'exercise_index', true);

	if (empty($_GET['finish']) && (array_search($current_paper_section, $sections) > array_search($section, $sections)
		|| (array_search($current_paper_section, $sections) === array_search($section, $sections)
		&& $current_paper_exercise_index > $exercise_index))) {
		exit('Cannot roll back to previous question or section. <a href="' . get_the_permalink() . '?paper_id=' . $paper->ID . '&section=' . $current_paper_section . '&exercise_index=' . $current_paper_exercise_index . '">Proceed exam &raquo;</a>');
	}

	update_post_meta($paper->ID, 'section', $section);
	update_post_meta($paper->ID, 'exercise_index', $exercise_index);

	if (empty($section_start_time) && !$section_start_time = get_post_meta($paper->ID, 'time_start_' . $section, true)) {
		$section_start_time = time();
		add_post_meta($paper->ID, 'time_start_' . $section, $section_start_time);
	}

	$sections_time_limit = array('speaking'=>2100, 'writing'=>2400, 'reading'=>2400, 'break' => 600, 'listening'=>3300);
	$section_time_left = $sections_time_limit[$section] - time() + $section_start_time;
	if ($section_time_left < 0) {
		// expired paper
	}

	if ($section_exercises && count($section_exercises) > $exercise_index + 1) {
		// find next exercise
		$next_exercise = $section_exercises[$exercise_index + 1];
		$next_exercise_url = get_the_permalink() . '?&paper_id=' . $paper->ID . '&section=' . $section . '&exercise_index=' . ($exercise_index + 1) . (isset($_GET['finish']) ? '&finish=true' : '');
	}
	else {
		$next_section_index = array_search($section, $sections) + 1;
		if ($next_section_index < count($sections)) {
			$next_section_url = get_the_permalink() . '?paper_id=' . $paper->ID . '&section=' . $sections[$next_section_index] . (isset($_GET['finish']) ? '&finish=true' : '');
		} elseif (empty($_GET['finish'])) {
			$submit_paper_url = get_the_permalink() . '?paper_id=' . $paper->ID . '&finish=true';
		} else {
			$return_url = get_the_permalink() . '?finish=true';
		}
	}

	if ($exercise_index === 0) {
		$previous_section_index = array_search($section, $sections) - 1;
		if ($previous_section_index >= 0) {
			$previous_section_url = get_the_permalink() . '?paper_id=' . $paper->ID . '&section=' . $sections[$previous_section_index] . (isset($_GET['finish']) ? '&finish=true' : '');
		}
	}
	else {
		$previous_exercise_index = $exercise_index - 1;
		if ($previous_exercise_index >= 0) {
			$previous_exercise_url = get_the_permalink() . '?paper_id=' . $paper->ID . '&section=' . $section . '&exercise_index=' . $previous_exercise_index . (isset($_GET['finish']) ? '&finish=true' : '');
		}
	}

	global $post; $post = $exercise;
	setup_postdata($exercise);
	include(locate_template('single-exercise.php'));

}

// exam cover
else {

if (empty($_GET['finish'])) {
	wp_enqueue_script('waveform');
	wp_enqueue_script('waveform-record');
	wp_enqueue_script('waveform-emitter');
	wp_enqueue_script('mp3-lame-encoder');
}

get_header(); the_post(); ?>

<div class="inner-head">
    <div class="container">
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <p class="description">
            <?php the_subtitle(); ?>
        </p>
        <div class="breadcrumb">
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
		<?php if (empty($_GET['finish'])): ?>
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
			<form method="post">
				<button type="submit" name="start" class="btn btn-block primary-btn orange-btn" style="cursor:pointer;">开始考试</button>
			</form>
		</div>
		<?php else: ?>
		<div>
			<form method="post" class="row">
				<div class="col-sm-6" style="padding-left:0;padding-right:0.5vw">
					<button type="submit" name="start" class=" btn btn-block primary-btn orange-btn" style="cursor:pointer;">检查答案</button>
				</div>
				<div class="col-sm-6" style="padding-right:0;padding-left:0.5vw">
					<button type="submit" name="restart" class="btn btn-block primary-btn orange-btn" style="cursor:pointer;">删除答案，重新考试</button>
				</div>
			</form>
		</div>
		<?php endif; ?>
	</div>
</section>

<?php } get_footer(); ?>
