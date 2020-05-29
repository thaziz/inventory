<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$opt = array('exact'=>'Exact','begins with'=>'Begins With','contains'=>'Contains','ends with'=>'Ends With');
/*echo '<pre>';
print_r($arr_outbond);
print_r($data);
echo '</pre>';
exit;*/
?>
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/dist/css/progressbar.css')?>">
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/plugins/monthpicker/monthpicker.css')?>">
<style type="text/css">
	.p-0{
		padding: 0;
	}
	.table-box{
		border:1px solid #ddd;
		border-radius: 4px;
	}
	.table-box>tbody>tr>th{
		background-color: #f9f9f9;
		font-weight: bold;
		color: #000;
		text-align: center;
	}
	table.table-box tr:last-child td:first-child {
	    border-bottom-left-radius: 10px;
	}

	table.table-box tr:last-child td:last-child {
	    border-bottom-right-radius: 10px;
	}
</style>

<div class="content-wrapper">
	<section class="content-header">
	    <h1>
	      Campaign <?=$data->campaign_name;?><small>Target</small>
	    </h1>
	    <ol class="breadcrumb">
	      <li><a href="<?=base_url('panel');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	      <li><a href="<?=base_url('panel/campaign');?>">Campaign</a></li>
	      <li class="active">Detail</li>
	    </ol>
  	</section>

  	<section class="content">
	  	<div class="row">
	  		<div class="col-xs-12">
	  			<ul class="nav nav-tabs">
				  <li role="presentation"><a href="<?=base_url('panel/campaign/dashboard/'.$data->campaign_id);?>">Dashboard</a></li>
				  <li><a href="<?=base_url('panel/campaign/detail/'.$data->campaign_id);?>">Detail</a></li>
          <?php if($rules['e']||$rules['c']):?>
				  <li><a href="<?=base_url('panel/campaign/agents/'.$data->campaign_id);?>">Agents</a></li>
				  <li><a href="<?=base_url('panel/campaign/assignment/'.$data->campaign_id);?>">Assignment</a></li>
          <li class="active"><a href="">Target Tools</a></li>
          <?php endif;?>
          <?php if($data->outbound_type=='predictive'):?>                    
          <li role="presentation"><a href="<?=base_url('panel/campaign/remaining_data/'.$data->campaign_id);?>">Remaining Data</a></li>
          <?php endif;?>
				  <li><a href="<?=base_url('panel/campaign/report/'.$data->campaign_id);?>">Report</a></li>
          

				</ul>
				<div class="box" style="border:1px solid #ddd;border-top:none;border-top-left-radius:0;border-top-right-radius:0;">
					<div class="box-body">

			  			<div class="col-md-12 p-0">
				  			<div class="box">

					            <div class="box-header">
					              <h3 class="box-title">Target Campaign per Month</h3>
					              <div class="action pull-right">
                          <?php if($rules['e']||$rules['c']):?>
						              <a id="delete-all" title="Delete selected data" class="btn btn-danger btn-sm btn-circle"><i class="fa fa-trash"></i></a>
                          <?php endif;?>
                          <?php if($rules['e']||$rules['c']):?>
						              <a href="" class="btn btn-success btn-sm btn-circle addTarget"><i class="fa fa-plus"></i> Add Target</a>
                          <?php endif;?>
						          </div>
					            </div>
							    <div class="box-body table-responsive">
							    	<table id="campaign_target" class="table table-bordered table-striped" style="width: 100%">
						              <thead>
						                <tr>
						                  <th width="20px"></th>
						                  <th width="30px;">NO</th>
                              <th width="40px;">MONTH</th>
                              <th width="40px;">TARGET</th>
                              <th width="75px;"></th>
						                </tr>
						              </thead>
						            </table>
							    </div>
				  			</div>
			  			</div>
			  		</div>
		  		</div>
	  		</div>
	  	</div>
  </section>
</div>

<!-- Modal Add Target-->
<div id="addTarget" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <form class="form-horizontal" role="form" method="post" id="add_target">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Target</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
              <label class="col-sm-3">Month *</label>
              <div class="col-sm-5">
                  <input type="text" class="form-control month" id="month" name="month">
              </div>
              <span class="info"></span>
           </div>

          <div class="form-group">
            <label class="col-sm-3">Target *</label>
               <div class="col-sm-5">
                  <input type="text" class="form-control currency" id="target" name="target">
              </div>
              <span class="info"></span>
           </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    </form>

  </div>
</div>

<!-- Modal Edit Target-->
<div id="editTarget" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <form class="form-horizontal" role="form" method="post" id="edit_target">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Target</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" class="form-control" id="edit_id" name="id">
          <div class="form-group">
              <label class="col-sm-3">Month *</label>
              <div class="col-sm-5">
                  <input type="text" class="form-control month" id="edit_month" name="month">
              </div>
              <span class="info"></span>
           </div>

          <div class="form-group">
            <label class="col-sm-3">Target *</label>
               <div class="col-sm-5">
                  <input type="text" class="form-control currency" id="edit_target_amount" name="target">
              </div>
              <span class="info"></span>
           </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    </form>

  </div>
