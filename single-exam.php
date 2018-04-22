<?php

$exam_type = get_post_meta(get_the_ID(), 'type', true);

if(!has_tag('free-trial') && !(is_limited_free(get_current_user_id()) && has_tag('limited-free'))) {
	if ($exam_type === 'ccl') {
		redirect_pricing_table('view_ccl');
	}
	else {
		redirect_pricing_table('view_exercises');
	}
}

$user = wp_get_current_user();

if ($exam_type === 'ccl') {
	$sections_time_limit = array('dialogue'=>3000);
} else {
	$sections_time_limit = array('speaking'=>3000, 'writing'=>3000, 'reading'=>2400, 'break' => 600, 'listening'=>3300);
}

$sections = array_keys($sections_time_limit);

// exam exercises
if (isset($_GET['paper_id'])):
	
	$paper = get_post($_GET['paper_id']);
	$paper_submitted = get_post_meta($paper->ID, 'submitted_at', true);

	if (!$paper || $paper->post_status !== 'private') {
		header('Location: ' . get_the_permalink()); exit;
	}

	$exam = get_post();

	$review = isset($_GET['finish']) && $_GET['finish'] && $paper_submitted; // view in review mode
	// in review mode, read section and exercise_index from url,
	// in test mode, read from paper post
	$section = $review ? $_GET['section'] : get_post_meta($paper->ID, 'section', true);
	$exercise_index = $review ? ($_GET['exercise_index'] ?: 0) : get_post_meta($paper->ID, 'exercise_index', true);
	$section_exercises = get_field($section);
	$exercise = $section_exercises[$exercise_index];
	$question_type = wp_get_object_terms($exercise->ID, 'question_type')[0];
	$is_last_exercise_of_section = !$section_exercises || count($section_exercises) === $exercise_index + 1;
	$section_index = array_search($section, $sections);
	$is_last_section_of_exam = count($sections) === $section_index + 1;

	if (!$review) {
		if (isset($_POST['answer'])) {
			// save answer to paper
			update_post_meta($paper->ID, 'answer_' . $section . '_' . $exercise_index, $_POST['answer']);

			// individual timer question types
			if (isset($_POST['current_exercise_time_left']) && is_numeric($_POST['current_exercise_time_left']) && in_array($question_type->slug, array('summarise-spoken-text', 'swt'))) {
				$section_start_time = get_post_meta($paper->ID, 'time_start_' . $section, true);
				$section_start_time -= $_POST['current_exercise_time_left'];
				update_post_meta($paper->ID, 'time_start_' . $section, $section_start_time);
			}

			echo json_encode(get_post_meta($paper->ID, 'answer_' . $section . '_' . $exercise_index, true));
			exit;
		}

		if (isset($_POST['submit'])) {
			// if is not last exercise of the section, go to next exercise
			if (!$is_last_exercise_of_section) {
				update_post_meta($paper->ID, 'exercise_index', $exercise_index + 1);
			}
			// is last exercise of the section
			elseif (!$is_last_section_of_exam) {
				// is not last section, go to next section
				$section_index = array_search($section, $sections);
				$next_section = $sections[$section_index + 1];
				update_post_meta($paper->ID, 'section', $next_section);
				update_post_meta($paper->ID, 'exercise_index', 0);
			}
			// is last section, finish the exam
			else {
				delete_post_meta($paper->ID, 'section');
				delete_post_meta($paper->ID, 'exercise_index');
				update_post_meta($paper->ID, 'submitted_at', time());
				header('Location:' . get_the_permalink() . '?&finish=true'); exit;
			}
			header('Location:' . get_the_permalink()); exit;
		}

		// set section start time
		if (!$section_start_time = get_post_meta($paper->ID, 'time_start_' . $section, true)) {
			$section_start_time = time();
			add_post_meta($paper->ID, 'time_start_' . $section, $section_start_time);
		}

		// calculate section time left
		$section_time_left = $sections_time_limit[$section] - time() + $section_start_time;
	}

	// in review mode, assign next and previous section and exercise links
	else {
		if (!$is_last_exercise_of_section) {
			// find next exercise
			$next_exercise = $section_exercises[$exercise_index + 1];
			$next_exercise_url = get_the_permalink() . '?&paper_id=' . $paper->ID . '&section=' . $section . '&exercise_index=' . ($exercise_index + 1) . '&finish=true';
		}
		elseif (!$is_last_section_of_exam) {
			$next_section_index = array_search($section, $sections) + 1;
			$next_section_url = get_the_permalink() . '?paper_id=' . $paper->ID . '&section=' . $sections[$next_section_index] . '&finish=true';
		} else {
			$return_url = get_the_permalink() . '?finish=true';
		}
		if ($exercise_index === 0) {
			$previous_section_index = array_search($section, $sections) - 1;
			if ($previous_section_index >= 0) {
				$previous_section_url = get_the_permalink() . '?paper_id=' . $paper->ID . '&section=' . $sections[$previous_section_index] . '&finish=true';
			}
		}
		else {
			$previous_exercise_index = $exercise_index - 1;
			if ($previous_exercise_index >= 0) {
				$previous_exercise_url = get_the_permalink() . '?paper_id=' . $paper->ID . '&section=' . $section . '&exercise_index=' . $previous_exercise_index . '&finish=true';
			}
		}
	}

	$answer = get_post_meta($paper->ID, 'answer_' . $section . '_' . $exercise_index, true);

	global $post; $post = $exercise;
	setup_postdata($exercise);
	include(locate_template('single-exercise.php'));

