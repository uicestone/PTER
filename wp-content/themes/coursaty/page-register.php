<?php

if(isset($_POST['submit'])){
	$user_id = wp_insert_user(array(
		'user_pass' => $_POST['password'],
		'user_login' => $_POST['username'],
		'user_email' => $_POST['email'],
		'user_registered' => date('Y-m-d H:i:s'),
		'show_admin_bar_front' => false
	));

	if(is_a($user_id, 'WP_Error')){
		exit(array_values($user_id->errors)[0][0]);
	}
	update_user_meta($user_id, 'mobile', $_POST['mobile']);
	wp_set_auth_cookie($user_id, true);
	wp_set_current_user($user_id);

	if ($_GET['intend']) {
		header('Location: ' . $_GET['intend']); exit;
	}
	else {
		header('Location: ' . site_url()); exit;
	}
}

get_header(); the_post(); ?>

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
                                    <input type="text" id="reg_username" name="username" class="username-input" placeholder="用户名">
                                </div>
                            </div><!-- end username -->
                            <div class="col-md-6 col-sm-6">
                                <div class="input">
                                    <input type="email" id="reg_email" name="email" class="email-input" placeholder="电子邮箱">
                                </div>
                            </div><!-- end email -->
                            <div class="col-md-6 col-sm-6">
                                <div class="input">
                                    <input type="password" id="reg_password" name="password" class="password-input" placeholder="密码">
                                </div>
                            </div><!-- end password -->
                            <div class="col-md-6 col-sm-6">
                                <div class="input">
                                    <input type="password" id="reg_confirm-password" name="confirm_password" class="confirm-password-input" placeholder="确认密码">
                                </div>
                            </div><!-- end confirm password -->
                            <div class="col-md-12">
                                <div class="input clearfix">
                                    <input type="submit" id="reg_submit" name="submit" class="submit-input grad-btn ln-tr" value="注册">
                                </div>
                            </div><!-- end submit -->
                            <div class="col-md-6 col-sm-6 col-sm-offset-6 clearfix">
                                <div class="forgot fr">
                                    <a href="<?=site_url()?>/login/<?=(isset($_GET['intend']) ? '?intend=' . $_GET['intend'] : '')?>" class="new-user">已有账号？马上登录</a>
                                </div>
                            </div><!-- end forgot password -->
                        </div><!-- end row -->
                    </form><!-- End form -->
                </div><!-- end login form -->
            </div><!-- end col-md-8/offset -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- End Register Page -->

<?php get_footer(); ?>
