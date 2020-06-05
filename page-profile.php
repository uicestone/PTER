<?php

redirect_login();
$user = wp_get_current_user();

if (isset($_POST['submit'])) {
	if ($_POST['email']) {
		$user->user_email = $_POST['email'];
	}
	if ($_POST['display_name']) {
		$user->display_name = $_POST['display_name'];
	}
	wp_insert_user($user);
	if ($_POST['password'] !== '') {
		wp_set_password($_POST['password'], $user->ID);
		redirect_login(true);
	}
	if ($_POST['mobile']) {
	    update_user_meta($user->ID, 'mobile', $_POST['mobile']);
    }
	if ($_POST['scoop_email']) {
		update_user_meta($user->ID, 'scoop_email', $_POST['scoop_email']);
	} else {
		delete_user_meta($user->ID, 'scoop_email');
	}

	if ($_POST['invitation_code']) {
		$invited_by_users = get_users(array('meta_key' => 'invitation_code', 'meta_compare' => 'LIKE', 'meta_value' => $_POST['invitation_code']));
		if (count($invited_by_users) !== 1) {
			exit(__('无法确定你的邀请人，请联系客服稍后绑定邀请人', 'bingo'));
		}
		if ($invited_by_users[0]->ID === $user->ID) {
		    exit(__('不能邀请自己', 'bingo'));
        }
		add_user_meta($user->ID, 'invited_by_user', $invited_by_users[0]->ID);
	}

	header('Location: ' . $_SERVER['HTTP_REFERER'], true, 303); exit;
}

foreach (array('reading', 'writing') as $service) {
	if (isset($_POST['activate_' . $service])) {
		$service_inactivated = get_user_meta($user->ID, 'service_' . $service . '_inactivated', true);
		$service_valid_before =  get_user_meta($user->ID, 'service_' . $service . '_valid_before', true);

		if ($service_valid_before >= time()) {
			exit(__('已激活，不要重复激活', 'bingo'));
		}

		if ($service_inactivated < 0) {
			exit(__('激活失败，没有可激活的额度', 'bingo'));
		}

		update_user_meta($user->ID, 'service_' . $service . '_inactivated', --$service_inactivated);
		update_user_meta($user->ID, 'service_' . $service . '_valid_before', time() + 86400 * 2 - 1);
		$user->add_cap('view_' . $service);
		header('Location: ' . site_url_ml() . $_SERVER['REQUEST_URI']); exit;
	}
}

$wx = new WeixinAPI();

$invitation_code = get_user_meta($user->ID, 'invitation_code', true);
if (!$invitation_code) {
	$invitation_code = sha1('Bingo' . $user->ID);
	add_user_meta($user->ID, 'invitation_code', $invitation_code);
}
$invitation_code = substr($invitation_code, 0, 6);

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
				<li class="ib current-page"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
			</ul>
		</div>
	</div><!-- End container -->
</div><!-- End Inner Page Head -->

<?php get_template_part('content-top-copyright'); ?>

