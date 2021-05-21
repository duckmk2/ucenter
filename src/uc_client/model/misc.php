<?php

/*
	[UCenter] (C)2001-2099 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: misc.php 1059 2011-03-01 07:25:09Z monkey $
*/

!defined('IN_UC') && exit('Access Denied');

define('UC_ARRAY_SEP_1', 'UC_ARRAY_SEP_1');
define('UC_ARRAY_SEP_2', 'UC_ARRAY_SEP_2');

class miscmodel {

	var $db;
	var $base;

	function __construct(&$base) {
		$this->miscmodel($base);
	}

	function miscmodel(&$base) {
		$this->base = $base;
		$this->db = $base->db;
	}

	function get_apps($col = '*', $where = '') {
		$arr = $this->db->fetch_all("SELECT $col FROM ".UC_DBTABLEPRE."applications".($where ? ' WHERE '.$where : ''));
		return $arr;
	}

	function delete_apps($appids) {
	}

	function update_app($appid, $name, $url, $authkey, $charset, $dbcharset) {
	}

	//private
	function alter_app_table($appid, $operation = 'ADD') {
	}

	function get_host_by_url($url) {
	}

	function check_url($url) {
	}

	function check_ip($url) {
	}

	function test_api($url, $ip = '') {
	}

	function dfopen2($url, $limit = 0, $post = '', $cookie = '', $bysocket = FALSE, $ip = '', $timeout = 15, $block = TRUE, $encodetype  = 'URLENCODE') {
		$__times__ = isset($_GET['__times__']) ? intval($_GET['__times__']) + 1 : 1;
		if($__times__ > 2) {
			return '';
		}
		$url .= (strpos($url, '?') === FALSE ? '?' : '&')."__times__=$__times__";
		return $this->dfopen($url, $limit, $post, $cookie, $bysocket, $ip, $timeout, $block, $encodetype);
	}

	function dfopen($url, $limit = 0, $post = '', $cookie = '', $bysocket = FALSE	, $ip = '', $timeout = 15, $block = TRUE, $encodetype  = 'URLENCODE') {
		//error_log("[uc_client]\r\nurl: $url\r\npost: $post\r\n\r\n", 3, 'c:/log/php_fopen.txt');
		$return = '';
		$matches = parse_url($url);
		$host = $matches['host'];
		$path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
		$port = !empty($matches['port']) ? $matches['port'] : 80;

		if($post) {
			$boundary = $encodetype == 'URLENCODE' ? '' : ';'.substr($post, 0, trim(strpos($post, "\n")));
			$options =  array(
				CURLOPT_TIMEOUT => $timeout,
				CURLOPT_URL => $host.$path,
				CURLOPT_POST => true,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POSTFIELDS => $post,
				CURLOPT_HTTPHEADER => array($encodetype == 'URLENCODE' ? "Content-Type: application/x-www-form-urlencoded" : "Content-Type: multipart/form-data$boundary",'User-Agent: '.$_SERVER[HTTP_USER_AGENT]),
				CURLOPT_COOKIE => $cookie,
			);
		} else {
			$options =  array(
				CURLOPT_TIMEOUT => $timeout,
				CURLOPT_URL => $host.$path,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_COOKIE => $cookie,
				CURLOPT_HTTPHEADER => array('User-Agent: '.$_SERVER['HTTP_USER_AGENT']),
			);
		}

		$ch = curl_init();
		curl_setopt_array($ch, $options);
		$response = curl_exec($ch);
		curl_close($ch);

		if(!$response) {
			return '';
		} else {
			return $response;
		}
	}

	function array2string($arr) {
		$s = $sep = '';
		if($arr && is_array($arr)) {
			foreach($arr as $k => $v) {
				$s .= $sep.$k.UC_ARRAY_SEP_1.$v;
				$sep = UC_ARRAY_SEP_2;
			}
		}
		return $s;
	}

	function string2array($s) {
		$arr = explode(UC_ARRAY_SEP_2, $s);
		$arr2 = array();
		foreach($arr as $k => $v) {
			list($key, $val) = explode(UC_ARRAY_SEP_1, $v);
			$arr2[$key] = $val;
		}
		return $arr2;
	}
}

?>
