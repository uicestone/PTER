<?php redirect_login();

if ($invitation_code = $_POST['invitation_code']) {
	$invited_by_users = get_users(array('meta_key' => 'invitation_code', 'meta_compare' => 'LIKE', 'meta_value' => $_POST['invitation_code']));
	if (count($invited_by_users) !== 1) {
		exit('无法确定你的邀请人，请联系客服稍后绑定邀请人');
	}
	if ($invited_by_users[0]->ID === get_current_user_id()) {
		exit('不能邀请自己');
	}
	add_user_meta(get_current_user_id(), 'invited_by_user', $invited_by_users[0]->ID);
}

$discount = 0;

if ($promotion_code_input = $_GET['promotion_code']) {
	$promotion_code = get_posts(array('post_type' => 'promotion_code', 'name' => $promotion_code_input, 'post_status' => 'private'))[0];

	if (!$promotion_code) {
		exit('错误的优惠码');
	}

	if (!get_post_meta($promotion_code->ID, 'multi_time', true)) {
		$bind_to_user = get_post_meta($promotion_code->ID, 'bind_to_user', true);

		if ($bind_to_user) {
			exit('优惠码已经被绑定');
		}
    }

	$expires_at = get_post_meta($promotion_code->ID, 'expires_at', true);

	if ($expires_at < time()) {
		exit('优惠码已过期');
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
				<li class="ib"><a href="<?=site_url()?>">首页</a></li>
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
                    <input type="text" id="invitation_code-input" name="invitation_code" class="invitation_code-input" placeholder="输入邀请码，获得优惠价格">
                    <input type="submit" id="invitation_code-submit" name="invitation_code_submit" class="invitation_code-submit ln-tr" value="保存">
                </form>
            </div>
			<?php endif; ?>
			<?php if (!isset($promotion_discount)): ?>
            <div class="col-sm-4">
                <form method="get" class="invitation_code-form">
					<?php if ($_GET): foreach ($_GET as $key => $value): ?>
					<input type="hidden" name="<?=$key?>" value="<?=$value?>">
					<?php endforeach; endif; ?>
                    <input type="text" id="promotion_code-input" name="promotion_code" value="<?=$_GET['promotion_code']?>" class="invitation_code-input" placeholder="输入优惠码，获得优惠价格">
                    <input type="submit" id="promotion_code-submit" class="invitation_code-submit ln-tr" value="使用">
                </form>
            </div>
			<?php 	if (!isset($_GET['ccl'])): ?>
            <a href="<?=site_url('exercise/repeat-sentence-%E7%BB%83%E4%B9%A01/?tag=free-trial')?>" class="limit-free ln-tr">限时免费课程试用</a>
			<a href="<?=site_url('pricing-table/?ccl')?>" class="limit-free ln-tr" style="margin-right:1em">订阅CCL模考</a>
			<?php 	endif; ?>
            <?php endif; ?>
        </div><!-- End main content row -->

		<?php if (isset($_GET['ccl'])): ?>
		<div class="row table-row fadeInDown-animation">
			<div class="col-sm-4 table-2">
				<div class="table">

					<div class="table-header grad-btn">
						<p class="text">CCL 全真模拟练习<br>（1个月）</p><!-- end text -->
						<p class="price">
							<?php $price = get_post_meta(get_the_ID(), 'price_ccl', true); if ($discount): ?>
								<del><?=$price?></del>
								<span class="price-amount"><?=round($price * (1 - $discount / 100), 2)?></span>
							<?php else: ?>
								<span class="price-amount"><?=$price?></span>
							<?php endif; ?>
							$ / 30天
						</p><!-- end price -->
					</div><!-- end table header -->

					<div class="table-body">
						<ul class="features">
							<li>CCL全真模考题+答案</li>
							<li>CCL考试题型介绍</li>
							<li>CCL考试核心评分解析</li>
							<li>CCL练习答疑</li>
							<li>CCL精选必备词汇</li>
							<li>CCL背景知识</li>
							<li>CCL听力练习</li>
						</ul><!-- end features list -->
					</div><!-- end table body -->

					<div class="table-footer">
						<div class="order-btn">
							<a href="#payment" data-service="ccl" class="grad-btn ln-tr show-payment-method">订阅</a>
						</div><!-- end order button -->
					</div><!-- end table footer -->

				</div><!-- end table -->
			</div>
			<div class="col-sm-4 table-3 recommended">
				<div class="table">

					<div class="table-header grad-btn">
						<p class="text">CCL 全真模拟练习<br>（3个月）</p><!-- end text -->
						<p class="price">
							<?php $price = get_post_meta(get_the_ID(), 'price_ccl_3', true); if ($discount): ?>
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
							<li>CCL全真模考题+答案</li>
							<li>CCL考试题型介绍</li>
							<li>CCL考试核心评分解析</li>
							<li>CCL练习答疑</li>
							<li>CCL精选必备词汇</li>
							<li>CCL背景知识</li>
							<li>CCL听力练习</li>
						</ul><!-- end features list -->
					</div><!-- end table body -->

					<div class="table-footer">
						<div class="order-btn clearfix">
							<a href="#payment" data-service="ccl" data-amount="3" class="grad-btn ln-tr show-payment-method">订阅（推荐）</a>
						</div><!-- end order button -->
					</div><!-- end table footer -->

				</div><!-- end table -->
			</div>
			<div class="col-sm-4 table-2">
				<div class="table">

					<div class="table-header grad-btn">
						<p class="text">CCL 全真模拟练习<br>（2个月）</p><!-- end text -->
						<p class="price">
							<?php $price = get_post_meta(get_the_ID(), 'price_ccl_2', true); if ($discount): ?>
								<del><?=$price?></del>
								<span class="price-amount"><?=round($price * (1 - $discount / 100), 2)?></span>
							<?php else: ?>
								<span class="price-amount"><?=$price?></span>
							<?php endif; ?>
							$ / 60天
						</p><!-- end price -->
					</div><!-- end table header -->

					<div class="table-body">
						<ul class="features">
							<li>CCL全真模考题+答案</li>
							<li>CCL考试题型介绍</li>
							<li>CCL考试核心评分解析</li>
							<li>CCL练习答疑</li>
							<li>CCL精选必备词汇</li>
							<li>CCL背景知识</li>
							<li>CCL听力练习</li>
						</ul><!-- end features list -->
					</div><!-- end table body -->

					<div class="table-footer">
						<div class="order-btn clearfix">
							<a href="#payment" data-service="ccl" data-amount="2" class="grad-btn ln-tr show-payment-method">订阅（推荐）</a>
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
                        <p class="text">听说读写四项全能（1个月）</p><!-- end text -->
                        <p class="price">
							<?php $price = get_post_meta(get_the_ID(), 'price_full', true); if ($discount): ?>
                                <del><?=$price?></del>
                                <span class="price-amount"><?=round($price * (1 - $discount / 100), 2)?></span>
							<?php else: ?>
                                <span class="price-amount"><?=$price?></span>
							<?php endif; ?>
                            $ / 30天
                        </p><!-- end price -->
                    </div><!-- end table header -->

                    <div class="table-body">
                        <ul class="features">
							<li>新增 Mock Test (2次)</li>
                            <li>宾果23天课程包</li>
                            <li>全站听力口语技巧，模板讲解</li>
                            <li>全站写作阅读技巧，模板讲解</li>
                            <li>听说读写海量练习题+满分答案</li>
                            <li>PTE听说读写备考建议</li>
                            <li>PTE题型详解+评分细则</li>
                            <li>参考笔记+答题要点</li>
                            <li>口语6, 7 ,8 分考生真实答案</li>
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
						<p class="text">听说读写四项全能（3个月）</p><!-- end text -->
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
							<li>新增 Mock Test (2次)</li>
							<li>宾果23天课程包</li>
							<li>全站听力口语技巧，模板讲解</li>
							<li>全站写作阅读技巧，模板讲解</li>
							<li>听说读写海量练习题+满分答案</li>
							<li>PTE听说读写备考建议</li>
							<li>PTE题型详解+评分细则</li>
							<li>参考笔记+答题要点</li>
							<li>口语6, 7 ,8 分考生真实答案</li>
						</ul><!-- end features list -->
					</div><!-- end table body -->

					<div class="table-footer">
						<div class="order-btn clearfix">
							<a href="#payment" data-service="full" data-amount="3" class="grad-btn ln-tr show-payment-method">订阅（推荐）</a>
						</div><!-- end order button -->
					</div><!-- end table footer -->

				</div><!-- end table -->
			</div><!-- end col-md-3 col-sm-6 -->

			<div class="col-md-4 col-sm-6 table-2 recommended">
				<div class="table">

					<div class="table-header grad-btn">
						<p class="text">听说读写四项全能（2个月）</p><!-- end text -->
						<p class="price">
							<?php $price = get_post_meta(get_the_ID(), 'price_full_2', true); if ($discount): ?>
								<del><?=$price?></del>
								<span class="price-amount"><?=round($price * (1 - $discount / 100), 2)?></span>
							<?php else: ?>
								<span class="price-amount"><?=$price?></span>
							<?php endif; ?>
							$ / 60天
						</p><!-- end price -->
					</div><!-- end table header -->

					<div class="table-body">
						<ul class="features">
							<li>新增 Mock Test (2次)</li>
							<li>宾果23天课程包</li>
							<li>全站听力口语技巧，模板讲解</li>
							<li>全站写作阅读技巧，模板讲解</li>
							<li>听说读写海量练习题+满分答案</li>
							<li>PTE听说读写备考建议</li>
							<li>PTE题型详解+评分细则</li>
							<li>参考笔记+答题要点</li>
							<li>口语6, 7 ,8 分考生真实答案</li>
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
			<?php if (!isset($_GET['ccl'])): ?>
            <div class="col-sm-4"><a href="" id="wechatpay" class="gateway" data-gateway="wechatpay"><img src="<?=get_stylesheet_directory_uri()?>/assets/img/icons/wechatpay.png"></a></div>
			<?php endif; ?>
            <div class="col-sm-4"><a href="" id="paypal" class="gateway" data-gateway="paypal"><img src="<?=get_stylesheet_directory_uri()?>/assets/img/icons/paypal.png"></a></div>
        </div>

        <div class="mobile-payment-notice" style="display:none;">
            <blockquote>
            <p>手机支付暂未全部开通，您也可以电脑版进行支付</p>
            <p>记住网址http://www.bingotraining.com 在大屏上使用以获得更好的体验</p>
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
    }, 500);

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
