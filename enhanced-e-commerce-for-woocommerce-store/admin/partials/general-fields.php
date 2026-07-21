<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Enqueue style for premium, independent tabbed dashboard
wp_enqueue_style('conv-pixel-dashboard-css', ENHANCAD_PLUGIN_URL . '/admin/css/conv-pixel-dashboard.css', array(), PLUGIN_TVC_VERSION);

// Instantiate Helper Objects & Variables (Merging single-pixel-settings.php setups)
$TVC_Admin_Helper = new TVC_Admin_Helper();
$customApiObj = new CustomApi();
$app_id = CONV_APP_ID;
$version = PLUGIN_TVC_VERSION;

$ee_options = $TVC_Admin_Helper->get_ee_options_settings();

$ee_additional_data = $TVC_Admin_Helper->get_ee_additional_data();
if (!is_array($ee_additional_data)) {
    $ee_additional_data = array();
}
$get_ee_options_data = $TVC_Admin_Helper->get_ee_options_data();
$tvc_data = $TVC_Admin_Helper->get_store_data();
$subscriptionId = $ee_options['subscription_id'] ?? '';

// Check if redirected from OAuth authorization and update tokens/emails
if (isset($_GET['subscription_id']) && sanitize_text_field(wp_unslash($_GET['subscription_id']))) {
    $subscriptionId = sanitize_text_field(wp_unslash($_GET['subscription_id']));
    
    if (isset($_GET['g_mail']) && sanitize_email(wp_unslash($_GET['g_mail']))) {
        $tvc_data['g_mail'] = sanitize_email(wp_unslash($_GET['g_mail']));
        $ee_additional_data['ee_last_login'] = sanitize_text_field(current_time('timestamp'));
        $TVC_Admin_Helper->set_ee_additional_data($ee_additional_data);
    }
    
    if (isset($_GET['microsoft_mail']) && sanitize_email(wp_unslash($_GET['microsoft_mail']))) {
        $tvc_data['microsoft_mail'] = sanitize_email(wp_unslash($_GET['microsoft_mail']));
        $ee_additional_data['ee_last_login'] = sanitize_text_field(current_time('timestamp'));
        $TVC_Admin_Helper->set_ee_additional_data($ee_additional_data);
    }
}

// Google & Microsoft Emails Setup
$tvc_data['g_mail'] = sanitize_email(get_option('ee_customer_gmail') ?: ($tvc_data['g_mail'] ?? ''));
$tvc_data['microsoft_mail'] = sanitize_email(get_option('ee_customer_msmail') ?: ($tvc_data['microsoft_mail'] ?? ''));

// Fetch google details from option
$googleDetail = "";
$tracking_option = "UA";
$login_customer_id = "";
$plan_id = 1;

if (!empty($subscriptionId)) {
    $google_detail_option = unserialize(get_option("ee_api_data"));
    if (isset($google_detail_option['setting']) && $google_detail_option['setting'] != "") {
        $googleDetail = $google_detail_option['setting'];
        $tvc_data['subscription_id'] = $googleDetail->id;
        $plan_id = $googleDetail->plan_id;
        $login_customer_id = $googleDetail->customer_id;
        $tracking_option = $googleDetail->tracking_option;
    }
}

// Active Pixels Configuration Data
$data = unserialize(get_option('ee_options'));
$conv_selected_events = unserialize(get_option('conv_selected_events'));
$TVC_Admin_Helper->add_spinner_html();
$conv_pro_url = "admin.php?page=conversios-pricings";

