<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly
if (!isset($is_refresh_token_expire)) { $is_refresh_token_expire = false; }
if (array_key_exists("microsoft_mail", $tvc_data) && sanitize_email($tvc_data["microsoft_mail"]) && isset($_GET['subscription_id']) && sanitize_text_field(wp_unslash($_GET['subscription_id']))) {
    update_option('ee_customer_msmail', sanitize_email($tvc_data["microsoft_mail"]));

    if (array_key_exists("access_token", $tvc_data) && array_key_exists("refresh_token", $tvc_data)) {
        $eeapidata = unserialize(get_option('ee_api_data'));
        $eeapidata_settings = new stdClass();

        if (!empty($eeapidata['setting'])) {
            $eeapidata_settings = $eeapidata['setting'];
        }

        $eeapidata_settings->access_token = base64_encode(sanitize_text_field($tvc_data["access_token"]));
        $eeapidata_settings->refresh_token = base64_encode(sanitize_text_field($tvc_data["refresh_token"]));

        $eeapidata['setting'] = $eeapidata_settings;
        update_option('ee_api_data', serialize($eeapidata));
    }

    // $eeapidata['setting'] = $eeapidata_settings;
    // update_option('ee_api_data', serialize($eeapidata));

    //is not work for existing user && $ee_additional_data['con_created_at'] != "" 
    if (isset($ee_additional_data['con_created_at'])) {
        $ee_additional_data = $TVC_Admin_Helper->get_ee_additional_data();
        if (!is_array($ee_additional_data)) {
            $ee_additional_data = [];
        }
        $ee_additional_data['con_updated_at'] = gmdate('Y-m-d');
        $TVC_Admin_Helper->set_ee_additional_data($ee_additional_data);
    } else {
        $ee_additional_data = $TVC_Admin_Helper->get_ee_additional_data();
        if (!is_array($ee_additional_data)) {
            $ee_additional_data = [];
        }
        $ee_additional_data['con_created_at'] = gmdate('Y-m-d');
        $ee_additional_data['con_updated_at'] = gmdate('Y-m-d');
        $TVC_Admin_Helper->set_ee_additional_data($ee_additional_data);
    }
}
$sub_page = (isset($_GET['subpage'])) ? sanitize_text_field(wp_unslash(filter_input(INPUT_GET, 'subpage'))) : "";
?>

