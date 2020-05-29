<?php

$table = $argv[1];
$path = $argv[2];
$mdname = $argv[3];

$path = __DIR__.'/'.trim($path,'/').'/';

if(!is_dir($path)){
	echo 'ERROR: Path doesn\'t exist';
	exit;
}
if(is_dir($path.strtolower($mdname))){
	echo 'ERROR: Path is exist';
	exit;
}else{
    $path = $path.strtolower($mdname);
    echo 'Creating directory '.$path;
    mkdir($path);
    echo 'Creating directory '.$path.'/controllers';
    mkdir($path.'/controllers');
    echo 'Creating directory '.$path.'/models';
    mkdir($path.'/models');
    echo 'Creating directory '.$path.'/views';
	mkdir($path.'/views');
}

$host = 'localhost';
$user = 'root';
$pass = 'dut4_MEDIA';
$dbname = 'outbound';

$mysqli = new mysqli($host, $user, $pass, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
} 

$sql = "DESC ".$table;
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $data = array();
    while($row = $result->fetch_assoc()) {
        echo "Field: " . $row["Field"]. " - Type: " . $row["Type"]. " - Null: " . $row["Null"]. " - Key: " . $row['Key']. PHP_EOL;
        $data[] = $row;
    }
    echo 'Creating controller'.PHP_EOL;
    controller($data, $path, $mdname);
    echo 'Creating model'.PHP_EOL;
    model($table, $data, $path, $mdname);
    echo 'Creating view'.PHP_EOL;
    view($data, $path, $mdname);
    echo 'Creating view insert'.PHP_EOL;
    view_insert($data, $path, $mdname);
    echo 'Creating view edit'.PHP_EOL;
    view_edit($data, $path, $mdname);
    echo 'Creating view detail'.PHP_EOL;
    view_detail($data, $path, $mdname);
    echo 'Done'.PHP_EOL;
} else {
    echo "0 results";
}
$mysqli->close();