else:
// exam cover

	$paper = get_posts(array('post_type'=>'paper', 'post_status'=>'private', 'author'=>$user->ID, 'meta_key'=>'exam_id', 'meta_value'=>get_the_ID()))[0];
	$paper_submitted = get_post_meta($paper->ID, 'submitted_at', true);
	
	// resume a unsubmitted paper
	if ($paper && !$paper_submitted) {
		$paper_section = get_post_meta($paper->ID, 'section', true);
		$paper_exercise_index = get_post_meta($paper->ID, 'exercise_index', true);
		header('Location: ' . get_the_permalink() . '?paper_id=' . $paper->ID); exit;
	}
	
	if (isset($_POST['start']) && !$paper) {
		// start exam and create a paper
		$paper_id = wp_insert_post(array(
			'post_type' => 'paper',
			'post_title' => $user->display_name . '的' . get_the_title() . '试卷',
			'post_status' => 'private'
		));
		add_post_meta($paper_id, 'exam_id', get_the_ID());

		// set to first section, first exercise
		add_post_meta($paper_id, 'section', $sections[0]);
		add_post_meta($paper_id, 'exercise_index', 0);
		// go to exam exercise
		header('Location: ' . get_the_permalink() . '?paper_id=' . $paper_id); exit;
	}

	// trash the paper and restart an exam
	if (isset($_POST['restart']) && $paper) {
		wp_trash_post($paper->ID);
		header('Location: ' . get_the_permalink()); exit;
	}

	if ($paper && $paper_submitted) {
		if (empty($_GET['finish'])) {
			header('Location: ' . get_the_permalink() . '?finish=true'); exit;
		}
	}

	if ($paper && $paper_submitted && isset($_POST['review'])) {
		header('Location: ' . get_the_permalink() . '?finish=true&paper_id=' . $paper->ID . '&section=' . $sections[0]); exit;
	}

	if (!$paper) {
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
                <li class="ib current-page"><a href="">考试</a></li>
            </ul>
        </div>
    </div><!-- End container -->
</div><!-- End Inner Page Head -->

<?php get_template_part('content-top-copyright'); ?>

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
					<button type="submit" name="review" class=" btn btn-block primary-btn orange-btn" style="cursor:pointer;">检查答案</button>
				</div>
				<div class="col-sm-6" style="padding-right:0;padding-left:0.5vw">
					<button type="submit" name="restart" class="btn btn-block primary-btn orange-btn" style="cursor:pointer;">删除答案，重新考试</button>
				</div>
			</form>
		</div>
		<?php endif; ?>
	</div>
</section>

<?php endif; get_footer(); ?>
