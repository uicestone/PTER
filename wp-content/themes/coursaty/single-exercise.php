<?php get_header(); the_post(); ?>

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
							<div class="content">
								<?php the_content(); ?>
							</div>
						</div><!-- End Entry -->
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
											<input type="submit" id="comment-submit" class="submit-input grad-btn ln-tr" value="保存">
										</div>
									</div>
								</div>
							</form><!-- End form -->
						</div><!-- End comment form -->
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
                                    'taxonomy' => 'question_model',
                                    'field' => 'slug',
                                    'terms' => wp_get_object_terms(get_the_ID(), 'question_model')[0]->slug
                                )
                            ),
                            'posts_per_page' => 1,
                            'orderby' => 'rand',
                            'post__not_in' => array(get_the_ID())
                        )); if ($random_exercises && $random_exercise = $random_exercises[0]): ?>
                        <a href="<?=get_the_permalink($random_exercise) . ($_GET['random'] ? '?random=yes' : '')?>" class="btn primary-btn"><i class="fa fa-random"></i> 换一题</a>
                        <?php endif; ?>
                    <?php else: ?>
                    <?php $previous_exercise = get_adjacent_post(true, '', true, 'question_model');?>
					<?php $next_exercise = get_adjacent_post(true, '', false, 'question_model');?>
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
                            <div class="skillbar timer clearfix" data-duration="25">
                                <div class="skillbar-title">
                                    <span>看图 <span class="seconds-left">25</span>s</span>
                                </div>
                                <div class="skillbar-bar"></div>
                            </div>
                            <div class="skillbar timer clearfix" data-wait="25" data-duration="40">
                                <div class="skillbar-title">
                                    <span>说话 <span class="seconds-left">40</span>s</span>
                                </div>
                                <div class="skillbar-bar"></div>
                            </div>
                        </div>
                    </div>
                </div>
			</div><!-- End Sidebar - RIGHT -->
		</div><!-- End main row -->
	</div><!-- End container -->
</article><!-- End Single Article -->

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
    $('.sidebar').sticky({topSpacing:30, bottomSpacing: 614});

    $('.timer').each(function() {
        var wait = $(this).data('wait') || 0;
        var duration = $(this).data('duration');
        var tick = 0;
        var self = this;
        setTimeout(function(){
            var interval = setInterval(function() {
                tick += 0.1;
                $(self).find('.seconds-left').text((duration - tick).toFixed(0).replace('-', ''));
                $(self).find('.skillbar-bar').css({width: tick / duration * 100 + '%'});
                if (tick.toFixed(1) === duration.toFixed(1)) {
                    clearInterval(interval);
                    return false;
                }
            }, 100);
        }, wait * 1000);
    });
});
</script>

<?php get_footer(); ?>