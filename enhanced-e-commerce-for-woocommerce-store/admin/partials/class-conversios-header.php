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

			add_action('add_conversios_header', [$this, 'before_start_header']);
			add_action('add_conversios_header', [$this, 'header_menu']);
			add_action('add_conversios_header', array($this, 'header_notices'));
		} //end __construct()


		/**
		 * before start header section
		 *
		 * @since    4.1.4
		 * @return void
		 */
		public function before_start_header()
		{
?>
			<div>
			<?php
		}

		/**
		 * header notices section
		 *
		 * @since    4.1.4
		 */
		public function header_notices()
		{
			?>
				<!--- Promotion box start -->
				<div id="conversioshead_notice" class="promobandtop">

					<div class="d-flex justify-content-between fixedcontainer_conversios_notice align-items-center">
						<div class="promoleft">
							<div class="promobandmsg text-white text-center fs-6">
								<span class="fs-3">
									📢
								</span>
								<span class="fs-6 text-dark me-2 px-2" style="background: #ffc700;">
									<?php esc_html_e("Black Friday Offer", "enhanced-e-commerce-for-woocommerce-store"); ?>
								</span>
								<span class="fs-6"><?php esc_html_e("Grab 70% OFF", "enhanced-e-commerce-for-woocommerce-store"); ?></span>
								<?php esc_html_e(" on 'All In One' Plugin", "enhanced-e-commerce-for-woocommerce-store"); ?>
								<a target="_blank" href="https://www.conversios.io/checkout/?pid=wpAIO_PY1&utm_source=freeplugin&utm_medium=headerbanner&utm_campaign=festbanner&coupon=convfest70">
									<span class="fs-6">
										<u><?php esc_html_e("Professional Plan", "enhanced-e-commerce-for-woocommerce-store"); ?></u>
									</span>
								</a>
								<span class="text-white fw-light" style="font-size:14px;">(FB CAPI + Snapchat CAPI + Tiktok CAPI & <a class="text-white" href="https://www.conversios.io/pricing?utm_source=freeplugin&utm_medium=headerbanner&utm_campaign=festbanner&plugin_name=aio" target="_blank"><u>many more features</u></a>)</span>

							</div>
						</div>
					</div>

				</div>
				<!--- Promotion box end -->
				<?php
				echo esc_attr($this->call_tvc_site_verified_and_domain_claim());
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
							"conversios" => array(
								"page" => "conversios",
								"title" => "Dashboard"
							),
							"conversios-analytics-reports" => array(
								"page" => "conversios-analytics-reports",
								"title" => "Reports & Insights"
							),
							"conversios-google-analytics" => array(
								"page" => "conversios-google-analytics",
								"title" => "Pixels & Analytics"
							),
							"conversios-google-shopping-feed" => array(
								"page" => "conversios-google-shopping-feed&tab=feed_list",
								"title" => "Product Feed",
								/*"sub_menus" => array(
									"conversios-google-shopping-feed" => array(
										"page" => "conversios-google-shopping-feed&tab=gaa_config_page",
										"title" => "Channel Configuration"
									),
									"feed-list" => array(
										"page" => "conversios-google-shopping-feed&tab=feed_list",
										"title" => "Feed Management"
									),
								)*/
							),
							"conversios-pmax" => array(
								"page" => "conversios-pmax",
								"title" => "Campaign Management"
							),
							"conversios-pricings" => array(
								"page" => "conversios-pricings",
								"title" => "Free Vs Pro"
							),
						);
					} else {
						$conversios_menu_arr  = array(
							"conversios" => array(
								"page" => "conversios",
								"title" => "Dashboard"
							),
							"conversios-google-shopping-feed" => array(
								"page" => "conversios-google-shopping-feed&tab=feed_list",
								"title" => "Product Feed"
							),
							"conversios-pricings" => array(
								"page" => "conversios-pricings",
								"title" => "Free Vs Pro"
							),
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
							"title" => "Reports & Insights"
						),
						"conversios-google-analytics" => array(
							"page" => "conversios-google-analytics",
							"title" => "Pixels & Analytics"
						),
						"conversios-pricings" => array(
							"page" => "conversios-pricings",
							"title" => "Free Vs Pro"
						),
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
					<header id="conversioshead" class="border-bottom bg-white">
						<div class="container-fluid col-12 p-0">
							<nav class="navbar navbar-expand-lg navbar-light bg-white ps-4 p-0" style="">
								<div class="container-fluid py-0">
									<a class="navbar-brand link-dark fs-16 fw-400">
										<img style="width: 120px;" src="<?php echo esc_url(ENHANCAD_PLUGIN_URL . '/admin/images/logo.png'); ?>" />
									</a>
									<div class="collapse navbar-collapse" id="navbarSupportedContent">
										<ul class="navbar-nav me-auto mb-lg-0">
											<?php
											foreach ($menu_list as $key => $value) {
												$value['title'] = str_replace(array(" & Insights", " & Analytics", " Management"), " ", $value['title']);
												if (isset($value['title']) && $value['title']) {
													$is_active = $this->is_active_menu($key);
													$active = $is_active != 'secondary' ? 'rich-blue' : '';
													$menu_url = "#";
													if (isset($value['page']) && $value['page'] != "#") {
														$menu_url = $this->site_url . $value['page'];
													}
													$is_parent_menu = "";
													$is_parent_menu_link = "";
													if (isset($value['sub_menus']) && !empty($value['sub_menus'])) {
														$is_parent_menu = "dropdown";
													}
											?>
													<li class="nav-item fs-14 mt-1 fw-400 <?php echo esc_attr($active); ?> <?php echo esc_attr($is_parent_menu); ?>">
														<?php if ($is_parent_menu == "") { ?>
															<a class="nav-link text-<?php echo esc_attr($is_active); ?> " aria-current="page" href="<?php echo esc_url($menu_url); ?>">
																<?php echo esc_attr($value['title']); ?>
															</a>
														<?php } else { ?>
															<a class="new-badge nav-link dropdown-toggle text-<?php echo esc_attr($is_active); ?> " id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
																<?php echo esc_attr($value['title']); ?>
															</a>
															<ul class="dropdown-menu fs-12 fw-400" aria-labelledby="navbarDropdown">
																<?php
																foreach ($value['sub_menus'] as $sub_key => $sub_value) {
																	$sub_menu_url = $this->site_url . $sub_value['page'];
																?>
																	<li>
																		<a class="dropdown-item" href="<?php echo esc_url($sub_menu_url); ?>">
																			<?php echo esc_attr($sub_value['title']); ?>
																		</a>
																	</li>
																<?php }
																?>
															</ul>
														<?php } ?>

													</li>
											<?php
												}
											} ?>
										</ul>
										<div class="d-flex align-items-center">
											<?php
											$plan_name = esc_html__("Free Plan", "enhanced-e-commerce-for-woocommerce-store");
											?>
											<a class="d-flex align-items-center flex-wrap text-dark" href="https://wordpress.org/support/plugin/enhanced-e-commerce-for-woocommerce-store/reviews/?rate=5#rate-response" target="_blank">
												<img style="max-width:95px;" src="<?php echo esc_url_raw(ENHANCAD_PLUGIN_URL . '/admin/images/rate-us.png'); ?>" /><span class="me-2 fs-12">Rate Us!</span>
											</a>
											<a href="javascript:void(0)" class="btn btn-warning rounded-pill text-white border-0 fw-bold fs-12 px-2 py-0" data-bs-toggle="modal" data-bs-target="#convLicenceInfoMod">
												<?php echo esc_attr($plan_name) ?>
											</a>
											<a target="_blank" class="ms-2 fs-12 fw-400 px-2 py-0 fw-bold btn-newgreen text-white rounded-pill text-center" href="<?php echo esc_url('https://www.conversios.io/pricing/?utm_source=woo_aiofree_plugin&utm_medium=topbarlink&utm_campaign=upgrade&plugin_name=aio'); ?>">
												<?php esc_html_e("Get Premium", "enhanced-e-commerce-for-woocommerce-store"); ?>
											</a>
											<a target="_blank" title="help center" class="px-2 py-0 text-dark lh-0" href="<?php echo esc_url('https://www.conversios.io/docs-category/woocommerce-2/?utm_source=woo_aiofree_plugin&utm_medium=top_menu&utm_campaign=help_center'); ?>" style="lh-0">
												<!-- <u><?php esc_html_e("Help Center", "enhanced-e-commerce-for-woocommerce-store"); ?></u> -->
												<span class="material-symbols-outlined">help_center</span>
											</a>
											<button id="conv_freshwork_chat" title="Support" class="btn p-0 lh-0">
												<span class="material-symbols-outlined">sms</span>
											</button>

										</div>
									</div>
								</div>
							</nav>
						</div>
					</header>
					<div id="loadingbar_blue_header" class="progress-materializecss d-none ps-2 pe-2" style="width:100%">
						<div class="indeterminate"></div>
					</div>

	<?php
				}
			}
		}
	}
	new Conversios_Header();
