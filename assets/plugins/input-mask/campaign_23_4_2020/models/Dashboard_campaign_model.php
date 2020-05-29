<?php
    class Dashboard_campaign_model extends CI_Model
    {
        var $table = 'data_campaign_';

        function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        public function get_widget_values($id){
            $camp = $this->db->select('form')->where('campaign_id',$id)->get('v_campaign',1)->row();
            //$camp = $this->db->select('form')->where('campaign_id',$id)->get_compiled('v_campaign');
            $form = json_decode($camp->form,true);
            $wbval ='';
            foreach ($form as $key => $value) {
                if(isset($value['wbval'])){
                    $wbval = 'form_'.$value['name'];
                    break;
                }
            }

            $query = $this->db->query("SELECT IFNULL(SUM(IF(status='PTP',1,0)),0) as total_ptp, IFNULL(SUM(IF(status='PTP',$wbval,0)),0) as total_ptp_amount, IFNULL(SUM(IF(status='Broken Promise',1,0)),0) as total_bp, IFNULL(SUM(IF(status='Broken Promise',$wbval,0)),0) as total_bp_amount, IFNULL(SUM(IF(status='Paid',1,0)),0) as total_paid, IFNULL(SUM(IF(status='Paid',$wbval,0)),0) as total_paid_amount, IFNULL(SUM(IF(status='Paid Off',1,0)),0) as total_paidoff, IFNULL(SUM(IF(status='Paid Off',$wbval,0)),0) as total_paidoff_amount FROM ".$this->table.$id)->result();

            return $query;

        }

        public function get_agent_wb($id){
            $camp = $this->db->select('form, target_per_month')->where('campaign_id',$id)->get('v_campaign',1)->row();
            $form = json_decode($camp->form,true);
            $wbval ='';
            foreach ($form as $key => $value) {
                if(isset($value['wbval'])){
                    $wbval = 'form_'.$value['name'];
                    break;
                }
            }

            $q = $this->db->select('target_amount')->where('campaign_id', $id)->where('month', date('m/Y'))->get('v_campaign_target',1);
            $target = 0;
            if($q->num_rows()>0){
                $target = $q->row()->target_amount;
            }


            $query = $this->db->query("SELECT u.adm_name, IFNULL(SUM(dc.$wbval),0) as os_balance, SUM(IF(dc.data_id IS NOT NULL, 1, 0)) as total_account, SUM(IF(dc.status='Paid',dc.$wbval,0 )) as total_paid , SUM(IF(dc.status='Paid Off',dc.$wbval,0 )) as total_paidoff FROM v_admin u JOIN `v_assign_campaign` ac ON (u.adm_id=ac.adm_id) LEFT JOIN ".$this->table.$id." dc ON (ac.assign_id=dc.assign_id) WHERE ac.campaign_id = $id group by u.adm_ext ")->result_array();
            $data = array();

            foreach ($query as $key => $value) {
                $_data = $value;
                $_data['percentage'] = ROUND(($_data['total_paidoff']+$_data['total_paid'])/($target!=0?$target:$camp->target_per_month), 2);
                $data[] = $_data;
            }

            return $data;

        }

        function data_remaining($id){
            $this->db->select('call_center_campaign');
            $this->db->where('campaign_id',$id);            
            $call_center_campaign=$this->db->get('v_campaign')->row()->call_center_campaign;


            $this->db->select('retries');
            $this->db->where('id',$call_center_campaign);            
            $retries=$this->db->get('call_center.campaign')->row()->retries;

            //var_dump($retries);exit();
/*Select * from calls where id_campaign= 20 and status <> 'success' and retries < 5*/
            $this->db->select('count(*) as total');
            $this->db->where('id_campaign',$call_center_campaign);
            $this->db->where('retries<',$retries);              
            $this->db->where('(status<>"success" OR status is null) and dnc=0');            
            $total=$this->db->get('call_center.calls')->row()->total;


/*              $this->db->select('count(*) as total');
            $this->db->where('id_campaign',$call_center_campaign);
            $this->db->where('retries<',$retries);              
            $this->db->where('(status<>"success" OR status is null) and dnc=0');            
            $total=$this->db->from('call_center.calls')->get_compiled_select();
            var_dump($total);exit();
*/


            return $total;
        }

        function form($id){
            $camp = $this->db->select('form')->where('campaign_id',$id)->get('v_campaign',1)->row();
            //$camp = $this->db->select('form')->where('campaign_id',$id)->get_compiled('v_campaign');
            $form = json_decode($camp->form,true);
            $a=[];
            foreach ($form as $key => $value) {
                if(isset($value['call'])){
                    $a[] =  array('form' => 'form_'.$value['name']);
                }
            }
            return $a;
        }

        function reply_data(){
            //putar ulang
            $id=$_POST['campaign'];
            if($_POST['flag']==1){
                $sql="UPDATE call_center.calls c, telmark.data_campaign_$id d SET c.status = NULL, c.retries = 0 WHERE d.id_call_outgoing = c.id AND (d.status IS NULL OR d.call_status = 'Not Contacted') and c.status <> 'Success' and c.dnc=0";                
                if($this->db->query($sql)){
                    return true;
                }
                
            }
            //putar sesuai filed
            else if($_POST['flag']==2){
            $this->db->select('call_center_campaign');
            $this->db->where('campaign_id',$id);            
            $call_center_campaign=$this->db->get('v_campaign')->row()->call_center_campaign;

             $sql="UPDATE call_center.calls a, call_center.calls_contact_helper b set a.phone = b.phone WHERE a.`id_campaign` = ".$call_center_campaign." AND a.`dnc` = 0 AND (status = 'Failure' or status = 'ShortCall' or status is null or status = 'Abandoned' or status = 'NoAnswer')
              AND a.id=b.id_call_outgoing AND b.field_name = '".$_POST['field']."' AND b.phone <> '0'";
              if($this->db->query($sql)){
                    return true;
                }
            }
        }

    }
?>
