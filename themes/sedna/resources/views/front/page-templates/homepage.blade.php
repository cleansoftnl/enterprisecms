@extends('webed-theme::front._master')

@section('content')
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="hero-content text-center">
                        <h1>{{ get_field($object, 'big_title') }}</h1>
                        <p class="intro">{{ get_field($object, 'intro_text') }}</p>
                        <a href="{{ get_field($object, 'download_link') }}"
                           target="_blank"
                           class="btn btn-fill btn-large btn-margin-right">
                            Download
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="intro section-padding">
        <div class="container">
            <div class="row">

                    <div class="col-md-4 intro-feature">
                        <div class="intro-icon">
                            <span data-icon="icon" class="icon"></span>
                        </div>
                        <div class="intro-content">
                            <h5>title</h5>
                            <p>&nbsp;</p>
                        </div>
                    </div>

            </div>
        </div>
    </section>

    <section class="features section-padding" id="features">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-md-offset-7">
                    <div class="feature-list">
                        <h3>title</h3>
                        <p>Intro</p>
                        <ul class="features-stack">

                                <li class="feature-item">
                                    <div class="feature-icon">
                                        <span data-icon="icon" class="icon"></span>
                                    </div>
                                    <div class="feature-content">
                                        <h5>title</h5>
                                        <p>txt</p>
                                    </div>
                                </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="device-showcase">
            <div class="devices">
                <div class="ipad-wrap wp1"></div>
                <div class="iphone-wrap wp2"></div>
            </div>
        </div>
        <div class="responsive-feature-img"><img src="{{ asset('themes/sedna/img/devices.png') }}"
                                                 alt="responsive devices">
        </div>
    </section>

    <section class="features-extra section-padding" id="assets">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="feature-list">
                        list
                    </div>
                </div>
            </div>
        </div>
        <div class="macbook-wrap wp3"></div>
        <div class="responsive-feature-img"><img src="{{ asset('themes/sedna/img/macbook-pro.png') }}"
                                                 alt="responsive devices"></div>
    </section>

    <section class="hero-strip section-padding">
        <div class="container">
            <div class="col-md-12 text-center">
                <h2>
                    Customise Sedna with the included <span class="sketch">Sketch <i class="version">3</i></span> file
                </h2>
                <p>Change/swap/edit every aspect of Sedna before you hit development with the included Sketch file.</p>
                <a href="#" class="btn btn-ghost btn-accent btn-large">Download now!</a>
                <div class="logo-placeholder floating-logo"><img src="{{ asset('themes/sedna/img/sketch-logo.png') }}"
                                                                 alt="Sketch Logo"></div>
            </div>
        </div>
    </section>
    <section class="blog-intro section-padding" id="blog">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3>title</h3>
                </div>
            </div>
            <div class="row">
            </div>
        </div>
    </section>
    <section class="testimonial-slider section-padding text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flexslider">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="sign-up section-padding text-center" id="download">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h3>Get started with Sedna, absolutely free</h3>
                    <p>Grab your copy today, exclusively from Codrops</p>
                    <div class="signup-form">
                        <div class="form-input-group">
                            <i class="fa fa-envelope"></i>
                            <input type="text" class="" placeholder="Enter your email" required>
                        </div>
                        <div class="form-input-group">
                            <i class="fa fa-lock"></i>
                            <input type="text" class="" placeholder="Enter your password" required>
                        </div>
                        <button type="submit" class="btn-fill sign-up-btn">Sign up for free</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="to-top">
        <div class="container">
            <div class="row">
                <div class="to-top-wrap">
                    <a href="#top" class="top"><i class="fa fa-angle-up"></i></a>
                </div>
            </div>
        </div>
    </section>
@endsection