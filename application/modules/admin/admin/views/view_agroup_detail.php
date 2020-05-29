<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
	<section class="content-header">
	    <h1>
	      Agent Group
	      <small> View</small>
	    </h1>
	    <ol class="breadcrumb">
	      <li><a href="<?=base_url('panel');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	      <li><a href="<?=base_url('panel/admin');?>">Administrator</a></li>
	      <li><a href="<?=base_url('panel/admin/agent_group');?>">Agent Group</a></li>
	      <li class="active">Detail</li>
	    </ol>
  	</section>

  	<section class="content">
	  	<div class="row">
	  		<div class="col-xs-12">
	  			<div class="box">
		            <div class="box-header">
		              <h3 class="box-title">Detail <?=$data->group_name;?></h3>
		            </div>
				    <div class="box-body">
				        <table class="table table-condensed">
				            <?php
				            	foreach ($data as $key => $value) {
				            		$field = str_replace('_', '', $key);
				            		/*if($key == 'pro_id'){
				            			$field = 'Identifier';
				            		}elseif ($key == 'adm_firstname') {
				            			$field = 'First Name';
				            		}elseif ($key == 'limitbalance') {
				            			$field = 'Limit Balance';
				            		}elseif ($key == 'pro_creation') {
				            			$field = 'Created Date';
				            		}elseif ($key == 'billcycle') {
				            			$field = 'Billing Cycle';
				            		}elseif ($key == 'pro_enabled') {
				            			$value = '<input type="checkbox" '.($value?'checked':'').' disabled>';
				            		}*/
				            		echo '<tr>
				            				<td style="width:250px;background-color:#eee;padding-left:15px;">'
				            				.ucfirst($field).' :</td><td style="padding-left:25px;">'.$value.'</td>
				            			  </tr>';
				            	}
				            	?>
				        </table>
				    </div>
	  			</div>
	  		</div>
	  	</div>
	  	<div class="row">
	  		<div class="col-xs-12">
	  			<div class="box">
		            <div class="box-header">
		              <h3 class="box-title">Agent in group <?=$data->group_name;?></h3>
		              <div class="action pull-right">
		              	  <?php if($rules['e']):?>
			              <a id="delete-all" title="Delete selected data" class="btn btn-danger btn-sm btn-circle"><i class="fa fa-trash"></i></a>
			              <?php endif;?>
			              <?php if($rules['e']):?>
			              <a href="#" id="btn-add" class="btn btn-success btn-sm btn-circle"><i class="fa fa-plus"></i> Add Agent</a>
			              <?php endif;?>
		              </div>
		            </div>
				    <div class="box-body">
				        <table id="agent_table" class="table table-bordered table-striped">
			              <thead>
			                <tr>
			                  <th width="20px;"></th>
			                  <th width="70px;">No</th>
			                  <th>Agent Name</th>
			                  <th>Agent Extension</th>
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

<!-- Modal -->
<div class="modal fade" id="add-agent" tabindex="-1" role="dialog" aria-labelledby="Add agent to group">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form id="select-agent">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="add-agent-title">Add Agent in Group</h4>
      </div>
      <div class="modal-body">
       	<div class="row" style="display: flex">
		  <div class="col-xs-5">
		    <select name="from" id="multiselect" class="form-control" size="8" multiple="multiple" style="height:100%">
		      <?php foreach ($not_in as $v) {
		      	echo '<option value="'.$v->adm_id.'">'.$v->adm_name.'</option>';
		      }?>
		    </select>
		  </div>
		  <div class="col-xs-2">
		    <button type="button" id="multiselect_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
		    <button type="button" id="multiselect_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
		    <button type="button" id="multiselect_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
		    <button type="button" id="multiselect_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
		  </div>
		  <div class="col-xs-5">
		    <select name="to[]" id="multiselect_to" class="form-control" size="8" multiple="multiple" style="height:100%">
		      <?php foreach ($in as $v) {
		      	echo '<option value="'.$v->adm_id.'">'.$v->adm_name.'</option>';
		      }?>
		    </select>
		  </div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
  	</form>
    </div>
  </div>
</div>

<script src="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/multiselect/js/multiselect.min.js"></script>

<script type="text/javascript">
  function remove(id){
    if (confirm( "Are you sure you want to delete the selected agent group?" )) {
      $.ajax({
          url : '<?php echo base_url("panel/admin/agent_group/delete_agent/".$group_id); ?>',
          type: "POST",
          data : {'id':[id]},
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
              if(data.status){
                $().toastmessage('showToast', {
                  text     : 'Delete data success',
                  position : 'top-center',
                  type     : 'success',
                  close    : function () {
                    location.reload();
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

  	$('#multiselect').multiselect();

  	$('#select-agent').submit(function(e){
  		e.preventDefault();
  		var data_agent = $(this).serialize();
  		$.ajax({
  			url: '<?=base_url('panel/admin/agent_group/add_agent/'.$group_id)?>',
  			data: data_agent,
  			dataType: 'json',
  			type: 'post'
  		})
  		.done(function(res){
  			if(res.status){
  				$().toastmessage('showToast', {
                  text     : 'Add agent(s) success',
                  position : 'top-center',
                  type     : 'success',
                  close    : function () {
                    location.reload();
                  }
                });
  			}else{
  				$().toastmessage('showToast', {
                  text     : res.msg,
                  position : 'top-center',
                  type     : 'error',
                });
  			}
  		})
  		.fail(function(jqXHR, error, status){
  			console.log(jqXHR);
  			console.log(error);
  			console.log(status);
  		});
  	})

  	$('#btn-add').click(function(e){
		$('#add-agent').modal({
		    backdrop: 'static',
		    keyboard: false
		});
  	});

    $('#agent_table').dataTable({
      "aLengthMenu":  [10, 25, 50, 100, 500, 1000, 2500, 5000],
      "ajax": {
              "url": "<?php echo current_url(); ?>",
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
      { "sClass": "center", "aTargets": [ 1 ], "data":1 },
      { "sClass": "center", "aTargets": [ 2 ], "data":2 },
      { "sClass": "center", "aTargets": [ 3 ], "data":3 },
      <?php if($rules['e'] || $rules['d']):?>
      { "sClass": "center", "aTargets": [ 4 ],
        "mRender": function(data, type, full) {
          var html = '';
                <?php if($rules['e'] || $rules['d']):?>
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
      if (confirm( 'Are you sure you want to delete the selected agent from group?' )) {
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
          id.push(parseInt($(el).val()));
        });
        data.id = id;
        $.ajax({
          url : '<?php echo base_url("panel/admin/agent_group/delete_agent/".$group_id); ?>',
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
                    location.reload();
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