function controller($data, $path, $mdname){
    $id = 0;
    $_data = array();
    foreach ($data as $key => $d) {
        if($d['Key']=='PRI'){
            $id = $d['Field'];
        }else{
            $_data[] = $d['Field'];
        }
    }
    $html[] = '<?php';
    $html[] = 'defined(\'BASEPATH\') OR exit(\'No direct script access allowed\');';
    $html[] = '';
    $html[] = 'class '.$mdname.' extends MX_Controller {';
    $html[] = '';
    $html[] = '';
    $html[] = '   public function __construct(){';
    $html[] = '       if(!isset($this->session->userdata[\'logged_in\'])){';
    $html[] = '           redirect(base_url(\'panel/login\'));';
    $html[] = '       }';
    $html[] = '       $this->menu = $this->menu_model->load_menu(\'admin\', \''.strtolower($mdname).'\');';
    $html[] = '       $this->load->library(\'form_validation\');';
    $html[] = '       $this->load->model(\''.strtolower($mdname).'_model\');';
    $html[] = '   }';
    $html[] = '   ';
    $html[] = '   public function index(){';
    $html[] = '       $auth = $this->template->set_auth($this->menu[\'rule\'][\'panel/'.strtolower($mdname).'\'][\'v\']);';
    $html[] = '       if($_POST && $auth){';
    $html[] = '           $list = $this->'.strtolower($mdname).'_model->get_load();';
    $html[] = '           $data = array();';
    $html[] = '           $no = $_POST[\'start\'];';
    $html[] = '           foreach ($list as $item) {';
    $html[] = '               $no++;';
    $html[] = '               $row = array();';
    $html[] = '               $row[] = $item->'.$id.';';
    $html[] = '               $row[] = $no;';
    foreach ($_data as $key => $value) {
    $html[] = '               $row[] = $item->'.$value.';';
    }
    $html[] = '               $data[] = $row;';
    $html[] = '           }';
    $html[] = '           ';
    $html[] = '           $output = array(';
    $html[] = '                           \'draw\' => $_POST[\'draw\'],';
    $html[] = '                           \'recordsTotal\' => $this->'.strtolower($mdname).'_model->count_all(),';
    $html[] = '                           \'recordsFiltered\' => $this->'.strtolower($mdname).'_model->count_filtered(),';
    $html[] = '                           \'data\' => $data';
    $html[] = '                      );';
    $html[] = '           ';
    $html[] = '           echo json_encode($output);';
    $html[] = '       }else{';
    $html[] = '           $data[\'menu\'] = $this->menu;';
    $html[] = '           $data[\'rules\'] = $this->menu[\'rule\'][\'panel/'.strtolower($mdname).'\'];';
    $html[] = '           $this->template->view(\'view_'.strtolower($mdname).'\', $data);';
    $html[] = '       }';
    $html[] = '   }';
    $html[] = '   ';
    $html[] = '   public function insert(){';
    $html[] = '       $auth = $this->template->set_auth($this->menu[\'rule\'][\'panel/'.strtolower($mdname).'\'][\'c\']);';
    $html[] = '       if($_POST && $auth){';
    foreach ($data as $key => $d) {
        if($d['Null']=='NO'&&$d['Key']!='PRI'){
    $html[] = '           $this->form_validation->set_rules(\''.$d['Field'].'\', \''.ucwords(str_replace('_',' ',$d['Field'])).'\', \'required\');';
        }
    }
    $html[] = '           if ($this->form_validation->run() == false){';
    $html[] = '               $data[\'status\'] = false;';
    foreach ($data as $key => $d) {
        if($d['Null']=='NO'&&$d['Key']!='PRI'){
    $html[] = '               $data[\'e\'][\''.$d['Field'].'\']=form_error(\''.$d['Field'].'\', \'<div class="has-error">\', \'</div>\');';
        }
    }
    $html[] = '               echo json_encode($data);';
    $html[] = '           }else{';
    $html[] = '               if($this->'.strtolower($mdname).'_model->insert()){';
    $html[] = '                   echo json_encode(array(\'status\'=>true));';
    $html[] = '               }else{';
    $html[] = '                   echo json_encode(array(\'status\'=>false, \'msg\'=>\'FAILED INSERTING DATA\'));';
    $html[] = '               }';
    $html[] = '           }';
    $html[] = '       }else{';
    $html[] = '           $data[\'menu\'] = $this->menu;';
    $html[] = '           $this->template->view(\'view_'.strtolower($mdname).'_insert\', $data);';
    $html[] = '       }';
    $html[] = '   }';
    $html[] = '   ';
    $html[] = '   public function detail($id){';
    $html[] = '       $data[\'menu\'] = $this->menu;';
    $html[] = '       if($this->template->set_auth($this->menu[\'rule\'][\'panel/'.strtolower($mdname).'\'][\'v\'])){';
    $html[] = '           $data[\'data\'] = $this->'.strtolower($mdname).'_model->detail($id);';
    $html[] = '       }';
    $html[] = '       $this->template->view(\'view_'.strtolower($mdname).'_detail\', $data);';
    $html[] = '   }';
    $html[] = '   ';
    $html[] = '   public function edit($id){';
    $html[] = '       $auth = $this->template->set_auth($this->menu[\'rule\'][\'panel/'.strtolower($mdname).'\'][\'e\']);';
    $html[] = '       if($_POST && $auth){';
    foreach ($data as $key => $d) {
        if($d['Null']=='NO'&&$d['Key']!='PRI'){
    $html[] = '           $this->form_validation->set_rules(\''.$d['Field'].'\', \''.ucwords(str_replace('_',' ',$d['Field'])).'\', \'required\');';
        }
    }
    $html[] = '           if ($this->form_validation->run() == false){';
    $html[] = '               $data[\'status\'] = false;';
    foreach ($data as $key => $d) {
        if($d['Null']=='NO'&&$d['Key']!='PRI'){
    $html[] = '               $data[\'e\'][\''.$d['Field'].'\']=form_error(\''.$d['Field'].'\', \'<div class="has-error">\', \'</div>\');';
        }
    }
    $html[] = '               echo json_encode($data);';
    $html[] = '           }else{';
    $html[] = '               if($this->'.strtolower($mdname).'_model->update($id)){';
    $html[] = '                   echo json_encode(array(\'status\'=>true));';
    $html[] = '               }else{';
    $html[] = '                   echo json_encode(array(\'status\'=>false, \'msg\'=>\'FAILED EDITING DATA\'));';
    $html[] = '               }';
    $html[] = '           }';
    $html[] = '       }else{';
    $html[] = '           $data[\'menu\'] = $this->menu;';
    $html[] = '           $data[\'data\'] = $this->'.strtolower($mdname).'_model->find_id($id);';
    $html[] = '           $this->template->view(\'view_'.strtolower($mdname).'_edit\', $data);';
    $html[] = '       }';
    $html[] = '   }';
    $html[] = '   ';
    $html[] = '   public function delete(){';
    $html[] = '       $auth = $this->template->set_auth($this->menu[\'rule\'][\'panel/'.strtolower($mdname).'\'][\'d\']);';
    $html[] = '       if($auth){';
    $html[] = '           if($this->'.strtolower($mdname).'_model->delete()){';
    $html[] = '               echo json_encode(array(\'status\'=>true));';
    $html[] = '           }else{';
    $html[] = '               echo json_encode(array(\'status\'=>false));';
    $html[] = '           }';
    $html[] = '       }';
    $html[] = '   }';
    $html[] = '}';

    $f=fopen($path.'/controllers/'.$mdname.'.php','w');
    fwrite($f,implode(PHP_EOL, $html));
    fclose($f);

}

