<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

$upgrade_link = 'https://www.conversios.io/woocommerce-plan-pricing/?utm_source=woo_aiofree_plugin&utm_medium=gads_card&utm_campaign=pixel_setting';
?>

<!-- Google Merchant Center Card (only if WooCommerce is active) -->
<?php if (class_exists('WooCommerce')) :
    $ee_options_gmc = maybe_unserialize(get_option('ee_options'));
    $has_gmc = (!empty($ee_options_gmc['google_merchant_center_id']));
    $gmc_link = admin_url('admin.php?page=conversios-google-shopping-feed&subpage=gmc');
?>
<div class="conv-card p-0 mt-4 conv-rounded conv-shadow-sm" style="overflow: hidden;">
    <!-- Header -->
    <div class="d-flex align-items-center p-4 pb-0">
        <?php echo wp_kses(
            enhancad_get_plugin_image('/admin/images/logos/conv_gmc_logo.png', '', 'align-self-center conv-channel-logo'),
            array(
                'img' => array(
                    'src' => true,
                    'alt' => true,
                    'class' => true,
                    'style' => true,
                ),
            )
        ); ?>
        <h4 class="conv-card-title ms-2 mb-0">Google Merchant Center</h4>
    </div>
    <hr class="conv-header-hr">

    <div class="p-4 pt-0">
        <div class="p-3" style="background: linear-gradient(135deg, #e8f0fe 0%, #d4e4fc 100%); border-radius: 8px;">
            <p style="font-size: 13px; color: #5f6368; line-height: 1.6; margin-bottom: 16px;">
                Directly send your WooCommerce products to Google Merchant Center and leverage Google Free Listings and Shopping Feeds to showcase your products across Google Search, Shopping, and Images.
            </p>
            <a target="_blank" href="<?php echo esc_url($gmc_link); ?>" class="btn conv-btn-primary">
                <?php if ($has_gmc) : ?>
                    Manage your Product Feed
                <?php else : ?>
                    Connect your site to Google Merchant Center
                <?php endif; ?>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-left:5px; vertical-align:middle;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Google Ads Pro Upgrade Card -->
