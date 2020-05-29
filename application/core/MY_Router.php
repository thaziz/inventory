<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH."third_party/MX/Router.php";

class MY_Router extends MX_Router {
	function _set_request($segments = array()){
		if($segments[0]=='panel'||$segments[0]=='user')
			array_splice($segments, 0, 1);
		parent::_set_request($segments);
	}

	/*function _parse_routes(){
		$uri = implode('/', $this->uri->segments);

        if (isset($this->routes[$uri])){
        	parent::_set_request(explode('/', $this->routes[$uri]));
        }else{
        	return $this->_set_request(explode('/', $uri));
        }
	}*/
}