<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tes extends MX_Controller {

	/**
	 * 
	 */

	public function __construct(){
		//check if the user has logged in, otherwise redirect to login page
		if(!isset($this->session->userdata['logged_in'])){
			redirect(base_url('panel/login'));
		}
		$this->menu = $this->menu_model->load_menu('admin', 'kategori');
		if(!isset($this->menu['rule']['panel/tes'])){
			show_404();
		}
		$this->load->model('tes/Keuangan_model');
		
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');
		
	}

	public function index(){
		//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/bidang']['v']);
		if($_POST && $auth){

			$data_all= [
				'SMP 01 Malang'        =>
				[
					'alamat' => 'Jl Mawar No 01',
					'tlp'    => '0341998822',
				],
				'SMA 01 Malang'        =>
				[
					'alamat' => 'Jl SMA 01 No 41',
					'tlp'    => '0341872819',
				],
				'SMA 02 Malang'        =>
				[
					'alamat' => 'Jl SMA 03 No 4',
					'tlp'    => '0341872819',
				],
				'SMA 03 Malang'        =>
				[
					'alamat' => 'Jl SMA 04 No 1',
					'tlp'    => '0341872819',
					'siswa'  => [
						[
							'nis'       => 'sma3001',
							'nama'      => 'Muhammad',
							'tgl_lahir' => '18 Januari 1996',
						],
						[
							'nis'       => 'sma3002',
							'nama'      => 'Inayah',
							'tgl_lahir' => '24 Januari 1994',
						],
					],
				],
				'SMA 04 Malang'        =>
				[
					'alamat' => 'Jl SMA 04 No 3',
					'tlp'    => '0341872819',
					'siswa'  => [
						[
							'nis'       => 'sma4001',
							'nama'      => 'sutejo',
							'tgl_lahir' => '18 Januari 1994',
						],
						[
							'nis'       => 'sma4002',
							'nama'      => 'sutijan',
							'tgl_lahir' => '24 Januari 1998',
						],
					],
				],
				'SMA 05 Malang'        =>
				[
					'alamat' => 'Jl SMA 05 No 5',
					'tlp'    => '0341872819',
				],
				'SMA 06 Malang'        =>
				[
					'alamat' => 'Jl SMA 06 No 8',
					'tlp'    => '0341872819',
				],
				'SMA 07 Malang'        =>
				[
					'alamat' => 'Jl SMA 07 No 81',
					'tlp'    => '0341872819',
				],
				'SMA 08 Malang'        =>
				[
					'alamat' => 'Jl SMA 08 No 11',
					'tlp'    => '0341872819',
				],
				'SMA 09 Malang'        =>
				[
					'alamat' => 'Jl SMA 09 No 121',
					'tlp'    => '0341872819',
				],
				'SMA 10 Malang'        =>
				[
					'alamat' => 'Jl SMA 10 No 451',
					'tlp'    => '0341872819',
				],
				'SMK 01 Malang'        =>
				[
					'alamat' => 'Jl SMA 01 No 21',
					'tlp'    => '0341928192',
				],
				'SMK 01 Malang'        =>
				[
					'alamat' => 'Jl SMK 01 No 11',
					'tlp'    => '0341928192',
				],
				'SMK 02 Malang'        =>
				[
					'alamat' => 'Jl SMK 02 No 31',
					'tlp'    => '0341928192',
				],
				'SMK 03 Malang'        =>
				[
					'alamat' => 'Jl SMK 03 No 21',
					'tlp'    => '0341928192',
				],
				'SMK 04 Malang'        =>
				[
					'alamat' => 'Jl Panjaitan No 21',
					'tlp'    => '0341928192',
				],
				'SMK 05 Malang'        =>
				[
					'alamat' => 'Jl Panjaitan No 21',
					'tlp'    => '0341928192',
					'siswa'  => [
						[
							'nis'       => 'smk5001',
							'nama'      => 'rani',
							'tgl_lahir' => '18 Januari 1994',
						],
						[
							'nis'       => 'smk5002',
							'nama'      => 'rahayu',
							'tgl_lahir' => '24 Januari 1998',
						],
					],
				],
				'SMK 06 Malang'        =>
				[
					'alamat' => 'Jl Panjaitan No 21',
					'tlp'    => '0341928192',
					'siswa'  => [
						[
							'nis'       => 'smk6001',
							'nama'      => 'sutejo',
							'tgl_lahir' => '18 Januari 1994',
						],
						[
							'nis'       => 'smk6002',
							'nama'      => 'sutijan',
							'tgl_lahir' => '24 Januari 1998',
						],
					],
				],
				'SMK Kesehatan Malang' =>
				[
					'alamat' => 'Jl Dr Soetomo No 25',
					'tlp'    => '0341587212',
				],
				'SMP 02 Malang'        =>
				[
					'alamat' => 'Jl SMP 02 No 25',
					'tlp'    => '034192812',
				],
				'SMP 03 Malang'        =>
				[
					'alamat' => 'Jl SMP 03 No 25',
					'tlp'    => '034192812',
				],
				'SMP 04 Malang'        =>
				[
					'alamat' => 'Jl SMP 04 No 25',
					'tlp'    => '034192812',
				],
				'SMP 05 Malang'        =>
				[
					'alamat' => 'Jl SMP 05 No 25',
					'tlp'    => '034192812',
				],
				'SMP 06 Malang'        =>
				[
					'alamat' => 'Jl SMP 06 No 25',
					'tlp'    => '034192812',
				],
				'SMP 07 Malang'        =>
				[
					'alamat' => 'Jl SMP 07 No 25',
					'tlp'    => '034192812',
					'siswa'  => [
						[
							'nis'       => 'smp7001',
							'nama'      => 'Lala',
							'tgl_lahir' => '18 Januari 1998',
						],
						[
							'nis'       => 'smp7002',
							'nama'      => 'Luluk',
							'tgl_lahir' => '24 Juli 1997',
						],
					],
				],
				'SMP 08 Malang'        =>
				[
					'alamat' => 'Jl SMP 08 No 25',
					'tlp'    => '034192812',
					'siswa'  => [
						[
							'nis'       => 'smp8001',
							'nama'      => 'Ahmad',
							'tgl_lahir' => '18 Januari 1994',
						],
						[
							'nis'       => 'smk8002',
							'nama'      => 'Memel',
							'tgl_lahir' => '21 Maret 1996',
						],
					],
				],
				'SMP 09 Malang'        =>
				[
					'alamat' => 'Jl SMP 09 No 25',
					'tlp'    => '034192812',
				],
				'SMP 10 Malang'        =>
				[
					'alamat' => 'JL SMP 10 No 25',
					'tlp'    => '034192812',
				],
				'SMP 11 Malang'        =>
				[
					'alamat' => 'Jl SMP 11 No 25',
					'tlp'    => '034192812',
				],
				'SMP 12 Malang'        =>
				[
					'alamat' => 'Jl SMP 12 No 25',
					'tlp'    => '034192812',
				],
				'SMP 13 Malang'        =>
				[
					'alamat' => 'Jl SMP 13 No 25',
					'tlp'    => '034192812',
				]
			];
			$data['data']=array();
			foreach ($data_all as $key => $value) {
				$value['kls']=$key;
				$chek=explode(" ",$key);
          		//	$data['data']['sekolah'][]=$key;
				if($_POST['sekolah']==$chek[0]){
					$data['data'][]=$value;
				}

			}
			$this->load->view('data', $data);
		}else{


			$data['menu'] = $this->menu;
			//write user activity to logger
			$data['rules'] = $this->menu['rule']['panel/admin'];
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS ADMINISTRATOR MENU');
			$this->template->view('index', $data);
		}
	}




	public function keuangan(){
		//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/tes']['v']);
		if($_POST && $auth){
			$data['keuangan']=$this->Keuangan_model->keuangan();
		//	var_dump($keuangan);exit();			
			
			$this->load->view('data_keuangan', $data);
		}else{
//	$keuangan=$this->Keuangan_model->keuangan();exit();
			$data['menu'] = $this->menu;
			//write user activity to logger
			$data['rules'] = $this->menu['rule']['panel/admin'];
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS ADMINISTRATOR MENU');
			$this->template->view('keuangan', $data);
		}
	}



}