</div>

<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/monthpicker/monthpicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?=base_url('assets')?>/plugins/input-mask/jquery.inputmask.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/buttons.colVis.min.js"></script>
<script type="text/javascript">
  function remove(id){
    if (confirm( "Are you sure you want to delete the selected data target?" )) {
      $.ajax({
          url : '<?php echo base_url("panel/campaign/delete_target/".$data->campaign_id); ?>',
          type: "POST",
          data : {'id':[id]},
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
              if(data.status){
                $().toastmessage('showToast', {
                  text     : 'Delete target success',
                  position : 'top-center',
                  type     : 'success',
                  close    : function () {
                    window.location = "<?=base_url('panel/campaign/target/'.$data->campaign_id);?>";
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
  function edit(id){
    $.ajax({
          url : '<?php echo base_url("panel/campaign/find_target/"); ?>',
          type: "POST",
          data : {'id':id},
          dataType: 'json'
        }).done(function(res){
          console.log(res.month);
          $('#edit_id').val(res.id)
          $('#edit_month').val(res.month)
          $('#edit_target_amount').val(res.target_amount)
          $('#editTarget').modal('show');
        })
  }

  $(document).ready(function(){
    $(".currency").inputmask({alias : "currency", prefix: '', digits: 0, groupSeparator: "."});
    $('.addTarget').click(function(e){
      e.preventDefault();
      $('#addTarget').modal('show')
    })
    $('#addTarget').on('hidden.bs.modal', function (e) {
      $('#add_target').find('input').val('');
    })
    $('.month').Monthpicker();

  	});
    function reload_table(){
      var table = $('#campaign_target').DataTable({
        
        "aLengthMenu":  [10, 25, 50, 100, 500, 1000, 2500, 5000],
        "ajax": {
                "url": "<?php echo base_url('panel/campaign/target/'.$data->campaign_id); ?>",
                "type": "POST",
            },
        "aaSorting": [[ 1, "desc" ]],
        "searching": false,
        "paging": true,
        "bFilter": true,
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
        { "sClass": "center", "aTargets": [ 1 ], "data":1 },
        { "sClass": "center", "aTargets": [ 2 ], "data":2 },
        { "sClass": "center", "aTargets": [ 3 ], "data":3 },
        <?php if($rules['e']||$rules['c']):?>
        	{ "sClass": "center", "aTargets": 4,
          "mRender": function(data, type, full) {
            	return '<a href="javascript:;" onclick="edit(\'' + full[0] + '\');" class="btn btn-info btn-xs btn-col icon-green"><i class="fa fa-pencil"></i> Edit'
                + '</a>'+'<a href="javascript:;" onclick="remove(\'' + full[0] + '\');" id="btn-delete" class="btn btn-danger btn-xs btn-col icon-black"><i class="fa fa-close"></i> ' + 'Delete'
                + '</a>';
          },
          "bSortable": false
        },
      <?php endif;?>
        ],
        "destroy":true
      })
    }
    reload_table();
    //action to change all checkbox
    $('.check-all').change(function(){
      $('.check-item').prop('checked', $(this).prop('checked'));
    });
    //action to delete selected items
    $('#delete-all').click(function(){
      if (confirm( 'Are you sure you want to delete the selected data target?' )) {
        var data = {};
        var id = [];
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
          data_id.push(parseInt($(el).val()));
        });
        data.data_id = data_id;
        $.ajax({
          url : '<?php echo base_url("panel/campaign/delete_target/".$data->campaign_id); ?>',
          type: "POST",
          data : data,
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
              if(data.status){
                $().toastmessage('showToast', {
                  text     : 'Delete target success',
                  position : 'top-center',
                  type     : 'success',
                  close    : function () {
                    window.location = "<?=base_url('panel/campaign/target/'.$data->campaign_id);?>";
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

    $('#add_target').submit(function(e){
      var data = $(this).serialize();
      e.preventDefault();
      $.ajax({
        "url": "<?php echo base_url('panel/campaign/insert_target/'.$data->campaign_id); ?>",
        "type": "POST",
        "dataType": "json",
        "data": data
      }).done(function(respon){
        if(respon.status){
          $().toastmessage('showToast', {
              text     : 'Add target success',
              position : 'top-center',
              type     : 'success',
              close    : function () {
                $('#addTarget').modal('hide');
                reload_table();
              }
          });
        }else{
          if(respon.msg !== undefined){
            $().toastmessage('showToast', {
              text     : respon.msg,
              position : 'top-center',
              type     : 'error',
          });
          }else{
            $.each(respon.e, function(key, val){
                    $('[name="'+key+'"]').closest('.form-group').find('.info').html(val);
                  });
          }
        }
      })
    })


</script>
