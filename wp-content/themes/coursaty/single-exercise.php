<?php

if(!has_tag('free-trial') && !current_user_can('view_exercises')) {
	header('Location: ' . site_url() . '/pricing-table/'); exit;
}

get_header(); the_post(); $question_type = wp_get_object_terms(get_the_ID(), 'question_type', array('orderby' => 'id'))[0]; ?>

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
							</h3><!-- End Title -->
							<div class="clearfix"></div>
							<div class="question content<?php if($question_type->slug === 'highlight-incorrect-words'): ?> highlightable <?php endif; ?>">
								<?php the_content(); ?>
							</div>
						</div><!-- End Entry -->
                        <?php if (in_array($question_type->slug, array('summarise-spoken-text', 'write-from-dictation'))): ?>
						<div class="clearfix" style="margin-top:30px"></div>
						<div class="comment-form">
							<div class="addcomment-title">
								<span class="icon"><i class="fa fa-comments-o"></i></span>
								<span class="text">你的回答</span>
                                <?php if (in_array($question_type->slug, array('summarise-spoken-text'))): ?>
                                <span class="pull-right word-count">词数：<span class="count">0</span></span>
                                <?php endif; ?>
							</div><!-- End Title -->
							<form method="post" action="/" id="answer-form">
								<div class="row">
									<div class="col-md-12">
										<div class="input">
											<textarea name="answer-area" id="answer-area" placeholder="内容" spellcheck="false"></textarea>
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
                                <a href="#" class="toggle grad-btn ln-tr pull-right">显示</a>
                            </div><!-- End Title -->
                            <div class="row" style="margin-top:20px">
                                <div class="col-md-12">
                                    <div class="input content" style="display:none">
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
                            </div>
                            <?php if(in_array($question_type->slug, array('read-aloud'))): ?>
                            <div class="skillbar timer clearfix" data-duration="40">
                                <div class="skillbar-title">
                                    <span>准备 <span class="seconds-left">40</span>s</span>
                                </div>
                                <div class="skillbar-bar"></div>
                            </div>
                            <?php endif; ?>
							<?php if(in_array($question_type->slug, array('retell-lecture'))): ?>
                                <div class="skillbar timer clearfix" data-duration="10" data-wait="previous">
                                    <div class="skillbar-title">
                                        <span>准备 <span class="seconds-left">10</span>s</span>
                                    </div>
                                    <div class="skillbar-bar"></div>
                                </div>
							<?php endif; ?>
							<?php if(in_array($question_type->slug, array('describe-image'))): ?>
                            <div class="skillbar timer clearfix" data-duration="25">
                                <div class="skillbar-title">
                                    <span>看图 <span class="seconds-left">25</span>s</span>
                                </div>
                                <div class="skillbar-bar"></div>
                            </div>
							<?php endif; ?>
							<?php if(in_array($question_type->slug, array('read-aloud', 'describe-image'))): ?>
                            <div class="skillbar timer clearfix" data-wait="previous" data-duration="40" data-is-answer="true">
                                <div class="skillbar-title">
                                    <span>说话 <span class="seconds-left">40</span>s</span>
                                </div>
                                <div class="skillbar-bar"></div>
                            </div>
							<?php endif; ?>
							<?php if(in_array($question_type->slug, array('retell-lecture'))): ?>
                                <div class="skillbar timer clearfix" data-wait="previous" data-duration="40" data-is-answer="true">
                                    <div class="skillbar-title">
                                        <span>描述 <span class="seconds-left">40</span>s</span>
                                    </div>
                                    <div class="skillbar-bar"></div>
                                </div>
							<?php endif; ?>
							<?php if(in_array($question_type->slug, array('summarise-spoken-text'))): ?>
                                <div class="skillbar timer clearfix" data-duration="600">
                                    <div class="skillbar-title">
                                        <span>时间 <span class="seconds-left">600</span>s</span>
                                    </div>
                                    <div class="skillbar-bar"></div>
                                </div>
							<?php endif; ?>
                            <audio id="ding-sound" preload="auto" src="<?=get_stylesheet_directory_uri()?>/assets/audios/ding.wav" style="display:none"></audio>
                        </div>
                    </div>
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
                    <?php
                    $uri = $_GET['random'] ? remove_query_arg(array('random'), $wp->request . '/') : add_query_arg(array('random' => 'yes'), $wp->request . '/');
					$uri = $_GET['tag'] ? add_query_arg(array('tag' => $_GET['tag']), $uri) : $uri;
                    ?>
                    <a class="btn primary-btn" href="<?=home_url($uri);?>">切换到<?=$_GET['random'] ? '顺序练习' : '随机练习'?></a>
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
        if ($(this).text() === '显示') {
            $(this).text('隐藏');
            $('.comments-list.answer .content').show(300);
        }
        else {
            $(this).text('显示');
            $('.comments-list.answer .content').hide(300);
        }
    });
    $('.sidebar').sticky({topSpacing:30, bottomSpacing: 615});

    // timers
    $.fn.startTimer = function () {
        var tick = 0;
        var self = this;
        var duration = $(this).data('duration');
        var interval = setInterval(function() {
            tick += 1;
            $(self).find('.seconds-left').text((duration - tick));
            $(self).find('.skillbar-bar').css({width: tick / duration * 100 + '%'});
            if (tick === duration) {
                clearInterval(interval);
                $(self).trigger('time-up');
                return false;
            }
        }, 1000);

        if ($(this).data('is-answer')) {
            $('#ding-sound').get(0).play();
        }
    };

    // auto plays audio in question and show audio timer
    $('.question.content audio').each(function() {
        $('.audio-progress').show();
        var self = this;
        setTimeout(function () {
            self.play();
        }, 3000);
    })
    // update audio timer
    .on('timeupdate', function() {
        if (this.currentTime && this.duration) {
            $('.audio-progress .skillbar-bar').css({width: this.currentTime / this.duration * 100 + '%'});
        }
    })
    // trigger next timer on audio ended
    .on('ended', function () {
        var nextTimer = $('.audio-progress').next('.timer');
        if (nextTimer.data('wait') === 'previous') {
            nextTimer.startTimer();
        }
    });

    // auto start timer
    $('.timer').each(function() {
        var wait = $(this).data('wait') || 0;
        var self = this;

        if (!isNaN(wait)) {
            setTimeout(function(){
                $(self).startTimer();
            }, wait * 1000);
        }
    })
    // trigger next timer on time up
    .on('time-up', function () {
        var nextTimer = $(this).next('.timer');
        if (nextTimer.data('wait') === 'previous') {
            nextTimer.startTimer();
        }
    });

    // answer word count
    $('#answer-area').on('keyup', function() {
        var wordCountElement = $(this).parents('.comment-form').find('.word-count>.count');
        var wordCount = $(this).val().trim().split(/\s+/).length;
        wordCountElement.text(wordCount);

        if (wordCount > 70) {
            wordCountElement.addClass('over-words');
        }
        else {
            wordCountElement.removeClass(('over-words'));
        }

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
});
</script>

<?php get_footer(); ?>