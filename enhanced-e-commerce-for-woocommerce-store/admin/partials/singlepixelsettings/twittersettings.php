<?php
$is_sel_disable = 'disabled';
?>
<div class="conv-card p-4 rounded conv-shadow-sm">
    <!-- Header -->
    <div class="d-flex align-items-center mb-3">
        <?php echo wp_kses(
            enhancad_get_plugin_image('/admin/images/logos/conv_twitter_logo.png', '', 'align-self-center conv-channel-logo'),
            array(
                'img' => array(
                    'src' => true,
                    'alt' => true,
                    'class' => true,
                    'style' => true,
                ),
            )
        ); ?>
        <h4 class="conv-card-title ms-2">Twitter (X) Pixel Tracking</h4>
    </div>
    <hr class="conv-header-hr">
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
                    <div class="col-6">
                        <label class="conv-field-label d-flex align-items-center"><?php esc_html_e("Twitter Pixel ID:", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            <!-- <span class="material-symbols-outlined text-secondary md-18 ps-2" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="The Twitter Ads pixel ID looks like. ocihb">
                                info
                            </span> -->
                        </label>
                        <input type="text" name="twitter_ads_pixel_id" id="twitter_ads_pixel_id"
                            class="form-control valtoshow_inpopup_this mb-1"
                            value="<?php echo esc_attr($twitter_ads_pixel_id); ?>" placeholder="e.g. ocihb">
                        <a href="https://www.conversios.io/blog/what-is-x-twitter-pixel-id-and-how-to-find-it/?utm_source=woo_aiofree_plugin&utm_medium=otherpixelsetting&utm_campaign=woo_aiofree_plugin" target="_blank" style="font-size: 12px; color: #0073aa; font-weight: 500; text-decoration: none; display:inline-block; margin-top:4px;">How to Find X (Twitter) Pixel ID &rarr;</a>
                    </div>
                </div>
                <div class="row pt-4">
                    <label class="conv-section-title d-flex align-items-center">
                        <?php esc_html_e("Twitter events settings:", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        <span class="fw-400 text-color fs-12">
                            <svg class="conv-icon text-secondary conv-ms-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Create events in the twitter ads and enter event IDs"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                        </span>
                    </label>
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