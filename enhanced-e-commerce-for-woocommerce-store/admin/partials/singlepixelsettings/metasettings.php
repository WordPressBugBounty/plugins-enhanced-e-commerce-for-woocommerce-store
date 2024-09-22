<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';
$is_sel_disable = 'disabled';
$google_merchant_center_id = (isset($googleDetail->google_merchant_center_id) && $googleDetail->google_merchant_center_id != "") ? $googleDetail->google_merchant_center_id : "";
$site_url = "admin.php?page=conversios-google-shopping-feed&tab=";
$store_country = get_option('woocommerce_default_country');
$store_country = explode(":",$store_country);
if($store_country[0]){
    $country = $store_country[0];
}else{
    $country = '';
}
$woo_currency = get_option('woocommerce_currency');
$timezone = get_option('timezone_string');
$confirm_url = "admin.php?page=conversios-google-shopping-feed&subpage=metasettings";
$fb_mail = isset($ee_options['facebook_setting']['fb_mail']) === TRUE ? esc_html($ee_options['facebook_setting']['fb_mail']) : '';
if (isset($_GET['g_mail']) == TRUE) {
    $fb_mail = sanitize_email($_GET['g_mail']);
}
// $error = '';
// if(isset($_GET['error'])) {
//     $error = $_GET['error'];
// }
$fb_business_id = isset($ee_options['facebook_setting']['fb_business_id']) === TRUE ? esc_html($ee_options['facebook_setting']['fb_business_id']) : '';
$fb_catalog_id = isset($ee_options['facebook_setting']['fb_catalog_id']) === TRUE ? esc_html($ee_options['facebook_setting']['fb_catalog_id']) : '';
$conv_data = $TVC_Admin_Helper->get_store_data();
$filesystem = new WP_Filesystem_Direct(true);
$getCountris = $filesystem->get_contents(ENHANCAD_PLUGIN_DIR . "includes/setup/json/countries.json");
$contData = json_decode($getCountris);
?>
<style>
    .tooltip-inner {
        max-width: 500px !important;
    }

    body {
        max-height: 100%;
        background: #f0f0f1;
    }

    #tvc_popup_box {
        width: 500px;
        overflow: hidden;
        background: #eee;
        box-shadow: 0 0 10px black;
        border-radius: 10px;
        position: absolute;
        top: 30%;
        left: 40%;
        display: none;
    }
