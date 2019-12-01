<?php
/*
Plugin Name: Kua number calculator (Feng shui)
Plugin URI:
Description: Getting your KUA number by date of brith. Shortcode: [wpknc_form]
Version: 1.0
Author: Ali.fpr
Author URI: t.me/ali_fpr
License: Non-licensed

* Shortcode: [wpknc_form]
* References: https://www.thespruce.com/your-feng-shui-kua-number-calculator-1274670
* AND
* https://circle-of-light.com/fengshui/fs-kua.html
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
		public $wpknc_group			= ['West Group' => [2,5,6,7,8], 'East Group' => [1,3,4,9]];

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
			if($num > 9) {
				$num		= str_split($num);
				$new_num[0]	= (count($num) == 4) ? $num[2] : $num[0];
				$new_num[1]	= (count($num) == 4) ? $num[3] : $num[1];
				$num		= $new_num[0] + $new_num[1];

				while($num > 9) {
					$num = str_split($num);
					$num = $num[0] + $num[1];
				}
			}
			return $num;
		}

		public function wpknc_calculator($submited_form) {
			if(isset($submited_form['wpknc_submit'])) {
				$wpknc_fy = $submited_form['wpknc_yyyy'];
				$wpknc_fm = $submited_form['wpknc_mm'];
				$wpknc_fd = $submited_form['wpknc_dd'];
				$wpknc_fg = $submited_form['wpknc_gender'];

				if(($wpknc_fm == 2) or ($wpknc_fm == 3 and ($wpknc_fd <= 20))) {
					$wpknc_fy = $wpknc_fy - 1;
				}

				$wpknc_kn = $this->wpknc_single_digit_maker($wpknc_fy);

				switch($wpknc_fg) {
					case 'famale':
					$wpknc_kn = ($wpknc_fy < 2000) ? $wpknc_kn + 5 : $wpknc_kn + 6;
					// $wpknc_kn = ($wpknc_kn == 5) ? $wpknc_kn + 3 : $wpknc_kn;
					break;
					case 'male':
					$wpknc_kn = ($wpknc_fy < 2000) ? 10 - $wpknc_kn : 9 - $wpknc_kn;
					// $wpknc_kn = ($wpknc_kn == 5) ? $wpknc_kn - 3 : $wpknc_kn;
					break;
				}

				$wpknc_kn = $this->wpknc_single_digit_maker($wpknc_kn);

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
?>