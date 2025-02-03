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
            <span class="material-symbols-outlined text-secondary md-18 ps-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Select Content, View Item, Add to Cart, Checkout, Add Payment Info, Purchase.">
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
            <!-- MS Bing Pixel -->
            <?php $microsoft_ads_pixel_id = isset($ee_options['microsoft_ads_pixel_id']) ? $ee_options['microsoft_ads_pixel_id'] : ""; ?>
            <div id="msbing_box" class="py-1">
                <div class="row pt-2">
                    <div class="col-7">
                        <h5 class="d-flex align-items-center mb-1 text-dark">
                            <b><?php esc_html_e("Microsoft Ads (Bing) Pixel:", "enhanced-e-commerce-for-woocommerce-store"); ?></b>
                            <?php if (!empty($microsoft_ads_pixel_id)) { ?>
                                <span class="material-symbols-outlined text-success ms-1 fs-6">check_circle</span>
                            <?php } ?>
                            <!-- <span class="material-symbols-outlined text-secondary md-18 ps-2" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="The Microsoft Ads pixel ID looks like. 343003931">
                                info
                            </span> -->
                        </h5>
                        <input type="text" name="microsoft_ads_pixel_id" id="microsoft_ads_pixel_id"
                            class="form-control valtoshow_inpopup_this"
                            value="<?php echo esc_attr($microsoft_ads_pixel_id); ?>" placeholder="e.g. 343003931"
                            popuptext="Microsoft Ads (Bing) Pixel:">
                    </div>
                </div>

            </div>
            <!-- MS Bing Pixel End-->
        </div>
    </form>
    <input type="hidden" id="valtoshow_inpopup" value="Microsoft Ads (Bing) Pixel:" />

</div>

<script>
    jQuery(function() {
        jQuery('.convchkbox_setting').change(function() {
            this.value = (Number(this.checked));
        });

        if (jQuery("#microsoft_ads_pixel_id").val() == "") {
            jQuery("#msbing_conversion").attr('disabled', true);
            jQuery("#msbing_conversion").prop("checked", false);
            jQuery("#msbing_conversion").attr('checked', false);
        }

        jQuery("#microsoft_ads_pixel_id").change(function() {
            if (jQuery(this).hasClass('conv-border-danger') || jQuery(this).val() == "") {
                jQuery("#msbing_conversion").attr('disabled', true);
                jQuery("#msbing_conversion").prop("checked", false);
                jQuery("#msbing_conversion").attr('checked', false);
            } else {
                jQuery("#msbing_conversion").removeAttr('disabled');
            }
        });
    });
</script>

<script>
    jQuery(function() {
        //jQuery("#upgradetopro_modal_link").attr("href", '<?php echo esc_url($TVC_Admin_Helper->get_conv_pro_link_adv("popup", "twittersettings",  "conv-link-blue fw-bold", "linkonly")); ?>');

        let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        let tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>