// Define 11 tabs details for right-hand panels (Flat, brand-based format)
$pixel_settings_arr = array(
    "gasettings" => array(
        "logo" => "/admin/images/logos/conv_galpha_logo.png",
        "title" => "Google Suite",
    ),
    "fbsettings" => array(
        "logo" => "/admin/images/logos/conv_meta_logo.png",
        "title" => "Facebook Meta",
        "topnoti" => "Enable Meta Pixel for higher accuracy and better campaign performance."
    ),
    "bingsettings" => array(
        "logo" => "/admin/images/logos/conv_bing_logo.png",
        "title" => "Microsoft Ads",
    ),
    "tiktoksettings" => array(
        "logo" => "/admin/images/logos/conv_tiktok_logo.png",
        "title" => "TikTok",
    ),
    "snapchatsettings" => array(
        "logo" => "/admin/images/logos/conv_snap_logo.png",
        "title" => "Snapchat",
    ),
    "pintrestsettings" => array(
        "logo" => "/admin/images/logos/conv_pint_logo.png",
        "title" => "Pinterest",
    ),
    "twittersettings" => array(
        "logo" => "/admin/images/logos/conv_twitter_logo.png",
        "title" => "Twitter / X",
    ),
    "linkedinsettings" => array(
        "logo" => "/admin/images/logos/conv_linkedin_logo.png",
        "title" => "LinkedIn Insight",
    ),
    "bingclaritysettings" => array(
        "logo" => "/admin/images/logos/conv_clarity_logo.png",
        "title" => "Microsoft Clarity",
    ),
    "hotjarsettings" => array(
        "logo" => "/admin/images/logos/conv_hotjar_logo.png",
        "title" => "Hotjar",
    ),
    "crazyeggsettings" => array(
        "logo" => "/admin/images/logos/conv_crazyegg_logo.png",
        "title" => "Crazy Egg",
    )
);

// Connection Status Dots Calculations
$connection_status = array(
    'gasettings'        => !empty($googleDetail->measurement_id) || !empty($data['gm_id']) || !empty($data['gads_remarketing_id']),
    'fbsettings'        => !empty($data['fb_pixel_id']),
    'bingsettings'      => !empty($data['microsoft_ads_pixel_id']),
    'tiktoksettings'    => !empty($data['tiKtok_ads_pixel_id']),
    'snapchatsettings'  => !empty($data['snapchat_ads_pixel_id']),
    'pintrestsettings'  => !empty($data['pinterest_ads_pixel_id']),
    'twittersettings'   => !empty($data['twitter_ads_pixel_id']),
    'linkedinsettings'  => !empty($data['linkedin_insight_id']),
    'bingclaritysettings' => !empty($data['msclarity_pixel_id']),
    'hotjarsettings'    => !empty($data['hotjar_pixel_id']),
    'crazyeggsettings'  => !empty($data['crazyegg_pixel_id']),
);

$active_count = 0;
foreach ($connection_status as $key => $status) {
    if ($status) {
        $active_count++;
    }
}
?>

