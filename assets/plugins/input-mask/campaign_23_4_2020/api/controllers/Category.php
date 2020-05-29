<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	/**
	 * 
	 */
	class Category extends MX_Controller
	{
		
		function __construct()
		{
			$this->load->model('category_api_model');
			$this->load->library('form_validation');
			$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');
		}

		public function add_category($issable_user)
		{
			$this->load->view('add_category');

		}

		public function store_add_category()
		{
			$this->form_validation->set_rules('category', 'Category', 'required|is_unique[v_nticket_category.category]');
			if ($this->form_validation->run() == FALSE) {
				# code...
			}

			return $this->category_api_model->insert($_POST);
		}

		public function add_sub_category($issable_user)
		{
			echo 'b';
		}
	}
?>