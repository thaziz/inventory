<?php

class Wa_model extends CI_Model {

    private $pref = '';
	var $table = 'campaign';
	var $column_order = array('a.campaign_id','a.campaign_name', 'a.start_date', 'a.stime_perday');
	var $column_search = array('a.campaign_id','a.campaign_name', 'concat(DATE_FORMAT(a.start_date,"%d %M %Y")," - ",DATE_FORMAT(a.end_date,"%d %M %Y"))', 'concat(TIME_FORMAT(a.stime_perday, "%h:%i %p")," - ", TIME_FORMAT(a.etime_perday, "%h:%i %p"))',);
	var $order = array('a.campaign_id' => 'asc');

	function __construct()
        {
                parent::__construct();
                $this->load->database();
                $this->pref = $this->config->item('tb_pref');
                $this->table = $this->pref.$this->table;
        }

	private function load_campaign(){
        $this->db->select('a.campaign_id, a.campaign_name, concat(DATE_FORMAT(a.start_date,"%d %M %Y")," - ",DATE_FORMAT(a.end_date,"%d %M %Y")) as date_range, concat(TIME_FORMAT(a.stime_perday, "%h:%i %p")," - ", TIME_FORMAT(a.etime_perday, "%h:%i %p")) as schedule_per_day',false);
        //$this->db->join($this->pref.'assign_campaign b', 'a.campaign_id=b.campaign_id');
        //$this->db->where('b.adm_id',$this->session->userdata('id'));
        $this->db->where('a.status',1);
        $this->db->where('a.wa_enabled',1);
        $this->db->group_start();
        $this->db->where('a.start_date<=',date('Y-m-d'));
        $this->db->where('a.end_date>=',date('Y-m-d'));
        $this->db->group_end();
		$this->db->from($this->table.' a');
		$i = 0;
		foreach ($this->column_search as $item) {
			if($_POST['search']['value'])
            {
                if($i===0)
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i)
                $this->db->group_end();
            }
            $i++;
		}

		if(isset($_POST['order']))
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']-1], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
	}

	public function get_load_result()
    {
        $this->load_campaign();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->load_campaign();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function find_by_id($id){
        $this->db->where('campaign_id', $id);
        $query = $this->db->get($this->table, 1);
        if($query->num_rows()>0){
            return $query->row();
        }else{
            return false;
        }
    }

    public function get_data_info($id, $data_id){
        $form=$this->db->select('form')->where('campaign_id', $id)->get($this->pref.'campaign')->row();
        $form = json_decode($form->form);
        $column = array();
        foreach ($form as $key => $value) {
            if(!isset($value->call)){
                $column[] = 'form_'.$value->name;
            }
        }
        $this->db->select(implode(',', $column).', status_wa')->where('data_id', $data_id);
        $query = $this->db->get('data_campaign_'.$id, 1);
        return $query->row();
    }

     public function get_chat($type,$agent,$phone){
        $this->db->where('wa_number',$phone);
        $this->db->where('type',$type);
        $this->db->order_by('chat_time','esc');
        
         /*$this->db->from('whatsapp_chat');
         var_dump($this->db->get_compiled_select());
        exit();*/
        $result = $this->db->get('whatsapp_chat')->result();      

        $q = $this->db->select('id')->where(array('number'=>$agent, 'estatus'=>'A'))->get('call_center.agent',1);
        if($q->num_rows()>0){
            $agent = $q->row()->id;
        }
          
          /*var_dump($result);exit();*/
        $this->db->where(array('wa_number'=> $phone,'type'=> $type, 'status'=>'unread', 'is_reply'=>1))->update('whatsapp_chat', array('status'=>'read'));

        /*
        
        $this->db->where(array('parent_number'=> $phone,'agent_id'=> $agent,'type'=> $type, 'status'=>'unread', 'is_reply'=>1))->update('whatsapp_chat', array('status'=>'read'));
        */

        $data = array();
        foreach ($result as $key => $value) {
             $status='';
             $assign='';             
            $time_assign='';
            if($value->status_chat==''){
                    $status='update_agent';
            }
            if(!empty($value->wa_images))
                $this->download_file($value->wa_images);
            if($value->agent_assign!=0){
                $assign='this chat was assigned by <strong>'.$value->agent_name.'</strong> to <strong>'.$value->agent_assign_name.'</strong>';
                $time_assign=date('H:i',strtotime($value->time_assign)).' | '.date('Y-m-d',strtotime($value->time_assign));
            }
            $data[] = array('text'=>nl2br($value->wa_text), 'image'=>$value->wa_images, 'file'=>$value->wa_files, 'date'=>date('Y-m-d', strtotime($value->chat_time)), 'time'=>date('H:i', strtotime($value->chat_time)), 'status_chat'=>$status,'type'=>$value->is_reply, 'agent'=>($value->is_reply==0?$value->agent_name:''),'quote_text'=>nl2br($value->quoteText), 'quote_image'=>$value->quoteImage,'status'=>$value->status,'id_ack'=>$value->wa_id,'assign'=>$assign,'time_assign'=>$time_assign);
        }
        return $data;
    }
    private function download_file($img){
        if(!is_file("/var/www/html/kanmo/assets/wa_images/".$img) && (strpos($img, 'https://') === false)){
            if($this->process("http://wablas.com/image/".$img, $img)){
                
            }
        }
    }

    private function process($url, $img){
        $ch = curl_init($url);    
        $file = fopen ("/var/www/html/kanmo/assets/wa_images/".$img, 'wb');
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
        //  CURLOPT_BINARYTRANSFER => 1, --- No effect from PHP 5.1.3
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FILE           => $file,
            CURLOPT_TIMEOUT        => 50,
            CURLOPT_USERAGENT      => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)'
        ]);
        $file = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if($code == 200){
            echo ' file exist.... downloading...<br>';
           
        }else{
          $status = false;
        }
        curl_close($ch);
       return $status;
    }

    public function get_data_routing($id, $data_id){
        $this->db->select('*')->where('data_id', $data_id);
        $query = $this->db->get('data_campaign_'.$id, 1);
        return $query->row();
    }

    public function check_api_column_exist($cid){
        return $this->db->field_exists('wa_api_id', 'data_campaign_'.$cid);
    }
    
    public function update_data_routing($id, $data_id, $api_id){
        return $this->db->where('data_id', $data_id)->update('data_campaign_'.$id, array('wa_api_id'=>$api_id));
    }

    public function get_api_account($id=0, $type='kanmo'){
        if($id!=0){
            return $this->db->select('id, wa_number, api_url, auth_key, api_type')->where(array('enabled'=>1, 'id'=>$id, 'type'=>strtolower($type)))->get('wa_api_account',1)->row();
        }else{
            return $this->db->select('id, wa_number, api_url, auth_key, api_type')->where(array('enabled'=>1, 'type'=>strtolower($type)))->get('wa_api_account')->row();
        }
    }

}