function model($table, $data, $path, $mdname){
    $id = 0;
    $_data = array();
    $field = array();
    foreach ($data as $key => $d) {
        if($d['Key']=='PRI'){
            $id = $d['Field'];
        }else{
            $_data[] = $d['Field'];
        }
        $field[] = $d['Field'];
    }
    $html[] = '<?php';
    $html[] = '';
    $html[] = 'class '.$mdname.'_model extends CI_Model {';
    $html[] = '';
    $html[] = '   private $pref = \'\';';
    $html[] = '   var $table = \''.$table.'\';';
    $html[] = '   var $column_order = array(\''.implode("', '",$field).'\');';
    $html[] = '   var $column_search = array(\''.implode("', '",$field).'\');';
    $html[] = '   var $order = array(\''.$id.'\' => \'asc\');';
    $html[] = '';
    $html[] = '   public function __construct(){';
    $html[] = '       parent::__construct();';
    $html[] = '       $this->load->database();';
    //$html[] = '       $this->pref = $this->config->item(\'tb_pref\');';
    $html[] = '       $this->table = $this->pref.$this->table;';
    $html[] = '   }';
    $html[] = '   ';
    $html[] = '   private function load(){';
    $html[] = '       $this->db->select(\''.implode(', ',$field).'\');';
    $html[] = '       $this->db->from($this->table);';
    $html[] = '       $i = 0;';
    $html[] = '       foreach ($this->column_search as $item) {';
    $html[] = '           if($_POST[\'search\'][\'value\']){';
    $html[] = '               if($i===0){';
    $html[] = '                   $this->db->group_start();';
    $html[] = '                   $this->db->like($item, $_POST[\'search\'][\'value\']);';
    $html[] = '               }else{';
    $html[] = '                   $this->db->or_like($item, $_POST[\'search\'][\'value\']);';
    $html[] = '               }';
    $html[] = '               ';
    $html[] = '               if(count($this->column_search) - 1 == $i)';
    $html[] = '                   $this->db->group_end();';
    $html[] = '               ';
    $html[] = '           }';
    $html[] = '           $i++;';
    $html[] = '       }';
    $html[] = '       ';
    $html[] = '       if(isset($_POST[\'order\'])){';
    $html[] = '           $this->db->order_by($this->column_order[$_POST[\'order\'][\'0\'][\'column\']-1], $_POST[\'order\'][\'0\'][\'dir\']);';
    $html[] = '       }else if(isset($this->order)){';
    $html[] = '           $order = $this->order;';
    $html[] = '           $this->db->order_by(key($order), $order[key($order)]);';
    $html[] = '       }';
    $html[] = '   }';
    $html[] = '   ';
    $html[] = '   public function get_load(){';
    $html[] = '       $this->load();';
    $html[] = '       if($_POST[\'length\'] != -1)';
    $html[] = '           $this->db->limit($_POST[\'length\'], $_POST[\'start\']);';
    $html[] = '       $query = $this->db->get();';
    $html[] = '       return $query->result();';
    $html[] = '   }';
    $html[] = '';
    $html[] = '   public function count_filtered(){';
    $html[] = '       $this->load();';
    $html[] = '       $query = $this->db->get();';
    $html[] = '       return $query->num_rows();';
    $html[] = '   }';
    $html[] = '   ';
    $html[] = '   public function count_all(){';
    $html[] = '       $this->db->from($this->table);';
    $html[] = '       return $this->db->count_all_results();';
    $html[] = '   }';
    $html[] = '   ';
    $html[] = '   public function find_id($id){';
    $html[] = '       $this->db->where(\''.$id.'\', $id);';
    $html[] = '       $query = $this->db->get($this->table, 1);';
    $html[] = '       return $query->row();';
    $html[] = '   }';
    $html[] = '   ';
    $html[] = '   public function detail($id){';
    $html[] = '       $this->db->where(\''.$id.'\', $id);';
    $html[] = '       $query = $this->db->get($this->table, 1);';
    $html[] = '       return $query->row();';
    $html[] = '   }';
    $html[] = '   ';
    $html[] = '   public function insert(){';
    $html[] = '       return $this->db->insert($this->table, $_POST);';
    $html[] = '   }';
    $html[] = '   ';
    $html[] = '   public function update($id){';
    $html[] = '       $this->db->where(\''.$id.'\', $id);';
    $html[] = '       return $this->db->update($this->table, $_POST);';
    $html[] = '   }';
    $html[] = '   ';
    $html[] = '   public function delete(){';
    $html[] = '       $this->db->where(\''.$id.'\', $_POST[\'id\']);';
    $html[] = '       return $this->db->delete($this->table);';
    $html[] = '   }';
    $html[] = '}';

    $f=fopen($path.'/models/'.$mdname.'_model.php','w');
    fwrite($f,implode(PHP_EOL, $html));
    fclose($f);

}

