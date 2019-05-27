<?php redirect_login();

$products = $_GET['products'] ? explode(',', $_GET['products']) : array('pte');

if ($invitation_code = $_POST['invitation_code']) {
	$invited_by_users = get_users(array('meta_key' => 'invitation_code', 'meta_compare' => 'LIKE', 'meta_value' => $_POST['invitation_code']));
	if (count($invited_by_users) !== 1) {
		exit(__('无法确定你的邀请人，请联系客服稍后绑定邀请人', 'bingo'));
	}
	if ($invited_by_users[0]->ID === get_current_user_id()) {
		exit(__('不能邀请自己', 'bingo'));
	}
	add_user_meta(get_current_user_id(), 'invited_by_user', $invited_by_users[0]->ID);
}

$discount = 0;

if ($promotion_code_input = $_GET['promotion_code']) {
	$promotion_code = get_posts(array('post_type' => 'promotion_code', 'name' => $promotion_code_input, 'post_status' => 'private'))[0];

	if (!$promotion_code) {
		exit(__('错误的优惠码', 'bingo'));
	}

	if (!get_post_meta($promotion_code->ID, 'multi_time', true)) {
		$bind_to_user = get_post_meta($promotion_code->ID, 'bind_to_user', true);

		if ($bind_to_user) {
			exit(__('优惠码已经被绑定', 'bingo'));
		}
    }

	$expires_at = get_post_meta($promotion_code->ID, 'expires_at', true);

	if ($expires_at < time()) {
		exit(__('优惠码已过期', 'bingo'));
	}

	$discount = get_post_meta($promotion_code->ID, 'discount', true);
}

// invitation discount
$invited_by_user = get_user_meta(get_current_user_id(), 'invited_by_user', true);
$invited_by_user_total_paid = get_user_meta($invited_by_user, 'total_paid', true);
$discount_order = get_user_meta(get_current_user_id(), 'discount_order', true);
$discountable = $invited_by_user && $invited_by_user_total_paid > 0 && !$discount_order;
if ($discountable) {
	$discount = get_post_meta(get_the_ID(), 'intro_discount', true);
}

get_header(); the_post() ?>

<div class="inner-head">
	<div class="container">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<p class="description">
			<?php the_subtitle(); ?>
		</p>
		<div class="breadcrumb">
			<ul class="clearfix">
				<li class="ib"><a href="<?=site_url()?>"><?=__('首页', 'bingo')?></a></li>
				<li class="ib current-page"><a href=""><?php the_title(); ?></a></li>
			</ul>
		</div>
	</div><!-- End container -->
</div><!-- End Inner Page Head -->

<div class="clearfix"></div>

