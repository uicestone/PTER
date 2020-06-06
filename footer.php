<div class="clearfix"></div>

<footer id="footer">
	<div class="container">
		<div class="row">
			<?php if (pll_current_language() === 'zh'): ?>
			<div class="col-md-3 col-sm-6">
				<div class="widget about-widget">
					<h6 class="widget-title"><?=__('微信客服号', 'bingo')?></h6>
					<img src="<?=get_stylesheet_directory_uri()?>/assets/img/qrcode_cs.jpg">
				</div><!-- End About Widget -->
			</div><!-- End col-md3 -->
			<div class="col-md-3 col-sm-6">
				<div class="widget about-widget">
					<h6 class="widget-title"><?=__('微信公众号', 'bingo')?></h6>
                    <img src="<?=get_stylesheet_directory_uri()?>/assets/img/qrcode_mp_co.jpg">
				</div><!-- End Courses Widget -->
			</div><!-- End col-md4 -->
			<?php elseif (!is_cn_ip()): ?>
			<div class="col-md-6">
				<div class="fb-page" data-href="https://www.facebook.com/Bingotraining/" data-tabs="timeline" data-width="500" data-height="265" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/Bingotraining/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/Bingotraining/">Bingotraining Pty Ltd</a></blockquote></div>
			</div>
			<?php endif; ?>
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
<?php if (!is_cn_ip()): ?>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/zh_CN/sdk.js#xfbml=1&version=v7.0"></script>
<?php endif; ?>
</body>
</html>