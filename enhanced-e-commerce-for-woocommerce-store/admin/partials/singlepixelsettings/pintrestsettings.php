<?php
$is_sel_disable = 'disabled';
?>
<div class="conv-card p-4 rounded conv-shadow-sm">
    <!-- Header -->
    <div class="d-flex align-items-center mb-3">
        <?php echo wp_kses(
            enhancad_get_plugin_image('/admin/images/logos/conv_pint_logo.png', '', 'align-self-center conv-channel-logo'),
            array(
                'img' => array(
                    'src' => true,
                    'alt' => true,
                    'class' => true,
                    'style' => true,
                ),
            )
        ); ?>
        <h4 class="conv-card-title ms-2">Pinterest Pixel</h4>
    </div>
    <hr class="conv-header-hr">

    <form id="pixelsetings_form" class="convpixsetting-inner-box">
        <div>
            <!-- Pinterest Pixel -->
            <?php $pinterest_ads_pixel_id = isset($ee_options['pinterest_ads_pixel_id']) ? $ee_options['pinterest_ads_pixel_id'] : ""; ?>
            <div id="pintrest_box" class="py-1">
                <div class="row pt-2">
                    <div class="col-6">
                        <label class="conv-field-label d-flex align-items-center"><?php esc_html_e("Pinterest Pixel ID:", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </label>
                        <input type="text" name="pinterest_ads_pixel_id" id="pinterest_ads_pixel_id" class="form-control valtoshow_inpopup_this" value="<?php echo esc_attr($pinterest_ads_pixel_id); ?>">
                        <a href="https://www.conversios.io/blog/how-to-find-pinterest-pixel-id-from-a-business-manager-account/?utm_source=woo_aiofree_plugin&utm_medium=otherpixelsetting&utm_campaign=woo_aiofree_plugin" target="_blank" style="font-size: 12px; color: #0073aa; font-weight: 500; text-decoration: none; display:inline-block; margin-top:4px;">How to Find Pinterest Pixel ID &rarr;</a>
                    </div>
                </div>
            </div>
            <!-- Pinterest Pixel End-->
        </div>

    </form>
    <input type="hidden" id="valtoshow_inpopup" value="Pinterest Pixel ID:" />

</div>