<section class="pricing-tables">
	<div class="container">
        <div class="row" style="margin-top:25px;margin-bottom:15px">
			<?php if (!$invited_by_user): ?>
            <div class="col-sm-4">
                <form method="post" class="invitation_code-form">
                    <input type="text" id="invitation_code-input" name="invitation_code" class="invitation_code-input" placeholder="<?=__('输入邀请码，获得优惠价格', 'bingo')?>">
                    <input type="submit" id="invitation_code-submit" name="invitation_code_submit" class="invitation_code-submit ln-tr" value="<?=__('保存', 'bingo')?>">
                </form>
            </div>
			<?php endif; ?>
			<?php if (!isset($promotion_discount)): ?>
            <div class="col-sm-4">
                <form method="get" class="invitation_code-form">
					<?php if ($_GET): foreach ($_GET as $key => $value): ?>
					<input type="hidden" name="<?=$key?>" value="<?=$value?>">
					<?php endforeach; endif; ?>
                    <input type="text" id="promotion_code-input" name="promotion_code" value="<?=$_GET['promotion_code']?>" class="invitation_code-input" placeholder="<?=__('输入优惠码，获得优惠价格', 'bingo')?>">
                    <input type="submit" id="promotion_code-submit" class="invitation_code-submit ln-tr" value="<?=__('使用', 'bingo')?>">
                </form>
            </div>
			<?php 	if (!in_array('ccl', $products)): ?>
            <a href="<?=site_url('exercise/repeat-sentence-%E7%BB%83%E4%B9%A01/?tag=free-trial')?>" class="limit-free ln-tr"><?=__('限时免费课程试用', 'bingo')?></a>
			<a href="<?=site_url('pricing-table/?products=ccl')?>" class="limit-free ln-tr" style="margin-right:1em"><?=__('订阅', 'bingo')?><?=__('CCL模考', 'bingo')?></a>
			<?php 	endif; ?>
            <?php endif; ?>
        </div><!-- End main content row -->

		<div class="row table-row fadeInDown-animation">
			<?php foreach(get_posts(array('post_type'=>'subscribe', 'posts_per_page'=>-1)) as $index => $subscribe_post): ?>
			<?php
				$question_types = get_field('grant_permissions_question_types', $subscribe_post->ID);
				$products_in_subscription = array_column($question_types, 'slug');
				if (!array_intersect($products, $products_in_subscription)) continue;
			?>
			<div class="col-sm-4 <?=get_field('recommended', $subscribe_post->ID)?'table-3 recommended':'table-2'?>">
				<div class="table price-table">

					<div class="table-header grad-btn">
						<p class="text"><?=get_the_title($subscribe_post->ID)?></p><!-- end text -->
						<p class="price">
							<?php $price = get_post_meta($subscribe_post->ID, 'price', true); if ($discount): ?>
								<del><?=$price?></del>
								<span class="price-amount"><?=round($price * (1 - $discount / 100), 2)?></span>
							<?php else: ?>
								<span class="price-amount"><?=$price?></span>
							<?php endif; ?>
							$ / <span class="duration-days"><?=get_post_meta($subscribe_post->ID, 'duration', true)?></span><?=__('天', 'bingo')?>
						</p><!-- end price -->
					</div><!-- end table header -->

					<div class="table-body">
						<ul class="features">
							<?=implode(array_map(function($line){ return '<li>'.$line.'</li>';}, explode("\n", get_post_meta($subscribe_post->ID, 'features', true))))?>
						</ul><!-- end features list -->
					</div><!-- end table body -->

					<div class="table-footer">
						<div class="order-btn">
							<a href="#payment" data-products="<?=implode(',', $products_in_subscription)?>" data-gateway-account="<?=get_post_meta($subscribe_post->ID, 'payment_gateway', true)?>" class="grad-btn ln-tr show-payment-method"><?=__('订阅', 'bingo')?></a>
						</div><!-- end order button -->
					</div><!-- end table footer -->

				</div><!-- end table -->
			</div>
			<?php if ($index % 3 === 2): ?>
		</div><!-- end 1st row -->
		<div class="row table-row fadeInDown-animation">
			<?php endif; ?>
			<?php endforeach; ?>
		</div><!-- end 1st row -->

        <div id="payment"></div>

        <div class="row payment-gateways" style="display: none;">
			<!--<div class="col-sm-4"><a href="" id="alipay" class="gateway" data-gateway="alipay"><img src="<?=get_stylesheet_directory_uri()?>/assets/img/icons/alipay.png"></a></div>-->
			<!--<div class="col-sm-4"><a href="" id="wechatpay" class="gateway" data-gateway="wechatpay"><img src="<?=get_stylesheet_directory_uri()?>/assets/img/icons/wechatpay.png"></a></div>-->
            <div class="col-sm-4"><a href="" id="paypal" class="gateway" data-gateway="paypal"><img src="<?=get_stylesheet_directory_uri()?>/assets/img/icons/paypal.png"></a></div>
        </div>

        <div class="mobile-payment-notice" style="display:none;">
            <blockquote>
            <p><?=__('手机支付暂未全部开通，您也可以电脑版进行支付', 'bingo')?></p>
            <p><?=__('记住网址', 'bingo')?>http://www.bingotraining.com <?=__('在大屏上使用以获得更好的体验', 'bingo')?></p>
            </blockquote>
        </div>

	</div><!-- end container -->
</section><!-- end pricing section -->

<script type="text/javascript">
jQuery(function ($) {

    var price, subject, products, duration, gatewayAccount;

    $('.show-payment-method').on('click', function (e) {
        $('.payment-gateways').hide(300).show(300);
        price = $(this).parents('.table').find('.price-amount').text();
        duration = $(this).parents('.table').find('.duration-days').text();
        subject = $(this).parents('.table').find('.table-header>.text').text();
        products = $(this).data('products');
        gatewayAccount = $(this).data('gateway-account');
    });

    $('.payment-gateways .gateway').on('click', function (e) {
        var href, gateway;
        e.preventDefault();

        gateway = $(this).data('gateway');

        href = '/payment/' + gateway + '/?price='+ price
            + '&subject=' + (subject)
            + '&products=' + (products)
            + '&duration=' + (duration)
            + '&gateway_account=' + (gatewayAccount)
            + '&intend=' + ('<?=urlencode($_GET['intend'])?>')
            + '&promotion_code=' + ('<?=$_GET['promotion_code']?>');

        window.location.href = href;
    });

    setInterval(function () {
        $('.price-table a').toggleClass('bling');
        setTimeout(function(){
            $('.price-table a').toggleClass('bling');
		}, 500)
    }, 3000);

    Date.prototype.format = function() {
        var m = this.getMonth() + 1; // getMonth() is zero-based
        var d = this.getDate();

        return [this.getFullYear(),
            (m>9 ? '' : '0') + m,
            (d>9 ? '' : '0') + d
        ].join('');
    };
});
</script>

<?php get_footer(); ?>
