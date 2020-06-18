<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
	<section class="content-header">
	    <h1>
	      Kategori
	      <small> Edit</small>
	    </h1>
	    <ol class="breadcrumb">
	      <li><a href="<?=base_url('panel');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	      <li><a href="<?=base_url('panel/admin');?>">Kategori</a></li>
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
					        <input type="hidden" name="k_id"  value="<?=$data->k_id?>">

				         


				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">Nama *</label>
					            <div class="col-sm-4">
					              
					              <input type="text" placeholder="Nama" name = "k_name" value="<?=$data->k_name?>" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>


							<input type="hidden" name = "k_sk_old" value="<?=$data->k_sk?>">
				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">Keterangan *</label>
					            <div class="col-sm-4">
					             <input type="text" placeholder="Keterangan" name = "k_note" value="<?=$data->k_note?>" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>


				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">SK Bupati *</label>
					            <div class="col-sm-4">
					              <input type="text" placeholder="No. Sk Bupati" name = "k_sk_bupati" id="k_sk_bupati" class="form-control" value="<?=$data->k_sk_bupati?>">
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">SK Direktur</label>
					            <div class="col-sm-4">
					              <input type="text" placeholder="Saldo" name = "k_sk" value="<?=$data->k_sk?>" class="form-control" >
					              <span class="info"></span>
					            </div>
				          	</div>





				          	<div class="form-group">
				          		<label class="col-sm-2 control-label" for="adm_active">Status</label>
				          		<div class = "col-sm-10">
						            	<label class="switch">
						            		<input type="checkbox" name="k_status" value="1" <?=($data->k_status==1?'checked':'')?>>
						            		<div class="slider round"></div>
						            	</label>
				          		</div>
				          	</div>

				        </div>
				        <div class="box-footer">
				        	<div class="col-md-2 col-sm-offset-2">
					          <button id = "enter" class="btn btn-primary pull-right" type="submit">Simpan</button>
					          <a href="<?php echo base_url('panel/kategori'); ?>" class="btn btn-default">Kembali</a>
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
          url : '<?php echo base_url("panel/kategori/edit").'/'.$data->k_id; ?>',
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
				    	window.location = "<?=base_url('panel/kategori');?>";
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
