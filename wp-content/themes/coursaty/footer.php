<div class="clearfix"></div>

<footer id="footer">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="widget about-widget">
                    <?php $about = get_posts(array('name' => 'about'))[0]; ?>
					<h6 class="widget-title"><?=get_the_title($about)?></h6>
					<p class="about-text">
						<?=get_the_excerpt($about)?>
					</p>
					<div class="footer-links">
						<ul>
							<li><a href="<?=site_url()?>/about/" class="ln-tr">关于我们</a></li>
							<li><a href="<?=site_url()?>/contact/">联系我们</a></li>
						</ul>
					</div><!-- End Footer Links -->
				</div><!-- End About Widget -->
			</div><!-- End col-md3 -->
			<div class="col-md-3">
				<div class="widget twitter-widget">
					<h6 class="widget-title">最近动态</h6>
					<div id="tweets-slider" class="flexslider">
						<ul class="slides">
							<li>
								<div class="tweet">
									<a href="#" class="ln-tr">@begha</a> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem quam.
									<div class="date">Dec. 6, 2014</div>
								</div><!-- End Single Tweet -->
								<div class="tweet">
									<a href="#" class="ln-tr">@begha</a> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem quam.
									<div class="date">Dec. 6, 2014</div>
								</div><!-- End Single Tweet -->
							</li><!-- End 1st Tweet Slide Item -->
							<li>
								<div class="tweet">
									<a href="#" class="ln-tr">@begha</a> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem quam.
									<div class="date">Dec. 6, 2014</div>
								</div><!-- End Single Tweet -->
								<div class="tweet">
									<a href="#" class="ln-tr">@begha</a> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem quam.
									<div class="date">Dec. 6, 2014</div>
								</div><!-- End Single Tweet -->
							</li><!-- End 2nd Tweet Slide Item -->
						</ul><!-- End ul Items -->
					</div><!-- End Tweets Slider -->
				</div><!-- End Twitter Widget -->
			</div><!-- End col-md3 -->
			<div class="col-md-4">
				<div class="widget courses-widget">
					<h6 class="widget-title">最新文章</h6>
					<div id="footer-courses-slider" class="flexslider">
						<ul class="slides">
                            <?php foreach (get_posts() as $index => $post): ?>
							<li class="clearfix">
								<div class="course-icon fl">
									<span class="icon grad-btn"><i class="fa fa-bookmark"></i></span>
								</div><!-- End Course Icon -->
								<div class="course-info">
									<h4 class="footer-course-title"><a href="<?=get?>" class="ln-tr"><?=get_the_title($post)?></a></h4>
									<p class="footer-course-description"><?=get_the_excerpt($post)?></p>
									<span class="course-date"><?=get_the_date('', $post)?></span>
								</div><!-- End Course Info -->
								<div class="course-icon fl">
									<span class="icon"><i class="fa fa-bookmark"></i></span>
								</div><!-- End Course Icon -->
								<div class="course-info">
									<h4 class="footer-course-title"><a href="#" class="ln-tr">How to Design website?</a></h4>
									<p class="footer-course-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem</p>
									<span class="course-date">Dec 8, 2015</span>
								</div><!-- End Course Info -->
							</li><!-- End 1st Slide Item -->
                            <?php endforeach; ?>
						</ul><!-- End ul Items -->
					</div><!-- End Footer Scourses Slider -->
				</div><!-- End Courses Widget -->
			</div><!-- End col-md4 -->
			<div class="col-md-2">
				<div class="widget links-widget">
					<h6 class="widget-title">链接</h6>
					<div class="footer-links">
						<ul>
							<li><a href="http://pearsonpte.com/" class="ln-tr">PTE</a></li>
						</ul>
					</div><!-- End Footer Links -->
				</div><!-- End Links Widget -->
			</div><!-- End col-md2 -->
		</div>
	</div>
	<div id="bottom">
		<div class="container">
			<div class="fl copyright">
				<p>All Rights Reserved &copy; Bingo Training Pty. Ltd.</p>
			</div><!-- End Copyright -->
			<div class="fr footer-social-icons">
				<ul class="clearfix">
					<li><a href="#" class="fb-icon ln-tr"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#" class="in-icon ln-tr"><i class="fa fa-weixin"></i></a></li>
				</ul>
			</div><!-- End Social Media Icons -->
		</div><!-- End container -->
	</div><!-- End Bottom Footer -->
</footer><!-- End Footer -->
</div><!-- End Entire Wrap -->

