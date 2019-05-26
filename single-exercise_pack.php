<?php the_post(); $post = get_post();
ensure_user_cap_on($post);
get_header();

$marked_exercises = get_user_meta(get_current_user_id(), 'marked_exercises') ?: [];
$exercises = get_field('exercises');
$exercises_exclude_tips = array_filter($exercises, function ($exercise) {
    return $exercise->post_type === 'exercise';
});

$complete_rate = 1 - count(array_diff(array_column($exercises_exclude_tips, 'ID'), $marked_exercises)) / count($exercises_exclude_tips);

get_header(); the_post(); ?>

<div class="inner-head">
    <div class="container">
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <p class="description">
            <?php the_subtitle(); ?>
        </p>
    </div><!-- End container -->
</div><!-- End Inner Page Head -->

<?php get_template_part('content-top-copyright'); ?>

<section class="full-section latest-courses-section no-slider" style="padding-top: 40px">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="add-courses top-margin" style="padding:30px;">
                    <img src="<?=get_stylesheet_directory_uri()?>/assets/img/icons/addcourse-icon.png" alt="" class="fl add-courses-icon">
                    <a class="add-courses-title ln-tr" style="margin-bottom:15px"><?php the_title(); ?></a>
                    <?php if ($last_exercise_packs = get_posts(array('post_type'=>'exercise_pack', 'meta_key'=>'next_pack', 'meta_value'=>get_the_ID()))): ?>
                    <a href="<?=get_the_permalink($last_exercise_packs[0]->ID)?>" class="pull-right"><i class="fa fa-undo"></i> <?=__('上一个打卡', 'bingo')?></a>
                    <?php endif; ?>
                    <div style="margin-left:10px"><?php the_content(); ?></div>
                </div><!-- End Add Courses -->
                <div class="home-skills">
                    <div class="skillbar clearfix" data-percent="<?=$complete_rate * 100?>%">
                        <div class="skillbar-title">
                            <span>
                                <?=__('完成度', 'bingo')?> <span class="seconds-left"><?=round($complete_rate * 100)?>%</span>
                                <?php if ($complete_rate >= 1 && $next_pack = get_field('next_pack')): ?>
                                <i class="fa fa-hand-o-right" style="margin-left:20px"></i>
                                <a href="<?=get_permalink($next_pack->ID)?>" style="color:white"><?=__('进入下一个打卡', 'bingo')?></a>
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="skillbar-bar" style="width:0"></div>
                    </div>
                </div>
            </div>
            <div class="section-content latest-courses-content listview fadeInDown-animation hide show animated fadeInDown col-md-8" style="margin-top:0">
                <?php foreach ($exercises as $index => $exercise): ?>
                <div class="course clearfix" style="padding:20px 60px<?php if ($index === 0): ?>; margin-top:17px<?php endif; ?>">
                    <?php if (in_array($exercise->ID, $marked_exercises)): ?>
                    <div class="featured-badge"><span>&nbsp;&nbsp;<?=__('已学', 'bingo')?></span></div>
                    <?php endif; ?>
                    <div class="course-info">
                        <h3 class="course-title"><a href="<?=get_the_permalink($exercise->ID)?>" target="_blank" class="ln-tr"><?=get_the_title($exercise->ID)?></a></h3>
                        <div class="details fl">
                            <div class="date ib">
                                <span class="icon"><i class="fa fa-pencil"></i></span>
                                <span class="text"><?=get_post_type_object($exercise->post_type)->label?></span>
                            </div><!-- date icon -->
                            <?php $question_types = wp_get_object_terms($exercise->ID, 'question_type', array('orderby' => 'id')); foreach ($question_types as $question_type): ?>
                            <div class="date ib">
                                <span class="icon"><i class="fa fa-tags"></i></span>
                                <span class="text"><?=$question_type->name?></span>
                            </div><!-- date icon -->
                            <?php endforeach; ?>
                        </div><!-- End Details Box -->
                        <div class="buttons fr">
                            <a href="<?=get_the_permalink($exercise->ID)?>" target="_blank" class="btn grad-btn orange-btn read-btn"><?=__('前往', 'bingo')?><?=get_post_type_object($exercise->post_type)->label?></a>
                        </div>
                    </div>
                </div><!-- End Course -->
                <?php endforeach; ?>
            </div><!-- End Latest-Courses Section Content -->
        </div><!-- End row -->
    </div>

</section>

<?php get_footer(); ?>
