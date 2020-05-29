<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
	<section class="content-header">
	    <h1>
	       Anggaran
	      <small> Edit</small>
	    </h1>
	    <ol class="breadcrumb">
	      <li><a href="<?=base_url('panel');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	      <li><a href="<?=base_url('panel/input_anggaran');?>">Anggaran</a></li>
	      <li class="active">Edit</li>
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
					        <input type="hidden" name="oa_id"  value="<?=$data->oa_id?>">

				         
					        <input type="hidden" name="oa_account_id_old" value="<?=$data->oa_account_id?>">
				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">Nama Anggaran *</label>
					            <div class="col-sm-4">
					             <select class="form-control select2" name="oa_account_id">
					              	<option>--Pilih--</option>
					              	<?php foreach ($account as $key => $v): ?>
					              		<option
					              		<?php if($data->oa_account_id==$v->id) echo 'selected=""';?>
					              		  value="<?=$v->id ?>"><?=$v->name ?></option>
					              		
					              	<?php endforeach ?>
					              </select>
					              <span class="info"></span>
					            </div>
				          	</div>


				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">Tahun</label>
					            <div class="col-sm-4">
					              <input type="text" placeholder="Tahun" name="tahun" class="form-control" readonly="" value="<?=$data->oa_year?>">
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">Saldo *</label>
					            <div class="col-sm-4">
					              <input class="form-control currency" type="" name = "oa_saldo" value="<?=$data->oa_saldo?>">
					             
					              <span class="info"></span>
					            </div>
				          	</div>

				      

				        </div>
				        <div class="box-footer">
				        	<div class="col-md-2 col-sm-offset-2">
					          <button id = "enter" class="btn btn-primary pull-right" type="submit">Simpan</button>
					          <a href="<?php echo base_url('panel/input_anggaran'); ?>" class="btn btn-default">Kembali</a>
				        	</div>
				        </div>
				      </form>
	  			</div>
	  		</div>
	  	</div>
  </section>
</div>

<script src="<?=base_url('assets')?>/plugins/input-mask/jquery.inputmask.bundle.js"></script>

<script type="text/javascript">

  	$(".currency").inputmask({alias : "currency", prefix: '', digits: 0, groupSeparator: "."});
  $(document).ready(function(){
    $('form#admin_form').on('submit', function(e) {
      e.preventDefault();
      $.ajax({
          url : '<?php echo base_url("panel/input_anggaran/edit").'/'.$data->oa_id; ?>',
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
				    	window.location = "<?=base_url('panel/input_anggaran');?>";
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
