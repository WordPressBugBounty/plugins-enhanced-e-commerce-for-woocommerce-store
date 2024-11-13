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
        <style>
            .plan_summ {
                background: #d7f2ff;
                font-size: 15px;
                border-radius: 12px;
                border-left: 5px solid #006BCD;
                font-size: 14px !important;
                line-height: 22px !important;
            }

            .convo-pricingpage .pricingcard-wholebox .card .card-body .card-price span {
                font-size: 21px;
                padding-left: 20px;
            }
        </style>
        <div class="convo-global">
            <div class="convo-pricingpage">
                <!-- business area -->
                <div class="business-area">
                    <div class="container" style="max-width: 1470px !important;">
                        <div class="row">
                            <div class="col-12">
                                <div class="title-text" id="wordpress-content">
                                    <h4>Get <mark> 15 days money back guarantee </mark> on any plan you choose.</h4>
                                    <h2>WooCommerce Plugins for Marketing &amp; Analytics</h2>
                                </div>

                                <div class="title-text d-none" id="shopify-content">
                                    <h4>Get <mark> 10 days free trial </mark> on any plan you choose.</h4>
                                    <h2>Grow Your Store with Powerful Shopify Apps</h2>
                                    <h3>Find the perfect plan to get the most out of your Shopify store. Whether you're just
                                        starting with GA4 or need enterprise-level server-side tagging, Conversios has the
                                        solution for you.</h3>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid">

                            <!-- Parent Tabs -->
                            <ul class="nav nav-tabs d-none" id="parentTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link nav-platform active" id="tab1" data-bs-toggle="tab" href="#content1" aria-selected="true" role="tab">
                                        <img style="height: 55px" src="https://www.conversios.io/wp-content/themes/conversios2023/assets/convo-images/pricing/wordpresslogo.png" alt="Wordpress Tab" class="img-fluid whitecolor">
                                        <b class="text-light">&amp;</b>
                                        <img style="height: 55px" src="https://www.conversios.io/wp-content/themes/conversios2023/assets/convo-images/pricing/woocommerce-logo-white.png" alt="Woocommerce Tab" class="img-fluid woocomimg">
                                    </a>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link nav-platform" id="tab3" data-bs-toggle="tab" href="#content3" aria-selected="false" tabindex="-1" role="tab">
                                        <img style="height: 34px; width: auto;" src="https://www.conversios.io/wp-content/themes/conversios2023/assets/convo-images/pricing/shopify_logo_black.png" alt="Shopify Tab" class="img-fluid shopifyimg">
                                    </a>
                                </li>


                            </ul>

                            <!-- Parent Tab Content -->
                            <div class="tab-content">
                                <!-- Tab1 -->
                                <div class="tab-pane fade show active wordpress" id="content1" role="tabpanel" aria-labelledby="#tab1">
                                    <!-- Nested Tabs for Tab 1 -->
                                    <ul class="nav nav-tabs d-none" id="nestedTabs1">
                                        <li class="nav-item">
                                            <a class="nav-link " id="nestedTab1_1" data-bs-toggle="tab" href="#nestedContent1_1">
                                                All-In-One Google Analytics &amp; Product Feed Manager
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="nestedTab1_2" data-bs-toggle="tab" href="#nestedContent1_2">Product Feed Manager</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " id="nestedTab1_3" data-bs-toggle="tab" href="#nestedContent1_3">Server-Side Tagging</a>
                                        </li>
                                    </ul>



                                    <!-- Nested Tab 1 Content -->
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="nestedContent1_1">
                                            <!-- my plan box -->
                                            <div class="myplan-wholebox">
                                                <div class="row align-items-end">
                                                    <div class="col-auto me-auto">
                                                        <div class="myplan-box">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" checked="" type="checkbox" role="switch" id="yearmonth_checkbox">
                                                            </div>
                                                            <p>Monthly | <span>Yearly</span> Get Flat 50% off on all yearly
                                                                plans. </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto ">
                                                        <div class="domain-box">
                                                            <p>Select Number Of Domains</p>
                                                            <div class="choose-domainbox">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1" checked="">
                                                                    <label class="form-check-label" for="inlineRadio1">1</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="5">
                                                                    <label class="form-check-label" for="inlineRadio2">3</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="10">
                                                                    <label class="form-check-label" for="inlineRadio3">5</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- All in one google analytics -->
                                            <div class="pricingcard-wholebox wp-aio">
                                                <div class="row">

                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                        <div class="card">
                                                            <div class="card-body">


                                                                <div class="dynamicprice_box" plan_cat="starter01" boxperiod="yearly" boxdomain="1">
                                                                    <h5 class="card-title">Starter</h5>
                                                                    <p class="text-start my-2 px-3 py-2 plan_summ fs-10"><b>Automate E-commerce, Lead Gen event tracking</b> &amp; reporting. Perfect for managing ads, <b>syncing products real time</b>, and boosting your campaigns</p>
                                                                    <div class="card-price">$99.00/
                                                                        <span>year</span>
                                                                        <span class="offer-price">50% Off</span>


                                                                    </div>

                                                                    <div class="slash-price">Regular Price:
                                                                        <span>$198.00/year</span><br>

                                                                    </div>


                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout/?pid=wpAIO_SY1">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="dynamicprice_box d-none" plan_cat="starter03" boxperiod="yearly" boxdomain="5">
                                                                    <h5 class="card-title">Starter</h5>
                                                                    <p class="text-start my-2 px-3 py-2 plan_summ fs-10"><b>Automate E-commerce, Lead Gen event tracking</b> &amp; reporting. Perfect for managing ads, <b>syncing products real time</b>, and boosting your campaigns</p>
                                                                    <div class="card-price">$199.00/
                                                                        <span>year</span>
                                                                        <span class="offer-price">50% Off</span>

                                                                    </div>
                                                                    <div class="slash-price">Regular Price:
                                                                        <span>$398.00/year</span>
                                                                    </div>





                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout/?pid=wpAIO_SY3">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="dynamicprice_box d-none" plan_cat="starter05" boxperiod="yearly" boxdomain="10">
                                                                    <h5 class="card-title">Starter</h5>
                                                                    <p class="text-start my-2 px-3 py-2 plan_summ fs-10"><b>Automate E-commerce, Lead Gen event tracking</b> &amp; reporting. Perfect for managing ads, <b>syncing products real time</b>, and boosting your campaigns</p>
                                                                    <div class="card-price">$299.00/
                                                                        <span>year</span>
                                                                        <span class="offer-price">50% Off</span>

                                                                    </div>

                                                                    <div class="slash-price">Regular Price:
                                                                        <span>$598.00/year</span>
                                                                    </div>


                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout/?pid=wpAIO_SY5">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="dynamicprice_box d-none" plan_cat="starter05+" boxperiod="yearly" boxdomain="10+">
                                                                    <h5 class="card-title">Starter</h5>
                                                                   
                                                                </div>

                                                                <ul class="feature-listing" style="max-height: 300px !important; overflow-y: scroll;">
                                                                    <h5>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">

                                                                            </button>
                                                                        </div>
                                                                    </h5>

                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="">
                                                                                Pixel and Analytics
                                                                            </button>
                                                                            <ul class="pfeaturesubli ps-2">
                                                                                <li>E-commerce event Datalayer Automation</li>
                                                                                <li>Automated GTM Configuration in Your Own Container</li>
                                                                                <li>GA4 E-Commerce Tracking</li>
                                                                                <li>Lead Form and Contact Tracking</li>
                                                                                <li>Google Ads Enhanced Conversion Tracking</li>
                                                                                <li>Google Ads Dynamic Remarketing Tracking (View Item, Add to Cart, Begin Checkout, Purchase)</li>
                                                                                <li>Facebook Pixel and Other Social Media Pixel Implementation</li>
                                                                                <li>Enable Google Consent Mode V2</li>
                                                                                <ul>
                                                                                </ul>
                                                                            </ul>
                                                                        </div>
                                                                    </li>


                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Set up high-quality product feeds for ad channels like Google, Facebook, and TikTok to expand your reach. This includes product feeds for Google Merchant Center, Facebook Catalog, and TikTok Catalog with automatic sync intervals. Allows up to 500 product sync.">
                                                                                Product Feed
                                                                            </button>
                                                                            <ul class="pfeaturesubli ps-2">
                                                                                <li>Real-Time Product Feed for Google Merchant Center, Facebook Catalogue, TikTok Catalogue (Up to 500 Products)</li>
                                                                                <li>Highest product approval rate</li>
                                                                                <li>Schedule Product Sync</li>
                                                                                <li>Advance Attribute Mapping &amp; Category Mapping</li>
                                                                            </ul>
                                                                        </div>
                                                                    </li>

                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="">
                                                                                Campaign Management
                                                                            </button>
                                                                            <ul class="pfeaturesubli ps-2">
                                                                                <li>Create new Google Ads campaigns</li>
                                                                                <li>Edit existing campaigns for optimization</li>
                                                                                <li>Manage campaign settings and targeting options</li>
                                                                            </ul>
                                                                        </div>
                                                                    </li>

                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="">
                                                                                Dashboards &amp; Insights
                                                                            </button>
                                                                            <ul class="pfeaturesubli ps-2">
                                                                                <li>GA4 E-Commerce Reporting</li>
                                                                                <li>Google Ads Conversion Reporting</li>
                                                                                <li>Schedule Email Reports</li>
                                                                            </ul>
                                                                        </div>
                                                                    </li>

                                                                </ul>
                                                                <div class="features-link">
                                                                    <a href="#seeallfeatures">Compare All Features</a>
                                                                </div>

                                                                <div class="dynamicprice_box" boxperiod="yearly" boxdomain="1">

                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout/?pid=wpAIO_SY1">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="5">

                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout/?pid=wpAIO_SY3">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10">

                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout/?pid=wpAIO_SY5">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10+">
                                                                   
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                        <div class="card">
                                                            <div class="card-body">


                                                                <div class="dynamicprice_box" plan_cat="professional01" boxperiod="yearly" boxdomain="1">
                                                                    <h5 class="card-title">Professional </h5>
                                                                    <p class="text-start my-2 px-3 py-2 plan_summ fs-10">Simplify e-commerce and lead gen event tracking with real-time product syncing. Get advanced ad performance with <b>CAPI integration</b> for Facebook, Snapchat &amp; TikTok</p>
                                                                    <div class="card-price">$199.00/
                                                                        <span>year</span>
                                                                        <span class="offer-price">50% Off</span>
                                                                    </div>

                                                                    <div class="slash-price">Regular Price:
                                                                        <span>$398.00/year</span>
                                                                    </div>






                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout/?pid=wpAIO_PY1">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="dynamicprice_box d-none" plan_cat="professional03" boxperiod="yearly" boxdomain="5">
                                                                    <h5 class="card-title">Professional </h5>
                                                                    <p class="text-start my-2 px-3 py-2 plan_summ fs-10">Simplify e-commerce and lead gen event tracking with real-time product syncing. Get advanced ad performance with <b>CAPI integration</b> for Facebook, Snapchat &amp; TikTok</p>
                                                                    <div class="card-price">$299.00/ <span>year</span>
                                                                        <span class="offer-price">50% Off</span>

                                                                    </div>


                                                                    <div class="slash-price">Regular Price:
                                                                        <span>$598.00/year</span>
                                                                    </div>



                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout/?pid=wpAIO_PY3">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="dynamicprice_box d-none" plan_cat="professional05" boxperiod="yearly" boxdomain="10">
                                                                    <h5 class="card-title">Professional </h5>
                                                                    <p class="text-start my-2 px-3 py-2 plan_summ fs-10">Simplify e-commerce and lead gen event tracking with real-time product syncing. Get advanced ad performance with <b>CAPI integration</b> for Facebook, Snapchat &amp; TikTok</p>
                                                                    <div class="card-price">$399.00/ <span>year</span>
                                                                        <span class="offer-price">50% Off</span>

                                                                    </div>


                                                                    <div class="slash-price">Regular Price:
                                                                        <span>$798.00/year</span>
                                                                    </div>



                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout/?pid=wpAIO_PY5">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="dynamicprice_box d-none" plan_cat="professional05+" boxperiod="yearly" boxdomain="10+">
                                                                    <h5 class="card-title">Professional </h5>
                                                                   
                                                                </div>



                                                                <ul class="feature-listing custom-scrollbar">


                                                                    <h5>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                                Everything in Starter ➡ AND:
                                                                            </button>
                                                                        </div>
                                                                    </h5>
                                                                    <span>+</span>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="">
                                                                                Facebook Pixel &amp; Conversions API - FBCAPI
                                                                            </button>
                                                                            <ul class="pfeaturesubli ps-2">
                                                                                <li>Provides Advance Event Match Quality</li>
                                                                                <li>Improved Data Accuracy and Attribution</li>
                                                                                <li>Reduced Data Loss</li>
                                                                                <ul>
                                                                                </ul>
                                                                            </ul>
                                                                        </div>
                                                                    </li>

                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="">
                                                                                TikTok Pixel and Events API Tracking
                                                                            </button>
                                                                            <ul class="pfeaturesubli ps-2">
                                                                                <li>Provides Advance Event Match Quality</li>
                                                                                <li>Improved Data Accuracy and Attribution</li>
                                                                                <li>Reduced Data Loss</li>
                                                                                <ul>
                                                                                </ul>
                                                                            </ul>
                                                                        </div>
                                                                    </li>

                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="">
                                                                                Snapchat Pixel and Conversion API
                                                                            </button>
                                                                            <ul class="pfeaturesubli ps-2">
                                                                                <li>Provides Advance Event Match Quality</li>
                                                                                <li>Improved Data Accuracy and Attribution</li>
                                                                                <li>Reduced Data Loss</li>
                                                                                <ul>
                                                                                </ul>
                                                                            </ul>
                                                                        </div>
                                                                    </li>


                                                                </ul>
                                                                <div class="features-link">
                                                                    <a href="#seeallfeatures">Compare All Features</a>
                                                                </div>

                                                                <div class="dynamicprice_box" boxperiod="yearly" boxdomain="1">
                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout/?pid=wpAIO_PY1">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="5">
                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout/?pid=wpAIO_PY3">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10">
                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout/?pid=wpAIO_PY5">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10+">
                                                                   
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                        <div class="card">
                                                            <div class="card-body">

                                                                <div class="dynamicprice_box" plan_cat="enterprise01" boxperiod="yearly" boxdomain="1">
                                                                    <h5 class="card-title">Enterprise</h5>
                                                                    <p class="text-start my-2 px-3 py-2 plan_summ fs-10"><b>Faster page load with server-side GTM</b>, automate e-commerce &amp; lead tracking. Handles event &amp; conversion tracking for GA4,Google Ads,Facebook &amp; more paltforms</p>

                                                                    <div class="card-price">$499.00/
                                                                        <span>year</span>
                                                                        <span class="offer-price">50% Off</span>

                                                                    </div>
                                                                    <div class="slash-price">Regular Price:
                                                                        <span>$998.00/year</span>

                                                                    </div>



                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout/?pid=wpAIO_EY1">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="dynamicprice_box d-none" plan_cat="enterprise03" boxperiod="yearly" boxdomain="5">
                                                                    <h5 class="card-title">Enterprise</h5>
                                                                    <p class="text-start my-2 px-3 py-2 plan_summ fs-10"><b>Faster page load with server-side GTM</b>, automate e-commerce &amp; lead tracking. Handles event &amp; conversion tracking for GA4,Google Ads,Facebook &amp; more paltforms</p>

                                                                   
                                                                </div>

                                                                <div class="dynamicprice_box d-none" plan_cat="enterprise05" boxperiod="yearly" boxdomain="10">
                                                                    <h5 class="card-title">Enterprise</h5>
                                                                    <p class="text-start my-2 px-3 py-2 plan_summ fs-10"><b>Faster page load with server-side GTM</b>, automate e-commerce &amp; lead tracking. Handles event &amp; conversion tracking for GA4,Google Ads,Facebook &amp; more paltforms</p>
                                                                   
                                                                    
                                                                </div>
                                                                <div class="dynamicprice_box d-none" plan_cat="enterprise05+" boxperiod="yearly" boxdomain="10+">
                                                                    <h5 class="card-title">Enterprise</h5>
                                                                   
                                                                </div>



                                                                <ul class="feature-listing custom-scrollbar">
                                                                    <h5>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                                Everything in Professional ➡ AND:
                                                                            </button>
                                                                        </div>
                                                                    </h5>
                                                                    <span>+</span>

                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="">
                                                                                Serverside Tagging Features
                                                                            </button>
                                                                            <ul class="pfeaturesubli ps-2">
                                                                                <li>Automation of <b>Server Container</b> for SGTM</li>
                                                                                <li>Automation of <b>Web Container</b> for SGTM</li>
                                                                                <li><b>Google Cloud Hosting</b> for SGTM</li>
                                                                                <li>Server E-Commerce Data Layer Automation</li>
                                                                                <li>Custom GTM Loader</li>
                                                                                <li>Server Side Tracking for <b>GA4</b></li>
                                                                                <li>Server Side Tracking for <b>Google Ads</b></li>
                                                                                <li>Server Side Tracking for <b>Facebook Ads and CAPI</b></li>
                                                                                <li>Server Side Tracking for <b>Snapchat Ads and CAPI</b></li>
                                                                                <li>Server Side Tracking for <b>TikTok Events API</b></li>
                                                                                <ul>
                                                                                </ul>
                                                                            </ul>
                                                                        </div>
                                                                    </li>

                                                                </ul>
                                                                <div class="features-link">
                                                                    <a href="#seeallfeatures">Compare All Features</a>
                                                                </div>
                                                                <div class="dynamicprice_box" plan_cat="enterprise01" boxperiod="yearly" boxdomain="1">
                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout/?pid=wpAIO_EY1">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="dynamicprice_box d-none" plan_cat="enterprise03" boxperiod="yearly" boxdomain="5">
                                                                    <!-- <div class="getstarted-btn">
                                                                    <a class="btn btn-secondary common-btn">
                                                                        GET STARTED
                                                                    </a>
                                                                </div> -->
                                                                   
                                                                </div>

                                                                <div class="dynamicprice_box d-none" plan_cat="enterprise05" boxperiod="yearly" boxdomain="10">
                                                                    <!-- <div class="getstarted-btn">
                                                                    <a class="btn btn-secondary common-btn">
                                                                        GET STARTED
                                                                    </a>
                                                                </div> -->
                                                                   
                                                                </div>
                                                                <div class="dynamicprice_box d-none" plan_cat="enterprise05+" boxperiod="yearly" boxdomain="10+">
                                                                   
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="nestedContent1_2">
                                            <!-- my plan box -->
                                            <div class="myplan-wholebox">
                                                <div class="row align-items-end">
                                                    <div class="col-auto me-auto">
                                                        <div class="myplan-box">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" checked="" type="checkbox" role="switch" id="yearmonth_checkbox">
                                                            </div>
                                                            <p>Monthly | <span>Yearly</span> Get Flat 50% off on all yearly
                                                                plans. </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto ">
                                                        <div class="domain-box">
                                                            <p>Select Number Of Domains</p>
                                                            <div class="choose-domainbox">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions_pfm" id="inlineRadio5" value="1" checked="">
                                                                    <label class="form-check-label" for="inlineRadio5">1</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions_pfm" id="inlineRadio6" value="5">
                                                                    <label class="form-check-label" for="inlineRadio6">5</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions_pfm" id="inlineRadio7" value="10">
                                                                    <label class="form-check-label" for="inlineRadio7">10</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions_pfm" id="inlineRadio8" value="10+">
                                                                    <label class="form-check-label" for="inlineRadio8">10+</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Product Feed Manager -->
                                            <div class="pricingcard-wholebox wp-pfm">
                                                <div class="row">
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                        <div class="card">
                                                            <div class="card-body">


                                                                <div class="dynamicprice_box" boxperiod="yearly" boxdomain="1">
                                                                    <h5 class="card-title">Starter</h5>

                                                                    <!-- <p class="card-text">1 Active Website</p> -->

                                                                    <div class="card-price">$49.00/ <span>year</span>
                                                                        <div class="offer-price">50% Off</div>
                                                                    </div>

                                                                    <div class="slash-price">Regular Price:
                                                                        <span>$98.00/year</span>
                                                                    </div>

                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout?pid=wpPFM_SY1">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="5">
                                                                    <h5 class="card-title">Starter</h5>
                                                                    <!-- <p class="card-text">5 Active Websites</p> -->
                                                                    <div class="card-price">$99.00/
                                                                        <span>year</span>
                                                                        <span class="offer-price">50% Off</span>


                                                                    </div>
                                                                    <div class="slash-price">Regular Price:
                                                                        <span>$198.00/year</span>
                                                                    </div>



                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout?pid=wpPFM_SY5">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10">
                                                                    <h5 class="card-title">Starter</h5>
                                                                    <!-- <p class="card-text">10 Active Websites</p> -->
                                                                    <div class="card-price">$199.00/ <span>year</span>
                                                                        <div class="offer-price">50% Off</div>
                                                                    </div>
                                                                    <div class="slash-price">Regular Price:
                                                                        <span>$398.00/year</span>
                                                                    </div>
                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout?pid=wpPFM_SY10">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10+">
                                                                    <h5 class="card-title">Starter</h5>
                                                                   
                                                                </div>

                                                                <ul class="feature-listing custom-scrollbar">

                                                                    <span>+</span>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Set up high quality product feed for Ad Channels like Google.">
                                                                                Product feed Google Shopping
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Set up high quality product feed for Ad Channels like Tiktok.">
                                                                                Product feed for TikTok
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Keep your product details up to date in Google Merchant Center, Facebook Catalog and Tiktok Catalog. Set time interval for auto product sync.">
                                                                                Schedule product sync
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Upto 500 products sync">
                                                                                Upto 500 products sync
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <span>+</span>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Create and manage campaigns based on feeds directly in Google Ads.">
                                                                                Feed based Camapign Management
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                                <div class="features-link">
                                                                    <a href="#seeallfeatures-table">Compare All Features</a>
                                                                </div>
                                                                <div class="dynamicprice_box" boxperiod="yearly" boxdomain="1">

                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout?pid=wpPFM_SY1">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="5">

                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout?pid=wpPFM_SY5">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10">

                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout?pid=wpPFM_SY10">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10+">
                                                                   
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


                                                                <div class="dynamicprice_box" boxperiod="yearly" boxdomain="1">
                                                                    <h5 class="card-title">Professional </h5>

                                                                    <div class="card-price">$69.00/ <span>year</span>
                                                                        <div class="offer-price">50% Off</div>
                                                                    </div>

                                                                    <div class="slash-price">Regular Price:
                                                                        <span>$138.00/year</span>
                                                                    </div>

                                                                    <!-- <p class="card-text">1 Active Website</p> -->
                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout?pid=wpPFM_PY1">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="5">
                                                                    <h5 class="card-title">Professional </h5>
                                                                    <!-- <p class="card-text">5 Active Websites</p> -->
                                                                    <div class="card-price">$149.00/
                                                                        <span>year</span>
                                                                        <span class="offer-price">50% Off</span>


                                                                    </div>
                                                                    <div class="slash-price">Regular Price:
                                                                        <span>$298.00/year</span>
                                                                    </div>


                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout?pid=wpPFM_PY5">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10">
                                                                    <h5 class="card-title">Professional </h5>

                                                                    <div class="card-price">$249.00/ <span>year</span>
                                                                        <div class="offer-price">50% Off</div>
                                                                    </div>

                                                                    <div class="slash-price">Regular Price:
                                                                        <span>$498.00/year</span>
                                                                    </div>

                                                                    <!-- <p class="card-text">10 Active Websites</p> -->
                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout?pid=wpPFM_PY10">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10+">
                                                                    <h5 class="card-title">Professional </h5>
                                                                   
                                                                </div>



                                                                <ul class="feature-listing custom-scrollbar">
                                                                    <span>+</span>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Set up high quality product feed for Ad Channels like Google.">
                                                                                Product feed Google Shopping
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Set up high quality product feed for Ad Channels like Tiktok.">
                                                                                Product feed for Tiktok
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Keep your product details up to date in Google Merchant Center, Tiktok Catalog. Set time interval for auto product sync.">
                                                                                Schedule product sync
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Upto 5000 products sync">
                                                                                Upto 5000 products sync
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Create and manage campaigns based on feeds directly in Google Ads.">
                                                                                Feed based Campaign Management
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Compatible with 50+ plugins so that you can sync any attribute you want. Reach out if you don't find specific attributes.">
                                                                                50+ plugins compatibility
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                                <div class="features-link">
                                                                    <a href="#seeallfeatures-table">Compare All Features</a>
                                                                </div>
                                                                <div class="dynamicprice_box" boxperiod="yearly" boxdomain="1">

                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout?pid=wpPFM_PY1">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="5">

                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout?pid=wpPFM_PY5">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10">

                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout?pid=wpPFM_PY10">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10+">
                                                                   
                                                                </div>
                                                                <div class="popular-plan">
                                                                    <p>Most Popular</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="dynamicprice_box" boxperiod="yearly" boxdomain="1">
                                                                    <h5 class="card-title">Enterprise</h5>
                                                                    <!-- <p class="card-text">1 Active Website</p> -->

                                                                    <div class="card-price">$99.00/
                                                                        <span>year</span>
                                                                        <span class="offer-price">50% Off</span>
                                                                    </div>

                                                                    <div class="slash-price">Regular Price:
                                                                        <span>$198.00/year</span>
                                                                    </div>


                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout?pid=planDpf_1_y">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="5">
                                                                    <h5 class="card-title">Enterprise</h5>
                                                                    <!-- <p class="card-text">5 Active Websites</p> -->
                                                                    <div class="card-price">$199.00/
                                                                        <span>year</span>

                                                                    </div>
                                                                    <div class="slash-price">Regular Price:
                                                                        <span>$398.00/year</span>
                                                                    </div>



                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout?pid=planDpf_2_y">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10">
                                                                    <h5 class="card-title">Enterprise</h5>

                                                                    <div class="card-price">$299.00/
                                                                        <span>year</span>
                                                                        <div class="offer-price">50% Off</div>
                                                                    </div>

                                                                    <div class="slash-price">Regular Price:
                                                                        <span>$598.00/year</span>
                                                                    </div>
                                                                    <!-- <p class="card-text">10 Active Websites</p> -->
                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout?pid=planDpf_3_y">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10+">
                                                                    <h5 class="card-title">Enterprise</h5>
                                                                   
                                                                </div>



                                                                <ul class="feature-listing custom-scrollbar">

                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Set up high quality product feed for Ad Channels like Google.">
                                                                                Product feed Google Shopping
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <span>+</span>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Set up high quality product feed for Ad Channels like Tiktok.">
                                                                                Product feed for Tiktok
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Keep your product details up to date in Google Merchant Center, Tiktok Catalog. Set time interval for auto product sync.">
                                                                                Schedule product sync
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                                Unlimited number of products sync
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Create and manage campaigns based on feeds directly in Google Ads.">
                                                                                Feed based Campaign Management
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Compatible with 50+ plugins so that you can sync any attribute you want. Reach out if you don't find specific attributes.">
                                                                                50+ plugins compatibility
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                                <div class="features-link">
                                                                    <a href="#seeallfeatures-table">Compare All Features</a>
                                                                </div>
                                                                <div class="dynamicprice_box" boxperiod="yearly" boxdomain="1">

                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout?pid=planDpf_1_y">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="5">

                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout?pid=planDpf_2_y">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10">

                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout?pid=planDpf_3_y">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10+">
                                                                   
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
                                        <div class="tab-pane fade" id="nestedContent1_3">
                                            <!-- my plan box -->
                                            <div class="myplan-wholebox">
                                                <div class="row align-items-end">
                                                    <div class="col-auto me-auto">
                                                        <div class="myplan-box">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" checked="" type="checkbox" role="switch" id="yearmonth_checkbox">
                                                            </div>
                                                            <p>Monthly | <span>Yearly</span> Get Flat 50% off on all yearly
                                                                plans. </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto ">
                                                        <div class="domain-box">
                                                            <p>Select Number Of Domains</p>
                                                            <div class="choose-domainbox">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions_sst" id="inlineRadio9" value="1" checked="">
                                                                    <label class="form-check-label" for="inlineRadio9">1</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions_sst" id="inlineRadio10" value="5">
                                                                    <label class="form-check-label" for="inlineRadio10">3</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions_sst" id="inlineRadio11" value="10">
                                                                    <label class="form-check-label" for="inlineRadio11">5</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions_sst" id="inlineRadio12" value="10+">
                                                                    <label class="form-check-label" for="inlineRadio12">5+</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Server-Side tagging -->
                                            <div class="pricingcard-wholebox wp-serverside">
                                                <div class="row">

                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-12 mx-auto">

                                                        <div class="card active">
                                                            <div class="card-body">

                                                                <div class="dynamicprice_box" plan_cat="enterprise01" boxperiod="yearly" boxdomain="1">
                                                                    <h5 class="card-title">Server Side Tagging</h5>

                                                                    <div class="card-price">$499.00/ <span>year</span>
                                                                        <div class="offer-price">50% Off</div>
                                                                    </div>

                                                                    <div class="slash-price">Regular Price:
                                                                        <span>$998.00/year</span>
                                                                    </div>

                                                                    <!-- <p class="card-text">1 Active Website</p> -->
                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout/?pid=wpAIO_EY1">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="dynamicprice_box d-none" plan_cat="enterprise03" boxperiod="yearly" boxdomain="5">
                                                                    <h5 class="card-title">Server Side Tagging</h5>
                                                                   
                                                                </div>

                                                                <div class="dynamicprice_box d-none" plan_cat="enterprise05" boxperiod="yearly" boxdomain="10">
                                                                    <h5 class="card-title">Server Side Tagging</h5>
                                                                    
                                                                </div>
                                                                <div class="dynamicprice_box d-none" plan_cat="enterprise05+" boxperiod="yearly" boxdomain="10+">
                                                                    <h5 class="card-title">Server Side Tagging</h5>
                                                                   
                                                                </div>



                                                                <ul class="feature-listing custom-scrollbar">
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Complete automation of Server-Side tagging setup. No coding, no expertise needed.">
                                                                                End to end Server-Side tracking automation
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Powerful Google Cloud hosting for 100% uptime and security.">
                                                                                Google cloud hosting
                                                                            </button>
                                                                        </div>
                                                                    </li>

                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Automates complete GA4 e-commerce tracking. The most accurate and efficient GA4 solution in the market.">
                                                                                GA4 E-Commerce Tracking
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Quick &amp; One click automation of server and web GTM container and datalayer for mentioned channels.">
                                                                                sGTM automation for Google Analytics 4, Google Ads tracking, Facebook &amp; Snapchat Pixel
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="">
                                                                                Enhanced Conversion Tracking for Google Ads
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="">
                                                                                Custom events tracking
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="">
                                                                                Unlimited number of products sync
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="">
                                                                                Ecommerce Reporting &amp; AI Powered Insights
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="">
                                                                                Event Tracking Wizard
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="">
                                                                                Custom loader
                                                                            </button>
                                                                        </div>
                                                                    </li>


                                                                </ul>
                                                                <!-- <div class="features-link">
                                                                <a href="#seeallfeatures">Compare All Features</a>
                                                            </div> -->
                                                                <div class="dynamicprice_box" plan_cat="enterprise01" boxperiod="yearly" boxdomain="1">
                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://www.conversios.io/checkout/?pid=wpAIO_EY1">
                                                                            GET STARTED
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="dynamicprice_box d-none" plan_cat="enterprise03" boxperiod="yearly" boxdomain="5">
                                                                    <!-- <div class="getstarted-btn">
                                                                    <a class="btn btn-secondary common-btn">
                                                                        GET STARTED
                                                                    </a>
                                                                </div> -->
                                                                   
                                                                </div>

                                                                <div class="dynamicprice_box d-none" plan_cat="enterprise05" boxperiod="yearly" boxdomain="10">
                                                                    <!-- <div class="getstarted-btn">
                                                                    <a class="btn btn-secondary common-btn">
                                                                        GET STARTED
                                                                    </a>
                                                                </div> -->
                                                                   
                                                                </div>
                                                                <div class="dynamicprice_box d-none" plan_cat="enterprise05+" boxperiod="yearly" boxdomain="10+">
                                                                   
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- Tab3 -->
                                <div class="tab-pane fade shopify" id="content3" role="tabpanel" aria-labelledby="#tab3">
                                    <!-- Nested Tabs for Tab 2 -->
                                    <!-- <ul class="nav nav-tabs" id="nestedTabs3">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="nestedTab3_1" data-bs-toggle="tab"
                                            href="#nestedContent3_1">
                                            Google Analytics App For Shopify
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="nestedTab3_2" data-bs-toggle="tab"
                                            href="#nestedContent3_2">
                                            Pixel Manager App For Shopify
                                        </a>
                                    </li>
                                </ul> -->

                                    <!-- Nested Tab 2 Content -->
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="nestedContent3_1">
                                            <div class="pricingcard-wholebox shopify">
                                                <div class="row">
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                        <div class="card" id="GA4">
                                                            <div class="card-body">
                                                                <div class="dynamicprice_box s_d">
                                                                    <h5 class="card-title">GA4 Plus</h5>
                                                                    <div class="slash-price">Regular Price:
                                                                        <span>$198.00/year</span>
                                                                    </div>
                                                                    <div class="card-price">$99.00/
                                                                        <span>year</span>
                                                                    </div>
                                                                    <div class="offer-price">50% Off</div>



                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://apps.shopify.com/google-analytics-4?utm_source=pricing_page_shopify&amp;utm_medium=google_analytics_4&amp;utm_campaign=start_your_free_trail" target="_blank">
                                                                            Start Your Free Trial
                                                                        </a>
                                                                    </div>
                                                                </div>



                                                                <ul class="feature-listing custom-scrollbar">
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="One click automation of your own GTM container for faster page speed and flexibility. Create tags, triggers &amp; variables based on your needs.">
                                                                                Automation of GTM container
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Automates complete e-commerce datalayer for your Shopify  stores. Single unified datalayer automation that can be used with all the analytics and ads tracking.">
                                                                                E-Commerce data layer automation
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Automates complete GA4 e-commerce tracking. The most accurate and efficient GA4 solution in the market.">
                                                                                GA4 E-Commerce Tracking
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <span>+</span>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Know about Order, Product, Source/Medium, Google Ads and Campaign Performance Report from shopify admin. Enables data driven decision making to increase conversion %.">
                                                                                E-Commerce reporting
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <span>+</span>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                                AI powered Insights
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                                Smart email reports
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Reach out to our professional team for custom events tracking like form tracking, conversion tracking for different goals.">
                                                                                Custom events tracking
                                                                            </button>
                                                                        </div>
                                                                    </li>

                                                                </ul>

                                                                <div class="dynamicprice_box s_d">

                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://apps.shopify.com/google-analytics-4?utm_source=pricing_page_shopify&amp;utm_medium=google_analytics_4&amp;utm_campaign=start_your_free_trail" target="_blank">
                                                                            Start Your Free Trial
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="popular-plan">
                                                                    <p style="opacity:0">Most Popular</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                        <div class="card" id="pixel_growth">
                                                            <div class="card-body">
                                                                <div class="dynamicprice_box s_d">
                                                                    <h5 class="card-title">Pixel Growth</h5>
                                                                    <div class="slash-price">Regular Price:
                                                                        <span>$398.00/year</span>
                                                                    </div>
                                                                    <div class="card-price">$199.00/ <span>year</span></div>

                                                                    <div class="offer-price">50% Off</div>
                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://apps.shopify.com/conversios-all-in-one-pixel?utm_source=pricing_page_shopify&amp;utm_medium=all_in_one_pixel&amp;utm_campaign=start_your_free_trail" target="_blank">
                                                                            Start Your Free Trial
                                                                        </a>
                                                                    </div>
                                                                </div>




                                                                <ul class="feature-listing custom-scrollbar">

                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="One click automation of your own GTM container for faster page speed and flexibility. Create tags, triggers &amp; variables based on your needs.">
                                                                                Automation of GTM container
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Automates complete e-commerce datalayer for your Shopify stores. Single unified datalayer automation that can be used with all the analytics and ads tracking.">
                                                                                E-Commerce datalayer automation
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Automates complete GA4 e-commerce tracking. The most accurate and efficient GA4 solution in the market.">
                                                                                GA4 E-Commerce Tracking
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <span>+</span>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Know about e-commerce funnel, product, source &amp; order performance reports   from Shopify admin. Enables data driven decision making to increase conversion %.">
                                                                                E-Commerce reporting
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <span>+</span>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Enables conversion tracking for Ads channels like Google Ads, Meta (Facebook + Instagram), Snapchat, Tiktok, Pinterest, Microsoft Ads, Twitter . Measures and optimizes your campaign performance.">
                                                                                Conversion tracking for 6+ Ads Tracking
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Facebook Conversions API integration for all the E-Commerce events and conversions. Enhances accurate audience building, campaign tracking and performance.">
                                                                                Facebook Conversions API
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Builds dynamic remarketing audiences in ad channels like Google Ads, Meta, Snapchat, Tiktok, Pinterest, Microsoft Ads &amp; Twitter. Build and grow audiences based on the visitor browsing.">
                                                                                Dynamic Audience building (6+ Ads Channels)
                                                                            </button>
                                                                        </div>
                                                                    </li>

                                                                </ul>

                                                                <div class="dynamicprice_box s_d">

                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://apps.shopify.com/conversios-all-in-one-pixel?utm_source=pricing_page_shopify&amp;utm_medium=all_in_one_pixel&amp;utm_campaign=start_your_free_trail" target="_blank">
                                                                            Start Your Free Trial
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="popular-plan">
                                                                    <p style="opacity:0">Most Popular</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                        <div class="card active" id="sst">
                                                            <div class="card-body">
                                                                <div class="dynamicprice_box s_d">
                                                                    <h5 class="card-title">SST Enhanced</h5>
                                                                    <div class="slash-price">Regular Price:
                                                                        <span>$798.00/year</span>
                                                                    </div>
                                                                    <div class="card-price">$399.00/ <span>year</span></div>
                                                                    <div class="offer-price">50% Off</div>
                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://apps.shopify.com/conversios-server-side-tagging?utm_source=pricing_page_shopify&amp;utm_medium=server_side_tagging&amp;utm_campaign=start_your_free_trail" target="_blank">
                                                                            Start Your Free Trial
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <ul class="feature-listing custom-scrollbar">

                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Complete automation of Server-Side tagging setup. No coding, no expertise needed.">
                                                                                End to end Server-Side tagging automation
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Powerful Google Cloud hosting for 100% uptime and security.">
                                                                                Google cloud hosting
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                                Adopt To First Party Cookies
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <span>+</span>

                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Quick &amp; One click automation of server and web GTM container and datalayer for mentioned channels.">
                                                                                sGTM automation for

                                                                            </button>
                                                                            <ul class="sub-list">
                                                                                <li>- Google Analytics 4</li>
                                                                                <li>- Google Ads Tracking</li>
                                                                                <li>- Facebook pixel and conversions API
                                                                                </li>
                                                                                <li>- TikTok pixel and events API</li>
                                                                                <li>- Snapchat pixel and conversions API
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                                Custom Loader &amp; Custom Domain Mapping

                                                                            </button>

                                                                        </div>
                                                                    </li>

                                                                </ul>

                                                                <div class="dynamicprice_box s_d">

                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://apps.shopify.com/conversios-server-side-tagging?utm_source=pricing_page_shopify&amp;utm_medium=server_side_tagging&amp;utm_campaign=start_your_free_trail" target="_blank">
                                                                            Start Your Free Trial
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="popular-plan">
                                                                    <p style="opacity:0">Most Popular</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                        <div class="card" id="sst">
                                                            <div class="card-body">
                                                                <div class="dynamicprice_box s_d">
                                                                    <h5 class="card-title">Meta Pixel</h5>
                                                                    <div class="slash-price">Regular Price:
                                                                        <span>$118.00/year</span>
                                                                    </div>
                                                                    <div class="card-price">$59.00/ <span>year</span></div>
                                                                    <div class="offer-price">50% Off</div>
                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://apps.shopify.com/conversios-meta-conversion-api?utm_source=pricing_page_shopify&amp;utm_medium=meta_conversion_api&amp;utm_campaign=start_your_free_trail" target="_blank">
                                                                            Start Your Free Trial
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <ul class="feature-listing custom-scrollbar">

                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                                GTM based integration
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                                Facebook Pixel automation
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Facebook Conversions API integration for all the E-Commerce events and conversions. Enhances accurate audience building, campaign tracking and performance.">
                                                                                Facebook Conversions API
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <span>+</span>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Build dynamic remarketing audiences for targeted messaging. for Build and grow audiences based on the visitor browsing.">
                                                                                Dynamic Audience building
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Enables conversion tracking for Ads channels like Meta (Facebook). Measures and optimizes your campaign performance.">
                                                                                Conversion tracking for Facebook Ads
                                                                                Tracking
                                                                            </button>
                                                                        </div>
                                                                    </li>

                                                                </ul>

                                                                <div class="dynamicprice_box s_d">

                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://apps.shopify.com/conversios-meta-conversion-api?utm_source=pricing_page_shopify&amp;utm_medium=meta_conversion_api&amp;utm_campaign=start_your_free_trail" target="_blank">
                                                                            Start Your Free Trial
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="popular-plan">
                                                                    <p style="opacity:0">Most Popular</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                                        <div class="card" id="sst">
                                                            <div class="card-body">
                                                                <div class="dynamicprice_box s_d">
                                                                    <h5 class="card-title">TikTok Pixel</h5>
                                                                    <div class="slash-price">Regular Price:
                                                                        <span>$118.00/year</span>
                                                                    </div>
                                                                    <div class="card-price">$59.00/ <span>year</span></div>
                                                                    <div class="offer-price">50% Off</div>
                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://apps.shopify.com/conversios-tiktok-events?utm_source=pricing_page_shopify&amp;utm_medium=tiktok_events&amp;utm_campaign=start_your_free_trail" target="_blank">
                                                                            Start Your Free Trial
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <ul class="feature-listing custom-scrollbar">

                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="TikTok Conversions API integration for all the E-Commerce events and conversions. Enhances accurate audience building, campaign tracking and performance.">
                                                                                TikTok Conversions API
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Build dynamic remarketing audiences for targeted messaging. for Build and grow audiences based on the visitor browsing.">
                                                                                Dynamic Audience building
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Enables conversion tracking for Ads channels like TikTok. Measures and optimizes your campaign performance.">
                                                                                Conversion tracking for TikTok Ads Tracking
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <span>+</span>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                                Automate web and Server-Side tracking
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                                TikTok Pixel Integration
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                                Event data Advanced Matching
                                                                            </button>

                                                                        </div>
                                                                    </li>
                                                                    <span>+</span>
                                                                    <li>
                                                                        <div class="tooltip-box">
                                                                            <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                                Tiktok native integration
                                                                            </button>

                                                                        </div>
                                                                    </li>

                                                                </ul>

                                                                <div class="dynamicprice_box s_d">

                                                                    <div class="getstarted-btn">
                                                                        <a class="btn btn-secondary common-btn" href="https://apps.shopify.com/conversios-tiktok-events?utm_source=pricing_page_shopify&amp;utm_medium=tiktok_events&amp;utm_campaign=start_your_free_trail" target="_blank">
                                                                            Start Your Free Trial
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="popular-plan">
                                                                    <p style="opacity:0">Most Popular</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>





                    </div>

                </div>

                <!-- compare feature -->
                <div class="allinone-ggogle compare-table" id="wp-aio" style="display: block;">
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
                                                    <table id="sticky-header-tbody-id" class="feature-table table">
                                                        <thead id="con_stick_this">
                                                            <tr>
                                                                <th scope="col" class="th-data">
                                                                    <div class="feature-box">
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <div class="card-icon">
                                                                                    <img src="https://www.conversios.io/wp-content/themes/conversios2023/assets/convo-images/pricing/privacy.png" alt="" class="img-fluid">
                                                                                </div>
                                                                                <h5 class="card-title">100% No Risk <br>
                                                                                    Moneyback Guarantee
                                                                                </h5>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </th>
                                                                <th scope="col" class="thd-data">
                                                                    <div class="feature-box">
                                                                        <div class="dynamicprice_box" plan_cat="enterprise01" boxperiod="yearly" boxdomain="1">
                                                                            <div class="title card-title">Enterprise</div>
                                                                            <!-- <p class="sub-title card-text">1 Active Website
                                                                        </p> -->
                                                                            <div class="strike-price">Regular Price: <span>
                                                                                    $998.00</span>
                                                                            </div>
                                                                            <div class="price">$499.00/ <span>year</span>
                                                                            </div>
                                                                            <div class="offer-price">Flat 50% Off Applied
                                                                            </div>
                                                                            <div class="getstarted-btn get-it-now">
                                                                                <a class="label btn btn-secondary common-btn" href="https://www.conversios.io/checkout/?pid=wpAIO_EY1">
                                                                                    Get It Now
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dynamicprice_box d-none" plan_cat="enterprise03" boxperiod="yearly" boxdomain="5">
                                                                            <div class="title card-title">Enterprise</div>
                                                                            <!-- <p class="sub-title card-text">3 Active Websites
                                                                        </p> -->

                                                                            <div class="strike-price">Regular Price: <span>
                                                                                    $XXXX</span>
                                                                            </div>

                                                                            <div class="offer-price">Flat 50% Off Applied
                                                                            </div>
                                                                            <div class="getstarted-btn get-it-now">
                                                                                <a class="label btn btn-secondary common-btn">
                                                                                    Get It Now
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dynamicprice_box d-none" plan_cat="enterprise05" boxperiod="yearly" boxdomain="10">
                                                                            <div class="title card-title">Enterprise</div>
                                                                            <p class="sub-title card-text">5 Active
                                                                                Websites
                                                                            </p>
                                                                            <div class="strike-price">Regular Price: <span>
                                                                                    $XXXX</span>
                                                                            </div>
                                                                            <div class="price">$XXXX/ <span>year</span>
                                                                                <span class="offer-price">Flat 50% Off Applied
                                                                                </span>
                                                                            </div>

                                                                            <div class="getstarted-btn get-it-now">
                                                                                <a class="label btn btn-secondary common-btn">
                                                                                    Get It Now
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dynamicprice_box d-none" plan_cat="enterprise05+" boxperiod="yearly" boxdomain="10+">
                                                                            <div class="title card-title">Enterprise</div>
                                                                            <p class="card-text contactus">
                                                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                                                    Contact Us
                                                                                </button>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </th>
                                                                <th scope="col" class="thd-data">
                                                                    <div class="feature-box">
                                                                        <div class="dynamicprice_box" plan_cat="professional01" boxperiod="yearly" boxdomain="1">
                                                                            <div class="title card-title">Professional</div>
                                                                            <!-- <p class="sub-title card-text">1 Active Website
                                                                        </p> -->
                                                                            <div class="strike-price">Regular Price: <span>
                                                                                    $398.00</span>
                                                                            </div>
                                                                            <div class="price">$199.00/ <span>year</span>
                                                                            </div>
                                                                            <div class="offer-price">Flat 50% Off Applied
                                                                            </div>
                                                                            <div class="getstarted-btn get-it-now">
                                                                                <a class="label btn btn-secondary common-btn" href="https://www.conversios.io/checkout/?pid=wpAIO_PY1">
                                                                                    Get It Now
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dynamicprice_box d-none" plan_cat="professional03" boxperiod="yearly" boxdomain="5">
                                                                            <div class="title card-title">Professional</div>
                                                                            <!-- <p class="sub-title card-text">3 Active Websites
                                                                        </p> -->
                                                                            <div class="strike-price">Regular Price: <span>
                                                                                    $598.00</span>
                                                                            </div>
                                                                            <div class="price">$299.00/ <span>year</span>
                                                                            </div>
                                                                            <div class="offer-price">Flat 50% Off Applied
                                                                            </div>
                                                                            <div class="getstarted-btn get-it-now">
                                                                                <a class="label btn btn-secondary common-btn" href="https://www.conversios.io/checkout/?pid=wpAIO_PY3">
                                                                                    Get It Now
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dynamicprice_box d-none" plan_cat="professional05" boxperiod="yearly" boxdomain="10">
                                                                            <div class="title card-title">Professional</div>
                                                                            <p class="sub-title card-text">5 Active
                                                                                Websites
                                                                            </p>
                                                                            <div class="strike-price">Regular Price: <span>
                                                                                    $798.00</span>
                                                                            </div>
                                                                            <div class="price">$399.00/ <span>year</span>
                                                                            </div>
                                                                            <div class="offer-price">Flat 50% Off Applied
                                                                            </div>
                                                                            <div class="getstarted-btn get-it-now">
                                                                                <a class="label btn btn-secondary common-btn" href="https://www.conversios.io/checkout/?pid=wpAIO_PY5">
                                                                                    Get It Now
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dynamicprice_box d-none" plan_cat="professional05+" boxperiod="yearly" boxdomain="10+">
                                                                            <div class="title card-title">Professional</div>
                                                                            <p class="card-text contactus">
                                                                                <!-- Button trigger modal -->
                                                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                                                    Contact Us
                                                                                </button>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </th>
                                                                <th scope="col" class="thd-data">
                                                                    <div class="feature-box">
                                                                        <div class="dynamicprice_box" plan_cat="starter01" boxperiod="yearly" boxdomain="1">
                                                                            <div class="title card-title">Starter</div>
                                                                            <!-- <p class="sub-title card-text">1 Active Website
                                                                        </p> -->
                                                                            <div class="strike-price">Regular Price: <span>
                                                                                    $198.00</span>
                                                                            </div>
                                                                            <div class="price">$99.00/ <span>year</span>
                                                                            </div>
                                                                            <div class="offer-price">Flat 50% Off Applied
                                                                            </div>
                                                                            <div class="getstarted-btn get-it-now">
                                                                                <a class="label btn btn-secondary common-btn" href="https://www.conversios.io/checkout/?pid=wpAIO_SY1">
                                                                                    Get It Now
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dynamicprice_box d-none" plan_cat="starter03" boxperiod="yearly" boxdomain="5">
                                                                            <div class="title card-title">Starter</div>
                                                                            <!-- <p class="sub-title card-text">3 Active Websites
                                                                        </p> -->
                                                                            <div class="strike-price">Regular Price: <span>
                                                                                    $398.00</span>
                                                                            </div>
                                                                            <div class="price">$199.00/ <span>year</span>
                                                                            </div>
                                                                            <div class="offer-price">Flat 50% Off Applied
                                                                            </div>
                                                                            <div class="getstarted-btn get-it-now">
                                                                                <a class="label btn btn-secondary common-btn" href="https://www.conversios.io/checkout/?pid=wpAIO_SY3">
                                                                                    Get It Now
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dynamicprice_box d-none" plan_cat="starter05" boxperiod="yearly" boxdomain="10">
                                                                            <div class="title card-title">Starter</div>
                                                                            <p class="sub-title card-text">5 Active
                                                                                Websites
                                                                            </p>
                                                                            <div class="strike-price">Regular Price: <span>
                                                                                    $598.00</span>
                                                                            </div>
                                                                            <div class="price">$299.00/ <span>year</span>
                                                                            </div>
                                                                            <div class="offer-price">Flat 50% Off Applied
                                                                            </div>
                                                                            <div class="getstarted-btn get-it-now">
                                                                                <a class="label btn btn-secondary common-btn" href="https://www.conversios.io/checkout/?pid=wpAIO_SY5">
                                                                                    Get It Now
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dynamicprice_box d-none" plan_cat="starter05+" boxperiod="yearly" boxdomain="10+">
                                                                            <div class="title card-title">Starter</div>
                                                                            <p class="card-text contactus">
                                                                                <!-- Button trigger modal -->
                                                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                                                    Contact Us
                                                                                </button>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </th>
                                                                <th scope="col" class="thd-data">
                                                                    <div class="feature-box">
                                                                        <div class="dynamicprice_box" boxperiod="yearly" boxdomain="1">
                                                                            <div class="title card-title">Free</div>
                                                                            <!-- <p class="sub-title card-text">1 Active Website
                                                                        </p> -->
                                                                            <div class="strike-price">Regular Price: <span>
                                                                                    $00.00</span></div>
                                                                            <div class="price">$00.00/ <span>year</span>
                                                                            </div>
                                                                            <div class="offer-price" style="opacity: 0; visibility: hidden;">Flat
                                                                                50% Off Applied </div>
                                                                            <div class="getstarted-btn get-it-now">
                                                                                <a class="label btn btn-secondary common-btn" target="_blank" href="https://wordpress.org/plugins/enhanced-e-commerce-for-woocommerce-store/">
                                                                                    Get It Now
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="5">
                                                                            <div class="title card-title">Free</div>
                                                                            <!-- <p class="sub-title card-text">3 Active Websites
                                                                        </p> -->
                                                                            <div class="strike-price">Regular Price: <span>
                                                                                    $00.00</span></div>
                                                                            <div class="price">$00.00/ <span>year</span>
                                                                            </div>
                                                                            <div class="offer-price" style="opacity: 0; visibility: hidden;">Flat
                                                                                50% Off Applied </div>
                                                                            <div class="getstarted-btn get-it-now">
                                                                                <a class="label btn btn-secondary common-btn" href="https://wordpress.org/plugins/enhanced-e-commerce-for-woocommerce-store/">
                                                                                    Get It Now
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10">
                                                                            <div class="title card-title">Free</div>
                                                                            <p class="sub-title card-text">5 Active
                                                                                Websites
                                                                            </p>
                                                                            <div class="strike-price">Regular Price: <span>
                                                                                    $00.00</span></div>
                                                                            <div class="price">$00.00/ <span>year</span>
                                                                            </div>
                                                                            <div class="offer-price" style="opacity: 0; visibility: hidden;">Flat
                                                                                50% Off Applied </div>
                                                                            <div class="getstarted-btn get-it-now">
                                                                                <a class="label btn btn-secondary common-btn" href="https://wordpress.org/plugins/enhanced-e-commerce-for-woocommerce-store/">
                                                                                    Get It Now
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10+">
                                                                            <div class="title card-title">Free</div>
                                                                            <p class="card-text contactus">
                                                                                <!-- Button trigger modal -->
                                                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="opacity: 0; visibility: hidden;">
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
                                                            <!-- Accessibility Features -->
                                                            <tr class="title-row" data-title="Accessibility Features">
                                                                <td colspan="5" class="data">
                                                                    <div class="feature-title">
                                                                        GTM &amp; Datalayer Automation

                                                                    </div>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Enhanced user privacy with Google Consent Mode V2. Conversios supports Google V2 Consent and is compatible with Real Cookie Banner, GDPR Cookie Compliance, and CookieYes.">
                                                                            <b>Customizable Tracking with GTM Container</b>
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Enhanced user privacy with Google Consent Mode V2. Conversios supports Google V2 Consent and is compatible with Real Cookie Banner, GDPR Cookie Compliance, and CookieYes.">
                                                                            <b>Google Consent Mode V2 for Tracking</b>
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                            page_view
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            <!-- 3 -->

                                                            <!-- 4 -->
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                            view_item_list
                                                                        </button>
                                                                    </div>
                                                                </th>

                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            <!-- 5 -->
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                            view_item
                                                                        </button>
                                                                    </div>
                                                                </th>

                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            <!-- 6 -->
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                            select_item
                                                                        </button>
                                                                    </div>
                                                                </th>

                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            <!-- 7 -->
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                            add_to_cart
                                                                        </button>
                                                                    </div>
                                                                </th>

                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            <!-- 8 -->

                                                            <!-- 9 -->
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                            view_cart
                                                                        </button>
                                                                    </div>
                                                                </th>

                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            <!-- 10 -->
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                            remove_from_cart
                                                                        </button>
                                                                    </div>
                                                                </th>

                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                            begin_checkout
                                                                        </button>
                                                                    </div>
                                                                </th>

                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            <!-- 11 -->

                                                            <!-- 12 -->
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                            add_shipping_info
                                                                        </button>
                                                                    </div>
                                                                </th>

                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            <!-- 13 -->
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                            add_payment_info
                                                                        </button>
                                                                    </div>
                                                                </th>

                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                            purchase
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                            form submissions
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                            </tr>

                                                            <!-- 31 -->
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                            phone clicks
                                                                        </button>
                                                                    </div>
                                                                </th>

                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                            </tr>

                                                            <!-- 32 -->
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                            email clicks
                                                                        </button>
                                                                    </div>
                                                                </th>

                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                            </tr>

                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                            address clicks
                                                                        </button>
                                                                    </div>
                                                                </th>

                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="You can set up and optimize your Google Ad Campaigns and Google Merchant Centre with Target KPIs optimized by Google Smart Bidding. ">
                                                                            Setup Google Ads and Optimize
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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

                                                            <!-- 16 -->
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="You can effectively monitor your Google Ads campaign performance using Conversion and Enhanced Conversion Tracking. Track Add To Cart and Begin Checkout events for better Google Ads optimization.">
                                                                            Google Ads Enhanced Conversion Tracking
                                                                        </button>
                                                                    </div>
                                                                </th>

                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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

                                                            <!-- 17 -->
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Enable Google Ads Dynamic Remarketing Tracking to create remarketing and dynamic remarketing audience lists.Retarget website visitors with laser focus based on their actions (View Item, Add to Cart, Begin Checkout, Purchase).">
                                                                            <b>Google Ads Dynamic Remarketing Tracking <br> (View Item, Add to Cart, Begin Checkout, Purchase)</b>
                                                                        </button>
                                                                    </div>
                                                                </th>

                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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

                                                            <!--Facebook Ecoomerce   -->
                                                            <tr class="title-row" data-title="hello">
                                                                <td colspan="5" class="data">
                                                                    <div class="feature-title">
                                                                        Facebook Pixel &amp; Conversions API

                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <!-- 1 -->
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                            Page View
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span class="cross">⤫</span>
                                                                        </div>
                                                                    </div>
                                                                </td>


                                                            </tr>
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                            View Content
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span class="cross">⤫</span>
                                                                        </div>
                                                                    </div>
                                                                </td>


                                                            </tr>
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                            Add To Cart
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span class="cross">⤫</span>
                                                                        </div>
                                                                    </div>
                                                                </td>


                                                            </tr>
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                            Initiate Checkout
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span class="cross">⤫</span>
                                                                        </div>
                                                                    </div>
                                                                </td>


                                                            </tr>
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                            Add Payment Info
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span class="cross">⤫</span>
                                                                        </div>
                                                                    </div>
                                                                </td>


                                                            </tr>
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                            Lead Tracking
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span class="cross">⤫</span>
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
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Gain valuable insights into TikTok ad performance with conversion tracking for key purchase events. (ecommerce and lead generation event tracking.">
                                                                            TikTok Pixel and Events API Tracking
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span class="cross">⤫</span>
                                                                        </div>
                                                                    </div>
                                                                </td>


                                                            </tr>
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Measure the effectiveness of your Snapchat ads with purchase event tracking.">
                                                                            Snapchat Pixel and Conversion API
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span class="cross">⤫</span>
                                                                        </div>
                                                                    </div>
                                                                </td>


                                                            </tr>
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Optimize your Pinterest ad strategy with conversion tracking for crucial purchase events.">
                                                                            Pinterest Pixel Tracking
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Track ad performance across various stages of the purchase funnel with Microsoft(Bing) Ads integration.">
                                                                            Microsoft (Bing) Pixel and Conversion Tracking
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Gain valuable insights into Twitter ad performance with conversion tracking.">
                                                                            Twitter Pixel Tracking
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Gain a visual understanding of user behavior with integrations for Microsoft Clarity, Hotjar, and Crazy Egg.">
                                                                            Heatmap and Screen Recording
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="One click automation of server GTM container for ecommerce events and ad channels.">
                                                                            Automation of sGTM
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span class="cross">⤫</span>
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
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="One click automation of web GTM container for e-commerce events and ad channels.">
                                                                            Automation of Web GTM
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span class="cross">⤫</span>
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
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="One click provisioning of powerful google cloud server hosting for 100% uptime, scalability and security.">
                                                                            Google Cloud Hosting for sGTM
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span class="cross">⤫</span>
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
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="No code automation for server e-commerce events datalayer.">
                                                                            Server E-commerce Datalayer Automation
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span class="cross">⤫</span>
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
                                                            <!-- 5 -->
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Sets first-party cookies. Extends cookie lifespan. Enhances GTM and GA4 to resist AdBlockers and ITP. Preserves data tracking integrity.">
                                                                            Custom GTM Loader
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span class="cross">⤫</span>
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
                                                            <!-- 6 -->

                                                            <!-- 7 -->
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Complete e-commerce tracking.">
                                                                            Server-Side Tagging for GA4
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span class="cross">⤫</span>
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
                                                            <!-- 8 -->
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Complete conversion tracking and audience building in Google Ads.">
                                                                            Server-Side Tagging for Google Ads
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span class="cross">⤫</span>
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
                                                            <!-- 9 -->
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Complete conversion tracking and audience building in Facebook.">
                                                                            Server-Side Tagging for FB Ads and CAPI
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span class="cross">⤫</span>
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
                                                            <!-- 10 -->
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Complete conversion tracking and audience building in Snapchat.">
                                                                            Server-Side Tagging for Snapchat Ads and CAPI
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span class="cross">⤫</span>
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

                                                            <!-- 11 -->
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Complete conversion tracking and audience building in TikTok.">
                                                                            Server-Side Tagging for TikTok Events API
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span class="cross">⤫</span>
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
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Total number of WooCommerce product sync limit.">
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
                                                                        <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                            Google Shopping Feed
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                            </tr>

                                                            <!-- 3 -->
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                            Facebook Catalog Feed
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                            </tr>

                                                            <!-- 4 -->
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc remove" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip">
                                                                            TikTok Catalog Feed
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                            </tr>

                                                            <!-- 5 -->
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Schedule automatic updates to keep your product feeds fresh and accurately updated. ">
                                                                            Schedule Auto Product Sync
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Utilize advanced filters to create targeted product feeds for different platforms.">
                                                                            Advanced Filters
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                            </tr>

                                                            <!-- 8-->
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Advance Attribute Mapping and Category Mapping for better visibility, improved product data quality, and better ad performance.">
                                                                            Advance Attribute Mapping &amp; Category Mapping
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                            </tr>

                                                            <!--9-->
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Create and manage high-performing Google Ads Performance Max Campaigns based on your product feeds.">
                                                                            Feed Based Campaign Management
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                            </tr>

                                                            <!-- Reporting & Campaign Management  -->
                                                            <!-- 0 -->
                                                            <tr class="title-row" data-title="hello">
                                                                <td colspan="5" class="data">
                                                                    <div class="feature-title">
                                                                        Reporting &amp; Campaign Management
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <!-- 1 -->
                                                            <tr>
                                                                <th class="th-data" scope="row">
                                                                    <div class="tooltip-box">
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Know about e-commerce funnel(Conversion and Checkout), product, source and order performance reports from wordpress admin. Enables data driven decision making to increase conversion.">
                                                                            E-Commerce Reporting (GA4)
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Enables you to measure the campaign performance in Google Ads.">
                                                                            Google Ads Reporting
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="ChatGPT powered insights on your analytics and campaigns data.">
                                                                            AI Powered Insights
                                                                        </button>
                                                                    </div>
                                                                </th>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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
                                                                        <button type="button" class="btn btn-secondary tooltipc" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Schedule daily, weekly or monthly reports straight into your inbox.">
                                                                            Schedule Smart Email Reports
                                                                        </button>
                                                                    </div>
                                                                </th>

                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="feature-data">
                                                                        <div class="items">
                                                                            <span>✓</span>
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


                                                            <!-- 18 buttons -->
                                                            <tr>
                                                                <th class="th-data" scope="row" style="border: 0px;"></th>
                                                                <td style="border: 0px;">
                                                                    <div class="feature-data">
                                                                        <div class="dynamicprice_box" plan_cat="enterprise01" boxperiod="yearly" boxdomain="1">
                                                                            <div class="getnow-btn">
                                                                                <a class="btn btn-secondary getnow" index="1" href="https://www.conversios.io/checkout/?pid=wpAIO_EY1">Get
                                                                                    It Now</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dynamicprice_box d-none" plan_cat="enterprise03" boxperiod="yearly" boxdomain="5">
                                                                            <div class="getnow-btn">
                                                                                <a class="btn btn-secondary getnow" index="1">Get
                                                                                    It Now</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dynamicprice_box d-none" plan_cat="enterprise05" boxperiod="yearly" boxdomain="10">
                                                                            <div class="getnow-btn">
                                                                                <a class="btn btn-secondary getnow" index="1">Get
                                                                                    It Now</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dynamicprice_box d-none" plan_cat="enterprise05+" boxperiod="yearly" boxdomain="10+">
                                                                            <div class="getnow-btn">
                                                                                <button type="button" class="btn btn-primary getnow" data-bs-toggle="modal" data-bs-target="#staticBackdrop" index="1">CONTACT US</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td style="border: 0px;">
                                                                    <div class="feature-data">
                                                                        <div class="dynamicprice_box" boxperiod="yearly" boxdomain="1">
                                                                            <div class="getnow-btn">
                                                                                <a class="btn btn-secondary getnow" index="2" href="https://www.conversios.io/checkout/?pid=wpAIO_PY1">Get
                                                                                    It Now</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="5">
                                                                            <div class="getnow-btn">
                                                                                <a class="btn btn-secondary getnow" index="2" href="https://www.conversios.io/checkout/?pid=wpAIO_PY3">Get
                                                                                    It Now</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10">
                                                                            <div class="getnow-btn">
                                                                                <a class="btn btn-secondary getnow" index="2" href="https://www.conversios.io/checkout/?pid=wpAIO_PY5">Get
                                                                                    It Now</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10+">
                                                                            <div class="getnow-btn">
                                                                                <button type="button" class="btn btn-primary getnow" data-bs-toggle="modal" data-bs-target="#staticBackdrop" index="1">CONTACT US</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td style="border: 0px;">
                                                                    <div class="feature-data">
                                                                        <div class="dynamicprice_box" boxperiod="yearly" boxdomain="1">
                                                                            <div class="getnow-btn">
                                                                                <a class="btn btn-secondary getnow" index="3" href="https://www.conversios.io/checkout/?pid=wpAIO_SY1">Get
                                                                                    It Now</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="5">
                                                                            <div class="getnow-btn">
                                                                                <a class="btn btn-secondary getnow" index="3" href="https://www.conversios.io/checkout/?pid=wpAIO_SY3">Get
                                                                                    It Now</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10">
                                                                            <div class="getnow-btn">
                                                                                <a class="btn btn-secondary getnow" index="3" href="https://www.conversios.io/checkout/?pid=wpAIO_SY5">Get
                                                                                    It Now</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10+">
                                                                            <div class="getnow-btn">
                                                                                <button type="button" class="btn btn-primary getnow" data-bs-toggle="modal" data-bs-target="#staticBackdrop" index="1">CONTACT US</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td style="border: 0px;">
                                                                    <div class="feature-data">
                                                                        <div class="dynamicprice_box" boxperiod="yearly" boxdomain="1">
                                                                            <div class="getnow-btn">
                                                                                <a class="btn btn-secondary getnow" index="4" target="_blank" href="https://wordpress.org/plugins/enhanced-e-commerce-for-woocommerce-store/">Get
                                                                                    It Now</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="5">
                                                                            <div class="getnow-btn">
                                                                                <a class="btn btn-secondary getnow" index="4" target="_blank" href="https://wordpress.org/plugins/enhanced-e-commerce-for-woocommerce-store/">Get
                                                                                    It Now</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10">
                                                                            <div class="getnow-btn">
                                                                                <a class="btn btn-secondary getnow" index="4" target="_blank" href="https://wordpress.org/plugins/enhanced-e-commerce-for-woocommerce-store/">Get
                                                                                    It Now</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dynamicprice_box d-none" boxperiod="yearly" boxdomain="10+">
                                                                            <div class="getnow-btn">
                                                                                <button type="button" class="btn btn-primary getnow" data-bs-toggle="modal" data-bs-target="#staticBackdrop" index="1" style="opacity: 0; visibility: hidden;">CONTACT
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