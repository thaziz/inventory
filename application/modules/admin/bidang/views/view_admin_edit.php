<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
	<section class="content-header">
	    <h1>
	      Administrator
	      <small> Edit</small>
	    </h1>
	    <ol class="breadcrumb">
	      <li><a href="<?=base_url('panel');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	      <li><a href="<?=base_url('panel/admin');?>">Administrator</a></li>
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
					        <input type="hidden" name="d_id"  value="<?=$data->d_id?>">

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">Name *</label>
					            <div class="col-sm-4">
					              <input type="hidden" name = "d_name_old" value="<?=$data->d_name?>">
					              <input type="text" placeholder="Name" name = "d_name" value="<?=$data->d_name?>" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>

				          	 	<div class="form-group">
					            <label class="col-sm-2 control-label" for="adm_name">Kode Purchase *</label>
					            <div class="col-sm-4">
					              <input type="hidden" name = "d_code_old" value="<?=$data->d_code?>">
					              <input type="text" placeholder="Name" name = "d_code" value="<?=$data->d_code?>" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>

				        </div>
				        <div class="box-footer">
				        	<div class="col-md-2 col-sm-offset-2">
					          <button id = "enter" class="btn btn-primary pull-right" type="submit">Enter</button>
					          <a href="<?php echo base_url('panel/bidang'); ?>" class="btn btn-default">Back</a>
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
          url : '<?php echo base_url("panel/bidang/edit").'/'.$data->d_id; ?>',
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
				    	window.location = "<?=base_url('panel/bidang');?>";
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
