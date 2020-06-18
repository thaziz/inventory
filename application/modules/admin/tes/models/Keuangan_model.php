<?php

class Keuangan_model extends CI_Model {

    private $pref = '';
    var $table = 'kategori';
    var $column_order = array('k_id','k_name','k_note','k_sk');
    var $column_search =array('k_id','k_name','k_note','k_sk');
    var $order = array('k_id' => 'asc');

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('security');
        $this->pref = $this->config->item('tb_pref');
        $this->table = $this->pref.$this->table;
    }

    function keuangan(){
        $data=$this->db->query("SELECT nama,tanggal,debit FROM acc_m_akun JOIN acc_trans_detail ON acc_trans_detail.m_akun_id=acc_m_akun.id WHERE tanggal LIKE '2020-02%' ")->result();

        $begin = new DateTime('2020-02-01');
        $end = new DateTime('2020-02-30');

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);
        $tgl=[];
        $nama=[];
        foreach ($data as $v) {
            $nama[]=$v->nama;
        }
        $nama=array_unique($nama);
        //$tgl='Nama Akun';
        foreach ($period as $dt) {
            $tgl[]=$dt->format("Y-m-d");
        }
        $new_data=[];
        foreach ($nama as $k => $n) {
         
            foreach ($tgl as $key => $t) {            
                $new_data[$n][$t]=$this->cek($t,$n,$data);                
                
            }
        } 

        return array('data'=>$new_data,'tgl'=>$tgl);



    }

    function cek($tanggal,$nama,$data){
        $a='';
        foreach ($data as $key => $v) {
          // echo $v->nama.'=='.$nama .'--'. $v->tanggal.'=='.$tanggal.'<br>';
            if($v->nama==$nama && $v->tanggal==$tanggal){
                $a= $v->debit;
            }
        }
        if($a==''){
            $a=0;
        }
        return $a;
    }
}