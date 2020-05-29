<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$opt = array('exact'=>'Exact','begins with'=>'Begins With','contains'=>'Contains','ends with'=>'Ends With');
$search_f = isset($this->session->userdata['asearch']['login_search'])?$this->session->userdata['asearch']['login_search']:'';
$filter_f = isset($this->session->userdata['afilter']['login_filter'])?$this->session->userdata['afilter']['login_filter']:'';
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Agent Time
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url().'panel';?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Agent Time</li>
    </ol>
  </section>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <!-- Start advancd search form -->
          <div class="row" style="padding-top: 15px;">
            <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-primary collapse" id="search" style="margin-bottom: 0;">
                <div class="panel-body">
                  <form class="form-horizontal" method="post" id="search_form">
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="adm_id">Agent</label>
                      <div class="col-sm-5">
                        <select name ="adv_search[adm_id]" class="form-control input-sm" readonly>
                          <option value=""></option>
                          <?php
                            foreach ($agent_list as $key => $value) {
                              $sel = '';
                                    if(is_array($search_f)){
                                  $sel = $search_f['adv_search']['adm_id']==$key?'selected':'';
                                  }
                              echo '<option value="'.$key.'" '.$sel.'>'.$value.'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="login_time">Login Time</label>
                      <div class="col-sm-3">
                        <input type="text" name="adv_search[login_time]" value="<?=date('F d, Y')." 01:00 AM - ".date('F d, Y').' 11:59 PM'?>" class="form-control date_range" id="login_time">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4 col-md-offset-5">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <button type="button" class="btn btn-default" id="clear">Clear</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- End advancd search form -->
          <div class="box-body">
            <table id="login_table" class="table table-bordered table-striped" width="100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Agent Name</th>
                  <th>Extension</th>
                  <th>Login Time</th>
                  <th>Logout Time</th>
                  <th>Total</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
  <form id="column-form">
  <?php
    $col_name = array('No', 'Agent Name', 'Extension', 'Login Time', 'Logout Time', 'Total');
    $columns = array('no', 'adm_name', 'adm_ext', 'login_time', 'logout_time', 'total');
    foreach ($columns as $key => $value) {
      echo '<input type="hidden" name="col['.$key.']" value="'.$value.'">';
      echo '<input type="hidden" name="col_name['.$key.']" value="'.$col_name[$key].'">';
    }
  ?>
  </form>
</div>
  <script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script><!-- date-range-picker -->
<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script><!-- bootstrap time picker -->
<script src="<?php echo base_url(); ?>assets/plugins/materialtimepicker/mdtimepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/buttons.colVis.min.js"></script>
<script type="text/javascript">

    
  $(document).ready(function(){    

    var columns = ['no', 'adm_name', 'adm_ext', 'login_time', 'logout_time', 'total'];
    var col_name = ['No', 'Agent Name', 'Extension', 'Login Time', 'Logout Time', 'Total'];
    function reload_table(){
      var table = $('#login_table').on( 'processing.dt', function ( e, settings, processing ) {
        //$('#loading').css( 'display', processing ? 'inline-block' : 'none' );
      }).DataTable({
        dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        responsive: false,
        "ajax": {
                "url": "<?php echo current_url(); ?>",
                "type": "POST",
                "data":data_builder(),
            },
        "aaSorting": [[ 1, "desc" ]],
        "paging": true,
        "scrollX": true,
        "bFilter": false,
        "bStateSave": true,
        "bServerSide": true,
        "sPaginationType": "full_numbers",
        "aoColumnDefs": [
        { "sClass": "center", "aTargets": [ 0 ]},
        { "sClass": "center", "aTargets": [ 1 ]},
        { "sClass": "center", "aTargets": [ 2 ]},
        { "sClass": "center", "aTargets": [ 3 ]},
        { "sClass": "center", "aTargets": [ 4 ]},
        { "sClass": "center", "aTargets": [ 5 ]},
        ],
        "destroy":true
      }).on('draw.dt',function(){
          var colvis = table.columns().visible();
          $.each(colvis, function(column,state){
            if(state){
              $('[name="col['+column+']"]').val(columns[column]);
              $('[name="col_name['+column+']"]').val(col_name[column]);
            }else{
              $('[name="col['+column+']"]').val(0);
              $('[name="col_name['+column+']"]').val(0);
            }
          });

        });
      $('#cdr_table').on( 'column-visibility.dt', function ( e, settings, column, state ) {
          if(state){
              $('[name="col['+column+']"]').val(columns[column]);
              $('[name="col_name['+column+']"]').val(col_name[column]);
          }else{
              $('[name="col['+column+']"]').val(0);
              $('[name="col_name['+column+']"]').val(0);
          }
          //alert( 'Table\'s column visibility are set to: '+table.columns().visible().join(', ') );
      });

    }

    reload_table();

    $('#export').click(function(){
      form_builder();
      $('#export_form').attr('action','<?=base_url('panel/agent_login/export')?>');
      $('#export_form').submit();
      $('#export_form').remove();
    });

    $('form#search_form').on('submit', function(e) {
      e.preventDefault();
      reload_table();
    });
    $('#clear').on('click', function(e) {
      e.preventDefault();
      $('form#search_form input').val('');
      $('form#search_form select').prop('selectedIndex', 0);
      reload_table();
    });

    function data_builder(){
      var data_set = {};
      var array = $("#search_form, #column-form").serializeArray();
      $.each(array, function(key, val){
        data_set[val.name] = val.value;
      })
      return data_set;
    }

    function form_builder(){
      var form='<form id="export_form" method="post" action="">';
      var array = $("#search_form").serializeArray();
      $.each(array, function(key, val){
        form += '<input type="hidden" name="'+val.name+'" value="'+val.value+'">';
      });
      form+='</form>';
      $(document.body).append(form);
    }

  });
</script>
<style type="text/css">
  .table th{
    text-align: center;
    vertical-align: middle !important;
  }
  .disabled.day{
    color: #999;
  }
</style>
