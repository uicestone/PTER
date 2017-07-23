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
}

if (isset($_POST['activate_reading'])) {
    update_user_meta(get_current_user_id(), 'service_valid_before_阅读拓展包', time() + 86400, 'inactivated');
    sleep(1);
}

if (isset($_POST['activate_writing'])) {
	update_user_meta(get_current_user_id(), 'service_valid_before_写作拓展包', time() + 86400, 'inactivated');
	sleep(1);
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
							</div><!-- end username -->
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
					</div><!-- End Title -->
					<div class="home-skills">
						<?php
                        if ($service_package_expires_at = get_user_meta($user->ID, 'service_valid_before_听说基础包30天', true)) {
							$service_package = '听说基础包30天';
                        }
                        elseif ($service_package_expires_at = get_user_meta($user->ID, 'service_valid_before_听说读写套餐30天', true)) {
							$service_package = '听说读写套餐30天';
                        }
                        else {
                            $service_package = null;
                        }

						if ($service_package): ?>
						<div class="add-courses box base-pack additional-pack">
							<?php $percent = max(0, 1 - (strtotime($service_package_expires_at) - time()) / (30 * 86400)) * 100 ?>
							<a href="#" class="add-courses-title ln-tr"><?=$service_package?></a>
							<div class="skillbar clearfix" data-percent="<?=$percent?>%">
								<div class="skillbar-title"><span><?=round($percent)?>%</span></div><div class="skillbar-bar" style="width: <?=$percent?>%;"></div>
							</div>
                            <hr>
                            <div class="expires-at">
                                下次续费日期 <?=date('Y-m-d', strtotime($service_package_expires_at))?>
								<?php if (strtotime($service_package_expires_at) - time() < 86400 * 10): ?>
                                <a href="<?=site_url()?>/pricig-table/" class="active btn btn-sm ln-tr">续费</a>
								<?php endif; ?>
                            </div>
						</div>
						<?php endif; ?>
					</div>
					<div class="row">
						<?php
						$service_reading = get_user_meta($user->ID, 'service_valid_before_阅读拓展包', true);
						$service_writing = get_user_meta($user->ID, 'service_valid_before_写作拓展包', true);
						?>
						<?php if ($service_reading): ?>
						<div class="col-md-6">
							<div class="add-courses box additional-pack">
								<div class="icon"><i class="fa fa-book"></i></div>
								<a href="#" class="add-courses-title ln-tr">阅读拓展包</a>
								<p class="add-courses-description">
									你可以在激活后24小时内完整学习1次视频
								</p>
                                <hr>
	    						<?php if ($service_reading === 'inactivated'): ?>
								<form method="post"><input type="submit" name="activate_reading" value="激活" class="btn btn-sm ln-tr active"></form>
    							<?php else: ?>
                                <div class="expires-at">
                                    还可以学习 <?=date('H:i', $service_reading - time())?>
                                    <a href="<?=site_url()?>/tip/pte-reading/" class="active btn btn-sm ln-tr learn">前往学习</a>
                                </div>
                                <?php endif; ?>
							</div>
						</div>
						<?php endif; ?>
						<?php if ($service_writing): ?>
						<div class="col-md-6">
							<div class="add-courses box additional-pack">
								<div class="icon"><i class="fa fa-pencil"></i></div>
								<a href="#" class="add-courses-title ln-tr">写作拓展包</a>
								<p class="add-courses-description">
									你可以在激活后24小时内完整学习1次视频
								</p>
                                <hr>
								<?php if ($service_writing === 'inactivated'): ?>
                                    <form method="post"><input type="submit" name="activate_writing" value="激活" class="btn btn-sm ln-tr active"></form>
								<?php else: ?>
                                    <div class="expires-at">
                                        还可以学习 <?=date('H:i', $service_writing - time())?>
                                        <a href="<?=site_url()?>/tip/pte-reading/" class="active btn btn-sm ln-tr learn">前往学习</a>
                                    </div>
								<?php endif; ?>
							</div>
						</div>
						<?php endif; ?>
						<?php if (!$service_package && !$service_reading && !$service_writing): ?>
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
