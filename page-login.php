<?php

if(isset($_POST['submit'])){
	$user = wp_authenticate($_POST['username'], $_POST['password']);

	if(is_a($user, 'WP_Error')){
	    echo '<meta charset="utf-8">';
	    echo array_values($user->errors)[0][0];
	    echo '<br><br> <b>客服微信</b>：<br><img width="150px" src="' . get_template_directory_uri() . '/assets/img/qrcode_cs.jpg">';
		exit;
	}

	// 检查并记录当日IP数
    $user_ips_today = get_user_meta($user->ID, 'ip_' . current_time('Y-W'));
    $user_ip = get_the_user_ip();

    if (!in_array(get_the_user_ip(), $user_ips_today)) {
		$user_ips_today[] = $user_ip;
		add_user_meta($user->ID, 'ip_' . current_time('Y-W'), $user_ip);
    }

    if (count($user_ips_today) > 2) {
        exit('账号状态异常，如果您使用的是朋友的账号，或许可以考虑：<br><a href="' . site_url_ml() . '/register/">注册自己的账号</a>，输入朋友的<b>邀请码</b>优惠购买！<br>当前优惠折扣：<b>' . get_post_meta(get_page_by_path('pricing-table')->ID, 'intro_discount', true) . '%OFF</b>');
    }

	wp_set_auth_cookie($user->ID, isset($_POST['remember']));
	wp_set_current_user($user->ID);

	if ($_GET['intend']) {
	    header('Location: ' . $_GET['intend']); exit;
    }
    else {
		header('Location: ' . site_url_ml('profile')); exit;
    }
}

if(isset($_GET['logout'])){
	wp_logout();
	header('Location: ' . site_url_ml());
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
                <li class="ib"><a href="<?=site_url_ml()?>"><?=__('首页', 'bingo')?></a></li>
                <li class="ib current-page"><a href="<?php the_permalink(); ?>"><?=__('登录', 'bingo')?></a></li>
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
                        <span class="text"><?=__('登录信息', 'bingo')?></span>
                    </div><!-- End Title -->
                    <form method="post" id="login-form">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="input">
                                    <input type="text" id="login_username" name="username" class="username-input" placeholder="<?=__('用户名', 'bingo')?>">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="input">
                                    <input type="password" id="login_password" name="password" class="password-input" placeholder="<?=__('密码', 'bingo')?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input clearfix">
                                    <input type="submit" id="login_submit" name="submit" class="submit-input grad-btn ln-tr" value="<?=__('登录', 'bingo')?>">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 clearfix">
                                <div class="custom-checkbox fl">
                                    <input type="checkbox" id="login_remember" name="remember" class="checkbox-input" checked>
                                    <label for="login_remember"><?=__('保持登录', 'bingo')?></label>
                                </div>
                            </div><!-- end remember -->
                            <div class="col-md-6 col-sm-6 clearfix">
                                <div class="forgot fr">
                                    <a href="<?=pll_home_url()?>register/<?=(isset($_GET['intend']) ? '?intend=' . $_GET['intend'] : '')?>" class="new-user"><?=__('注册账号', 'bingo')?></a>
                                    /
                                    <a href="<?=wp_lostpassword_url(site_url_ml($_GET['intend']))?>" class="reset"><?=__('忘记密码？', 'bingo')?></a>
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
