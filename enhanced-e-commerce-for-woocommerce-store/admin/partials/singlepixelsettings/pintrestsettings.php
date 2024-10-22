<?php
if (! defined('ABSPATH')) exit; // Exit if accessed directly 
$is_sel_disable = 'disabled';
?>
<div class="convcard p-4 mt-0 rounded-3 shadow-sm">
    <ul class="conv-green-checklis list-unstyled mt-3">
        <li class="d-flex">
            <span class="material-symbols-outlined text-success md-18">
                check_circle
            </span>
            <?php esc_html_e("E-commerce conversion tracking including Purchase", "enhanced-e-commerce-for-woocommerce-store"); ?>
            <span class="material-symbols-outlined text-secondary md-18 ps-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Page Visit, Add to Cart, Checkout (Purchase).">
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
            <!-- Pinterest Pixel -->
            <?php $pinterest_ads_pixel_id = isset($ee_options['pinterest_ads_pixel_id']) ? $ee_options['pinterest_ads_pixel_id'] : ""; ?>
            <div id="pintrest_box" class="py-1">
                <div class="row pt-2">
                    <div class="col-7">
                        <h5 class="d-flex align-items-center mb-1 text-dark">
                            <b><?php esc_html_e("Pinterest Pixel ID:", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                            <?php if (!empty($pinterest_ads_pixel_id)) { ?>
                                <span class="material-symbols-outlined text-success ms-1 fs-6">check_circle</span>
                            <?php } ?>
                            <!-- <span class="material-symbols-outlined text-secondary md-18 ps-2" data-bs-toggle="tooltip" data-bs-placement="top" title="The Pinterest Ads pixel ID looks like. 2612831678022">
                                info
                            </span> -->
                        </h5>
                        <input type="text" name="pinterest_ads_pixel_id" id="pinterest_ads_pixel_id" class="form-control valtoshow_inpopup_this" value="<?php echo esc_attr($pinterest_ads_pixel_id); ?>" placeholder="e.g. 2612831678022">
                    </div>
                </div>
            </div>
            <!-- Pinterest Pixel End-->
        </div>
    </form>
    <input type="hidden" id="valtoshow_inpopup" value="Pinterest Pixel ID:" />

</div>