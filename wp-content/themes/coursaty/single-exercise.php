<?php get_header(); the_post(); $question_type = wp_get_object_terms(get_the_ID(), 'question_type')[0]; ?>

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
							<div class="question content">
								<?php the_content(); ?>
							</div>
						</div><!-- End Entry -->
                        <?php if (in_array($question_type->slug, array('summarize-spoken-text', 'write-from-dictation'))): ?>
						<div class="clearfix" style="margin-top:30px"></div>
						<div class="comment-form">
							<div class="addcomment-title">
								<span class="icon"><i class="fa fa-comments-o"></i></span>
								<span class="text">你的回答</span>
							</div><!-- End Title -->
							<form method="post" action="/" id="comment-form">
								<div class="row">
									<div class="col-md-12">
										<div class="input">
											<textarea name="comment-area" id="comment-area" placeholder="内容"></textarea>
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
                        <?php $random_exercises = get_posts(array(
                            'post_type' => 'exercise',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'question_type',
                                    'field' => 'slug',
                                    'terms' => $question_type->slug
                                )
                            ),
                            'posts_per_page' => 1,
                            'orderby' => 'rand',
                            'post__not_in' => array(get_the_ID())
                        )); if ($random_exercises && $random_exercise = $random_exercises[0]): ?>
                        <a href="<?=get_the_permalink($random_exercise) . ($_GET['random'] ? '?random=yes' : '')?>" class="btn primary-btn"><i class="fa fa-random"></i> 换一题</a>
                        <?php endif; ?>
                    <?php else: ?>
                    <?php $previous_exercise = get_adjacent_post(true, '', true, 'question_type');?>
					<?php $next_exercise = get_adjacent_post(true, '', false, 'question_type');?>
                    <div class="row">
                        <div class="col-md-6">
							<?php if ($previous_exercise): ?><a class="btn primary-btn " href="<?=get_the_permalink($previous_exercise)?>" title="<?=get_the_title($previous_exercise)?>">&laquo; 上一题</a><?php endif; ?>
                        </div>
                        <div class="col-md-6">
							<?php if ($next_exercise): ?><a class="btn primary-btn pull-right" href="<?=get_the_permalink($next_exercise)?>" title="<?=get_the_title($next_exercise)?>">下一题 &raquo;</a><?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="sidebar-widget cats">
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
                            <audio id="ding-sound" preload="auto" src="<?=get_stylesheet_directory_uri()?>/assets/audios/ding.wav" style="display:none"></audio>
                        </div>
                    </div>
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

    $('.question.content audio').each(function() {
        $('.audio-progress').show();
        var self = this;
        setTimeout(function () {
            self.play();
        }, 3000);
    })
    .on('timeupdate', function() {
        if (this.currentTime && this.duration) {
            $('.audio-progress .skillbar-bar').css({width: this.currentTime / this.duration * 100 + '%'});
        }
    })
    .on('ended', function () {
        var nextTimer = $('.audio-progress').next('.timer');
        if (nextTimer.data('wait') === 'previous') {
            nextTimer.startTimer();
        }
    });

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

    $('.timer').each(function() {
        var wait = $(this).data('wait') || 0;
        var self = this;

        if (!isNaN(wait)) {
            setTimeout(function(){
                $(self).startTimer();
            }, wait * 1000);
        }
    }).on('time-up', function () {
        var nextTimer = $(this).next('.timer');
        if (nextTimer.data('wait') === 'previous') {
            nextTimer.startTimer();
        }
    });
});
</script>

<?php get_footer(); ?>