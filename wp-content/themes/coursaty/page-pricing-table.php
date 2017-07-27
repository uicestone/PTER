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

if ($promotion_code_input = $_POST['promotion_code']) {
	$promotion_code = get_posts(array('post_type' => 'promotion_code', 'name' => $promotion_code_input, 'post_status' => 'private'))[0];

	if (!$promotion_code) {
		exit('错误的优惠码');
	}

	$bind_to_user = get_post_meta($promotion_code->ID, 'bind_to_user', true);

	if ($bind_to_user) {
	    exit('优惠码已经被绑定');
    }

	$expires_at = get_post_meta($promotion_code->ID, 'expires_at', true);
	$discount = get_post_meta($promotion_code->ID, 'discount', true);

	if ($expires_at < time()) {
		exit('优惠码已过期');
	}

	add_user_meta(get_current_user_id(), 'promotion_discount', $discount . ' ' . $expires_at);
	add_post_meta($promotion_code->ID, 'bind_to_user', get_current_user_id());
}

$discount = 0;
// invitation discount
$invited_by_user = get_user_meta(get_current_user_id(), 'invited_by_user', true);
$invited_by_user_total_paid = get_user_meta($invited_by_user, 'total_paid', true);
$discount_order = get_user_meta(get_current_user_id(), 'discount_order', true);
$discountable = $invited_by_user && $invited_by_user_total_paid > 0 && !$discount_order;
if ($discountable) {
	$discount = get_post_meta(get_the_ID(), 'intro_discount', true);
}

