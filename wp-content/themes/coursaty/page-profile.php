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
	if ($_POST['invitation_code']) {
		$invited_by_users = get_users(array('meta_key' => 'invitation_code', 'meta_compare' => 'LIKE', 'meta_value' => $_POST['invitation_code']));
		if (count($invited_by_users) !== 1) {
			exit('无法确定你的邀请人，请联系客服稍后绑定邀请人');
		}
		if ($invited_by_users[0]->ID === $user->ID) {
		    exit('不能邀请自己');
        }
		add_user_meta($user->ID, 'invited_by_user', $invited_by_users[0]->ID);
	}
}

foreach (array('reading', 'writing') as $service) {
	if (isset($_POST['activate_' . $service])) {
		$service_inactivated = get_user_meta($user->ID, 'service_' . $service . '_inactivated', true);
		$service_valid_before =  get_user_meta($user->ID, 'service_' . $service . '_valid_before', true);

		if ($service_valid_before >= time()) {
			exit('已激活，不要重复激活');
		}

		if ($service_inactivated < 0) {
			exit('激活失败，没有可激活的额度');
		}

		update_user_meta($user->ID, 'service_' . $service . '_inactivated', --$service_inactivated);
		update_user_meta($user->ID, 'service_' . $service . '_valid_before', time() + 86400 - 1);
		$user->add_cap('view_' . $service);
		header('Location: ' . site_url() . $_SERVER['REQUEST_URI']); exit;
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
				<li class="ib current-page"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
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
						<span class="text">基本信息</span>
					</div><!-- End Title -->
					<form method="post" id="register-form">
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="static">
									<label>用户名：</label>
									<?=$user->user_login?>
								</div>
							</div><!-- end username -->
							<div class="col-md-6 col-sm-6">
								<div class="input-with-label">
									<label>显示名：</label>
									<input type="text" id="reg_name" name="display_name" class="name-input" placeholder="对外显示的我的名称" value="<?=$user->display_name?>">
								</div>
							</div><!-- end display_name -->
							<div class="col-md-6 col-sm-6">
								<div class="input-with-label">
									<label>电子邮箱：</label>
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
                                    <label>邀请人：</label>
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
                            <?php global $is_cn_ip; if ($is_cn_ip): ?>
                            <div class="col-md-6 col-sm-6">
                                <div class="static">
                                    <label>中国大陆网络</label>
                                </div>
                            </div><!-- end username -->
                            <?php endif; ?>
							<div class="col-md-12">
								<div class="input clearfix">
									<input type="submit" id="reg_submit" name="submit" value="修改" class="submit-input grad-btn ln-tr">
								</div>
							</div><!-- end submit -->
						</div><!-- end row -->
					</form><!-- End form -->
				</div><!-- end login form -->
				<div class="login-form register my-services">
					<div class="login-title">
						<span class="icon"><i class="fa fa-group"></i></span>
						<span class="text">我的服务</span>
                        <div class="ib fr">
                            <span>付款：$<?=get_user_meta($user->ID, 'total_paid', true) ?: 0?></span>，
                            <span>奖励：$<?=get_user_meta($user->ID, 'total_awarded', true) ?: 0?></span>，
                            <?php
							$invitation_code = get_user_meta($user->ID, 'invitation_code', true);
							if (!$invitation_code) {
								$invitation_code = sha1('Bingo' . $user->ID);
								add_user_meta($user->ID, 'invitation_code', $invitation_code);
							}
                            ?>
                            <span>邀请码：<?=substr($invitation_code, 0, 6)?></span>
                        </div>
					</div><!-- End Title -->
                    <div class="clearfix"></div>
					<div class="home-skills">
						<?php
                        $active_services = array();
                        foreach (array ('tips' => '听力口语技巧', 'exercises' => '听力口语练习') as $service => $service_name):
                            $service_valid_before = get_user_meta($user->ID, 'service_' . $service . '_valid_before', true);
                            if ($service_valid_before && $service_valid_before >= time()): $active_services[] = $service; ?>
                        <div class="add-courses box base-pack additional-pack">
							<?php $percent = ($service_valid_before - time()) / (30 * 86400) * 100 ?>
							<a href="#" class="add-courses-title ln-tr"><?=$service_name?></a>
							<div class="skillbar clearfix" data-percent="<?=min($percent, 100)?>%">
								<div class="skillbar-title"><span><?=round($percent)?>%</span></div><div class="skillbar-bar" style="width:0"></div>
							</div>
                            <hr>
                            <div class="expires-at">
                                剩余天数：<?=round(($service_valid_before - time()) / 86400, 1)?>
								<?php if ($service_valid_before - time() < 86400 * 10): ?>
                                <a href="<?=site_url()?>/pricig-table/" class="active btn btn-sm ln-tr">续费</a>
								<?php endif; ?>
                            </div>
						</div>
                        <?php endif; endforeach; ?>
					</div>
					<div class="row">
						<?php
                        foreach (array ('reading' => '阅读拓展包', 'writing' => '写作拓展包') as $service => $service_name):
                            $service_valid_before = get_user_meta($user->ID, 'service_' . $service . '_valid_before', true);
    						$service_inactivated = get_user_meta($user->ID, 'service_' . $service . '_inactivated', true);
						    if ($service_valid_before >= time() || $service_inactivated > 0): $active_services[] = $service; ?>
						<div class="col-md-6">
							<div class="add-courses box additional-pack">
								<div class="icon"><i class="fa fa-book"></i></div>
								<a href="#" class="add-courses-title ln-tr"><?=$service_name?></a>
								<p class="add-courses-description">
									你可以在激活后24小时内完整学习1次视频
								</p>
                                <hr>
	    						<?php if ($service_valid_before < time()): ?>
								<form method="post"><input type="submit" name="activate_<?=$service?>" value="激活" class="btn btn-sm ln-tr active"></form>
    							<?php else: ?>
                                <div class="expires-at">
                                    还可以学习 <?=date('H:i', $service_valid_before - time())?>
                                    <?php if ($service_inactivated): ?>+<?=$service_inactivated?>次<?php endif; ?>
                                    <a href="<?=site_url()?>/tip/pte-<?=$service?>/" class="active btn btn-sm ln-tr learn">前往学习</a>
                                </div>
                                <?php endif; ?>
							</div>
						</div>
						<?php endif; endforeach; ?>

						<?php if (!$active_services): ?>
						<div class="subscribe">
							<a href="<?=site_url()?>/pricing-table/?intend=<?=$_SERVER['REQUEST_URI']?>" class="subscribe-btn ln-tr">您目前没有任何服务，点击订阅</a>
						</div>
						<?php endif; ?>
					</div>
				</div><!-- end login form -->
			</div><!-- end col-md-8/offset -->
		</div><!-- end row -->
	</div><!-- end container -->
</section><!-- End Register Page -->

<?php get_footer(); ?>
