<?php get_header(); the_post(); ?>

<div class="inner-head">
    <div class="container">
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <p class="description">
            <?php the_subtitle(); ?>
        </p>
    </div><!-- End container -->
</div><!-- End Inner Page Head -->

<div class="clearfix"></div>

<article class="contact fadeInDown-animation">
    <div class="big-map">
        <div id="contact-map" class="full-map"></div>
    </div><!-- End Big Map -->
    <div class="contact-container container">
        <div class="row">
            <div class="col-md-8">
                <div class="contact-left">
                    <span class="contact-form-icon"><i class="fa fa-envelope"></i></span>
                    <h5 class="contact-title ib"><?=__('联系我们', 'bingo')?></h5>
                    <div class="contact-text">
                        <p>
							<?=get_post_meta(get_the_ID(), 'contact_form_description', true)?>
                        </p>
                    </div><!-- End text -->
                    <div class="contact-form">
                        <form method="post" action="" id="contact-form">
                            <div class="row">
                                <?php the_content(); ?>
                            </div><!-- end row -->
                        </form><!-- end form tag -->
                    </div><!-- end contact form -->
                </div><!-- End contact left -->
            </div><!-- end col-md-8 -->
            <div class="col-md-4">
                <div class="contact-right sidebar">
                    <div class="sidebar-widget contact-info">
                        <span class="widget-icon"><i class="fa fa-book"></i></span>
                        <h5 class="sidebar-widget-title ib"><?=__('联络方式', 'bingo')?></h5>
                        <div class="info-text">
                            <p>
								<?=get_post_meta(get_the_ID(), 'contact_description', true)?>
                            </p>
                        </div><!-- end text info -->
                        <div class="call">
                            <?php
                                $email = get_post_meta(get_the_ID(), 'email', true);
                                $facebook = get_post_meta(get_the_ID(), 'facebook', true);
							    $weibo = get_post_meta(get_the_ID(), 'weibo', true);
                            ?>
                            <p><?=__('咨询：', 'bingo')?><a href="mailto:<?=$email?>"><?=$email?></a></p>
                            <p><?=__('合作：', 'bingo')?><a href="mailto:cooperation@bingotraining.com">cooperation@bingotraining.com</a></p>
                            <?php if ($facebook): ?><p><i class="fa fa-facebook" style="width:2em;text-align:center"></i>: <a href="<?=$facebook?>" target="_blank">@BingoTraining</a></p><?php endif; ?>
                            <?php if ($weibo): ?><p><i class="fa fa-weibo" style="width:2em;text-align:center"></i>: <a href="<?=$weibo?>">@BingoTraining</a></p><?php endif; ?>
                        </div><!-- end call info -->
                    </div><!-- end 1st block -->
                </div><!-- End contact right -->
            </div><!-- end col-md-4 -->
        </div><!-- end row -->
    </div><!-- end contact container -->
</article><!-- End Single Article -->

<!-- start google maps code -->
<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCuo-7pilc2gDxQT8rzArOrcrQvm4N6yZk&sensor=false&extension=.js'></script>
<script>
    google.maps.event.addDomListener(window, 'load', init);
    var map;
    function init() {
        var mapOptions = {
            center: new google.maps.LatLng(<?=get_post_meta(get_the_ID(), 'location', true)?>),
            zoom: 12,
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL
            },
            disableDoubleClickZoom: true,
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
            },
            scaleControl: false,
            scrollwheel: false,
            panControl: false,
            streetViewControl: false,
            draggable : true,
            overviewMapControl: false,
            overviewMapControlOptions: {
                opened: false
            },
            mapTypeId: google.maps.MapTypeId.TERRAIN
        };
        var mapElement = document.getElementById('contact-map');
        var map = new google.maps.Map(mapElement, mapOptions);
        var locations = [
            ['Coursaty', 'Welcome To Coursaty!', '002-0100-123456', 'contact@coursaty.com', 'http://iSeada.com', 30.792357,  -329.027998, 'https://mapbuildr.com/assets/img/markers/default.png']
        ];
        for (i = 0; i < locations.length; i++) {
            if (locations[i][1] =='undefined'){ description ='';} else { description = locations[i][1];}
            if (locations[i][2] =='undefined'){ telephone ='';} else { telephone = locations[i][2];}
            if (locations[i][3] =='undefined'){ email ='';} else { email = locations[i][3];}
            if (locations[i][4] =='undefined'){ web ='';} else { web = locations[i][4];}
            if (locations[i][7] =='undefined'){ markericon ='';} else { markericon = locations[i][7];}
            marker = new google.maps.Marker({
                icon: markericon,
                position: new google.maps.LatLng(locations[i][5], locations[i][6]),
                map: map,
                title: locations[i][0],
                desc: description,
                tel: telephone,
                email: email,
                web: web
            });
            link = '';     }

    }
</script>
<!-- end google maps code -->

<?php get_footer(); ?>

