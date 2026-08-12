<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$is_sel_disable = 'disabled';
?>
<div class="conv-card p-4 rounded conv-shadow-sm">
    <!-- Header -->
    <div class="d-flex align-items-center mb-3">
        <?php echo wp_kses(
            enhancad_get_plugin_image('/admin/images/logos/conv_crazyegg_logo.png', '', 'align-self-center conv-channel-logo'),
            array(
                'img' => array(
                    'src' => true,
                    'alt' => true,
                    'class' => true,
                    'style' => true,
                ),
            )
        ); ?>
        <h4 class="conv-card-title ms-2">Crazy Egg Tracking</h4>
    </div>
    <hr class="conv-header-hr">
    <form id="pixelsetings_form" class="convpixsetting-inner-box">
        <div>
            <!-- Crazy Egg Pixel -->
            <?php $crazyegg_pixel_id = isset($ee_options['crazyegg_pixel_id']) ? $ee_options['crazyegg_pixel_id'] : ""; ?>
            <div id="crazyegg_box" class="py-1">
                <div class="row pt-2">
                    <div class="col-6">
                        <label class="conv-field-label d-flex align-items-center"><?php esc_html_e("Crazy Egg Pixel ID:", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </label>
                        <input type="text" name="crazyegg_pixel_id" id="crazyegg_pixel_id" class="form-control valtoshow_inpopup_this" value="<?php echo esc_attr($crazyegg_pixel_id); ?>">
                        <a href="https://www.conversios.io/docs/how-to-find-crazyegg-pixel-id/?utm_source=woo_aiofree_plugin&utm_medium=otherpixelsetting&utm_campaign=woo_aiofree_plugin" target="_blank" style="font-size: 12px; color: #0073aa; font-weight: 500; text-decoration: none; display:inline-block; margin-top:4px;">How to Find CrazyEgg Pixel ID &rarr;</a>
                    </div>
                </div>
            </div>
            <!-- Crazy Egg Pixel End-->

        </div>
    </form>
    <input type="hidden" id="valtoshow_inpopup" value="Crazy Egg Pixel ID:" />

</div>