function view($data, $path, $mdname){
    $id = 0;
    $_data = array();
    $field = array();
    foreach ($data as $key => $d) {
        if($d['Key']=='PRI'){
            $id = $d['Field'];
        }else{
            $_data[] = $d['Field'];
        }
        $field[] = $d['Field'];
    }
    $html[] = '<?php';
    $html[] = 'defined(\'BASEPATH\') OR exit(\'No direct script access allowed\');';
    $html[] = '?>';
    $html[] = '<div class="content-wrapper">';
    $html[] = '   <section class="content-header">';
    $html[] = '       <h1>'.ucwords(str_replace('_',' ',$mdname)).'<small></small></h1>';
    $html[] = '       <ol class="breadcrumb">';
    $html[] = '           <li><a href="<?= base_url(\'panel\');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>';
    $html[] = '           <li><a href="<?= base_url(\'panel/'.strtolower($mdname).'\');?>">'.ucwords(str_replace('_',' ',$mdname)).'</a></li>';
    $html[] = '           <li class="active">Insert</li>';
    $html[] = '       </ol>';
    $html[] = '   </section>';
    $html[] = '   <section class="content">';
    $html[] = '       <div class="row">';
    $html[] = '           <div class="col-xs-12">';
    $html[] = '               <div class="box">';
    $html[] = '                   <div class="box-header">';
    $html[] = '                       <h3 class="box-title">'.ucwords(str_replace('_',' ',$mdname)).'</h3>';
    $html[] = '                       <div class="action pull-right">';
    $html[] = '                           <?php if($rules[\'d\']){?>';
    $html[] = '                               <a id="delete-all" title="Delete selected data" class="btn btn-danger btn-sm btn-circle"><i class="fa fa-trash"></i></a>';
    $html[] = '                           <?php }?>';
    $html[] = '                           <?php if($rules[\'c\']){?>';
    $html[] = '                               <a href="<?=base_url(\'panel/'.strtolower($mdname).'/insert\');?>" class="btn btn-success btn-sm btn-circle"><i class="fa fa-plus"></i> Insert</a>';
    $html[] = '                           <?php }?>';
    $html[] = '                       </div>';
    $html[] = '                   </div>';
    $html[] = '                   <div class="box-body">';
    $html[] = '                       <table id="'.strtolower($mdname).'_table" class="table table-bordered table-striped">';
    $html[] = '                           <thead>';
    $html[] = '                               <tr>';
    $html[] = '                                   <th width="20px"></th>';
    $html[] = '                                   <th width="40px;">No</th>';
    foreach ($_data as $key => $value) {
    $html[] = '                                   <th>'.ucwords(str_replace('_',' ',$value)).'</th>';
    }
    $html[] = '                                   <th width="210px;"></th>';
    $html[] = '                               </tr>';
    $html[] = '                           </thead>';
    $html[] = '                       </table>';
    $html[] = '                   </div>';
    $html[] = '               </div>';
    $html[] = '           </div>';
    $html[] = '       </div>';
    $html[] = '   </section>';
    $html[] = '</div>';
    $html[] = '<script src="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.js"></script>';
    $html[] = '<script type="text/javascript">';
    $html[] = '   function remove(id){';
    $html[] = '       if (confirm( "Are you sure you want to delete the selected '.strtolower(str_replace('_', ' ', $mdname)).'?" )) {';
    $html[] = '           $.ajax({';
    $html[] = '               url : \'<?php echo base_url("panel/'.strtolower($mdname).'/delete"); ?>\',';
    $html[] = '               type: "POST",';
    $html[] = '               data : {\'id\':[id]},';
    $html[] = '               dataType: \'json\',';
    $html[] = '               success:function(data, textStatus, jqXHR){';
    $html[] = '                   if(data.status){';
    $html[] = '                       $().toastmessage(\'showToast\', {';
    $html[] = '                           text     : \'Delete data success\',';
    $html[] = '                           position : \'top-center\',';
    $html[] = '                           type     : \'success\',';
    $html[] = '                           close    : function () {';
    $html[] = '                               location.reload();';
    $html[] = '                           }';
    $html[] = '                        });';
    $html[] = '                    }';
    $html[] = '               },';
    $html[] = '               error: function(jqXHR, textStatus, errorThrown){';
    $html[] = '               }';
    $html[] = '           });';
    $html[] = '       }';
    $html[] = '   }';
    $html[] = '   ';
    $html[] = '   $(document).ready(function(){';
    $html[] = '       $(\'#'.strtolower($mdname).'_table\').dataTable({';
    $html[] = '           "aLengthMenu":  [10, 25, 50, 100, 500, 1000, 2500, 5000],';
    $html[] = '           "ajax": {';
    $html[] = '               "url": "<?php echo base_url(\'panel/'.strtolower($mdname).'\'); ?>",';
    $html[] = '               "type": "POST"';
    $html[] = '           },';
    $html[] = '           "aaSorting": [[ 1, "desc" ]],';
    $html[] = '           "searching": true,';
    $html[] = '           "paging": true,';
    $html[] = '           "bFilter": false,';
    $html[] = '           "bStateSave": true,';
    $html[] = '           "bServerSide": true,';
    $html[] = '           "sPaginationType": "full_numbers",';
    $html[] = '           "aoColumnDefs": [';
    $html[] = '               { "title":"<input type=\'checkbox\' class=\'check-all\'></input>","sClass": "center","aTargets":[0],';
    $html[] = '                   "render": function(data, type, full){';
    $html[] = '                       return \'<input type="checkbox" class="check-item" value="\'+full[0]+\'">\';';
    $html[] = '                   },';
    $html[] = '                   "bSortable": false';
    $html[] = '               },';
    $html[] = '               { "sClass": "center", "aTargets": [ 1 ], "data":1 },';
    $i=0;
    for ($i; $i<count($_data); $i++) {
        $html[] = '               { "sClass": "center", "aTargets": [ '.($i+2).' ], "data":'.($i+2).' },';
    }
    $html[] = '           { "sClass": "center", "aTargets": [ '.($i+2).' ],';
    $html[] = '               "mRender": function(data, type, full) {';
    $html[] = '                   return \'<a href=<?=base_url(\'panel/'.strtolower($mdname).'/detail\');?>/\' + full[0]';
    $html[] = '                       + \' class="btn btn-default btn-xs btn-col icon-black"><i class="fa fa-search"></i> Detail\'';
    $html[] = '                       <?php if($rules[\'e\']){?>';
    $html[] = '                       + \'</a>\'+\'<a href=<?=base_url(\'panel/'.strtolower($mdname).'/edit\');?>/\' + full[0]';
    $html[] = '                       + \' class="btn btn-info btn-xs btn-col icon-green"><i class="fa fa-pencil"></i> Edit\'';
    $html[] = '                       <?php }?>';
    $html[] = '                       <?php if($rules[\'d\']){?>';
    $html[] = '                       + \'</a><a href="javascript:;" onclick="remove(\\\'\' + full[0] + \'\\\');" id="btn-delete" class="btn btn-danger btn-xs btn-col icon-black"><i class="fa fa-close"></i> Delete\' ';
    $html[] = '                       <?php }?>';
    $html[] = '                       + \'</a>\';';
    $html[] = '           },';
    $html[] = '           "bSortable": false';
    $html[] = '       },';
    $html[] = '       ]';
    $html[] = '   });';
    $html[] = '   ';
    $html[] = '   $(\'.check-all\').change(function(){';
    $html[] = '       $(\'.check-item\').prop(\'checked\', $(this).prop(\'checked\'));';
    $html[] = '   });';
    $html[] = '   ';
    $html[] = '   $(\'#delete-all\').click(function(){';
    $html[] = '       if (confirm( \'Are you sure you want to delete the selected '.strtolower(str_replace('_', ' ', $mdname)).'?\' )) {';
    $html[] = '           var data = {};';
    $html[] = '           var id = [];';
    $html[] = '           if($(\'.check-item:checked\').length<1){';
    $html[] = '               $().toastmessage(\'showToast\', {';
    $html[] = '                   text     : "Delete failed, you don\'t select any data.",';
    $html[] = '                   sticky   : false,';
    $html[] = '                   position : \'top-center\',';
    $html[] = '                   type     : \'error\',';
    $html[] = '               });';
    $html[] = '               return false;';
    $html[] = '           }';
    $html[] = '           $(\'.check-item:checked\').each(function(idx, el){';
    $html[] = '               id.push(parseInt($(el).val()));';
    $html[] = '           });';
    $html[] = '           data.id = id;';
    $html[] = '           $.ajax({';
    $html[] = '               url : \'<?php echo base_url("panel/'.strtolower($mdname).'/delete"); ?>\',';
    $html[] = '               type: "POST",';
    $html[] = '               data : data,';
    $html[] = '               dataType: \'json\',';
    $html[] = '               success:function(data, textStatus, jqXHR){';
    $html[] = '                   if(data.status){';
    $html[] = '                       $().toastmessage(\'showToast\', {';
    $html[] = '                           text     : \'Delete data success\',';
    $html[] = '                           position : \'top-center\',';
    $html[] = '                           type     : \'success\',';
    $html[] = '                           close    : function () {';
    $html[] = '                               location.reload();';
    $html[] = '                           }';
    $html[] = '                       });';
    $html[] = '                   }else{console.log(data);}';
    $html[] = '               },';
    $html[] = '               error: function(jqXHR, textStatus, errorThrown){';
    $html[] = '                   alert(\'Error,something goes wrong\');';
    $html[] = '               }';
    $html[] = '           });';
    $html[] = '       }';
    $html[] = '   });';
    $html[] = '});';
    $html[] = '</script>';
    $f=fopen($path.'/views/view_'.strtolower($mdname).'.php','w');
    fwrite($f,implode(PHP_EOL, $html));
    fclose($f);
}

