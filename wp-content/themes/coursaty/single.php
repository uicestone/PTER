<?php get_header(); the_post(); ?>

<div class="inner-head">
    <div class="container">
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <p class="description">
            <?php the_subtitle(); ?>
        </p>
    </div><!-- End container -->
</div><!-- End Inner Page Head -->

<div class="clearfix"></div>

<article class="post single fadeInDown-animation">
    <div class="container">
        <div class="row">
            <div class="col-md-3 sidebar">
                <div class="search">
                    <form action="<?=site_url()?>" id="search">
                        <input type="search" id="search" class="search-input" name="s" placeholder="在这里搜索...">
                        <input type="submit" id="submit" class="submit-btn ln-tr fr" value="&#xf002;">
                    </form><!-- End Search form -->
                </div><!-- End Search bar -->
                <?php if (has_post_thumbnail()): ?>
                <div class="featured-image">
					<?php the_post_thumbnail('post-thumbnail'); ?>
                </div><!-- End featured image -->
                <?php endif; ?>
                <div class="sidebar-widget last-posts">
                    <span class="widget-icon"><i class="fa fa-comments"></i></span>
                    <h5 class="sidebar-widget-title ib">最新文章</h5>
                    <ul class="clearfix">
                        <?php foreach (get_posts() as $latest_post): ?>
                        <li>
                            <a href="<?=get_the_permalink($latest_post)?>" class="ln-tr"><?=get_the_title($latest_post)?></a>
                            <span class="date"><?=get_the_date('', $latest_post)?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div><!-- End Latest Posts Widget -->
            </div><!-- End Sidebar - LEFT -->
            <div class="col-md-9 main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="entry clearfix">
                            <h3 class="single-title fl">
                                <span class="post-type-icon"><i class="fa fa-comment"></i></span>
                                <a href="<?php the_permalink(); ?>" class="ln-tr"><?php the_title(); ?></a>
                            </h3><!-- End Title -->
                            <div class="meta fr">
                                <div class="date ib">
                                    <span class="icon"><i class="fa fa-clock-o"></i></span>
                                    <span class="text"><?php the_date(); ?></span>
                                </div><!-- date icon -->
                            </div><!-- End Meta -->
                            <div class="clearfix"></div>
                            <div class="content">
                                <?php the_content(); ?>
                            </div>
                        </div><!-- End Entry -->
                    </div><!-- End col-md-12 -->
                </div><!-- End main content row -->
            </div><!-- End Main Content - RIGHT -->
        </div><!-- End main row -->
    </div><!-- End container -->
</article><!-- End Single Article -->

<?php get_footer(); ?>