</style>
<div class="convcard p-4 mt-0 rounded-3 shadow-sm">
    <?php if (isset($pixel_settings_arr[$subpage]['topnoti']) && $pixel_settings_arr[$subpage]['topnoti'] != "") { ?>
        <div class="alert d-flex align-items-cente p-0" role="alert">
            <div class="text-light conv-success-bg rounded-start d-flex">
                <span class="p-2 material-symbols-outlined align-self-center">verified</span>
            </div>
            <div class="p-2 w-100 rounded-end border border-start-0 shadow-sm conv-notification-alert bg-white">
                <div class="">
                    <?php printf(esc_html__('%s', 'enhanced-e-commerce-for-woocommerce-store'), esc_html($pixel_settings_arr[$subpage]['topnoti'])); ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="alert d-flex align-items-cente p-0">
        <div class="convpixsetting-inner-box">            
            <span>
                <?php echo esc_html($fb_mail);                
                    $businessId = '';
                    $subId = isset($_GET['subscription_id']) ? esc_html($_GET['subscription_id']) : esc_html($subscriptionId);
                    $facebook_auth_url = TVC_API_CALL_URL_TEMP . '/auth/facebook?domain='.esc_url_raw(get_site_url()).'&app_id='.$app_id.'&country='.$country.'&user_currency='.$woo_currency.'&subscription_id='.$subId.'&confirm_url='.admin_url().$confirm_url.'&timezone='.$timezone.'&scope=productFeed' ;
                    
                    if(isset($_GET['subscription_id']) || $fb_business_id !== ''){
                        $data = array(
                            "customer_subscription_id" => esc_html($subId)
                        );
                        $businessId =  $customApiObj->getUserBusinesses($data);
                    }
                    if($fb_business_id !== ''){
                        $cat_data = array(
                            "customer_subscription_id" => esc_html($subId),
                            "business_id" => esc_html($fb_business_id),
                        );
                        $catalogId = $customApiObj->getCatalogList($cat_data);
                    }
                ?>
                <span class="conv-link-blue ps-2 facebookLogin" id="facebookLogin">
                    <a onclick="window.open('<?php echo $facebook_auth_url ?>','MyWindow','width=800,height=700,left=300, top=150'); return false;" href="#">
                        <?php if(isset($ee_options['facebook_setting']['fb_business_id']) || isset($_GET['subscription_id'])) {
                          echo 'Change'  ;
                        }else{
                          echo '<button class="btn conv-blue-bg text-white"><img style="width:24px" src="'. esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logos/fb_channel_logo.png') .'" /> &nbsp;Sign In with Facebook</button>';
                        } ?>
                    </a>
                </span>
            </span>
        </div>
    </div>   

    <form id="gmcsetings_form" class="convpixsetting-inner-box mt-4">
        <div id="analytics_box_UA" class="py-1 row">
            <div class="col-5">
                <label class="text-dark">
                    <?php esc_html_e("Facebook Business ID", "enhanced-e-commerce-for-woocommerce-store"); ?>
                </label>
                <div class="pt-2 conv-metasettings">
                    <div class="col-12">
                        <select class="select2" id="fb_business_id" name="fb_business_id" style="width:100%" <?php echo isset($_GET['subscription_id']) ? '' : "disabled" ?> >
                            <option value="">Select Business Id</option>
                            <?php 
                            $selectedBusId = '';
                            $selectBusChek = '';
                                if(isset($businessId) && $businessId != ''){
                                    foreach($businessId as $key => $businessVal){ 
                                        $selectedBusId = isset($ee_options['facebook_setting']['fb_business_id']) && $ee_options['facebook_setting']['fb_business_id'] == $key ?  "selected" : '' ;
                                        if($selectedBusId == 'selected'){
                                            $selectBusChek = 'selected';
                                        }
                                        ?>
                                            <option value="<?php echo esc_attr($key) ?>" <?php echo isset($ee_options['facebook_setting']['fb_business_id']) && $ee_options['facebook_setting']['fb_business_id'] == $key ?  "selected" : '' ?> ><?php echo esc_html($businessVal) ?></option>
                                    <?php 
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <label class="text-dark">
                    <?php esc_html_e("Facebook Catalog ID", "enhanced-e-commerce-for-woocommerce-store"); ?>
                </label>
                <div class="pt-2 conv-metasettings">
                    <div class="col-12">
                        <select class="select2" id="fb_catalog_id" name="fb_catalog_id" style="width:100%" <?php echo isset($_GET['subscription_id']) ? '' : "disabled" ?>>
                            <option value="">Select Catalog Id</option>
                            <?php 
                                $selectChek = '';
                                $selected = '';
                                if(isset($catalogId->data)){
                                    foreach($catalogId->data as $key => $catalogVal){ 
                                        $selected = isset($ee_options['facebook_setting']['fb_catalog_id']) && $ee_options['facebook_setting']['fb_catalog_id'] == $catalogVal->id ?  "selected" : '';
                                        if($selected == 'selected'){
                                            $selectChek = 'selected';
                                        }
                                        ?>                                                                                             
                                            <option value="<?php echo esc_attr($catalogVal->id) ?>" <?php echo isset($ee_options['facebook_setting']['fb_catalog_id']) && $ee_options['facebook_setting']['fb_catalog_id'] == $catalogVal->id ?  "selected" : '' ?> ><?php echo esc_html($catalogVal->id).'-'.esc_html($catalogVal->name) ?></option>
                                        <?php 
                                    }
                                }
                            ?>
                        </select>                                                  
                    </div>
                </div>
            </div>
            <div class="col-2 editDiv <?php echo isset($ee_options['facebook_setting']['fb_business_id']) ? '' : 'd-none' ?>">
                <div class="conv-enable-selection text-primary pt-4-5">                    
                    <span class="material-symbols-outlined">edit</span><label class="mb-2 fs-12 text">Edit</label>
                </div>
            </div>
        </div>
        <input type="hidden" id="fb_mail" value="<?php echo esc_attr($fb_mail) ?>" />
    </form>

</div>

<!-------------------------CTA POP up Start ---------------------------------->
<div class="modal fade" id="conv_save_success_modal_cta" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <div class="connection-box">
                    <div class="items">
                        <img style="width:35px;"
                            src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/logos/popup_woocommerce _logo.png'); ?>">
                        <span>
                            <?php esc_html_e("Woo Commerce", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </span>
                    </div>
                    <div class="items">
                        <span class="material-symbols-outlined text-primary">
                            arrow_forward
                        </span>
                    </div>
                    <div class="items">
                        <img style="width:35px;"
                            src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/logos/fb_channel_logo.png'); ?>">
                        <span>
                            <?php esc_html_e("Facebook Business Account", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </span>
                    </div>
                </div>

            </div>
            <div class="modal-body text-center p-4">
                <div class="connected-content">
                    <h4>
                        <?php esc_html_e("Successfully Connected", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </h4>
                    <p><span class="fw-bolder">Facebook Business Account -</span> <span
                            class="gmcAccount fw-bolder"></span>
                        Has Been Successfully Connected</p>
                    <p class="my-3">
                        <?php esc_html_e("Success! Your product feed is now linked to Facebook's powerful catalog, unlocking vast global audiences and maximizing your sales potential through our plugin."); ?>
                    </p>
                </div>
                <div>
                    <div class="attributemapping-box">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <div class="attribute-box mb-3">
                                    <div class="attribute-icon">
                                        <img style="width:35px;"
                                            src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/logos/Manage_feed.png'); ?>">
                                    </div>
                                    <div class="attribute-content para">
                                        <h3>
                                            <?php esc_html_e("Manage Feeds", "enhanced-e-commerce-for-woocommerce-store"); ?>
                                        </h3>
                                        <p>
                                            <?php esc_html_e("A feed management tool offers benefits such as centralized product updates,
                                            optimized product listings, and improved data quality, ultimately enhancing
                                            the efficiency and effectiveness of your product feed management process.", "enhanced-e-commerce-for-woocommerce-store"); ?>

                                        </p>
                                        <div class="attribute-btn">
                                            <a href="#" class="btn btn-dark common-btn">Create Feed</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                            <div class="" style="justify-content: center">
                                <a 
                                href="<?php echo esc_url_raw('admin.php?page=conversios-google-shopping-feed&subpage="gmcsettings"'); ?>">Connect
                                to Google Merchant Center</a> <span>OR</span> 
                                <a
                                href="<?php echo esc_url_raw('admin.php?page=conversios-google-shopping-feed&subpage="tiktokBusinessSettings"'); ?>">Connect
                                to TikTok Business Account</a>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--------------------------------CTA popup End -------------------------------------->
<?php
$google_merchant_center_id = '';
if (isset($googleDetail->google_merchant_center_id) === TRUE && $googleDetail->google_merchant_center_id !== '') {
    $google_merchant_center_id = esc_html($googleDetail->google_merchant_center_id);
}
$tiktok_business_account = '';
if (isset($googleDetail->tiktok_setting->tiktok_business_id) === TRUE && $googleDetail->tiktok_setting->tiktok_business_id !== '') {
    $tiktok_business_account = esc_html($googleDetail->tiktok_setting->tiktok_business_id);
}

?>
<!-- Create Feed Modal -->
<div class="modal fade" id="convCreateFeedModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ">
            <form id="feedForm" onfocus="this.className='focused'">
                <div id="loadingbar_blue_modal" class="progress-materializecss d-none ps-2 pe-2" style="width:98%">
                    <div class="indeterminate"></div>
                </div>
                <div class="modal-header bg-light p-2 ps-4">
                    <h5 class="modal-title fs-16 fw-500" id="feedType">
                        <?php esc_html_e("Create New Feed", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="jQuery('#feedForm')[0].reset()"></button>
                </div>
                <div class="modal-body ps-4 pt-0">
                    <div class="mb-4 feed_name">
                        <label for="feed_name" class="col-form-label text-dark fs-14 fw-500">
                            <?php esc_html_e("Feed Name", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </label>
                        <span class="material-symbols-outlined fs-6" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="Add a name to your feed for your reference, for example, 'April end-of-season sales' or 'Black Friday sales for the USA'.">
                            info
                        </span>
                        <input type="text" class="form-control fs-14" name="feedName" id="feedName"
                            placeholder="e.g. New Summer Collection">
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5">
                            <label for="auto_sync" class="col-form-label text-dark fs-14 fw-500">
                                <?php esc_html_e("Auto Sync", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </label>
                            <span class="material-symbols-outlined fs-6" data-bs-toggle="tooltip"
                                data-bs-placement="right"
                                title="Turn on this feature to schedule an automated product feed to keep your products up to date with the changes made in the products. You can come and change this any time.">
                                info
                            </span>
                        </div>
                        <div class="form-check form-switch col-7 mt-0 fs-5">
                            <input class="form-check-input" type="checkbox" name="autoSync" id="autoSync" checked>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-5">
                            <label for="auto_sync_interval" class="col-form-label text-dark fs-14 fw-500">
                                <?php esc_html_e("Auto Sync Interval", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </label>
                            <span class="material-symbols-outlined fs-6" data-bs-toggle="tooltip"
                                data-bs-placement="right"
                                title="Set the number of days to schedule the next auto-sync for the products in this feed. You can come and change this any time.">
                                info
                            </span>
                        </div>
                        <div class="col-7 feed_name">
                            <input type="text" class="form-control-sm fs-14 " <?php echo ($plan_id === 1) ? 'readonly="readonly"' : ''; ?> name="autoSyncIntvl" id="autoSyncIntvl" size="3" min="1"
                                onkeypress="return ( event.charCode === 8 || event.charCode === 0 || event.charCode === 13 || event.charCode === 96) ? null : event.charCode >= 48 && event.charCode <= 57"
                                oninput="removeZero();" value="25">
                            <label for="" class="col-form-label fs-14 fw-400">
                                <?php esc_html_e("Days", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </label>
                            <span>
                                <?php echo ($plan_id === 1) ? '<a target="_blank" href="https://www.conversios.io/wordpress/product-feed-manager-for-woocommerce-pricing/?utm_source=app_wooPFM&utm_medium=BUSINESS&utm_campaign=Pricing"><b> Upgrade To Pro</b></a>' : ''; ?>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-5">
                            <label for="target_country" class="col-form-label text-dark fs-14 fw-500" name="">
                                <?php esc_html_e("Target Country", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </label>
                            <span class="material-symbols-outlined fs-6" data-bs-toggle="tooltip"
                                data-bs-placement="right"
                                title="Specify the target country for your product feed. Select the country where you intend to promote and sell your products.">
                                info
                            </span>
                        </div>
                        <div class="col-7">
                            <select class="select2 form-select form-select-sm mb-3" aria-label="form-select-sm example"
                                style="width: 100%" name="target_country" id="target_country">
                                <option value="">Select Country</option>
                                <?php
                                $selecetdCountry = $conv_data['user_country'];
                                foreach ($contData as $key => $value) {
                                    ?>
                                    <option value="<?php echo esc_attr($value->code) ?>" <?php echo $selecetdCountry === $value->code ? 'selected = "selecetd"' : '' ?>><?php echo esc_html($value->name) ?></option>"
                                    <?php
                                }

                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="auto_sync_interval" class="col-form-label text-dark fs-14 fw-500">
                            <?php esc_html_e("Select Channel", "enhanced-e-commerce-for-woocommerce-store"); ?>
                        </label>
                        <span class="material-symbols-outlined fs-6" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="Below is the list of channels that you have linked for product feed. Please note you will not be able to make any changes in the selected channels once product feed process is done.">
                            info
                        </span>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-check-custom">
                            <input class="form-check-input check-height fs-14 errorChannel" type="checkbox"
                                value="<?php echo $google_merchant_center_id !== '' ? esc_html($google_merchant_center_id) : '' ?>"
                                id="gmc_id" name="gmc_id" <?php echo $google_merchant_center_id !== '' ? "checked" : 'disabled' ?>>
                            <label for="" class="col-form-label fs-14 pt-0 text-dark fw-500">
                                <?php esc_html_e("Google Merchant Center Account :", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </label>
                            <label class="col-form-label fs-14 pt-0 fw-400 modal_google_merchant_center_id">
                                <?php echo $google_merchant_center_id !== '' ? esc_html($google_merchant_center_id) : '' ?>
                            </label>
                        </div>
                        <div class="form-check form-check-custom">
                            <input class="form-check-input check-height fs-14 errorChannel" type="checkbox" 
                            value="" id="tiktok_id" name="tiktok_id" <?php echo $tiktok_business_account !== '' ? "checked" : 'disabled' ?>>
                            <label for="" class="col-form-label fs-14 pt-0 text-dark fw-500">
                                <?php esc_html_e("TikTok Catalog Id :", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </label>
                            <label class="col-form-label fs-14 pt-0 fw-400 tiktok_catalog_id">
                                <?php //echo isset($tiktok_catalog_id) && $tiktok_catalog_id !== '' ? $tiktok_catalog_id : '' ?>
                            </label>
                        </div>
                        <div class="form-check form-check-custom">
                            <input class="form-check-input check-height fs-14 errorChannel" type="checkbox" value=""
                                id="fb_id" name="fb_id" checked>
                            <label for="" class="col-form-label fs-14 pt-0 text-dark fw-500">
                                <?php esc_html_e("Facebook Catalog Id :", "enhanced-e-commerce-for-woocommerce-store"); ?>
                            </label>
                            <label class="col-form-label fs-14 pt-0 fw-400 fb_id">

                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-2">
                    <input type="hidden" id="edit" name="edit">
                    <input type="hidden" id="tiktok_catalog_id" name="tiktok_catalog_id" value="">
                    <input type="hidden" id="is_mapping_update" name="is_mapping_update" value="">
                    <input type="hidden" id="last_sync_date" name="last_sync_date" value="">
                    <button type="button" class="btn btn-light btn-sm border" data-bs-dismiss="modal"
                        onclick="jQuery('#feedForm')[0].reset()">
                        <?php esc_html_e("Cancel", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </button>
                    <button type="button" class="btn btn-soft-primary btn-sm" id="submitFeed">
                        <?php esc_html_e("Create and Next", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    //Onload functions
    jQuery(function () {
        var tvc_data = "<?php echo esc_js(wp_json_encode($tvc_data)); ?>";
        var tvc_ajax_url = '<?php echo esc_url_raw(admin_url('admin-ajax.php')); ?>';
        let subscription_id = "<?php echo esc_attr($subId); ?>";
        let plan_id = "<?php echo esc_attr($plan_id); ?>";
        let app_id = "<?php echo esc_attr($app_id); ?>";
        let bagdeVal = "yes";
        let convBadgeVal = "<?php echo esc_attr($convBadgeVal); ?>";
        let fb_business_id = "<?php echo esc_attr($fb_business_id); ?>";
        jQuery('#fb_catalog_id').select2({ dropdownCssClass: "fs-12" });
        jQuery('#fb_business_id').select2({ dropdownCssClass: "fs-12" });
        jQuery('.hreflink').attr('href', 'admin.php?page=conversios-google-shopping-feed&tab=gaa_config_page');        
        
        jQuery(document).on("change", "form#gmcsetings_form", function () {
            jQuery(".conv-btn-connect").removeClass("conv-btn-connect-disabled");
            jQuery(".conv-btn-connect").addClass("btn-primary");
            jQuery(".conv-btn-connect").text('Save');
        });  
        
        <?php
            if(isset($_GET['subscription_id'])) { ?>
                jQuery('.editDiv').addClass('d-none')
                jQuery(".conv-btn-connect").removeClass("conv-btn-connect-disabled");
                jQuery(".conv-btn-connect").addClass("btn-primary");
                jQuery(".conv-btn-connect").text('Save');
          <?php  }
         ?>

        // Save data
        jQuery(document).on("click", ".conv-btn-connect", function () {
            var selected_vals = {};
            var facebook_data = {};
            facebook_data["fb_mail"] = jQuery('#fb_mail').val();
            facebook_data["fb_business_id"] = jQuery('#fb_business_id').find(":selected").val();
            facebook_data["fb_catalog_id"] = jQuery('#fb_catalog_id').find(":selected").val();
            selected_vals["facebook_setting"] = facebook_data;
            if (facebook_data["fb_business_id"] === '') {
                jQuery('.selection').find("[aria-labelledby='select2-fb_business_id-container']").addClass('selectError');
                return false;
            }
            if (facebook_data["fb_catalog_id"] === '') {
                jQuery('.selection').find("[aria-labelledby='select2-fb_catalog_id-container']").addClass('selectError');
                return false;
            }
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: tvc_ajax_url,
                data: {
                    action: "conv_save_pixel_data",
                    pix_sav_nonce: "<?php echo esc_js(wp_create_nonce('pix_sav_nonce_val')); ?>",
                    conv_options_data: selected_vals,
                    customer_subscription_id: "<?php echo esc_html($subId) ?>",
                    conv_options_type: ["eeoptions", "facebookmiddleware", "facebookcatalog"],
                },
                beforeSend: function () {
                    conv_change_loadingbar("show");
                    jQuery(".conv-btn-connect").text("Saving...");
                    jQuery(".conv-btn-connect").addClass('disabled');
                },
                success: function (response) {
                    conv_change_loadingbar("hide");
                    if (response == "0" || response == "1") {
                        jQuery(".conv-btn-connect").text("Save");
                        jQuery('.gmcAccount').html(facebook_data["fb_business_id"])
                        jQuery("#conv_save_success_modal_cta").modal("show");
                    }
                }
            });

        });
        /********************Modal POP up validation on click remove**********************************/
        jQuery(document).on('input', '#feedName', function (e) {
            e.preventDefault();
            jQuery('#feedName').css('margin-left', '0px');
            jQuery('#feedName').css('margin-right', '0px');
            jQuery('#feedName').removeClass('errorInput');
        });
        jQuery(document).on('click', '#gmc_id', function (e) {
            jQuery('.errorChannel').css('border', '');
        });
        jQuery(document).on('click', '#tiktok_id', function (e) {
            jQuery('.errorChannel').css('border', '');
        });
        jQuery(document).on('click', '#fb_id', function (e) {
            jQuery('.errorChannel').css('border', '');
        });
        /********************Modal POP up validation on click remove end **********************************/
        /************************************* Auto Sync Toggle Button Start*************************************************************************/
        jQuery(document).on('change', '#autoSync', function () {
            var autoSync = jQuery('input#autoSync').is(':checked');
            if (autoSync) {
                jQuery('#autoSyncIntvl').attr('disabled', false);
            } else {
                jQuery('#autoSyncIntvl').attr('disabled', true);
                jQuery('#autoSyncIntvl').val(25);
                jQuery('#autoSyncIntvl').removeClass('errorInput');
            }
        });
        /************************************* Auto Sync Toggle Button End*************************************************************************/
    });
    jQuery(document).on('change', '#fb_business_id', function() {
        jQuery('.selection').find("[aria-labelledby='select2-fb_business_id-container']").removeClass('selectError');
        var fb_business = jQuery('#fb_business_id').find(":selected").val();
        if(fb_business != ''){
            var data = {
                action: "get_fb_catalog_data",
                customer_subscription_id: <?php echo esc_html($subId) ?>,
                fb_business_id: fb_business,
                fb_business_nonce: "<?php echo esc_js(wp_create_nonce('fb_business_nonce')); ?>"
            }
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: tvc_ajax_url,
                data: data,
                beforeSend: function(){
                    conv_change_loadingbar('show') 
                },
                success: function(response){ 
                    var cat_id = "<?php echo isset($ee_options['facebook_setting']['fb_catalog_id']) ? esc_js($ee_options['facebook_setting']['fb_catalog_id']) : '' ?>";                      
                    $html = '<option value="">Select Catalog Id</option>';
                    $.each(response, function(index, value){
                        var selected = (value.id == cat_id ) ? 'selected' : '';                        
                        $html +='<option value="'+value.id+'" '+selected+'>'+value.id+'-'+value.name+'</option>';
                    });
                    $('#fb_catalog_id').html($html);
                    conv_change_loadingbar('hide') 
                }
            });
        } else {
            $html = '<option value="">Select Catalog Id</option>';
            $('#fb_catalog_id').html($html);
        }
    })
    jQuery(document).on('click', '.conv-enable-selection', function() {
        jQuery('#fb_business_id').removeAttr('disabled')
        jQuery('#fb_catalog_id').removeAttr('disabled')
        jQuery('.conv-enable-selection').addClass('d-none')
        jQuery(".conv-btn-connect").removeClass("conv-btn-connect-disabled")
        jQuery(".conv-btn-connect").addClass("btn-primary")
    })

    jQuery(".common-btn").on("click", function () {
        jQuery("#conv_save_success_modal_cta").modal("hide");
        jQuery('#autoSyncIntvl').attr('disabled', false);
        jQuery('#target_country').attr('disabled', false);
        jQuery("#feedForm")[0].reset();
        jQuery('#feedType').text('Create New Feed');
        jQuery('.fb_id').text(jQuery('#fb_catalog_id').find(":selected").val())
        jQuery('#convCreateFeedModal').modal('show');
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })  
        var tiktok_business_account = "<?php echo esc_html($tiktok_business_account) ?>";
        if (tiktok_business_account !== '' && jQuery('#tiktok_id').is(":checked")) {
            getCatalogId(jQuery('#target_country').find(":selected").val());
        }      
        jQuery('#target_country').select2({ dropdownParent: jQuery("#convCreateFeedModal") });
    });

        /****************Submit Feed call start*********************************/
        jQuery(document).on('click', '#submitFeed', function (e) {
            e.preventDefault();
            let feedName = jQuery('#feedName').val();
            if (feedName === '') {
                jQuery('#feedName').css('margin-left', '0px');
                jQuery('#feedName').css('margin-right', '0px');
                jQuery('#feedName').addClass('errorInput');
                var l = 4;
                for (var i = 0; i <= 2; i++) {
                    jQuery('#feedName').animate({
                        'margin-left': '+=' + (l = -l) + 'px',
                        'margin-right': '-=' + l + 'px'
                    }, 50);
                }
                return false;
            }

            let autoSyncIntvl = jQuery('#autoSyncIntvl').val();
            if (autoSyncIntvl === '') {
                jQuery('#autoSyncIntvl').css('margin-left', '0px');
                jQuery('#autoSyncIntvl').css('margin-right', '0px');
                jQuery('#autoSyncIntvl').addClass('errorInput');
                var l = 4;
                for (var i = 0; i <= 2; i++) {
                    jQuery('#autoSyncIntvl').animate({
                        'margin-left': '+=' + (l = -l) + 'px',
                        'margin-right': '-=' + l + 'px'
                    }, 50);
                }
                return false;
            }

            let target_country = jQuery('#target_country').find(":selected").val();
            if (target_country === "") {
                jQuery('.select2-selection').css('border', '1px solid #ef1717');
                return false;
            }

            if (!jQuery('#gmc_id').is(":checked") && !jQuery('#tiktok_id').is(":checked") && !jQuery('#fb_id').is(':checked')) {
                jQuery('.errorChannel').not(':disabled').css('border', '1px solid red');
                return false;
            }

            save_feed_data();
        });

        /****************Submit Feed call end***********************************/
        function removeZero() {
        var val = jQuery("#autoSyncIntvl").val();
        if (val === '0') {
            jQuery("#autoSyncIntvl").val('')
        }
    }
        /*************************************Save Feed Data Start*************************************************************************/
        function save_feed_data() {
            var conv_onboarding_nonce = "<?php echo esc_js(wp_create_nonce('conv_onboarding_nonce')); ?>"
            var planid = "<?php echo esc_attr($plan_id); ?>";
            var data = {
                action: "save_feed_data",
                feedName: jQuery('#feedName').val(),
                google_merchant_center: jQuery('input#gmc_id').is(':checked') ? '1' : '',
                fb_catalog_id:jQuery('input#fb_id').is(':checked') ? '2' : '',
                tiktok_id: jQuery('input#tiktok_id').is(':checked') ? '3' : '',
                tiktok_catalog_id: jQuery('input#tiktok_id').is(':checked') ? jQuery('input#tiktok_id').val() : '',
                tiktok_business_account: "<?php echo esc_html($tiktok_business_account) ?>",             
                autoSync: jQuery('input#autoSync').is(':checked') ? '1' : '0',
                autoSyncIntvl: jQuery('#autoSyncIntvl').val(),
                last_sync_date: '',
                is_mapping_update: '',
                target_country: jQuery('#target_country').find(":selected").val(),
                customer_subscription_id: "<?php echo esc_html($subId) ?>",            
                conv_onboarding_nonce: conv_onboarding_nonce
            }
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: tvc_ajax_url,
                data: data,
                beforeSend: function () {
                    conv_change_loadingbar_modal('show');
                },
                error: function (err, status) {
                    conv_change_loadingbar_modal('hide');
                    jQuery('#convCreateFeedModal').modal('hide');
                    jQuery("#conv_save_error_txt").html('Error occured.');
                    jQuery("#conv_save_error_modal").modal("show");
                },
                success: function (response) {
                    if (response.id) {
                        jQuery('#convCreateFeedModal').modal('hide');
                        jQuery("#conv_save_success_txt_").html("Great job! Your product feed is ready! The next step is to select the products you want to sync and expand your reach across multiple channels.");
                        jQuery("#conv_save_success_modal_").modal("show");
                        setTimeout(function () {
                            window.location.replace("<?php echo esc_url_raw($site_url . 'product_list&id='); ?>" + response.id);
                        }, 100);
                    } else if (response.errorType === 'tiktok') {
                        jQuery('.tiktok_catalog_id').empty();
                        jQuery('.tiktok_catalog_id').html(response.message);
                        jQuery('.tiktok_catalog_id').addClass('text-danger');

                    } else {
                        jQuery('#convCreateFeedModal').modal('hide');
                        jQuery("#conv_save_error_txt").html(response.message);
                        jQuery("#conv_save_success_modal_").modal("show");
                    }
                    conv_change_loadingbar_modal('hide');
                }
            });

        }
        /*************************************Save Feed Data End***************************************************************************/
        function conv_change_loadingbar(state = 'show') {
            if (state === 'show') {
                jQuery("#loadingbar_blue").removeClass('d-none');
                jQuery("#wpbody").css("pointer-events", "none");
                jQuery('#submitFeed').attr('disabled', true);
            } else {
                jQuery("#loadingbar_blue").addClass('d-none');
                jQuery("#wpbody").css("pointer-events", "auto");
                jQuery('#submitFeed').attr('disabled', false);
            }
        } 
        function conv_change_loadingbar_modal(state = 'show') {
            if (state === 'show') {
                jQuery("#loadingbar_blue_modal").removeClass('d-none');
                jQuery("#wpbody").css("pointer-events", "none");
                jQuery('#submitFeed').attr('disabled', true);
            } else {
                jQuery("#loadingbar_blue_modal").addClass('d-none');
                jQuery("#wpbody").css("pointer-events", "auto");
                jQuery('#submitFeed').attr('disabled', false);
            }
        }
        /*************************************Get saved catalog id by country code start **************************************************/
    function getCatalogId($countryCode) {
        var conv_country_nonce = "<?php echo esc_html(wp_create_nonce('conv_country_nonce')); ?>";
        var data = {
            action: "ee_getCatalogId",
            countryCode: $countryCode,
            conv_country_nonce: conv_country_nonce
        }
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: tvc_ajax_url,
            data: data,
            beforeSend: function () {
                conv_change_loadingbar_modal('show');
            },
            error: function (err, status) {
                //conv_change_loadingbar_modal('hide');
            },
            success: function (response) {
                jQuery('.tiktok_catalog_id').empty()
                jQuery('#tiktok_id').empty();
                jQuery('.tiktok_catalog_id').removeClass('text-danger');

                if (response.error == false) {
                    if (response.data.catalog_id !== '') {
                        jQuery('#tiktok_id').val(response.data.catalog_id);
                        jQuery('.tiktok_catalog_id').text(response.data.catalog_id)
                    } else {
                        jQuery('#tiktok_id').val('Create New');
                        jQuery('.tiktok_catalog_id').text('You do not have a catalog associated with the selected target country. Do not worry we will create a new catalog for you.');
                    }
                }
                conv_change_loadingbar_modal('hide');
            }
        });
    }
    /*************************************Get saved catalog id by country code End ****************************************************/
    /****************Get tiktok catalog id on check box change ***************************************/
    jQuery(document).on('change', '#tiktok_id', function () {
            jQuery('.tiktok_catalog_id').empty();
            jQuery('#tiktok_id').val('');
            if (jQuery('#tiktok_id').is(":checked")) {
                getCatalogId(jQuery('#target_country').find(":selected").val())
            }
    });
    /****************Get tiktok catalog id on check box change end ***************************************/
    /****************Get tiktok catalog id on target country change ***************************************/
    jQuery(document).on('change', '#target_country', function (e) {
        var tiktok_business_account = "<?php echo esc_js($tiktok_business_account); ?>";
        jQuery('.select2-selection').css('border', '1px solid #c6c6c6');
        let target_country = jQuery('#target_country').find(":selected").val();
        jQuery('#tiktok_id').empty();
        jQuery('.tiktok_catalog_id').empty()
        if (target_country !== "" && tiktok_business_account !== "" && jQuery('input#tiktok_id').is(':checked')) {
            getCatalogId(target_country);
        }
    });
    /****************Get tiktok catalog id on target country change end ***************************************/
    
</script>
