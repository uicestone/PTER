<?php get_header(); the_post(); ?>

<div class="inner-head">
    <div class="container">
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <p class="description">
            <?php the_subtitle(); ?>
        </p>
        <div class="breadcrumb">
			<?php $question_model = wp_get_object_terms(get_the_ID(), 'question_model')[0]; ?>
            <ul class="clearfix">
                <li class="ib"><a href="<?=site_url()?>">首页</a></li>
                <li class="ib"><a href="<?=site_url()?>/question_model/<?=$question_model->slug?>"><?=$question_model->name?></a></li>
                <li class="ib current-page"><a href="">技巧</a></li>
            </ul>
        </div>
    </div><!-- End container -->
</div><!-- End Inner Page Head -->

<div class="clearfix"></div>

<article class="post single fadeInDown-animation">
    <div class="container">
        <div class="row">
            <div class="col-md-4 sidebar">
                <div class="search">
                    <form action="" id="search">
                        <input type="search" id="search" class="search-input" placeholder="在这里搜索…">
                        <input type="submit" id="submit" class="submit-btn ln-tr fr" value="&#xf002;">
                    </form><!-- End Search form -->
                </div><!-- End Search bar -->
                <div class="sidebar-widget cats">
                    <span class="widget-icon"><i class="fa fa-folder"></i></span>
                    <h5 class="sidebar-widget-title ib">题型</h5>
                    <ul class="clearfix">
                        <?php wp_list_categories(array('taxonomy' => 'question_model', 'depth' => 2, 'title_li' => false, 'hide_empty' => false, 'orderby' => 'ID')); ?>
                    </ul>
                </div><!-- End Categories Widget -->
            </div><!-- End Sidebar - LEFT -->
            <div class="col-md-8 main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="featured-image">
                            <?php the_post_thumbnail('large', array('class' => 'img-responsive')); ?>
                        </div><!-- End featured image -->
                        <div class="entry clearfix">
                            <h3 class="single-title fl">
                                <span class="post-type-icon"><i class="fa fa-comment"></i></span>
                                <a href="#" class="ln-tr"><?php the_title(); ?></a>
                            </h3><!-- End Title -->
                            <div class="meta fr">
                                <div class="date ib">
                                    <span class="icon"><i class="fa fa-clock-o"></i></span>
                                    <span class="text"><?php the_date(); ?></span>
                                </div><!-- date icon -->
                                <!--<div class="author ib">
                                    <span class="icon"><i class="fa fa-user"></i></span>
                                    <span class="text">By : <a class="ln-tr" href="#">Begha</a></span>
                                </div>--><!-- author icon -->
                                <!--<div class="comments ib">
                                    <span class="icon"><i class="fa fa-comments"></i></span>
                                    <span class="text">Comments : <a class="ln-tr" href="#">22</a></span>
                                </div>--><!-- comments icon -->
                            </div><!-- End Meta -->
                            <div class="clearfix"></div>
                            <div class="content">
                                <?php the_content(); ?>
                            </div>
                            <!--<div class="share-post clearfix">
                                <p class="text fl">Share This Article If You Liked It :)</p>
                                <div class="icons fr">
                                    <ul class="clearfix">
                                        <li><a href="#" class="fb-icon ln-tr"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#" class="tw-icon ln-tr"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#" class="gp-icon ln-tr"><i class="fa fa-google-plus"></i></a></li>
                                        <li><a href="#" class="in-icon ln-tr"><i class="fa fa-linkedin"></i></a></li>
                                    </ul>
                                </div>
                            </div>-->
                        </div><!-- End Entry -->
                    </div><!-- End col-md-12 -->
                </div><!-- End main content row -->
            </div><!-- End Main Content - RIGHT -->
        </div><!-- End main row -->
    </div><!-- End container -->
</article><!-- End Single Article -->

<?php get_footer(); ?>