<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog container">
		<div class="popup-content">
			<div class="login-page">
				<div class="row">
					<div class="col-md-12">
						<div class="login-form">
							<div class="login-title">
								<span class="icon"><i class="fa fa-group"></i></span>
								<span class="text">Login Area</span>
								<a href="#" class="close-modal fr" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true"><i class="fa fa-close"></i></span>
								</a>
							</div><!-- End Title -->
							<form method="post" action="/" id="login-form">
								<div class="row">
									<div class="col-md-6 col-sm-6">
										<div class="input">
											<input type="text" id="login_username" class="username-input" placeholder="User Name">
										</div>
									</div>
									<div class="col-md-6 col-sm-6">
										<div class="input">
											<input type="password" id="login_password" class="password-input" placeholder="Password">
										</div>
									</div>
									<div class="col-md-12">
										<div class="input clearfix">
											<input type="submit" id="login_submit" class="submit-input grad-btn ln-tr" value="Login">
										</div>
									</div>
									<div class="col-md-6 col-sm-6 clearfix">
										<div class="custom-checkbox fl">
											<input type="checkbox" id="login_remember" class="checkbox-input" checked>
											<label for="login_remember">Remember Password</label>
										</div>
									</div><!-- end remember -->
									<div class="col-md-6 col-sm-6 clearfix">
										<div class="forgot fr">
											<a href="#" class="new-user">Create New Account</a> / <a href="#" class="reset">Forget Password ?</a>
										</div>
									</div><!-- end forgot password -->
								</div><!-- end row -->
							</form><!-- End form -->
						</div><!-- end login form -->
						<div class="login-options">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<a href="#" class="login-op-btn grad-btn ln-tr fb">Login with Facebook Account</a>
								</div><!-- end FB login -->
								<div class="col-md-6 col-sm-6">
									<a href="#" class="login-op-btn grad-btn ln-tr gp">Login with Google Account</a>
								</div><!-- end GP login -->
								<div class="col-md-6 col-sm-6">
									<a href="#" class="login-op-btn grad-btn ln-tr tw">Login with Twitter Account</a>
								</div><!-- end TW login -->
								<div class="col-md-6 col-sm-6">
									<a href="#" class="login-op-btn grad-btn ln-tr ya">Login with Yahoo Account</a>
								</div><!-- end YA login -->
							</div>
						</div><!-- end login optionss -->
					</div><!-- end col-md-12 -->
				</div><!-- end row -->
			</div><!-- End Login Page -->
		</div><!-- End Modal Content -->
	</div><!-- End Dialog -->
</div><!-- End Login Modal -->

<div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog container">
		<div class="popup-content">
			<div class="login-page">
				<div class="row">
					<div class="col-md-12">
						<div class="login-form register">
							<div class="login-title">
								<span class="icon"><i class="fa fa-group"></i></span>
								<span class="text">Register</span>
								<a href="#" class="close-modal fr" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true"><i class="fa fa-close"></i></span>
								</a>
							</div><!-- End Title -->
							<form method="post" action="/" id="register-form">
								<div class="row">
									<div class="col-md-6 col-sm-6">
										<div class="input">
											<input type="text" id="reg_username" class="username-input" placeholder="User Name">
										</div>
									</div><!-- end username -->
									<div class="col-md-6 col-sm-6">
										<div class="input">
											<input type="email" id="reg_email" class="email-input" placeholder="Email">
										</div>
									</div><!-- end email -->
									<div class="col-md-6 col-sm-6">
										<div class="input">
											<input type="password" id="reg_password" class="password-input" placeholder="Password">
										</div>
									</div><!-- end password -->
									<div class="col-md-6 col-sm-6">
										<div class="input">
											<input type="password" id="reg_confirm-password" class="confirm-password-input" placeholder="Confirm Password">
										</div>
									</div><!-- end confirm password -->
									<div class="col-md-12">
										<div class="input clearfix">
											<input type="submit" id="reg_submit" class="submit-input grad-btn ln-tr" value="Login">
										</div>
									</div><!-- end submit -->
								</div><!-- end row -->
							</form><!-- End form -->
						</div><!-- end login form -->
						<div class="login-options">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<a href="#" class="login-op-btn grad-btn ln-tr fb">Login with Facebook Account</a>
								</div><!-- end FB login -->
								<div class="col-md-6 col-sm-6">
									<a href="#" class="login-op-btn grad-btn ln-tr gp">Login with Google Account</a>
								</div><!-- end GP login -->
								<div class="col-md-6 col-sm-6">
									<a href="#" class="login-op-btn grad-btn ln-tr tw">Login with Twitter Account</a>
								</div><!-- end TW login -->
								<div class="col-md-6 col-sm-6">
									<a href="#" class="login-op-btn grad-btn ln-tr ya">Login with Yahoo Account</a>
								</div><!-- end YA login -->
							</div>
						</div><!-- end login optionss -->
					</div><!-- end col-md-8/offset -->
				</div><!-- end row -->
			</div><!-- End Register Page -->
		</div><!-- End Modal Content -->
	</div><!-- End Dialog -->
</div><!-- End Register Modal -->
<?php wp_footer(); ?>
</body>
</html>