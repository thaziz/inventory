<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
	<section class="content-header">
	    <h1>
	       Anggaran
	      <small> Insert</small>
	    </h1>
	    <ol class="breadcrumb">
	      <li><a href="<?=base_url('panel');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	      <li><a href="<?=base_url('panel/admin');?>">Anggaran</a></li>
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
				        	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_ext">Nama Anggaran *</span></label>
					            <div class="col-sm-5">					             
					              <select class="form-control select2" name="oa_account_id">
					              	<option value="">--Pilih--</option>
					              	<?php foreach ($account as $key => $v): ?>
					              		<option value="<?=$v->id ?>"><?=$v->name ?></option>
					              		
					              	<?php endforeach ?>
					              </select>
					              <span class="info" id="oa_account_id"></span>
					            </div>
				          	</div>


				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">Tahun</label>
					            <div class="col-sm-4">
					              <input type="text" placeholder="Tahun" name="tahun" class="form-control" readonly="" value="<?=date("Y") ?>">
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">Saldo *</label>
					            <div class="col-sm-4">
					              <input type="text" placeholder="Saldo" name = "oa_saldo" id="a_saldo" class="form-control currency">
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
  $(document).ready(function(){
    $('form#admin_form').on('submit', function(e) {
      e.preventDefault();
      $.ajax({
          url : '<?php echo base_url("panel/input_anggaran/insert"); ?>',
          type: "POST",
          data : $('#admin_form').serialize(),
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
              if(!data.status){
                $.each(data.e, function(key, val){
                	$('[name="'+key+'"] + .info').html(val);
                	//if(key=='oa_account_id')
                	$('#'+key).html(val);
                	
                });
              }else{
                $().toastmessage('showToast', {
				    text     : 'Insert data success',
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

  	$(".currency").inputmask({alias : "currency", prefix: '', digits: 0, groupSeparator: "."});
</script>