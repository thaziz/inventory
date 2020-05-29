<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- daterange picker -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/materialtimepicker/mdtimepicker.min.css">
<div class="content-wrapper">
	<section class="content-header">
	    <h1>
	      <?=isset($data)?'EDIT':'ADD'?> DATA CAMPAIGN <?=strtoupper($campaign->campaign_name)?>
	    </h1>
	    <ol class="breadcrumb">
	      <li><a href="<?=base_url('panel');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url('panel/campaign');?>">Campaign</a></li>
	      <li><a href="<?=base_url('panel/campaign/detail/'.$campaign->campaign_id);?>">Detail</a></li>
	      <li class="active"><?=isset($data)?'Edit Data':'Add Data'?></li>
	    </ol>
  	</section>

  	<section class="content">
	  	<div class="row">
	  		<div class="col-xs-12">
	  			<div class="box">
		            <!--<div class="box-body">
		            	
		            </div>!-->
					   <form class="form-horizontal" method="post" id="data_form">
				        <div class="box-body">
                  <?php 
                    $form = json_decode($campaign->form);
                    $idx=0;
                    foreach ($form as $key => $item) :?>
                      <?php //if(isset($data) || !isset($item->editable)):?>
                      <div class="form-group">
                        <label class="col-sm-2 col-xs-4 control-label" for="campaign_name"><?=$item->label?> <?=isset($item->required)&&!isset($item->editable)?'<span class="required">*</span>':''?></label>
  
                        <div class="col-sm-4  col-xs-8">
                          <?php if($item->type=='number'):?>
                            <input type="number" name="<?=$item->name?>" class="form-control" placeholder="<?=$item->label?>" min="<?=$item->min?>" max="<?=$item->max?>" value="<?=isset($data)?$data->{'form_'.$item->name}:''?>">
                          <?php elseif($item->type=='textarea'):?>
                            <textarea name="<?=$item->name?>" class="form-control" cols="<?=$item->cols?>" rows="<?=$item->rows?>"><?=isset($data)?$data->{'form_'.$item->name}:''?></textarea>
                          <?php elseif($item->type=='dropdown'):?>
                                <select class="form-control" name="<?=$item->name?>">
                                  <option value=""> --<?=$item->label?>-- </option>
                                  <?php 
                                  foreach ($item->option as $key => $v) {
                                    echo '<option value="'.$v.'">'.$v.'</option>';
                                  } 
                                  ?>
                                </select>
                          <?php elseif($item->type=='radio'):
                                  foreach ($item->option as $key => $v) {
                                    echo '<label class="radio"><input type="radio" name="'.$item->name.'" value="'.$v.'">'.$v.'</label>';
                                  }
                                elseif($item->type=='checkbox'):
                                  foreach ($item->option as $key => $v) {
                                    echo '<label class="checkbox"><input type="checkbox" name="'.$item->name.'[]" value="'.$v.'">'.$v.'</label>';
                                  }
                                elseif($item->type=='file'):?>
                              <?php 
                              if(isset($data)){
                                echo '<span>'.(isset($data)?$data->{'form_'.$item->name}:'').'</span>';
                                echo '<input type="hidden" name="<?=$item->name?>" value="'.(isset($data)?$data->{'form_'.$item->name}:'').'">';
                              }
                              ?>
                              <input type="file" name="<?=$item->name?>" class="form-control">
                          <?php elseif($item->type=='date'):?>
                            <input type="text" name="<?=$item->name?>" class="form-control date" placeholder="<?=$item->label?>" value="<?=isset($data)?$data->{'form_'.$item->name}:''?>">

                          <?php elseif($item->type=='datetime'):?>
                            <input type="text" name="<?=$item->name?>" class="form-control datetime" placeholder="<?=$item->label?>" value="<?=isset($data)?$data->{'form_'.$item->name}:''?>">

                          <?php elseif($item->type=='time'):?>
                            <input type="text" name="<?=$item->name?>" class="form-control timepicker" placeholder="<?=$item->label?>" value="<?=isset($data)?$data->{'form_'.$item->name}:''?>">

                          <?php elseif($item->type=='text'):?>
                            <input type="text" name="<?=$item->name?>" class="form-control" placeholder="<?=$item->label?>" value="<?=isset($data)?$data->{'form_'.$item->name}:''?>">
                          <?php elseif($item->type=='amount'):?>
                            <input type="text" name="<?=$item->name?>" class="form-control amount" placeholder="<?=$item->label?>" value="<?=isset($data)?$data->{'form_'.$item->name}:''?>">
                          <?php elseif($item->type=='password'):?>
                            <input type="password" name="<?=$item->name?>" class="form-control" placeholder="<?=$item->label?>" value="<?=isset($data)?$data->{'form_'.$item->name}:''?>">
                          <?php elseif($item->type=='email'):?>
                            <input type="email" name="<?=$item->name?>" class="form-control" placeholder="<?=$item->label?>" value="<?=isset($data)?$data->{'form_'.$item->name}:''?>">
                          <?php endif;?>
                          <?php
                          if(isset($item->required)){
                            echo '<span class="info"></span>';
                          }
                          ?>
                        </div>
                      </div>
                      <?php// endif;?>
                    <?php endforeach;?>
                    <?php if(isset($data)):?>
                    <div class="form-group">
                        <label class="col-sm-2 col-xs-4 control-label" for="status">Status </label>
                        <div class="col-sm-4  col-xs-8">
                          <select class="form-control" name="estatus">
                            <option value="" <?=$data->status==''||$data->status==NULL?'selected':''?>> Incomplete </option>
                            <option value="Complete" <?=$data->status=='Complete'?'selected':''?>> Complete </option>
                          </select>
                        </div>
                    </div>
                    <?php endif;?>
				        </div>
				        <div class="box-footer">
				        	<div class="col-md-2 col-sm-offset-2">
					          <button id = "enter" class="btn btn-primary pull-right" type="submit">Enter</button>
					          <a href="<?php echo base_url('panel/campaign/detail/'.$campaign->campaign_id); ?>" class="btn btn-default">Back</a>
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
<script src="<?=base_url('assets')?>/plugins/input-mask/jquery.inputmask.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
  $(function(){
    $(".amount").inputmask({alias : "currency", prefix: '', digits: 0, groupSeparator: "."});
  })
  $('.date').datepicker({autoclose:true,format: 'yyyy-mm-dd'});
  $('.datetime').daterangepicker({
    "singleDatePicker": true,
    "timePicker": true,
    "locale": {
      format: 'Y-M-DD hh:mm:ss'
    }
  });
  $('.timepicker').mdtimepicker();
  $('#data_form').submit(function(e){
    e.preventDefault();
    var data = new FormData(this);
    $.ajax({
      url: '<?=current_url()?>',
      type: 'post',
      dataType: 'json',
      data: data,
      processData: false,
      contentType: false,
    })
    .done(function(data){
      if(data.status){
          $().toastmessage('showToast', {
              text     : '<?=isset($data)?'Edit':'Create'?> Data Success',
              position : 'top-center',
              type     : 'success',
              close    : function () {
                window.location = "<?=base_url('panel/campaign/detail/'.$campaign->campaign_id);?>";
              }
          });
      }else{
        $.each(data.e, function(key,msg){
          $('[name="'+key+'"]').closest('.form-group').find('.info').html(msg);
        })
      }
    })
    .fail(function(xhr,error,status){
      $.post('<?=base_url('logger/writexhrlog')?>', {'act':'save data','xhr':xhr.responseText, 'status':status, 'error':error});
      alert('Error,something goes wrong');
    })
  })
</script>