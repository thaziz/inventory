<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- daterange picker -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/materialtimepicker/mdtimepicker.min.css">
<style type="text/css">
  div#form-builder{
    background: #dfdfdf;
    border: 1px solid #ccc;
    width: 100%;
    min-height: 100px;
    padding: 0;
  }
  .text-left{
    text-align: left !important;
  }
  #form-builder .fg{
    background: #fff;
    display: inline-block;
    width: 100%;
    padding-bottom: 10px;
  }
  .pane-btn{
    padding-top:30px;
  }
  .plt-0{
    padding:0 15px 0 0 !important;
  }
  .p-0{
  	padding: 0 !important;
  }
  .pl-0{
  	padding-left: 0 !important;
  }
  .pr-0{
  	padding-right: 0 !important;
  }
  .mt-10{
    margin-top: 10px !important;
  }
  .mb-10{
    margin-bottom: 10px !important;
  }
  .ml-20{
    margin-left: 20px !important;
  }
  .ml-10{
    margin-left: 10px !important;
  }
  .p-0{
    padding:0 !important;
  }
  .pb-10{
    padding-bottom: 10px !important;
  }
</style>
<div class="content-wrapper">
	<section class="content-header">
	    <h1>
	      EDIT CAMPAIGN <?=strtoupper($data->campaign_name)?>
	    </h1>
	    <ol class="breadcrumb">
	      <li><a href="<?=base_url('panel');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	      <li><a href="<?=base_url('panel/campaign');?>">Campaign</a></li>
	      <li class="active">Edit</li>
	    </ol>
  	</section>

  	<section class="content">
	  	<div class="row">
	  		<div class="col-xs-12">
	  			<div class="box">
		            <!--<div class="box-body">
		            	
		            </div>!-->
					<form class="form-horizontal" method="post" id="campaign_form">
				        <div class="box-body">
				          	<div class="form-group">
					            <label class="col-sm-2 col-xs-4 control-label" for="campaign_name">Name <span class="required">*</span></label>
					            <div class="col-sm-4  col-xs-8">
					              <input type="text" placeholder="Name" name="campaign_name" id="campaign_name" class="form-control" value="<?=$data->campaign_name?>">
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 col-xs-4 control-label" for="date_range">Range Date <span class="required">*</span></label>
					            <div class="col-sm-4  col-xs-8">
				              		<div class="input-group">
				              			<input type="text" name="date_range" id="date_range" class="form-control" value="<?=date('F d, Y', strtotime($data->start_date)).' - '.date('F d, Y', strtotime($data->end_date))?>">
				              			<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				              		</div>
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 col-xs-4 control-label" for="schedule_perday">Schedule per Day <span class="required">*</span></label>
					            <div class="col-sm-4  col-xs-8">
					            	<div class="row">
					            		<div class="col-xs-12 col-sm-6">
						              		<div class="input-group">
							                    <input type="text" name="stime_perday" class="form-control timepicker" value="<?=date('h:i A', strtotime($data->stime_perday))?>">
							                    <div class="input-group-addon">
							                      <i class="fa fa-clock-o"></i>
							                    </div>
							                </div>
							            </div>
					            		<div class="col-xs-12 col-sm-6">
						              		<div class="input-group">
							                    <input type="text" name="etime_perday" class="form-control timepicker" value="<?=date('h:i A', strtotime($data->etime_perday))?>">
							                    <div class="input-group-addon">
							                      <i class="fa fa-clock-o"></i>
							                    </div>
							                </div>
							            </div>
							        </div>
					              	<span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 col-xs-4 control-label" for="retries">Retries <span class="required">*</span></label>
					            <div class="col-sm-2  col-xs-4">
				              		<input type="number" name="retries" id="retries" class="form-control" value="<?=$data->retries?>">
					              	<span class="info"></span>
					            </div>
				          	</div>

                    <?php if($rules['a']):?>
                    <div class="form-group">
                      <label class="col-sm-2 col-xs-4 control-label" for="retries">Supervisi <span class="required">*</span></label>
                      <div class="col-sm-2  col-xs-4">
                          <select name="spv_id" class="form-control">
                            <option value=""> --Supervisi-- </option>
                            <?php foreach ($spv as $key => $value) {
                              $sel = '';
                              $sel = $data->spv_id==$value->adm_id?'selected':'';
                              echo '<option value="'.$value->adm_id.'" '.$sel.'>'.$value->adm_name.'</option>';
                            }
                            ?>
                          </select>
                          <span class="info"></span>
                      </div>
                    </div>
                    <?php endif;?>

                   
                    <!--div class="form-group">
                      <label class="col-sm-2 col-xs-4 control-label" for="queue">Queue <!- <span class="required">*</span> -></label>
                      <!-div class="col-sm-2  col-xs-4">
                          <!-<input type="number" name="queue" id="queue" class="form-control"> -->
                          <!--select class="form-control" name="queue" id="queue">
                            <option value="">--</option>
                          </select>
                          <span class="info"></span>
                      </div>
                    </div-->

                    <div class="form-group">
                      <label class="col-sm-2 col-xs-4 control-label" for="queue">Outbond Type <span class="required">*</span></label>
                      <div class="col-sm-2  col-xs-4">
                          <!-- <input type="number" name="queue" id="queue" class="form-control"> -->
                          <select class="form-control" name="outbound_type" id="outbound_type">
                            <?php
                              $sel = '';
                              $opt = '';
                              foreach ($arr_outbound as $i => $value) {
                                $sel = ($i == $data->outbound_type) ? 'selected' : '';
                                $opt .= '<option '.$sel.' value = '.$i.'>'.$value.'</option>';
                              }
                              echo $opt;
                            ?>
                          </select>
                          <span class="info"></span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 col-xs-4 control-label" for="target_per_month">Target per Month</label>
                      <div class="col-sm-2  col-xs-4">
                          <input type="text" name="target_per_month" id="target_per_month" class="form-control">
                          <span class="info"></span>
                      </div>
                    </div>

				          	<div class="form-group">
					            <label class="col-sm-2 col-xs-4 control-label" for="script">Script <span class="required">*</span></label>
					            <div class="col-sm-6  col-xs-12">
					              <textarea name="script" class="form-control" id="script"><?=$data->script?></textarea>
					              <span class="info"></span>
					            </div>
				          	</div>



                    <div class="form-group">
                      <label class="col-sm-2 col-xs-4 control-label" for="ivr_template">SMS Enabled <!-- <span class="required">*</span> --></label>
                      <div class="col-sm-6  col-xs-12">
                          <label class="switch">
                          <input type="checkbox" id="sms_enabled" name="sms_enabled" value="1" class="switch-menu" <?=isset($data->sms_enabled)?($data->sms_enabled==1?'checked':''):'checked'?>>
                                <div class="slider round"></div>
                              </label>
                        <span class="info"></span>
                      </div>
                    </div>

                    <div class="form-group" id="sms_script_pane" <?=isset($data->sms_enabled)?($data->sms_enabled==1?'':'style="display:none;"'):'style="display:none;"'?>>
                      <label class="col-sm-2 col-xs-4 control-label" for="sms_script">SMS Script <span class="required">*</span></label>
                      <div class="col-sm-6  col-xs-12">
                        <textarea name="sms_script" class="form-control" id="sms_script" rows="5"><?=$data->sms_script?></textarea>
                        <span class="info"></span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 col-xs-4 control-label" for="wa_enabled">WA Enabled <!-- <span class="required">*</span> --></label>
                      <div class="col-sm-6  col-xs-12">
                          <label class="switch">
                          <input type="checkbox" id="wa_enabled" name="wa_enabled" value="1" class="switch-menu" <?=isset($data->wa_enabled)?($data->wa_enabled==1?'checked':''):'checked'?>>
                                <div class="slider round"></div>
                              </label>
                        <span class="info"></span>
                      </div>
                    </div>

                    <?php if(false):?>
                    <div class="form-group">
                      <label class="col-sm-2 col-xs-4 control-label" for="ivr_template">IVR Template <span class="required">*</span></label>
                      <div class="col-sm-2  col-xs-12">
                          <select name="ivr_template" class="form-control" id="ivr_template">
                            <option value="">--</option>
                            <?php
                              $opt = '';

                              for ($i=0; $i < count($ivr_template); $i++) {
                                $sel = ($ivr_template[$i]->id == $data->ivr_template) ? 'selected' : '';
                                $opt .= '<option '.$sel.' value='.$ivr_template[$i]->id.'>'.$ivr_template[$i]->ivr_name.'</option>';
                              }
                              echo $opt;
                            ?>
                          </select>
                        <span class="info"></span>
                      </div>
                    </div>
                  <?php endif;?>
                    <div class="form-group">
                      <label class="col-sm-2 col-xs-4 control-label" for="ivr_template">Status <!-- <span class="required">*</span> --></label>
                      <div class="col-sm-6  col-xs-12">
                          <label class="switch">
                            <input type="checkbox" name="status" value="1" class="switch-menu" <?=isset($data->status)?($data->status==1?'checked':''):'checked'?>>
                              <div class="slider round"></div>
                          </label>
                        <span class="info"></span>
                      </div>
                    </div>

				          	<div class="form-group" id="builder">
                      <div class="col-md-11 col-md-offset-1">
                        <div class="row" style="padding-bottom: 15px;">
                          <label class="col-md-2 control-label text-left">Form Builder</label>
                          <div class="col-md-10">
                            <!--button type="button" class="btn btn-primary pull-right" id="add_item" style="margin-right: 25px;">Add Form Item</button-->

                          </div>
                        </div>
                        <div id="form-builder" class="col-md-8">
                          <?php 
                            $form = json_decode($data->form);
                            $type = array('text'=>'Text', 'number'=>'Number', 'date'=>'Date', 'datetime'=>'Date Time', 'time'=>'Time', 'email'=>'Email', 'password'=>'Password', 'textarea'=>'Text Area', 'dropdown'=>'Dropdown', 'radio'=>'Radio Button', 'checkbox'=>'Checkbox', 'file'=>'File Upload');
                            $idx=0;
                            foreach ($form as $key => $item) : $idx++;?>
                              <div class="fg">
                              <div class="col-md-2">
                                <label class="control-label">Name</label>
                                <input type="text" name="el[<?=$idx?>][name]" class="form-control input-sm" value="<?=$item->label?>">
                              </div>
                              <div class="col-md-2 pl-0">
                                <label class="control-label">Type</label>
                                <select name="el[<?=$idx?>][type]" class="form-control typedrop input-sm" id="type-'<?=$idx?>" data-opt="#options<?=$idx?>" data-id="<?=$idx?>">
                                  <?php foreach ($type as $key => $t) {
                                    $sel = $key == $item->type?'selected':'';
                                    echo '<option value="'.$key.'" '.$sel.'>'.$t.'</option>';
                                  }?>
                                </select>
                              </div>
                              <div class="col-md-1 pl-0" style="padding-left: 0;">
                                <label class="control-label">Required</label>
                                <input type="checkbox" name="el[<?=$idx?>][required]" value="1" class="mt-10 ml-20" <?=isset($item->required)?'checked':''?> data-id="#def<?=$idx?>">
                              </div>
                              <div class="col-md-2 pl-0"><label class="control-label">Default</label><input type="text" name="el[<?=$idx?>][default]" id="def<?=$idx?>" class="form-control input-sm" <?=isset($item->required)?'disabled':''?> value="<?=trim(isset($item->default)?$item->default:'')?>"></div>
                              <div class="col-md-3 p-0">
                                <label class="control-label">Options</label>
                                <div class="col-md-12 p-0" id="options<?=$idx?>">
                                <?php if($item->type=='number'):?>
                                      <div class="col-md-6 plt-0"><input type="number" name="el[<?=$idx?>][min]" class="form-control input-sm" placeholder="Min" value="<?=isset($item->min)?$item->min:''?>"></div><div class="col-md-6 plt-0"><input type="number" name="el[<?=$idx?>][max]" class="form-control input-sm" placeholder="Max" value="<?=isset($item->max)?$item->max:''?>"></div>
                                <?php elseif($item->type=='textarea'):?>
                                      <div class="col-md-6 plt-0"><input type="number" name="el[<?=$idx?>][cols]" class="form-control input-sm" placeholder="Columns"  value="<?=isset($item->cols)?$item->cols:''?>"></div><div class="col-md-6 plt-0"><input type="number" name="el[<?=$idx?>][rows]" class="form-control input-sm" placeholder="Rows" value="<?=isset($item->rows)?$item->rows:''?>"></div>
                                <?php elseif($item->type=='dropdown'):?>
                                      <div class="col-md-12 plt-0 drp-opt">
                                        <!--div class="col-sm-4 pl-0">
                                          <select class="drp form-control" style="padding:1px 5px;height:25px" name="el[<?=$idx?>][optype]" data-pane="#opt<?=$idx?>" data-id="<?=$idx?>">
                                            <option value="0" <?=isset($item->optype)?($item->optype==0?'selected':''):''?>>Data</option>
                                            <option value="1"<?=isset($item->optype)?($item->optype==1?'selected':''):''?>>Json URL</option>
                                          </select>
                                        </div-->
                                        <button class="btn btn-default btn-xs btnadd mb-10" type="button" data-pane="#opt<?=$idx?>" data-id="<?=$idx?>" <?=isset($item->optype)?($item->optype==1?'disabled':''):''?>><i class="fa fa-plus"></i> Add Option</button>
                                      </div>
                                      <div class="col-md-8 plt-0" id="opt<?=$idx?>">
                                        <?php if(isset($item->optype) && $item->optype==1):?>
                                        <!--input type="text" name="el[<?=$idx?>][source]" class="form-control" placeholder="Source" value="<?=$item->source?>"-->
                                        <?php else:?>
                                          <?php 
                                          if(isset($item->option)):
                                            foreach ($item->option as $opt) :?>
                                            <div class="input-group input-group-sm mb-10"><input type="text" name="el[<?=$idx?>][option][]" class="form-control input-sm" placeholder="Option" value="<?=$opt?>"><span class="input-group-btn"><button class="btn btn-danger" type="button" onclick="$(this).closest('.input-group').remove();"><i class="fa fa-times"></i></button></span></div>
                                          <?php endforeach;
                                          else:?>
                                            <div class="input-group input-group-sm mb-10"><input type="text" name="el[<?=$idx?>][option][]" class="form-control input-sm" placeholder="Option"><span class="input-group-btn"><button class="btn btn-danger" type="button" onclick="$(this).closest('.input-group').remove();"><i class="fa fa-times"></i></button></span></div>
                                        <?php endif;?>
                                        <?php endif;?>
                                      </div>
                                <?php elseif($item->type=='radio' || $item->type=='checkbox'):?>
                                      <div class="col-md-12 plt-0"><button class="btn btn-default btn-xs btnadd mb-10" type="button" data-pane="#opt<?=$idx?>" data-id="<?=$idx?>"><i class="fa fa-plus"></i> Add Option</button></div>
                                      <div class="col-md-8 plt-0" id="opt<?=$idx?>">
                                      <?php foreach ($item->option as $opt) :?>
                                        <div class="input-group input-group-sm mb-10"><input type="text" name="el[<?=$idx?>][option][]" class="form-control input-sm" placeholder="Option" value="<?=$opt?>"><span class="input-group-btn"><button class="btn btn-danger" type="button" onclick="$(this).closest('.input-group').remove();"><i class="fa fa-times"></i></button></span></div>
                                      <?php endforeach;?>
                                      </div>
                                <?php elseif($item->type=='file'||$item->type=='date'||$item->type=='datetime'||$item->type=='time'):?>
                                <?php else:?>
                                      <div class="col-md-6 plt-0"><input type="number" name="el[<?=$idx?>][min]" class="form-control input-sm" placeholder="Min Length" value="<?=isset($item->min)?$item->min:''?>"></div><div class="col-md-6 plt-0"><input type="number" name="el[<?=$idx?>][max]" class="form-control input-sm" placeholder="Max Length" value="<?=isset($item->max)?$item->max:''?>"></div>
                                <?php endif;?>
                                </div>
                              </div>
                              <div class="col-md-1 p-0" style="width:30px"><label class="control-label" style="text-align:center">Call</label><input type="checkbox" name="el[<?=$idx?>][call]" value="1" class="mt-10 ml-10"<?=isset($item->call)?'checked':''?>></div>
                              <div class="col-md-1 p-0" style="width:30px"><label class="control-label" style="text-align:center">Editable</label><input type="checkbox" name="el[<?=$idx?>][editable]" value="1" class="mt-10 ml-10"<?=isset($item->editable)?'checked':''?>></div>
                              <div class="col-md-1 p-0" style="width:30px;margin-left:45px;"><label class="control-label" style="text-align:center">MF</label><input type="checkbox" name="el[<?=$idx?>][mf]" value="1" class="mt-10 ml-10"<?=isset($item->mf)?'checked':''?>></div>
                              <div class="col-md-1 pull-right pane-btn" style="width:30px;">
                                <button type="button" class="btn btn-xs btn-danger pull-right" onclick="$(this).closest('.fg').remove();"><i class="fa fa-trash"></i></button>
                              </div>
                            </div>
                            <?php endforeach;?>
                            
                        </div>
                        <input type="hidden" name="form">
                        <span class="info"></span>
                      </div>
                    </div>

				        </div>
				        <div class="box-footer">
				        	<div class="col-md-2 col-sm-offset-2">
					          <button id = "enter" class="btn btn-primary pull-right" type="submit">Enter</button>
					          <a href="<?php echo base_url('panel/campaign'); ?>" class="btn btn-default">Back</a>
				        	</div>
				        </div>
				      </form>
	  			</div>
	  		</div>
	  	</div>
  </section>
