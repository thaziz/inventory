<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Ticketing_model extends CI_Model
{

	public function check_caller($phone){
		$query = $this->db->where('cus_phone',$phone)->get('v_caller',1);
		if($query->num_rows() > 0){
			return $query->row();
		}
		return false;
	}

	public function generate_ticket_id($ext){
		$ticket = date('ymd').'2'.substr($ext, -3);
		$query = $this->db->select('MAX(CAST(RIGHT(ticket_id, 4) AS SIGNED)) as max_id',false)->like('ticket_id', $ticket, 'after')->get('v_ticket',1);
		if($query->num_rows()>0){
			$row = $query->row()->max_id+1;
			return $ticket.str_pad($row, (14-strlen($ticket)), '0', STR_PAD_LEFT);
		}else{
			return str_pad($ticket, 13, '0').'1';
		}
	}

	public function save_ticket(){
		$time = date('Y-m-d H:i:s');
		if(!isset($_POST['cus_id'])){
			$cus = array(
				'cus_name'=>$_POST['cus_name'],
				'cus_phone'=>$_POST['cus_phone'],
				'address'=>isset($_POST['address'])?$_POST['address']:'',
				'province'=>isset($_POST['province'])?$_POST['province']:'',
				'city'=>isset($_POST['city'])?$_POST['city']:'',
				'district'=>isset($_POST['district'])?$_POST['district']:'',
				'last_call'=>date('Y-m-d H:i:s')
			);
			$this->db->insert('v_caller', $cus);
			$_POST['cus_id'] = $this->db->insert_id();
		} else {
			$this->db->where('cus_id', $_POST['cus_id'])->update('v_caller', array('last_call'=>date('Y-m-d H:i:s')));
		}

		$cc = $this->load->database('callcenter', TRUE);
		$agent = $cc->where('number', $_POST['agent'])->get('call_center.agent',1);
		if($agent->num_rows()>0){
			$_POST['open_by_name'] = $agent->row()->name;
		}

		//$_POST['province']=$this->db->where('id', $_POST['province'])->get('v_province',1)->row()->province;
		//$_POST['city']=$this->db->where('id', $_POST['city'])->get('v_city',1)->row()->city;
		//$_POST['district']=$this->db->where('id', $_POST['district'])->get('v_district',1)->row()->district;
		//$_POST['category']=$this->db->where('id', $_POST['category'])->get('v_nticket_category',1)->row()->category;


		$_POST['open_date'] = $time;
		$_POST['is_read'] = 0;
		$_POST['open_by'] = $_POST['agent'];
		if($_POST['status']=='OPEN'){
			$assign_to = isset($_POST['assign_to'])?$_POST['assign_to']:0;

		}else{
			$_POST['closed_by']=$_POST['agent'];
			$_POST['closed_by_name']=isset($_POST['open_by_name'])?$_POST['open_by_name']:$_POST['open_by'];
			$_POST['closed_date']=$time;
			$_POST['is_read']=1;
		}

		unset($_POST['cc']);
		unset($_POST['bcc']);
		unset($_POST['callback']);
		unset($_POST['agent']);
		unset($_POST['assign_to']);
		unset($_POST['email_assign']);
		$flag = false;

		if($this->db->insert('v_ticket', $_POST)){
			$ticket_id=$this->db->insert_id();

			if($_POST['status']=='OPEN'){
				$assignment = array();
				if(!empty($assign_to)){
					$assignment = $this->db->where('id',$assign_to)->get('v_department',1)->row_array();

				}else{
					$assignment['department_name'] = '';
				}
				$assign = array(
					'ticket_id'=>$ticket_id,
					'assign_by'=>$_POST['open_by'],
					'assign_by_name'=>isset($_POST['open_by_name'])?$_POST['open_by_name']:$_POST['open_by'],
					'dept_id'=>$assign_to,
					'department_name'=>$assignment['department_name'],
					'assign_time'=>$time,
				);

				if($this->db->insert('v_ticket_assignment',$assign)){
					$assign_id = $this->db->insert_id();
					$this->db->where('id',$ticket_id)->update('v_ticket',array('curr_assign'=>$assign_id));
					$history = array(
						'ticket_id'=>$ticket_id,
						'assign_id'=>$assign_id,
						'user_id'=>$_POST['open_by'],
						'username'=>isset($_POST['open_by_name'])?$_POST['open_by_name']:$_POST['open_by'],
						'time'=>$time,
						'activity'=>'Create ticket with status <label class="label label-info">OPEN</label> and assign to '.$assignment['department_name'].'.'/*.($_POST['need_callback']==1?' This ticket need callback to the customer.':''),*/
					);
					$flag = $this->db->insert('v_ticket_history', $history);
				}
			}else{
				$history = array(
					'ticket_id'=>$ticket_id,
					'user_id'=>$_POST['open_by'],
					'username'=>isset($_POST['open_by_name'])?$_POST['open_by_name']:$_POST['open_by'],
					'time'=>$time,
					'activity'=>'Create ticket with status <label class="label label-warning">CLOSED</label>.<br>'.(!empty($_POST['closed_note'])?'Note: <br>'.$_POST['closed_note']:''),
				);
				$flag = $this->db->insert('v_ticket_history', $history);
			}
			/*if($_POST['status']=='CLOSED'){
				send_email_ticket_closed($ticket_id);
			}*/
		}
		return $flag;
	}

	public function assignment_list(){
		$result = $this->db->select('id, name, email')->get('v_assignment_list')->result();
		$data = array();
		foreach ($result as $key => $value) {
			$data[] = array('id'=>$value->id, 'text'=>$value->name, 'email'=>$value->email);
		}
		return $data;
	}

	public function department_list(){
		$result = $this->db->select('id, department_name')->get('v_department')->result();
		$data = array();
		foreach ($result as $key => $value) {
			$data[] = array('id'=>$value->id, 'text'=>$value->department_name);
		}
		return $data;
	}
	/*public function category(){
		$result = $this->db->select('id, category')->get('v_nticket_category')->result();
		$data = array();
		foreach ($result as $key => $value) {
			$data[] = array('id'=>$value->category, 'text'=>$value->category);
		}
		return $data;
	}*/
	public function category(){
		$result = $this->db->select('id, category')->where(array('meta_id'=>0,'parent_id'=>0, 'enabled'=>1))->get('v_nticket_category')->result();
		$data = array();
		foreach ($result as $key => $value) {
			$data[] = array('id'=>$value->id, 'text'=>$value->category);
		}
		return $data;
	}

	public function subcategory($id){
		$result = $this->db->select('id, category')->where(array('parent_id'=>$id, 'enabled'=>1))->get('v_nticket_category')->result();
		$data = array();
		foreach ($result as $key => $value) {
			$data[] = array('id'=>$value->category, 'text'=>$value->category);
		}
		return $data;
	}

	var $ticket_order = array('v_ticket.id','ticket_id','category','subject', 'open_date',/*'store_name',*/'status');
	var $ticket_search = array('v_ticket.id','ticket_id','category','subject', 'open_date',/*'store_name',*/'status');
	var $thorder = array('open_date' => 'desc');

	private function load_ticket_history(){
        $this->db->select(implode(',',$this->ticket_order));
        $this->db->from('v_ticket');
        $this->db->join('v_customer', 'v_customer.cus_id=v_ticket.cus_id', 'left');
        if(isset($_POST['phone'])){
	        $this->db->group_start();
		        $this->db->where('v_customer.cus_phone', $_POST['phone']);
		        $this->db->or_where('v_ticket.cus_phone', $_POST['phone']);
	        $this->db->group_end();
	    }else if(isset($_POST['email'])){
	    	$this->db->group_start();
		        $this->db->where('v_customer.email', $_POST['email']);
		        $this->db->or_where('v_ticket.email', $_POST['email']);
	        $this->db->group_end();
	    }
        $this->db->where('v_ticket.type', 'NESPRESSO');
        /*if(!empty($_POST['store'])){
        	$this->db->like('store', $_POST['store']);
        }*/
        if(!empty($_POST['periode'])){
        	$date = explode(' - ',$_POST['periode']);
        	$this->db->where(array('open_date>='=>date('Y-m-d 00:00:00',strtotime($date[0])), 'open_date<='=>date('Y-m-d 23:59:59',strtotime($date[1]))));
        }else{
        	$startdate = date('Y-m-d 00:00:00', strtotime(date('Y-m-d'). ' -1 months'));
			$enddate = date('Y-m-d 23:59:59');
			$this->db->where(array('open_date>='=>$startdate, 'open_date<='=>$enddate));
        }
		$i = 0;
		foreach ($this->ticket_search as $item) {
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
 
                if(count($this->ticket_search) - 1 == $i)
                $this->db->group_end();
            }
            $i++;
		}

		if(isset($_POST['order']))
        {
            $this->db->order_by($this->ticket_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->thorder))
        {
            $order = $this->thorder;
            $this->db->order_by(key($order), $order[key($order)]);
        }
	}

	public function get_load_ticket()
    {
        $this->load_ticket_history();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_ticket_filtered()
    {
        $this->load_ticket_history();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_ticket_all()
    {
        $this->db->from('v_ticket');
        $this->db->join('v_customer', 'v_customer.cus_id=v_ticket.cus_id', 'left');
        if(isset($_POST['phone'])){
	        $this->db->group_start();
		        $this->db->where('v_customer.cus_phone', $_POST['phone']);
		        $this->db->or_where('v_ticket.cus_phone', $_POST['phone']);
	        $this->db->group_end();
	    }else if(isset($_POST['email'])){
	    	$this->db->group_start();
		        $this->db->where('v_customer.email', $_POST['email']);
		        $this->db->or_where('v_ticket.email', $_POST['email']);
	        $this->db->group_end();
	    }
        $this->db->where('v_ticket.type', 'NESPRESSO');
        /*if(!empty($_POST['store'])){
        	$this->db->like('store', $_POST['store']);
        }*/
        if(!empty($_POST['periode'])){
        	$date = explode(' - ',$_POST['periode']);
        	$this->db->where(array('open_date>='=>date('Y-m-d',strtotime($date[0])), 'open_date<='=>date('Y-m-d',strtotime($date[1]))));
        }
        return $this->db->count_all_results();
    }

    public function get_ticket_detail($id){
    	$query = $this->db->select('ticket_id, category, subject, open_date, open_by_name, status, curr_assign, content')->where('id', $id)->get('v_ticket', 1);
    	if($query->num_rows()>0){
    		$row = $query->row();
    		if($row->status=='OPEN' && $row->curr_assign != 0){
    			$assign = $this->db->select('groupname')->where('assign_id', $row->curr_assign)->get('v_ticket_assignment',1)->row();
    			$row->status = $row->status.' and assign to '.$assign->groupname;
    		}
    		return $row;
    	}else{
    		return array();
    	}
    }

    public function get_country(){
    	$query = $this->db->get('v_country')->result();
    	$data = array();
    	foreach ($query as $key => $value) {
    		$data[] = array('id'=>$value->id, 'text'=>$value->country);
    	}
    	return $data;
    }

    public function get_province($id=false, $is_name = false){
    	if($id!=false){
    		if($is_name){
    			$this->db->where('b.country',strtolower($id));
    		}else{
    			$this->db->where('a.country_id',$id);
    		}
    	}
    	$query = $this->db->select('a.id, a.province')->join('v_country b', 'a.country_id=b.id')->get('v_province a')->result();
    	$data = array();
    	foreach ($query as $key => $value) {
    		$data[] = array('id'=>$value->province, 'text'=>$value->province);
    	}
    	return $data;
    }

    public function get_city($id=false, $is_name = false){
    	if($id!=false){
    		if($is_name){
    			$this->db->where('b.province',strtolower($id));
    		}else{
    			$this->db->where('a.province_id',$id);
    		}
    	}
    	$query = $this->db->select('a.id, a.city')->join('v_province b', 'a.province_id=b.id')->get('v_city a')->result();
    	$data = array();
    	foreach ($query as $key => $value) {
    		$data[] = array('id'=>$value->city, 'text'=>$value->city);
    	}
    	return $data;
    }

    public function get_district($id=false, $is_name = false){
    	if($id!=false){
			if($is_name){
    			$this->db->where('b.city',strtolower($id));
    		}else{
    			$this->db->where('a.city_id',$id);
    		}
    	}
    	$query = $this->db->select('a.id, a.district')->join('v_city b', 'a.city_id=b.id')->get('v_district a')->result();
    	$data = array();
    	foreach ($query as $key => $value) {
    		$data[] = array('id'=>$value->district, 'text'=>$value->district);
    	}
    	return $data;
    }

    public function get_subsidiary(){
    	$query = $this->db->get('v_subsidiary')->result();
    	$data = array();
    	foreach ($query as $key => $value) {
    		$data[] = array('id'=>$value->brand, 'text'=>$value->brand);
    	}
    	return $data;
    }

    public function save_outgoing($data){
        $agent = $this->db->where('number', $data['ext'])->get('call_center.agent',1)->row();
        $data['agent_name'] = isset($agent->name)?$agent->name:'';
        $this->db->insert('v_outgoing_call', $data);
        return $this->db->insert_id();
    }
    public function save_return_outgoing($data){
        return $this->db->where('outgoing_id',$data['outgoing_id'])->update('v_outgoing_call', $data);
    }

    public function subcategory_info($subcat){
    	$result = $this->db->select('sub.category subcategory, cat.category, meta.meta_category, type.name')
    	->join('v_nticket_category cat', 'cat.id=sub.parent_id')
    	->join('nmeta_category meta', 'cat.meta_id=meta.id')
    	->join('v_main_category type', 'type.id=meta.calltype_id')
    	->group_start()
    	//->like('cat.category',$subcat)
    	->or_like('sub.category',$subcat)
    	->group_end()
    	->where('sub.enabled',1)->get('v_nticket_category sub')->result_array();
    	return $result;
    }
}