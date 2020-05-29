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
	      Campaign <?=$data->campaign_name;?><small>Detail</small>
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
				  <li class="active"><a href="#">Detail</a></li>
          <?php if($rules['e']||$rules['c']):?>
				  <li><a href="<?=base_url('panel/campaign/agents/'.$data->campaign_id);?>">Agents</a></li>
				  <li><a href="<?=base_url('panel/campaign/assignment/'.$data->campaign_id);?>">Assignment</a></li>
          <?php endif;?>
				  <li><a href="<?=base_url('panel/campaign/report/'.$data->campaign_id);?>">Report</a></li>
          <?php if($rules['e']||$rules['c']):?>
          <li role="presentation"><a href="<?=base_url('panel/campaign/wallboard/'.$data->campaign_id);?>">Wallboard</a></li>
          <?php endif;?>

				</ul>
				<div class="box" style="border:1px solid #ddd;border-top:none;border-top-left-radius:0;border-top-right-radius:0;">
					<div class="box-body">
						<div class="col-md-12 p-0">
				  			<div class="box">
					            <div class="box-header">
					              <h3 class="box-title">Campaign <?=$data->campaign_name;?></h3>
					            </div>
							    <div class="box-body">
							    	<div class="row">
								    	<div class="col-md-6">
									        <table class="table table-condensed table-detail table-box">
									        	<tr><th colspan="2" class="title">Campaign Detail</th></tr>
									            <?php
                              /*echo '<pre>';
                              print_r($data);
                              echo '</pre>';
                              exit;*/
									            	foreach ($data as $key => $value) {
									            		$field = ucwords(str_replace('_', ' ', $key));
									            		$field = str_replace('Per', 'per', $field);
									            		$field = str_replace('At', 'at', $field);
									            		$field = str_replace('By', 'by', $field);
				            		          if($key == 'campaign_id' || (strrpos($key, 'form') !== false) || $key=='creator_id' || $key=='script' || $key=='sms_script'){
									            			continue;
									            		}
                                  if(($key == 'status' && $value == 1) || ($key == 'sms_enabled' && $value == 1) || ($key == 'wa_enabled' && $value == 1)){
                                    $value = '<input type = "checkbox" checked disabled>';
                                  }else if(($key == 'status' && $value != 1) || ($key == 'sms_enabled' && $value != 1) || ($key == 'wa_enabled' && $value != 1)){
                                    $value = '<input type = "checkbox" disabled>';
                                  }
                                  if($key == 'outbond_type'){
                                    for ($i=0; $i < count($arr_outbond); $i++) {
                                      if($data->outbond_type == $i){
                                        $value = $arr_outbond[$i];
                                      }

                                    }

                                  }
									            		echo '<tr>
									            				<td style="width:180px;background-color:#f5f5f5;padding-left:15px;">'
									            				.$field.'</td><td style="padding-left:5px;">: '.$value.'</td>
									            			  </tr>';

									            	}
									            	?>
									        </table>
									    </div>

									    <div class="col-md-6">
									        <table class="table table-condensed table-detail table-box">
									        	<tr><th>Script</th></tr>
									        	<tr><td><?=$data->script?></td></tr>
									        </table>
                          <?php if($data->sms_enabled==1):?>
                          <table class="table table-condensed table-detail table-box" style="margin-top:10px;">
                            <tr><th>SMS Script</th></tr>
                            <tr><td><?=$data->sms_script?></td></tr>
                          </table>
                          <?php endif;?>
									    </div>

                      <!--div class="col-md-6">
                          <table class="table table-condensed table-detail table-box">
                            <tr><th>IVR Template</th></tr>
                            <tr><td><?=$data->ivr_template?></td></tr>
                          </table>
                      </div-->

								    </div>
							    </div>
				  			</div>
			  			</div>

			  			<div class="col-md-12 p-0">
				  			<div class="box">

                  <!-- Start advancd search form -->
          <div class="row" style="padding-top: 15px;">
            <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-primary collapse" id="search" style="margin-bottom: 0;">
                <div class="panel-body">
                  <form class="form-horizontal" method="post" id="search_form">
                    <?php $form=json_decode($data->form);?>
                    <?php foreach ($form as $item):?>
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="<?=$item->name?>"><?=$item->label?></label>
                        <?php if($item->type=='number'):?>
                          <div class="col-sm-4">
                            <input type="number" name="adv_search[form_<?=$item->name?>]" class="form-control" placeholder="<?=$item->label?>" min="<?=$item->min?>" max="<?=$item->max?>" id="<?=$item->name?>">
                          </div>
                          <?php elseif($item->type=='dropdown' || $item->type=='radio' || $item->type=='checkbox'):?>
                          <div class="col-sm-6">
                            <select class="form-control" name="adv_search[form_<?=$item->name?>]" id="<?=$item->name?>">
                                  <option value=""> --<?=$item->label?>-- </option>
                                  <?php
                                  foreach ($item->option as $key => $v) {
                                    echo '<option value="'.$v.'">'.$v.'</option>';
                                  }
                                  ?>
                            </select>
                          </div>
                          <?php elseif($item->type=='date'):?>
                          <div class="col-sm-5">
                            <input type="text" name="adv_search[form_<?=$item->name?>]" class="form-control date" placeholder="<?=$item->label?>" id="<?=$item->name?>">
                          </div>
                          <?php elseif($item->type=='text' || $item->type=='email' || $item->type=='textarea'):?>
                          <div class="col-sm-6">
                            <input type="text" name="adv_search[form_<?=$item->name?>]" class="form-control" placeholder="<?=$item->label?>" id="<?=$item->name?>">
                          </div>
                          <div class="col-sm-2 pull-right">
                            <select name="opt[form_<?=$item->name?>]" class="form-control input-sm" readonly>
                              <?php
                                    foreach ($opt as $key => $value) {
                                      $sel = '';
                                      /*if(is_array($search_f)){
                                        $sel = $search_f['opt']['pre_prefix']==$key?'selected':'';
                                      }*/
                                      echo '<option value="'.$key.'" '.$sel.'>'.$value.'</option>';
                                    }
                                  ?>
                            </select>
                          </div>
                          <?php elseif($item->type=='password' || $item->type=='file'):
                            continue;?>
                          <?php endif;?>
                    </div>
                    <?php endforeach;?>
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
				  				<!-- Import form -->
          <?php if($rules['e']||$rules['c']):?>
          <div class="row">
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
          </div>
        <?php endif;?>
					            <div class="box-header">
					              <h3 class="box-title">Data Campaign</h3>
					              <div class="action pull-right">
                          <?php if($rules['e']||$rules['c']):?>
						              <a id="delete-all" title="Delete selected data" class="btn btn-danger btn-sm btn-circle"><i class="fa fa-trash"></i></a>
                          <?php endif;?>
                          <a class="btn btn-primary btn-sm btn-circle" data-toggle="collapse" data-target="#search">
                            <i class="fa fa-search"></i> Search
                          </a>
													<a id="export-dt" class="btn btn-success btn-sm btn-circle">
				                    <i class="fa fa-file-excel-o "></i> Export
				                  </a>
                          <?php if($rules['e']||$rules['c']):?>
						              <a href="#import" data-toggle="collapse" class="btn btn-primary btn-sm btn-circle"><i class="fa fa-upload"></i> Import</a>
						              <a href="<?=base_url('panel/campaign/insert_data/'.$data->campaign_id);?>" class="btn btn-success btn-sm btn-circle"><i class="fa fa-plus"></i> Create</a>
                          <?php endif;?>
						          </div>
					            </div>
							    <div class="box-body table-responsive">
							    	<table id="campaign_data" class="table table-bordered table-striped" style="width: 100%">
						              <thead>
						                <tr>
						                  <th width="20px"></th>
						                  <th width="40px;">NO</th>
						                  <?php
						                  foreach ($form as $key => $value) {
						                  	echo '<th title="'.$value->label.'">'.substr($value->label,0, 25).'</th>';
						                  }
						                  ?>
                              <?php if($rules['e']||$rules['c']):?>
						                  <th width="125px">&nbsp;</th>
                              <?php endif;?>
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
<form id="column-form">
  <?php
    $clabel = array();
    $cname = array();
    foreach ($form as $idx => $f) {
      echo '<input type="hidden" name="col['.$idx.']" value="'.$f->name.'">';
      $cname[]=$f->name;
      echo '<input type="hidden" name="col_name['.$idx.']" value="'.$f->label.'">';
      $clabel[]=$f->label;
    }
  ?>
  </form>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/buttons.colVis.min.js"></script>
