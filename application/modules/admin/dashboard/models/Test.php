<?php

class Test extends CI_Model {
	public function __construct()
        {
                parent::__construct();
                // Your own constructor code
        }
	function test(){
		return 'hello';
	}
}