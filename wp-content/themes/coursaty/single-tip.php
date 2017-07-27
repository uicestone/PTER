<?php

if(!has_tag('free-trial')) {
    redirect_pricing_table('view_tips');
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
                <li class="ib current-page"><a href="">技巧</a></li>
            </ul>
        </div>
    </div><!-- End container -->
</div><!-- End Inner Page Head -->

<div class="clearfix"></div>

<article class="post single">
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
		<?=do_shortcode('[video width="1280" height="720" mp4="' . site_url() . '/wp-content/uploads/' . $post->post_name . '.mp4"][/video]')?>
    </div><!-- End container -->
</article><!-- End Single Article -->
<?php endif; ?>

<?php get_footer(); ?>