function view_insert($data, $path, $mdname){
    $id = 0;
    $_data = array();
    $field = array();
    foreach ($data as $key => $d) {
        if($d['Key']=='PRI'){
            $id = $d['Field'];
        }else{
            $_data[] = $d['Field'];
        }
        $field[] = $d['Field'];
    }
    $html[] = '<?php';
    $html[] = 'defined(\'BASEPATH\') OR exit(\'No direct script access allowed\');';
    $html[] = '?>';
    $html[] = '<div class="content-wrapper">';
    $html[] = '   <section class="content-header">';
    $html[] = '       <h1>'.ucwords(str_replace('_',' ',$mdname)).'<small></small></h1>';
    $html[] = '       <ol class="breadcrumb">';
    $html[] = '           <li><a href="<?= base_url(\'panel\');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>';
    $html[] = '           <li><a href="<?= base_url(\'panel/'.strtolower($mdname).'\');?>">'.ucwords(str_replace('_',' ',$mdname)).'</a></li>';
    $html[] = '           <li class="active">Insert</li>';
    $html[] = '       </ol>';
    $html[] = '   </section>';
    $html[] = '   <section class="content">';
    $html[] = '       <div class="row">';
    $html[] = '           <div class="col-xs-12">';
    $html[] = '               <div class="box">';
    $html[] = '                   <div class="box-header">';
    $html[] = '                       <h3 class="box-title">Insert '.$mdname.'</h3>';
    $html[] = '                   </div>';
    $html[] = '                   <form class="form-horizontal" method="post" id="'.strtolower($mdname).'_form">';
    $html[] = '                   <div class="box-body">';
    foreach ($data as $key => $v) {
        if($v['Key']=='PRI'){

        }else{
    $html[] = '                       <div class="form-group">';
    $html[] = '                           <label class="col-sm-2 control-label" for="'.strtolower($v['Field']).'">'.ucwords(str_replace('_',' ',$v['Field'])).' '.($v['Null']=='NO'?'<span class="red">*</span>':'').'</label>';
    $html[] = '                           <div class="col-sm-5">';
    $html[] = '                               <input type="text" placeholder="'.ucwords(str_replace('_',' ',$v['Field'])).'" name="'.strtolower($v['Field']).'" id="'.strtolower($v['Field']).'" class="form-control">';
    $html[] = '                               <span class="info"></span>';
    $html[] = '                           </div>';
    $html[] = '                       </div>';
        }
    }
    $html[] = '                   </div>';
    $html[] = '                   <div class="box-footer">';
    $html[] = '                       <div class="col-md-2 col-sm-offset-2">';
    $html[] = '                           <a href="#" onclick="window.history.back()" class="btn btn-default">Back</a>';
    $html[] = '                           <button id = "enter" class="btn btn-primary pull-right" type="submit">Enter</button>';
    $html[] = '                       </div>';
    $html[] = '                   </div>';
    $html[] = '                   </form>';
    $html[] = '               </div>';
    $html[] = '           </div>';
    $html[] = '       </div>';
    $html[] = '   </section>';
    $html[] = '</div>';
    $html[] = '<script type="text/javascript">';
    $html[] = '   $(document).ready(function(){';
    $html[] = '       $(\'form#'.strtolower($mdname).'_form\').on(\'submit\', function(e) {';
    $html[] = '           e.preventDefault();';
    $html[] = '           $.ajax({';
    $html[] = '               url : \'<?php echo current_url(); ?>\',';
    $html[] = '               type: "POST",';
    $html[] = '               data : $(\'#'.strtolower($mdname).'_form\').serialize(),';
    $html[] = '               dataType: \'json\',';
    $html[] = '               success:function(data, textStatus, jqXHR){';
    $html[] = '                   if(!data.status){';
    $html[] = '                       $.each(data.e, function(key, val){';
    $html[] = '                           $(\'[name="\'+key+\'"]\').closest(\'.form-group\').find(\'.info\').html(val);';
    $html[] = '                       });';
    $html[] = '                   }else{';
    $html[] = '                       $().toastmessage(\'showToast\', {';
    $html[] = '                           text     : \'Insert data success\',';
    $html[] = '                           position : \'top-center\',';
    $html[] = '                           type     : \'success\',';
    $html[] = '                           close    : function () {';
    $html[] = '                               window.location = "<?=base_url(\'panel/'.strtolower($mdname).'\');?>";';
    $html[] = '                           }';
    $html[] = '                       });';
    $html[] = '                   }';
    $html[] = '               },';
    $html[] = '               error: function(jqXHR, textStatus, errorThrown){';
    $html[] = '                   alert(\'Error,something goes wrong\');';
    $html[] = '               }';
    $html[] = '           });';
    $html[] = '       });';
    $html[] = '   });';
    $html[] = '</script>';
    $f=fopen($path.'/views/view_'.strtolower($mdname).'_insert.php','w');
    fwrite($f,implode(PHP_EOL, $html));
    fclose($f);
}

