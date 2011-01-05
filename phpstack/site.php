<?php 

class StackSite extends PHPStack {
	
	var $site_info;
	
	function __construct($key, $site_info) {
		$this->site = $site_info->api_endpoint;
		$this->key = $key;
		$this->site_info = $site_info;
	}
	
}