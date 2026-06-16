<?php
$is_sel_disable = 'disabled';
?>
<div class="conv-card p-4 rounded conv-shadow-sm">
    <!-- Header -->
    <div class="d-flex align-items-center mb-3">
        <?php echo wp_kses(
            enhancad_get_plugin_image('/admin/images/logos/conv_hotjar_logo.png', '', 'align-self-center conv-channel-logo'),
            array(
                'img' => array(
                    'src' => true,
                    'alt' => true,
                    'class' => true,
                    'style' => true,
                ),
            )
        ); ?>
        <h4 class="conv-card-title ms-2">Hotjar Analytics</h4>
    </div>
    <hr class="conv-header-hr">
    <form id="pixelsetings_form" class="convpixsetting-inner-box">
        <div>
            <!-- Hotjar Pixel -->
            <?php $hotjar_pixel_id = isset($ee_options['hotjar_pixel_id']) ? $ee_options['hotjar_pixel_id'] : ""; ?>
            <div id="hotjar_box" class="py-1">
                <div class="row pt-2">
                    <div class="col-6">
                        <label class="conv-field-label d-flex align-items-center"><?php esc_html_e("Hotjar Pixel ID:", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </label>
                        <input type="text" name="hotjar_pixel_id" id="hotjar_pixel_id" class="form-control valtoshow_inpopup_this" value="<?php echo esc_attr($hotjar_pixel_id); ?>">
                        <a href="https://www.conversios.io/blog/how-to-find-a-hotjar-pixel-from-hotjar-business-manager/?utm_source=woo_aiofree_plugin&utm_medium=otherpixelsetting&utm_campaign=woo_aiofree_plugin" target="_blank" style="font-size: 12px; color: #0073aa; font-weight: 500; text-decoration: none; display:inline-block; margin-top:4px;">How to Find Hotjar Site ID &rarr;</a>
                    </div>
                </div>
            </div>
            <!-- Hotjar Pixel End-->

        </div>
       
    </form>
    <input type="hidden" id="valtoshow_inpopup" value="Hotjar Pixel ID:" />

</div>