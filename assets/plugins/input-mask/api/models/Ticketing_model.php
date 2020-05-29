<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Ticketing_model extends CI_Model
{

	public function check_caller($phone, $customer, $cus_fields, $ext_fields){
		$data = array(
			'cus_fname'=>$customer['firstname'],
			'cus_lname'=>$customer['lastname'],
			'cus_phone'=>$phone,
			'external_id'=>$customer['external_id'],
			'cust_sid'=>isset($cus_fields['cust_sid'])?$cus_fields['cust_sid']:'',
			'cus_kanmo_id'=>isset($cus_fields['cust_id'])?$cus_fields['cust_id']:'',
			'address'=>isset($cus_fields['address_one'])?$cus_fields['address_one']:'',
			'address_one_home_one'=>$cus_fields['address_one_home_one'],
			'anniversary_date'=>$cus_fields['anniversary_date'],
			'birthday'=>$cus_fields['birthday'],
			'city_one'=>$cus_fields['city_one'],
			'country_origin'=>$cus_fields['country_origin'],
			'dob_mom'=>$cus_fields['dob_mom'],
			'first_sale_date'=>$cus_fields['first_sale_date'],
			'gender'=>(!empty($cus_fields['gender'])?$cus_fields['gender']:$ext_fields['gender']),
			'last_modified_date'=>$cus_fields['last_modified_date'],
			'last_sale_amount'=>$cus_fields['last_sale_amount'],
			'last_sale_date'=>$cus_fields['last_sale_date'],
			'last_twelve_mon_sale'=>$cus_fields['last_twelve_mon_sale'],
			'membership'=>$cus_fields['membership'],
			'membership_expiry'=>$cus_fields['membership_expiry'],
			'mobile_two'=>$cus_fields['mobile_two'],
			'points_balance'=>$cus_fields['points_balance'],
			'province_one'=>$cus_fields['province_one'],
			'store_name'=>$cus_fields['store_name'],
			'subsidiary'=>$cus_fields['subsidiary'],
			'title'=>$cus_fields['title'],
			'zip_code'=>$cus_fields['zip_code'],
			'last_call'=>date('Y-m-d H:i:s'),
			'registered_on'=>$customer['registered_on'],
			'registered_store'=>$customer['registered_store']['name'],
			'email'=>$customer['email'],
		);
		$query = $this->db->where('cus_phone',$phone)->get('v_customer',1);
		if($query->num_rows() > 0){
			$cus_id = $query->row()->cus_id;
			$this->db->where('cus_id',$cus_id)->update('v_customer',$data);
			return $cus_id;
		}else{
			
			$this->db->insert('v_customer', $data);
			return $this->db->insert_id();
		}
	}

	public function check_chat($phone, $customer, $cus_fields, $ext_fields){
		$data = array(
			'cus_fname'=>$customer['firstname'],
			'cus_lname'=>$customer['lastname'],
			'cus_phone'=>$phone,
			'external_id'=>$customer['external_id'],
			'cust_sid'=>isset($cus_fields['cust_sid'])?$cus_fields['cust_sid']:'',
			'cus_kanmo_id'=>isset($cus_fields['cust_id'])?$cus_fields['cust_id']:'',
			'address'=>isset($cus_fields['address_one'])?$cus_fields['address_one']:'',
			'address_one_home_one'=>$cus_fields['address_one_home_one'],
			'anniversary_date'=>$cus_fields['anniversary_date'],
			'birthday'=>$cus_fields['birthday'],
			'city_one'=>$cus_fields['city_one'],
			'country_origin'=>$cus_fields['country_origin'],
			'dob_mom'=>$cus_fields['dob_mom'],
			'first_sale_date'=>$cus_fields['first_sale_date'],
			'gender'=>(!empty($cus_fields['gender'])?$cus_fields['gender']:$ext_fields['gender']),
			'last_modified_date'=>$cus_fields['last_modified_date'],
			'last_sale_amount'=>$cus_fields['last_sale_amount'],
			'last_sale_date'=>$cus_fields['last_sale_date'],
			'last_twelve_mon_sale'=>$cus_fields['last_twelve_mon_sale'],
			'membership'=>$cus_fields['membership'],
			'membership_expiry'=>$cus_fields['membership_expiry'],
			'mobile_two'=>$cus_fields['mobile_two'],
			'points_balance'=>$cus_fields['points_balance'],
			'province_one'=>$cus_fields['province_one'],
			'store_name'=>$cus_fields['store_name'],
			'subsidiary'=>$cus_fields['subsidiary'],
			'title'=>$cus_fields['title'],
			'zip_code'=>$cus_fields['zip_code'],
			'last_call'=>date('Y-m-d H:i:s'),
			'registered_on'=>$customer['registered_on'],
			'registered_store'=>$customer['registered_store']['name'],
			'email'=>$customer['email'],
		);
		$query = $this->db->where('cus_phone',$phone)->get('whatsapp_cust',1);
		if($query->num_rows() > 0){
			$cus_id = $query->row()->cus_id;
			$this->db->where('cus_id',$cus_id)->update('whatsapp_cust',$data);
			return $cus_id;
		}else{
			
			$this->db->insert('whatsapp_cust', $data);
			return $this->db->insert_id();
		}
	}

	public function save_transaction($phone, $data){
		$query = $this->db->where('cus_phone',$phone)->get('v_customer',1);
		if($query->num_rows() > 0){
			$cus_id = $query->row()->cus_id;

			if(is_array($data) && count($data)>0){
				$this->db->where_in('transaction_id', array_keys($data));
				$this->db->update('v_transaction', array('cus_id'=>$cus_id));
			}

			$this->db->select('cus_id, transaction_id');
			if(is_array($data) && count($data)>0){
				$this->db->where_in('transaction_id', array_keys($data));
			}else{
				$this->db->where('cus_id', $cus_id);
			}
			$query = $this->db->get('v_transaction');
			if($query->num_rows()>0){
				$cus_id = 0;
				foreach ($query->result() as $value) {
					unset($data[$value->transaction_id]);
				}

			}
			foreach ($data as $key => $d) {
				$items = $d['items'];
				unset($d['items']);
				$d['cus_id'] = $cus_id;
				if($this->db->insert('v_transaction', $d)){
					$id = $this->db->insert_id();
					for ($i=0; $i<count($items); $i++) {
						$items[$i]['trans_id']=$id;
					}
					$this->db->insert_batch('v_transaction_item', $items);
				}
			}
		}
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
			$cus = array('cus_fname'=>$_POST['cus_fname'],'cus_lname'=>$_POST['cus_lname'],'cus_phone'=>$_POST['cus_phone'],'address'=>isset($_POST['address'])?$_POST['address']:'');
			$this->db->insert('v_customer', $cus);
			$_POST['cus_id'] = $this->db->insert_id();
		}

		$cc = $this->load->database('callcenter', TRUE);
		$agent = $cc->where('number', $_POST['agent'])->get('call_center.agent',1);
		if($agent->num_rows()>0){
			$_POST['open_by_name'] = $agent->row()->name;
		}

		$_POST['main_category']=$this->db->where('id', $_POST['main_category'])->get('v_main_category',1)->row()->name;
		$_POST['meta_category']=$this->db->where('id', $_POST['meta_category'])->get('nmeta_category',1)->row()->meta_category;
		$_POST['category']=$this->db->where('id', $_POST['category'])->get('v_nticket_category',1)->row()->category;


		$_POST['open_date'] = $time;
		$_POST['need_callback'] = $_POST['callback'];
		$_POST['is_read'] = 0;
		$_POST['open_by'] = $_POST['agent'];
		$_POST['type'] = 'NESPRESSO';
		if($_POST['status']=='OPEN'){
			$assign_to = isset($_POST['assign_to'])?$_POST['assign_to']:0;

		}else{
			$_POST['closed_by']=$_POST['agent'];
			$_POST['closed_by_name']=isset($_POST['open_by_name'])?$_POST['open_by_name']:$_POST['open_by'];
			$_POST['closed_date']=$time;
			$_POST['is_read']=1;
		}

		$cc = isset($_POST['cc'])?$_POST['cc']:'';
		$bcc = isset($_POST['bcc'])?$_POST['bcc']:'';

		$email_assign = $_POST['email_assign'];

		//unset($_POST['cus_phone']);
		if(isset($_POST['cphone']))
			$_POST['cphone']=empty($_POST['cphone'])?$_POST['cus_phone']:$_POST['cphone'];
		else
			$_POST['cphone']=$_POST['cus_phone'];
		unset($_POST['cc']);
		unset($_POST['bcc']);
		unset($_POST['address']);
		unset($_POST['callback']);
		unset($_POST['agent']);
		unset($_POST['assign_to']);
		unset($_POST['email_assign']);
		$flag = false;

		$wa = isset($_POST['wa'])?$_POST['wa']:0;
		unset($_POST['wa']);

		if($this->db->insert('v_ticket', $_POST)){
			$ticket_id=$this->db->insert_id();
			
			if($wa==1)
				$this->db->where(array('wa_number'=>$_POST['cphone'], 'status_chat<>'=>'closed', 'ticket_id'=>0))->update('whatsapp_chat',array('ticket_id'=>$ticket_id, 'status_chat'=>$_POST['status']));

			if($_POST['status']=='OPEN'){
				$assignment = array();
				if(!empty($assign_to)){
					$assignment = $this->db->where('id',$assign_to)->get('v_assignment_list',1)->row_array();
					$email_assign = $assignment['email'];
					$assignment['is_email'] = 0;

				}else{
					$assignment['name'] = $email_assign;
					$assignment['is_email'] = 1;
					$assignment['user_ext'] = 0;
				}
				$assign = array(
					'ticket_id'=>$ticket_id,
					'assign_by'=>$_POST['open_by'],
					'assign_by_name'=>isset($_POST['open_by_name'])?$_POST['open_by_name']:$_POST['open_by'],
					'user_id'=>$assign_to,
					'username'=>$assignment['name'],
					'user_ext'=>$assignment['user_ext'],
					'is_email'=>$assignment['is_email'],
					'assign_time'=>$time,
				);

				$email = array(
					'ticket_id'=>$_POST['ticket_id'],
					'main_category'=>$_POST['main_category'],
					'subject'=>$_POST['subject'],
					'category'=>$_POST['category'],
					'assign_by'=>isset($_POST['open_by_name'])?$_POST['open_by_name']:$_POST['open_by'],
					'assignee'=>$assignment['name'],
					'assign_time'=>date('d F Y H:i:s', strtotime($time)),
					'due_time'=>date('d F Y H:i:s', strtotime($time. ' +1 days')),
					'content'=>$_POST['content'],
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
						'cc'=>$cc,
						'bcc'=>$bcc,
						'activity'=>'Create ticket with status <label class="label label-info">OPEN</label> and assign to '.$assignment['name'].'.'.($_POST['need_callback']==1?' This ticket need callback to the customer.':''),
					);
					$flag = $this->db->insert('v_ticket_history', $history);
					if($assignment['user_ext']!=0){
						write_notif($assignment['user_ext'], 'menu=nespresso_ticket&action=detail&id='.$_POST['ticket_id'], $_POST['ticket_id'], 'Ticket <strong>'.$_POST['ticket_id'].'</strong> is assigned to you', $time);
					}
					$this->load->helper('mail');
					assign_email(array('email'=>'club.indonesia@nespresso.co.id', 'name'=>'Nespresso'), $email_assign,$email, 'nespresso', false, $cc, $bcc);
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

	/*public function depart_list(){
		$result = $this->db->get('v_department')->result();
		$data = array();
		foreach ($result as $key => $value) {
			$data[] = array('id'=>$value->depart_id, 'text'=>$value->depart_name);
		}
		return $data;
	}*/
	public function assignment_list(){
		$result = $this->db->select('id, name, email')->get('v_assignment_list')->result();
		$data = array();
		foreach ($result as $key => $value) {
			$data[] = array('id'=>$value->id, 'text'=>$value->name, 'email'=>$value->email);
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
	public function category($id){
		$result = $this->db->select('id, category')->where(array('meta_id'=>$id,'parent_id'=>0, 'enabled'=>1))->get('v_nticket_category')->result();
		$data = array();
		foreach ($result as $key => $value) {
			$data[] = array('id'=>$value->id, 'text'=>$value->category);
		}
		return $data;
	}
	public function main_category(){
		$result = $this->db->select('id, name')->get('v_main_category')->result();
		$data = array();
		foreach ($result as $key => $value) {
			$data[] = array('id'=>$value->id, 'text'=>$value->name);
		}
		return $data;
	}
	public function meta_category($id){
		$result = $this->db->select('id, meta_category')->where(array('calltype_id'=>$id))->get('nmeta_category')->result();
		$data = array();
		foreach ($result as $key => $value) {
			$data[] = array('id'=>$value->id, 'text'=>$value->meta_category);
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

	var $trans_order = array('transaction_id','type','amount', 'delivery_status','billing_time','store');
	var $trans_search = array('transaction_id','type','amount', 'delivery_status','billing_time','store');
	var $torder = array('billing_time' => 'asc');

	private function load_transaction(){
        $this->db->select(implode(',',$this->trans_order));
        $this->db->from('v_transaction');
        $this->db->join('v_customer', 'v_customer.cus_id=v_transaction.cus_id');
        $this->db->where('v_customer.cus_phone', $_POST['phone']);
        if(!empty($_POST['store'])){
        	$this->db->like('store', $_POST['store']);
        }
        if(!empty($_POST['periode'])){
        	$date = explode(' - ',$_POST['periode']);
        	$this->db->where(array('billing_time>='=>date('Y-m-d',strtotime($date[0])), 'billing_time<='=>date('Y-m-d',strtotime($date[1]))));
        }
		$i = 0;
		foreach ($this->trans_search as $item) {
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
 
                if(count($this->trans_search) - 1 == $i)
                $this->db->group_end();
            }
            $i++;
		}

		if(isset($_POST['order']))
        {
            $this->db->order_by($this->trans_order[$_POST['order']['0']['column']-1], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->torder))
        {
            $order = $this->torder;
            $this->db->order_by(key($order), $order[key($order)]);
        }
	}

	public function get_load_trans()
    {
        $this->load_transaction();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_trans_filtered()
    {
        $this->load_transaction();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_trans_all()
    {
        $this->db->from('v_transaction');
        $this->db->join('v_customer', 'v_customer.cus_id=v_transaction.cus_id');
        $this->db->where('v_customer.cus_phone', $_POST['phone']);
        if(!empty($_POST['store'])){
        	$this->db->like('store', $_POST['store']);
        }
        if(!empty($_POST['periode'])){
        	$date = explode(' - ',$_POST['periode']);
        	$this->db->where(array('billing_time>='=>date('Y-m-d',strtotime($date[0])), 'billing_time<='=>date('Y-m-d',strtotime($date[1]))));
        }
        return $this->db->count_all_results();
    }


	var $items_order = array('item_code','type','description', 'qty','rate','discount', 'amount', 'value');
	var $items_search = array('item_code','type','description', 'qty','rate','discount', 'amount', 'value');
	var $iorder = array('item_code' => 'asc');

	private function load_items(){
		$trans = $this->db->select('id')->where('transaction_id',$_POST['trans_id'])->get('v_transaction',1)->row(); 
        $this->db->select(implode(',',$this->items_order));
        $this->db->from('v_transaction_item');
        $this->db->where('trans_id', $trans->id);
		$i = 0;
		foreach ($this->items_search as $item) {
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
 
                if(count($this->items_search) - 1 == $i)
                $this->db->group_end();
            }
            $i++;
		}

		if(isset($_POST['order']))
        {
            $this->db->order_by($this->items_order[$_POST['order']['0']['column']-1], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->iorder))
        {
            $order = $this->iorder;
            $this->db->order_by(key($order), $order[key($order)]);
        }
	}

	public function get_load_items()
    {
        $this->load_items();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_items_filtered()
    {
        $this->load_items();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_items_all()
    {
    	$trans = $this->db->select('id')->where('transaction_id',$_POST['trans_id'])->get('v_transaction',1)->row(); 
        $this->db->from('v_transaction_item');
        $this->db->where('trans_id', $trans->id);
        return $this->db->count_all_results();
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