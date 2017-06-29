<?php get_header(); ?>

<div class="inner-head">
    <div class="container">
        <h1 class="entry-title">Register new member</h1>
        <p class="description">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem quam, adipiscing condimentum tristique vel, eleifend sed turpis. Pellentesque cursus arcu id magna euismod in elementum purus molestie.
        </p>
        <div class="breadcrumb">
            <ul class="clearfix">
                <li class="ib"><a href="">Home</a></li>
                <li class="ib"><a href="">Blog</a></li>
                <li class="ib current-page"><a href="">Register</a></li>
            </ul>
        </div>
    </div><!-- End container -->
</div><!-- End Inner Page Head -->

<div class="clearfix"></div>

<section class="login-page fadeInDown-animation">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="login-form register">
                    <div class="login-title">
                        <span class="icon"><i class="fa fa-group"></i></span>
                        <span class="text">Register</span>
                    </div><!-- End Title -->
                    <form method="post" action="/" id="register-form">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="input">
                                    <input type="text" id="reg_username" class="username-input" placeholder="User Name">
                                </div>
                            </div><!-- end username -->
                            <div class="col-md-6 col-sm-6">
                                <div class="input">
                                    <input type="email" id="reg_email" class="email-input" placeholder="Email">
                                </div>
                            </div><!-- end email -->
                            <div class="col-md-6 col-sm-6">
                                <div class="input">
                                    <input type="password" id="reg_password" class="password-input" placeholder="Password">
                                </div>
                            </div><!-- end password -->
                            <div class="col-md-6 col-sm-6">
                                <div class="input">
                                    <input type="password" id="reg_confirm-password" class="confirm-password-input" placeholder="Confirm Password">
                                </div>
                            </div><!-- end confirm password -->
                            <div class="col-md-12">
                                <div class="input clearfix">
                                    <input type="submit" id="reg_submit" class="submit-input grad-btn ln-tr" value="Register">
                                </div>
                            </div><!-- end submit -->
                        </div><!-- end row -->
                    </form><!-- End form -->
                </div><!-- end login form -->
                <div class="login-options">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <a href="#" class="login-op-btn grad-btn ln-tr fb">Login with Facebook Account</a>
                        </div><!-- end FB login -->
                        <div class="col-md-6 col-sm-6">
                            <a href="#" class="login-op-btn grad-btn ln-tr gp">Login with Google Account</a>
                        </div><!-- end GP login -->
                        <div class="col-md-6 col-sm-6">
                            <a href="#" class="login-op-btn grad-btn ln-tr tw">Login with Twitter Account</a>
                        </div><!-- end TW login -->
                        <div class="col-md-6 col-sm-6">
                            <a href="#" class="login-op-btn grad-btn ln-tr ya">Login with Yahoo Account</a>
                        </div><!-- end YA login -->
                    </div>
                </div><!-- end login optionss -->
            </div><!-- end col-md-8/offset -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- End Register Page -->

<?php get_footer(); ?>