<div class="conv-settings-page d-flex mt-4">
    <!-- LEFT SIDEBAR (Flat Brand-Logo List Layout, No Accordions) -->
    <div class="conv-settings-sidebar">
        <div class="conv-settings-sidebar__brand p-4 conv-border-bottom d-flex align-items-center">
            <?php echo wp_kses(
                enhancad_get_plugin_image('/admin/images/logos/popup_mapping_logo.png', '', 'me-2'),
                array('img' => array('src' => true, 'alt' => true, 'class' => true, 'style' => true))
            ); ?>
            <div>
                <h4 class="m-0 conv-fw-bold conv-text-dark conv-fs-5">Conversios</h4>
                <small class="conv-text-muted">Onboarding & Pixels</small>
            </div>
        </div>

        <nav class="conv-settings-sidebar__nav flex-grow-1 conv-p-3">
            <div class="conv-settings-sidebar__brand-list">
                <?php foreach ($pixel_settings_arr as $tab_key => $tab_info) : ?>
                    <?php
                    $is_connected = $connection_status[$tab_key] ?? false;
                    ?>
                    <div class="conv-settings-sidebar__item d-flex align-items-center conv-py-2-5 px-3 mb-2 conv-rounded" data-tab="<?php echo esc_attr($tab_key); ?>">
                        <img class="conv-settings-sidebar__item-logo conv-me-3" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . $tab_info['logo']); ?>" style="width: 20px; height: 20px; object-fit: contain;" />
                        <span class="conv-settings-sidebar__item-name flex-grow-1 conv-text-dark">
                            <?php echo esc_html($tab_key === 'gasettings' ? 'Google Suite' : ($tab_key === 'fbsettings' ? 'Facebook Meta' : $tab_info['title'])); ?>
                        </span>
                        <!-- Dynamic status dot -->
                        <span class="conv-settings-sidebar__dot <?php echo $is_connected ? 'conv-settings-sidebar__dot--green' : 'conv-settings-sidebar__dot--grey'; ?>"></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="conv-settings-sidebar__divider my-3"></div>

        </nav>

    </div>

    <!-- RIGHT CONTENT PANEL -->
    <div class="conv-settings-content flex-grow-1 conv-bg-light p-4">
        
        <!-- Scaved alert bar for unsaved changes (Custom Spacing) -->
        <div class="conv-unsaved-alert alert d-none align-items-center mb-3 conv-shadow-sm py-2 px-3" role="alert">
            <svg class="conv-icon text-danger me-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px;"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
            <span class="flex-grow-1 conv-text-dark conv-fs-14">You have unsaved changes in this tab. Please save before leaving!</span>
        </div>
        
        <!-- Content Panel Header (Independent of Bootstrap row/borders) -->
        <div class="conv-settings-content__header d-flex align-items-center justify-content-between conv-pb-3 mb-4">
            <div class="d-flex align-items-center">
                <div class="d-none conv-settings-content__header-logo conv-p-2 bg-white conv-rounded conv-border d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <img id="active-tab-logo" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . $pixel_settings_arr['gasettings']['logo']); ?>" style="max-height: 100%; max-width: 100%; object-fit: contain;" />
                </div>
                <div class="conv-ms-3">
                    <h3 class="conv-settings-content__title m-0" id="active-tab-title">Google Suite</h3>
                    <p class="conv-settings-content__subtitle m-0 conv-text-muted conv-small mt-1">Configure your analytics tracking settings.</p>
                </div>
            </div>
            
            <button type="button" class="conv-btn conv-btn-primary conv-px-4 py-2 conv-fw-bold-500 conv-shadow-sm d-flex align-items-center global-save-btn" onclick="convSaveActivePanel()">
                <svg class="conv-icon conv-icon--save conv-me-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>Save Configurations
            </button>
        </div>

        <!-- Scoped Loading Bar -->
        <div id="loadingbar_blue" class="progress-materializecss d-none">
            <div class="indeterminate"></div>
        </div>

        <!-- Tab Panels (Included Inline) -->
        <div class="conv-tab-panels-wrapper">
            <?php foreach ($pixel_settings_arr as $tab_key => $tab_data) : ?>
                <div class="conv-tab-panel <?php echo $tab_key === 'gasettings' ? 'conv-tab-panel--active' : 'd-none'; ?>" id="conv-panel-<?php echo esc_attr($tab_key); ?>" data-tab="<?php echo esc_attr($tab_key); ?>">
                    <?php
                    // Map variables context so standard files run smoothly
                    $subpage = $tab_key;
                    if (file_exists(ENHANCAD_PLUGIN_DIR . 'admin/partials/singlepixelsettings/' . $tab_key . '.php')) {
                        require(ENHANCAD_PLUGIN_DIR . 'admin/partials/singlepixelsettings/' . $tab_key . '.php');
                    }
                    
                    // If Google Suite, also include Google Ads display-only UI below GA4 settings
                    if ($tab_key === 'gasettings') {
                        require(ENHANCAD_PLUGIN_DIR . 'admin/partials/singlepixelsettings/gadssettings.php');
                    }
                    ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Custom HTML Success Save Modal (Bootstrap Free overlay dialog) -->
<div class="conv-modal" id="conv_save_success_modal">
    <div class="conv-modal__backdrop" onclick="jQuery('#conv_save_success_modal').removeClass('conv-modal--show')"></div>
    <div class="conv-modal__content">
        <div class="conv-modal__body p-4">
            <div class="success-round d-flex conv-rounded-circle align-items-center justify-content-center text-white conv-shadow-sm">
                <svg class="conv-icon conv-icon--success" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="width: 32px; height: 32px;"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </div>
            <h2 class="conv-modal__title conv-fw-bold conv-text-dark conv-fs-3 mt-3"><?php esc_html_e("Successful!", "enhanced-e-commerce-for-woocommerce-store"); ?></h2>
            <p id="conv_save_success_txt" class="conv-modal__text my-3 conv-text-secondary conv-fs-16 px-3"></p>
        </div>
        <div class="conv-modal__footer p-3 d-flex justify-content-center">
            <button type="button" class="conv-btn conv-btn-secondary conv-px-4 py-2 conv-fs-15 conv-rounded-pill conv-shadow-sm" onclick="jQuery('#conv_save_success_modal').removeClass('conv-modal--show')">Close</button>
        </div>
    </div>
