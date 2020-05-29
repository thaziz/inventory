<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
	<section class="content-header">
	    <h1>
	      Tanda Tangan
	      <small> Insert</small>
	    </h1>
	    <ol class="breadcrumb">
	      <li><a href="<?=base_url('panel');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	      <li><a href="<?=base_url('panel/ttd');?>">User</a></li>
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
					            <label class="col-sm-2 control-label" for="adm_name">telaahan 1 *</label>
					            <div class="col-sm-4">					          
					              <input type="text"  name = "telaahan1" value="" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">NIK 1 *</label>
					            <div class="col-sm-4">					          
					              <input type="text"  name = "nik1" value=""  class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>


				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">telaahan 2 *</label>
					            <div class="col-sm-4">					          
					              <input type="text"  name = "telaahan2" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>

				          		<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">NIK 2 *</label>
					            <div class="col-sm-4">					          
					              <input type="text"  name = "nik2"  class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>


				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">telaahan 3 *</label>
					            <div class="col-sm-4">					          
					              <input type="text"  name = "telaahan3" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">NIK 3 *</label>
					            <div class="col-sm-4">					          
					              <input type="text"  name = "nik3"  class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>


				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">telaahan 4 *</label>
					            <div class="col-sm-4">					          
					              <input type="text"  name = "telaahan4" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">NIK 4 *</label>
					            <div class="col-sm-4">					          
					              <input type="text"  name = "nik4" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">Peminjaman 1 *</label>
					            <div class="col-sm-4">					          
					              <input type="text"  name = "peminjaman1" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">NIK 1 *</label>
					            <div class="col-sm-4">					          
					              <input type="text"  name = "nikp1" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>


						
				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">Peminjaman 2 *</label>
					            <div class="col-sm-4">					          
					              <input type="text"  name = "peminjaman2"  class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">NIK 2 *</label>
					            <div class="col-sm-4">					          
					              <input type="text"  name = "nikp2" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>


				          	<div class="form-group">
				          		<label class="col-sm-2 control-label" for="adm_active">Enabled</label>
				          		<div class = "col-sm-10">
						            	<label class="switch">
						            		<input type="checkbox" name="status" value="1">
						            		<div class="slider round"></div>
						            	</label>
				          		</div>
				          	</div>

				          
				        </div>
				        <div class="box-footer">
				        	<div class="col-md-2 col-sm-offset-2">
					          <button id = "enter" class="btn btn-primary pull-right" type="submit">Enter</button>
					          <a href="<?php echo base_url('panel/ttd'); ?>" class="btn btn-default">Back</a>
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
          url : '<?php echo base_url("panel/ttd/insert"); ?>',
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
				    text     : 'Insert data success',
				    position : 'top-center',
				    type     : 'success',
				    close    : function () {
				    	window.location = "<?=base_url('panel/ttd');?>";
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