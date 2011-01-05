<?php

class PHPStack {
	
	// Our API key
	var $key;
	// The site we are currently scoped to
	var $site;
	// An array of sites
	var $sites;
	
	
	function __construct($key, $root = true) {
		$this->key = $key;
		if($root === true) {
			$this->sites = $this->update_sites();
		}
		
		return array($this, $this->sites);
	}
		
	public function update_sites() {
		$raw_api = $this->request("http://stackauth.com/" . SE_API_VERSION . "/sites?key=" . $this->key);
		$api_sites = $raw_api->api_sites;
		$sites = array();
		
		foreach($api_sites as $site) {
			$sites[$site->api_endpoint] = new StackSite($this->key, $site);
		}
		
		return $sites;
	}
	
	// All API requests pass through here.
	private function request($url) {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

 		$response = curl_exec($ch);
		// TODO: Some processing here
		$response = json_decode($response);
		return $response;
	}
	
	// Handles scoped requests
	private function call() {
		
	}
	
}