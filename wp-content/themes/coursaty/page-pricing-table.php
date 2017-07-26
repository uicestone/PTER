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
            <div class="col-sm-4">
				<?php if (!get_user_meta(get_current_user_id(), 'invited_by_user', true)): ?>
                <form method="post" class="invitation_code-form">
                    <input type="text" id="invitation_code-input" name="invitation_code" class="invitation_code-input" placeholder="输入邀请码获得优惠价格">
                    <input type="submit" id="invitation_code-submit" name="invitation_code_submit" class="invitation_code-submit" value="保存">
                </form>
				<?php endif; ?>
            </div>
        </div><!-- End main content row -->

		<div class="row table-row fadeInDown-animation">
            <div class="col-md-offset-2 col-md-4 col-sm-6 table-3 recommended">
                <div class="table">

                    <div class="table-header grad-btn">
                        <p class="text">听说读写大礼包</p><!-- end text -->
                        <p class="price">
							<?php $price = get_post_meta(get_the_ID(), 'price_full', true); if ($discountable): ?>
                                <del><?=$price?></del>
                                <span class="price-amount"><?=round($price * (1 - get_post_meta(get_the_ID(), 'intro_discount', true) / 100), 2)?></span>
							<?php else: ?>
                                <span class="price-amount"><?=$price?></span>
							<?php endif; ?>
                            $ / 月
                        </p><!-- end price -->
                    </div><!-- end table header -->

                    <div class="table-body">
                        <ul class="features">
                            <li>全站听力口语技巧详解</li>
                            <li>PTE阅读写作技巧</li>
                            <li>全站听力口语练习题</li>
                            <li>PTE题型讲解</li>
                            <li>PTE评分细则</li>
                            <li>PTE推荐联系材料</li>
                        </ul><!-- end features list -->
                    </div><!-- end table body -->

                    <div class="table-footer">
                        <div class="order-btn clearfix">
                            <a href="#payment" data-service="full" class="grad-btn ln-tr show-payment-method">推荐购买</a>
                        </div><!-- end order button -->
                    </div><!-- end table footer -->

                </div><!-- end table -->
            </div><!-- end col-md-3 col-sm-6 -->

            <div class="col-md-4 col-sm-6 table-2">
                <div class="table">

                    <div class="table-header grad-btn">
                        <p class="text">听力口语技巧+练习包</p><!-- end text -->
                        <p class="price">
							<?php $discountable = get_user_meta(get_current_user_id(), 'invited_by_user', true) && !get_user_meta(get_current_user_id(), 'discount_order', true)?>
							<?php $price = get_post_meta(get_the_ID(), 'price_base', true); if ($discountable): ?>
                                <del><?=$price?></del>
                                <span class="price-amount"><?=round($price * (1 - get_post_meta(get_the_ID(), 'intro_discount', true) / 100), 2)?></span>
							<?php else: ?>
                                <span class="price-amount"><?=$price?></span>
							<?php endif; ?>
                            $ / 月
                        </p><!-- end price -->
                    </div><!-- end table header -->

                    <div class="table-body">
                        <ul class="features">
                            <li>全站口语技巧例题详解</li>
                            <li>全站听力技巧例题详解</li>
                            <li>口语听力全套练习及参考答案</li>
                            <li>PTE题型讲解</li>
                            <li>PTE推荐练习材料</li>
                        </ul><!-- end features list -->
                    </div><!-- end table body -->

                    <div class="table-footer">
                        <div class="order-btn">
                            <a href="#payment" data-service="base" class="grad-btn ln-tr show-payment-method">推荐购买</a>
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
                            <li>全站口语技巧例题详解</li>
                            <li>全站听力技巧例题详解</li>
                            <li>PTE题型讲解</li>
                            <li>PTE评分细则</li>
                            <li>PTE推荐练习材料</li>
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
                            <li>Read Aloud 32题，含6，7，8分参考答案</li>
                            <li>Repeat Sentence 100题</li>
                            <li>Describe Image 100题，含8分参考答案</li>
                            <li>Retell Lecture 15题，含笔记和参考答案</li>
                            <li>Write from dictation 70题，Highlight Incorrect Words 15题</li>
                            <li>Summarise Spoken Text 15题，含通用和高级版本答案</li>
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
        $('.recommended a').trigger('hover');
    }, 1000);

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
