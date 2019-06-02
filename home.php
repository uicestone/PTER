<?php
$banners = get_posts(array('category_name' => 'headline'));
$banner_links = array_map(function ($banner) {
	$text = get_post_meta($banner->ID, 'button_text', true);
	$link = get_post_meta($banner->ID, 'button_link', true);
	return compact('text', 'link');
}, $banners);
get_header(); ?>

<div class="tp-banner-container">
    <div class="tp-banner">
        <ul>
            <?php foreach ($banners as $index => $banner): ?>
            <li data-transition="random" data-slotamount="7" data-masterspeed="1500">
                <!-- MAIN IMAGE -->
                <?=get_the_post_thumbnail($banner, 'headline', array('alt' => 'slidebg' . ($index + 1), 'data-bgfit' => 'cover', 'data-bgposition' => 'left top', 'data-bgrepeat' => 'no-repeat'))?>
                <!-- LAYERS -->
                <!-- LAYER NR. 1 -->
                <div class="tp-caption sft skewtoleft tp-resizeme start white"
                    data-y="245"
                    data-x="center"
                    data-hoffset="0"
                    data-start="300"
                    data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                    data-speed="500"
                    data-easing="Power3.easeInOut"
                    data-endspeed="300"
                    style="z-index: 2">
                    <h2 class="slide-title"><?=get_the_title($banner)?></h2>
                </div>
                <!-- LAYER NR. 2 -->
                <div class="tp-caption black randomrotate skewtoleft tp-resizeme start"
                    data-x="center"
                    data-hoffset="0"
                    data-y="270"
                    data-speed="500"
                    data-start="1300"
                    data-easing="Power3.easeInOut"
                    data-splitin="none"
                    data-splitout="none"
                    data-elementdelay="0.1"
                    data-endelementdelay="0.1"
                    data-endspeed="500" style="z-index: 99; white-space: pre-line;">
                    <p class="slide-description"><?=get_the_subtitle($banner)?></p>
                </div>
                <div class="tp-caption black randomrotate skewtoleft tp-resizeme start"
                     data-x="center"
                     data-hoffset="0"
                     data-y="430"
                     data-speed="500"
                     data-start="1300"
                     data-easing="Power3.easeInOut"
                     data-splitin="none"
                     data-splitout="none"
                     data-elementdelay="0.1"
                     data-endelementdelay="0.1"
                     data-endspeed="500" style="z-index:99">
					<?php foreach ($banner_links as $banner_link): ?>
					<a href="<?=$banner_link['link']?>" class="btn"><?=$banner_link['text']?></a>
					<?php endforeach; ?>
                </div>
            </li>
            <?php endforeach; ?>
        </ul><!-- end ul elements -->
    </div><!-- end tp-banner -->
</div><!-- End Home Slider Container -->

<?php foreach ($banners as $index => $banner): ?>
<section class="full-section banner" style="background-image:url('<?=get_the_post_thumbnail_url($banner, 'large')?>')">
    <div class="container">
        <h3 class="section-title"><?=get_the_title($banner)?></h3>
        <p class="section-description">
			<?=get_the_subtitle($banner)?>
        </p><!-- End Section Description -->
        <div class="banner-actions">
            <a href="<?=$banner_links[$index]['link']?>" class="btn"><?=$banner_links[$index]['text']?></a>
        </div>
    </div>
</section>
<div class="clearfix"></div>
<?php endforeach; ?>

<section class="full-section features-section fancy-shadow pricing-tables">
    <div class="table-row">
		<?php foreach(get_posts(array('post_type'=>'subscribe', 'posts_per_page'=>-1)) as $index => $subscribe_post): ?>
		<?php
		$question_types = get_field('grant_permissions_question_types', $subscribe_post->ID);
		$products_in_subscription = array_column($question_types, 'slug');
		?>
		<div class="<?=get_field('recommended', $subscribe_post->ID)?'table-3 recommended':'table-2'?>">
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
						<a href="<?=pll_home_url()?>pricing-table/?products=<?=implode(',', $products_in_subscription)?>&id=<?=$subscribe_post->ID?>" data-products="<?=implode(',', $products_in_subscription)?>" data-gateway-account="<?=get_post_meta($subscribe_post->ID, 'payment_gateway', true)?>" class="grad-btn ln-tr show-payment-method"><?=__('订阅', 'bingo')?></a>
					</div><!-- end order button -->
				</div><!-- end table footer -->

			</div><!-- end table -->
		</div>
		<?php endforeach; ?>
    </div>
</section><!-- End Features Section -->

<?php $welcome_pages = get_posts(array('post_type' => 'page', 'name' => 'welcome')); if ($welcome_pages): $welcome_page = $welcome_pages[0]; ?>
<section class="full-section features-section fancy-shadow">
    <div class="container">
        <h3 class="section-title"><?=get_the_title($welcome_page)?></h3>
        <p class="section-description">
            <?=get_the_subtitle($welcome_page)?>
        </p><!-- End Section Description -->
        <p>
			<a href="<?=site_url()?>/pricing-table/" class="btn subscribe"><?=sprintf(__('立即订阅%s', 'bingo'), 'PTE')?></a>
			<a href="<?=site_url()?>/pricing-table/?ccl" class="btn subscribe"><?=sprintf(__('立即订阅%s', 'bingo'), 'CCL')?></a>
		</p>
    </div>
    <div class="section-content features-content fadeInDown-animation">
        <div class="container">
            <div class="row">
	            <?php foreach (get_posts(array('category_name' => 'service')) as $service): ?>
                <div class="col-md-3 col-xs-6">
                    <div class="feature-box">
                        <div class="icon">
                            <?=get_the_post_thumbnail($service, 'thumbnail', array('class' => 'es-tr'))?>
                        </div><!-- End Icon -->
                        <h5 class="feature-title"><?=get_the_title($service)?></h5>
                        <p class="feature-description">
                            <?=wpautop($service->post_excerpt)?>
                        </p>
                    </div><!-- End Features Box -->
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div><!-- End Features Section Content -->
</section><!-- End Features Section -->

<div class="clearfix"></div>
<?php endif; ?>

<?php $recommended_posts = get_posts(array('post_type' => array('post', 'tip'), 'tag' => 'recommended', 'posts_per_page' => 4, 'orderby' => 'menu_order', 'order' => 'asc')); if ($recommended_posts): ?>
<section class="full-section instructors-section fancy-shadow">
    <div class="container">
        <h3 class="section-title"><?=__('推荐阅读', 'bingo')?></h3>
        <p class="section-description">

        </p><!-- End Section Description -->
    </div>
    <div class="section-content instructors-content fadeInDown-animation">
        <div class="container">
            <div class="row">
                <?php foreach ($recommended_posts as $recommended_post): ?>
                <div class="col-md-3 col-xs-6">
                    <div class="instructor">
                        <div class="avatar">
                            <a href="<?=get_permalink($recommended_post)?>"><?=get_the_post_thumbnail($recommended_post, 'mentor', array('class' => 'img-responsive'))?></a>
                        </div><!-- End Avatar -->
                        <div class="instructor-info">
                            <p class="name"><a href="<?=get_permalink($recommended_post)?>"><?=get_the_title($recommended_post)?></a></p>
                            <span class="position"><?=get_the_subtitle($recommended_post)?></span>
                        </div>
                    </div><!-- End Instructor Box -->
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div><!-- End Instructors Section Content -->
</section><!-- End Our Instructors Container -->
<?php endif; ?>

<?php get_footer(); ?>

