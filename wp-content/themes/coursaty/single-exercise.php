<?php

if(!has_tag('free-trial')) {
    redirect_pricing_table('view_exercises');
}

get_header(); the_post(); $question_types = wp_get_object_terms(get_the_ID(), 'question_type', array('orderby' => 'id')); $question_type = $question_types[0]; $question_sub_type = $question_types[1]; ?>

<div class="copyright-header">
    <p>All Rights Reserved &copy; Bingo Training Pty. Ltd. ABN 64 618 887 951, ACN 618 887 951</p>
</div>

<article class="post single">
	<div class="container">
		<div class="row">
			<div class="col-md-8 main-content">
				<div class="row">
					<div class="col-md-12">
						<div class="entry clearfix">
							<h3 class="single-title fl">
								<span class="post-type-icon"><i class="fa fa-pencil"></i></span>
								<a href="#" class="ln-tr"><?php the_title(); ?></a>
                                <?php if ($rating = (int)get_post_meta(get_the_ID(), 'rating', true)): ?>
                                <div class="rating fr">
                                    <?php $star_full = 5; for ($star_index = 0; $star_index < $star_full; $star_index++): ?>
                                    <span class="star<?=$rating === ($star_full - $star_index) ? ' rated' : ''?>"></span>
                                    <?php endfor; ?>
                                </div>
                                <?php endif; ?>
							</h3><!-- End Title -->
							<div class="clearfix"></div>
							<div class="question content<?=$question_type->slug === 'highlight-incorrect-words' ? ' highlightable' : ''?>">
								<?php the_content(); ?>
							</div>
						</div><!-- End Entry -->
                        <?php if (in_array($question_type->slug, array('summarise-spoken-text', 'write-from-dictation', 'intensive-listening'))): ?>
						<div class="clearfix" style="margin-top:30px"></div>
						<div class="comment-form answer-form entry">
							<div class="addcomment-title">
								<span class="icon"><i class="fa fa-comments-o"></i></span>
								<span class="text">你的回答</span>
                                <?php if (in_array($question_type->slug, array('summarise-spoken-text'))): ?>
                                <span class="pull-right word-count">词数：<span class="count">0</span></span>
                                <?php endif; ?>
								<?php if (in_array($question_type->slug, array('write-from-dictation', 'intensive-listening'))): ?>
                                    <span class="pull-right word-diff-count">正确率：<span class="diff-percentage">-</span></span>
								<?php endif; ?>
							</div><!-- End Title -->
							<form method="post" action="/" id="answer-form">
								<div class="row">
									<div class="col-md-12">
										<div class="input">
											<textarea name="answer-area" id="answer-area" placeholder="内容" spellcheck="false"></textarea>
                                            <div class="diff-check-result content clearfix" style="white-space:pre-line;display:none"></div>
											<?php if (in_array($question_type->slug, array('write-from-dictation', 'intensive-listening'))): ?>
                                            <input type="submit" id="comment-submit" class="diff-check submit-input grad-btn ln-tr" value="检查" disabled="disabled">
                                            <input type="submit" id="comment-submit" class="resume-input submit-input grad-btn ln-tr" value="返回" style="display:none">
											<?php endif; ?>
										</div>
									</div>
								</div>
							</form><!-- End form -->
						</div><!-- End comment form -->
                        <?php endif; ?>
						<?php if (in_array($question_type->slug, array('read-aloud', 'repeat-sentence', 'describe-image', 'retell-lecture'))): ?>
                            <div class="clearfix" style="margin-top:30px"></div>
                            <div class="comment-form answer-form entry">
                                <div class="addcomment-title">
                                    <span class="icon"><i class="fa fa-comments-o"></i></span>
                                    <span class="text">你的回答</span>
                                </div><!-- End Title -->
                                <form method="post" action="/" id="answer-form">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input">
                                                <div class="post-content">

                                                    <div id="top-bar" class="playlist-top-bar">
                                                        <div class="playlist-toolbar">
                                                            <div class="btn-group">
                                                                <span class="btn-play btn btn-success">
                                                                    <i class="fa fa-play"></i>
                                                                </span>
                                                                <span class="btn-stop btn btn-danger">
                                                                    <i class="fa fa-stop"></i>
                                                                </span>
                                                                <span class="btn-record btn btn-danger disabled">
                                                                    <i class="fa fa-microphone"></i>
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
						<?php endif; ?>
                        <div class="comment-form comments-list entry answer">
                            <div class="addcomment-title" style="margin-bottom:20px">
                                <span class="icon"><i class="fa fa-comments-o"></i></span>
                                <span class="text">参考答案</span>
                                <a href="#" class="toggle grad-btn ln-tr pull-right<?=in_array($question_type->slug, array('intensive-listening')) ? ' disabled disable-on-high-diff' : ''?>">显示</a>
                            </div><!-- End Title -->
                            <div class="row" style="margin-top:20px">
                                <div class="col-md-12">
                                    <div class="input content<?=$question_type->slug === 'highlight-incorrect-words' ? ' highlightable' : ''?>" style="display:none">
                                        <?=wpautop(do_shortcode(get_post_meta(get_the_ID(), 'answer', true)))?>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End comment form -->
					</div><!-- End col-md-12 -->
				</div><!-- End main content row -->
			</div><!-- End Main Content - LEFT -->
			<div class="col-md-4">
                <div class="sidebar">
                    <?php if ($_GET['random']): ?>
                        <?php
                        $random_query = array(
							'post_type' => 'exercise',
							'posts_per_page' => 1,
							'orderby' => 'rand',
							'post__not_in' => array(get_the_ID())
						);

                        if ($_GET['tag']) {
                            $random_query['tag'] = $_GET['tag'];
                        }
                        else {
							$random_query['tax_query'] = array(
								array(
									'taxonomy' => 'question_type',
									'field' => 'slug',
									'terms' => $question_type->slug
								)
							);
                        }

                        $random_exercises = get_posts($random_query); if ($random_exercises && $random_exercise = $random_exercises[0]): ?>
                        <a href="<?=get_the_permalink($random_exercise) . '?random=yes' . ($_GET['tag'] ? '&tag=' . $_GET['tag'] : '')?>" class="btn primary-btn"><i class="fa fa-random"></i> 换一题</a>
                        <?php endif; ?>
                    <?php else: ?>
                    <?php $previous_exercise = get_adjacent_post(true, '', true, $_GET['tag'] ? 'post_tag' : 'question_type');?>
					<?php $next_exercise = get_adjacent_post(true, '', false, $_GET['tag'] ? 'post_tag' : 'question_type');?>
                    <div class="row">
                        <div class="col-md-6">
							<?php if ($previous_exercise): ?><a class="btn primary-btn " href="<?=get_the_permalink($previous_exercise) . ($_GET['tag'] ? '?tag=' . $_GET['tag'] : '')?>" title="<?=get_the_title($previous_exercise)?>">&laquo; 上一题</a><?php endif; ?>
                        </div>
                        <div class="col-md-6">
							<?php if ($next_exercise): ?><a class="btn primary-btn pull-right" href="<?=get_the_permalink($next_exercise) .  ($_GET['tag'] ? '?tag=' . $_GET['tag'] : '')?>" title="<?=get_the_title($next_exercise)?>">下一题 &raquo;</a><?php endif; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <select class="go-to-exercise" style="width:100%;height:40px;font-size:16px;margin-bottom:10px;background:none">
                                <?php $all_query = array(
									'post_type' => 'exercise',
									'posts_per_page' => -1,
									'order' => 'asc',
									'orderby' => 'ID'
								);

								if ($_GET['tag']) {
									$all_query['tag'] = $_GET['tag'];
									$all_query['order'] = 'desc';
									$all_query['orderby'] = 'post_date';
								}
								else {
									$all_query['tax_query'] = array(
										array(
											'taxonomy' => 'question_type',
											'field' => 'slug',
											'terms' => $question_sub_type ? $question_sub_type->slug : $question_type->slug
										)
									);
								}

                                foreach(get_posts($all_query) as $exercise): ?>
                                <option value="<?=get_the_permalink($exercise)?>"<?=$exercise->ID === get_the_ID() ? ' selected' : ''?>><?=get_the_title($exercise)?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="sidebar-widget">
                        <span class="widget-icon"><i class="fa fa-clock-o"></i></span>
                        <h5 class="sidebar-widget-title ib">计时器</h5>
                        <div class="home-skills">
                            <div class="skillbar audio-progress clearfix" style="display:none">
                                <div class="skillbar-title">
                                    <span>音频</span>
                                </div>
                                <div class="skillbar-bar"></div>
                                <div class="controls">
									<?php if (in_array($question_type->slug, array('intensive-listening'))): ?>
                                    <i id="rewind-control" class="fa fa-fast-backward"></i>
                                    <i id="fast-forward-control" class="fa fa-fast-forward"></i>
									<?php endif; ?>
                                    <i id="play-control" class="fa fa-play" style="display:none;"></i>
                                    <i id="pause-control" class="fa fa-pause" style="display:none"></i>
                                    <i id="replay-control" class="fa fa-refresh"></i>
                                </div>
                            </div>
                            <?php if(in_array($question_type->slug, array('read-aloud'))): ?>
                            <div class="skillbar timer clearfix" data-duration="40">
                                <div class="skillbar-title">
                                    <span>准备 <span class="seconds-left">00:40</span></span>
                                </div>
                                <div class="skillbar-bar"></div>
                                <div class="controls">
                                    <i class="skip fa fa-step-forward"></i>
                                </div>
                            </div>
                            <?php endif; ?>
							<?php if(in_array($question_type->slug, array('retell-lecture'))): ?>
                            <div class="skillbar timer clearfix" data-duration="10" data-wait="previous">
                                <div class="skillbar-title">
                                    <span>准备 <span class="seconds-left">00:10</span></span>
                                </div>
                                <div class="skillbar-bar"></div>
                                <div class="controls">
                                    <i class="skip fa fa-step-forward"></i>
                                </div>
                            </div>
							<?php endif; ?>
							<?php if(in_array($question_type->slug, array('describe-image'))): ?>
                            <div class="skillbar timer clearfix" data-duration="25">
                                <div class="skillbar-title">
                                    <span>看图 <span class="seconds-left">00:25</span></span>
                                </div>
                                <div class="skillbar-bar"></div>
                                <div class="controls">
                                    <i class="skip fa fa-step-forward"></i>
                                </div>
                            </div>
							<?php endif; ?>
							<?php if(in_array($question_type->slug, array('read-aloud', 'describe-image'))): ?>
                            <div class="skillbar timer clearfix" data-wait="previous" data-duration="40" data-is-answer="true">
                                <div class="skillbar-title">
                                    <span>说话 <span class="seconds-left">00:40</span></span>
                                </div>
                                <div class="skillbar-bar"></div>
                            </div>
							<?php endif; ?>
							<?php if(in_array($question_type->slug, array('retell-lecture'))): ?>
                            <div class="skillbar timer clearfix" data-wait="previous" data-duration="40" data-is-answer="true">
                                <div class="skillbar-title">
                                    <span>描述 <span class="seconds-left">00:40</span></span>
                                </div>
                                <div class="skillbar-bar"></div>
                            </div>
							<?php endif; ?>
							<?php if(in_array($question_type->slug, array('summarise-spoken-text'))): ?>
                            <div class="skillbar timer clearfix" data-duration="600">
                                <div class="skillbar-title">
                                    <span>时间 <span class="seconds-left">10:00</span></span>
                                </div>
                                <div class="skillbar-bar"></div>
                            </div>
							<?php endif; ?>
							<?php if(in_array($question_type->slug, array('intensive-listening'))): ?>
                                <div class="skillbar timer clearfix" data-duration="2400">
                                    <div class="skillbar-title">
                                        <span>时间 <span class="seconds-left">40:00</span></span>
                                    </div>
                                    <div class="skillbar-bar"></div>
                                </div>
							<?php endif; ?>
                            <audio id="ding-sound" preload="auto" src="<?=get_stylesheet_directory_uri()?>/assets/audios/ding.wav" style="display:none"></audio>
                        </div>
                    </div>
					<?php
					$uri = $_GET['random'] ? remove_query_arg(array('random'), $wp->request . '/') : add_query_arg(array('random' => 'yes'), $wp->request . '/');
					$uri = $_GET['tag'] ? add_query_arg(array('tag' => $_GET['tag']), $uri) : $uri;
					?>
                    <a class="btn primary-btn" href="<?=home_url($uri);?>">切换到<?=$_GET['random'] ? '顺序练习' : '随机练习'?></a>
                    <?php $question_type_desc = get_posts(array('post_type' => 'question_type_desc', 'posts_per_page' => 1, 'tax_query' => array(
						array(
							'taxonomy' => 'question_type',
							'field' => 'slug',
							'terms' => $question_type->slug
						)
					)))[0]; ?>
                    <?php if ($tips = get_post_meta($question_type_desc->ID, 'tips', true)): ?>
                    <div class="sidebar-widget">
                        <span class="widget-icon"><i class="fa fa-info-circle"></i></span>
                        <h5 class="sidebar-widget-title ib">提示</h5>
                        <div class="content">
                            <?=$tips?>
                        </div>
                    </div>
                    <?php endif; ?>
					<?php if ($notes_id = get_post_meta(get_the_ID(), 'notes', true)): ?>
                    <div class="sidebar-widget">
                        <span class="widget-icon"><i class="fa fa-info-circle"></i></span>
                        <h5 class="sidebar-widget-title ib">笔记</h5>
                        <small class="fr">点击图片放大</small>
                        <div class="content" style="overflow:auto;max-height:150px">
                            <a href="<?=wp_get_attachment_url($notes_id)?>"><img src="<?=wp_get_attachment_image_url($notes_id, 'post-thumbnail')?>"></a>
                        </div>
                    </div>
					<?php endif; ?>
                </div>
			</div><!-- End Sidebar - RIGHT -->
		</div><!-- End main row -->
	</div><!-- End container -->