</div>

<script>
// Window-scoped helper variables & trackers
let convTabDirty = {};
let activeTab = 'gasettings';
let bingAccountsLoaded = false; // Guard: load Microsoft Ads accounts only once

// Initialize tabs clean state
<?php foreach ($pixel_settings_arr as $tab_key => $tab_data) : ?>
convTabDirty['<?php echo esc_js($tab_key); ?>'] = false;
<?php endforeach; ?>

// Switch to a new tab
function convSwitchTab(tabKey, force = false) {
    if (!force && convTabDirty[activeTab]) {
        if (!confirm('You have unsaved changes in this tab. Are you sure you want to discard them?')) {
            return;
        }
    }
    
    // Mark old tab as clean if forced / accepted
    convMarkClean(activeTab);
    
    // Hide old active panel, show new active panel
    jQuery('.conv-tab-panel').addClass('d-none').removeClass('conv-tab-panel--active');
    jQuery('#conv-panel-' + tabKey).removeClass('d-none').addClass('conv-tab-panel--active');
    
    // Update active nav class
    jQuery('.conv-settings-sidebar__item').removeClass('conv-settings-sidebar__item--active');
    jQuery('.conv-settings-sidebar__item[data-tab="' + tabKey + '"]').addClass('conv-settings-sidebar__item--active');
    
    // Update active tab title in content header
    let brandName = jQuery('.conv-settings-sidebar__item[data-tab="' + tabKey + '"]').find('.conv-settings-sidebar__item-name').text().trim();
    jQuery('#active-tab-title').text(brandName);
    
    // Update active tab logo in content header
    let logoSrc = jQuery('.conv-settings-sidebar__item[data-tab="' + tabKey + '"]').find('.conv-settings-sidebar__item-logo').attr('src');
    if (logoSrc) {
        jQuery('#active-tab-logo').attr('src', logoSrc);
    }
    
    activeTab = tabKey;
    window.location.hash = tabKey;
    
    // Manage alert visibility
    jQuery('.conv-unsaved-alert').addClass('d-none');

    // Auto-load Microsoft Ads accounts when switching to bingsettings
    // if auth is available but no manager account has been saved yet (only once)
    if (tabKey === 'bingsettings' && !bingAccountsLoaded) {
        <?php if (!empty($tvc_data['microsoft_mail'])) : ?>
        var bingManagerId = jQuery('#microsoft_ads_manager_id').val();
        if (!bingManagerId || bingManagerId === '') {
            if (typeof list_microsoft_ads_account === 'function') {
                bingAccountsLoaded = true;
                list_microsoft_ads_account(tvc_data);
            }
        }
        <?php endif; ?>
    }
}

// Mark a tab as dirty
function convMarkDirty(tabKey) {
    convTabDirty[tabKey] = true;
    jQuery('#conv-panel-' + tabKey + ' form').data('dirty', true);
    jQuery('.conv-unsaved-alert').removeClass('d-none').addClass('d-flex');
    change_top_button_state("enable");
}

// Mark tab clean
function convMarkClean(tabKey) {
    convTabDirty[tabKey] = false;
    jQuery('#conv-panel-' + tabKey + ' form').data('dirty', false);
    jQuery('.conv-unsaved-alert').addClass('d-none');
    change_top_button_state("disable");
}

