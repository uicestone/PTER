<div class="copyright-header container">
	<p>All Rights Reserved &copy; Bingo Training Pty. Ltd. ABN 64 618 887 951, ACN 618 887 951</p>
	<?php if (is_limited_free(get_current_user_id())): ?>
	<hr>
	<p style="font-weight:normal">
		<?php $expires_at = get_user_meta(get_current_user_id(), 'service_tips_valid_before', true); ?>
		您是限时免费订阅用户，<?=$expires_at>time()?'将':'已'?>于
		<span class="count-down" data-expires-at="<?=$expires_at?>">
			<?=date('Y-m-d H:i:s', $expires_at + get_option( 'gmt_offset' ) * HOUR_IN_SECONDS)?>
		</span>
		过期，请了解我们的<a href="<?=site_url('profile')?>" target="_blank">优惠政策</a>，并及时<a href="<?=site_url('pricing-table')?>">订阅</a>
	</p>
	<?php endif; ?>
</div>

<div class="clearfix"></div>
