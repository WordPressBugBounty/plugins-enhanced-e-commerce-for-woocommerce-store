<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
$is_sel_disable = 'disabled';
?>
<div class="conv-card p-4 rounded conv-shadow-sm">
    <!-- Header -->
    <div class="d-flex align-items-center mb-3">
        <?php echo wp_kses(
            enhancad_get_plugin_image('/admin/images/logos/conv_linkedin_logo.png', '', 'align-self-center conv-channel-logo'),
            array(
                'img' => array(
                    'src' => true,
                    'alt' => true,
                    'class' => true,
                    'style' => true,
                ),
            )
        ); ?>
        <h4 class="conv-card-title ms-2">LinkedIn Insight Tag</h4>
    </div>
    <hr class="conv-header-hr">
    <form id="pixelsetings_form" class="convpixsetting-inner-box">
        <div>
            <!-- Linkedin Insight -->
            <?php $linkedin_insight_id = isset($ee_options['linkedin_insight_id']) ? $ee_options['linkedin_insight_id'] : ""; ?>
            <div id="pintrest_box" class="py-1">
                <div class="row pt-2">
                    <div class="col-6">
                        <label class="conv-field-label d-flex align-items-center"><?php esc_html_e("Linkedin Insight ID:", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </label>
                        <input type="text" name="linkedin_insight_id" id="linkedin_insight_id" class="form-control valtoshow_inpopup_this" value="<?php echo esc_attr($linkedin_insight_id); ?>">
                        <a href="https://www.conversios.io/blog/linkedin-insight-tag-id/?utm_source=woo_aiofree_plugin&utm_medium=otherpixelsetting&utm_campaign=woo_aiofree_plugin" target="_blank" style="font-size: 12px; color: #0073aa; font-weight: 500; text-decoration: none; display:inline-block; margin-top:4px;">How to Find LinkedIn Insight Tag ID &rarr;</a>
                    </div>
                </div>
            </div>
            <!-- Linkedin Insight End-->
        </div>

    </form>
    <input type="hidden" id="valtoshow_inpopup" value="Linkedin Insight ID:" />

</div>
