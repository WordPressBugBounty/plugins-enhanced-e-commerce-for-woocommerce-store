<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly
?>

<script>
    function cb(start, end) {
        jQuery('span.daterangearea').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
    }
</script>

<!-- Hide WP admin footer on this locked report sub-page -->
<style>#wpfooter { display: none !important; }</style>

<!-- Upgrade Banner -->
<div style="
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    background: #e8f0fe;
    border-radius: 12px;
    padding: 20px 28px;
    margin-bottom: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.18);
">
    <!-- Left: Icon + Text -->
    <div style="display:flex; align-items:center; gap:16px;">
        <div style="
            width: 48px; height: 48px; flex-shrink: 0;
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(245,158,11,0.40);
        ">
            <span class="material-symbols-outlined" style="font-size:26px; color:#1e293b;">lock</span>
        </div>
        <div>
            <div style="font-size:16px; font-weight:700; color:#1e293b; margin-bottom:4px; line-height:1.3;">
                <?php esc_html_e('GA4 Ecommerce Reports — Available in Paid Plan', 'enhanced-e-commerce-for-woocommerce-store'); ?>
            </div>
            <div style="font-size:13px; color:#5f6368; line-height:1.5;">
                <?php esc_html_e('Unlock Revenue tracking, Top Products, Checkout Funnels, AOV and more.', 'enhanced-e-commerce-for-woocommerce-store'); ?>
            </div>
        </div>
    </div>

    <!-- Right: CTA -->
    <a href="https://www.conversios.io/woocommerce-plan-pricing/?plugin_name=aio&utm_source=woo_aiofree_plugin&utm_medium=ecom_report_banner&utm_campaign=upgrade"
       target="_blank"
        style="
            display: flex; align-items: center; align-self: center; gap: 7px;
            background: #f59e0b; color: #1e293b;
            font-weight: 700; font-size: 14px;
            padding: 11px 24px; border-radius: 9px;
            text-decoration: none; white-space: nowrap;
            box-shadow: 0 4px 14px rgba(245,158,11,0.45);
            flex-shrink: 0;
        "
       onmouseover="this.style.background='#d97706'; this.style.transform='translateY(-1px)'"
       onmouseout="this.style.background='#f59e0b'; this.style.transform='translateY(0)'"
    >
        <span class="material-symbols-outlined" style="font-size:17px; vertical-align:middle; line-height:1;">rocket_launch</span>
        <?php esc_html_e('Upgrade Now', 'enhanced-e-commerce-for-woocommerce-store'); ?>
    </a>
</div>

<!-- Full quality screenshot — not full-width, centered -->
<div style="max-width: 900px; margin: 0 auto;">
    <div style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 16px rgba(0,0,0,0.12);">
        <?php echo wp_kses(
            enhancad_get_plugin_image('/admin/images/web-reports-gecom.webp', '', '', 'max-width:100%; height:auto; display:block;'),
            array(
                'img' => array(
                    'src'   => true,
                    'alt'   => true,
                    'class' => true,
                    'style' => true,
                ),
            )
        ); ?>
    </div>
</div>