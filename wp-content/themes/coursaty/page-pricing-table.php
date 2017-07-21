<?php get_header(); the_post() ?>

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
        <div style="margin:50px 0">
			<?php the_content(); ?>
        </div><!-- End main content row -->
		<div class="row table-row fadeInDown-animation table-1">
			<div class="col-md-3 col-sm-6 table-2">
				<div class="table">

					<div class="table-header grad-btn">
						<p class="text">听说基础包</p><!-- end text -->
						<p class="price">20 $ / 月</p><!-- end price -->
					</div><!-- end table header -->

					<div class="table-body">
						<ul class="features">
							<li>全站口语技巧浏览</li>
							<li>全站口语练习实践</li>
							<li>全站听力技巧浏览</li>
							<li>全站听力练习实践</li>
							<li>30天有效期</li>
						</ul><!-- end features list -->
					</div><!-- end table body -->

					<div class="table-footer">
						<div class="order-btn">
							<a href="#payment" data-price="20" data-subject="听说基础包30天" class="grad-btn ln-tr show-payment-method">订阅</a>
						</div><!-- end order button -->
					</div><!-- end table footer -->

				</div><!-- end table -->
			</div><!-- end col-md-3 col-sm-6 -->

			<div class="col-md-3 col-sm-6 table-3">
				<div class="table">

					<div class="table-header grad-btn">
						<p class="text">听说读写套餐</p><!-- end text -->
						<p class="price">30 $ / 月</p><!-- end price -->
					</div><!-- end table header -->

					<div class="table-body">
						<ul class="features">
							<li>全站口语技巧和练习</li>
							<li>全站听力技巧和练习</li>
							<li>一次阅读视频讲解</li>
							<li>一次写作视频讲解</li>
							<li>30天有效期</li>
						</ul><!-- end features list -->
					</div><!-- end table body -->

					<div class="table-footer">
						<div class="order-btn clearfix">
							<a href="#payment" data-price="30" data-subject="听说读写套餐30天" class="grad-btn ln-tr show-payment-method">订阅</a>
						</div><!-- end order button -->
					</div><!-- end table footer -->

				</div><!-- end table -->
			</div><!-- end col-md-3 col-sm-6 -->

			<div class="col-md-3 col-sm-6">
				<div class="table">

					<div class="table-header grad-btn">
						<div class="icon ln-tr"><i class="fa fa-book"></i></div><!-- end icon -->
						<p class="text">阅读拓展包</p><!-- end text -->
					</div><!-- end table header -->

					<div class="table-body">
						<ul class="features" style="padding: 51px 0 50px">
							<li>超过3小时视频讲解PTE阅读</li>
							<li>视频全程大纲</li>
							<li>24小时学习时间</li>
						</ul><!-- end features list -->
					</div><!-- end table body -->

					<div class="table-footer">
						<div class="order-btn">
							<a href="#payment" data-price="10" data-subject="阅读拓展包" class="grad-btn ln-tr show-payment-method">10 <span class="currency">$ / 次</span>
								<span class="icon fr ln-tr"><i class="fa fa-angle-right"></i></span>
							</a>
						</div><!-- end order button -->
					</div><!-- end table footer -->

				</div><!-- end table -->
			</div><!-- end col-md-3 col-sm-6 -->

			<div class="col-md-3 col-sm-6">
				<div class="table">

					<div class="table-header grad-btn">
						<div class="icon ln-tr"><i class="fa fa-pencil"></i></div><!-- end icon -->
						<p class="text">写作拓展包</p><!-- end text -->
					</div><!-- end table header -->

					<div class="table-body">
						<ul class="features" style="padding: 48px 0 47px">
							<li>超过3小时视频讲解PTE写作</li>
							<li>视频全程大纲</li>
							<li>24小时学习时间</li>
						</ul><!-- end features list -->
					</div><!-- end table body -->

					<div class="table-footer">
						<div class="order-btn">
							<a href="#payment" data-price="10" data-subject="写作拓展包" class="grad-btn ln-tr show-payment-method">10 <span class="currency">$ / 次</span>
								<span class="icon fr ln-tr"><i class="fa fa-angle-right"></i></span>
							</a>
						</div><!-- end order button -->
					</div><!-- end table footer -->

				</div><!-- end table -->
			</div><!-- end col-md-3 col-sm-6 -->

		</div><!-- end 1st row -->

        <div id="payment" class="row payment-gateways" style="display: none;">
            <div class="col-sm-4"><a href="#" id="alipay"><img src="<?=get_stylesheet_directory_uri()?>/assets/img/icons/alipay.png"></a></div>
            <div class="col-sm-4"><a href="#" id="wechatpay"><img src="<?=get_stylesheet_directory_uri()?>/assets/img/icons/wechatpay.png"></a></div>
            <div class="col-sm-4"><a href="#" id="paypal"><img src="<?=get_stylesheet_directory_uri()?>/assets/img/icons/paypal.png"></a></div>
        </div>

	</div><!-- end container -->
</section><!-- end pricing section -->

<script type="text/javascript">
jQuery(function ($) {

    var price, subject, expiresAt, lastDay;

    $('.show-payment-method').on('click', function (e) {
        $('.payment-gateways').hide(300).show(300);
        price = $(this).data('price');
        subject = $(this).data('subject');
        var matchDays = subject.match(/(\d+)天/);
        if (matchDays) {
            lastDay = new Date((new Date()).getTime() + matchDays[1] * 86400000);
        }
        else {
            lastDay = null;
        }
    });

    $('#alipay').on('click', function (e) {
        var href;
        e.preventDefault();

        if (lastDay) {
            subject += '至' + lastDay.format();
            expiresAt = (new Date(lastDay.getTime() + 86400000)).format();
        }

        window.location.href = '/payment/alipay/?price='+ price
            + '&subject=' + encodeURIComponent(subject)
            + '&expires_at=' + expiresAt;
    });

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