<script type="text/javascript">
  function remove(id){
    if (confirm( "Are you sure you want to delete the selected data campaign?" )) {
      $.ajax({
          url : '<?php echo base_url("panel/campaign/delete_data/".$data->campaign_id); ?>',
          type: "POST",
          data : {'data_id':[id]},
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
              if(data.status){
                $().toastmessage('showToast', {
                  text     : 'Delete data success',
                  position : 'top-center',
                  type     : 'success',
                  close    : function () {
                    window.location = "<?=base_url('panel/campaign/detail/'.$data->campaign_id);?>";
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

    $('.date').datepicker({
          dateFormat: 'yy-mm-dd',
          format: 'yyyy-mm-dd',
          //altFormat: "mm-dd-yyyy",
          //appendText: "(yyyy-mm-dd)",
          startDate: '-3d',
          //dateFormat: 'yyyy-mm-dd'
      });
  	$('#importform').submit(function(e){
  		e.preventDefault();
  		$('#importform').hide();
  		$('.progress').show();
  		var data = new FormData(this);
  		$.ajax({
			url : '<?=base_url('panel/campaign/import_data/'.$data->campaign_id)?>',
			type: "POST",
			data : data,
			processData: false,
			contentType: false,
			dataType: 'json',
			success:function(data, textStatus, jqXHR){
			  if(data.status=='ERROR'){
            $().toastmessage('showToast', {
                text     : 'Failed, '+data.errors,
                position : 'top-center',
                type     : 'error',
                close    : function () {
                  //window.location = "<?=current_url() ?>";
                }
            });
        }else if(data.status){
			      $().toastmessage('showToast', {
			          text     : 'Import data Success',
			          position : 'top-center',
			          type     : 'success',
			          close    : function () {
			            location.reload();
			          }
			      });
			  }else{
			    $().toastmessage('showToast', {
			          text     : data.msg,
			          position : 'top-center',
			          type     : 'error',
			      });
			  }
			},
			error: function(jqXHR, textStatus, errorThrown){
        $.post('<?=base_url('logger/writexhrlog')?>', {'act':'submit call','xhr':jqXHR.responseText, 'status':textStatus, 'error':errorThrown});
			  alert('Something goes wrong, ask to your vendor app');
			},
			complete: function(){
				$('#importform').show();
  				$('.progress').hide();
			}
		});
  	});
    <?php
      echo 'var columns = ["'.implode('","',$cname).'"];';
      echo 'var col_name = ["'.implode('","',$clabel).'"];';
    ?>
    function reload_table(){
      var table = $('#campaign_data').DataTable({
        dom: 'Blfrtip',
          buttons: [
              'colvis'
          ],
        "aLengthMenu":  [10, 25, 50, 100, 500, 1000, 2500, 5000],
        "ajax": {
                "url": "<?php echo base_url('panel/campaign/data/'.$data->campaign_id); ?>",
                "type": "POST",
                "data":data_builder(),
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
        <?php
        	$idx = 2;
        	foreach (json_decode($data->form) as $value) {
        		echo '{ "sClass": "center", "aTargets": [ '.$idx.' ], "data":'.$idx.' },'.PHP_EOL;
        		$idx++;
        	}
        ?>
        <?php if($rules['e']||$rules['c']):?>
        	{ "sClass": "center", "aTargets": [ <?=$idx?> ],
          "mRender": function(data, type, full) {
            	return '<a href=<?=base_url('panel/campaign/edit_data/'.$data->campaign_id);?>/' + full[0]
                + ' class="btn btn-info btn-xs btn-col icon-green"><i class="fa fa-pencil"></i> Edit'
                + '</a>'+'<a href="javascript:;" onclick="remove(\'' + full[0] + '\');" id="btn-delete" class="btn btn-danger btn-xs btn-col icon-black"><i class="fa fa-close"></i> ' + 'Delete'
                + '</a>';
          },
          "bSortable": false
        },
      <?php endif;?>
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
      $('#campaign_data').on( 'column-visibility.dt', function ( e, settings, column, state ) {
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
    //action to change all checkbox
    $('.check-all').change(function(){
      $('.check-item').prop('checked', $(this).prop('checked'));
    });
    //action to delete selected items
    $('#delete-all').click(function(){
      if (confirm( 'Are you sure you want to delete the selected data campaign?' )) {
        var data = {};
        var data_id = [];
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
          url : '<?php echo base_url("panel/campaign/delete_data/".$data->campaign_id); ?>',
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
                    window.location = "<?=base_url('panel/campaign/detail/'.$data->campaign_id);?>";
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
    $('form#search_form').on('submit', function(e) {
      e.preventDefault();
      reload_table();
    });
    $('#clear').on('click', function(e) {
      e.preventDefault();
      $('form#search_form input').val('');
      $('form#search_form select').prop('selectedIndex',0);
      $('form#search_form .select2').val('').trigger("change");
      reload_table();
    });

		$('#export-dt').click(function(){
			var ids = '<?php echo $data->campaign_id; ?>';

      $.ajax({
        url:'<?=base_url('panel/campaign/export_detail_campaign/')?>'+ids,
        type:'post',
        data:data_builder(),
        success:function(response){
					/*form_builder();
					console.log('success'+"\n");
					console.log(response);*/
					form_builder();
		      $('#export_form').attr('action','<?=base_url('panel/campaign/export_detail_campaign/')?>'+ids);
		      $('#export_form').submit();
		      $('#export_form').remove();
        },
        error: function(){

        },
        complete:function(){
					/*console.log('complete'+"\n");*/
					/*
					console.log(response);*/
        }
      });
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
      var array = $("#search_form,#column-form").serializeArray();
      $.each(array, function(key, val){
        form += '<input type="hidden" name="'+val.name+'" value="'+val.value+'">';
      });
      form+='</form>';
      $(document.body).append(form);
    }

  });

</script>
