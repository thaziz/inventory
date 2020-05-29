<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Administrator Rule
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url('panel');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="<?= base_url('panel/admin');?>"> Administrator</a></li>
      <li class="active">Rule</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">
              
            </h3>
            <div class="action pull-right">
              <?php if($rules['d']):?>
              <a id="delete-all" title="Delete selected data" class="btn btn-danger btn-sm btn-circle"><i class="fa fa-trash"></i></a>
              <?php endif;?>
              <?php if($rules['c']):?>
              <a href="<?=base_url('panel/admin/group/insert');?>" class="btn btn-success btn-sm btn-circle"><i class="fa fa-plus"></i> Insert</a>
              <?php endif;?>
            </div>
          </div>
          <div class="box-body">
            <table id="group_table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="20px;"></th>
                  <th width="70px;">Identifier</th>
                  <th>Name</th>
                  <th>Description</th>
                  <?php if($rules['e'] || $rules['d']):?>
                  <th width="200px">&nbsp;</th>
                  <?php endif;?>
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
    if (confirm( "Are you sure you want to delete the selected admin group?" )) {
      $.ajax({
          url : '<?php echo base_url("panel/admin/group/delete"); ?>',
          type: "POST",
          data : {'grp_id':[id]},
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
              if(data.status){
                $().toastmessage('showToast', {
                  text     : 'Delete data success',
                  position : 'top-center',
                  type     : 'success',
                  close    : function () {
                    window.location = "<?=base_url('panel/admin/group');?>";
                  }
              });
            }else{
              console.log(data);
            }
          },
          error: function(jqXHR, textStatus, errorThrown){
              alert('Error,something goes wrong');
          }
      });
    }
  }

  $(document).ready(function(){
    $('#group_table').dataTable({
      "aLengthMenu":  [10, 25, 50, 100, 500, 1000, 2500, 5000],
      "ajax": {
              "url": "<?php echo base_url('panel/admin/group'); ?>",
              "type": "POST"
          },
      "aaSorting": [[ 1, "desc" ]],
      "searching": true,
      "paging": true,
      "bFilter": false,
      "bStateSave": true,
      "bServerSide": true,
      "sPaginationType": "full_numbers",
      "aoColumnDefs": [
      { "title":"<input type='checkbox' class='check-all'></input>","sClass": "center","aTargets":[0],
        "render": function(data, type, full){
          return '<input type="checkbox" class="check-item" value="'+full[0]+'">';
        },
        "bSortable": false
      },
      { "sClass": "center", "aTargets": [ 1 ], "data":0 },
      { "sClass": "center", "aTargets": [ 2 ], "data":1 },
      { "sClass": "center", "aTargets": [ 3 ], "data":2 },
      <?php if($rules['e'] || $rules['d']):?>
      { "sClass": "center", "aTargets": [ 4 ],
        "mRender": function(data, type, full) {
          var html = '';
                <?php if($rules['e']):?>
          html += '<a href=<?=base_url('panel/admin/group/edit');?>/' + full[0] 
              + ' class="btn btn-info btn-xs btn-col icon-green"><i class="fa fa-pencil"></i> Edit' 
              + '</a>';
                <?php endif;?>
                <?php if($rules['d']):?>
          html +='<a href="javascript:;" onclick="remove(\'' + full[0] + '\');" id="btn-delete" class="btn btn-danger btn-xs btn-col icon-black"><i class="fa fa-close"></i> Delete' 
              + '</a>';
                <?php endif;?>
          return html;
        }, "bSortable": false        
      },
      <?php endif;?>
      ]
    });
    //action to change all checkbox
    $('.check-all').change(function(){
      $('.check-item').prop('checked', $(this).prop('checked'));
    });
    //action to delete selected items
    $('#delete-all').click(function(){
      if (confirm( 'Are you sure you want to delete the selected admin group?' )) {
        var data = {};
        var grp_id = [];
        if($('.check-item:checked').length<1){
          $().toastmessage('showToast', {
            text     : "Delete failed, you don't select any data.",
            sticky   : false,
            position : 'top-center',
            type     : 'error',
          });
          return false;
        }
        $('.check-item:checked').each(function(idx, el){
          grp_id.push(parseInt($(el).val()));
        });
        data.grp_id = grp_id;
        $.ajax({
          url : '<?php echo base_url("panel/admin/group/delete"); ?>',
          type: "POST",
          data : data,
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
              if(data.status){
                $().toastmessage('showToast', {
                  text     : 'Delete data success',
                  position : 'top-center',
                  type     : 'success',
                  close    : function () {
                    window.location = "<?=base_url('panel/admin/group');?>";
                  }
                });
              }else{
                console.log(data);
              }
          },
          error: function(jqXHR, textStatus, errorThrown){
              alert('Error,something goes wrong');
          }
        });
      }
    });
  });

</script>