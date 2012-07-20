<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Type: BBcode
| Name: Chart
| Version: 1.00
| Author: Valerio Vendrame (lelebart)
+--------------------------------------------------------+
| Filename: chart_bbcode_include_var.php
| Author: Valerio Vendrame (lelebart)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

include_once (LOCALE."English/bbcodes/chart.php");
if (file_exists(LOCALE.LOCALESET."bbcodes/chart.php")) {
	include_once (LOCALE.LOCALESET."bbcodes/chart.php");
}

if ( !function_exists('google_chart_bbcode') ) {
	/* Google Chart Image: http://code.google.com/intl/it-IT/apis/chart/image/docs/making_charts.html */	
	function google_chart_bbcode( $args ) {
		global $locale;
		
		if ( !version_compare(PHP_VERSION, '5.3.0', '>=') )
			return '<!-- chart: error: PHP >= 5.3 required -->';
		
		if ( isset( $args[2] ) ) {
			$args_raw = bbcode_params( $args[1] ); 
			$args_raw['title'] = stripslash( $args[2] );
		} else {
			if ( $argsnraw = explode( "\n", $args[1] ) ) {		
				$args_raw['data']   = $argsnraw[0];
				$args_raw['labels'] = isset($argsnraw[1]) ? $argsnraw[1] : '';
				$args_raw['title']  = isset($argsnraw[2]) ? $argsnraw[2] : '';
				$args_raw = clean_array( $args_raw );
			} else {
				return '<!-- chart: error: no data -->';			
			}
		}
		
		if ( array_key_exists( 'NOT_FOUND', $args_raw ) )
			return '<!-- chart: error: NOT_FOUND -->';
	  
		$args_new = bbcode_check_value( array(
			'data' => '', 'colors' => '', 'size' => '400x200', 'bgcolor' => 'ffffff',
			'title' => '', 'labels' => '', 'advanced' => '', 'type' => 'pie'
		), $args_raw );
		
		if ( empty($args_new['data']) )
			return '<!-- chart: error: no data -->';
		$args_new['data']     = "t:".$args_new['data'];
		
		$args_new['size']     = isnum( $args_new['size'] ) ? $args_new['size']."x".$args_new['size'] : $args_new['size'];
		$size = explode( "x", $args_new['size']);
		if ( !isset($size[1]) || !isnum($size[0]) || !isnum($size[1]) || max($size[0], $size[1]) > 1000)
			return '<!-- chart: error: invalid size -->';
		
		$type = array( 
			'line' => 'lc', 'xyline' => 'lxy', 'sparkline' => 'ls', 'meter' => 'gom',
			'scatter' => 's', 'venn' => 'v', 'pie' => 'p3', 'pie2d' => 'p'
		);
		$args_new['type']     = array_key_exists( $args_new['type'], $type ) ? $type[ $args_new['type'] ] : $args_new['type'];
		
		$title = empty( $args_new['title'] ) ? $locale['bb_chart'] : $args_new['title'];
		$args_new['title']    = str_replace( array("<",">","'",'"',"+") , array("%3C","%3E","%27","%22","%2B"),  $args_new['title'] );
		$args_new['title']    = str_replace( array(" ", "--"), array("+", "|"), $args_new['title'] );
		
		$args_new['labels']   = str_replace( array(" ", ","), array("+", "|"), $args_new['labels'] );
		
	//	$args_new['advanced'] = str_replace( "&", "&amp;", str_replace( "&amp;", "&", $args_new['advanced'] ) );
		
		$chart_check_hex = function( $val ) use (&$chart_check_hex) {
			if ( is_array( $val ) ) return array_map( $chart_check_hex, $val );
			else {
				$val = strtoupper( $val );
				return preg_match('/^([A-F\d]{3})$/i', $val) ? $val[0].$val[0].$val[1].$val[1].$val[2].$val[2] :
					( preg_match('/^([A-F\d]{3}){2}$/i', $val) ? $val : '' );
			}
		};
		$args_new['colors']   = implode( ",", $chart_check_hex( explode(",", $args_new['colors']) ? 
									explode( ",", $args_new['colors'] ) : $args_new['colors'] ) );
		$args_new['bgcolor']  = preg_match('/^([A-F\d]{3}){1,2}$/i', $args_new['bgcolor']) ? "bg,s,".$chart_check_hex( $args_new['bgcolor'] ) : $args_new['bgcolor'];
		
		$args_url = array(
			'chd'  => $args_new['data'],
			'chco' => $args_new['colors'],
			'chs'  => $args_new['size'],
			'chf'  => $args_new['bgcolor'],
			'chtt' => $args_new['title'],
			'chl'  => $args_new['labels'],
			'cht'  => $args_new['type']
		);
		
		$url = urldecode( http_build_query( array_filter( $args_url ), '', '&amp;' ) ).( $args_new['advanced'] ? '&amp;'.$args_new['advanced'] : '' );
		
		return '<img title="'.$title.'" src="http://'.rand(0,9).'.chart.apis.google.com/chart?'.$url.'" alt="'.$title.'" class="chart-bbocde-image" />';
	}
}

if ( !function_exists('bbcode_params') ) {
	function bbcode_params( $str ) {
		$params   = array();
		$regexp[] = '(\w+)="([^"]*)"';            // f[1]="f[2]"
		$regexp[] = "(\w+)='([^']*)'";            // f[3]='f[4]'
		$regexp[] = '(\w+)=&quot;([^"]*)&quot;';  // f[5]="f[6]"
		$regexp[] = '(\w+)=&\#39;([^"]*)&\#39;';  // f[7]='f[8]'
		$regexp[] = '(\w+)=([^\s\'"]+)';          // f[9]=f[10]
		$regexp[] = '([a-z]+)(.*?)';              // f[11]
		$regexp   = '/'.implode( "|", $regexp ).'/';
		if ( preg_match_all( $regexp, $str, $m, PREG_SET_ORDER ) ) {
			foreach ($m as $f) {
					 if (!empty($f[1]))  $params[strtolower($f[1])] = $f[2];
				else if (!empty($f[3]))  $params[strtolower($f[3])] = $f[4];
				else if (!empty($f[5]))  $params[strtolower($f[5])] = $f[6];
				else if (!empty($f[7]))  $params[strtolower($f[7])] = $f[8];
				else if (!empty($f[9]))  $params[strtolower($f[9])] = $f[10];
				else if (!empty($f[11])) $params[trim($f[11])]      = true;
			}
		} else { $params['NOT_FOUND'] = $str; }
		return clean_array( $params );
	}
}

if ( !function_exists('bbcode_check_value') ) {
	function bbcode_check_value($defaults, $params) {
		$params = (array)$params;
		$values = array();
		foreach($defaults as $value => $default) {
			$values[$value] = array_key_exists($value, $params) ?
								$params[$value] : $default;
		}
		return $values;
	}
}

if ( !function_exists('clean_array') ) {
	function clean_array( $arr ) {
		if (!is_array( $arr )) return $arr;
		else {
			$arr = array_map( 'stripslash', $arr );
			$arr = array_map( 'trim', $arr );
			$arr = array_filter( $arr );
			$arr = array_map( function( $sanitize ) { 
									return str_replace( array("<",">") , array("%3C","%3E"), $sanitize );
								}, $arr );
			return $arr;
		}
	}
}

$text = preg_replace_callback('#\[chart (.*?)\](.*?)\[/chart\]#si', "google_chart_bbcode", $text);
$text = preg_replace_callback('#\[chart\](.*?)\[/chart\]#si', "google_chart_bbcode", $text);

?>
