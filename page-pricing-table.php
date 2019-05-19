<?php redirect_login();

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
				<li class="ib"><a href="<?=site_url()?>"><?=__(首页, 'bingo')?></a></li>
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
			<?php 	if (!isset($_GET['ccl'])): ?>
            <a href="<?=site_url('exercise/repeat-sentence-%E7%BB%83%E4%B9%A01/?tag=free-trial')?>" class="limit-free ln-tr"><?=__('限时免费课程试用', 'bingo')?></a>
			<a href="<?=site_url('pricing-table/?ccl')?>" class="limit-free ln-tr" style="margin-right:1em"><?=__('订阅', 'bingo')?><?=__('CCL模考', 'bingo')?></a>
			<?php 	endif; ?>
            <?php endif; ?>
        </div><!-- End main content row -->

		<?php if (isset($_GET['ccl'])): ?>
		<div class="row table-row fadeInDown-animation">
			<div class="col-sm-4 table-2">
				<div class="table">

					<div class="table-header grad-btn">
						<p class="text">CCL <?=__('全真模拟练习', 'bingo')?><br>（1<?=__('个月', 'bingo')?>）</p><!-- end text -->
						<p class="price">
							<?php $price = get_post_meta(get_the_ID(), 'price_ccl', true); if ($discount): ?>
								<del><?=$price?></del>
								<span class="price-amount"><?=round($price * (1 - $discount / 100), 2)?></span>
							<?php else: ?>
								<span class="price-amount"><?=$price?></span>
							<?php endif; ?>
							$ / 30<?=__('天', 'bingo')?>
						</p><!-- end price -->
					</div><!-- end table header -->

					<div class="table-body">
						<ul class="features">
							<li>CCL<?=__('全真模考题', 'bingo')?>+<?=__('答案', 'bingo')?></li>
							<li>CCL<?=__('考试题型介绍', 'bingo')?></li>
							<li>CCL<?=__('考试核心评分解析', 'bingo')?></li>
							<li>CCL<?=__('练习答疑', 'bingo')?></li>
							<li>CCL<?=__('精选必备词汇', 'bingo')?></li>
							<li>CCL<?=__('背景知识', 'bingo')?></li>
							<li>CCL<?=__('听力练习', 'bingo')?></li>
						</ul><!-- end features list -->
					</div><!-- end table body -->

					<div class="table-footer">
						<div class="order-btn">
							<a href="#payment" data-service="ccl" class="grad-btn ln-tr show-payment-method"><?=__('订阅', 'bingo')?></a>
						</div><!-- end order button -->
					</div><!-- end table footer -->

				</div><!-- end table -->
			</div>
			<div class="col-sm-4 table-3 recommended">
				<div class="table">

					<div class="table-header grad-btn">
						<p class="text">CCL <?=__('全真模拟练习', 'bingo')?><br>（3<?=__('个月', 'bingo')?>）</p><!-- end text -->
						<p class="price">
							<?php $price = get_post_meta(get_the_ID(), 'price_ccl_3', true); if ($discount): ?>
								<del><?=$price?></del>
								<span class="price-amount"><?=round($price * (1 - $discount / 100), 2)?></span>
							<?php else: ?>
								<span class="price-amount"><?=$price?></span>
							<?php endif; ?>
							$ / 90<?=__('天', 'bingo')?>
						</p><!-- end price -->
					</div><!-- end table header -->

					<div class="table-body">
						<ul class="features">
							<li>CCL<?=__('全真模考题', 'bingo')?>+<?=__('答案', 'bingo')?></li>
							<li>CCL<?=__('考试题型介绍', 'bingo')?></li>
							<li>CCL<?=__('考试核心评分解析', 'bingo')?></li>
							<li>CCL<?=__('练习答疑', 'bingo')?></li>
							<li>CCL<?=__('精选必备词汇', 'bingo')?></li>
							<li>CCL<?=__('背景知识', 'bingo')?></li>
							<li>CCL<?=__('听力练习', 'bingo')?></li>
						</ul><!-- end features list -->
					</div><!-- end table body -->

					<div class="table-footer">
						<div class="order-btn clearfix">
							<a href="#payment" data-service="ccl" data-amount="3" class="grad-btn ln-tr show-payment-method"><?=__('订阅', 'bingo')?><?=__('（推荐）', 'bingo')?></a>
						</div><!-- end order button -->
					</div><!-- end table footer -->

				</div><!-- end table -->
			</div>
			<div class="col-sm-4 table-2">
				<div class="table">

					<div class="table-header grad-btn">
						<p class="text">CCL <?=__('全真模拟练习', 'bingo')?><br>（2<?=__('个月', 'bingo')?>）</p><!-- end text -->
						<p class="price">
							<?php $price = get_post_meta(get_the_ID(), 'price_ccl_2', true); if ($discount): ?>
								<del><?=$price?></del>
								<span class="price-amount"><?=round($price * (1 - $discount / 100), 2)?></span>
							<?php else: ?>
								<span class="price-amount"><?=$price?></span>
							<?php endif; ?>
							$ / 60<?=__('天', 'bingo')?>
						</p><!-- end price -->
					</div><!-- end table header -->

					<div class="table-body">
						<ul class="features">
							<li>CCL<?=__('全真模考题', 'bingo')?>+<?=__('答案', 'bingo')?></li>
							<li>CCL<?=__('考试题型介绍', 'bingo')?></li>
							<li>CCL<?=__('考试核心评分解析', 'bingo')?></li>
							<li>CCL<?=__('练习答疑', 'bingo')?></li>
							<li>CCL<?=__('精选必备词汇', 'bingo')?></li>
							<li>CCL<?=__('背景知识', 'bingo')?></li>
							<li>CCL<?=__('听力练习', 'bingo')?></li>
						</ul><!-- end features list -->
					</div><!-- end table body -->

					<div class="table-footer">
						<div class="order-btn clearfix">
							<a href="#payment" data-service="ccl" data-amount="2" class="grad-btn ln-tr show-payment-method"><?=__('订阅', 'bingo')?><?=__('（推荐）', 'bingo')?></a>
						</div><!-- end order button -->
					</div><!-- end table footer -->

				</div><!-- end table -->
			</div>
		</div><!-- end 1st row -->
		<?php else: ?>
		<div class="row table-row fadeInDown-animation">
            <div class="col-md-4 col-sm-6 table-2 recommended">
                <div class="table">

                    <div class="table-header grad-btn">
                        <p class="text"><?=__('听说读写四项全能', 'bingo')?>（1<?=__('个月', 'bingo')?>）</p><!-- end text -->
                        <p class="price">
							<?php $price = get_post_meta(get_the_ID(), 'price_full', true); if ($discount): ?>
                                <del><?=$price?></del>
                                <span class="price-amount"><?=round($price * (1 - $discount / 100), 2)?></span>
							<?php else: ?>
                                <span class="price-amount"><?=$price?></span>
							<?php endif; ?>
                            $ / 30<?=__('天', 'bingo')?>
                        </p><!-- end price -->
                    </div><!-- end table header -->

                    <div class="table-body">
                        <ul class="features">
							<li><?=__('新增', 'bingo')?> Mock Test (2<?=__('次', 'bingo')?>)</li>
                            <li><?=__('宾果', 'bingo')?>23<?=__('天课程包', 'bingo')?></li>
                            <li><?=__('全站听力口语技巧，模板讲解', 'bingo')?></li>
                            <li><?=__('全站写作阅读技巧，模板讲解', 'bingo')?></li>
                            <li><?=__('听说读写海量练习题', 'bingo')?>+<?=__('满分答案', 'bingo')?></li>
                            <li><?=__('PTE听说读写备考建议', 'bingo')?></li>
                            <li><?=__('PTE题型详解', 'bingo')?>+<?=__('评分细则', 'bingo')?></li>
                            <li><?=__('参考笔记')?>+<?=__('答题要点', 'bingo');?></li>
                            <li><?=__('口语 6, 7 ,8 分考生真实答案', 'bingo')?></li>
                        </ul><!-- end features list -->
                    </div><!-- end table body -->

                    <div class="table-footer">
                        <div class="order-btn">
                            <a href="#payment" data-service="full" class="grad-btn ln-tr show-payment-method">订阅</a>
                        </div><!-- end order button -->
                    </div><!-- end table footer -->

                </div><!-- end table -->
            </div><!-- end col-md-3 col-sm-6 -->

			<div class="col-md-4 col-sm-6 table-3 recommended">
				<div class="table">

					<div class="table-header grad-btn">
						<p class="text"><?=__('听说读写四项全能', 'bingo')?>（3<?=__('个月', 'bingo')?>）</p><!-- end text -->
						<p class="price">
							<?php $price = get_post_meta(get_the_ID(), 'price_full_3', true); if ($discount): ?>
								<del><?=$price?></del>
								<span class="price-amount"><?=round($price * (1 - $discount / 100), 2)?></span>
							<?php else: ?>
								<span class="price-amount"><?=$price?></span>
							<?php endif; ?>
							$ / 90天
						</p><!-- end price -->
					</div><!-- end table header -->

					<div class="table-body">
						<ul class="features">
							<li><?=__('新增', 'bingo')?> Mock Test (2<?=__('次', 'bingo')?>)</li>
							<li><?=__('宾果', 'bingo')?>23<?=__('天课程包', 'bingo')?></li>
							<li><?=__('全站听力口语技巧，模板讲解', 'bingo')?></li>
							<li><?=__('全站写作阅读技巧，模板讲解', 'bingo')?></li>
							<li><?=__('听说读写海量练习题', 'bingo')?>+<?=__('满分答案', 'bingo')?></li>
							<li>PTE<?=__('听说读写备考建议', 'bingo')?></li>
							<li>PTE<?=__('题型详解', 'bingo')?>+<?=__('评分细则', 'bingo')?></li>
							<li><?=__('参考笔记', 'bingo')?>+<?=__('答题要点', 'bingo')?></li>
							<li><?=__('口语 6, 7 ,8 分考生真实答案', 'bingo')?></li>
						</ul><!-- end features list -->
					</div><!-- end table body -->

					<div class="table-footer">
						<div class="order-btn clearfix">
							<a href="#payment" data-service="full" data-amount="3" class="grad-btn ln-tr show-payment-method"><?=__('订阅', 'bingo')?><?=__('（推荐）', 'bingo')?></a>
						</div><!-- end order button -->
					</div><!-- end table footer -->

				</div><!-- end table -->
			</div><!-- end col-md-3 col-sm-6 -->

			<div class="col-md-4 col-sm-6 table-2 recommended">
				<div class="table">

					<div class="table-header grad-btn">
						<p class="text"><?=__('听说读写四项全能', 'bingo')?>（2<?=__('个月', 'bingo')?>）</p><!-- end text -->
						<p class="price">
							<?php $price = get_post_meta(get_the_ID(), 'price_full_2', true); if ($discount): ?>
								<del><?=$price?></del>
								<span class="price-amount"><?=round($price * (1 - $discount / 100), 2)?></span>
							<?php else: ?>
								<span class="price-amount"><?=$price?></span>
							<?php endif; ?>
							$ / 60<?=__('天', 'bingo')?>
						</p><!-- end price -->
					</div><!-- end table header -->

					<div class="table-body">
						<ul class="features">
							<li><?=__('新增', 'bingo')?> Mock Test (2<?=__('次', 'bingo')?>)</li>
							<li><?=__('宾果', 'bingo')?>23<?=__('天课程包', 'bingo')?></li>
							<li><?=__('全站听力口语技巧', 'bingo')?>，<?=__('模板讲解', 'bingo')?></li>
							<li><?=__('全站写作阅读技巧', 'bingo')?>，<?=__('模板讲解', 'bingo')?></li>
							<li><?=__('听说读写海量练习题', 'bingo')?>+<?=__('满分答案', 'bingo')?></li>
							<li>PTE<?=__('听说读写备考建议', 'bingo')?></li>
							<li>PTE<?=__('题型详解', 'bingo')?>+<?=__('评分细则', 'bingo')?></li>
							<li><?=__('参考笔记', 'bingo')?>+答题要点</li>
							<li><?=__('口语 6, 7 ,8 分考生真实答案', 'bingo')?></li>
						</ul><!-- end features list -->
					</div><!-- end table body -->

					<div class="table-footer">
						<div class="order-btn clearfix">
							<a href="#payment" data-service="full" data-amount="2" class="grad-btn ln-tr show-payment-method">订阅</a>
						</div><!-- end order button -->
					</div><!-- end table footer -->

				</div><!-- end table -->
			</div><!-- end col-md-3 col-sm-6 -->
		</div><!-- end 1st row -->
		<?php endif; ?>

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

    var price, subject, service, amount;

    $('.show-payment-method').on('click', function (e) {
        $('.payment-gateways').hide(300).show(300);
        price = $(this).parents('.table').find('.price-amount').text();
        subject = $(this).parents('.table').find('.table-header>.text').text();
        service = $(this).data('service');
        amount = $(this).data('amount') || 1;
    });

    $('.payment-gateways .gateway').on('click', function (e) {
        var href, gateway;
        e.preventDefault();

        gateway = $(this).data('gateway');

        href = '/payment/' + gateway + '/?price='+ price
            + '&subject=' + (subject)
            + '&service=' + (service)
            + '&amount=' + (amount)
            + '&intend=' + ('<?=$_GET['intend']?>')
            + '&promotion_code=' + ('<?=$_GET['promotion_code']?>');

        window.location.href = href;
    });

    setInterval(function () {
        $('.recommended a').toggleClass('bling');
        setTimeout(function(){
            $('.recommended a').toggleClass('bling');
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
