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
	      Campaign <?=$data->campaign_name;?><small>Assignment</small>
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
          <li role="presentation"><a href="<?=base_url('panel/campaign/agents/'.$data->campaign_id);?>">Agents</a></li>
          <li role="presentation" class="active"><a href="#">Assignment</a></li>
          <li role="presentation"><a href="<?=base_url('panel/campaign/report/'.$data->campaign_id);?>">Report</a></li>
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
                        <h3 class="box-title" style="float:left;margin-top:10px;">Campaign Assignment
                        </h3>
                        <div class="col-md-3">
                          <div class="form-group">
                            <select class="form-control" id="agent">
                              <option>All</option>
                              <option value="0">Unassigned</option>
                              <?php
                              foreach ($in as $key => $value) {
                                echo '<option value="'.$value->assign_id.'">'.$value->adm_name.'</option>';
                              }
                              ?>
                            </select>
                          </div>
                        </div>
					              <div class="action pull-right">
						              <a id="unassign-all" title="Delete selected data" class="btn btn-warning btn-sm btn-circle"><i class="fa fa-minus"></i> Unassign</a>
						              <!--a href="#import" data-toggle="collapse" class="btn btn-primary btn-sm btn-circle"><i class="fa fa-upload"></i> Import</a-->
                          <a href="#" id="btn-add" class="btn btn-success btn-sm btn-circle"><i class="fa fa-reply"></i> Assign to</a>
						              <a href="#" id="auto" class="btn btn-primary btn-sm btn-circle"><i class="fa fa-reply"></i> Auto Assign</a>
						          </div>
					            </div>
							    <div class="box-body">
							    	<table id="assignment_table" class="table table-bordered table-striped">
						              <thead>
						                <tr>
						                  <th width="20px"></th>
						                  <th width="70px;">NO</th>
                              <?php
                              foreach (json_decode($data->form) as $key => $value) {
                                if(!isset($value->editable))
                                  echo '<th>'.$value->label.'</th>';
                              }
                              ?>
						                  <th>Assign to</th>
						                  <th width="175">&nbsp;</th>
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
<div class="modal fade" id="assign-agent" tabindex="-1" role="dialog" aria-labelledby="Add Agent in Campaign">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
    <form id="assign-form">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="add-agent-title">Assign to Agent</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12">
            <select name="assign_id" class="form-control">
              <?php foreach ($in as $v) {
                echo '<option value="'.$v->assign_id.'">'.$v->adm_name.'</option>';
              }?>
            </select>
            <input type="hidden" name="data_id">
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

<script type="text/javascript">
  function unassign(id){
    if (confirm( "Are you sure you want to unassign the selected agent?" )) {
      $.ajax({
          url : '<?php echo base_url("panel/campaign/unassign_agents/".$data->campaign_id); ?>',
          type: "POST",
          data : {'data_id':[id]},
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
              if(data.status){
                $().toastmessage('showToast', {
                  text     : 'Unassign agent success',
                  position : 'top-center',
                  type     : 'success',
                  close    : function () {
                    window.location = "<?=base_url('panel/campaign/assignment/'.$data->campaign_id);?>";
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

  function assign(data_id){
    $('[name="data_id"]').val(data_id);
    $('#assign-agent').modal({
        backdrop: 'static',
        keyboard: false
    });
  }

  function reload_tabel(){
    $('#assignment_table').dataTable({
      "aLengthMenu":  [10, 25, 50, 100, 500, 1000, 2500, 5000],
      "ajax": {
              "url": "<?php echo current_url() ?>",
              "type": "POST",
              "data": {'agent_id':$('#agent').val()}
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
      <?php
        $idx = 2;
        foreach (json_decode($data->form) as $value) {
          if(!isset($value->editable)){
            echo '{ "sClass": "center", "aTargets": [ '.$idx.' ], "data":'.$idx.' },'.PHP_EOL;
            $idx++;
          }
        }
        echo '{ "sClass": "center", "aTargets": [ '.$idx.' ], "data":'.$idx.' },'.PHP_EOL;
      ?>
        { "sClass": "center", "aTargets": [ <?=($idx+1)?> ],
        "mRender": function(data, type, full) {
            return '<a href="javascript:;" onclick="unassign(\'' + full[0] + '\');" id="btn-unassign" class="btn btn-warning btn-xs btn-col"><i class="fa fa-minus"></i> Unassign</a><a href="javascript:;" onclick="assign(\'' + full[0] + '\');" id="btn-assign" class="btn btn-success btn-xs btn-col"><i class="fa fa-reply"></i> Assign</a>';
        },
        "bSortable": false,
      },
      ],
        "destroy": true
    });

    //action to change all checkbox
    $('.check-all').change(function(){
      $('.check-item').prop('checked', $(this).prop('checked'));
    });
}

  $(document).ready(function(){
    reload_tabel();
    $('#agent').change(function(){
      reload_tabel();
    })

    $('#btn-add').click(function(e){
      var data_id = [];
      if($('.check-item:checked').length<1){
        $().toastmessage('showToast', {
          text     : "Assign failed, you don't select any data.",
          sticky   : false,
          position : 'top-center',
          type     : 'error',
        });
        return false;
      }else{
        $('.check-item:checked').each(function(idx, el){
          data_id.push(parseInt($(el).val()));
        });
        $('[name="data_id"]').val(data_id.join(','));
        $('#assign-agent').modal({
            backdrop: 'static',
            keyboard: false
        });
      }
    });
    $('#assign-form').submit(function(e){
      e.preventDefault();
      $.ajax({
        url: '<?=base_url('panel/campaign/assign_to/'.$data->campaign_id)?>',
        type: 'post',
        dataType: 'json',
        data: $('#assign-form').serialize()
      })
      .done(function(res){
        if(res.status){
          $().toastmessage('showToast', {
            text     : 'Assign data success',
            position : 'top-center',
            type     : 'success',
            close    : function () {
              location.reload();
            }
          });
        }else{
          $().toastmessage('showToast', {
            text     : "Assign data failed",
            sticky   : false,
            position : 'top-center',
            type     : 'error',
          });
        }
      })
      .fail(function(xhr, error, status){
        console.log(xhr);
        console.log(error);
        console.log(status);
      })
    })
    //action to delete selected items
    $('#unassign-all').click(function(){
      if (confirm( 'Are you sure you want to unassign the selected agent(s)?' )) {
        var data = {};
        var data_id = [];
        if($('.check-item:checked').length<1){
          $().toastmessage('showToast', {
            text     : "Unassign failed, you don't select any data.",
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
          url : '<?php echo base_url("panel/campaign/unassign_agents/".$data->campaign_id); ?>',
          type: "POST",
          data : data,
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
              if(data.status){
                $().toastmessage('showToast', {
                  text     : 'Unassign agent success',
                  position : 'top-center',
                  type     : 'success',
                  close    : function () {
                    window.location = "<?=base_url('panel/campaign/assignment/'.$data->campaign_id);?>";
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
    //action to delete selected items
    $('#auto').click(function(){
      //alert('hello');
        $.post('<?php echo base_url("panel/campaign/auto_assign/".$data->campaign_id); ?>')
        .done(function(res){
          var d = JSON.parse(res);
          if(d.status){
            $().toastmessage('showToast', {
              text     : 'Auto assign success',
              position : 'top-center',
              type     : 'success',
              close    : function () {
                location.reload();
              }
            });
          }else{
            $().toastmessage('showToast', {
              text     : 'Auto assign failed',
              position : 'top-center',
              type     : 'error'
            });
          }
        })
        .always(function(){

        })
    });
  });


</script>
