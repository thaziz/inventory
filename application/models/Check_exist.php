<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Check_exist extends CI_Model
{

	public function checking($table,$unique = array()){
		$query = $this->db->get_where($table,$unique);
		if($query->num_rows() > 0){
			return array('status'	=>	'exist');
		}else{
			return array('status'	=>	'free');
		}
	}
}