// Save active panel form
function convSaveActivePanel() {
    let panel = jQuery('#conv-panel-' + activeTab);
    
    if (activeTab === 'gasettings') {
        // Directly call GA4 save (defined in gasettings.php)
        if (typeof convSaveGA4 === 'function') {
            convSaveGA4();
        }
    } else if (activeTab === 'bingsettings') {
        // Call the Bing save function directly (defined in bingsettings.php)
        if (typeof window.convSaveMicrosoftAds === 'function') {
            window.convSaveMicrosoftAds();
        }
    } else if (activeTab === 'tiktoksettings') {
        if (typeof window.convSaveTikTok === 'function') {
            window.convSaveTikTok();
        }
    } else {
        // Simple pixel tabs — directly call AJAX save
        convSaveSimplePixel();
    }
}

// Direct AJAX save for simple pixel tabs (TikTok, FB, Snapchat, Pinterest, Twitter, LinkedIn, Clarity, Hotjar, Crazy Egg)
function convSaveSimplePixel() {
    conv_change_loadingbar("show");
    change_top_button_state("disable");
    let globalSaveBtn = jQuery(".global-save-btn");
    let originalText = globalSaveBtn.text();
    globalSaveBtn.find('span').length ? globalSaveBtn.find('span').text('Saving...') : globalSaveBtn.text('Saving...');

    let selected_vals = {
        subscription_id: "<?php echo esc_js($tvc_data['subscription_id']) ?>"
    };

    jQuery('.conv-tab-panel--active form input, .conv-tab-panel--active form textarea').each(function() {
        let name = jQuery(this).attr("name");
        if (name) {
            selected_vals[name] = jQuery(this).val();
        }
    });

    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo esc_url(admin_url('admin-ajax.php')); ?>",
        data: {
            action: "conv_save_pixel_data",
            pix_sav_nonce: "<?php echo wp_create_nonce('pix_sav_nonce_val'); ?>",
            conv_options_data: selected_vals,
            conv_options_type: ["eeoptions"],
        },
        success: function(response) {
            if (response == "0" || response == "1") {
                convMarkClean(activeTab);
                // Check if any pixel field has a value — if all empty, go gray
                let hasValue = Object.keys(selected_vals).some(function(k) {
                    return k !== 'subscription_id' && selected_vals[k] !== '';
                });
                if (hasValue) {
                    convSetTabConnected(activeTab);
                } else {
                    convSetTabDisconnected(activeTab);
                }
                jQuery("#conv_save_success_txt").html("Your settings have been saved successfully.");
                jQuery("#conv_save_success_modal").addClass("conv-modal--show");
                // Keep Save button disabled after successful save
                conv_change_loadingbar("hide");
                change_top_button_state("disable");
                globalSaveBtn.find('span').length ? globalSaveBtn.find('span').text('Save Configurations') : globalSaveBtn.text('Save Configurations');
            } else {
                conv_change_loadingbar("hide");
                change_top_button_state("enable");
                globalSaveBtn.find('span').length ? globalSaveBtn.find('span').text('Save Configurations') : globalSaveBtn.text('Save Configurations');
            }
        },
        error: function() {
            conv_change_loadingbar("hide");
            change_top_button_state("enable");
            globalSaveBtn.find('span').length ? globalSaveBtn.find('span').text('Save Configurations') : globalSaveBtn.text('Save Configurations');
        }
    });
}

// Turn the sidebar status dot green for a tab after successful save
function convSetTabConnected(tabKey) {
    jQuery('.conv-settings-sidebar__item[data-tab="' + tabKey + '"] .conv-settings-sidebar__dot')
        .removeClass('conv-settings-sidebar__dot--grey')
        .addClass('conv-settings-sidebar__dot--green');
}

// Turn the sidebar status dot gray (disconnected)
function convSetTabDisconnected(tabKey) {
    jQuery('.conv-settings-sidebar__item[data-tab="' + tabKey + '"] .conv-settings-sidebar__dot')
        .removeClass('conv-settings-sidebar__dot--green')
        .addClass('conv-settings-sidebar__dot--grey');
}

// Top button & loading bar implementations
function change_top_button_state(state = "enable") {
    let globalSaveBtn = jQuery(".global-save-btn");
    if (state === "enable") {
        globalSaveBtn.removeClass("disabled").prop('disabled', false);
    } else {
        globalSaveBtn.addClass("disabled").prop('disabled', true);
    }
}

