<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class TVC_Pricings
{
    protected $TVC_Admin_Helper = "";
    protected $url = "";
    protected $subscriptionId = "";
    protected $google_detail;
    protected $customApiObj;
    protected $pro_plan_site;
    protected $convositeurl;

    public function __construct()
    {
        $this->TVC_Admin_Helper = new TVC_Admin_Helper();
        $this->customApiObj = new CustomApi();
        $this->subscriptionId = $this->TVC_Admin_Helper->get_subscriptionId();
        $this->google_detail = $this->TVC_Admin_Helper->get_ee_options_data();
        $this->TVC_Admin_Helper->add_spinner_html();
        $this->pro_plan_site = $this->TVC_Admin_Helper->get_pro_plan_site();
        $this->convositeurl = "http://conversios.io";
        $this->create_form();
    }

    public function create_form()
    {
        $close_icon = esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/close.png');
        $check_icon = esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/check.png');
        $conversios_site_url = "https://www.conversios.io";
?>


<div class="convo-global">
    <div class="convo-pricingpage">
        <!-- pricing timer -->
        <div class="pricing-timer d-none">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="timer-box">
                                    <div id="time"> <span id="min">00</span>:<span id="sec">00</span></div>
                                </div>
                                <h5 class="card-title">Wait! Get 10% Off</h5>
                                <p class="card-text">Purchase any yearly plan in next 10 minutes with coupon code
                                    <strong>FIRSTBUY10</strong> and get additional 10% off.
                                </p>
                                <a class="btn btn-secondary common-btn"
                                    href="<?php echo esc_url_raw($conversios_site_url . "/checkout?pid=planD_1_y"); ?>">
                                    Get It Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- business area -->
        <div class="business-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="title-text">
                            <h4>Get <mark> 15 days money back guarantee </mark> on any plan you choose.</h4>
                            <h2>WooCommerce for Marketing & Analytics</h2>
                            <h3>Find the perfect plan to supercharge your WooCommerce store.</h3>
                        </div>
                    </div>
                </div>
                <div class="myplan-wholebox">
                    <div class="row align-items-end">
                        <div class="col-auto me-auto">
                            <div class="myplan-box">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" checked type="checkbox" role="switch"
                                        id="yearmonth_checkbox">
                                </div>
                                <p>Monthly | <span>Yearly</span> Get Flat 50% off on all yearly plans. </p>
                            </div>
                        </div>
                        <div class="col-auto ">
                            <div class="domain-box">
                                <p>Select Number Of Domains</p>
                                <div class="choose-domainbox">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                            id="inlineRadio1" value="1" checked>
                                        <label class="form-check-label" for="inlineRadio1">1</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                            id="inlineRadio2" value="5">
                                        <label class="form-check-label" for="inlineRadio2">3</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                            id="inlineRadio3" value="10">
                                        <label class="form-check-label" for="inlineRadio3">5</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pricingcard-wholebox wp-aio">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Enterprise</h5>

                                    <div class="dynamicprice_box" plan_cat="enterprise01" boxperiod="yearly"
                                        boxdomain="1">
                                        <p class="card-text">1 Active Website</p>
                                        <div class="card-price">$499.00/ <span>year</span></div>
                                        <div class="slash-price">Regular Price: <span>$998.00/year</span></div>
                                        <div class="offer-price">50% Off</div>
                                        <div class="getstarted-btn">
                                            <a class="btn btn-secondary common-btn"
                                                href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_EY1"); ?>">
                                                GET STARTED
                                            </a>
                                        </div>
                                    </div>

                                    <div class="dynamicprice_box d-none" plan_cat="enterprise03" boxperiod="yearly"
                                        boxdomain="5">
                                        <p class="card-text">3 Active Websites</p>
                                        <div class="card-price">$XXX/ <span>year</span></div>
                                        <div class="slash-price">Regular Price: <span>$XXXX/year</span></div>
                                        <div class="offer-price">50% Off</div>
                                        <div class="getstarted-btn">
                                            <a class="btn btn-secondary common-btn">
                                                GET STARTED
                                            </a>
                                        </div>
                                    </div>

                                    <div class="dynamicprice_box d-none" plan_cat="enterprise05" boxperiod="yearly"
                                        boxdomain="10">
                                        <p class="card-text">5 Active Websites</p>
                                        <div class="card-price">$XXXX/ <span>year</span></div>
                                        <div class="slash-price">Regular Price: <span>$XXXX/year</span></div>
                                        <div class="offer-price">50% Off</div>
                                        <div class="getstarted-btn">
                                            <a class="btn btn-secondary common-btn">
                                                GET STARTED
                                            </a>
                                        </div>
                                    </div>
                                    <div class="dynamicprice_box d-none" plan_cat="enterprise05+" boxperiod="yearly"
                                        boxdomain="10+">
                                        <p class="card-text contactus">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#staticBackdrop">
                                                Contact Us
                                            </button>
                                        </p>
                                    </div>



                                    <ul class="feature-listing custom-scrollbar">
                                        <h5>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc remove"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip">
                                                    Everything in Professional, plus
                                                </button>
                                            </div>
                                        </h5>
                                        <span>&#43;</span>

                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="One click automation of server GTM container for ecommerce events and ad channels.">
                                                    Automation of Server Container for sGTM
                                                </button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="One click automation of web GTM container for ecommerce events and ad channels.">
                                                    Automation of Web Container for sGTM
                                                </button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="One click provisioning of powerful google cloud server hosting for 100% uptime, scalability and security.">
                                                    Google Cloud Hosting for sGTM
                                                </button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="No code automation for server e-commerce events datalayer.">
                                                    Server Ecommerce Data Layer Automation
                                                </button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="Sets first-party cookies. Extends cookie lifespan. Enhances GTM and GA4 to resist AdBlockers and ITP. Preserves data tracking integrity.">
                                                    Custom GTM Loader
                                                </button>

                                            </div>
                                        </li>
                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="Complete ecommerce tracking.">
                                                    Server Side Tracking for GA4
                                                </button>

                                            </div>
                                        </li>

                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc remove"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-title="Complete conversion tracking and audience building in Google Ads."
                                                    data-bs-custom-class="custom-tooltip">
                                                    Server Side Tracking for Google Ads
                                                </button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc remove"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-title="Complete conversion tracking and audience building in Facebook."
                                                    data-bs-custom-class="custom-tooltip">
                                                    Server Side Tracking for FB Ads and CAPI
                                                </button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc remove"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-title="Complete conversion tracking and audience building in Snapchat."
                                                    data-bs-custom-class="custom-tooltip">
                                                    Server Side Tracking for Snapchat Ads and CAPI
                                                </button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc remove"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-title="Complete conversion tracking and audience building in Tiktok."
                                                    data-bs-custom-class="custom-tooltip">
                                                    Server Side Tracking for Tiktok Events API
                                                </button>
                                            </div>
                                        </li>

                                    </ul>
                                    <div class="features-link">
                                        <a href="#seeallfeatures">Compare All Features</a>
                                    </div>
                                    <div class="dynamicprice_box" plan_cat="enterprise01" boxperiod="yearly"
                                        boxdomain="1">
                                        <div class="getstarted-btn">
                                            <a class="btn btn-secondary common-btn"
                                                href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_EY1"); ?>">
                                                GET STARTED
                                            </a>
                                        </div>
                                    </div>

                                    <div class="dynamicprice_box d-none" plan_cat="enterprise03" boxperiod="yearly"
                                        boxdomain="5">
                                        <div class="getstarted-btn">
                                            <a class="btn btn-secondary common-btn">
                                                GET STARTED
                                            </a>
                                        </div>
                                    </div>

                                    <div class="dynamicprice_box d-none" plan_cat="enterprise05" boxperiod="yearly"
                                        boxdomain="10">
                                        <div class="getstarted-btn">
                                            <a class="btn btn-secondary common-btn">
                                                GET STARTED
                                            </a>
                                        </div>
                                    </div>
                                    <div class="dynamicprice_box d-none" plan_cat="enterprise05+" boxperiod="yearly"
                                        boxdomain="10+">
                                        <p class="card-text contactus">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#staticBackdrop">
                                                Contact Us
                                            </button>
                                        </p>
                                    </div>
                                    <div class="popular-plan">
                                        <p>Most Popular</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                            <div class="card active">
                                <div class="card-body">
                                    <h5 class="card-title">Professional </h5>

                                    <div class="dynamicprice_box" plan_cat="professional01" boxperiod="yearly"
                                        boxdomain="1">
                                        <p class="card-text">1 Active Website</p>
                                        <div class="card-price">$199.00/ <span>year</span></div>
                                        <div class="slash-price">Regular Price: <span>$398.00/year</span></div>
                                        <div class="offer-price">50% Off</div>
                                        <div class="getstarted-btn">
                                            <a class="btn btn-secondary common-btn"
                                                href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_PY1"); ?>">
                                                GET STARTED
                                            </a>
                                        </div>
                                    </div>

                                    <div class="dynamicprice_box d-none" plan_cat="professional03" boxperiod="yearly"
                                        boxdomain="5">
                                        <p class="card-text">3 Active Websites</p>
                                        <div class="card-price">$299.00/ <span>year</span></div>
                                        <div class="slash-price">Regular Price: <span>$598.00/year</span></div>
                                        <div class="offer-price">50% Off</div>
                                        <div class="getstarted-btn">
                                            <a class="btn btn-secondary common-btn"
                                                href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_PY3"); ?>">
                                                GET STARTED
                                            </a>
                                        </div>
                                    </div>

                                    <div class="dynamicprice_box d-none" plan_cat="professional05" boxperiod="yearly"
                                        boxdomain="10">
                                        <p class="card-text">5 Active Websites</p>
                                        <div class="card-price">$399.00/ <span>year</span></div>
                                        <div class="slash-price">Regular Price: <span>$798.00/year</span></div>
                                        <div class="offer-price">50% Off</div>
                                        <div class="getstarted-btn">
                                            <a class="btn btn-secondary common-btn"
                                                href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_PY5"); ?>">
                                                GET STARTED
                                            </a>
                                        </div>
                                    </div>
                                    <div class="dynamicprice_box d-none" plan_cat="professional05+" boxperiod="yearly"
                                        boxdomain="10+">
                                        <p class="card-text contactus">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#staticBackdrop">
                                                Contact Us
                                            </button>
                                        </p>
                                    </div>



                                    <ul class="feature-listing custom-scrollbar">
                                        <h5>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc remove"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip">
                                                    Everything in Starter, plus
                                                </button>
                                            </div>
                                        </h5>
                                        <span>&#43;</span>
                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="Track e-commerce and lead generation events in meta-pixel with conversion tracking. Track key ad interactions like PageView, ViewContent, AddToCart, InitiateCheckout, AddPaymentInfo, Purchase, and Lead tracking for optimized Facebook ad campaigns.  ">
                                                    Facebook Pixel & Conversions API - FBCAPI
                                                </button>

                                                <small>Provides Advance Event Match Quality</small>
                                                <small>Improved Data Accuracy and Attribution</small>
                                                <small>Reduced Data Loss</small>

                                            </div>
                                        </li>
                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="Gain valuable insights into TikTok ad performance with conversion tracking for key purchase events. (ecommerce and lead generation event tracking.">
                                                    TikTok Pixel and Events API Tracking
                                                </button>
                                                <small>Provides Advance Event Match Quality</small>
                                                <small>Improved Data Accuracy and Attribution</small>
                                                <small>Reduced Data Loss</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="Measure the effectiveness of your Snapchat ads with purchase event tracking.">
                                                    Snapchat Pixel and Conversion API
                                                </button>
                                                <small>Provides Advance Event Match Quality</small>
                                                <small>Improved Data Accuracy and Attribution</small>
                                                <small>Reduced Data Loss</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="Expand your reach with unlimited product feeds for Google Merchant Center, Facebook Catalog, and TikTok Catalog with auto sync interval. ">
                                                    Unlimited Product Feed Management
                                                </button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="Analytics and ads management becomes complicated some time. Our team of expert helps you in set up everything and performs audit so that you focus on the things that matter for your business. ">
                                                    Free Setup and Audit
                                                </button>
                                            </div>
                                        </li>

                                    </ul>
                                    <div class="features-link">
                                        <a href="#seeallfeatures">Compare All Features</a>
                                    </div>

                                    <div class="dynamicprice_box" boxperiod="yearly" boxdomain="1">
                                        <div class="getstarted-btn">
                                            <a class="btn btn-secondary common-btn"
                                                href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_PY1"); ?>">
                                                GET STARTED
                                            </a>
                                        </div>
                                    </div>

                                    <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="5">
                                        <div class="getstarted-btn">
                                            <a class="btn btn-secondary common-btn"
                                                href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_PY3"); ?>">
                                                GET STARTED
                                            </a>
                                        </div>
                                    </div>

                                    <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10">
                                        <div class="getstarted-btn">
                                            <a class="btn btn-secondary common-btn"
                                                href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_PY5"); ?>">
                                                GET STARTED
                                            </a>
                                        </div>
                                    </div>
                                    <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10+">
                                        <p class="card-text contactus">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#staticBackdrop">
                                                Contact Us
                                            </button>
                                        </p>
                                    </div>
                                    <div class="popular-plan">
                                        <p>Most Popular</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="starter_box" class="col-xl-4 col-lg-4 col-md-6 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Starter</h5>

                                    <div class="dynamicprice_box" plan_cat="starter01" boxperiod="yearly" boxdomain="1">
                                        <p class="card-text">1 Active Website</p>
                                        <div class="card-price">$99.00/ <span>year</span></div>
                                        <div class="slash-price">Regular Price: <span>$198.00/year</span></div>
                                        <div class="offer-price">50% Off</div>
                                        <div class="getstarted-btn">
                                            <a class="btn btn-secondary common-btn"
                                                href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_SY1"); ?>">
                                                GET STARTED
                                            </a>
                                        </div>
                                    </div>

                                    <div class="dynamicprice_box d-none" plan_cat="starter03" boxperiod="yearly"
                                        boxdomain="5">
                                        <p class="card-text">3 Active Websites</p>
                                        <div class="card-price">$199.00/ <span>year</span></div>
                                        <div class="slash-price">Regular Price: <span>$398.00/year</span></div>
                                        <div class="offer-price">50% Off</div>
                                        <div class="getstarted-btn">
                                            <a class="btn btn-secondary common-btn"
                                                href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_SY3"); ?>">
                                                GET STARTED
                                            </a>
                                        </div>
                                    </div>

                                    <div class="dynamicprice_box d-none" plan_cat="starter05" boxperiod="yearly"
                                        boxdomain="10">
                                        <p class="card-text">5 Active Websites</p>
                                        <div class="card-price">$299.00/ <span>year</span></div>
                                        <div class="slash-price">Regular Price: <span>$598.00/year</span></div>
                                        <div class="offer-price">50% Off</div>
                                        <div class="getstarted-btn">
                                            <a class="btn btn-secondary common-btn"
                                                href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_SY5"); ?>">
                                                GET STARTED
                                            </a>
                                        </div>
                                    </div>
                                    <div class="dynamicprice_box d-none" plan_cat="starter05+" boxperiod="yearly"
                                        boxdomain="10+">
                                        <p class="card-text contactus">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#staticBackdrop">
                                                Contact Us
                                            </button>
                                        </p>
                                    </div>

                                    <ul class="feature-listing custom-scrollbar">

                                        <h5>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc remove"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip">
                                                    Everything in Free
                                                </button>
                                            </div>
                                        </h5>

                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="Customize your tags, triggers, and variables to fit your needs by using your own Google Tag Manager container with automated tag triggers for precise tracking.">
                                                    Customizable Tracking with Your Own GTM Container
                                                </button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="Enhanced user privacy with Google Consent Mode V2. Conversios supports Google V2 Consent and is compatible with various cookie consent plugins..">
                                                    Google Consent Mode V2 for Tracking
                                                </button>
                                            </div>
                                        </li>



                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="It monitors all E-commerce events such as page_view, purchase, view_item_list, view_item, select_item, add_to_cart, remove_from_cart, view_cart, begin_checkout, add_payment_info, and add_shipping_info.">
                                                    GA4 E-Commerce Tracking
                                                </button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="Measure the effectiveness of your website forms and optimize for higher conversions. Capture data beyond purchases, like form submissions, phone clicks, email clicks, and address clicks.">
                                                    Lead Generation Tracking
                                                </button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="You can effectively monitor your Google Ads campaign performance using Conversion and Enhanced Conversion Tracking. Track Add To Cart and Begin Checkout events for better Google Ads optimization.">
                                                    Google Ads Enhanced Conversion Tracking
                                                </button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="Enable Google Ads Dynamic Remarketing Tracking to create remarketing and dynamic remarketing audience lists.Retarget website visitors with laser focus based on their actions (View Item, Add to Cart, Begin Checkout, Purchase).">
                                                    Google Ads Dynamic Remarketing Tracking
                                                </button>
                                            </div>
                                        </li>
                                        <span>&#43;</span>
                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="Ecommerce events tracking across multiple Ads channels such as Facebook, Snapchat, TikTok, Pinterest, Bing, and Twitter.">
                                                    Ecommerce Tracking for Multiple Ads Channels
                                                </button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="Set up high-quality product feeds for ad channels like Google, Facebook, and TikTok to expand your reach. This includes product feeds for Google Merchant Center, Facebook Catalog, and TikTok Catalog with automatic sync intervals. Allows up to 500 product sync.">
                                                    Product Feed for 3 Ad Channels (Upto 500 Products)
                                                </button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="Schedule automatic updates to keep your product feeds fresh and accurately updated.">
                                                    Schedule Product Sync
                                                </button>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="Advance Attribute Mapping and Category Mapping for better visibility, improved product data quality, and better ad performance.">
                                                    Advance Attribute Mapping & Category Mapping
                                                </button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="Create and manage high-performing Google Ads Performance Max Campaigns based on your product feeds.">
                                                    Feed based Campaign Management
                                                </button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="Know about e-commerce funnel, product, source and order performance reports from wordpress admin. Enables data driven decision making to increase conversion %.">
                                                    E-Commerce Reporting
                                                </button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="Enables you to measure the campaign performance in Google Ads.">
                                                    Google Ads Reporting
                                                </button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="AI powered insights on your analytics and campaigns data.">
                                                    AI Powered Insights
                                                </button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="tooltip-box">
                                                <button type="button" class="btn btn-secondary tooltipc"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="Schedule daily, weekly or monthly reports straight into your inbox.">
                                                    Schedule Email Reports
                                                </button>
                                            </div>
                                        </li>

                                    </ul>
                                    <div class="features-link">
                                        <a href="#seeallfeatures">Compare All Features</a>
                                    </div>

                                    <div class="dynamicprice_box" boxperiod="yearly" boxdomain="1">

                                        <div class="getstarted-btn">
                                            <a class="btn btn-secondary common-btn"
                                                href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_SY1"); ?>">
                                                GET STARTED
                                            </a>
                                        </div>
                                    </div>
                                    <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="5">

                                        <div class="getstarted-btn">
                                            <a class="btn btn-secondary common-btn"
                                                href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_SY3"); ?>">
                                                GET STARTED
                                            </a>
                                        </div>
                                    </div>
                                    <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10">

                                        <div class="getstarted-btn">
                                            <a class="btn btn-secondary common-btn"
                                                href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_SY5"); ?>">
                                                GET STARTED
                                            </a>
                                        </div>
                                    </div>
                                    <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10+">
                                        <p class="card-text contactus">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#staticBackdrop">
                                                Contact Us
                                            </button>
                                        </p>
                                    </div>
                                    <div class="popular-plan">
                                        <p>Most Popular</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>


            </div>

        </div>
        <!-- one stop section -->
        <div class="onestop-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="title-text">
                            <p>50,000+ E-commerce Businesses Use Conversios To Scale Faster as One Stop Solution to <br>
                                Save
                                Time, Efforts & Costs</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Compare feature -->
        <div class="comparefeature-wholebox" id="seeallfeatures">
            <div class="comparefeature-area space">
                <div class="container-full">
                    <div class="row">
                        <div class="col-12">
                            <div class="title-text">
                                <h2> <strong>Comprehensive Feature</strong> Comparison</h2>
                                <h3>Delve into the details of all our feature</h3>
                            </div>
                        </div>
                    </div>
                    <div class="comparetable-box">
                        <form action="">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive custom-scrollbar">
                                        <table id="sticky-header-tbody-id" class="feature-table table ">
                                            <thead id="con_stick_this">
                                                <tr>
                                                    <th scope="col" class="th-data">
                                                        <div class="feature-box">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="card-icon">
                                                                        <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/convo-images/pricing/privacy.png"
                                                                            alt="" class="img-fluid">
                                                                    </div>
                                                                    <h5 class="card-title">100% No Risk <br>
                                                                        Moneyback Guarantee</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </th>
                                                    <th scope="col" class="thd-data">
                                                        <div class="feature-box">
                                                            <div class="dynamicprice_box" plan_cat="enterprise01"
                                                                boxperiod="yearly" boxdomain="1">
                                                                <div class="title card-title">Enterprise</div>
                                                                <p class="sub-title card-text">1 Active Website</p>
                                                                <div class="strike-price">Regular Price: <span>
                                                                        $998.00</span></div>
                                                                <div class="price">$499.00/ <span>year</span></div>
                                                                <div class="offer-price">Flat 50% Off Applied </div>
                                                                <div class="getstarted-btn get-it-now">
                                                                    <a class="label btn btn-secondary common-btn"
                                                                        href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_EY1"); ?>">
                                                                        Get It Now
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="dynamicprice_box d-none" plan_cat="enterprise03"
                                                                boxperiod="yearly" boxdomain="5">
                                                                <div class="title card-title">Enterprise</div>
                                                                <p class="sub-title card-text">3 Active Websites</p>
                                                                <div class="strike-price">Regular Price: <span>
                                                                        $XXXX</span></div>
                                                                <div class="price">$XXX/ <span>year</span></div>
                                                                <div class="offer-price">Flat 50% Off Applied </div>
                                                                <div class="getstarted-btn get-it-now">
                                                                    <a class="label btn btn-secondary common-btn">
                                                                        Get It Now
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="dynamicprice_box d-none" plan_cat="enterprise05"
                                                                boxperiod="yearly" boxdomain="10">
                                                                <div class="title card-title">Enterprise</div>
                                                                <p class="sub-title card-text">5 Active Websites</p>
                                                                <div class="strike-price">Regular Price: <span>
                                                                        $XXXX</span></div>
                                                                <div class="price">$XXXX/ <span>year</span></div>
                                                                <div class="offer-price">Flat 50% Off Applied </div>
                                                                <div class="getstarted-btn get-it-now">
                                                                    <a class="label btn btn-secondary common-btn">
                                                                        Get It Now
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="dynamicprice_box d-none"
                                                                plan_cat="enterprise05+" boxperiod="yearly"
                                                                boxdomain="10+">
                                                                <div class="title card-title">Enterprise</div>
                                                                <p class="card-text contactus">
                                                                    <button type="button" class="btn btn-primary"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#staticBackdrop">
                                                                        Contact Us
                                                                    </button>
                                                                </p>

                                                            </div>
                                                        </div>
                                                    </th>
                                                    <th scope="col" class="thd-data">
                                                        <div class="feature-box">
                                                            <div class="dynamicprice_box" plan_cat="professional01"
                                                                boxperiod="yearly" boxdomain="1">
                                                                <div class="title card-title">Professional</div>
                                                                <p class="sub-title card-text">1 Active Website</p>
                                                                <div class="strike-price">Regular Price: <span>
                                                                        $398.00</span></div>
                                                                <div class="price">$199.00/ <span>year</span></div>
                                                                <div class="offer-price">Flat 50% Off Applied </div>
                                                                <div class="getstarted-btn get-it-now">
                                                                    <a class="label btn btn-secondary common-btn"
                                                                        href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_PY1"); ?>">
                                                                        Get It Now
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="dynamicprice_box d-none"
                                                                plan_cat="professional03" boxperiod="yearly"
                                                                boxdomain="5">
                                                                <div class="title card-title">Professional</div>
                                                                <p class="sub-title card-text">3 Active Websites</p>
                                                                <div class="strike-price">Regular Price: <span>
                                                                        $598.00</span></div>
                                                                <div class="price">$299.00/ <span>year</span></div>
                                                                <div class="offer-price">Flat 50% Off Applied </div>
                                                                <div class="getstarted-btn get-it-now">
                                                                    <a class="label btn btn-secondary common-btn"
                                                                        href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_PY3"); ?>">
                                                                        Get It Now
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="dynamicprice_box d-none"
                                                                plan_cat="professional05" boxperiod="yearly"
                                                                boxdomain="10">
                                                                <div class="title card-title">Professional</div>
                                                                <p class="sub-title card-text">5 Active Websites</p>
                                                                <div class="strike-price">Regular Price: <span>
                                                                        $798.00</span></div>
                                                                <div class="price">$399.00/ <span>year</span></div>
                                                                <div class="offer-price">Flat 50% Off Applied </div>
                                                                <div class="getstarted-btn get-it-now">
                                                                    <a class="label btn btn-secondary common-btn"
                                                                        href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_PY5"); ?>">
                                                                        Get It Now
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="dynamicprice_box d-none"
                                                                plan_cat="professional05+" boxperiod="yearly"
                                                                boxdomain="10+">
                                                                <div class="title card-title">Professional</div>
                                                                <p class="card-text contactus">
                                                                    <!-- Button trigger modal -->
                                                                    <button type="button" class="btn btn-primary"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#staticBackdrop">
                                                                        Contact Us
                                                                    </button>
                                                                </p>

                                                            </div>
                                                        </div>
                                                    </th>
                                                    <th scope="col" class="thd-data">
                                                        <div class="feature-box">
                                                            <div class="dynamicprice_box" plan_cat="starter01"
                                                                boxperiod="yearly" boxdomain="1">
                                                                <div class="title card-title">Starter</div>
                                                                <p class="sub-title card-text">1 Active Website</p>
                                                                <div class="strike-price">Regular Price: <span>
                                                                        $198.00</span></div>
                                                                <div class="price">$99.00/ <span>year</span></div>
                                                                <div class="offer-price">Flat 50% Off Applied </div>
                                                                <div class="getstarted-btn get-it-now">
                                                                    <a class="label btn btn-secondary common-btn"
                                                                        href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_SY1"); ?>">
                                                                        Get It Now
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="dynamicprice_box d-none" plan_cat="starter03"
                                                                boxperiod="yearly" boxdomain="5">
                                                                <div class="title card-title">Starter</div>
                                                                <p class="sub-title card-text">3 Active Websites</p>
                                                                <div class="strike-price">Regular Price: <span>
                                                                        $398.00</span></div>
                                                                <div class="price">$199.00/ <span>year</span></div>
                                                                <div class="offer-price">Flat 50% Off Applied </div>
                                                                <div class="getstarted-btn get-it-now">
                                                                    <a class="label btn btn-secondary common-btn"
                                                                        href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_SY3"); ?>">
                                                                        Get It Now
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="dynamicprice_box d-none" plan_cat="starter05"
                                                                boxperiod="yearly" boxdomain="10">
                                                                <div class="title card-title">Starter</div>
                                                                <p class="sub-title card-text">5 Active Websites</p>
                                                                <div class="strike-price">Regular Price: <span>
                                                                        $598.00</span></div>
                                                                <div class="price">$299.00/ <span>year</span></div>
                                                                <div class="offer-price">Flat 50% Off Applied </div>
                                                                <div class="getstarted-btn get-it-now">
                                                                    <a class="label btn btn-secondary common-btn"
                                                                        href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_SY5"); ?>">
                                                                        Get It Now
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="dynamicprice_box d-none" plan_cat="starter05+"
                                                                boxperiod="yearly" boxdomain="10+">
                                                                <div class="title card-title">Starter</div>
                                                                <p class="card-text contactus">
                                                                    <!-- Button trigger modal -->
                                                                    <button type="button" class="btn btn-primary"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#staticBackdrop">
                                                                        Contact Us
                                                                    </button>
                                                                </p>

                                                            </div>
                                                        </div>
                                    </div>
                                    </th>
                                    <th scope="col" class="thd-data">
                                        <div class="feature-box">
                                            <div class="dynamicprice_box" boxperiod="yearly" boxdomain="1">
                                                <div class="title card-title">Free</div>
                                                <p class="sub-title card-text">1 Active Website</p>
                                                <div class="strike-price">Regular Price: <span>
                                                        $00.00</span></div>
                                                <div class="price">$00.00/ <span>year</span></div>
                                                <div class="offer-price" style="opacity: 0; visibility: hidden;">Flat
                                                    50% Off Applied </div>
                                                <div class="getstarted-btn get-it-now">
                                                    <a class="label btn btn-secondary common-btn" target="_blank"
                                                        href="<?php echo esc_url_raw("https://wordpress.org/plugins/enhanced-e-commerce-for-woocommerce-store/"); ?>">
                                                        Get It Now
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="5">
                                                <div class="title card-title">Free</div>
                                                <p class="sub-title card-text">3 Active Websites</p>
                                                <div class="strike-price">Regular Price: <span>
                                                        $00.00</span></div>
                                                <div class="price">$00.00/ <span>year</span></div>
                                                <div class="offer-price" style="opacity: 0; visibility: hidden;">Flat
                                                    50% Off Applied </div>
                                                <div class="getstarted-btn get-it-now">
                                                    <a class="label btn btn-secondary common-btn"
                                                        href="<?php echo esc_url_raw("https://wordpress.org/plugins/enhanced-e-commerce-for-woocommerce-store/"); ?>">
                                                        Get It Now
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10">
                                                <div class="title card-title">Free</div>
                                                <p class="sub-title card-text">5 Active Websites</p>
                                                <div class="strike-price">Regular Price: <span>
                                                        $00.00</span></div>
                                                <div class="price">$00.00/ <span>year</span></div>
                                                <div class="offer-price" style="opacity: 0; visibility: hidden;">Flat
                                                    50% Off Applied </div>
                                                <div class="getstarted-btn get-it-now">
                                                    <a class="label btn btn-secondary common-btn"
                                                        href="<?php echo esc_url_raw("https://wordpress.org/plugins/enhanced-e-commerce-for-woocommerce-store/"); ?>">
                                                        Get It Now
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10+">
                                                <div class="title card-title">Free</div>
                                                <p class="card-text contactus">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#staticBackdrop"
                                                        style="opacity: 0; visibility: hidden;">
                                                        Contact Us
                                                    </button>
                                                </p>

                                            </div>
                                        </div>
                                    </th>




                                    </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Accessibility Features -->
                                        <!-- 0 -->
                                        <tr class="title-row" data-title="Accessibility Features">
                                            <td colspan="5" class="data">
                                                <div class="feature-title">
                                                    GTM & Datalayer Automation

                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="Enhanced user privacy with Google Consent Mode V2. Conversios supports Google V2 Consent and is compatible with Real Cookie Banner, GDPR Cookie Compliance, and CookieYes.">
                                                        <b>Customizable Tracking with GTM Container</b>
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">⤫</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                        <!-- 1 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="Enhanced user privacy with Google Consent Mode V2. Conversios supports Google V2 Consent and is compatible with Real Cookie Banner, GDPR Cookie Compliance, and CookieYes.">
                                                        <b>Google Consent Mode V2 for Tracking</b>
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">⤫</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                        <!-- 2 -->
                                        <!-- 1 -->


                                        <!-- GA4, Ads Conversion Tracking & Audience Building -->
                                        <!-- 0 -->
                                        <tr class="title-row" data-title="Accessibility Features">
                                            <td colspan="5" class="data">
                                                <div class="feature-title">
                                                    GA4 E-commerce Tracking
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- 1 -->

                                        <!-- 2 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip">
                                                        page_view
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                        <!-- 3 -->

                                        <!-- 4 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip">
                                                        view_item_list
                                                    </button>
                                                </div>
                                            </th>

                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                        <!-- 5 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip">
                                                        view_item
                                                    </button>
                                                </div>
                                            </th>

                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                        <!-- 6 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip">
                                                        select_item
                                                    </button>
                                                </div>
                                            </th>

                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                        <!-- 7 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip">
                                                        add_to_cart
                                                    </button>
                                                </div>
                                            </th>

                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                        <!-- 8 -->

                                        <!-- 9 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip">
                                                        view_cart
                                                    </button>
                                                </div>
                                            </th>

                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                        <!-- 10 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip">
                                                        remove_from_cart
                                                    </button>
                                                </div>
                                            </th>

                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip">
                                                        begin_checkout
                                                    </button>
                                                </div>
                                            </th>

                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                        <!-- 11 -->

                                        <!-- 12 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip">
                                                        add_shipping_info
                                                    </button>
                                                </div>
                                            </th>

                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                        <!-- 13 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip">
                                                        add_payment_info
                                                    </button>
                                                </div>
                                            </th>

                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip">
                                                        purchase
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 29 -->
                                        <tr class="title-row" data-title="Accessibility Features">
                                            <td colspan="5" class="data">
                                                <div class="feature-title">
                                                    Lead Generation Tracking

                                                </div>
                                            </td>
                                        </tr>


                                        <!-- 30 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip">
                                                        form submissions
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>

                                        <!-- 31 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip">
                                                        phone clicks
                                                    </button>
                                                </div>
                                            </th>

                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>

                                        <!-- 32 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip">
                                                        email clicks
                                                    </button>
                                                </div>
                                            </th>

                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>

                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip">
                                                        address clicks
                                                    </button>
                                                </div>
                                            </th>

                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>

                                        <!-- 14 -->
                                        <tr class="title-row" data-title="Accessibility Features">
                                            <td colspan="5" class="data">
                                                <div class="feature-title">
                                                    Google Ads Tracking

                                                </div>
                                            </td>
                                        </tr>


                                        <!-- 15 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="You can set up and optimize your Google Ad Campaigns and Google Merchant Centre with Target KPIs optimized by Google Smart Bidding. ">
                                                        Setup Google Ads and Optimize
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 16 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="You can effectively monitor your Google Ads campaign performance using Conversion and Enhanced Conversion Tracking. Track Add To Cart and Begin Checkout events for better Google Ads optimization.">
                                                        Google Ads Enhanced Conversion Tracking
                                                    </button>
                                                </div>
                                            </th>

                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>

                                        <!-- 17 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="Enable Google Ads Dynamic Remarketing Tracking to create remarketing and dynamic remarketing audience lists.Retarget website visitors with laser focus based on their actions (View Item, Add to Cart, Begin Checkout, Purchase).">
                                                        <b>Google Ads Dynamic Remarketing Tracking <br> (View Item, Add
                                                            to Cart, Begin Checkout, Purchase)</b>
                                                    </button>
                                                </div>
                                            </th>

                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>





                                        <!--Facebook Ecoomerce   -->
                                        <tr class="title-row" data-title="hello">
                                            <td colspan="5" class="data">
                                                <div class="feature-title">
                                                    Facebook Pixel & Conversions API

                                                </div>
                                            </td>
                                        </tr>
                                        <!-- 1 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip">
                                                        Page View
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip">
                                                        View Content
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip">
                                                        Add To Cart
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip">
                                                        Initiate Checkout
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip">
                                                        Add Payment Info
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip">
                                                        Lead Tracking
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>
                                        <tr class="title-row" data-title="Accessibility Features">
                                            <td colspan="5" class="data">
                                                <div class="feature-title">
                                                    Ecommerce Tracking for Multiple Ads Channels

                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="Gain valuable insights into TikTok ad performance with conversion tracking for key purchase events. (ecommerce and lead generation event tracking.">
                                                        TikTok Pixel and Events API Tracking
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="Measure the effectiveness of your Snapchat ads with purchase event tracking.">
                                                        Snapchat Pixel and Conversion API
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="Optimize your Pinterest ad strategy with conversion tracking for crucial purchase events.">
                                                        Pinterest Pixel Tracking
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>



                                        </tr>
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="Track ad performance across various stages of the purchase funnel with Microsoft(Bing) Ads integration.">
                                                        Microsoft (Bing) Pixel and Conversion Tracking
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="Gain valuable insights into Twitter ad performance with conversion tracking.">
                                                        Twitter Pixel Tracking
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="Gain a visual understanding of user behavior with integrations for Microsoft Clarity, Hotjar, and Crazy Egg.">
                                                        Heatmap and Screen Recording
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>
                                        <!-- 2 -->

                                        <!-- Server-Side Tagging  -->
                                        <!-- 0 -->
                                        <tr class="title-row" data-title="hello">
                                            <td colspan="5" class="data">
                                                <div class="feature-title">
                                                    Server-Side Tagging
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- 1 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="One click automation of server GTM container for ecommerce events and ad channels.">
                                                        Automation of sGTM
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>
                                        <!-- 2 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="One click automation of web GTM container for e-commerce events and ad channels.">
                                                        Automation of Web GTM
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>
                                        <!-- 3 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="One click provisioning of powerful google cloud server hosting for 100% uptime, scalability and security.">
                                                        Google Cloud Hosting for sGTM
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>
                                        <!-- 4 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="No code automation for server e-commerce events datalayer.">
                                                        Server E-commerce Datalayer Automation
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>
                                        <!-- 5 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="Sets first-party cookies. Extends cookie lifespan. Enhances GTM and GA4 to resist AdBlockers and ITP. Preserves data tracking integrity.">
                                                        Custom GTM Loader
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>
                                        <!-- 6 -->

                                        <!-- 7 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="Complete e-commerce tracking.">
                                                        Server-Side Tagging for GA4
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>
                                        <!-- 8 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="Complete conversion tracking and audience building in Google Ads.">
                                                        Server-Side Tagging for Google Ads
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>
                                        <!-- 9 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="Complete conversion tracking and audience building in Facebook.">
                                                        Server-Side Tagging for FB Ads and CAPI
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>
                                        <!-- 10 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="Complete conversion tracking and audience building in Snapchat.">
                                                        Server-Side Tagging for Snapchat Ads and CAPI
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>

                                        <!-- 11 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="Complete conversion tracking and audience building in TikTok.">
                                                        Server-Side Tagging for TikTok Events API
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>


                                        <!-- Product Feed Manager  -->
                                        <!-- 0 -->
                                        <tr class="title-row" data-title="hello">
                                            <td colspan="5" class="data">
                                                <div class="feature-title">
                                                    Product Feed Management
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- 1 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="Total number of WooCommerce product sync limit.">
                                                        Number Of Products
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items"><b>Unlimited</b></div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items"><b>Unlimited</b></div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items"><b>Upto 500</b></div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items"><b>Upto 100</b></div>
                                                </div>
                                            </td>




                                        </tr>

                                        <!-- 2 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc remove"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip">
                                                        Google Shopping Feed
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>

                                        <!-- 3 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc remove"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip">
                                                        Facebook Catalog Feed
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>

                                        <!-- 4 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc remove"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip">
                                                        TikTok Catalog Feed
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>

                                        <!-- 5 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="Schedule automatic updates to keep your product feeds fresh and accurately updated. ">
                                                        Schedule Auto Product Sync
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">⤫</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>



                                        <!-- 7 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="Utilize advanced filters to create targeted product feeds for different platforms.">
                                                        Advanced Filters
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>

                                        <!-- 8-->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="Advance Attribute Mapping and Category Mapping for better visibility, improved product data quality, and better ad performance.">
                                                        Advance Attribute Mapping & Category Mapping
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>

                                        <!--9-->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="Create and manage high-performing Google Ads Performance Max Campaigns based on your product feeds.">
                                                        Feed Based Campaign Management
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>

                                        <!-- Reporting & Campaign Management  -->
                                        <!-- 0 -->
                                        <tr class="title-row" data-title="hello">
                                            <td colspan="5" class="data">
                                                <div class="feature-title">
                                                    Reporting & Campaign Management
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- 1 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="Know about e-commerce funnel(Conversion and Checkout), product, source and order performance reports from wordpress admin. Enables data driven decision making to increase conversion.">
                                                        E-Commerce Reporting (GA4)
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">⤫</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>

                                        <!-- 2 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="Enables you to measure the campaign performance in Google Ads.">
                                                        Google Ads Reporting
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">⤫</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>

                                        <!-- 3 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="ChatGPT powered insights on your analytics and campaigns data.">
                                                        AI Powered Insights
                                                    </button>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">⤫</span>
                                                    </div>
                                                </div>
                                            </td>




                                        </tr>

                                        <!-- 4 -->
                                        <tr>
                                            <th class="th-data" scope="row">
                                                <div class="tooltip-box">
                                                    <button type="button" class="btn btn-secondary tooltipc"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="Schedule daily, weekly or monthly reports straight into your inbox.">
                                                        Schedule Smart Email Reports
                                                    </button>
                                                </div>
                                            </th>

                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span>&#10003;</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="feature-data">
                                                    <div class="items">
                                                        <span class="cross">&#10539;</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>



                                        <!-- 18 buttons -->
                                        <tr>
                                            <th class="th-data" scope="row" style="border: 0px;"></th>
                                            <td style="border: 0px;">
                                                <div class="feature-data">

                                                    <div class="dynamicprice_box" plan_cat="enterprise01"
                                                        boxperiod="yearly" boxdomain="1">
                                                        <div class="getnow-btn">
                                                            <a class="btn btn-secondary getnow" index='1'
                                                                href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_EY1"); ?>">Get
                                                                It Now</a>
                                                        </div>
                                                    </div>
                                                    <div class="dynamicprice_box d-none" plan_cat="enterprise03"
                                                        boxperiod="yearly" boxdomain="5">
                                                        <div class="getnow-btn">
                                                            <a class="btn btn-secondary getnow" index='1'>Get It Now</a>
                                                        </div>
                                                    </div>
                                                    <div class="dynamicprice_box d-none" plan_cat="enterprise05"
                                                        boxperiod="yearly" boxdomain="10">
                                                        <div class="getnow-btn">
                                                            <a class="btn btn-secondary getnow" index='1'>Get It Now</a>
                                                        </div>
                                                    </div>
                                                    <div class="dynamicprice_box d-none" plan_cat="enterprise05+"
                                                        boxperiod="yearly" boxdomain="10+">
                                                        <div class="getnow-btn">
                                                            <button type="button" class="btn btn-primary getnow"
                                                                data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                                                index='1'>CONTACT US</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </td>
                                            <td style="border: 0px;">
                                                <div class="feature-data">
                                                    <div class="dynamicprice_box" boxperiod="yearly" boxdomain="1">
                                                        <div class="getnow-btn">
                                                            <a class="btn btn-secondary getnow" index='2'
                                                                href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_PY1"); ?>">Get
                                                                It Now</a>
                                                        </div>
                                                    </div>
                                                    <div class="dynamicprice_box d-none" boxperiod="yearly"
                                                        boxdomain="5">
                                                        <div class="getnow-btn">
                                                            <a class="btn btn-secondary getnow" index='2'
                                                                href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_PY3"); ?>">Get
                                                                It Now</a>
                                                        </div>
                                                    </div>
                                                    <div class="dynamicprice_box d-none" boxperiod="yearly"
                                                        boxdomain="10">
                                                        <div class="getnow-btn">
                                                            <a class="btn btn-secondary getnow" index='2'
                                                                href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_PY5"); ?>">Get
                                                                It Now</a>
                                                        </div>
                                                    </div>
                                                    <div class="dynamicprice_box d-none" boxperiod="yearly"
                                                        boxdomain="10+">
                                                        <div class="getnow-btn">
                                                            <button type="button" class="btn btn-primary getnow"
                                                                data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                                                index='1'>CONTACT US</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="border: 0px;">
                                                <div class="feature-data">
                                                    <div class="dynamicprice_box" boxperiod="yearly" boxdomain="1">
                                                        <div class="getnow-btn">
                                                            <a class="btn btn-secondary getnow" index='3'
                                                                href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_SY1"); ?>">Get
                                                                It Now</a>
                                                        </div>
                                                    </div>
                                                    <div class="dynamicprice_box d-none" boxperiod="yearly"
                                                        boxdomain="5">
                                                        <div class="getnow-btn">
                                                            <a class="btn btn-secondary getnow" index='3'
                                                                href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_SY3"); ?>">Get
                                                                It Now</a>
                                                        </div>
                                                    </div>
                                                    <div class="dynamicprice_box d-none" boxperiod="yearly"
                                                        boxdomain="10">
                                                        <div class="getnow-btn">
                                                            <a class="btn btn-secondary getnow" index='3'
                                                                href="<?php echo esc_url_raw($conversios_site_url . "/checkout/?pid=wpAIO_SY5"); ?>">Get
                                                                It Now</a>
                                                        </div>
                                                    </div>
                                                    <div class="dynamicprice_box d-none" boxperiod="yearly"
                                                        boxdomain="10+">
                                                        <div class="getnow-btn">
                                                            <button type="button" class="btn btn-primary getnow"
                                                                data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                                                index='1'>CONTACT US</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="border: 0px;">
                                                <div class="feature-data">
                                                    <div class="dynamicprice_box" boxperiod="yearly" boxdomain="1">
                                                        <div class="getnow-btn">
                                                            <a class="btn btn-secondary getnow" index='4'
                                                                target="_blank"
                                                                href="<?php echo esc_url_raw("https://wordpress.org/plugins/enhanced-e-commerce-for-woocommerce-store/"); ?>">Get
                                                                It Now</a>
                                                        </div>
                                                    </div>
                                                    <div class="dynamicprice_box d-none" boxperiod="yearly"
                                                        boxdomain="5">
                                                        <div class="getnow-btn">
                                                            <a class="btn btn-secondary getnow" index='4'
                                                                target="_blank"
                                                                href="<?php echo esc_url_raw("https://wordpress.org/plugins/enhanced-e-commerce-for-woocommerce-store/"); ?>">Get
                                                                It Now</a>
                                                        </div>
                                                    </div>
                                                    <div class="dynamicprice_box d-none" boxperiod="yearly"
                                                        boxdomain="10">
                                                        <div class="getnow-btn">
                                                            <a class="btn btn-secondary getnow" index='4'
                                                                target="_blank"
                                                                href="<?php echo esc_url_raw("https://wordpress.org/plugins/enhanced-e-commerce-for-woocommerce-store/"); ?>">Get
                                                                It Now</a>
                                                        </div>
                                                    </div>
                                                    <div class="dynamicprice_box d-none" boxperiod="yearly"
                                                        boxdomain="10+">
                                                        <div class="getnow-btn">
                                                            <button type="button" class="btn btn-primary getnow"
                                                                data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                                                index='1'
                                                                style="opacity: 0; visibility: hidden;">CONTACT
                                                                US</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

</div>

<script>
var distance = jQuery('#con_stick_this').offset().top;
$window = jQuery(window);
$window.scroll(function() {
    if ($window.scrollTop() >= 1760 && $window.scrollTop() <= 6360) {
        jQuery("#con_stick_this").addClass("sticky-header");
        jQuery("#sticky-header-tbody-id").addClass("sticky-header-tbody");

    } else {
        jQuery("#con_stick_this").removeClass("sticky-header");
        jQuery("#sticky-header-tbody-id").removeClass("sticky-header-tbody");

    }
});
</script>

<script>
jQuery('.testi-slider').slick({
    dots: true,
    arrows: true,
    infinite: true,
    speed: 300,
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: true, // time for slides changes
    smartSpeed: 0, // duration of change of 1 slide
    autoHeight: false,
    cssEase: 'linear',
    centerPadding: '0px',
    centerMode: true,
    autoplayHoverPause: false,
    responsiveClass: true,
    responsive: [{
            breakpoint: 1300,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1,

            }
        },
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                dots: false,
                arrows: false,
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
                arrows: false,
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
                arrows: false,
            }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
    ]
});
</script>


