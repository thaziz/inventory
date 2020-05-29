<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
	<section class="content-header">
	    <h1>
	       Transaksi
	      <small> Insert</small>
	    </h1>
	    <ol class="breadcrumb">
	      <li><a href="<?=base_url('panel');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	      <li><a href="<?=base_url('panel/admin');?>">Transaksi</a></li>
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
				        	<input type="" name="t_id" value="<?=$data->t_id?>">
				        	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_ext">Nama Anggaran *</span></label>
					            <div class="col-sm-5">					             
					              <select class="form-control select2" name="t_a_code">
					              	<option value="">--Pilih--</option>
					              	<?php foreach ($account as $key => $v){
					              		$selected='';

					              		if($v->id==$data->t_a_code)
					              			$selected="selected=''";

					              	echo '<option  value="'.$v->id.'" '.$selected.'>'.$v->name.'</option>';
					              		
					              	} ?>
					              </select>
					              <span class="info" id="account_id"></span>
					            </div>
				          	</div>


				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">Tahun</label>
					            <div class="col-sm-4">
					              <input type="text" placeholder="Tahun" name="t_tahun" class="form-control" readonly="" value="<?=$data->t_year?>">
					              <span class="info"></span>
					            </div>
				          	</div>

				      

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">Saldo *</label>
					            <div class="col-sm-4">
					              <input type="text" placeholder="Saldo" name = "t_nominal" id="t_nominal" class="form-control currency" value="<?=$data->t_nominal?>">
					              <span class="info"></span>
					            </div>
				          	</div>



				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">Keterangan *</label>
					            <div class="col-sm-5">
					              <textarea class="form-control" name="t_note" style="height: 100px"><?=$data->t_note?></textarea>
					              <span class="info"></span>
					            </div>
				          	</div>
				          

				        </div>
				        <div class="box-footer">
				        	<div class="col-md-2 col-sm-offset-2">
					          <button id = "enter" class="btn btn-primary pull-right" type="submit">Simpan</button>
					          <a href="<?php echo base_url('panel/input_transaksi'); ?>" class="btn btn-default">Kembali</a>
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
          url : '<?php echo base_url("panel/input_transaksi/edit/".$data->t_id); ?>',
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
				    	window.location = "<?=base_url('panel/input_transaksi');?>";
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