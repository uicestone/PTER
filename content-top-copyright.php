<div class="copyright-header container">
	<p>All Rights Reserved &copy; Bingo Training Pty. Ltd. ABN 64 618 887 951, ACN 618 887 951</p>
	<?php if (is_limited_free(get_current_user_id())): ?>
	<hr>
	<p style="font-weight:normal">
		<?php $expires_at = get_user_meta(get_current_user_id(), 'service_tips_valid_before', true);
			$expires_at_string = '<span class="count-down" data-expires-at="' . $expires_at . '">'
			. date('Y-m-d H:i:s', $expires_at + get_option( 'gmt_offset' ) * HOUR_IN_SECONDS)
			. '</span>'; ?>
		<?=__('您是限时免费订阅用户，', 'bingo')?><?=$expires_at>time()?sprintf(__('将于%s过期，', 'bingo'), $expires_at_string):sprintf(__('已于%s过期，', 'bingo'), $expires_at_string)?>
		<?=sprintf(__('请了解我们的%s并及时%s', 'bingo'), '<a href="' . site_url_ml('profile') . '" target="_blank">' . __('优惠政策', 'bingo') . '</a>', '<a href="' . site_url_ml('pricing-table/') . '">' . __('订阅', 'bingo') . '</a>')?>
	</p>
	<?php endif; ?>
</div>

<div class="clearfix"></div>
