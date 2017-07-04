<?php get_header(); the_post(); ?>

<div class="inner-head">
    <div class="container">
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <p class="description">
            <?php the_subtitle(); ?>
        </p>
        <div class="breadcrumb">
            <ul class="clearfix">
                <li class="ib"><a href="<?=site_url()?>">首页</a></li>
                <li class="ib current-page"><a href="<?php the_permalink(); ?>">登录</a></li>
            </ul>
        </div>
    </div><!-- End container -->
</div><!-- End Inner Page Head -->

<div class="clearfix"></div>

<section class="login-page fadeInDown-animation">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="login-form">
                    <div class="login-title">
                        <span class="icon"><i class="fa fa-group"></i></span>
                        <span class="text">登录信息</span>
                    </div><!-- End Title -->
                    <form method="post" action="/" id="login-form">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="input">
                                    <input type="text" id="login_username" class="username-input" placeholder="用户名">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="input">
                                    <input type="password" id="login_password" class="password-input" placeholder="密码">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input clearfix">
                                    <input type="submit" id="login_submit" class="submit-input grad-btn ln-tr" value="登录">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 clearfix">
                                <div class="custom-checkbox fl">
                                    <input type="checkbox" id="login_remember" class="checkbox-input" checked>
                                    <label for="login_remember">保持登录</label>
                                </div>
                            </div><!-- end remember -->
                            <div class="col-md-6 col-sm-6 clearfix">
                                <div class="forgot fr">
                                    <a href="<?=site_url()?>/register/" class="new-user">注册账号</a> / <a href="#" class="reset">忘记密码？</a>
                                </div>
                            </div><!-- end forgot password -->
                        </div><!-- end row -->
                    </form><!-- End form -->
                </div><!-- end login form -->
            </div><!-- end col-md-8/offset -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- End Login Page -->

<?php get_footer(); ?>
