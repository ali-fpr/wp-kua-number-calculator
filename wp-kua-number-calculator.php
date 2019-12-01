<?php
/*
Plugin Name: Kua number calculator
Plugin URI:
Description: Getting your KUA number by date of brith. Shortcode: [wpknc_form]
Version: 1.0
Author: Ali.fpr
Author URI: t.me/ali_fpr
License: Non-licensed

* Shortcode: [wpknc_form]
* Reference: https://www.thespruce.com/your-feng-shui-kua-number-calculator-1274670
*/

if(!defined('ABSPATH')) {
	exit('Hi there, no direct script access allowed.');
}

if(!class_exists('wpknc')) {
	class wpknc {
		protected static $_instance = NULL;
		public $wpknc_plugin_url	= NULL;
		public $wpknc_result_number	= NULL;
		public $wpknc_result_group	= NULL;
		public $wpknc_group			= ['West Group' => [2,6,7,8], 'East Group' => [1,3,4,9]];

		public static function instance() {
			if(is_null(self::$_instance)) {
				self::$_instance = new self();
			}
		}

		public function __construct() {
			$this->wpknc_plugin_url = untrailingslashit(plugin_dir_path(__FILE__));

			add_action('plugins_loaded', [$this, 'wpknc_load']);
			register_activation_hook(__FILE__, [$this, 'wpknc_load']);
		}

		public function wpknc_single_digit_maker($num) {
			while($num > 9) {
				$num = str_split($num);
				$num = $num[0] + $num[1];
			}
			return $num;
		}

		public function wpknc_calculator($submited_form) {
			if(isset($submited_form['wpknc_submit'])) {
				$wpknc_fy = $submited_form['wpknc_yyyy'];
				$wpknc_fm = $submited_form['wpknc_mm'];
				$wpknc_fd = $submited_form['wpknc_dd'];
				$wpknc_fg = $submited_form['wpknc_gender'];

				$wpknc_fy = ($wpknc_fm < 3) ? $wpknc_fy - 1 : $wpknc_fy;
				$wpknc_kn = $this->wpknc_single_digit_maker($wpknc_fy);

				switch($wpknc_fg) {
					case 'famale':
					$wpknc_kn = ($wpknc_fy < 2000) ? $wpknc_kn + 5 : $wpknc_kn + 6;
					$wpknc_kn = ($wpknc_kn == 5) ? $wpknc_kn + 3 : $wpknc_kn;
					break;
					case 'male':
					$wpknc_kn = ($wpknc_fy < 2000) ? 10 - $wpknc_kn : 9 - $wpknc_kn;
					$wpknc_kn = ($wpknc_kn == 5) ? $wpknc_kn - 3 : $wpknc_kn;
					break;
				}


				$this->wpknc_result_group	= (in_array($wpknc_kn, $this->wpknc_group['West Group'])) ? 'West Group' : 'East Group';
				$this->wpknc_result_number	= $wpknc_kn;
			}
		}

		public function wpknc_shortcode_forntend() {
			echo $this->wpknc_result_number . ' (' . $this->wpknc_result_group . ')';
			include_once($this->wpknc_plugin_url . '/frontend/kua-form.php');
		}

		public function wpknc_load() {
			$this->wpknc_calculator($_POST);
			add_shortcode('wpknc_form', [$this, 'wpknc_shortcode_forntend']);
		}
	}
}
wpknc::instance();



/*if(!class_exists('wp_gamesprofile')) {
class mafp_kua_number_maker {
	protected static $mknm_plugin_url;
	private $mknm_kua_number;
	private $mknm_kua_group;
	private $mknm_kua_pageid;

	function __construct() {
		$this->mknm_plugin_url	= untrailingslashit(plugin_dir_path(__FILE__));
		$this->mknm_kua_number	= NULL;
		$this->mknm_kua_group	= NULL;
		$this->mknm_kua_pageid	= [
			'1' => 'http://fengshui-miracles.com/your-kua-number-is-1/',
			'2' => 'http://fengshui-miracles.com/your-kua-number-is-2/',
			'3' => 'http://fengshui-miracles.com/your-kua-number-is-3/',
			'4' => 'http://fengshui-miracles.com/your-kua-number-is-4/',
			'6' => 'http://fengshui-miracles.com/your-kua-number-is-6/',
			'7' => 'http://fengshui-miracles.com/your-kua-number-is-7/',
			'8' => 'http://fengshui-miracles.com/your-kua-number-is-8/',
			'9' => 'http://fengshui-miracles.com/your-kua-number-is-9/'
		];

		function start_session() {
			if(!session_id()) {
				session_start();
			}
		}
		add_action('init', 'start_session', 1);

		add_action('plugins_loaded', array($this, 'mknm_start'));
		register_activation_hook(__FILE__, array($this, 'mknm_setup'));

		$this->mknm_form_submit();
	}

	public function mknm_setup() {
		// KUA plugin dosent need this part to do something :D
	}

	public function mknm_form_submit() {
		if(isset($_POST['mknm_submit'])) {
			// Get post inputs
			$form_y = $_POST['mknm_form_yy'];
			$form_m = $_POST['mknm_form_mm'];
			$form_d = $_POST['mknm_form_dd'];
			$form_g = $_POST['mknm_form_gender'];

			// Make session for client date of birth,
			// U must use this result with DATE() tag like: echo date('Y/m/d', session);
			//$_SESSION['mknm_client_db'] = mktime(00, 00, 00, $form_m, $form_d, $form_y);
			
			// Get two last number from year and sum both of them
			$form_y		= ($form_m < 3) ? $form_y - 1 : $form_y;
			$filter_y	= str_split($form_y);
			$filter_y	= $filter_y[2] + $filter_y[3];

			// Make func for number which is bigger than 9
			function mknm_make_single_num($num) {
				$filter_yL2 = str_split($num);
				$filter_yL2 = $filter_yL2[0] + $filter_yL2[1];
				return $filter_yL2;
			}

			// Check if first result is bigger than 9
			$kua_base = ($filter_y > 9) ? mknm_make_single_num($filter_y) : $filter_y;

			// Make KUA number by gender
			switch($form_g) {
				case 'male':
				$kua_num = ($form_y < 2000) ? 10 - $kua_base : 9 - $kua_base;
				$kua_num = ($kua_num == 5) ? $kua_num - 3 : $kua_num;
				break;
				case 'famale':
				$kua_num = ($form_y < 2000) ? $kua_base + 5 : $kua_base + 6;
				$kua_num = ($kua_num > 9) ? mknm_make_single_num($kua_num) : $kua_num;
				$kua_num = ($kua_num == 5) ? $kua_num + 3 : $kua_num;
				break;
			}

			// $EAST_Group = [1,3,4,9] / $WEST_Group = [2,6,7,8]
			$this->mknm_kua_group	= (in_array($kua_num, [2,6,7,8])) ? 'West Group' : 'East Group';
			$this->mknm_kua_number	= $kua_num;

			//wp_redirect($this->mknm_kua_pageid[$this->mknm_kua_number]);
			echo '<script>window.location.href = "' . $this->mknm_kua_pageid[$this->mknm_kua_number] . '";</script>';
		}
	}

	public function mknm_start() {
		// Shortcode: [mknm_form]
		add_shortcode('mknm_form', array($this, 'mknm_form_shortcode'));
	}

	public function mknm_form_shortcode() {
		include_once($this->mknm_plugin_url . '/template/input_form.php');
	}
}

// There we go ;)
$mafp_kua_number_maker = new mafp_kua_number_maker();*/
?>