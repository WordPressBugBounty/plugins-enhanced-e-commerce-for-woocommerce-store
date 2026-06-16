<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$is_sel_disable = 'disabled';
?>
<div class="conv-card p-4 rounded conv-shadow-sm">
    <!-- Header -->
    <div class="d-flex align-items-center mb-3">
        <?php echo wp_kses(
            enhancad_get_plugin_image('/admin/images/logos/conv_clarity_logo.png', '', 'align-self-center conv-channel-logo'),
            array(
                'img' => array(
                    'src' => true,
                    'alt' => true,
                    'class' => true,
                    'style' => true,
                ),
            )
        ); ?>
        <h4 class="conv-card-title ms-2">Microsoft Clarity</h4>
    </div>
    <hr class="conv-header-hr">
    <form id="pixelsetings_form" class="convpixsetting-inner-box">
        <div>
            <!-- MS Clarity Pixel -->
            <?php $msclarity_pixel_id = isset($ee_options['msclarity_pixel_id']) ? $ee_options['msclarity_pixel_id'] : ""; ?>
            <div id="msclarity_box" class="py-1">
                <div class="row pt-2">
                    <div class="col-6">
                        <label class="conv-field-label d-flex align-items-center"><?php esc_html_e("Microsoft Clarity ID:", "enhanced-e-commerce-for-woocommerce-store"); ?></label>
                        <input type="text" name="msclarity_pixel_id" id="msclarity_pixel_id"
                            class="form-control valtoshow_inpopup_this mb-1"
                            value="<?php echo esc_attr($msclarity_pixel_id); ?>" placeholder="e.g. ij312itarj"
                            popuptext="Microsoft Clarity ID:">
                        <a href="https://www.conversios.io/blog/how-to-find-microsoft-clarity-id/?utm_source=woo_aiofree_plugin&utm_medium=otherpixelsetting&utm_campaign=woo_aiofree_plugin" target="_blank" style="font-size: 12px; color: #0073aa; font-weight: 500; text-decoration: none; display:inline-block; margin-top:4px;">How to Find Microsoft Clarity ID &rarr;</a>
                    </div>
                </div>
            </div>
            <!-- MS Clarity Pixel End-->
        </div>
    </form>
    <input type="hidden" id="valtoshow_inpopup" value="Microsoft Clarity ID:" />

</div>

<script>
jQuery(function() {
    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    let tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});
</script>