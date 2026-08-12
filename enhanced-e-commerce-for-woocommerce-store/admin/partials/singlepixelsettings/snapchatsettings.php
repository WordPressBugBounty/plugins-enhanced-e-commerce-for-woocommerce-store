<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$is_sel_disable = 'disabled';
$blurContentClass = '';
$availProHtml = '';
$upgrade_link = 'https://www.conversios.io/woocommerce-plan-pricing/?utm_source=woo_aiofree_plugin&utm_medium=snapchat_card&utm_campaign=pixel_setting';
?>
<div class="conv-card p-4 rounded conv-shadow-sm">
    <!-- Header -->
    <div class="d-flex align-items-center mb-3">
        <?php echo wp_kses(
            enhancad_get_plugin_image('/admin/images/logos/conv_snap_logo.png', '', 'align-self-center conv-channel-logo'),
            array(
                'img' => array(
                    'src' => true,
                    'alt' => true,
                    'class' => true,
                    'style' => true,
                ),
            )
        ); ?>
        <h4 class="conv-card-title ms-2">Snapchat Pixel</h4>
    </div>
    <hr class="conv-header-hr">

    <form id="pixelsetings_form" class="convpixsetting-inner-box">
        <div>
            <!-- Snapchat Pixel -->
            <?php $snapchat_ads_pixel_id = isset($ee_options['snapchat_ads_pixel_id']) ? $ee_options['snapchat_ads_pixel_id'] : ""; ?>
            <div id="snapchat_box" class="py-1">
                <div class="row pt-2">
                    <div class="col-6">
                        <label class="conv-field-label d-flex align-items-center"><?php esc_html_e("Snapchat Pixel ID", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </label>
                        <input type="text" name="snapchat_ads_pixel_id" id="snapchat_ads_pixel_id" class="form-control valtoshow_inpopup_this" value="<?php echo esc_attr($snapchat_ads_pixel_id); ?>">
                        <a href="https://www.conversios.io/blog/find-your-snapchat-pixel-id-and-conversion-api-token/?utm_source=woo_aiofree_plugin&utm_medium=otherpixelsetting&utm_campaign=woo_aiofree_plugin" target="_blank" style="font-size: 12px; color: #0073aa; font-weight: 500; text-decoration: none; display:inline-block; margin-top:4px;">How to Find Snapchat Pixel ID &rarr;</a>
                    </div>
                </div>
            </div>
            <!-- Snapchat Pixel End-->


            <!-- CAPI Pro Nudge -->
        <div class="p-4 mt-3" style="background: linear-gradient(135deg, #e8f0fe 0%, #d4e4fc 100%); border-radius: 8px;">
            <div class="row align-items-center">
                <!-- Left: EQM circular meter -->
                <div class="col-md-3 col-sm-4 text-center d-flex justify-content-center mb-3 mb-sm-0">
                    <div style="position: relative; width: 140px; height: 140px;">
                        <svg width="140" height="140" viewBox="0 0 140 140">
                            <!-- Background circle -->
                            <circle cx="70" cy="70" r="60" stroke="#d4e4fc" stroke-width="12" fill="transparent" />
                            <!-- Progress circle (93% of 376.99 = 350.60 => dashoffset = 26.39) -->
                            <circle cx="70" cy="70" r="60" stroke="#2ec471" stroke-width="12" fill="transparent"
                                stroke-dasharray="376.99" stroke-dashoffset="26.39" stroke-linecap="round" transform="rotate(-90 70 70)" />
                        </svg>
                        <div style="position: absolute; top: 0; left: 0; width: 140px; height: 140px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                            <span style="font-size: 28px; font-weight: 700; color: #1a1f36; line-height: 1;">93%</span>
                            <span style="font-size: 13px; color: #4a5568; font-weight: 600; margin-top: 4px;">Match Rate</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Benefits Checklist & CTA Button -->
                <div class="col-md-9 col-sm-8">
                    <h5 class="mb-3" style="font-size: 15px; font-weight: 700; color: #202124; margin-top: 0;"><?php esc_html_e("Get the benefit of Snapchat Conversion API (CAPI):", "enhanced-e-commerce-for-woocommerce-store"); ?></h5>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="conv-pro-feature-item mb-2" style="display: flex; align-items: center; padding: 0;">
                                <svg class="conv-pro-check" viewBox="0 0 24 24" style="flex-shrink: 0; width: 18px; height: 18px; margin-right: 8px;"><circle cx="12" cy="12" r="12" fill="#e6f7ee"/><path d="M7 12.5l3 3 7-7" stroke="#2ec471" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <span style="font-size: 14px; color: #4a5568; font-weight: 500; line-height: 1.4;"><?php esc_html_e("Bypass ad blockers & browser restrictions", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
                            </div>
                            <div class="conv-pro-feature-item mb-2" style="display: flex; align-items: center; padding: 0;">
                                <svg class="conv-pro-check" viewBox="0 0 24 24" style="flex-shrink: 0; width: 18px; height: 18px; margin-right: 8px;"><circle cx="12" cy="12" r="12" fill="#e6f7ee"/><path d="M7 12.5l3 3 7-7" stroke="#2ec471" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <span style="font-size: 14px; color: #4a5568; font-weight: 500; line-height: 1.4;"><?php esc_html_e("Accurate server-side tracking (Snap CAPI)", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="conv-pro-feature-item mb-2" style="display: flex; align-items: center; padding: 0;">
                                <svg class="conv-pro-check" viewBox="0 0 24 24" style="flex-shrink: 0; width: 18px; height: 18px; margin-right: 8px;"><circle cx="12" cy="12" r="12" fill="#e6f7ee"/><path d="M7 12.5l3 3 7-7" stroke="#2ec471" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <span style="font-size: 14px; color: #4a5568; font-weight: 500; line-height: 1.4;"><?php esc_html_e("Achieve up to 93% Snap Signal Match Rate", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
                            </div>
                            <div class="conv-pro-feature-item mb-2" style="display: flex; align-items: center; padding: 0;">
                                <svg class="conv-pro-check" viewBox="0 0 24 24" style="flex-shrink: 0; width: 18px; height: 18px; margin-right: 8px;"><circle cx="12" cy="12" r="12" fill="#e6f7ee"/><path d="M7 12.5l3 3 7-7" stroke="#2ec471" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <span style="font-size: 14px; color: #4a5568; font-weight: 500; line-height: 1.4;"><?php esc_html_e("Reduce CPA & optimize ad bidding", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
                            </div>
                        </div>
                    </div>
                    <!-- CTA Button -->
                    <div class="mt-3 text-start">
                        <a href="<?php echo esc_url($upgrade_link); ?>" target="_blank" class="conv-pro-upgrade-btn" style="display: inline-flex; align-items: center; justify-content: center; padding: 8px 20px; background-color: #2e6ff2; color: #fff; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px; transition: background-color 0.2s;">
                            Upgrade to Pro
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:16px; height:16px; margin-left:8px;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        </div>

    </form>
    <input type="hidden" id="valtoshow_inpopup" value="Snapchat Pixel ID:" />

</div>