<section class="login-page fadeInDown-animation">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
                <div class="alert alert-info">
                    <h3 class="course-title"><?=__('优惠活动一 （未付费用户）', 'bingo')?></h3>
                    <ol>
						<li><?=sprintf(__('邀请好友通过%s或您的优惠码%s，登录并注册试用网站。', 'bingo'),
								'<a href="#" class="copy-invitation-link" data-clipboard-text="' . site_url_ml('register?invitation_code=' . $invitation_code) . '">' . __('您的专属链接', 'bingo') . '</a>',
								$invitation_code
							)?></li>
                        <li><?=__('好友注册成功, 您便可增多2天宾果课程试用', 'bingo')?></li>
                    </ol>
                </div>
                <div class="alert alert-info">
                    <h3 class="course-title"><?=__('优惠活动二 （已付费用户）', 'bingo')?></h3>
                    <ol>
						<li><?=sprintf(__('邀请好友通过%s或您的优惠码%s订阅学习，TA可获得<strong>八五折</strong>优惠。', 'bingo'),
								'<a href="#" class="copy-invitation-link" data-clipboard-text="' . site_url_ml('register?invitation_code=' . $invitation_code) . '">' . __('您的专属链接', 'bingo') . '</a>',
								$invitation_code
							)?></li>
                        <li><?=__('好友购买成功后，您会<strong>立即获得$4返现</strong>，现金会自动返回到您当时支付课程时使用的账户', 'bingo')?></li>
                    </ol>
                </div>
				<div class="login-form register">
					<div class="login-title">
						<span class="icon"><i class="fa fa-group"></i></span>
						<span class="text"><?=__('基本信息', 'bingo')?></span>
					</div><!-- End Title -->
					<form method="post" id="register-form">
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="static">
									<label><?=__('用户名：', 'bingo')?></label>
									<?=$user->user_login?>
								</div>
							</div><!-- end username -->
							<div class="col-md-6 col-sm-6">
								<div class="input-with-label">
									<label><?=__('显示名：', 'bingo')?></label>
									<input type="text" id="reg_name" name="display_name" class="name-input" placeholder="对外显示的我的名称" value="<?=$user->display_name?>">
								</div>
							</div><!-- end display_name -->
                            <div class="col-md-6 col-sm-6">
                                <div class="input-with-label">
                                    <label><?=__('手机：', 'bingo')?></label>
                                    <input type="text" id="reg_mobile" name="mobile" class="mobile-input" placeholder="<?=is_cn_ip() ? '+86 13612345678' : '+61 412345678'?>" value="<?=get_user_meta($user->ID, 'mobile', true)?>">
                                </div>
                            </div><!-- end email -->
							<div class="col-md-6 col-sm-6">
								<div class="input-with-label">
									<label><?=__('电子邮箱：', 'bingo')?></label>
									<input type="email" id="reg_email" name="email" class="email-input" placeholder="my.name@domain.com" value="<?=$user->user_email?>">
								</div>
							</div><!-- end email -->
							<div class="col-md-6 col-sm-6">
								<div class="input">
									<input type="password" id="reg_password" name="password" class="password-input" placeholder="重置密码">
								</div>
							</div><!-- end password -->
                            <?php if ($invited_by_user = get_user_by('ID', get_user_meta($user->ID, 'invited_by_user', true))): ?>
                            <div class="col-md-6 col-sm-6">
                                <div class="static">
                                    <label><?=__('邀请人：', 'bingo')?></label>
                                    <?=$invited_by_user->display_name?>
                                </div>
                            </div><!-- end username -->
                            <?php else: ?>
                            <div class="col-md-6 col-sm-6">
                                <div class="input">
                                    <input type="text" id="reg_invitation_code" name="invitation_code" class="invitation_code-input" placeholder="邀请码，填写后你和邀请人都将获得奖励">
                                </div>
                            </div><!-- end invitation_code -->
                            <?php endif; ?>
							<div class="col-md-6 col-sm-6">
								<div class="static">
									<label>
										<input type="checkbox" name="scoop_email" value="no"<?php if('no'===get_user_meta($user->ID, 'scoop_email', true)){ ?> checked<?php } ?>>
										<?=__('禁止每周邮件推送', 'bingo')?>
									</label>
								</div>
							</div>
                            <?php global $is_cn_ip; if ($is_cn_ip): ?>
                            <div class="col-md-6 col-sm-6">
                                <div class="static">
                                    <label><?=__('中国大陆网络', 'bingo')?></label>
                                </div>
                            </div>
                            <?php endif; ?>
							<div class="col-md-12">
								<div class="input clearfix">
									<input type="submit" id="reg_submit" name="submit" value="<?=__('修改', 'bingo')?>" class="submit-input grad-btn ln-tr">
                                    <?php if (pll_current_language() === 'zh' && !get_user_meta($user->ID, 'wx_openid', true)): ?>
                                    <a href="<?=$wx->generate_oauth_url()?>" class="submit-input grad-btn ln-tr input-with-label" style="background:#00c44e"><?=__('绑定微信，立即获得3天课程试用', 'bingo')?></a>
                                    <?php endif; ?>
								</div>
							</div><!-- end submit -->
						</div><!-- end row -->
					</form><!-- End form -->
				</div><!-- end login form -->
				<div class="login-form register my-services">
					<div class="login-title">
						<span class="icon"><i class="fa fa-group"></i></span>
						<span class="text"><?=__('我订阅的产品', 'bingo')?></span>
                        <div class="ib fr">
                            <span><?=__('付款：', 'bingo')?>$<?=get_user_meta($user->ID, 'total_paid', true) ?: 0?></span>，
                            <span><?=__('奖励：', 'bingo')?>$<?=get_user_meta($user->ID, 'total_awarded', true) ?: 0?></span>，
                            <span><?=__('邀请码：', 'bingo')?><?=$invitation_code?></span>
                            <a href="#" class="copy-invitation-link" data-clipboard-text="<?=site_url_ml('register?invitation_code=' . $invitation_code)?>"><?=__('复制邀请链接', 'bingo')?></a>
                        </div>
					</div><!-- End Title -->
                    <div class="clearfix"></div>
					<div class="home-skills">
						<?php
                        $active_products = array();
                        foreach (array ('pte' => __('PTE', 'bingo'), 'ccl' => __('CCL', 'bingo')) as $product => $product_name):
                            $product_valid_before = get_user_meta($user->ID, 'product_' . $product . '_valid_before', true);
                            if ($product_valid_before && $product_valid_before >= time()): $active_products[] = $product; ?>
                        <div class="add-courses box base-pack additional-pack">
							<?php $percent = ($product_valid_before - time()) / (30 * 86400) * 100 ?>
							<a href="#" class="add-courses-title ln-tr"><?=$product_name?></a>
							<div class="skillbar clearfix" data-percent="<?=min($percent, 100)?>%">
								<div class="skillbar-title"><span><?=round($percent)?>%</span></div><div class="skillbar-bar" style="width:0"></div>
							</div>
                            <hr>
                            <div class="expires-at">
                                <?=__('剩余天数：', 'bingo')?><?=round(($product_valid_before - time()) / 86400, 1)?>
								<?php if ($product_valid_before - time() < 86400 * 10): ?>
                                <a href="<?=site_url_ml('pricing-table/')?>" class="active btn btn-sm ln-tr"><?=__('续费', 'bingo')?></a>
								<?php endif; ?>
                            </div>
						</div>
                        <?php endif; endforeach; ?>
					</div>
					<div class="row">
						<?php
                        foreach (array ('reading' => __('阅读拓展包', 'bingo'), 'writing' => __('写作拓展包', 'bingo')) as $service => $service_name):
                            $service_valid_before = get_user_meta($user->ID, 'service_' . $service . '_valid_before', true);
    						$service_inactivated = get_user_meta($user->ID, 'service_' . $service . '_inactivated', true);
						    if ($service_valid_before >= time() || $service_inactivated > 0): $active_services[] = $service; ?>
						<div class="col-md-6">
							<div class="add-courses box additional-pack">
								<div class="icon"><i class="fa fa-book"></i></div>
								<a href="#" class="add-courses-title ln-tr"><?=$service_name?></a>
								<p class="add-courses-description">
									<?=__('你可以在激活后24小时内完整学习3次视频', 'bingo')?>
								</p>
                                <hr>
	    						<?php if ($service_valid_before < time()): ?>
								<form method="post"><input type="submit" name="activate_<?=$service?>" value="<?=__('激活', 'bingo')?>" class="btn btn-sm ln-tr active"></form>
    							<?php else: ?>
                                <div class="expires-at">
                                    <?=__('还可以学习', 'bingo')?> <?=date('H:i', $service_valid_before - time())?>
                                    <?php if ($service_inactivated): ?>+<?=$service_inactivated?><?=__('次', 'bingo')?><?php endif; ?>
                                    <a href="<?=site_url_ml( 'tip/pte-' . $service . '/')?>" class="active btn btn-sm ln-tr learn"><?=__('前往学习', 'bingo')?></a>
                                </div>
                                <?php endif; ?>
							</div>
						</div>
						<?php endif; endforeach; ?>

						<?php if (!$active_products): ?>
						<div class="subscribe">
                            <?php if (is_limited_free($user->ID)): ?>
                                <a href="<?=site_url_ml('pricing-table/?intend=' . $_SERVER['REQUEST_URI'])?>" class="subscribe-btn ln-tr"><?=__('您正在试用限时课程，点击订阅完整技巧和学习包', 'bingo')?></a>
                            <?php else: ?>
							<a href="<?=site_url_ml('pricing-table/?intend=' . $_SERVER['REQUEST_URI'])?>" class="subscribe-btn ln-tr"><?=__('您目前没有订阅任何产品，点击订阅', 'bingo')?></a>
                            <?php endif; ?>
						</div>
						<?php endif; ?>
					</div>
				</div><!-- end login form -->
			</div><!-- end col-md-8/offset -->
		</div><!-- end row -->
	</div><!-- end container -->
</section><!-- End Register Page -->

<script type="text/javascript">
jQuery(function($) {
    new ClipboardJS('.copy-invitation-link');
    $('.copy-invitation-link').click(function (e) {
        e.preventDefault();
        alert('<?=__('邀请注册链接已复制，发送给好友邀请他们注册吧！', 'bingo')?>');
    });
});
</script>

<?php get_footer(); ?>