function view_edit($data, $path, $mdname){
    $id = 0;
    $_data = array();
    $field = array();
    foreach ($data as $key => $d) {
        if($d['Key']=='PRI'){
            $id = $d['Field'];
        }else{
            $_data[] = $d['Field'];
        }
        $field[] = $d['Field'];
    }
    $html[] = '<?php';
    $html[] = 'defined(\'BASEPATH\') OR exit(\'No direct script access allowed\');';
    $html[] = '?>';
    $html[] = '<div class="content-wrapper">';
    $html[] = '   <section class="content-header">';
    $html[] = '       <h1>'.ucwords(str_replace('_',' ',$mdname)).'<small></small></h1>';
    $html[] = '       <ol class="breadcrumb">';
    $html[] = '           <li><a href="<?= base_url(\'panel\');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>';
    $html[] = '           <li><a href="<?= base_url(\'panel/'.strtolower($mdname).'\');?>">'.ucwords(str_replace('_',' ',$mdname)).'</a></li>';
    $html[] = '           <li class="active">Edit</li>';
    $html[] = '       </ol>';
    $html[] = '   </section>';
    $html[] = '   <section class="content">';
    $html[] = '       <div class="row">';
    $html[] = '           <div class="col-xs-12">';
    $html[] = '               <div class="box">';
    $html[] = '                   <div class="box-header">';
    $html[] = '                       <h3 class="box-title">Edit '.$mdname.'</h3>';
    $html[] = '                   </div>';
    $html[] = '                   <form class="form-horizontal" method="post" id="'.strtolower($mdname).'_form">';
    $html[] = '                   <div class="box-body">';
    foreach ($data as $key => $v) {
        if($v['Key']=='PRI'){

        }else{
    $html[] = '                       <div class="form-group">';
    $html[] = '                           <label class="col-sm-2 control-label" for="'.strtolower($v['Field']).'">'.ucwords(str_replace('_',' ',$v['Field'])).' '.($v['Null']=='NO'?'<span class="red">*</span>':'').'</label>';
    $html[] = '                           <div class="col-sm-5">';
    $html[] = '                               <input type="text" placeholder="'.ucwords(str_replace('_',' ',$v['Field'])).'" name="'.strtolower($v['Field']).'" id="'.strtolower($v['Field']).'" class="form-control" value="<?=$data->'.strtolower($v['Field']).'?>">';
    $html[] = '                               <span class="info"></span>';
    $html[] = '                           </div>';
    $html[] = '                       </div>';
        }
    }
    $html[] = '                   </div>';
    $html[] = '                   <div class="box-footer">';
    $html[] = '                       <div class="col-md-2 col-sm-offset-2">';
    $html[] = '                           <a href="#" onclick="window.history.back()" class="btn btn-default">Back</a>';
    $html[] = '                           <button id = "enter" class="btn btn-primary pull-right" type="submit">Enter</button>';
    $html[] = '                       </div>';
    $html[] = '                   </div>';
    $html[] = '                   </form>';
    $html[] = '               </div>';
    $html[] = '           </div>';
    $html[] = '       </div>';
    $html[] = '   </section>';
    $html[] = '</div>';
    $html[] = '<script type="text/javascript">';
    $html[] = '   $(document).ready(function(){';
    $html[] = '       $(\'form#'.strtolower($mdname).'_form\').on(\'submit\', function(e) {';
    $html[] = '           e.preventDefault();';
    $html[] = '           $.ajax({';
    $html[] = '               url : \'<?php echo current_url(); ?>\',';
    $html[] = '               type: "POST",';
    $html[] = '               data : $(\'#'.strtolower($mdname).'_form\').serialize(),';
    $html[] = '               dataType: \'json\',';
    $html[] = '               success:function(data, textStatus, jqXHR){';
    $html[] = '                   if(!data.status){';
    $html[] = '                       $.each(data.e, function(key, val){';
    $html[] = '                           $(\'[name="\'+key+\'"]\').closest(\'.form-group\').find(\'.info\').html(val);';
    $html[] = '                       });';
    $html[] = '                   }else{';
    $html[] = '                       $().toastmessage(\'showToast\', {';
    $html[] = '                           text     : \'Insert data success\',';
    $html[] = '                           position : \'top-center\',';
    $html[] = '                           type     : \'success\',';
    $html[] = '                           close    : function () {';
    $html[] = '                               window.location = "<?=base_url(\'panel/'.strtolower($mdname).'\');?>";';
    $html[] = '                           }';
    $html[] = '                       });';
    $html[] = '                   }';
    $html[] = '               },';
    $html[] = '               error: function(jqXHR, textStatus, errorThrown){';
    $html[] = '                   alert(\'Error,something goes wrong\');';
    $html[] = '               }';
    $html[] = '           });';
    $html[] = '       });';
    $html[] = '   });';
    $html[] = '</script>';
    $f=fopen($path.'/views/view_'.strtolower($mdname).'_edit.php','w');
    fwrite($f,implode(PHP_EOL, $html));
    fclose($f);
}

