<?php
header('HTTP/1.0 404 Not Found');
get_header(); ?>

<section class="error-page full-page">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="not-found">
                    <span class="num">404</span>
                    <span class="text">页面不存在</span>
                </div><!-- end 404 circle -->
                <div class="error-message">抱歉，您访问的内容不存在</div><!-- end error msg -->
                <div class="share-icons clearfix">
                    <p class="text fl">也许您输错了网址，或内容的已经被移动、删除</p>
                    <div class="icons fr">
                        <ul class="clearfix">
                            <li><a href="#" class="fb-icon ln-tr"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#" class="tw-icon ln-tr"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#" class="gp-icon ln-tr"><i class="fa fa-google-plus"></i></a></li>
                            <li><a href="#" class="in-icon ln-tr"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div><!-- end share page -->
            </div>
        </div>
    </div><!-- end container -->
</section><!-- end 404 section -->

<?php get_footer(); ?>