<div class="convwiz_pixtitle mt-0 mb-3 d-flex justify-content-between align-items-center py-0">

   
    <div class="col convgauthcol">
        <div class="convpixsetting-inner-box ps-3" style="border-left: 3px solid #09bd83;">
            <?php
            $ee_customer_msmail = get_option('ee_customer_msmail');
            ?>
            <?php if ($ee_customer_msmail != "") { ?>
                <h5 class="fw-normal mb-1">
                    <?php esc_html_e("Successfully signed in with account:", "enhanced-e-commerce-for-woocommerce-store"); ?>
                </h5>
                <span>
                    <?php echo esc_html($ee_customer_msmail); ?>
                    <span class="conv-link-blue ps-0 tvc_microsoft_signinbtn">
                        <?php esc_html_e("Login with Microsoft", "enhanced-e-commerce-for-woocommerce-store"); ?>
                    </span>

                </span>
            <?php } else { ?>

                <div class="tvc_microsoft_signinbtn_box">
                    <div class="tvc_microsoft_signinbtn microsoft-btn d-flex align-items-center">
                        <div class="microsoft-icon-wrapper">
                            <?php echo wp_kses(
                                enhancad_get_plugin_image('/admin/images/logos/ms-logo.png', '', 'microsoft-icon', ''),
                                array(
                                    'img' => array(
                                        'src' => true,
                                        'alt' => true,
                                        'class' => true,
                                        'style' => true,
                                    ),
                                )
                            ); ?>
                        </div>
                        <div class="btn-text"><?php esc_html_e("Sign in with Microsoft", "enhanced-e-commerce-for-woocommerce-store"); ?></div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>


<!-- Microsoft signin -->
<div class="pp-modal onbrd-popupwrp" id="tvc_microsoft_signin" tabindex="-1" role="dialog">
    <div class="onbrdppmain" role="document">
        <div class="onbrdnpp-cntner acccretppcntnr">
            <div class="onbrdnpp-hdr" style="position: relative; min-height: 36px;">
                <div class="ppclsbtn clsbtntrgr">
                    <?php echo wp_kses(
                        enhancad_get_plugin_image('/admin/images/close-icon.png', '', 'ppclsbtn clsbtntrgr', ''),
                        array(
                            'img' => array(
                                'src' => true,
                                'alt' => true,
                                'class' => true,
                                'style' => true,
                            ),
                        )
                    ); ?>
                </div>
                <button type="button" class="clsbtntrgr" aria-label="Close"
                    style="position: absolute; top: 6px; right: 12px; background: none; border: none; font-size: 24px; line-height: 1; color: #555; cursor: pointer; padding: 0; z-index: 10;"
                    onmouseover="this.style.color='#000'" onmouseout="this.style.color='#555'">&times;</button>
            </div>
            <div class="onbrdpp-body">
                <div class="h6 py-2 px-1" style="background: #d7ffd7;">Please use Chrome browser to configure the plugin if you face any issues during setup.</div>
                <div class="microsoft_signin_sec_left">
                    <?php
                    $woo_currency = get_option('woocommerce_currency');
                    $timezone = get_option('timezone_string');


                    $confirm_url = urlencode(string: "admin.php?page=conversios-google-analytics&subpage=bingsettings");
                    $ms_redirect_uri = TVC_API_CALL_URL_TEMP . '/auth/microsoft/callback';
                    $state = ['confirm_url' => admin_url() . $confirm_url, 'subscription_id' => $subscriptionId, 'ms_redirect_uri' => $ms_redirect_uri];
                    $microsoft_client_id = (isset($customApiObj) && is_object($customApiObj))
                        ? $customApiObj->fetch_oauth_client_id('microsoft')
                        : '';
                    $microsoft_auth_url = '';
                    if ($microsoft_client_id !== '') {
                        $microsoft_auth_url = 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize?client_id=' . rawurlencode($microsoft_client_id) . '&response_type=code&redirect_uri=' . rawurlencode($ms_redirect_uri) . '&response_mode=query&tenant=d6545bb5-03a2-461a-880a-14ce7ce63143&scope=' . rawurlencode('openid email profile offline_access https://ads.microsoft.com/msads.manage User.Read') . '&state=' . rawurlencode(wp_json_encode($state));
                    }


                    ?>
                    <?php if (!isset($tvc_data['microsoft_mail']) || $tvc_data['microsoft_mail'] == "" || $subscriptionId == "") { ?>
                        <?php if ($microsoft_client_id === '') { ?>
                        <p class="text-muted mb-0"><?php esc_html_e('Microsoft sign-in is temporarily unavailable. Please try again later.', 'enhanced-e-commerce-for-woocommerce-store'); ?></p>
                        <?php } else { ?>
                        <div class="microsoft_connect_url microsoft-btn d-flex align-items-center" onclick='window.open("<?php echo esc_js(esc_url($microsoft_auth_url)); ?>","MyWindow","width=800,height=700,left=300, top=150"); return false;'>
                            <?php if (isset($ee_options['microsoft_ads_manager_id']) || isset($_GET['subscription_id'])) { ?>
                                <span>Login with Microsoft</span>
                            <?php } else { ?>
                                <div class="microsoft-icon-wrapper">
                                    <?php echo wp_kses(
                                        enhancad_get_plugin_image('/admin/images/logos/ms-logo.png', '', 'microsoft-icon', ''),
                                        array(
                                            'img' => array(
                                                'src' => true,
                                                'alt' => true,
                                                'class' => true,
                                                'style' => true,
                                            ),
                                        )
                                    ); ?>
                                </div>
                                <div class="btn-text"><?php esc_html_e("Sign in with Microsoft", "enhanced-e-commerce-for-woocommerce-store"); ?></div>
                            <?php } ?>
                        </div>
                        <?php } ?>
                    <?php } else { ?>
                        <?php if ($is_refresh_token_expire == true) { ?>
                            <p class="alert alert-primary"><?php esc_html_e("It seems the token to access your Microsoft accounts is expired. Sign in again to continue.", "enhanced-e-commerce-for-woocommerce-store"); ?></p>
                            <?php if ($microsoft_client_id !== '') { ?>
                            <div class="microsoft_connect_url microsoft-btn d-flex align-items-center" onclick='window.open("<?php echo esc_js(esc_url($microsoft_auth_url)); ?>","MyWindow","width=800,height=700,left=300, top=150"); return false;'>
                                <div class="microsoft-icon-wrapper">
                                    <?php echo wp_kses(
                                        enhancad_get_plugin_image('/admin/images/logos/ms-logo.png', '', 'microsoft-icon', ''),
                                        array(
                                            'img' => array(
                                                'src' => true,
                                                'alt' => true,
                                                'class' => true,
                                                'style' => true,
                                            ),
                                        )
                                    ); ?>
                                </div>
                                <div class="btn-text"><b><?php esc_html_e("Sign in with Microsoft", "enhanced-e-commerce-for-woocommerce-store"); ?></b></div>
                            </div>
                            <?php } else { ?>
                            <p class="text-muted mb-0"><?php esc_html_e('Microsoft re-authorization is temporarily unavailable. Please try again later.', 'enhanced-e-commerce-for-woocommerce-store'); ?></p>
                            <?php } ?>
                        <?php } else { ?>
                            <?php if ($microsoft_client_id !== '') { ?>
                            <div class="microsoft_connect_url microsoft-btn d-flex align-items-center" onclick='window.open("<?php echo esc_js(esc_url($microsoft_auth_url)); ?>","MyWindow","width=800,height=700,left=300, top=150"); return false;'>
                                <div class="microsoft-icon-wrapper">
                                    <?php echo wp_kses(
                                        enhancad_get_plugin_image('/admin/images/logos/ms-logo.png', '', 'microsoft-icon', ''),
                                        array(
                                            'img' => array(
                                                'src' => true,
                                                'alt' => true,
                                                'class' => true,
                                                'style' => true,
                                            ),
                                        )
                                    ); ?>
                                </div>
                                <div class="btn-text"><?php esc_html_e("Reauthorize Microsoft", "enhanced-e-commerce-for-woocommerce-store"); ?></div>
                            </div>
                            <?php } else { ?>
                            <p class="text-muted mb-0"><?php esc_html_e('Microsoft re-authorization is temporarily unavailable. Please try again later.', 'enhanced-e-commerce-for-woocommerce-store'); ?></p>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                    <p class="p-0 pe-2 pt-2"><?php esc_html_e("Make sure you sign in with the Microsoft email account that has all privileges to access  Microsoft Advertising account that you want to configure for your store.", "enhanced-e-commerce-for-woocommerce-store"); ?></p>
                </div>
                <div class="microsoft_signin_sec_right">
                    <h6><?php esc_html_e("Why do I need to sign in with Microsoft?", "enhanced-e-commerce-for-woocommerce-store"); ?></h6>
                    <p><?php esc_html_e("When you sign in with Microsoft, we ask for limited programmatic access to your accounts in order to automate the following features for you:", "enhanced-e-commerce-for-woocommerce-store"); ?></p>
                    <p><strong><?php esc_html_e("1. Microsoft Ads:", "enhanced-e-commerce-for-woocommerce-store"); ?></strong><?php esc_html_e("To automate dynamic remarketing, conversion tracking, enhanced conversion tracking, and to create performance campaigns as required.", "enhanced-e-commerce-for-woocommerce-store"); ?></p>
                    <p><strong><?php esc_html_e("2. Microsoft Merchant Center:", "enhanced-e-commerce-for-woocommerce-store"); ?></strong><?php esc_html_e("To automate product feed submission using the Content API and to set up your Merchant Center account.", "enhanced-e-commerce-for-woocommerce-store"); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    jQuery(function() {
        var tvc_data = "<?php echo esc_js(wp_json_encode($tvc_data)); ?>";
        var tvc_ajax_url = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
        let subscription_id = "<?php echo esc_attr($subscriptionId); ?>";
        let plan_id = "<?php echo (isset($plan_id)) ? esc_attr($plan_id) : ''; ?>";
        let app_id = "<?php echo esc_attr(CONV_APP_ID); ?>";

        let ua_acc_val = jQuery('#ua_acc_val').val();
        let ga4_acc_val = jQuery('#ga4_acc_val').val();
        //let propId = jQuery('#propId').val();
        //let measurementId = jQuery('#measurementId').val();
        let bingAds = jQuery('#bingAds').val();
        let gmc_field = jQuery('#gmc_field').val();
        //console.log("ua_acc_val",ua_acc_val);  
        //console.log("ga4_acc_val",ga4_acc_val);  
        //console.log("bingAds",bingAds);  
        //console.log("gmc_field",gmc_field);  

        //open microsoft signin popup
        jQuery(".tvc_microsoft_signinbtn").on("click", function() {
            jQuery('#tvc_microsoft_signin').addClass('showpopup');
            jQuery('body').addClass('scrlnone');
        });

        jQuery(".clsbtntrgr, .ppblubtn").on("click", function() {
            jQuery(this).closest('.onbrd-popupwrp').removeClass('showpopup');
            jQuery('body').removeClass('scrlnone');
        });

        jQuery('#conv_show_badge_onboardingCheck').change(function() {
            if (jQuery(this).prop("checked")) {
                jQuery("#badge_label_check").addClass("conv_default_cls_enabled");
                jQuery("#badge_label_check").removeClass("conv_default_cls_disabled");
            } else {
                jQuery("#badge_label_check").addClass("conv_default_cls_disabled");
                jQuery("#badge_label_check").removeClass("conv_default_cls_enabled");
            }
        });

    });
</script>