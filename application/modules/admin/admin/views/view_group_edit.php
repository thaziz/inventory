<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style type="text/css">
	.prms label{
		text-align: left !important;
	}
</style>

<div class="content-wrapper">
	<section class="content-header">
	    <h1>
	      Administrator Group
	      <small> Edit</small>
	    </h1>
	    <ol class="breadcrumb">
	      <li><a href="<?=base_url('panel');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	      <li><a href="<?=base_url('panel/admin');?>">Administrator</a></li>
	      <li><a href="<?=base_url('panel/admin/group');?>">Group</a></li>
	      <li class="active">Edit</li>
	    </ol>
  	</section>

  	<section class="content">
	  	<div class="row">
	  		<div class="col-xs-12">
	  			<div class="box">
		            <!--<div class="box-body">
		            	
		            </div>!-->
					<form class="form-horizontal" method="post" id="group_form">
				        <div class="box-header with-border">
					        <input type="hidden" name= "grp_id" value="<?=$data->grp_id;?>">
				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="grp_name">Name *</label>
					            <div class="col-sm-4">
					        	  <input type="hidden" name= "grp_name_old" value="<?=$data->grp_name;?>">
					              <input type="text" placeholder="Name" name= "grp_name" value="<?=$data->grp_name;?>" id="name" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="grp_description">Description</span></label>
					            <div class="col-sm-5">
					              <textarea placeholder="Description" rows="3" name="grp_description" id="description" class="form-control"><?=$data->grp_description;?></textarea>
					              <span class="info"></span>
					            </div>
				          	</div>
				        </div>
				        <div class="box-body">
							<label class="col-sm-11 col-sm-offset-1">Permission :</label>
							<div class="col-sm-9 col-sm-offset-2 prms">
							
								<?php 
								$rule_text = array('v'=>'View', 'a'=>'View All', 'e'=>'Edit', 'd'=>'Delete', 'c'=>'Create', 're'=>'Reload', 'im'=>'Import', 'ex'=>'Export', 'wa'=>'Chat WA');
								foreach ($menu_rule as $key => $value) {
									$main_id = $key;
									/* if menu doesn't have sub menu but have rules */
									if(!isset($value['sub_menu']) && !empty($value['rule_menu'])) {
								?>
						          	<div class="form-group">
						          		<!-- Show main menu name as label -->
							            <label class="col-sm-2 control-label">
							            	<?=$value['menu_name']?>	
							            </label>
							            <!-- Show main menu switch on/off -->
							            <div class="col-sm-2">
							              <label class="switch">
										    <input type="checkbox" <?=isset($rule[$key])?'checked':'';?> name="menu[<?=$key?>]" value="<?=$key?>" class="switch-menu"
												   rel="#<?=str_replace(' ','-',strtolower($value['menu_name']));?>">
										  	<div class="slider round"></div>
										  </label>
							            </div>
							            <div class="col-sm-8" <?=!isset($rule[$key])?'style="display:none;"':'';?> 
							            		id="<?=str_replace(' ','-',strtolower($value['menu_name']));?>">
							            <?php 
							            	  /* show rules as checkboxes */
							           		  foreach (explode('-', $value['rule_menu']) as $v) {?>
									              <label class="icheck-label">
												    <input value="<?=$v?>" name="menu[<?=$key?>][rules][]" class="" type="checkbox" 
												    	<?=$v=='v'?'disabled':'';?> <?=isset($rule[$key][$v])?'checked':'';?>> <?=$rule_text[$v];?>
												  </label>
										<?php } //end foreach menu rules?>
							            </div>
						          	</div>

						        <?php } //end if menu doesn't have sub menu but have rules
						        	/* if menu doesn't have sub menu*/
						        	elseif(isset($value['sub_menu'])){ ?>
						        		<div class="row" style="padding-bottom: 15px;">
						        			<!-- Show main menu name as label -->
										    <label class="col-sm-2 control-label" style="text-decoration: underline;">
										      	<?=$value['menu_name']?>:	
										    </label>
										    <div class="col-sm-2">
									              <label class="switch">
												    <input type="checkbox" class="switch-menu pmenu"
												    	rel=".<?=str_replace(' ','-',strtolower($value['menu_name']));?>">
												  	<div class="slider round"></div>
												  </label>
									        </div>
						        		</div>
						        <?php	
						        		/* show submenu */
						        		foreach ($value['sub_menu'] as $key => $sub_menu){ ?>
						        			<div class="form-group">
						        				<!-- Show sub menu name as label -->
									            <label class="col-sm-2 control-label" style="font-weight: normal; 
									            	padding-left: 25px;">
									            	<?=$sub_menu['menu_name']?>	
									            </label>
									            <!-- Show sub menu switch on/off -->
									            <div class="col-sm-2">
									              <label class="switch">
												    <input type="checkbox" <?=isset($rule[$key])?'checked':'';?> class="switch-menu <?=str_replace(' ','-',strtolower($value['menu_name']));?>"
												    	rel="#<?=str_replace(' ','-',strtolower($sub_menu['menu_name']));?>">
												  	<div class="slider round"></div>
												  </label>
									            </div>
									            <div class="col-sm-8" <?=!isset($rule[$key])?'style="display:none;"':'';?>
									            	id="<?=str_replace(' ','-',strtolower($sub_menu['menu_name']));?>">
									            <?php 
									            	  /* show rules as checkboxes */
									            	  foreach (explode('-', $sub_menu['rule_menu']) as $v){?>
											              <label class="icheck-label">
														    <input value="<?=$v?>" name="smenu[<?=$main_id?>][<?=$key?>][rules][]" class="" type="checkbox" 
														    	<?=$v=='v'?'disabled':'';?> <?=isset($rule[$key][$v])?'checked':'';?>> <?=$rule_text[$v];?>
														  </label>
												<?php } //end foreach sub menu rules ?>
									            </div>
								          	</div>
						       <?php 	} //end foreach sub menus
						        	} //end if have sub menus
						        } //end foreach menus
						        ?>

				          	</div>
				        </div>
				        <div class="box-footer">
				        	<div class="col-md-2 col-sm-offset-2">
					          <button id = "enter" class="btn btn-primary pull-right" type="submit">Enter</button>
					          <a href="<?php echo base_url('panel/admin/group'); ?>" class="btn btn-default">Back</a>
				        	</div>
				        </div>
				      </form>
	  			</div>
	  		</div>
	  	</div>
  </section>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('form#group_form').on('submit', function(e) {
      e.preventDefault();
      var disabled = $(this).find(':input:disabled').removeAttr('disabled');
      var data_form = $(this).serialize();
      disabled.attr('disabled','disabled');
      $.ajax({
          url : '<?php echo base_url("panel/admin/group/edit/".$data->grp_id); ?>',
          type: "POST",
          data : data_form,
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
              if(!data.status){
                $.each(data.e, function(key, val){
                	$('[name="'+key+'"] + .info').html(val);
                });
              }else{
                $().toastmessage('showToast', {
				    text     : 'Edit data success',
				    position : 'top-center',
				    type     : 'success',
				    close    : function () {
				    	window.location = "<?=base_url('panel/admin/group');?>";
				    }
				});
              }
          },
          error: function(jqXHR, textStatus, errorThrown){
              alert('Error,something goes wrong');
          }
      });
    });

    /* switch menu toogle */
    $('.switch-menu:not(.pmenu)').on('change', function(){
    	var rel = $(this).attr('rel');
    	if($(this).prop('checked') === true){
    		$(rel).show();
    		$(rel+' input[type="checkbox"]').prop('checked', false);
    		$(rel+' input[value="v"]').prop('checked', true);
    	}else{
    		$(rel+' input[type="checkbox"]').removeAttr('checked');
    		$(rel).hide();
    	}
    });
    $('.switch-menu.pmenu').on('change', function(){
    	var rel = $(this).attr('rel');
    	if($(this).prop('checked') === true){
    		$(rel+':not(:checked)').click();
    	}else{
    		$(rel+':checked').click();
    	}
    });
    $('.switch-menu.pmenu').each(function(){
    	var rel = $(this).attr('rel');
    	var ls = $(rel+':checked');
    	if(ls.length>0){
    		$(this).prop('checked',true);
    	}
    });
  });
</script>