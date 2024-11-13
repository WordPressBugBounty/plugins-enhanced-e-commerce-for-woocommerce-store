<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly
$is_sel_disable = 'disabled';
?>
<div class="convcard p-4 mt-0 rounded-3 shadow-sm">
    <ul class="conv-green-checklis list-unstyled mt-3">
        <li class="d-flex">
            <span class="material-symbols-outlined text-success md-18">
                check_circle
            </span>
            <?php esc_html_e("E-commerce conversion tracking including Purchase", "enhanced-e-commerce-for-woocommerce-store"); ?>
            <span class="material-symbols-outlined text-secondary md-18 ps-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="View Content, Add to Cart, Initiate Checkout, Add Payment Info & Purchase.">
                info
            </span>
        </li>
        <li class="d-flex">
            <span class="material-symbols-outlined text-success md-18">
                check_circle
            </span>
            <?php esc_html_e("Lead generation conversion tracking including Form Submit", "enhanced-e-commerce-for-woocommerce-store"); ?>
        </li>
    </ul>
    <form id="pixelsetings_form" class="convpixsetting-inner-box">
        <div>
            <!-- Tiktok Pixel -->
            <?php $tiKtok_ads_pixel_id = isset($ee_options['tiKtok_ads_pixel_id']) ? $ee_options['tiKtok_ads_pixel_id'] : ""; ?>
            <div id="tiktok_box" class="py-1">
                <div class="row pt-2">
                    <div class="col-7">
                        <h5 class="d-flex align-items-center mb-1 text-dark">
                            <b><?php esc_html_e("TikTok Pixel ID:", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                            <?php if (!empty($tiKtok_ads_pixel_id)) { ?>
                                <span class="material-symbols-outlined text-success ms-1 fs-6">check_circle</span>
                            <?php } ?>
                        </h5>
                        <input type="text" name="tiKtok_ads_pixel_id" id="tiKtok_ads_pixel_id" class="form-control valtoshow_inpopup_this" value="<?php echo esc_attr($tiKtok_ads_pixel_id); ?>" placeholder="eg.CBET743C77U5BM7P178N">
                    </div>
                </div>
            </div>
            <!-- Tiktok Pixel End-->
        </div>

        <div id="fbapi_box" class="pt-4">
            <div class="row pt-2">
                <div class="col-12">
                    <h5 class="d-flex align-items-center mb-1 text-dark">
                        <b><?php esc_html_e("Tiktok Events API Benefits:", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                        <a target="_blank" href="<?php echo esc_url('https://www.conversios.io/checkout/?pid=wpAIO_PY1&utm_source=woo_aiofree_plugin&utm_medium=tiktokinnersetting&utm_campaign=capi'); ?>" class="conv-link-blue ms-2 fw-bold-500">
                            <img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/upgrade_badge.png'); ?>" />
                            <u><?php esc_html_e("Available In Professional Plan", "enhanced-e-commerce-for-woocommerce-store"); ?></u>
                        </a>
                    </h5>
                    <div class="mt-0 mb-2 col-10">
                        <ul class="conv-green-checkli fb-kapi list-unstyled mt-1">
                            <li class="d-flex fs-14 fw-bold">
                                <span class="material-symbols-outlined">
                                    fiber_manual_record
                                </span>
                                <?php esc_html_e("Improves Event Match Quality scores by sending extra user data (e.g., email, phone number).", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </li>
                            <li class="d-flex fs-14 fw-bold">
                                <span class="material-symbols-outlined">
                                    fiber_manual_record
                                </span>
                                <?php esc_html_e("Capture events like purchases and form submissions directly from your server, regardless of browser restrictions.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </li>
                            <li class="d-flex fs-14 fw-bold">
                                <span class="material-symbols-outlined">
                                    fiber_manual_record
                                </span>
                                <?php esc_html_e("Complete picture of user journeys, resulting in better conversion attribution, especially with iOS 14+ restrictions.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </li>
                            <li class="d-flex fs-14 fw-bold">
                                <span class="material-symbols-outlined">
                                    fiber_manual_record
                                </span>
                                <?php esc_html_e("Bypasses ad blockers and browser restrictions, ensuring more precise tracking of conversions.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>
        </div>
    </form>
    <input type="hidden" id="valtoshow_inpopup" value="TikTok Pixel ID:" />

</div>

<!-- Ecommerce Events -->
<div class="convcard p-4 mt-0 rounded-3 shadow-sm mt-3 d-none hidden">
    <div class="row">
        <h5 class="fw-normal mb-1">
            <?php esc_html_e("Ecommerce Events", "enhanced-e-commerce-for-woocommerce-store"); ?>
            <span class="fw-400 text-color fs-12">
                <span class="text-color fs-6"> *</span> <span class="material-symbols-outlined fs-6" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Page view and purchase event tracking are available in free plan. For complete ecommerce tracking, upgrade to our pro plan">
                    info
                </span>
            </span>
        </h5>
    </div>
    <div class="row">
        <div class="col-md-4">
            <input type="checkbox" class="m-1" name="" style="-webkit-appearance: auto;" checked onclick="return false;">
            <?php esc_html_e("Page view", "enhanced-e-commerce-for-woocommerce-store"); ?>
        </div>
        <div class="col-md-4">
            <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Available with Pro Plan">
                <span class="material-symbols-outlined lock-icon">
                    lock
                </span>
                <?php esc_html_e("View item", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
        </div>
        <div class="col-md-4 pr-0">
            <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Available with Pro Plan">
                <span class="material-symbols-outlined lock-icon">
                    lock
                </span>
                <?php esc_html_e("Intiate checkout", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <input type="checkbox" name="" class="m-1" style="-webkit-appearance: auto;" checked onclick="return false;">
            <?php esc_html_e("Purchase", "enhanced-e-commerce-for-woocommerce-store"); ?>
        </div>
        <div class="col-md-4">
            <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Available with Pro Plan">
                <span class="material-symbols-outlined lock-icon">
                    lock
                </span>
                <?php esc_html_e("Add to cart", "enhanced-e-commerce-for-woocommerce-store"); ?>
            </span>
        </div>
        <div class="col-md-4">
            <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Available with Pro Plan">
                <span class="material-symbols-outlined lock-icon">
                    lock
                </span>
                <?php esc_html_e("Add payment info", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 pr-0">
            <!-- <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Available with Pro Plan">
                <span class="material-symbols-outlined lock-icon">
                    lock
                </span>
                <?php esc_html_e("Base pixel on all pages", "enhanced-e-commerce-for-woocommerce-store"); ?></span> -->
        </div>
        <div class="col-md-4">
            <!-- <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Available with Pro Plan">
                <span class="material-symbols-outlined lock-icon">
                    lock
                </span><?php esc_html_e("Intiate checkout", "enhanced-e-commerce-for-woocommerce-store"); ?>
            </span> -->
        </div>
        <!-- <div class="col-md-4">
            <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Available with Pro Plan">
                <span class="material-symbols-outlined lock-icon">
                    lock
                </span>
                <?php esc_html_e("Select item", "enhanced-e-commerce-for-woocommerce-store"); ?>
            </span>
        </div> -->
    </div>
    <!-- <div class="row">
        <div class="col-md-4">
            <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Available with Pro Plan">
                <span class="material-symbols-outlined lock-icon">
                    lock
                </span>
                <?php esc_html_e("Remove from cart", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
        </div>
        <div class="col-md-4">
            <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Available with Pro Plan">
                <span class="material-symbols-outlined lock-icon">
                    lock
                </span>
                <?php esc_html_e("View item list", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
        </div>
        <div class="col-md-4">
            <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Available with Pro Plan">
                <span class="material-symbols-outlined lock-icon">
                    lock
                </span>
                <?php esc_html_e("View item", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
        </div>
    </div>  -->

    <div class="row pt-3">
        <div class="col-md-12">
            <h5 class="fw-bold-500 conv-recommended-text" style="font-size: 17px;">
                <?php esc_html_e("Recommended:", "enhanced-e-commerce-for-woocommerce-store"); ?>
            </h5>
            <h5 class="fw-normal mb-1">
                <?php esc_html_e("For complete ecommerce tracking and user browsing behavior for your Woo Shop, switch to our Starter plan.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                <span class="align-middle conv-link-blue ms-2 fw-bold-500 upgradetopro_badge" data-bs-toggle="modal" data-bs-target="#upgradetopromodal">
                    <img src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/upgrade_badge.png'); ?>" />
                    <?php esc_html_e("Available In Pro", "enhanced-e-commerce-for-woocommerce-store"); ?>
                </span>
            </h5>
        </div>
    </div>
</div>

<script>
    jQuery(function() {
        jQuery("#upgradetopro_modal_link").attr("href",
            '<?php echo esc_url($TVC_Admin_Helper->get_conv_pro_link_adv("popup", "tiktoksettings",  "conv-link-blue fw-bold", "linkonly")); ?>'
        );

        let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        let tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>