// promotion discount
$promotion_discount_meta = get_user_meta(get_current_user_id(), 'promotion_discount', true);
if ($promotion_discount_meta) {
    $params = explode(' ', $promotion_discount_meta);
    $promotion_discount_expires_at = $params[1];
    if ($promotion_discount_expires_at >= time()) {
        $promotion_discount = $params[0];
        if ($promotion_discount > $discount) {
            $discount = $promotion_discount;
        }
    }
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
        <div class="row" style="margin-top:25px;margin-bottom:25px">
			<?php if (!$invited_by_user): ?>
            <div class="col-sm-4">
                <form method="post" class="invitation_code-form">
                    <input type="text" id="invitation_code-input" name="invitation_code" class="invitation_code-input" placeholder="输入邀请码，获得优惠价格">
                    <input type="submit" id="invitation_code-submit" name="invitation_code_submit" class="invitation_code-submit" value="保存">
                </form>
            </div>
			<?php endif; ?>
			<?php if (!isset($promotion_discount)): ?>
            <div class="col-sm-4">
                <form method="post" class="invitation_code-form">
                    <input type="text" id="promotion_code-input" name="promotion_code" class="invitation_code-input" placeholder="输入优惠码，获得优惠价格">
                    <input type="submit" id="promotion_code-submit" name="promotion_code_submit" class="invitation_code-submit" value="保存">
                </form>
            </div>
            <?php endif; ?>
        </div><!-- End main content row -->

		<div class="row table-row fadeInDown-animation">
            <div class="col-md-offset-2 col-md-4 col-sm-6 table-3 recommended">
                <div class="table">

                    <div class="table-header grad-btn">
                        <p class="text">听说读写大礼包</p><!-- end text -->
                        <p class="price">
                            （价值1600澳币）<br>
							<?php $price = get_post_meta(get_the_ID(), 'price_full', true); if ($discount): ?>
                                <del><?=$price?></del>
                                <span class="price-amount"><?=round($price * (1 - $discount / 100), 2)?></span>
							<?php else: ?>
                                <span class="price-amount"><?=$price?></span>
							<?php endif; ?>
                            $ / 月
                        </p><!-- end price -->
                    </div><!-- end table header -->

                    <div class="table-body">
                        <ul class="features">
                            <li>全站听力口语技巧，模板详解</li>
                            <li>PTE阅读技巧及备考建议</li>
                            <li>PTE写作技巧，范文讲解</li>
                            <li>PTE题型详解+评分细则</li>
                            <li>全站近400道练习题+答案</li>
                            <li>参考笔记，答题要点</li>
                            <li>口语6，7，8分考生真实答案</li>
                        </ul><!-- end features list -->
                    </div><!-- end table body -->

                    <div class="table-footer">
                        <div class="order-btn clearfix">
                            <a href="#payment" data-service="full" class="grad-btn ln-tr show-payment-method">订阅（推荐）</a>
                        </div><!-- end order button -->
                    </div><!-- end table footer -->

                </div><!-- end table -->
            </div><!-- end col-md-3 col-sm-6 -->

            <div class="col-md-4 col-sm-6 table-2 recommended">
                <div class="table">

                    <div class="table-header grad-btn">
                        <p class="text">听力口语技巧+练习包</p><!-- end text -->
                        <p class="price">
                            （价值1200澳币）<br>
							<?php $price = get_post_meta(get_the_ID(), 'price_base', true); if ($discount): ?>
                                <del><?=$price?></del>
                                <span class="price-amount"><?=round($price * (1 - $discount / 100), 2)?></span>
							<?php else: ?>
                                <span class="price-amount"><?=$price?></span>
							<?php endif; ?>
                            $ / 月
                        </p><!-- end price -->
                    </div><!-- end table header -->

                    <div class="table-body">
                        <ul class="features">
                            <li>全站听力口语技巧，模板详解</li>
                            <li>PTE题型详解+评分细则</li>
                            <li>全站近400道练习题+答案</li>
                            <li>参考笔记，答题要点</li>
                            <li>口语6，7，8分考生真实答案</li>
                            <li>听力通用版+高阶版参考答案</li>
                        </ul><!-- end features list -->
                    </div><!-- end table body -->

                    <div class="table-footer">
                        <div class="order-btn">
                            <a href="#payment" data-service="base" class="grad-btn ln-tr show-payment-method">订阅（推荐）</a>
                        </div><!-- end order button -->
                    </div><!-- end table footer -->

                </div><!-- end table -->
            </div><!-- end col-md-3 col-sm-6 -->

            <div class="clearfix" style="margin:20px"></div>

            <div class="col-md-3 col-sm-6 table-2">
                <div class="table">

                    <div class="table-header grad-btn">
                        <p class="text">听力口语技巧包</p><!-- end text -->
                        <p class="price">
                            <span class="price-amount"><?=get_post_meta(get_the_ID(), 'price_tips', true)?></span>
                            $ / 月
                        </p><!-- end price -->
                    </div><!-- end table header -->

                    <div class="table-body">
                        <ul class="features">
                            <li>全站听力技巧，模板详解</li>
                            <li>全站口语技巧，模板详解</li>
                            <li>PTE题型详解+评分细则</li>
                            <li>全站听力口语例题+参考答案</li>
                        </ul><!-- end features list -->
                    </div><!-- end table body -->

                    <div class="table-footer">
                        <div class="order-btn">
                            <a href="#payment" data-service="tips" class="grad-btn ln-tr show-payment-method">订阅</a>
                        </div><!-- end order button -->
                    </div><!-- end table footer -->

                </div><!-- end table -->
            </div><!-- end col-md-3 col-sm-6 -->

            <div class="col-md-3 col-sm-6 table-2">
                <div class="table">

                    <div class="table-header grad-btn">
                        <p class="text">听力口语练习包</p><!-- end text -->
                        <p class="price">
                            <span class="price-amount"><?=get_post_meta(get_the_ID(), 'price_exercises', true)?></span>
                            $ / 月
                        </p><!-- end price -->
                    </div><!-- end table header -->

                    <div class="table-body">
                        <ul class="features">
                            <li>全站近400道练习题+答案</li>
                            <li>参考笔记，答题要点</li>
                            <li>口语6，7，8分考生真实答案</li>
                            <li>听力通用版+高阶版参考答案</li>
                        </ul><!-- end features list -->
                    </div><!-- end table body -->

                    <div class="table-footer">
                        <div class="order-btn">
                            <a href="#payment" data-service="exercises" class="grad-btn ln-tr show-payment-method">订阅</a>
                        </div><!-- end order button -->
                    </div><!-- end table footer -->

                </div><!-- end table -->
            </div><!-- end col-md-3 col-sm-6 -->

            <div class="col-md-3 col-sm-6 table-1">
				<div class="table">

					<div class="table-header grad-btn">
						<div class="icon ln-tr"><i class="fa fa-book"></i></div><!-- end icon -->
						<p class="text">阅读技巧包</p><!-- end text -->
					</div><!-- end table header -->

					<div class="table-body">
						<ul class="features">
							<li>PTE阅读题型详解</li>
							<li>PTE阅读技巧详解</li>
							<li>PTE阅读例题详解</li>
                            <li>句子精读详解</li>
                            <li>推荐词汇讲解</li>
						</ul><!-- end features list -->
					</div><!-- end table body -->

					<div class="table-footer">
						<div class="order-btn">
							<a href="#payment" data-service="reading" class="grad-btn ln-tr show-payment-method">
                                <span class="price-amount"><?=get_post_meta(get_the_ID(), 'price_reading', true)?></span>
                                <span class="currency">$ / 次</span>
								<span class="icon fr ln-tr"><i class="fa fa-angle-right"></i></span>
							</a>
						</div><!-- end order button -->
					</div><!-- end table footer -->

				</div><!-- end table -->
			</div><!-- end col-md-3 col-sm-6 -->

			<div class="col-md-3 col-sm-6 table-1">
				<div class="table">

					<div class="table-header grad-btn">
						<div class="icon ln-tr"><i class="fa fa-pencil"></i></div><!-- end icon -->
						<p class="text">写作技巧包</p><!-- end text -->
					</div><!-- end table header -->

					<div class="table-body">
						<ul class="features">
							<li>PTE写作题型详解</li>
							<li>PTE写作技巧模板详解</li>
							<li>PTE小作文例题</li>
                            <li>PTE大作文范文</li>
						</ul><!-- end features list -->
					</div><!-- end table body -->

					<div class="table-footer">
						<div class="order-btn">
							<a href="#payment" data-service="writing" class="grad-btn ln-tr show-payment-method">
                                <span class="price-amount"><?=get_post_meta(get_the_ID(), 'price_writing', true)?></span> <span class="currency">$ / 次</span>
								<span class="icon fr ln-tr"><i class="fa fa-angle-right"></i></span>
							</a>
						</div><!-- end order button -->
					</div><!-- end table footer -->

				</div><!-- end table -->
			</div><!-- end col-md-3 col-sm-6 -->

        </div><!-- end 1st row -->

        <div id="payment"></div>

        <div class="row payment-gateways" style="display: none;">
            <div class="col-sm-4"><a href="" id="alipay" class="gateway" data-gateway="alipay"><img src="<?=get_stylesheet_directory_uri()?>/assets/img/icons/alipay.png"></a></div>
            <div class="col-sm-4"><a href="" id="wechatpay" class="gateway" data-gateway="wechatpay"><img src="<?=get_stylesheet_directory_uri()?>/assets/img/icons/wechatpay.png"></a></div>
            <div class="col-sm-4"><a href="" id="paypal" class="gateway" data-gateway="paypal"><img src="<?=get_stylesheet_directory_uri()?>/assets/img/icons/paypal.png"></a></div>
        </div>

	</div><!-- end container -->
</section><!-- end pricing section -->

<script type="text/javascript">
jQuery(function ($) {

    var price, subject, service, expiresAt, lastDay;

    $('.show-payment-method').on('click', function (e) {
        $('.payment-gateways').hide(300).show(300);
        price = $(this).parents('.table').find('.price-amount').text();
        subject = $(this).parents('.table').find('.table-header>.text').text();
        service = $(this).data('service');

        if (service !== 'reading' && service !== 'writing') {
            lastDay = new Date((new Date()).getTime() + 30 * 86400000);
        }
        else {
            lastDay = null;
        }
    });

    $('.payment-gateways .gateway').on('click', function (e) {
        var href, gateway;
        e.preventDefault();

        gateway = $(this).data('gateway');

        if (lastDay) {
            subject += ' 至' + lastDay.format();
            expiresAt = (new Date(lastDay.getTime() + 86400000)).format();
        }

        href = '/payment/' + gateway + '/?price='+ price
            + '&subject=' + (subject)
            + '&service=' + (service)
            + '&intend=' + ('<?=$_GET['intend']?>');

        if (expiresAt) {
            href += '&expires_at=' + expiresAt;
        }

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