function view_detail($data, $path, $mdname){
    $id = 0;
    $_data = array();
    $field = array();
    foreach ($data as $key => $d) {
        if($d['Key']=='PRI'){
            $id = $d['Field'];
        }else{
            $_data[] = $d['Field'];
        }
        $field[] = $d['Field'];
    }
    $html[] = '<?php';
    $html[] = 'defined(\'BASEPATH\') OR exit(\'No direct script access allowed\');';
    $html[] = '?>';
    $html[] = '<div class="content-wrapper">';
    $html[] = '   <section class="content-header">';
    $html[] = '       <h1>'.ucwords(str_replace('_',' ',$mdname)).'<small></small></h1>';
    $html[] = '       <ol class="breadcrumb">';
    $html[] = '           <li><a href="<?= base_url(\'panel\');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>';
    $html[] = '           <li><a href="<?= base_url(\'panel/'.strtolower($mdname).'\');?>">'.ucwords(str_replace('_',' ',$mdname)).'</a></li>';
    $html[] = '           <li class="active">Detail</li>';
    $html[] = '       </ol>';
    $html[] = '   </section>';
    $html[] = '   <section class="content">';
    $html[] = '       <div class="row">';
    $html[] = '           <div class="col-xs-12">';
    $html[] = '               <div class="box">';
    $html[] = '                   <div class="box-header">';
    $html[] = '                       <h3 class="box-title">Detail '.$mdname.'</h3>';
    $html[] = '                   </div>';
    $html[] = '                   <div class="box-body">';
    $html[] = '                       <table class="table table-condensed">';
    $html[] = '                           <?php';
    $html[] = '                               foreach ($data as $key => $value) {';
    $html[] = '                                   $field = str_replace(\'_\', \' \', $key);';
    $html[] = '                                   if($key == \'id\'){';
    $html[] = '                                       continue;';
    $html[] = '                                   }';
    $html[] = '                                   echo \'<tr><td style="width:250px;background-color:#eee;padding-left:15px;">\'.ucfirst($field).\' :</td><td style="padding-left:25px;">\'.$value.\'</td></tr>\';';
    $html[] = '                               }';
    $html[] = '                           ?>';
    $html[] = '                       </table>';
    $html[] = '                   </div>';
    $html[] = '                   <div class="box-footer">';
    $html[] = '                       <div class="col-md-2 col-sm-offset-2">';
    $html[] = '                           <a href="#" onclick="window.history.back()" class="btn btn-default">Back</a>';
    $html[] = '                       </div>';
    $html[] = '                   </div>';
    $html[] = '               </div>';
    $html[] = '           </div>';
    $html[] = '       </div>';
    $html[] = '   </section>';
    $html[] = '</div>';
    $f=fopen($path.'/views/view_'.strtolower($mdname).'_detail.php','w');
    fwrite($f,implode(PHP_EOL, $html));
    fclose($f);
}