function conv_change_loadingbar(state = 'show') {
    if (state === 'show') {
        jQuery("#loadingbar_blue").removeClass('d-none');
    } else {
        jQuery("#loadingbar_blue").addClass('d-none');
    }
}

function getAlertMessageAll(type = 'Success', title = 'Success', message = '', icon = 'success', buttonText = 'Done!', buttonColor = '#1967D2', iconImageTag = '') {
    Swal.fire({
        title: title,
        icon: icon,
        confirmButtonText: buttonText,
        confirmButtonColor: buttonColor,
        text: message,
    });
}

// On Page Load Handlers
jQuery(document).ready(function() {
    let tvc_ajax_url = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
    let subscription_id = "<?php echo esc_attr($subscriptionId); ?>";
    
    // Reusable select2 dropdowns
    jQuery(".selecttwo").select2({
        minimumResultsForSearch: -1,
        placeholder: function() {
            return jQuery(this).data('placeholder');
        }
    });

    // Tooltips activation
    jQuery('[data-bs-toggle="tooltip"]').tooltip({
        trigger: 'click'
    });

    // Tab init priority: 1) ?subpage= URL param  2) #hash  3) default gasettings
    (function() {
        var validTabs = <?php echo json_encode(array_keys($pixel_settings_arr)); ?>;

        // 1. Check ?subpage= query param first (highest priority — explicit navigation)
        var urlSubpage = new URLSearchParams(window.location.search).get('subpage');
        if (urlSubpage && validTabs.indexOf(urlSubpage) !== -1) {
            convSwitchTab(urlSubpage, true);
            return;
        }

        // 2. Check URL hash (set by in-page tab clicks)
        var hashTab = window.location.hash.substring(1);
        if (hashTab && validTabs.indexOf(hashTab) !== -1) {
            convSwitchTab(hashTab, true);
            return;
        }

        // 3. Default
        convSwitchTab('gasettings', true);
    })();

    // Flat list sidebar items clicking (ignoring locked ones)
    jQuery('.conv-settings-sidebar__item:not(.conv-settings-sidebar__item--locked)').on('click', function() {
        let tabKey = jQuery(this).data('tab');
        convSwitchTab(tabKey);
    });

    // Capture changes inside any of the setting forms
    jQuery(document).on('change input', '.conv-tab-panel form input, .conv-tab-panel form select', function() {
        convMarkDirty(activeTab);
    });

    // Block page exits if dirty
    window.addEventListener('beforeunload', function (e) {
        let isDirty = Object.values(convTabDirty).some(v => v === true);
        if (isDirty) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // No client-side regex validation on pixel inputs — save freely

    // Standard AJAX connection save for simpler pixels
    jQuery(document).on("click", ".conv-btn-connect-enabled", function() {
        conv_change_loadingbar("show");
        let btn = jQuery(this);
        btn.addClass('disabled');
        let valtoshow_inpopup = jQuery("#valtoshow_inpopup").val() + " " + jQuery(".valtoshow_inpopup_this").val();
        let selected_vals = {
            subscription_id: "<?php echo esc_js($tvc_data['subscription_id']) ?>"
        };

        jQuery('.conv-tab-panel--active form input, .conv-tab-panel--active form textarea').each(function() {
            let name = jQuery(this).attr("name");
            if (name) {
                selected_vals[name] = jQuery(this).val();
            }
        });

        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: tvc_ajax_url,
            data: {
                action: "conv_save_pixel_data",
                pix_sav_nonce: "<?php echo wp_create_nonce('pix_sav_nonce_val'); ?>",
                conv_options_data: selected_vals,
                conv_options_type: ["eeoptions"],
            },
            beforeSend: function() {
                btn.text("Saving...");
            },
            success: function(response) {
                if (response == "0" || response == "1") {
                    btn.text("Save");
                    convMarkClean(activeTab);
                    jQuery("#conv_save_success_txt").html("Your settings have been saved successfully.");
                    jQuery("#conv_save_success_modal").addClass("conv-modal--show");
                }
                conv_change_loadingbar("hide");
            }
        });
    });
});
</script>