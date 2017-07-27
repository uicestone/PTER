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
            <div class="col-md-12 main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="entry clearfix">
                            <h3 class="single-title fl">
                                <span class="post-type-icon"><i class="fa fa-comment"></i></span>
                                <a href="<?php the_permalink(); ?>" class="ln-tr"><?php the_title(); ?></a>
                            </h3><!-- End Title -->
                            <div class="meta fr">
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
