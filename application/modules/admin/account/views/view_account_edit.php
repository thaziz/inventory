<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
	<section class="content-header">
	    <h1>
	       Kode Anggaran
	      <small> Edit</small>
	    </h1>
	    <ol class="breadcrumb">
	      <li><a href="<?=base_url('panel');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	      <li><a href="<?=base_url('panel/admin');?>"> Kode Anggaran</a></li>
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
					        <input type="hidden" name="a_id"  value="<?=$data->a_id?>">

				         

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">Kode Purchase *</label>
					            <div class="col-sm-4">
					              <input type="hidden" name = "a_code_old" value="<?=$data->a_code?>">
					              <input type="text" placeholder="Name" name = "a_code" value="<?=$data->a_code?>" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>


				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">Name *</label>
					            <div class="col-sm-4">
					              <input type="hidden" name = "a_name_old" value="<?=$data->a_name?>">
					              <input type="text" placeholder="Name" name = "a_name" value="<?=$data->a_name?>" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>

				          <!-- 	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">Saldo *</label>
					            <div class="col-sm-4">
					              <input type="text" placeholder="Saldo" name = "a_saldo" value="<?=$data->a_saldo?>" class="form-control" disabled>
					              <span class="info"></span>
					            </div>
				          	</div> -->

				        </div>
				        <div class="box-footer">
				        	<div class="col-md-2 col-sm-offset-2">
					          <button id = "enter" class="btn btn-primary pull-right" type="submit">Enter</button>
					          <a href="<?php echo base_url('panel/account'); ?>" class="btn btn-default">Back</a>
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
          url : '<?php echo base_url("panel/account/edit").'/'.$data->a_id; ?>',
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
				    	window.location = "<?=base_url('panel/account');?>";
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
