<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/dist/css/progressbar.css')?>">
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
	      Campaign <?=$data->campaign_name;?><small>Agents</small>
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
          <li role="presentation"><a href="<?=base_url('panel/campaign/detail/'.$data->campaign_id);?>">Detail</a></li>
          <li role="presentation" class="active"><a href="#">Agents</a></li>
          <li role="presentation"><a href="<?=base_url('panel/campaign/assignment/'.$data->campaign_id);?>">Assignment</a></li>
          <li role="presentation"><a href="<?=base_url('panel/campaign/report/'.$data->campaign_id);?>">Report</a></li>
          <li role="presentation"><a href="<?=base_url('panel/campaign/wallboard/'.$data->campaign_id);?>">Wallboard</a></li>
				</ul>
				<div class="box" style="border:1px solid #ddd;border-top:none;border-top-left-radius:0;border-top-right-radius:0;">


					<div class="box-body">

						<?php if($agent_count<1): ?>
						<div class="row">
							<div class="col-md-12">
								<div class="alert alert-warning">
									There're no agents in this campaign yet. Please add one or more agent for this campaign.
								</div>
							</div>
						</div>
						<?php endif; ?>

			  			<div class="col-md-12 p-0">
				  			<div class="box">
				  				<!-- Import form -->
          <!--div class="row">
            <div class="col-md-12" style="text-align: center">
              <div id="import" class="collapse" style="margin:15px auto; width: 550px;">
                <form id="importform" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="file" name="file" id="input-file" class="form-control">
                       <span class="input-group-addon">
                        <label style="position:relative;margin-bottom:0"><input type="checkbox" value="1" name="header"  style="position:relative;top:3px;"> Skip Header</label>
                       </span>
                       <span class="input-group-btn">
                        <button class="btn btn-primary" id="btn-import" type="submit">Import</button>
                       </span>
                    </div>
                  </div>
                </form>
                <div class="progress" style="display:none;">
				  <div class="indeterminate"></div>
				</div>
              </div>
            </div>
          </div-->

					            <div class="box-header">
					              <h3 class="box-title">Agents in Campaign</h3>
					              <div class="action pull-right">
						              <a id="delete-all" title="Delete selected data" class="btn btn-danger btn-sm btn-circle"><i class="fa fa-trash"></i></a>
						              <!--a href="#import" data-toggle="collapse" class="btn btn-primary btn-sm btn-circle"><i class="fa fa-upload"></i> Import</a-->
						              <a href="#" id="btn-add" class="btn btn-success btn-sm btn-circle"><i class="fa fa-plus"></i> Add Agent</a>
						          </div>
					            </div>
							    <div class="box-body">
							    	<table id="agent_table" class="table table-bordered table-striped">
						              <thead>
						                <tr>
						                  <th width="20px"></th>
						                  <th width="70px;">NO</th>
						                  <th>Agent Name</th>
						                  <th>Extension</th>
						                  <th>&nbsp;</th>
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

<!-- Modal -->
<div class="modal fade" id="add-agent" tabindex="-1" role="dialog" aria-labelledby="Add Agent in Campaign">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form id="select-agent">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="add-agent-title">Add Agent in Campaign</h4>
      </div>
      <div class="modal-body">
       	<div class="row" style="display: flex">
		  <div class="col-xs-5">
		    <select name="from" id="multiselect" class="form-control" size="8" multiple="multiple" style="height:100%">
		      <?php foreach ($not_in as $v) {
		      	if(isset($v['group_name'])){
              echo '<optgroup label="'.$v['group_name'].'">';
              foreach ($v['data'] as $val) {
                echo '<option value="'.$val['adm_id'].'">'.$val['adm_name'].'</option>';
              }
              echo '</optgroup>';
            }else{
              echo '<option value="'.$v['adm_id'].'">'.$v['adm_name'].'</option>';
            }
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
		      <?php foreach ($in as $key=>$v) {
            if(isset($v['group_name'])){
              echo '<optgroup label="'.$v['group_name'].'">';
              foreach ($v['data'] as $val) {
                echo '<option value="'.$val['adm_id'].'">'.$val['adm_name'].'</option>';
              }
              echo '</optgroup>';
            }else{
		      	 echo '<option value="'.$v['adm_id'].'">'.$v['adm_name'].'</option>';
            }
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
    if (confirm( "Are you sure you want to delete the selected agent?" )) {
      $.ajax({
          url : '<?php echo base_url("panel/campaign/delete_agents/".$data->campaign_id); ?>',
          type: "POST",
          data : {'assign_id':[id]},
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
              if(data.status){
                $().toastmessage('showToast', {
                  text     : 'Delete data success',
                  position : 'top-center',
                  type     : 'success',
                  close    : function () {
                    window.location = "<?=base_url('panel/campaign/agents/'.$data->campaign_id);?>";
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

  	$('#multiselect').multiselect();

  	$('#select-agent').submit(function(e){
  		e.preventDefault();
  		var data_agent = $(this).serialize();
  		$.ajax({
  			url: '<?=base_url('panel/campaign/submit_agents/'.$data->campaign_id)?>',
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
                    window.location = "<?=base_url('panel/campaign/agents/'.$data->campaign_id);?>";
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
              "url": "<?php echo current_url() ?>",
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
      { "sClass": "center", "aTargets": [ 4 ],
        "mRender": function(data, type, full) {
          	return '<a href="javascript:;" onclick="remove(\'' + full[0] + '\');" id="btn-delete" class="btn btn-danger btn-xs btn-col icon-black"><i class="fa fa-close"></i> Delete</a>';
        },
        "bSortable": false
      },
      ]
    });

    //action to change all checkbox
    $('.check-all').change(function(){
      $('.check-item').prop('checked', $(this).prop('checked'));
    });
    //action to delete selected items
    $('#delete-all').click(function(){
      if (confirm( 'Are you sure you want to delete the selected agent(s)?' )) {
        var data = {};
        var assign_id = [];
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
          assign_id.push(parseInt($(el).val()));
        });
        data.assign_id = assign_id;
        $.ajax({
          url : '<?php echo base_url("panel/campaign/delete_agents/".$data->campaign_id); ?>',
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
                    window.location = "<?=base_url('panel/campaign/agents/'.$data->campaign_id);?>";
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
