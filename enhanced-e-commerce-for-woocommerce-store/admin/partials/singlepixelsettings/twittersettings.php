<?php
if (! defined('ABSPATH')) exit; // Exit if accessed directly
$is_sel_disable = 'disabled';
?>
<div class="convcard p-4 mt-0 rounded-3 shadow-sm">
    <form id="pixelsetings_form" class="convpixsetting-inner-box">
        <div>
            <!-- Twitter Pixel -->
            <?php
            $twitter_ads_pixel_id = isset($ee_options['twitter_ads_pixel_id']) ? $ee_options['twitter_ads_pixel_id'] : "";
            $twitter_ads_form_submit_event_id = isset($ee_options['twitter_ads_form_submit_event_id']) ? $ee_options['twitter_ads_form_submit_event_id'] : "";
            $twitter_ads_add_to_cart_event_id = isset($ee_options['twitter_ads_add_to_cart_event_id']) ? $ee_options['twitter_ads_add_to_cart_event_id'] : "";
            $twitter_ads_checkout_initiated_event_id = isset($ee_options['twitter_ads_checkout_initiated_event_id']) ? $ee_options['twitter_ads_checkout_initiated_event_id'] : "";
            $twitter_ads_payment_info_event_id = isset($ee_options['twitter_ads_payment_info_event_id']) ? $ee_options['twitter_ads_payment_info_event_id'] : "";
            $twitter_ads_purchase_event_id = isset($ee_options['twitter_ads_purchase_event_id']) ? $ee_options['twitter_ads_purchase_event_id'] : "";
            $twitter_ads_email_click_event_id = isset($ee_options['twitter_ads_email_click_event_id']) ? $ee_options['twitter_ads_email_click_event_id'] : "";
            $twitter_ads_phone_click_event_id = isset($ee_options['twitter_ads_phone_click_event_id']) ? $ee_options['twitter_ads_phone_click_event_id'] : "";
            $twitter_ads_address_click_event_id = isset($ee_options['twitter_ads_address_click_event_id']) ? $ee_options['twitter_ads_address_click_event_id'] : "";
            ?>
            <div id="twitter_box" class="py-1">
                <div class="row pt-2">
                    <div class="col-7">
                        <h5 class="d-flex align-items-center mb-1 text-dark">
                            <b><?php esc_html_e("Twitter Pixel ID:", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                            <?php if (!empty($twitter_ads_pixel_id)) { ?>
                                <span class="material-symbols-outlined text-success ms-1 fs-6">check_circle</span>
                            <?php } ?>
                        </h5>
                        <input type="text" name="twitter_ads_pixel_id" id="twitter_ads_pixel_id"
                            class="form-control valtoshow_inpopup_this"
                            value="<?php echo esc_attr($twitter_ads_pixel_id); ?>" placeholder="e.g. ocihb">
                    </div>
                </div>
                <div class="row pt-4">
                    <h5 class="fw-normal mb-1 mt-3">
                        <b><?php esc_html_e("Twitter events settings:", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                        <span class="fw-400 text-color fs-12">
                            <span class="material-symbols-outlined fs-6" data-bs-toggle="tooltip"
                                data-bs-placement="right"
                                data-bs-original-title="Create events in the twitter ads and enter event IDs">
                                info
                            </span>
                        </span>
                    </h5>
                </div>

                <div class="wc_event_configure <?php echo !CONV_IS_WC ? 'hidden' : '' ?>">
                    <div class="row pt-3">
                        <div class="col-6">
                            <label class="d-flex align-items-center mb-1 text-dark">
                                <?php esc_html_e("Event ID for Add to Cart", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </label>
                            <input type="text" name="twitter_ads_add_to_cart_event_id"
                                id="twitter_ads_add_to_cart_event_id" class="form-control"
                                value="<?php echo esc_attr($twitter_ads_add_to_cart_event_id); ?>"
                                placeholder="e.g. tw-olwfn-olwio">
                        </div>
                        <div class="col-6">
                            <label class="d-flex align-items-center mb-1 text-dark">
                                <?php esc_html_e("Event ID for Checkout Initiated", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </label>
                            <input type="text" name="twitter_ads_checkout_initiated_event_id"
                                id="twitter_ads_checkout_initiated_event_id" class="form-control"
                                value="<?php echo esc_attr($twitter_ads_checkout_initiated_event_id); ?>"
                                placeholder="e.g. tw-olwfn-olwio">
                        </div>
                    </div>

                    <div class="row pt-3">
                        <div class="col-6">
                            <label class="d-flex align-items-center mb-1 text-dark">
                                <?php esc_html_e("Event ID for Payment Info Added", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </label>
                            <input type="text" name="twitter_ads_payment_info_event_id"
                                id="twitter_ads_payment_info_event_id" class="form-control"
                                value="<?php echo esc_attr($twitter_ads_payment_info_event_id); ?>"
                                placeholder="e.g. tw-olwfn-olwio">
                        </div>
                        <div class="col-6">
                            <label class="d-flex align-items-center mb-1 text-dark">
                                <?php esc_html_e("Event ID for Purchase", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </label>
                            <input type="text" name="twitter_ads_purchase_event_id" id="twitter_ads_purchase_event_id"
                                class="form-control" value="<?php echo esc_attr($twitter_ads_purchase_event_id); ?>"
                                placeholder="e.g. tw-olwfn-olwio">
                        </div>
                    </div>
                </div> <!-- wc events -->

                <div class="row pt-3">
                    <div class="col-6">
                        <label class="d-flex align-items-center mb-1 text-dark">
                            <?php esc_html_e("Event ID for Form Submit", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </label>
                        <input type="text" name="twitter_ads_form_submit_event_id" id="twitter_ads_form_submit_event_id"
                            class="form-control" value="<?php echo esc_attr($twitter_ads_form_submit_event_id); ?>"
                            placeholder="e.g. tw-olwfn-olwio">
                    </div>
                    <div class="col-6">
                        <label class="d-flex align-items-center mb-1 text-dark">
                            <?php esc_html_e("Event ID for Email Click", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </label>
                        <input type="text" name="twitter_ads_email_click_event_id" id="twitter_ads_email_click_event_id"
                            class="form-control" value="<?php echo esc_attr($twitter_ads_email_click_event_id); ?>"
                            placeholder="e.g. tw-olwfn-olwio">
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="col-6">
                        <label class="d-flex align-items-center mb-1 text-dark">
                            <?php esc_html_e("Event ID for Phone Click", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </label>
                        <input type="text" name="twitter_ads_phone_click_event_id" id="twitter_ads_phone_click_event_id"
                            class="form-control" value="<?php echo esc_attr($twitter_ads_phone_click_event_id); ?>"
                            placeholder="e.g. tw-olwfn-olwio">
                    </div>
                    <div class="col-6">
                        <label class="d-flex align-items-center mb-1 text-dark">
                            <?php esc_html_e("Event ID for Address Click", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </label>
                        <input type="text" name="twitter_ads_address_click_event_id"
                            id="twitter_ads_address_click_event_id" class="form-control"
                            value="<?php echo esc_attr($twitter_ads_address_click_event_id); ?>"
                            placeholder="e.g. tw-olwfn-olwio">
                    </div>
                </div>
            </div>
            <!-- Twitter Pixel End-->
        </div>
    </form>
    <input type="hidden" id="valtoshow_inpopup" value="Twitter Pixel ID:" />

</div>

<!-- Ecommerce Events -->
<div class="convcard p-4 mt-0 rounded-3 shadow-sm mt-3 d-none hidden">
    <div class="row">
        <h5 class="fw-normal mb-1">
            <?php esc_html_e("Ecommerce Events", "enhanced-e-commerce-for-woocommerce-store"); ?>
            <span class="fw-400 text-color fs-12">
                <span class="text-color fs-6"> *</span> <span class="material-symbols-outlined fs-6"
                    data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-original-title="Page view and purchase event tracking are available in free plan. For complete ecommerce tracking, upgrade to our pro plan">
                    info
                </span>
            </span>
        </h5>
    </div>
    <div class="row">
        <div class="col-md-4">
            <input type="checkbox" class="m-1" name="" style="-webkit-appearance: auto;" checked
                onclick="return false;">
            <?php esc_html_e("Page view", "enhanced-e-commerce-for-woocommerce-store"); ?>
        </div>
        <div class="col-md-4">
            <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Available with Pro Plan">
                <span class="material-symbols-outlined lock-icon">
                    lock
                </span>
                <?php esc_html_e("Add to cart", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
        </div>
        <div class="col-md-4 pr-0">
            <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Available with Pro Plan">
                <span class="material-symbols-outlined lock-icon">
                    lock
                </span>
                <?php esc_html_e("Initiate checkout", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <input type="checkbox" name="" class="m-1" style="-webkit-appearance: auto;" checked
                onclick="return false;">
            <?php esc_html_e("Purchase", "enhanced-e-commerce-for-woocommerce-store"); ?>
        </div>
        <div class="col-md-4">
            <span data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Available with Pro Plan">
                <span class="material-symbols-outlined lock-icon">
                    lock
                </span>
                <?php esc_html_e("Add payment info", "enhanced-e-commerce-for-woocommerce-store"); ?>
            </span>
        </div>
    </div>
    
    <div class="row pt-3">
        <div class="col-md-12">
            <h5 class="fw-bold-500 conv-recommended-text" style="font-size: 17px;">
                <?php esc_html_e("Recommended:", "enhanced-e-commerce-for-woocommerce-store"); ?>
            </h5>
            <h5 class="fw-normal mb-1">
                <?php esc_html_e("For complete ecommerce tracking and user browsing behavior for your Woo Shop, switch to our Starter plan.", "enhanced-e-commerce-for-woocommerce-store"); ?>
                <span class="align-middle conv-link-blue ms-2 fw-bold-500 upgradetopro_badge" data-bs-toggle="modal"
                    data-bs-target="#upgradetopromodal">
                    <?php echo wp_kses(
                        enhancad_get_plugin_image('/admin/images/logos/upgrade_badge.png'),
                        array(
                            'img' => array(
                                'src' => true,
                                'alt' => true,
                                'class' => true,
                                'style' => true,
                            ),
                        )
                    ); ?>
                    <?php esc_html_e("Available In Pro", "enhanced-e-commerce-for-woocommerce-store"); ?>
                </span>
            </h5>
        </div>
    </div>
</div>

<script>
    jQuery(function() {
        jQuery("#upgradetopro_modal_link").attr("href",
            '<?php echo esc_url($TVC_Admin_Helper->get_conv_pro_link_adv("popup", "twittersettings",  "conv-link-blue fw-bold", "linkonly")); ?>'
        );

        let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        let tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>