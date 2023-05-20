<?php

/*
Plugin Name: Price
Version: 1.0
Description: Price
Author: SHIN-YA
Author URI: https://twitter.com/shinya_blogger
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: price
*/

/**
 * [price regular="1980" discount="1480"]
 * [price regular="1980" discount="1480" cachback="true"]
 *
 * @return string
*/

add_shortcode('price', 'price_text');

function price_init() {
/*
	■割引
	書式：[price regular="1100" discount="770"]
	出力：
	1,100円<br>
	<span class="hutoaka">770円</span>

	■キャッシュバック
	書式：[price regular="1100" discount="770" cashback]
	1,100円<br>
	<span class="hutoaka"><span class="komozi">キャッシュバックで</span><br>実質550円</span>
*/
	function price_text($atts) {
		if (!is_array($atts)) {
			return '-';
		}
		
		// 値段
		if (!array_key_exists('regular', $atts)) {
			return '-';
		}
		$regular = $atts['regular'];

		// 割引後価格
		$discount = null;
		if (array_key_exists('discount', $atts)) {
			$discount = $atts['discount'];
		}

		// 割引後価格
		$cashback = false;
		if (array_key_exists('cashback', $atts) && $atts['cashback'] == 'true') {
			$cashback = true;
		}
		
		// 出力
		$out = number_format($regular) . '円';
		if ($discount) {
			if ($cashback == true) {
				$out = '<s>' . $out . '</s><br><span class="hutoaka"><span class="komozi">キャッシュバックで</span><br>実質' . number_format($discount) . '円</span>';
			} else {
				$out = '<s>' . $out . '</s><br><span class="hutoaka">' . number_format($discount) . '円</span>';
			}
		}

		return $out;
	}
}
add_action('init', 'price_init');

/** Always end your PHP files with this closing tag */
?>