<script>
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>

<script>
function checkperiod_domain() {

    jQuery(".dynamicprice_box").addClass("d-none");

    var yearmonth_checkbox = "monthly";
    if (jQuery("#yearmonth_checkbox").is(":checked")) {
        yearmonth_checkbox = "yearly"
    }

    var domain_num = jQuery('input[name=inlineRadioOptions]:checked').val()

    jQuery(".dynamicprice_box").each(function() {
        var boxperiod = jQuery(this).attr("boxperiod");
        var boxdomain = jQuery(this).attr("boxdomain");
        var plan_cat = jQuery(this).attr("plan_cat");
        if (plan_cat == "enterprise03" || plan_cat == "enterprise05") {
            jQuery(this).addClass("dim_box");
        } else {
            jQuery(this).removeClass("dim_box");
        }
        if (boxperiod == yearmonth_checkbox && boxdomain == domain_num) {
            jQuery(this).removeClass("d-none");
        }
    });
}

jQuery(function() {
    jQuery("#yearmonth_checkbox").click(function() {
        checkperiod_domain();
    });

    jQuery("input[name=inlineRadioOptions]").change(function() {
        checkperiod_domain();
    });
});
</script>

<script>
function startTimer(duration, display) {
    var timer = duration,
        minutes, seconds;
    setInterval(function() {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        // display.textContent = minutes + ":" + seconds;
        document.querySelector('#min').textContent = minutes;
        document.querySelector('#sec').textContent = seconds;

        if (--timer < 0) {
            timer = duration;
        }
    }, 1000);
}

window.onload = function() {
    var fiveMinutes = 60 * 5,
        display = document.querySelector('#time');
    startTimer(fiveMinutes, display);
};

// jQuery('#sticky-header-tbody-id').find('td:nth-child(5)').remove();
// jQuery('#con_stick_this').find('th:nth-child(5)').remove();
</script>

<script>
// pricing default
jQuery(document).ready(function() {
    jQuery(function() {
        var $radios = jQuery('input:radio[name=inlineRadioOptions]');
        if ($radios.is(':checked') === true) {
            $radios.filter('[value=1]').prop('checked', true);
        }
    });
});

//plan inquire form 
jQuery(".planform-box").each(function() {
    var url = document.title;
    jQuery(this).find(".Platform_input input").val(url);
});
</script>

<?php
    }
}
?>