<div class="conv-card conv-pro-upgrade-card p-0 mt-4 conv-rounded conv-shadow-sm" style="overflow: hidden;">
    <!-- Header with PRO badge -->
    <div class="d-flex align-items-center p-4 pb-0">
        <?php echo wp_kses(
            enhancad_get_plugin_image('/admin/images/logos/conv_gads_logo.png', '', 'align-self-center conv-channel-logo'),
            array(
                'img' => array(
                    'src' => true,
                    'alt' => true,
                    'class' => true,
                    'style' => true,
                ),
            )
        ); ?>
        <h4 class="conv-card-title ms-2 mb-0">Google Ads Remarketing & Conversion Tracking</h4>
    </div>
    <hr class="conv-header-hr">

    <div class="p-4 pt-0">
        <div class="row">
            <!-- Left: Conversion Tracking -->
            <div class="col-6">
                <h5 class="mb-2" style="font-size: 14px; font-weight: 700; color: #202124;">Conversion Tracking</h5>
                <div class="conv-pro-feature-list">
                    <div class="conv-pro-feature-item">
                        <svg class="conv-pro-check" viewBox="0 0 24 24"><circle cx="12" cy="12" r="12" fill="#e6f7ee"/><path d="M7 12.5l3 3 7-7" stroke="#2ec471" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <div>
                            <h6 class="conv-pro-feature-title">Purchase</h6>
                            <p class="conv-pro-feature-desc">Track purchase conversions from your Google Ads campaigns.</p>
                        </div>
                    </div>
                    <div class="conv-pro-feature-item">
                        <svg class="conv-pro-check" viewBox="0 0 24 24"><circle cx="12" cy="12" r="12" fill="#e6f7ee"/><path d="M7 12.5l3 3 7-7" stroke="#2ec471" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <div>
                            <h6 class="conv-pro-feature-title">Add to Cart</h6>
                            <p class="conv-pro-feature-desc">Optimize campaigns using micro-conversion signals.</p>
                        </div>
                    </div>
                    <div class="conv-pro-feature-item">
                        <svg class="conv-pro-check" viewBox="0 0 24 24"><circle cx="12" cy="12" r="12" fill="#e6f7ee"/><path d="M7 12.5l3 3 7-7" stroke="#2ec471" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <div>
                            <h6 class="conv-pro-feature-title">Begin Checkout</h6>
                            <p class="conv-pro-feature-desc">Identify and retarget users who drop off at checkout.</p>
                        </div>
                    </div>
                    <div class="conv-pro-feature-item">
                        <svg class="conv-pro-check" viewBox="0 0 24 24"><circle cx="12" cy="12" r="12" fill="#e6f7ee"/><path d="M7 12.5l3 3 7-7" stroke="#2ec471" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <div>
                            <h6 class="conv-pro-feature-title">Form Lead Submit</h6>
                            <p class="conv-pro-feature-desc">Capture lead form submissions as ad conversions.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Audience Building -->
            <div class="col-6">
                <h5 class="mb-2" style="font-size: 14px; font-weight: 700; color: #202124;">Audience Building</h5>
                <div class="conv-pro-feature-list">
                    <div class="conv-pro-feature-item">
                        <svg class="conv-pro-check" viewBox="0 0 24 24"><circle cx="12" cy="12" r="12" fill="#e6f7ee"/><path d="M7 12.5l3 3 7-7" stroke="#2ec471" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <div>
                            <h6 class="conv-pro-feature-title">Remarketing Tags</h6>
                            <p class="conv-pro-feature-desc">Build audience lists to re-engage past visitors.</p>
                        </div>
                    </div>
                    <div class="conv-pro-feature-item">
                        <svg class="conv-pro-check" viewBox="0 0 24 24"><circle cx="12" cy="12" r="12" fill="#e6f7ee"/><path d="M7 12.5l3 3 7-7" stroke="#2ec471" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <div>
                            <h6 class="conv-pro-feature-title">Dynamic Remarketing</h6>
                            <p class="conv-pro-feature-desc">Show personalized product ads to past visitors.</p>
                        </div>
                    </div>
                    <div class="conv-pro-feature-item">
                        <svg class="conv-pro-check" viewBox="0 0 24 24"><circle cx="12" cy="12" r="12" fill="#e6f7ee"/><path d="M7 12.5l3 3 7-7" stroke="#2ec471" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <div>
                            <h6 class="conv-pro-feature-title">Link GA4 with Google Ads</h6>
                            <p class="conv-pro-feature-desc">Import audiences and conversions for smarter bidding.</p>
                        </div>
                    </div>
                    <div class="conv-pro-feature-item">
                        <svg class="conv-pro-check" viewBox="0 0 24 24"><circle cx="12" cy="12" r="12" fill="#e6f7ee"/><path d="M7 12.5l3 3 7-7" stroke="#2ec471" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <div>
                            <h6 class="conv-pro-feature-title">Link Ads with Merchant Center</h6>
                            <p class="conv-pro-feature-desc">Run Shopping and Performance Max campaigns.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="p-3 mt-3" style="background: linear-gradient(135deg, #e8f0fe 0%, #d4e4fc 100%); border-radius: 8px;">
            <p class="mb-2" style="color: #5f6368; font-size: 12px; margin: 0;">
                Get the benefit of Google Ads conversion tracking, remarketing audiences, and smarter campaign optimization with Conversios Pro.
            </p>
            <a href="<?php echo esc_url($upgrade_link); ?>" target="_blank" class="conv-pro-upgrade-btn">
                Upgrade to Pro
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:14px; height:14px; margin-left:5px; vertical-align:middle;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
        </div>
    </div>
</div>
