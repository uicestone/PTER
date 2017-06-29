<?php get_header(); ?>

<div class="inner-head">
    <div class="container">
        <h1 class="entry-title">We Wanna Hear From You!</h1>
        <p class="description">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem quam, adipiscing condimentum tristique vel, eleifend sed turpis. Pellentesque cursus arcu id magna euismod in elementum purus molestie.
        </p>
        <div class="breadcrumb">
            <ul class="clearfix">
                <li class="ib"><a href="">Home</a></li>
                <li class="ib"><a href="">Blog</a></li>
                <li class="ib current-page"><a href="">Login</a></li>
            </ul>
        </div>
    </div><!-- End container -->
</div><!-- End Inner Page Head -->

<div class="clearfix"></div>

<section class="login-page fadeInDown-animation">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="login-form">
                    <div class="login-title">
                        <span class="icon"><i class="fa fa-group"></i></span>
                        <span class="text">Login Area</span>
                    </div><!-- End Title -->
                    <form method="post" action="/" id="login-form">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="input">
                                    <input type="text" id="login_username" class="username-input" placeholder="User Name">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="input">
                                    <input type="password" id="login_password" class="password-input" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input clearfix">
                                    <input type="submit" id="login_submit" class="submit-input grad-btn ln-tr" value="Login">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 clearfix">
                                <div class="custom-checkbox fl">
                                    <input type="checkbox" id="login_remember" class="checkbox-input" checked>
                                    <label for="login_remember">Remember Password</label>
                                </div>
                            </div><!-- end remember -->
                            <div class="col-md-6 col-sm-6 clearfix">
                                <div class="forgot fr">
                                    <a href="#" class="new-user">Create New Account</a> / <a href="#" class="reset">Forget Password ?</a>
                                </div>
                            </div><!-- end forgot password -->
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
</section><!-- End Login Page -->

<?php get_footer(); ?>
