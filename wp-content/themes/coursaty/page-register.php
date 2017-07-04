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
                <li class="ib current-page"><a href="<?php the_permalink(); ?>">注册</a></li>
            </ul>
        </div>
    </div><!-- End container -->
</div><!-- End Inner Page Head -->

<div class="clearfix"></div>

<section class="login-page fadeInDown-animation">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="login-form register">
                    <div class="login-title">
                        <span class="icon"><i class="fa fa-group"></i></span>
                        <span class="text">注册</span>
                    </div><!-- End Title -->
                    <form method="post" action="/" id="register-form">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="input">
                                    <input type="text" id="reg_username" class="username-input" placeholder="用户名">
                                </div>
                            </div><!-- end username -->
                            <div class="col-md-6 col-sm-6">
                                <div class="input">
                                    <input type="email" id="reg_email" class="email-input" placeholder="电子邮箱">
                                </div>
                            </div><!-- end email -->
                            <div class="col-md-6 col-sm-6">
                                <div class="input">
                                    <input type="password" id="reg_password" class="password-input" placeholder="密码">
                                </div>
                            </div><!-- end password -->
                            <div class="col-md-6 col-sm-6">
                                <div class="input">
                                    <input type="password" id="reg_confirm-password" class="confirm-password-input" placeholder="确认密码">
                                </div>
                            </div><!-- end confirm password -->
                            <div class="col-md-12">
                                <div class="input clearfix">
                                    <input type="submit" id="reg_submit" class="submit-input grad-btn ln-tr" value="注册">
                                </div>
                            </div><!-- end submit -->
                        </div><!-- end row -->
                    </form><!-- End form -->
                </div><!-- end login form -->
            </div><!-- end col-md-8/offset -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- End Register Page -->

<?php get_footer(); ?>
