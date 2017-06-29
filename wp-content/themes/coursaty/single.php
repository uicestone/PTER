<?php get_header(); ?>

<div class="inner-head">
    <div class="container">
        <h1 class="entry-title">Blog</h1>
        <p class="description">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem quam, adipiscing condimentum tristique vel, eleifend sed turpis. Pellentesque cursus arcu id magna euismod in elementum purus molestie.
        </p>
        <div class="breadcrumb">
            <ul class="clearfix">
                <li class="ib"><a href="">Home</a></li>
                <li class="ib"><a href="">Blog</a></li>
                <li class="ib current-page"><a href="">Single Post with Left Sidebar</a></li>
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
                        <input type="search" id="search" class="search-input" placeholder="Search Here ...">
                        <input type="submit" id="submit" class="submit-btn ln-tr fr" value="&#xf002;">
                    </form><!-- End Search form -->
                </div><!-- End Search bar -->
                <div class="sidebar-widget cats">
                    <span class="widget-icon"><i class="fa fa-folder"></i></span>
                    <h5 class="sidebar-widget-title ib">Categories</h5>
                    <ul class="clearfix">
                        <li><a href="#" class="ln-tr">Self Development Courses</a></li>
                        <li><a href="#" class="ln-tr">Adminsitrative Courses</a></li>
                        <li><a href="#" class="ln-tr">Social Courses</a></li>
                        <li><a href="#" class="ln-tr">Computer & It Courses</a></li>
                        <li><a href="#" class="ln-tr">Language Courses</a></li>
                        <li><a href="#" class="ln-tr">Health & Medical</a></li>
                        <li><a href="#" class="ln-tr">Policy & Law Courses</a></li>
                        <li><a href="#" class="ln-tr">Other Courses</a></li>
                    </ul>
                </div><!-- End Categories Widget -->
                <div class="sidebar-widget last-posts">
                    <span class="widget-icon"><i class="fa fa-comments"></i></span>
                    <h5 class="sidebar-widget-title ib">Latest Posts</h5>
                    <ul class="clearfix">
                        <li>
                            <a href="#" class="ln-tr">Blog Tiltle Shall Be Here !</a>
                            <span class="date">Dec 26, 2015</span>
                        </li>
                        <li>
                            <a href="#" class="ln-tr">Blog Tiltle Shall Be Here !</a>
                            <span class="date">Dec 26, 2015</span>
                        </li>
                        <li>
                            <a href="#" class="ln-tr">Blog Tiltle Shall Be Here !</a>
                            <span class="date">Dec 26, 2015</span>
                        </li>
                    </ul>
                </div><!-- End Latest Posts Widget -->
                <div class="sidebar-widget tabs-widget">
                    <ul class="tabs">
                        <li class="tab-item active" data-tab="tab-1">Popular</li>
                        <li class="tab-item" data-tab="tab-2">Recent</li>
                        <li class="tab-item" data-tab="tab-3">Comments</li>
                    </ul>
                    <div id="tab-1" class="tab-content active">
                        <div class="tab-posts">
                            <div class="post-item clearfix">
                                <div class="post-image fl"><a href="#"><img src="assets/img/content/sidebar-thumb-92x92.jpg" alt=""></a></div>
                                <a href="#" class="post-title ln-tr">Blog title shall be here</a>
                                <p class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                <div class="meta clearfix">
                                    <span class="date">Dec 26, 2014</span>
                                    <a href="#" class="read-more ln-tr fr"><i class="fa fa-plus"></i></a>
                                </div>
                            </div><!-- End Single Post Item -->
                            <div class="post-item clearfix">
                                <div class="post-image fl"><a href="#"><img src="assets/img/content/sidebar-thumb-92x92.jpg" alt=""></a></div>
                                <a href="#" class="post-title ln-tr">Blog title shall be here</a>
                                <p class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                <div class="meta clearfix">
                                    <span class="date">Dec 26, 2014</span>
                                    <a href="#" class="read-more ln-tr fr"><i class="fa fa-plus"></i></a>
                                </div>
                            </div><!-- End Single Post Item -->
                        </div><!-- End Popular Posts -->
                    </div><!-- End 1st Tab Content -->
                    <div id="tab-2" class="tab-content">
                        <div class="tab-posts">
                            <div class="post-item clearfix">
                                <div class="post-image fl"><a href="#"><img src="assets/img/content/sidebar-thumb-92x92.jpg" alt=""></a></div>
                                <a href="#" class="post-title ln-tr">Recent post title!</a>
                                <p class="description">Consectetur adipiscing elit, Lorem ipsum dolor sit amet.</p>
                                <div class="meta clearfix">
                                    <span class="date">Dec 26, 2015</span>
                                    <a href="#" class="read-more ln-tr fr"><i class="fa fa-plus"></i></a>
                                </div>
                            </div><!-- End Single Post Items -->
                            <div class="post-item clearfix">
                                <div class="post-image fl"><a href="#"><img src="assets/img/content/sidebar-thumb-92x92.jpg" alt=""></a></div>
                                <a href="#" class="post-title ln-tr">Recent post title!</a>
                                <p class="description">Consectetur adipiscing elit, Lorem ipsum dolor sit amet.</p>
                                <div class="meta clearfix">
                                    <span class="date">Dec 26, 2015</span>
                                    <a href="#" class="read-more ln-tr fr"><i class="fa fa-plus"></i></a>
                                </div>
                            </div><!-- End Single Post Items -->
                        </div><!-- End Recent Posts -->
                    </div><!-- End 2nd Tab Content -->
                    <div id="tab-3" class="tab-content">
                        Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                    </div><!-- End 3rd Tab Content -->
                </div><!-- End Tabs Widget -->
                <div class="sidebar-widget sidebar-twitter-widget">
                    <h5 class="sidebar-widget-title">Latest from Twitter</h5>
                    <div id="sidebar-tweets" class="flexslider">
                        <ul class="slides">
                            <li>
                                <div class="status">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation quat.</p>
                                </div>
                                <div class="date">2 mins ago</div>
                            </li><!-- End tweet item -->
                            <li>
                                <div class="status">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.</p>
                                </div>
                                <div class="date">8 mins ago</div>
                            </li><!-- End tweet item -->
                        </ul><!-- End li items -->
                    </div><!-- end tweets slider -->
                </div><!-- End twitter widget -->
            </div><!-- End Sidebar - LEFT -->
            <div class="col-md-8 main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="featured-image">
                            <img src="assets/img/content/single-post-img-770x350.jpg" alt="" class="img-responsive">
                        </div><!-- End featured image -->
                        <div class="entry clearfix">
                            <h3 class="single-title fl">
                                <span class="post-type-icon"><i class="fa fa-comment"></i></span>
                                <a href="#" class="ln-tr">Blog title shall be here</a>
                            </h3><!-- End Title -->
                            <div class="meta fr">
                                <div class="date ib">
                                    <span class="icon"><i class="fa fa-clock-o"></i></span>
                                    <span class="text">Dec 26, 2014</span>
                                </div><!-- date icon -->
                                <div class="author ib">
                                    <span class="icon"><i class="fa fa-user"></i></span>
                                    <span class="text">By : <a class="ln-tr" href="#">Begha</a></span>
                                </div><!-- author icon -->
                                <div class="comments ib">
                                    <span class="icon"><i class="fa fa-comments"></i></span>
                                    <span class="text">Comments : <a class="ln-tr" href="#">22</a></span>
                                </div><!-- comments icon -->
                            </div><!-- End Meta -->
                            <div class="clearfix"></div>
                            <div class="content">
                                <p>
                                    Perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto. Beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur.Aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur.Perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto. Beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur.
                                </p>
                                <p>
                                    Perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto. Beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur.Aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur.
                                </p>
                                <p>
                                    Perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto. Beatae vitae dicta sunt explicabo. Perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto. Beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur.
                                </p>
                                <p>
                                    Nemo enim ipsam voluptatem quia voluptas sit aspernatur.Aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur.Perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto. Beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur.
                                </p>
                            </div>
                            <div class="share-post clearfix">
                                <p class="text fl">Share This Article If You Liked It :)</p>
                                <div class="icons fr">
                                    <ul class="clearfix">
                                        <li><a href="#" class="fb-icon ln-tr"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#" class="tw-icon ln-tr"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#" class="gp-icon ln-tr"><i class="fa fa-google-plus"></i></a></li>
                                        <li><a href="#" class="in-icon ln-tr"><i class="fa fa-linkedin"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div><!-- End Entry -->
                        <ol class="comments-list">
                            <li class="comment haschild">
                                <div class="comment-body clearfix">
                                    <div class="avatar fl">
                                        <img src="assets/img/content/instructor-avatar-6-72x72.jpg" alt="">
                                    </div><!-- end avatar -->
                                    <div class="content">
                                        <div class="author clearfix">
                                            <div class="meta fl">
                                                <a href="#" class="name">Ibrahim</a>
                                                <span class="date">Dec 26, 2013 - 10:07 pm</span>
                                            </div>
                                            <div class="reply fr">
                                                <a href="#" class="ln-tr grad-btn">Reply</a>
                                            </div>
                                        </div><!-- end author details -->
                                        <div class="text">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
                                        </div><!-- end text -->
                                    </div><!-- end content -->
                                </div><!-- End main comment -->
                                <ul class="children">
                                    <li class="comment">
                                        <div class="comment-body clearfix">
                                            <div class="avatar fl">
                                                <img src="assets/img/content/instructor-avatar-2-72x72.jpg" alt="">
                                            </div><!-- end avatar -->
                                            <div class="content">
                                                <div class="author clearfix">
                                                    <div class="meta fl">
                                                        <a href="#" class="name">Begha</a>
                                                        <span class="date">Dec 26, 2013 - 10:17 pm</span>
                                                    </div>
                                                    <div class="reply fr">
                                                        <a href="#" class="ln-tr grad-btn">Reply</a>
                                                    </div>
                                                </div><!-- end author details -->
                                                <div class="text">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
                                                </div><!-- end text -->
                                            </div><!-- end content -->
                                        </div><!-- End main comment -->
                                    </li><!-- End child comment item/tree -->
                                </ul><!-- End child comments -->
                            </li><!-- End Comment item/tree -->
                            <li class="comment">
                                <div class="comment-body clearfix">
                                    <div class="avatar fl">
                                        <img src="assets/img/content/instructor-avatar-3-72x72.jpg" alt="">
                                    </div><!-- end avatar -->
                                    <div class="content">
                                        <div class="author clearfix">
                                            <div class="meta fl">
                                                <a href="#" class="name">Ibrahim</a>
                                                <span class="date">Dec 28, 2013 - 10:17 pm</span>
                                            </div>
                                            <div class="reply fr">
                                                <a href="#" class="ln-tr grad-btn">Reply</a>
                                            </div>
                                        </div><!-- end author details -->
                                        <div class="text">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
                                        </div><!-- end text -->
                                    </div><!-- end content -->
                                </div><!-- End main comment -->
                            </li><!-- End 2nd comment item/tree -->
                        </ol><!-- End comments list -->
                        <div class="comment-form">
                            <div class="addcomment-title">
                                <span class="icon"><i class="fa fa-comments-o"></i></span>
                                <span class="text">Add Your Comment</span>
                            </div><!-- End Title -->
                            <form method="post" action="/" id="comment-form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input">
                                            <input type="text" id="name" class="name-input" placeholder="Your Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input">
                                            <input type="email" id="email" class="email-input" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input">
                                            <textarea name="comment-area" id="comment-area" placeholder="Comment"></textarea>
                                            <input type="submit" id="comment-submit" class="submit-input grad-btn ln-tr" value="Send">
                                        </div>
                                    </div>
                                </div>
                            </form><!-- End form -->
                        </div><!-- End comment form -->
                    </div><!-- End col-md-12 -->
                </div><!-- End main content row -->
            </div><!-- End Main Content - RIGHT -->
        </div><!-- End main row -->
    </div><!-- End container -->
</article><!-- End Single Article -->

<?php get_footer(); ?>