</article><!-- End Single Article -->

<style type="text/css">
    .question.content .mejs-audio {
        display: none;
    }
</style>

<script type="text/javascript">
jQuery(function($) {

    // toggle answer display
    $('.comments-list.answer .toggle').click(function(e) {
        e.preventDefault();

        if ($(this).hasClass('disabled')) {
            return;
        }

        if ($(this).text() === '显示') {
            $(this).text('隐藏');
            $('.comments-list.answer .content').show(300);
        }
        else {
            $(this).text('显示');
            $('.comments-list.answer .content').hide(300);
        }
    });

    // timers
    $.fn.startTimer = function () {
        var tick = 0;
        var self = this;
        var duration = $(this).data('duration');
        var interval = setInterval(function() {
            tick += 1;
            var secondsLeft = duration - tick;
            var minutesLeft = Math.floor(secondsLeft / 60);
            var minuteSecondsLeft = secondsLeft % 60;
            $(self).find('.seconds-left').text(('0' + minutesLeft).slice(-2) + ':' + ('0' + minuteSecondsLeft).slice(-2));
            $(self).find('.skillbar-bar').css({width: tick / duration * 100 + '%'});
            if (tick === duration) {
                clearInterval(interval);
                $(self).trigger('time-up');
                return false;
            }
        }, 1000);

        if ($(this).data('is-answer')) {
            var answerVoiceRecorder = document.querySelector('#answer-voice-record');
            $('#ding-sound').get(0).play();
            $('.btn-record').trigger('click');
        }

        return interval;
    };

    // auto plays audio in question and show audio timer
    var audioProgress = $('.audio-progress');
    $('.question.content audio').each(function() {
        var self = this;
        audioProgress.show()
        .on('click', '#pause-control', function () {
            self.pause();
        })
        .on('click', '#play-control', function () {
            self.play();
        })
        .on('click', '#replay-control', function () {
            self.currentTime = 0;
            self.play();
        })
        .on('click', '#rewind-control', function () {
            self.currentTime -= 5;
        })
        .on('click', '#fast-forward-control', function () {
            self.currentTime += 5;
        });
        setTimeout(function () {
            self.play();
        }, 3000);
    })
    .on('play', function() {
        audioProgress.find('#play-control').hide();
        audioProgress.find('#pause-control').show();
    })
    .on('pause', function() {
        audioProgress.find('#play-control').show();
        audioProgress.find('#pause-control').hide();
    })
    // update audio timer
    .on('timeupdate', function() {
        if (this.currentTime && this.duration) {
            $('.audio-progress .skillbar-bar').css({width: this.currentTime / this.duration * 100 + '%'});
        }
    })
    // trigger next timer on audio ended
    .on('ended', function () {
        var nextTimer = audioProgress.next('.timer');
        if (nextTimer.data('wait') === 'previous') {
            nextTimer.startTimer();
        }
        audioProgress.find('#pause-control').hide();
    });

    // auto start timer
    $('.timer').each(function() {
        var wait = $(this).data('wait') || 0;
        var self = this;

        if (!isNaN(wait)) {
            setTimeout(function(){
                var interval = $(self).startTimer();
                $(self).data('interval', interval);
            }, wait * 1000);
        }
    })
    // trigger next timer on time up
    .on('time-up', function () {
        var nextTimer = $(this).next('.timer');
        if (nextTimer.data('wait') === 'previous') {
            nextTimer.data('interval', nextTimer.startTimer());
        }
        $(this).find('.skip').remove();
        if ($(this).data('is-answer')) {
            $('.btn-stop').trigger('click');
        }
    })
    .on('click', '.skip', function (e) {
        var self = e.delegateTarget;
        clearInterval($(self).data('interval'));
        $(self).find('.seconds-left').text('00:00');
        $(self).find('.skillbar-bar').css({width: '100%'});
        $(this).trigger('time-up');
    });

    var answerContentElement = $('.answer.entry .content');
    var answerToggleButton = $('.answer.entry .toggle');
    var answer = answerContentElement.text().replace(/答案/, '').trim();
    var answerWordCount = answer.split(/\s+/).length;

    var answerForm = $('.comment-form.answer-form');
    var wordCountElement = answerForm.find('.word-count>.count');
    var wordDiffCountElement = answerForm.find('.word-diff-count>.diff-percentage');
    var answerArea = answerForm.find('#answer-area');
    var answerCheckButton = answerForm.find('.diff-check');
    var answerResumeButton = answerForm.find('.resume-input');

    answerArea.on('keyup', function() {

        // answer word count
        var wordCount = $(this).val().trim().split(/\s+/).length;
        wordCountElement.text(wordCount);

        if (wordCount > 70) {
            wordCountElement.addClass('over-words');
        }
        else {
            wordCountElement.removeClass(('over-words'));
        }

        // answer diff rate
        var diffWords = JsDiff.diffWords(answer, $(this).val()).reduce(function (stat, current) {
            var diffWordCount = current.value.trim().split(/\s+/).length;

            if (current.added && !stat.modified) {
                stat.diff += diffWordCount;
            }
            else if (current.removed) {
                stat.diff += diffWordCount;
                stat.modified += diffWordCount;
            }
            else if (current.added && stat.modified) {
                stat.modified = 0;
            }

            return stat;

        }, {diff:0, modified:0}).diff;

        var diffRate = diffWords / answerWordCount;

        wordDiffCountElement.text((100 - diffRate * 100).toFixed(0) + '%');

        if (diffRate <= 0.2) {
            answerCheckButton.prop('disabled', false);
            answerToggleButton.removeClass('disabled');
        }
        else {
            answerCheckButton.prop('disabled', true);
            if (answerToggleButton.hasClass('disable-on-high-diff')) {
                answerToggleButton.addClass('disabled');
            }
        }
    });

    answerCheckButton.on('click', function (e) {
        e.preventDefault();

        var diff = JsDiff.diffWords(answer, answerArea.val());

        var resultContainer = answerForm.find('.diff-check-result').html('').show();

        diff.forEach(function (part) {
            var word = $('<span/>').text(part.value);
            if (part.removed) {
                word.addClass('removed');
            }
            if (part.added) {
                word.addClass('added');
            }
            resultContainer.append(word);
        });

        resultContainer.html(resultContainer.html().replace(/\n{2,}/g, "\n"));

        answerArea.hide(); answerCheckButton.hide(); answerResumeButton.show();
    });

    answerResumeButton.on('click', function (e) {
        e.preventDefault();
        answerForm.find('.diff-check-result').hide();
        answerArea.show(); answerCheckButton.show(); answerResumeButton.hide();
    });

    // highlight on click
    $('.question.content.highlightable blockquote p').each(function () {
        $(this).html($(this).html().split(/\s+/).map(function (word) {
            return '<span>' + word + '</span>';
        }).join(' '));
    })
    .on('click', 'span', function () {
        $(this).replaceWith('<del>' + $(this).html() + '</del>');
    })
    .on('click', 'del', function () {
        $(this).replaceWith('<span>' + $(this).html() + '</span>');
    });

    $('.go-to-exercise').change(function () {
        window.location.href = $(this).val();
    });
});
</script>

<?php

if (in_array($question_type->slug, array('read-aloud', 'repeat-sentence', 'describe-image', 'retell-lecture'))) {
	wp_enqueue_script('waveform');
	wp_enqueue_script('waveform-record');
	wp_enqueue_script('waveform-emitter');
}

get_footer();
