<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      User Log
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url().'panel';?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">User Log</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">
            </h3>
            <!--div class="action pull-right">
              <a href="<?=base_url('panel/user_log/delete_three');?>" class="btn btn-danger btn-sm btn-circle"><i class="fa fa-trash"></i> Delete</a>
            </div-->
          </div>
          <div class="box-body">
            <table id="user_log" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="100px">User</th>
                  <th>Log</th>
                  <th width="125px">Date</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.js"></script>
<script type="text/javascript">
  function remove(id){
    if (confirm( "Are you sure you want to delete the selected provider?" )) {
      $.ajax({
          url : '<?php echo base_url("panel/user_log/delete"); ?>',
          type: "POST",
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
              if(data.status){
                $().toastmessage('showToast', {
                  text     : 'Delete data success',
                  position : 'top-center',
                  type     : 'success',
                  close    : function () {
                    window.location = "<?=base_url('panel/user_log');?>";
                  }
              });
            }
          },
          error: function(jqXHR, textStatus, errorThrown){
              alert('Error,something goes wrong');
          }
      });
    }
  }

  $(document).ready(function(){

    $('#user_log').dataTable({
      "aLengthMenu":  [10, 25, 50, 100, 500, 1000, 2500, 5000],
      "ajax": {
              "url": "<?php echo base_url('panel/user_log'); ?>",
              "type": "POST"
          },
      "aaSorting": [[ 2, "desc" ]],
      "searching": true,
      "paging": true,
      "bFilter": false,
      "bStateSave": true,
      "bServerSide": true,
      "sPaginationType": "full_numbers",
      "aoColumnDefs": [
      { "sClass": "center", "aTargets": [ 0 ], "data":[1]},
      { "sClass": "center", "aTargets": [ 1 ], "data":[2]},
      { "sClass": "center", "aTargets": [ 2 ], "data":[3]},
      ], //"destroy":true
    });

  });

</script>