</div>
<!-- date-range-picker -->
<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script><!-- bootstrap time picker -->
<script src="<?php echo base_url(); ?>assets/plugins/materialtimepicker/mdtimepicker.min.js"></script>
<!-- CKEditor -->
<script src="<?php echo base_url(); ?>assets/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
  $(document).ready(function(){

    $.get( "<?php echo base_url('panel/campaign/get_queue'); ?>", function( data ) {
      var obj   = JSON.parse(data);
      var queue_id  = obj.queue_id;
      var opt     = '';
      var sel = '';
      var q = '<?php echo $data->queue_id; ?>';

      $('#queue').empty();

      opt   +=  '<option value = "">--</option>';

      for (var i = 0; i < queue_id.length; i++) {
        
        if(q == queue_id[i]){
          sel = 'selected';
          opt   +=  '<option '+sel+' value = '+queue_id[i]+'>'+queue_id[i]+'</option>';
        }else{
          opt   +=  '<option value = '+queue_id[i]+'>'+queue_id[i]+'</option>';
        }
        
      }

      $('#queue').append(opt);
    });
//disabled edit form
  <?php if($tbl_exist):?>
    $('#form-builder input').prop('disabled', true);
    $('#form-builder .form-control').prop('disabled', true);
    $('#form-builder .btn').prop('disabled', true);
  <?php endif;?>
  	//Date range picker with time picker
    $('#date_range').daterangepicker({ 
    	locale: {
           	format: 'MMMM DD, YYYY'
        }
    });


    $('#sms_enabled').change(function(){
      if($(this).prop('checked')){
        $('#sms_script_pane').show();
      }else{
        alert('This will delete previous sms data, are you sure?');
        $('#sms_script_pane').hide();
      }
    });

    $('#wa_enabled').change(function(){
      if(!$(this).prop('checked')){
        alert('This will delete previous wa chat data, are you sure?');
      }
    });

    /*$('#queue').select2({
      placeholder: 'Select the queue',
      minimumResultsForSearch: -1
    });*/

    //Timepicker
    $('.timepicker').mdtimepicker();

    var toolbars = [{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline'] },{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },{ name: 'links', items: [ 'Link', 'Unlink' ] },];
	CKEDITOR.replace('script', {height:130,toolbar: toolbars,removePlugins: 'elementspath',resize_enabled: false});
  /*CKEDITOR.replace('ivr_template', {height:130,toolbar: toolbars,removePlugins: 'elementspath',resize_enabled: false});*/

    $('form#campaign_form').on('submit', function(e) {
      e.preventDefault();
      var script = CKEDITOR.instances['script'].getData();
	   $('[name="script"]').val(script);
     /*var ivr_template = CKEDITOR.instances['ivr_template'].getData();
      $('[name="ivr_template"]').val(ivr_template);*/
	  //console.log($('#campaign_form').serialize());
      $.ajax({
          url : '<?php echo current_url() ?>',
          type: "POST",
          data : $('#campaign_form').serialize(),
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
              if(!data.status){
                $.each(data.e, function(key, val){
                	$('[name="'+key+'"]').closest('.form-group').find('.info').html(val);
                });
              }else{
                $().toastmessage('showToast', {
				    text     : 'Edit campaign success',
				    position : 'top-center',
				    type     : 'success',
				    close    : function () {
				    	window.location = "<?=base_url('panel/campaign/dashboard/');?>"+data.id;
				    }
				});
              }
          },
          error: function(jqXHR, textStatus, errorThrown){
              alert('Error,something goes wrong');
          }
      });
    });
  });
</script>
<script type="text/javascript">
  /*var idx = 0;
  $('#add_item').click(function(){
    idx++;
    $.when($('#form-builder').append('<div class="fg"><div class="col-md-3"><label class="control-label">Name</label><input type="text" name="el['+idx+'][name]" class="form-control input-sm"></div><div class="col-md-2 pl-0"><label class="control-label">Type</label><select name="el['+idx+'][type]" class="form-control input-sm" id="type-'+idx+'" data-opt="#options'+idx+'" data-id="'+idx+'"><option value="text">Text</option><option value="number">Number</option><option value="date">Date Chooser</option><option value="email">Email</option><option value="password">Password</option><option value="textarea">Text Area</option><option value="dropdown">Dropdown</option><option value="radio">Radio Button</option><option value="checkbox">Checkbox</option><!--option value="file">File Upload</option--></select></div><div class="col-md-1 pl-0"><label class="control-label">Required</label><input type="checkbox" name="el['+idx+'][required]" value="1" data-id="#def'+idx+'" class="req mt-10 ml-20"></div><div class="col-md-2 pl-0"><label class="control-label">Default</label><input type="text" name="el['+idx+'][default]" id="def'+idx+'" class="form-control input-sm"></div><div class="col-md-3 p-0"><label class="control-label">Options</label><div class="col-md-12 p-0" id="options'+idx+'"><div class="col-md-6 plt-0"><input type="number" name="el['+idx+'][min]" class="form-control input-sm" placeholder="Min Length"></div><div class="col-md-6 plt-0"><input type="number" name="el['+idx+'][max]" class="form-control input-sm" placeholder="Max Length"></div></div></div><div class="col-md-1 p-0" style="width:30px"><label class="control-label" style="text-align:center">Call</label><input type="checkbox" name="el['+idx+'][call]" value="1" class="mt-10 ml-10"></div><div class="col-md-1 pull-right pane-btn" style="width:30px"><button type="button" class="btn btn-xs btn-danger pull-right" onclick="$(this).closest(\'.fg\').remove();"><i class="fa fa-trash"></i></button></div></div>')).then(function(){
    	$('.req').change(function(e){
    		e.stopImmediatePropagation();
    		var defid = $(this).data('id');
    		var checked = $(this).prop('checked');
    		$(defid).prop('disabled', checked);
    	});
      $('#type-'+idx).change(function(){
        var type = $(this).val();
        var rel = $(this).data('opt');
        var itemid = $(this).data('id');

        var html = '';
        if(type=='number'){
          html = '<div class="col-md-6 plt-0"><input type="number" name="el['+itemid+'][min]" class="form-control input-sm" placeholder="Min"></div><div class="col-md-6 plt-0"><input type="number" name="el['+itemid+'][max]" class="form-control input-sm" placeholder="Max"></div>';
          $(rel).html(html);
        }else if(type=='textarea'){
          html = '<div class="col-md-6 plt-0"><input type="number" name="el['+itemid+'][cols]" class="form-control input-sm" placeholder="Columns"></div><div class="col-md-6 plt-0"><input type="number" name="el['+itemid+'][rows]" class="form-control input-sm" placeholder="Rows"></div>';
          $(rel).html(html);
        }else if(type=='dropdown'){
          html = '<div class="col-md-12 plt-0 drp-opt"><!--div class="col-sm-5 pl-0"><select class="drp form-control" style="padding:1px 5px;height:25px" name="el['+itemid+'][optype]" data-pane="#opt'+itemid+'"><option value="0">Data</option><option value="1">Json URL</option></select></div--><button class="btn btn-default btn-xs btnadd mb-10" type="button" data-pane="#opt'+itemid+'" data-id="'+itemid+'"><i class="fa fa-plus"></i> Add Option</button></div> <div class="col-md-12 plt-0 drp-data" id="opt'+itemid+'"><div class="input-group input-group-sm mb-10"><input type="text" name="el['+itemid+'][option][]" class="form-control" placeholder="Option"><span class="input-group-btn"><button class="btn btn-danger" type="button" onclick="$(this).closest(\'.input-group\').remove();"><i class="fa fa-times"></i></button></span></div></div>';
          $(rel).html(html);
          $('.drp').change(function(){
            var pane = $(this).data('pane');
            if($(this).val()==0){
              $(this).closest('.col-md-12').find('.btnadd').prop('disabled', false);
              $(pane).html('<div class="input-group input-group-sm mb-10"><input type="text" name="el['+itemid+'][option][]" class="form-control" placeholder="Option"><span class="input-group-btn"><button class="btn btn-danger" type="button" onclick="$(this).closest(\'.input-group\').remove();"><i class="fa fa-times"></i></button></span></div>');
            }else{
              $(this).closest('.col-md-12').find('.btnadd').prop('disabled', true);
              $(pane).html('<input type="text" name="el['+itemid+'][source]" class="form-control input-sm" placeholder="Source">');
            }
          });

          $('.btnadd').click(function(e){
            e.stopImmediatePropagation();
            var rl = $(this).data('pane');
            var itm = $(this).data('id');
              $(rl).append('<div class="input-group input-group-sm mb-10"><input type="text" name="el['+itm+'][option][]" class="form-control" placeholder="Option"><span class="input-group-btn"><button class="btn btn-danger" type="button" onclick="$(this).closest(\'.input-group\').remove();"><i class="fa fa-times"></i></button></span></div>');
          })
        }else if(type=='radio' || type=='checkbox'){
          html = '<div class="col-md-12 plt-0"><button class="btn btn-default btn-xs btnadd mb-10" type="button" data-pane="#opt'+itemid+'" data-id="'+itemid+'"><i class="fa fa-plus"></i> Add Option</button></div> <div class="col-md-8 plt-0" id="opt'+itemid+'"><div class="input-group input-group-sm mb-10"><input type="text" name="el['+itemid+'][option][]" class="form-control" placeholder="Option"><span class="input-group-btn"><button class="btn btn-danger" type="button" onclick="$(this).closest(\'.input-group\').remove();"><i class="fa fa-times"></i></button></span></div></div>';
          $(rel).html(html);
          $('.btnadd').click(function(e){
            e.stopImmediatePropagation();
            var rl = $(this).data('pane');
            var itm = $(this).data('id');
              $(rl).append('<div class="input-group input-group-sm mb-10"><input type="text" name="el['+itm+'][option][]" class="form-control" placeholder="Option"><span class="input-group-btn"><button class="btn btn-danger" type="button" onclick="$(this).closest(\'.input-group\').remove();"><i class="fa fa-times"></i></button></span></div>');
          })
        }else if(type=='file' || type=='date'){
          html = '';
          $(rel).html(html);
        }else{
          html = '<div class="col-md-6 plt-0"><input type="number" name="el['+itemid+'][min]" class="form-control input-sm" placeholder="Min Length"></div><div class="col-md-6 plt-0"><input type="number" name="el['+itemid+'][max]" class="form-control input-sm" placeholder="Max Length"></div>';
          $(rel).html(html);
        }
      })
    });
  })*/
</script>