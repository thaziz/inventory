<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
	<section class="content-header">
	    <h1>
	      Customer
	      <small> Insert</small>
	    </h1>
	    <ol class="breadcrumb">
	      <li><a href="<?=base_url('panel');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	      <li><a href="<?=base_url('panel/customer');?>">Customer</a></li>
	      <li class="active">Insert</li>
	    </ol>
  	</section>

  	<section class="content">
	  	<div class="row">
	  		<div class="col-xs-12">
	  			<div class="box">
		            <!--<div class="box-body">
		            	
		            </div>!-->
					<form class="form-horizontal" method="post" id="customer_form">
				        <div class="box-body">
				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="cus_company">Company</label>
					            <div class="col-sm-4">
					              <input type="text" placeholder="Company" name = "cus_company" id="cus_company" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="cus_name">Name *</label>
					            <div class="col-sm-4">
					              <input type="text" placeholder="Name" name = "cus_name" id="name" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="cus_firstname">First Name</span></label>
					            <div class="col-sm-4">
					              <input type="text" placeholder="First Name" name = "cus_firstname" id="firstname" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="cus_address">Address</span></label>
					            <div class="col-sm-8">
					              <input type="text" placeholder="Address" name = "cus_address" id="address" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="cus_city">City</span></label>
					            <div class="col-sm-4">
					              <input type="text" placeholder="City" name = "cus_city" id="city" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="cus_zipcode">Zip Code</span></label>
					            <div class="col-sm-3">
					              <input type="text" placeholder="Zip Code" name = "cus_zipcode" id="zipcode" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="cus_state">State</span></label>
					            <div class="col-sm-4">
					              <input type="text" placeholder="State" name = "cus_state" id="state" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="cus_country">Country</span></label>
					            <div class="col-sm-4">
					              <select name = "cus_country" id="country" data-placeholder="Select a Country" class="form-control select2">
					              	<option value="">-- Select Country --</option>
					              	<?php
					              		$countries = get_countries();
						              	foreach ($countries as $value) {
						              		$value = strtoupper($value);
						              		echo '<option value="'.$value.'">'.$value.'</option>';
						              	}
					              	?>
					              </select>
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="cus_phone">Phone</span></label>
					            <div class="col-sm-4">
					              <input type="text" placeholder="Phone" name = "cus_phone" id="phone" class="form-control number-only">
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="cus_fax">Fax</span></label>
					            <div class="col-sm-4">
					              <input type="text" placeholder="Fax" name = "cus_fax" id="cus_fax" class="form-control number-only">
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="cus_website">Website</span></label>
					            <div class="col-sm-6">
					              <input type="text" placeholder="website" name = "cus_website" id="cus_website" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="cus_email">Email *</span></label>
					            <div class="col-sm-5">
					              <input type="text" placeholder="Email" name = "cus_email" id="email" class="form-control">
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="cus_webpassword">Password *</span></label>
					            <div class="col-sm-5">
					              <input type="text" placeholder="Password" name = "cus_webpassword" id="password" class="form-control" value="<?=random_string('alnum', 10);?>">
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
				          		<label class="col-sm-2 control-label" for="cus_enabled">Enabled</label>
				          		<div class = "col-sm-10">
						            	<label class="switch">
						            		<input type="checkbox" name="cus_enabled" value="1">
						            		<div class="slider round"></div>
						            	</label>
				          		</div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="cus_currency">Currency</span></label>
					            <div class="col-sm-4">
					              <select name = "cus_currency" id="cus_currency" class="form-control" readonly>
					              	<option value="">-- Select Currencies --</option>
					              	<?php
						              	foreach ($currencies as $value) {
						              		echo '<option value="'.$value->cur_id.'">'.$value->cur_name.'</option>';
						              	}
					              	?>
					              </select>
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="tim_id">Time zone</span></label>
					            <div class="col-sm-4">
					              <select name = "tim_id" id="tim_id" class="form-control" readonly>
					              	<option value="">-- Select Timezone --</option>
					              	<?php
						              	foreach ($timezone as $value) {
						              		echo '<option value="'.$value->tim_id.'">'.$value->tim_zone.'</option>';
						              	}
					              	?>
					              </select>
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="cus_accounttype">Type</span></label>
					            <div class="col-sm-3">
					              <select name = "cus_accounttype" id="cus_accounttype" class="form-control" readonly>
					              	<?php
					              		$type = array(0=>'Prepaid', 1=>'Postpaid');
						              	foreach ($type as $key=>$value) {
						              		echo '<option value="'.$key.'">'.$value.'</option>';
						              	}
					              	?>
					              </select>
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group" id="generateinv" style="display: none">
					            <label class="col-sm-2 control-label" for="cus_generateinvoice">Generate Invoice</span></label>
					            <div class="col-sm-2">
					              <select name = "cus_generateinvoice" id="cus_generateinvoice" class="form-control" readonly>
					              	<?php
					              		$type = array(0=>'No', 1=>'Yes');
						              	foreach ($type as $key=>$value) {
						              		echo '<option value="'.$key.'">'.$value.'</option>';
						              	}
					              	?>
					              </select>
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="cal_id">Call Plan</span></label>
					            <div class="col-sm-4">
					              <select name = "cal_id" id="cal_id" class="form-control" readonly>
					              	<option value="">-- Select Call Plan --</option>
					              	<?php
						              	foreach ($callplan as $value) {
						              		echo '<option value="'.$value->cal_id.'">'.$value->cal_name.'</option>';
						              	}
					              	?>
					              </select>
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
				          		<label class="col-sm-2 control-label" for="cus_sendinvoice">Send Invoice</label>
				          		<div class = "col-sm-10">
						            	<label class="switch">
						            		<input type="checkbox" name="cus_sendinvoice" value="1">
						            		<div class="slider round"></div>
						            	</label>
				          		</div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="cus_creditlimitnotify">Credit Limit Notify</span></label>
					            <div class="col-sm-2">
					              <select name = "cus_creditlimitnotify" id="cus_creditlimitnotify" class="form-control" readonly>
					              	<?php
					              		$type = array(0=>'No', 1=>'Yes');
						              	foreach ($type as $key=>$value) {
						              		echo '<option value="'.$key.'">'.$value.'</option>';
						              	}
					              	?>
					              </select>
					              <span class="info"></span>
					            </div>
				          	</div>

				          	<div class="form-group">
					            <label class="col-sm-2 control-label" for="cus_discount">Discount</span></label>
					            <div class="col-sm-3">
					              <input type="text" name="cus_discount" id="cus_discount" class="form-control allow-decimal">
					              <span class="info"></span>
					            </div>
				          	</div>


				        </div>
				        <div class="box-footer">
				        	<div class="col-md-2 col-sm-offset-2">
					          <button id = "enter" class="btn btn-primary pull-right" type="submit">Enter</button>
					          <a href="<?php echo base_url('panel/customer'); ?>" class="btn btn-default">Back</a>
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
  	$('#tim_id').val(55);
  	$('#cus_currency').val(63);
  	$('#cus_accounttype').on('change',function(){
  		var val = $(this).val();
  		//alert(val);
  		$('#generateinv').css('display', (val==0?'none':'block'));
  	});
    $('form#customer_form').on('submit', function(e) {
      e.preventDefault();
      $.ajax({
          url : '<?php echo base_url("panel/customer/insert"); ?>',
          type: "POST",
          data : $('#customer_form').serialize(),
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
				    	window.location = "<?=base_url('panel/customer');?>";
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