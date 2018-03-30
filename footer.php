<div class="clearfix"></div>

<footer id="footer">
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-sm-6">
				<div class="widget about-widget">
					<h6 class="widget-title">微信客服号</h6>
					<img src="<?=get_stylesheet_directory_uri()?>/assets/img/qrcode_cs.jpg">
				</div><!-- End About Widget -->
			</div><!-- End col-md3 -->
			<div class="col-md-3 col-sm-6">
				<div class="widget about-widget">
					<h6 class="widget-title">微信公众号</h6>
                    <img src="<?=get_stylesheet_directory_uri()?>/assets/img/qrcode_mp_co.jpg">
				</div><!-- End Courses Widget -->
			</div><!-- End col-md4 -->
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
				<p>All Rights Reserved &copy; Bingo Training Pty. Ltd. ABN 64 618 887 951, ACN 618 887 951</p>
			</div><!-- End Copyright -->
			<div class="fr footer-social-icons">
				<ul class="clearfix">
<!--					<li><a href="#" class="fb-icon ln-tr"><i class="fa fa-facebook"></i></a></li>-->
<!--                    <li><a href="#" class="in-icon ln-tr"><i class="fa fa-weixin"></i></a></li>-->
				</ul>
			</div><!-- End Social Media Icons -->
		</div><!-- End container -->
	</div><!-- End Bottom Footer -->
</footer><!-- End Footer -->
</div><!-- End Entire Wrap -->

<script type="text/javascript">
/********** Disable Context Menu in Content ***********/
jQuery('.entry .content, video, audio').on('contextmenu', function (e) {
    e.preventDefault();
});
if (!localStorage.getItem('promotionRead')) {
    jQuery('.main-navigation li.account>a, .main-navigation li.profile>a').addClass('unread');
}
</script>

<?php wp_footer(); ?>
</body>
</html>