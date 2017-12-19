<?php

require_once(ABSPATH . 'wp-admin/includes/user.php');

if(isset($_POST['submit'])){

    if ($_POST['password'] !== $_POST['confirm_password']) {
        exit('两次输入密码不一致，请返回修改');
    }

    if ($_POST['agree'] !== 'yes') {
		exit('请同意用户协议');
    }

	$user_id = wp_insert_user(array(
		'user_pass' => $_POST['password'],
		'user_login' => $_POST['username'],
		'display_name' => $_POST['display_name'],
		'user_email' => $_POST['email'],
		'user_registered' => date('Y-m-d H:i:s'),
		'show_admin_bar_front' => false
	));

	if(is_a($user_id, 'WP_Error')){
		exit(array_values($user_id->errors)[0][0]);
	}

	if (!get_user_by('ID', $user_id)->user_email) {
		wp_delete_user($user_id);
		exit('Invalid email address: ' . $_POST['email'] . '.');
	}

	if ($_POST['mobile']) {
	    add_user_meta($user_id, 'mobile', $_POST['mobile']);
    }

	if ($_POST['invitation_code']) {
	    $invited_by_users = get_users(array('meta_key' => 'invitation_code', 'meta_compare' => 'LIKE', 'meta_value' => $_POST['invitation_code']));
	    if (count($invited_by_users) !== 1) {
	        exit('无法确定你的邀请人，请联系客服稍后绑定邀请人');
        }
		add_user_meta($user_id, 'invited_by_user', $invited_by_users[0]->ID);
    }

	wp_set_auth_cookie($user_id, true);
	wp_set_current_user($user_id);

	send_template_mail('welcome-email', wp_get_current_user()->user_email);

	$wx = new WeixinAPI();

	header('Location: ' . $wx->generate_oauth_url(site_url($_GET['intend'] ?: 'profile'))); exit;
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
                    <form method="post" id="register-form">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="input">
                                    <input type="text" id="reg_username" name="username" class="username-input" placeholder="用户名*" required>
                                </div>
                            </div><!-- end username -->
                            <div class="col-md-6 col-sm-6">
                                <div class="input">
                                    <input type="text" id="reg_mobile" name="mobile" class="mobile-input" placeholder="手机*" required>
                                </div>
                            </div><!-- end email -->
                            <div class="col-md-6 col-sm-6">
                                <div class="input">
                                    <input type="email" id="reg_email" name="email" class="email-input" placeholder="电子邮箱*" required>
                                </div>
                            </div><!-- end email -->
                            <div class="col-md-6 col-sm-6">
                                <div class="input">
                                    <input type="password" id="reg_password" name="password" class="password-input" placeholder="密码*" required>
                                </div>
                            </div><!-- end password -->
                            <div class="col-md-6 col-sm-6">
                                <div class="input">
                                    <input type="password" id="reg_confirm-password" name="confirm_password" class="confirm-password-input" placeholder="确认密码*" required>
                                </div>
                            </div><!-- end confirm password -->
                            <div class="col-md-6 col-sm-6">
                                <div class="input">
                                    <input type="text" id="reg_username" name="display_name" class="display_name-input" placeholder="显示名">
                                </div>
                            </div><!-- end username -->
                            <div class="col-md-6 col-sm-6">
                                <div class="input">
                                    <input type="text" id="reg_invitation_code" name="invitation_code" class="invitation_code-input" placeholder="邀请码（可选，也可稍后绑定）">
                                </div>
                            </div><!-- end username -->
                            <div class="col-md-12">
                                <div class="input clearfix agree">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" id="reg_agree" name="agree" value="yes" class="checkbox-input">
                                        <label for="reg_agree">同意 <a href="<?=site_url()?>/agreement/" target="_blank">用户协议</a></label>
                                    </div>
                                </div>
                            </div><!-- end submit -->
                            <div class="col-md-12">
                                <div class="input clearfix">
                                    <input type="submit" id="reg_submit" name="submit" class="submit-input grad-btn ln-tr" value="注册并绑定微信">
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
