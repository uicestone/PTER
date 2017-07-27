<div class="clearfix"></div>

<footer id="footer">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="widget about-widget">
                    <?php $about = get_posts(array('name' => 'about'))[0]; ?>
					<h6 class="widget-title"><?=get_the_title($about)?></h6>
					<p class="about-text">
						<?=$about->post_excerpt?>
					</p>
					<div class="footer-links">
						<ul>
                            <li><a href="<?=site_url()?>/agreement/">使用协议</a></li>
                            <li><a href="<?=site_url()?>/how-to-use/">使用指南</a></li>
							<li><a href="<?=site_url()?>/about/" class="ln-tr">关于我们</a></li>
							<li><a href="<?=site_url()?>/contact/">联系我们</a></li>
						</ul>
					</div><!-- End Footer Links -->
				</div><!-- End About Widget -->
			</div><!-- End col-md3 -->
			<div class="col-md-3">
				<div class="widget courses-widget">
					<h6 class="widget-title">最新文章</h6>
					<div id="footer-courses-slider" class="flexslider">
						<ul class="slides">
                            <?php foreach (get_posts() as $index => $post): ?>
                            <?php if ($index % 2 === 0): ?>
                            <li class="clearfix">
                            <?php endif; ?>
                            <div class="course-icon fl">
                                <span class="icon grad-btn"><i class="fa fa-bookmark"></i></span>
                            </div><!-- End Course Icon -->
                            <div class="course-info">
                                <h4 class="footer-course-title"><a href="<?=get_the_permalink($post)?>" class="ln-tr"><?=get_the_title($post)?></a></h4>
                                <span class="course-date"><?=get_the_date('', $post)?></span>
                            </div><!-- End Course Info -->
                            <?php if ($index % 2 === 1): ?>
                            </li>
                            <?php endif; ?>
                            <?php endforeach; ?>
						</ul><!-- End ul Items -->
					</div><!-- End Footer Scourses Slider -->
				</div><!-- End Courses Widget -->
	g		</div><!-- End col-md4 -->
			<div class="col-md-6">
				<div class="widget">
                    <?php if ($copyright = get_posts('name=copyright')[0]): ?>
					<h6 class="widget-title"><?=get_the_title($copyright)?></h6>
					<div class="content">
                        <?=wpautop($copyright->post_content)?>
					</div><!-- End Footer Links -->
                    <?php endif; ?>
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

<?php wp_footer(); ?>
</body>
</html>