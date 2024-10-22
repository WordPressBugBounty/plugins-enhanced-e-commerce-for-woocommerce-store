<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
$is_sel_disable = 'disabled';
?>
<div class="convcard p-4 mt-0 rounded-3 shadow-sm">
    <form id="pixelsetings_form" class="convpixsetting-inner-box">
        <div>
            <!-- Linkedin Insight -->
            <?php $linkedin_insight_id = isset($ee_options['linkedin_insight_id']) ? $ee_options['linkedin_insight_id'] : ""; ?>
            <div id="pintrest_box" class="py-1">
                <div class="row pt-2">
                    <div class="col-7">
                        <h5 class="d-flex align-items-center mb-1 text-dark">
                            <b><?php esc_html_e("Linkedin Insight ID:", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                            <?php if (!empty($linkedin_insight_id)) { ?>
                                <span class="material-symbols-outlined text-success ms-1 fs-6">check_circle</span>
                            <?php } ?>
                            <!-- <span class="material-symbols-outlined text-secondary md-18 ps-2" data-bs-toggle="tooltip" data-bs-placement="top" title="The Pinterest Ads pixel ID looks like. 2612831678022">
                                info
                            </span> -->
                        </h5>
                        <input type="text" name="linkedin_insight_id" id="linkedin_insight_id" class="form-control valtoshow_inpopup_this" value="<?php echo esc_attr($linkedin_insight_id); ?>" placeholder="e.g. 2612831678022">
                    </div>
                </div>
            </div>
            <!-- Linkedin Insight End-->
        </div>
    </form>
    <input type="hidden" id="valtoshow_inpopup" value="Linkedin Insight ID:" />

</div>
