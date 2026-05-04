<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * @since      4.0.2
 * Description: Conversios Onboarding page, It's call while active the plugin
 */
if (class_exists('Conversios_Header') === FALSE) {
	class Conversios_Header extends TVC_Admin_Helper
	{
		// Site Url.
		protected $site_url;

		// Conversios site Url.
		protected $conversios_site_url;

		// Subcription Data.
		protected $subscription_data;

		protected $google_ads_id;
		protected $google_merchant_id;
		// Plan id.
		protected $plan_id = 1;

		/** Contruct for Hook */
		public function __construct()
		{
			$this->site_url = "admin.php?page=";
			$this->conversios_site_url = $this->get_conversios_site_url();
			$this->subscription_data = $this->get_user_subscription_data();
			if (isset($this->subscription_data->plan_id) === TRUE && !in_array($this->subscription_data->plan_id, array("1"))) {
				$this->plan_id = $this->subscription_data->plan_id;
			}
			$ee_options = unserialize(get_option('ee_options'));
			$this->google_ads_id = isset($ee_options['google_ads_id']) ? $ee_options['google_ads_id'] : "";
			$this->google_merchant_id = isset($ee_options['google_merchant_id']) ? $ee_options['google_merchant_id'] : "";
			add_action('add_conversios_header', array($this, 'header_notices'));
			add_action('add_conversios_header', [$this, 'header_menu']);
		} //end __construct()



		/**
		 * header notices section
		 *
		 * @since    4.1.4
		 */
		public function header_notices()
		{
			$is_localhost_error = get_option('conv_localhost_error');

			?>
				<!--- Notification Bar (AJAX) -->
				<div id="convaio-notification-bar" style="display:none; padding:10px; text-align:center; transition: all .3s ease;"></div>
				
				<?php
				if ($is_localhost_error) {
					echo '<div class="alert alert-danger">';
					echo '<p>The localhost domain will not work. Please use a live domain to continue using this feature.</p>';
					echo '</div>';
				}
				?>


				<?php
				//echo esc_attr($this->call_tvc_site_verified_and_domain_claim());
			}

			/* add active tab class */
			protected function is_active_menu($page = "")
			{
				if ($page !== "" && isset($_GET['page']) === TRUE && sanitize_text_field(wp_unslash($_GET['page'])) === $page) {
					return "dark";
				}

				return "secondary";
			}
			public function conversios_menu_list()
			{
				$conversios_menu_arr  = array();
				if (is_plugin_active_for_network('woocommerce/woocommerce.php') || in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
					if (!function_exists('is_plugin_active_for_network')) {
						require_once(ABSPATH . '/wp-admin/includes/woocommerce.php');
					}
					if (CONV_APP_ID == 1) {
						$conversios_menu_arr  = array(
							"conversios-analytics-reports" => array(
								"page" => "conversios-analytics-reports",
								"title" => "Analytics Report"
							),
							"conversios-google-analytics" => array(
								"page" => "conversios-google-analytics",
								"title" => "Pixels & Analytics"
							),
							"conversios-google-shopping-feed" => array(
								"page" => "conversios-google-shopping-feed&subpage=gmc",
								"title" => "Product Feed",
							),
							"conversios-purchase-tracking" => array(
								"page" => "conversios-purchase-tracking",
								"title" => "Order Recovery Engine"
							)
						);
					} else {
						$conversios_menu_arr  = array(
							"conversios" => array(
								"page" => "conversios",
								"title" => "Dashboard"
							),
							"conversios-google-shopping-feed" => array(
								"page" => "conversios-google-shopping-feed&subpage=gmc",
								"title" => "Product Feed"
							),
							"conversios-purchase-tracking" => array(
								"page" => "conversios-purchase-tracking",
								"title" => "Order Recovery Engine"
							)
						);
					}
				} else {
					$conversios_menu_arr  = array(
						"conversios" => array(
							"page" => "conversios",
							"title" => "Dashboard"
						),
						"conversios-analytics-reports" => array(
							"page" => "conversios-analytics-reports",
							"title" => "Analytics Report"
						),
						"conversios-google-analytics" => array(
							"page" => "conversios-google-analytics",
							"title" => "Pixels & Analytics"
						)
					);
				}


				return apply_filters('conversios_menu_list', $conversios_menu_arr, $conversios_menu_arr);
			}
			/**
			 * header menu section
			 *
			 * @since    4.1.4
			 */
			public function header_menu()
			{
				$menu_list = $this->conversios_menu_list();
				if (!empty($menu_list)) {
				?>
					<style>
					/* Premium Header Styles */
					#conversioshead {
						background: #ffffff !important;
						box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
						border-bottom: 1px solid #e5e7eb !important;
						z-index: 100;
						position: relative;
					}
					#conversioshead .navbar {
						padding-top: 8px !important;
						padding-bottom: 8px !important;
					}
					#conversioshead .nav-link {
						color: #4b5563 !important;
						transition: all 0.2s ease-in-out;
						padding: 6px 12px !important;
						margin: 0 4px;
						border-radius: 6px;
						border: none !important;
						box-shadow: none !important;
						text-decoration: none !important;
					}
					#conversioshead .nav-link:hover {
						color: #0369a1 !important;
						background-color: transparent !important;
						border: none !important;
						box-shadow: none !important;
						text-decoration: none !important;
						outline: none !important;
					}
					#conversioshead .nav-link.text-rich-blue {
						color: #0284c7 !important;
						font-weight: 600;
						background-color: #e0f2fe;
					}
					#conversioshead .badge-new {
						background: #ecfdf5;
						color: #059669;
						border: 1px solid #10b981;
						font-size: 9px;
						font-weight: 700;
						text-transform: uppercase;
						letter-spacing: 0.5px;
						padding: 1px 5px;
						border-radius: 4px;
						position: absolute;
						top: -4px;
						right: -12px;
						box-shadow: none;
					}
					#conversioshead .action-pill {
						color: #4b5563;
						background-color: #f3f4f6;
						transition: all 0.2s ease;
						padding: 4px 12px;
						border-radius: 20px;
						display: flex;
						align-items: center;
						gap: 6px;
						text-decoration: none;
						border: 1px solid transparent;
					}
					#conversioshead .action-pill label {
						cursor: pointer;
						margin: 0;
						font-weight: 500;
						font-size: 13px;
					}
					#conversioshead .action-pill:hover {
						background-color: #e5e7eb;
						color: #111827;
						border-color: #d1d5db;
					#conversioshead .action-pill.icon-only {
						padding: 0;
						width: 32px;
						height: 32px;
						justify-content: center;
						border-radius: 50%;
					}
					#conversioshead .action-pill.dropdown-toggle::after {
						display: none;
					}
					.conv-plan-pill {
						background-color: #fefce8;
						color: #b45309;
						border: 1px solid #fde047;
						transition: all 0.2s ease;
					}
					.conv-plan-pill:hover {
						background-color: #fef08a;
						color: #92400e;
					}
					</style>
					<header id="conversioshead">
						<div class="container-fluid col-12 p-0">
							<nav class="navbar navbar-expand-lg navbar-light ps-4 pe-4">
								<div class="container-fluid py-0 px-0">
									<a class="navbar-brand link-dark fs-16 fw-400">
										<?php echo wp_kses(
											enhancad_get_plugin_image('/admin/images/logo.png', '', '', 'width: 140px; margin-right: 15px;'),
											array(
												'img' => array(
													'src' => true,
													'alt' => true,
													'class' => true,
													'style' => true,
												),
											)
										); ?>
									</a>
									<div class="collapse navbar-collapse" id="navbarSupportedContent">
										<ul class="navbar-nav me-auto mb-lg-0 align-items-center">
											<?php
											foreach ($menu_list as $key => $value) {
												$value['title'] = str_replace(array(" & Insights", " Management"), " ", $value['title']);
												if (isset($value['title']) && $value['title']) {
													$is_active = $this->is_active_menu($key);
													$active = $is_active != 'secondary' ? 'rich-blue' : '';
													$menu_url = "#";
													if (isset($value['page']) && $value['page'] != "#") {
														$menu_url = $this->site_url . $value['page'];
													}

													$openinnew = false;
													if ($key == "conversios-pricings") {
														$menu_url = "https://www.conversios.io/pricing/?utm_source=woo_aiofree_plugin&utm_medium=adminmenu&utm_campaign=freetopro";
														$openinnew = true;
													}
													$is_parent_menu = "";
													if (isset($value['sub_menus']) && !empty($value['sub_menus'])) {
														$is_parent_menu = "dropdown";
													}
											?>
													<li class="nav-item fs-14 fw-400 <?php echo esc_attr($is_parent_menu); ?>">
														<?php if ($is_parent_menu == "") { ?>
															<a class="nav-link text-<?php echo esc_attr($active ? $active : 'secondary'); ?> " style="position:relative;" aria-current="page" href="<?php echo esc_url($menu_url); ?>" <?php if ( $openinnew ) { echo 'target="_blank"'; } ?>>
																<?php echo esc_attr($value['title']); ?>
																<?php if ($key == "conversios-purchase-tracking") { ?>
																	<span class="badge-new"><?php esc_html_e( 'New', 'enhanced-e-commerce-for-woocommerce-store' ); ?></span>
																<?php } ?>
															</a>
														<?php } else { ?>
															<a class="nav-link dropdown-toggle text-<?php echo esc_attr($active ? $active : 'secondary'); ?> " id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
																<?php echo esc_attr($value['title']); ?>
															</a>
															<ul class="dropdown-menu fs-13 fw-400 shadow-sm border-0 mt-2" aria-labelledby="navbarDropdown" style="border-radius:8px;">
																<?php
																foreach ($value['sub_menus'] as $sub_key => $sub_value) {
																	$sub_menu_url = $this->site_url . $sub_value['page'];
																?>
																	<li>
																		<a class="dropdown-item py-2" href="<?php echo esc_url($sub_menu_url); ?>">
																			<?php echo esc_attr($sub_value['title']); ?>
																		</a>
																	</li>
																<?php } ?>
															</ul>
														<?php } ?>
													</li>
											<?php
												}
											} ?>

											<li class="nav-item fs-14 fw-400 ms-2 position-relative">
												<a class="nav-link text-secondary" style="position:relative;" aria-current="page" href="https://www.conversios.io/website-tracking-checker-tool/?utm_source=woo_aiofree_plugin&amp;utm_medium=topmenu&amp;utm_campaign=trackingcheckedr" target="_blank">
													<span><?php esc_html_e( 'Tracking Checker Tool', 'enhanced-e-commerce-for-woocommerce-store' ); ?></span>
													<span class="badge-new"><?php esc_html_e( 'New', 'enhanced-e-commerce-for-woocommerce-store' ); ?></span>
												</a>
											</li>
										</ul>
										<div class="d-flex align-items-center gap-2">

											<a target="_blank" class="fs-12 fw-400 px-3 py-1 fw-bold btn-newgreen text-white rounded-pill text-center me-2" href="<?php echo esc_url('https://www.conversios.io/pricing/?utm_source=woo_aiofree_plugin&utm_medium=topbarlink&utm_campaign=upgrade&plugin_name=aio'); ?>">
												<?php esc_html_e("Get Premium", "enhanced-e-commerce-for-woocommerce-store"); ?>
											</a>
											<div class="dropdown">
												<a href="#" class="action-pill icon-only dropdown-toggle" id="helpDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="<?php esc_attr_e("Help & Support", "enhanced-e-commerce-for-woocommerce-store"); ?>" style="border:none;">
													<span class="material-symbols-outlined" style="font-size: 18px;">help</span>
												</a>
												<ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" aria-labelledby="helpDropdown" style="border-radius:8px;">
													<li>
														<a class="dropdown-item fs-13 d-flex align-items-center gap-2 py-2" target="_blank" href="<?php echo esc_url('https://conversios.freshdesk.com/support/tickets/new'); ?>">
															<span class="material-symbols-outlined" style="font-size: 16px;">sms</span>
															<?php esc_html_e("Connect to support", "enhanced-e-commerce-for-woocommerce-store"); ?>
														</a>
													</li>
													<li>
														<a class="dropdown-item fs-13 d-flex align-items-center gap-2 py-2" target="_blank" href="<?php echo esc_url('https://www.conversios.io/docs-category/aio-free/?utm_source=woo_aiofree_plugin&utm_medium=top_menu&utm_campaign=help_center'); ?>">
															<span class="material-symbols-outlined" style="font-size: 16px;">library_books</span>
															<?php esc_html_e("Check documents", "enhanced-e-commerce-for-woocommerce-store"); ?>
														</a>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</nav>
						</div>
					</header>
                    <?php
                    // Display Global Tracking Loss Notice
                    $show_fomo_banner = false;
                    $current_page = isset($_GET['page']) ? sanitize_text_field(wp_unslash($_GET['page'])) : '';
                    $current_wizard = isset($_GET['wizard']) ? sanitize_text_field(wp_unslash($_GET['wizard'])) : '';
                    
                    // Show only on pixel & tracking related screens
                    if (
                        $current_page === 'conversios-google-analytics' || 
                        $current_page === 'conversios-analytics-reports' || 
                        $current_wizard === 'pixelandanalytics' ||
                        $current_wizard === 'campaignManagement'
                    ) {
                        $show_fomo_banner = true;
                    }

                    if ($show_fomo_banner) :
                        $missed_orders_count = 0;
                        $tracked_orders_count = 0;
                        if (class_exists('WooCommerce')) {
                            $install_date = get_option('conversiosaiofree_install_date');
                            $start_date = strtotime('-30 days');
                            
                            if ($install_date) {
                                $install_timestamp = strtotime($install_date); // Keep original timestamp
                                if ($install_timestamp > $start_date) {
                                    $start_date = $install_timestamp;
                                }
                            }
                            
                            $date_query_string = '>=' . $start_date;

                            $args_total = [
                                'type'          => 'shop_order',
                                'status'        => ['processing', 'completed'],
                                'date_created'  => $date_query_string,
                                'limit'         => -1,
                                'return'        => 'ids'
                            ];
                            $total_ids = wc_get_orders($args_total);
                            $total_orders_count = count($total_ids);

                            $args_untracked = [
                                'type'          => 'shop_order',
                                'status'        => ['processing', 'completed'],
                                'date_created'  => $date_query_string,
                                'limit'         => -1,
                                'return'        => 'ids',
                                'meta_query'    => [
                                    [
                                        'key'     => '_tracked',
                                        'compare' => 'NOT EXISTS'
                                    ]
                                ]
                            ];
                            $untracked_ids = wc_get_orders($args_untracked);
                            $missed_orders_count = count($untracked_ids);
                            
                            $tracked_orders_count = max(0, $total_orders_count - $missed_orders_count);
                        }
                        if ($missed_orders_count > 0) :
                    ?>
                    <div style="padding: 10px 24px; background: #fefce8; border-bottom: 1px solid #fde047; display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; gap: 12px; align-items: center;">
                            <span class="dashicons dashicons-chart-area" style="color: #ca8a04; font-size: 18px; width: 18px; height: 18px;"></span>
                            <div style="color: #545454; font-size: 14px; line-height: 1.4;">
                                You tracked <strong style="color: #000;"><?php echo esc_html($tracked_orders_count); ?> orders</strong>, but lost <strong style="color: #000;"><?php echo esc_html($missed_orders_count); ?></strong> due to ad-blockers, iOS, and strict browser privacy.<br>Recover these <strong style="color: #000;"><?php echo esc_html($missed_orders_count); ?> sales</strong> so you know exactly what's working.
                            </div>
                        </div>
                        <div style="display: flex; gap: 16px; align-items: center;">
                            <a href="<?php echo esc_url(admin_url('admin.php?page=conversios-purchase-tracking')); ?>" style="color: #a16207; font-size: 14px; font-weight: 600; text-decoration: underline;">Preview Potential Data</a>
                            <a href="<?php echo esc_url('https://www.conversios.io/pricing/?utm_source=woo_aiofree_plugin&utm_medium=oretopbanner&utm_campaign=upgrade&plugin_name=aio'); ?>" target="_blank" class="button button-small" style="background: #eab308; border-color: #ca8a04; color: #fff; font-size: 14px; font-weight: 600; text-shadow: none; box-shadow: 0 1px 2px rgba(202, 138, 4, 0.2);">Enable Server-Side Tracking &rarr;</a>
                        </div>
                    </div>
                    <?php 
                        endif; // closes if ($missed_orders_count > 0) 
                    endif; // closes if ($show_fomo_banner)
                    ?>
					<div id="loadingbar_blue_header" class="progress-materializecss d-none ps-2 pe-2" style="width:100%">
						<div class="indeterminate"></div>
					</div>

	<?php
				}
			}
		}
	}
	new Conversios_Header();
