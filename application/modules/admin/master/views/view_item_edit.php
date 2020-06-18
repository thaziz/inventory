<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
	<section class="content-header">
	    <h1>
	      Barang
	      <small> Edit</small>
	    </h1>
	    <ol class="breadcrumb">
	      <li><a href="<?=base_url('panel');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	      <li><a href="<?=base_url('panel/admin');?>">Barang</a></li>
	      <li class="active">Insert</li>
	    </ol>
  	</section>

  	<section class="content">
	  	<div class="row">
	  		<div class="col-xs-12">
	  			<div class="box">
		            <!--<div class="box-body">
		            	
		            </div>!-->
					<form class="form-horizontal" method="post" id="admin_form">
				        <div class="box-body">


					               <input type="hidden" placeholder="Kode Barang" name = "i_code_old" id="i_code_old" class="form-control" value="<?=$data->i_code?>" readonly>

					                <input type="hidden" placeholder="Nama Barang" name = "i_name_old" id="i_name_old" class="form-control" value="<?=$data->i_name?>" readonly>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">Kode Barang *</label>
					            <div class="col-sm-4">
					            <input type="hidden" placeholder="Kode Barang" name = "i_id" id="i_id" class="form-control" value="<?=$data->i_id?>">
					              <input type="text" placeholder="Kode Barang" name = "i_code" id="i_code" class="form-control" value="<?=$data->i_code?>">

					              <span class="info"></span>
					            </div>
				          	</div>
				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">Nama Barang *</label>
					            <div class="col-sm-4">
					              <input type="text" placeholder="Nama Barang" name = "i_name" id="i_name" class="form-control" value="<?=$data->i_name?>">
					              
					              <span class="info"></span>
					            </div>
				          	</div>

				        


				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_ext">Satuan *</span></label>
					            <div class="col-sm-5">
					            
					            	<select class="form-control" name="i_unit" id="i_unit">
					            		<?php foreach ($satuan as $key => $v): ?>
					            			<?php if ($data->i_unit==$v->name){ ?>
					            				<option selected="" ><?=$v->name ?></option>	
					            			<?php }else{ ?>
					            				<option><?=$v->name ?></option>	
					            			<?php } ?>
					            				
					            		<?php endforeach ?>
					            	

					            		<!-- <option <?php if ($data->i_unit=='PCS'): ?>
					            		selected=""					            			
					            		<?php endif ?>>PCS</option>
					            		<option  <?php if ($data->i_unit=='KG'): ?>
					            		selected=""
					            		<?php endif ?>>KG</option> -->
					            	</select>
					              <span class="info"></span>
					            </div>
				          	</div>

				          <!-- 	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_password">Anggaran *</span></label>
					            <div class="col-sm-5">
					              <input  placeholder="Anggaran" name = "i_anggar" id="i_anggar" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div> -->
<!-- 
				          	<div class="form-group">
				          		<label class="col-sm-2 control-label" for="adm_active">Enabled</label>
				          		<div class = "col-sm-10">
						            	<label class="switch">
						            		<input type="checkbox" name="adm_active" value="1">
						            		<div class="slider round"></div>
						            	</label>
				          		</div>
				          	</div> -->
<!-- 
				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="grp_id">Group *</span></label>
					            <div class="col-sm-4">
					              <select class="form-control" name="grp_id" id="group">
					              	<option value="">-- Select Group --</option>
					              	<?php
					              		if($group){
						              		foreach ($group as $value) {
						              			echo '<option value="'.$value->grp_id.'">'.$value->grp_name.'</option>';
						              		}
						              	}
					              	?>
					              </select>
					              <span class="info"></span>
					            </div>
				          	</div> -->

				        </div>
				        <div class="box-footer">
				        	<div class="col-md-2 col-sm-offset-2">
					          <button id = "enter" class="btn btn-primary pull-right" type="submit">Enter</button>
					          <a href="<?php echo base_url('panel/master'); ?>" class="btn btn-default">Back</a>
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
    $('form#admin_form').on('submit', function(e) {
      e.preventDefault();
      $.ajax({
          url : '<?php echo base_url("panel/master/edit/"); ?>'+'<?=$data->i_id?>',
          type: "POST",
          data : $('#admin_form').serialize(),
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
              if(!data.status){
                $.each(data.e, function(key, val){
                	$('[name="'+key+'"] + .info').html(val);
                });
              }else{
                $().toastmessage('showToast', {
				    text     : 'Update data success',
				    position : 'top-center',
				    type     : 'success',
				    close    : function () {
				    	window.location = "<?=base_url('panel/master');?>";
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