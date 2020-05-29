<!DOCTYPE html>
<html>
<head>
	<title>Form Ticketing</title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
	<!-- iCheck for checkboxes and radio inputs -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/iCheck/all.css">
	<!-- Select2 -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/toastMessage/css/jquery.toastmessage.css">

	<script
  src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<!--script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script-->
	<script src="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/moment.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
	<style type="text/css">
		.wrapper *{
			font-size: .98em;
		}
		span.required, span.info{
			color: red;
		}
		.cus-field-info{
			margin-bottom: -2px;
			font-size: 1em;
			display: flex;
		}
		.flex{
			display: flex;
			flex-direction: row;
    		align-items: stretch;
		}
		.flex-column{
			flex-direction: column;
		}
		.flex>div{
			flex-shrink: 1;
			padding: 15px; 
		}
		.info-value>span{
			font-weight: normal;
		}
		.p-0{
			padding: 0 !important;
		}
		.mt-5{
			margin-top: 5px !important;
		}
		td.align-right{
			text-align: right;
		}
		div#new-customer.modal div.modal-backdrop {
		    z-index: 0 !important;
		}
		.select2-container--default .select2-selection--single{
			height: 34px !important;
		}
		.select2-container--default .select2-selection--single .select2-selection__rendered{
			line-height: 32px !important
		}
	</style>
</head>
<body>
		<div class="wrapper" style="overflow-x: hidden">
			<div class="row">
				<div class="col-md-12" id="content">
					<form id="form_ticketing" role="form" class="form-horizontal">
						<?php if(isset($data)):?>
							<input type="hidden" name="cus_id" value="<?=$data?>">
							<div id="alert" class="alert alert-warning text-center" style="display: none;"></div>
						<?php else:?>
							<input type="hidden" name="cus_id" value="0">
							<div id="alert" class="alert alert-warning text-center" style="display: <?=!empty($phone)?'block':'none'?>;"><i>Number is not registered</i></div>
						<?php endif;?>
						<input type="hidden" name="wa" value="<?=$wa?>">
						<input type="hidden" name="call_id" value="<?=$call_id?>">
						<input type="hidden" name="agent" value="<?=$agent?>">
						<div class="flex">
							<div class="col-md-7 col-sm-7" style="border-radius: 5px;border: 1px solid #ccc;">
								<div class="form-group" style="margin-bottom: 5px;">
									<label class="col-md-12" style="font-size: 1.2em">Ticket Form</label>

								</div>
								<div class="form-group field-flex">
									<label class="col-md-3 col-sm-3 mt-5" for="name">Name <span class="required">*</span></label>
									<div class="col-md-4 col-sm-4">
										<input type="text" name="cus_fname" class="form-control" placeholder="First Name" id="fname" value="<?=isset($fname)?$fname:''?>" <?=!isset($data)?'':'readonly'?>>
										<span class="info"></span>
									</div>
									<div class="col-md-4 col-sm-4">
										<input type="text" name="cus_lname" class="form-control" placeholder="Last Name" id="lname" value="<?=isset($lname)?$lname:''?>" <?=!isset($data)?'':'readonly'?>>
										<span class="info"></span>
									</div>
								</div>
								<div class="form-group field-flex">
									<label class="col-md-3 col-sm-3 mt-5" for="phone">Phone Number & Email</label>
									<div class="col-md-4 col-sm-4">
										<input type="hidden" name="cphone" id="cphone" value="<?=isset($phone)?$phone:''?>">
										<?php if(isset($phone) && ($call_id!=0 || $wa==1)):?>
										<input type="text" name="cus_phone" class="form-control" id="phone" value="<?=isset($phone)?$phone:''?>" <?=!isset($data)?'':'readonly'?>>
										<?php elseif($call_id==0):?>
											<input type="hidden" name="outgoing_id" id="outgoing_id">
											<div class="input-group">
												<input type="text" name="cus_phone" class="form-control" id="phone">
												<div class="input-group-btn">
													<button type="button" class="btn btn-success" id="btn-call" style="padding:8px 12px;"><i class="fa fa-phone"></i> Call</button>
												</div>
											</div>
										<?php endif;?>
										<span class="info"></span>
									</div>
									<div class="col-md-5 col-sm-5 col-sm-5">
										<input type="text" name="email" class="form-control" placeholder="Email" id="email" value="<?=isset($email)?$email:''?>" <?=!isset($data)?'':'readonly'?>>
										<span class="info"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 col-sm-3 mt-5" for="ticket_id">Ticket ID</label>
									<div class="col-md-9 col-sm-9">
										<div class="col-md-5 col-sm-5 p-0" style="margin-right: 15px;">
										<input type="text" name="ticket_id" class="form-control" id="ticket" value="<?=isset($ticket_id)?$ticket_id:''?>" readonly>
										<span class="info"></span>
									</div>

									<label class="col-md-2 col-sm-2 mt-5" for="ticket_id">Source <span class="required">*</span></label>
										<div class="col-md-4 col-sm-4 p-0">
											<select name="source" class="form-control">
												<option value=""> --Ticket Source-- </option>
												<option value="Email">Email</option>
												<option value="Phone">Inbound Call</option>
												<option value="Social Media">Social Media</option>
												<option value="E-Survey">E-Survey Outbound</option>
												<option value="Abandon calls">Abandon Call Back</option>
												<!--option value="Allocation calls">Allocation Failure Call Back</option-->
												<!--option value="Early Abandon Call Back">Early Abandon Call Back</option-->
												<option value="Servicing Outbound">Servicing Outbound</option>
												<option value="Nursery calls">Nursery calls</option>
												<option value="Outgoing calls">Outgoing calls</option>
												<option value="Home Delivery Nursery Call">Home Delivery Nursery Call</option>
												<option value="Home Delivery Confirmation Call">Home Delivery Confirmation Call</option>
												<option value="Store">Store</option>
												<option value="Chat" <?=$wa==1?'selected':''?>>WA Chat</option>
												<option value="Web Chat">Web Chat</option>
											</select>
											<span class="info"></span>
										</div>
									</div>



								</div>
								<div class="form-group field-flex">
									<label class="col-md-3 col-sm-3 mt-5" for="ticket_id">Call Type <span class="required">*</span></label>
									<div class="col-md-5 col-sm-5">
										<select name="main_category" class="form-control">
											<option value=""> --Main Category-- </option>
											<?php foreach ($main_category as $key => $value) {
												echo '<option value="'.$value['id'].'">'.$value['text'].'</option>';
											}?>
											<!--option value="Accessories">Accessories</option>
											<option value="Coffee">Coffee</option>
											<option value="Machine">Machine</option>
											<option value="Service">Service</option>
											<option value="Others">Others</option-->
										</select>
										<span class="info"></span>
									</div>
								</div>




								<div class="form-group">
									<label class="col-md-3 col-sm-3 mt-5" for="ticket_id">Meta Category <span class="required">*</span></label>
									<div class="col-md-9 col-sm-9">
										<div class="col-md-5 col-sm-5 p-0">
											<select name="meta_category" class="form-control">
												<option value=""> --Meta Category-- </option>
											</select>
											<span class="info"></span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 col-sm-3 mt-5" for="ticket_id">Category <span class="required">*</span></label>
									<div class="col-md-9 col-sm-9 p-0">
										<div class="col-md-5 col-sm-5">
											<select name="category" class="form-control select2">
												<option value=""> --Category-- </option>
											</select>
											<span class="info"></span>
										</div>
										<div class="col-md-7 col-sm-7">
											<div class="input-group">
												<select name="sub_category" class="form-control select2">
													<option value=""> --Sub Category-- </option>
												</select>
												<div class="input-group-btn">
													<button class="btn btn-info" id="show-category-info-modal" type="button"><i class="fa fa-info-circle"></i></button>
												</div>
											</div>
											<span class="info"></span>
										</div>
									</div>
								</div>


								<div class="form-group field-flex">
									<label class="col-md-3 col-sm-3 mt-5" for="subject">Subject <span class="required">*</span></label>
									<div class="col-md-9 col-sm-9">
										<input type="text" name="subject" class="form-control" id="subject">
										<span class="info"></span>
									</div>
								</div>
								<div class="form-group field-flex">
									<label class="col-md-3 col-sm-3 mt-5" for="content">Ticket Content <span class="required">*</span></label>
									<div class="col-md-9 col-sm-9">
										<textarea name="content" class="form-control" rows="7" id="content"></textarea>
										<span class="info"></span>
									</div>
								</div>
								<div class="form-group field-flex">
									<label class="col-md-3 col-sm-3 mt-5" for="status">Status <span class="required">*</span></label>
									<div class="col-md-9 col-sm-9">
										<div class="col-md-3 col-sm-3 p-0">
											<select name="status" class="form-control" id="status">
												<option value=""> --Status-- </option>
												<option value="OPEN" selected>OPEN</option>
												<option value="CLOSED">CLOSED</option>
											</select>
											<span class="info"></span>
										</div>
										<div id="assign">
											<label class="col-md-3 col-sm-3 mt-5" for="assign_to" style="text-align: right;">Assign to</label>
											<div class="col-md-6 col-sm-6 p-0">
												<select name="assign_to" class="form-control" id="assign_to">
													<option value="" data-email=""> --Assign to-- </option>
													<?php
													foreach($assign_list as $assign){
														echo '<option value="'.$assign['id'].'" data-email="'.$assign['email'].'">'.$assign['text'].'</option>';
													}
													?>
												</select>
												<span class="info"></span>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group field-flex" id="panel-closed" style="display: none">
									<label class="col-md-3 col-sm-3 mt-5" for="callback">Closed Note <span class="required">*</span></label>
									<div class="col-md-9 col-sm-9">
										<textarea class="form-control" name="closed_note"></textarea>
										<span class="info"></span>
									</div>
								</div>
								<div class="form-group field-flex" id="panel-callback">
									<label class="col-md-3 col-sm-3 mt-5" for="callback">Need Callback</label>
									<div class="col-md-9 col-sm-9">
										<div class="col-md-3 col-sm-3 p-0">
											<select name="callback" class="form-control" id="callback">
												<option value="0">No</option>
												<option value="1">Yes</option>
											</select>
											<span class="info"></span>
										</div>
										<label class="col-md-3 col-sm-3 mt-5" for="assign_to" style="text-align: right;">Email <span class="required">*</span></label>
										<div class="col-md-6 col-sm-6 p-0">
											<input type="text" name="email_assign" class="form-control">
											<span class="info"></span>
										</div>
									</div>
								</div>
								<div class="form-group field-flex" id="panel-cc">
									<label class="col-md-3 col-sm-3 mt-5" for="callback">CC</label>
									<div class="col-md-9 col-sm-9">
										<div class="col-md-3 col-sm-3 p-0">
											<input type="text" name="cc" class="form-control">
											<span class="info"></span>
										</div>
										<label class="col-md-3 col-sm-3 mt-5" for="assign_to" style="text-align: right;">BCC</label>
										<div class="col-md-6 col-sm-6 p-0">
											<input type="text" name="bcc" class="form-control">
											<span class="info"></span>
										</div>
									</div>
								</div>

								<div class="form-group field-flex" style="padding-top: 15px;margin-bottom: 0;">
									<div class="col-md-5 col-sm-5 col-md-offset-3 col-sm-offset-3">
										<button type="reset" class="btn btn-default" style="margin-right: 15px">Reset</button>
										<button type="submit" class="btn btn-primary" id="btn-save">Save</button>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 flex flex-column p-0" style="width:40%;max-height:700px;margin-left:10px;overflow-y:auto;">
								<div style="border-radius: 5px;border: 1px solid #ccc; margin-bottom: 10px; padding: 0 15px;">
									<div class="form-group" style="margin-bottom: 0px;">
										<div class="input-group" style="margin-right:-1px">
											<input type="text" id="seach_cus" class="form-control" placeholder="Search Customer Phone">
											<div class="input-group-btn">
												<button type="button" class="btn btn-primary" id="btn-search" style="padding:8px 12px;"><i class="fa fa-search"></i></button>
											</div>
										</div>
									</div>
								</div>
								<div style="border-radius: 5px;border: 1px solid #ccc; margin-bottom: 10px">
									<div class="form-group" style="margin-bottom: 5px;">
										<label class="col-md-12" style="font-size: 1.2em">Customer's Information</label>
									</div>
									<div class="form-group cus-field-info">
										<label class="col-md-5 col-sm-5" for="callback">Registered on</label>
										<label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tregistered_on"><?=!empty($registered_on)?date('d F Y', strtotime($registered_on)):''?></span></label>
										<input type="hidden" name="registered_on" value="<?=$registered_on?>">
									</div>
									<div class="form-group cus-field-info">
										<label class="col-md-5 col-sm-5" for="callback">Registered Store</label>
										<label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="registered_store"><?=$registered_store?></span></label>
										<input type="hidden" name="registered_store" value="<?=$registered_store?>">
									</div>
									<div class="form-group cus-field-info">
										<label class="col-md-5 col-sm-5" for="callback">Subsidiary</label>
										<label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="subsidiary"><?=$fields['subsidiary']?></span></label>
										<input type="hidden" name="subsidiary" value="<?=$fields['subsidiary']?>">
									</div>
									<div class="form-group cus-field-info">
										<label class="col-md-5 col-sm-5" for="callback">Birthdate</label>
										<label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tdob_mom"><?=!empty($fields['dob_mom'])?date('d F Y', strtotime($fields['dob_mom'])):''?></span></label>
										<input type="hidden" name="dob_mom" value="<?=$fields['dob_mom']?>">
									</div>
									<div class="form-group cus-field-info">
										<label class="col-md-5 col-sm-5" for="callback">Anniversary Date</label>
										<label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tanniversary_date"><?=!empty($fields['anniversary_date'])?date('d F Y', strtotime($fields['anniversary_date'])):''?></span></label>
										<input type="hidden" name="anniversary_date" value="<?=$fields['anniversary_date']?>">
									</div>
									<div class="form-group cus-field-info">
										<label class="col-md-5 col-sm-5" for="callback">Gender</label>
										<label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="gender"><?=!empty($fields['gender'])?$fields['gender']:$extend['gender']?></span></label>
										<input type="hidden" name="gender" value="<?=$fields['gender']?>">
									</div>
								</div>

								<div style="border-radius: 5px;border: 1px solid #ccc; margin-bottom: 10px">
									<div class="form-group" style="margin-bottom: 5px;">
										<label class="col-md-12" style="font-size: 1.2em">Transaction Summary</label>
									</div>
									<div class="form-group cus-field-info">
										<label class="col-md-5 col-sm-5" for="callback">First Sale Date</label>
										<label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tfirst_sale_date"><?=!empty($fields['first_sale_date'])?date('d F Y', strtotime($fields['first_sale_date'])):''?></span></label>
										<input type="hidden" name="first_sale_date" value="<?=$fields['first_sale_date']?>">
									</div>
									<div class="form-group cus-field-info">
										<label class="col-md-5 col-sm-5" for="callback">Last Modified Date</label>
										<label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tlast_modified_date"><?=!empty($fields['last_modified_date'])?date('d F Y', strtotime($fields['last_modified_date'])):''?></span></label>
									</div>
									<div class="form-group cus-field-info">
										<label class="col-md-5 col-sm-5" for="callback">Last Sale Amount</label>
										<label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="last_sale_amount"><?=$fields['last_sale_amount']?></span></label>
										<input type="hidden" name="last_sale_amount" value="<?=$fields['last_sale_amount']?>">
									</div>
									<div class="form-group cus-field-info">
										<label class="col-md-5 col-sm-5" for="callback">Last Sale Date</label>
										<label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tlast_sale_date"><?=!empty($fields['last_sale_date'])?date('d F Y', strtotime($fields['last_sale_date'])):''?></span></label>
										<input type="hidden" name="last_sale_date" value="<?=$fields['last_sale_date']?>">
									</div>
									<div class="form-group cus-field-info">
										<label class="col-md-5 col-sm-5" for="callback">Last 12 Month Sale Amount</label>
										<label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="last_twelve_mon_sale"><?=$fields['last_twelve_mon_sale']?></span></label>
										<input type="hidden" name="last_twelve_mon_sale" value="<?=$fields['last_twelve_mon_sale']?>">
									</div>
								</div>

								<div style="border-radius: 5px;border: 1px solid #ccc; height: 223px;">
									<div class="form-group" style="margin-bottom: 5px;">
										<label class="col-md-12" style="font-size: 1.2em">Customer's Address</label>
									</div>
									<div class="form-group cus-field-info">
										<label class="col-md-5 col-sm-5" for="callback">Home Address</label>
										<label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="address_one_home_one"><?=$fields['address_one_home_one']?></span></label>
										<input type="hidden" name="address_one_home_one" value="<?=$fields['address_one_home_one']?>">
									</div>
									<div class="form-group cus-field-info">
										<label class="col-md-5 col-sm-5" for="callback">Zip/Postal Code</label>
										<label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="zip_code"><?=$fields['zip_code']?></span></label>
										<input type="hidden" name="zip_code" value="<?=$fields['zip_code']?>">
									</div>
									<div class="form-group cus-field-info">
										<label class="col-md-5 col-sm-5" for="callback">City</label>
										<label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="city_one"><?=$fields['city_one']?></span></label>
										<input type="hidden" name="city_one" value="<?=$fields['city_one']?>">
									</div>
									<div class="form-group cus-field-info">
										<label class="col-md-5 col-sm-5" for="callback">Province</label>
										<label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="province_one"><?=$fields['province_one']?></span></label>
										<input type="hidden" name="province_one" value="<?=$fields['province_one']?>">
									</div>
									<div class="form-group cus-field-info">
										<label class="col-md-5 col-sm-5" for="callback">Country of Origin</label>
										<label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="country_origin"><?=$fields['country_origin']?></span></label>
										<input type="hidden" name="country_origin" value="<?=$fields['country_origin']?>">
									</div>
								</div>

								<div style="border-radius: 5px;border: 1px solid #ccc; margin-top: 10px; padding: 0 15px;display:<?=(isset($data)?'block':'none')?>;" id="btn-update-panel">
									<div class="form-group" style="margin-bottom: 0px;">
										<div class="col-md-12" style="margin-right:-1px;padding:0;">
											<button type="button" class="btn btn-primary" id="btn-update" style="padding:8px 12px;width:100%;">Edit Profile</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="flex">
							<div class="col-md-12 col-sm-12" style="border-radius: 5px;border: 1px solid #ccc; margin-top: 15px;padding-top: 5px;">
								<ul class="nav nav-pills spc">
								  <li class="active"><a data-toggle="tab" href="#transaction">Customer Transaction</a></li>
								  <li><a data-toggle="tab" href="#ticket_history">Customer Ticket History</a></li>
								</ul>
								<div class="tab-content">
  									<div id="transaction" class="tab-pane fade in active">
										<div class="form-group" style="margin-top: 15px;margin-bottom: 5px;">
											<label class="col-md-5 col-sm-4 pull-left" style="font-size: 1.2em">Customer Transaction</label>
											<div class="col-md-7 col-sm-8" scol-sm-7 tyle="padding-left:0;">
												<div class="col-md-6 col-sm-6 p-0">
													<label class="col-md-3 col-sm-3" style="margin-top:5px;">Periode</label>
													<div class="col-md-9 col-sm-9" style="padding-right:0;">
														<input type="text" class="form-control input-sm fperiode" id="fperiode" placeholder="Periode" value="<?=!empty($fields['last_sale_date'])?date('F d, Y', strtotime($fields['last_sale_date'].' -3 months')).' - '.date('F d, Y', strtotime($fields['last_sale_date'].' +1 day')):''?>">
													</div>
												</div>
												<div class="col-md-5 col-sm-5">
													<label class="col-md-2 col-sm-2" style="margin-top:5px;">Store</label>
													<div class="col-md-10 col-sm-10" style="padding-right: 0">
														<input type="text" class="form-control input-sm fstore" placeholder="Store Name">
													</div>
												</div>
												<div class="col-md-1 col-sm-1 p-0">
													<button type="button" class="btn btn-sm btn-primary pull-right btn-filter" onclick="reload_table()">Filter <i class="fa fa-circle-o-notch fa-spin fa-fw" style="display: none;"></i></button>
												</div>
											</div>
										</div>
										<div class="table-responsive">
											<table class="table table-striped table-bordered" id="table-trans" style="width: 100%">
												<thead>
													<tr>
														<th width="25">No</th>
														<th>Transaction ID</th>
														<th>Type</th>
														<th>Amount</th>
														<th>Delivery Status</th>
														<th>Billing Time</th>
														<th>Store</th>
														<th width="25"></th>
													</tr>
												</thead>
											</table>
										</div>
									</div>

									<div id="ticket_history" class="tab-pane fade in">
										<div class="form-group" style="margin-top: 15px;margin-bottom: 5px;">
											<label class="col-md-5 col-sm-5 pull-left" style="font-size: 1.2em">Customer Ticket History</label>
											<div class="col-md-4 col-sm-7" style="padding-left:0;">
												<div class="col-md-10 col-sm-10 p-0">
													<label class="col-md-3 col-sm-3" style="margin-top:5px;">Periode</label>
													<div class="col-md-9 col-sm-9" style="/*padding-right:0;*/">
														<input type="text" class="form-control input-sm tperiode" placeholder="Periode" value="">
													</div>
												</div>
												<!--div class="col-md-5 col-sm-5">
													<label class="col-mdcol-sm-7 -2" style="margin-top:5px;">Store</label>
													<div class="col-md-10" style="padding-right: 0">
														<input type="text" class="form-control input-sm tstore" placeholder="Store Name">
													</div>
												</div-->
												<div class="col-md-2 col-sm-2 p-0">
													<button type="button" class="btn btn-sm btn-primary pull-right btn-tfilter" onclick="reload_table_ticket()">Filter <i class="fa fa-circle-o-notch fa-spin fa-fw" style="display: none;"></i></button>
												</div>
											</div>
										</div>
										<div class="table-responsive">
											<table class="table table-striped table-bordered" id="table-ticket" style="width: 100%">
												<thead>
													<tr>
														<th width="25">No</th>
														<th>Ticket ID</th>
														<th>Category</th>
														<th>Subject</th>
														<th>Created on</th>
														<!--th>Store</th-->
														<th>Status</th>
														<th width="25"></th>
													</tr>
												</thead>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

<!-- Modal -->
<div id="detail-modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Transaction Detail</h4>
      </div>
      <div class="modal-body">
        <p>Transaction List Items</p>
        <div class="table-responsive">
        	<table class="table table-striped table-bordered" id="table-items" style="width: 100%">
				<thead>
					<tr>
						<th width="25">No</th>
						<th>Item Code</th>
						<th>Type</th>
						<th>Description</th>
						<th>QTY</th>
						<th>Rate</th>
						<th>Discount</th>
						<th>Amount</th>
						<th>Value</th>
					</tr>
				</thead>
			</table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal Category -->
<div id="find-category" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Find Sub Category</h4>
      </div>
      <div class="modal-body">
      	<div class="wrap" style="display: block">
      		<div>
      			<input type="text" class="form-control" id="find-subcat" placeholder="Type Sub Category">
      		</div>
      		<div>
      			<table class="table" id="sub-category-table-info">
      				<thead>
      					<tr>
      						<th>Sub Category</th>
      						<th>Category</th>
      						<th>Meta Category</th>
      						<th>Call Type</th>
      					</tr>
      				</thead>
      				<tbody></tbody>
      			</table>
      		</div>
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Modal Ticket -->
<div class="modal-dialog modal-lg" id="detail-ticket" style="width: 100%;height: 100%; position: absolute; top:0; left: 0;z-index: 999;margin:0;display: none;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close dismis-detail-ticket">&times;</button>
        <h4 class="modal-title">Ticket Detail</h4>
      </div>
      <div class="modal-body">
      	<div class="flex" style="justify-content: center;align-content: middle;color:#ddd;"><i class="fa fa-circle-o-notch fa-spin fa-5x fa-fw"></i></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default dismis-detail-ticket">Close</button>
      </div>
    </div>

  </div>

<!-- Modal New -->
<div id="new-customer" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" style="width: 100%;height: 100%;margin-top:0;">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="title-form-new"><?=isset($data)?'Update Customer Data':'New Customer Registration'?></h4>
      </div>
      <div class="modal-body">
      	<form method="post" id="form-new">
      		<p id="warning" style="color:red;text-align:center;"></p>
      		<div class="alert" id="alert-update" style="display: none;text-align: center;"></div>
      	<div class="row">
	      	<div class="col-md-4 col-sm-4">
	      		<input type="hidden" name="action" id="action" value="<?=isset($data)?'update':'new'?>">
		      	<div class="form-group">
		      		<label class="form-label">First Name<span class="required">*</span></label>
		      		<input type="text" name="firstname" id="nfname" class="form-control" value="<?=isset($nfname)?$nfname:''?>">
		      		<span class="info"></span>
		      	</div>
		    </div>
	      	<div class="col-md-4 col-sm-4">
		      	<div class="form-group">
		      		<label class="form-label">Last Name<span class="required">*</span></label>
		      		<input type="text" name="lastname" id="nlname" class="form-control" value="<?=isset($nlname)?$nlname:''?>">
		      		<span class="info"></span>
		      	</div>
		    </div>
	      	<div class="col-md-4 col-sm-4">
		      	<div class="form-group">
		      		<label class="form-label">Email<span class="required">*</span></label>
		      		<input type="email" name="email" id="nemail" class="form-control" value="<?=isset($nemail)?$nemail:''?>">
		      		<span class="info"></span>
		      	</div>
		    </div>
		</div>
      	<div class="row">
	      	<div class="col-md-4 col-sm-4">
		      	<div class="form-group">
		      		<label class="form-label">Mobile Number<span class="required">*</span></label>
		      		<input type="text" name="mobile" id="nphone" class="form-control" value="<?=isset($nphone)?$nphone:''?>">
		      		<span class="info"></span>
		      	</div>
		    </div>
	      	<div class="col-md-4 col-sm-4">
		      	<div class="form-group">
		      		<label class="form-label">Bar Code<span class="required">*</span></label>
		      		<input type="text" name="external_id" id="nbarcode" class="form-control" value="<?=isset($nbarcode)?$nbarcode:''?>">
		      		<span class="info"></span>
		      	</div>
		    </div>
	      	<div class="col-md-4 col-sm-4">
		      	<div class="form-group">
		      		<label class="form-label">Gender<span class="required">*</span></label>
		      		<div class="col-md-12 col-sm-12 p-0">
		      			<label class="radio-inline" style="margin-right: 25px;">
		      				<input type="radio" name="field[gender]" value="MALE" id="ngender_MALE" <?=isset($ngender) && $ngender=='MALE'?'checked':''?>> Male
		      			</label>
		      			<label class="radio-inline">
		      				<input type="radio" name="field[gender]" value="FEMALE" id="ngender_FEMALE" <?=isset($ngender) && $ngender=='FEMALE'?'checked':''?>> Female
		      			</label>
		      			<span class="info"></span>
		      		</div>
		      	</div>
		    </div>
		</div>
      	<div class="row">
	      	<div class="col-md-4 col-sm-4">
		      	<div class="form-group">
		      		<label class="form-label">Birthday<span class="required">*</span></label>
		      		<input type="text" name="field[dob_mom]" id="ndob_mom" class="form-control datepicker" value="<?=isset($ndob_mom)?$ndob_mom:''?>">
		      		<span class="info"></span>
		      	</div>
		    </div>
	      	<div class="col-md-4 col-sm-4">
		      	<div class="form-group">
		      		<label class="form-label">Country of Origin<span class="required">*</span></label>
		      		<input type="text" name="field[country_origin]" id="ncountry_origin" class="form-control" value="<?=isset($ncountry_origin)?$ncountry_origin:''?>">
		      		<span class="info"></span>
		      	</div>
		    </div>
	      	<div class="col-md-4 col-sm-4">
		      	<div class="form-group">
		      		<label class="form-label">Company</label>
		      		<input type="text" name="field[company]" id="ncompany" class="form-control" value="<?=isset($ncompany)?$ncompany:''?>">
		      	</div>
		    </div>
		</div>
      	<div class="row">
	      	<div class="col-md-4 col-sm-4">
		      	<div class="form-group">
		      		<label class="form-label">Address 1<span class="required">*</span></label>
		      		<input type="text" name="field[address_one_home_one]" id="nadd1" class="form-control" value="<?=isset($nadd1)?$nadd1:''?>">
		      		<span class="info"></span>
		      	</div>
		    </div>
	      	<div class="col-md-4 col-sm-4">
		      	<div class="form-group">
		      		<label class="form-label">Address 2</label>
		      		<input type="text" name="field[address_one_home_two]" id="nadd2" class="form-control" value="<?=isset($nadd2)?$nadd2:''?>">
		      	</div>
		    </div>
	      	<div class="col-md-4 col-sm-4">
		      	<div class="form-group">
		      		<label class="form-label">Province<span class="required">*</span></label>
		      		<select class="form-control select2" name="field[province_one]" id="nprovince">
		      			<?php
		      				foreach ($province as $key => $v) {
		      					//$sel = $fields['province_one']==$v['text']?'selected':'';
		      					echo '<option value="'.$v['text'].'">'.$v['text'].'</option>';
		      				}
		      			?>
		      		</select>
		      		<span class="info"></span>
		      	</div>
		    </div>
		</div>
      	<div class="row">
	      	<div class="col-md-4 col-sm-4">
		      	<div class="form-group">
		      		<label class="form-label">City<span class="required">*</span></label>
		      		<select class="form-control select2" name="field[city_one]" id="ncity">
		      			<?php
		      				//foreach ($city as $key => $v) {
		      					//$sel = $fields['city_one']==$v['text']?'selected':'';
		      					//echo '<option value="'.$v['text'].'" '.$sel.'>'.$v['text'].'</option>';
		      				//}
		      			?>
		      		</select>
		      		<span class="info"></span>
		      	</div>
		    </div>
	      	<div class="col-md-4 col-sm-4">
		      	<div class="form-group">
		      		<label class="form-label">District<span class="required">*</span></label>
		      		<select class="form-control select2" name="field[district_one]" id="ndistrict">
		      			<?php
		      				//foreach ($district as $key => $v) {
		      					//$sel = $fields['district_one']==$v['text']?'selected':'';
		      					//echo '<option value="'.$v['text'].'" '.$sel.'>'.$v['text'].'</option>';
		      				//}
		      			?>
		      		</select>
		      		<span class="info"></span>
		      	</div>
		    </div>
	      	<div class="col-md-4 col-sm-4">
		      	<div class="form-group">
		      		<label class="form-label">Zip Code<span class="required">*</span></label>
		      		<input type="text" name="field[zip_code]" id="nzip_code" class="form-control" value="<?=isset($nzip_code)?$nzip_code:''?>">
		      		<span class="info"></span>
		      	</div>
		    </div>
		</div>
      	<div class="row">
	      	<div class="col-md-4 col-sm-4">
		      	<div class="form-group">
		      		<label class="form-label">Subsidiary<span class="required">*</span></label>
		      		<select class="form-control select2" name="field[subsidiary]" id="nsubsidiary">
		      			<?php
		      				foreach ($subsidiary as $key => $v) {
		      					$sel = $fields['subsidiary']==$v['text']?'selected':'';
		      					echo '<option value="'.$v['text'].'" '.$sel.'>'.$v['text'].'</option>';
		      				}
		      			?>
		      		</select>
		      		<span class="info"></span>
		      	</div>
		    </div>
		</div>
      	<div class="row">
	      	<div class="col-md-12 col-sm-12">
		      	<div class="form-group">
		      		<label class="form-label">Brand Interest<span class="required">*</span></label>
		      		<div class="col-md-12 col-sm-12 p-0">
		      			<label class="checkbox-inline" style="margin-right: 25px;">
		      				<input type="checkbox" name="field[brand_interest][]" class="bi" id="bi_mothercare" value="Mothercare"> Mothercare
		      			</label>
		      			<label class="checkbox-inline">
		      				<input type="checkbox" name="field[brand_interest][]" class="bi" id="bi_elc" value="ELC"> ELC
		      			</label>
		      			<label class="checkbox-inline">
		      				<input type="checkbox" name="field[brand_interest][]" class="bi" id="bi_gingersnaps" value="Gingersnaps"> Gingersnaps
		      			</label>
		      			<label class="checkbox-inline">
		      				<input type="checkbox" name="field[brand_interest][]" class="bi" id="bi_justice" value="Justice"> Justice
		      			</label>
		      			<label class="checkbox-inline">
		      				<input type="checkbox" name="field[brand_interest][]" class="bi" id="bi_wilio" value="Wilio"> Wilio
		      			</label>
		      			<label class="checkbox-inline">
		      				<input type="checkbox" name="field[brand_interest][]" class="bi" id="bi_coach" value="Coach"> Coach
		      			</label>
		      			<label class="checkbox-inline">
		      				<input type="checkbox" name="field[brand_interest][]" class="bi" id="bi_karen_millen" value="Karen Millen"> Karen Millen
		      			</label>
		      			<label class="checkbox-inline">
		      				<input type="checkbox" name="field[brand_interest][]" class="bi" id="bi_women_secret" value="Women Secret"> Women Secret
		      			</label>
		      			<label class="checkbox-inline">
		      				<input type="checkbox" name="field[brand_interest][]" class="bi" id="bi_havaianas" value="Havaianas"> Havaianas
		      			</label>
		      			<label class="checkbox-inline">
		      				<input type="checkbox" name="field[brand_interest][]" class="bi" id="bi_kanmoretail" value="Kanmoretail"> Kanmoretail
		      			</label>
		      			<label class="checkbox-inline">
		      				<input type="checkbox" name="field[brand_interest][]" class="bi" id="bi_kate_spade" value="Kate Spade"> Kate Spade
		      			</label>
		      			<label class="checkbox-inline">
		      				<input type="checkbox" name="field[brand_interest][]" class="bi" id="bi_nespresso" value="Nespresso"> Nespresso
		      			</label>
		      		</div>
		      	</div>
		    </div>
		</div>
      	<div class="row">
	      	<div class="col-md-12 col-sm-12">
		      	<div class="form-group">
		      		<label class="form-label">We would like to keep you updated on new products, services and exclusive offers. Please tick below if you:</label>
		      		<div class="col-md-12 col-sm-12 p-0">
		      			<label class="checkbox-inline" style="margin-right: 25px;">
		      				<input type="checkbox"> DO NOT wish to receive any form of marketing & promotion communication from us
		      			</label>
		      		</div>
		      	</div>
		    </div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn-reg">Register</button>
      </div>
    </div>
	</form>
  </div>
</div>
<div class="loading" style="display: flex; align-items: middle; justify-content: center; position: fixed; width: 100vw; height: 100vh; "><i class="fa fa-circle-o-notch fa5x"></i></div>
		<script type="text/javascript">
		function show_modal(e,trans_id){
			e.preventDefault();
			$('#detail-modal').modal('show');
			$('#detail-modal').on('shown.bs.modal', function(){
				table_detail(trans_id);
			});
		}
		function table_detail(trans_id){
			var periode = $('.fperiode').val();
			var store = $('.fstore').val();
		      var table = $('#table-items').on( 'processing.dt', function ( e, settings, processing ) {
		        //$('.btn-filter').find('i').css( 'display', processing ? 'inline-block' : 'none' );
		        //$('.btn-filter').prop( 'disabled', processing ? true : false );
		      }).DataTable({
		        responsive: false,
		        "ajax": {
	                "url": "<?=base_url('api/get_trans_detail/3ec8112b9e277cf4d24c85136fc9ee95'); ?>",
	                "type": "POST",
	                "data": {'trans_id':trans_id},
	            },
		        "aaSorting": [[ 5, "asc" ]],
		        "bLengthChange": false,
		        "bInfo": false ,
		        "search": false,
		        "paging": true,
		        "scrollX": true,
		        "bFilter": false,
		        "bStateSave": false,
		        "bServerSide": true,
		        "sPaginationType": "full_numbers",
		        "aoColumnDefs": [
		        { "sClass": "center", "aTargets": [ 0 ]},
		        { "sClass": "center", "aTargets": [ 1 ]},
		        { "sClass": "center", "aTargets": [ 2 ]},
		        { "sClass": "center", "aTargets": [ 3 ]},
		        { "sClass": "center", "aTargets": [ 4 ]},
		        { "sClass": "center", "aTargets": [ 5 ]},
		        { "sClass": "center", "aTargets": [ 6 ]},
		        { "sClass": "center", "aTargets": [ 7 ]},
		        { "sClass": "center", "aTargets": [ 8 ]},
		        ],
		        "destroy":true
		      });

	    }

	    /*function show_reopen_on_create(){
	    	$('#detail-ticket').modal('hide');
	    	$('#detail-ticket').on('hidden.bs.modal', function(){
				$('#modal-reopen').modal('show');
			})
	    }*/


		function show_detail_ticket(e,t_id){
			e.preventDefault();
			$('#tick_ids').val(t_id)
			$('#detail-ticket').find('.modal-body').html('<div class="flex" style="justify-content: center;align-content: middle;color:#ddd;"><i class="fa fa-circle-o-notch fa-spin fa-5x fa-fw"></i></div>');
			/*$.post('<?=base_url('api/ticket_detail/3ec8112b9e277cf4d24c85136fc9ee95'); ?>',{'id':t_id})
			.done(function(res){
				data = JSON.parse(res);
				$.each(data, function(i, v){
					$('#d'+i).text(v);
				})*/
			$.when($('#detail-ticket').show()).then(function(){
				$('#detail-ticket').find('.modal-body').load('<?=base_url('api/ticket/detail/nespresso/')?>3ec8112b9e277cf4d24c85136fc9ee95/0?ticket_id='+t_id+'&editable=0&issabel_user=<?=$agent?>');

				$('#reopen-form').on('submit', function(e){
				    e.preventDefault();
				    //var reopennote = CKEDITOR.instances['reopen-note'].getData();
				    $('[name="reopen_note"]').val($('#reopen-note').val());
				    var dt = $(this).serialize();
				    //alert(dt);
				    $.ajax({
				      url: '<?=base_url('api/ticket/save_reopen')?>',
				      type: 'post',
				      dataType: 'json',
				      data: $(this).serialize()
				    }).done(function(res){
				      if(res.status){
				        $().toastmessage('showToast', {
				                  text     : 'Reopen ticket success',
				                  position : 'top-center',
				                  type     : 'success',
				                  close    : function () {
				                    location.reload();
				                  }
				                });
				      }else{
				        if(res.code==200){
				          $.each(res.e, function(key,msg){
				            var info = $('[name="'+key+'"]').closest('.form-group').find('.info');
				                  info.html(msg);
				                });
				        }else{
				          $().toastmessage('showToast', {
				                    text     : 'Reopen ticket failed',
				                    position : 'top-center',
				                    type     : 'error',
				                    
				                  });
				        }
				      }
				    }).fail(function(xhr, status, error){
				    	$.post('<?=base_url('logger/writexhrlog')?>', {'xhr':xhr, 'act':'save_reopen', 'error':error, 'status':status});
				      alert('Something goes wrong, please call your aplication vendor');
				      console.log(xhr);
				      console.log(status);
				      console.log(error);
				    });
				});
			})

	    }
	    $('.dismis-detail-ticket').click(function(e){
	    	e.preventDefault();
	    	$('#detail-ticket').hide()
	    })

		function reload_table(){
			var periode = $('.fperiode').val();
			var store = $('.fstore').val();
		      var table = $('#table-trans').on( 'processing.dt', function ( e, settings, processing ) {
		        $('.btn-filter').find('i').css( 'display', processing ? 'inline-block' : 'none' );
		        $('.btn-filter').prop( 'disabled', processing ? true : false );
		      }).DataTable({
		        responsive: false,
		        "ajax": {
	                "url": "<?=base_url('api/get_trans/3ec8112b9e277cf4d24c85136fc9ee95'); ?>",
	                "type": "POST",
	                "data": {'phone':$('#phone').val(), 'periode':periode, 'store':store},
	            },
		        "aaSorting": [[ 5, "asc" ]],
		        "bLengthChange": false,
		        "bInfo": false ,
		        "search": false,
		        "paging": true,
		        "scrollX": true,
		        "bFilter": false,
		        "bStateSave": false,
		        "bServerSide": true,
		        "sPaginationType": "full_numbers",
		        "aoColumnDefs": [
		        { "sClass": "center", "aTargets": [ 0 ], "bSortable":false},
		        { "sClass": "center", "aTargets": [ 1 ]},
		        { "sClass": "center", "aTargets": [ 2 ]},
		        { "sClass": "align-right", "aTargets": [ 3 ]},
		        { "sClass": "center", "aTargets": [ 4 ]},
		        { "sClass": "align-right", "aTargets": [ 5 ]},
		        { "sClass": "center", "aTargets": [ 6 ]},
		        { "sClass": "center", "aTargets": [ 7 ], 
		        	"mRender":function(data, type, full){
		        		return '<button class="btn btn-default btn-xs" onclick="show_modal(event,'+full[1]+')"><i class="fa fa-list"></i> Detail</button>';
		        	}
		        	, "bSortable":false
		    	},
		        ],
		        "destroy":true
		      });

	    }

		function reload_table_ticket(){
			var periode = $('.tperiode').val();
			//var store = $('.tstore').val();
		      var table = $('#table-ticket').on( 'processing.dt', function ( e, settings, processing ) {
		        $('.btn-tfilter').find('i').css( 'display', processing ? 'inline-block' : 'none' );
		        $('.btn-tfilter').prop( 'disabled', processing ? true : false );
		      }).DataTable({
		        responsive: false,
		        "ajax": {
	                "url": "<?=base_url('api/get_ticket/3ec8112b9e277cf4d24c85136fc9ee95'); ?>",
	                "type": "POST",
	                "data": {'phone':$('#phone').val(), 'periode':periode/*, 'store':store*/},
	            },
		        "aaSorting": [[ 5, "asc" ]],
		        "bLengthChange": false,
		        "bInfo": false ,
		        "search": false,
		        "paging": true,
		        "scrollX": true,
		        "bFilter": false,
		        "bStateSave": false,
		        "bServerSide": true,
		        "sPaginationType": "full_numbers",
		        "aoColumnDefs": [
		        { "sClass": "center", "aTargets": [ 0 ], "data":1, "bSortable":false},
		        { "sClass": "center", "aTargets": [ 1 ], "data":2, },
		        { "sClass": "center", "aTargets": [ 2 ], "data":3, },
		        { "sClass": "center", "aTargets": [ 3 ], "data":4, },
		        { "sClass": "center", "aTargets": [ 4 ], "data":5, },
		        { "sClass": "center", "aTargets": [ 5 ], "data":6, },
		        { "sClass": "center", "aTargets": [ 6 ], 
		        	"mRender":function(data, type, full){
		        		return '<button class="btn btn-default btn-xs" onclick="show_detail_ticket(event,'+full[2]+')"><i class="fa fa-list"></i> Detail</button>';
		        	}
		        	, "bSortable":false
		    	},
		        ],
		        "destroy":true
		      });

	    }
	    $('#show-category-info-modal').click(function(){
	    	$('#find-category').modal('show')
	    })
	    var typingTimer;
		var doneTypingInterval = 500;
	    $('#find-subcat').on('keyup', function(){
	    	var subcat = $(this).val();
	    	clearTimeout(typingTimer);
  			typingTimer = setTimeout(function(){
  				$.ajax({url:'<?=base_url('api/show_subcat_info')?>', data:{'subcat':subcat}, type:'post', dataType:'text'})
		    	.done(function(res){
		    		$('#sub-category-table-info tbody').html(res);
		    	})
  			}, doneTypingInterval);
	    })
$('#nprovince').change(function(){
	var province = $(this).val();
	$('#ncity').html('<option></option>');
	$('#ndistrict').html('');
	if(province!==null && province!==''){
		$.ajax({url:'<?=base_url('api/kanmo/get_city')?>', data:{'province':province}, type:'post', dataType:'json'})
		.done(function(res){
			if(res.status){
				$('select#ncity').select2({
			      dropdownAutoWidth : false,
			      width: '100%',
			      data: res.data
			    });
			}
		})
	}
});
$('#ncity').change(function(){
	var city = $(this).val();
	$('#ndistrict').html('');
	if(city!==null && city!==''){
		$.ajax({url:'<?=base_url('api/kanmo/get_district')?>', data:{'city':city}, type:'post', dataType:'json'})
		.done(function(res){
			if(res.status){
				$('select#ndistrict').select2({
			      dropdownAutoWidth : false,
			      width: '100%',
			      data: res.data
			    });
			}
		})
	}
});
	    function search(){
	    	$('#alert-update').html('');
	    	$('#alert-update').hide();
	    	$('#btn-search').prop('disabled',true);
	    	$('#btn-search').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
	    	$.when(
	    		$.ajax({
	    		url: '<?=base_url('api/search_add/3ec8112b9e277cf4d24c85136fc9ee95')?>',
	    		data: {'phone':$('#seach_cus').val()},
	    		dataType: 'json',
	    		type: 'post'
	    	}).done(function(res){
	    		
	    		if(res.status){
					$('#fname').prop('readonly',true);
					$('#lname').prop('readonly',true);
					$('#phone').prop('readonly',true);
					$('#email').prop('readonly',true);
					if($('#phone').val()==''){
						$('#phone').val(res.data.nphone);
					}
	    			$('#action').val('update');
	    			$('#title-form-new').html('Update Customer Data');
	    			$('#warning').html('');
	    			console.log(res.data);
	    			$('#nprovince').val(res.data.nprovince_one).trigger('change');
	    			$('#ncity').select2({
				      dropdownAutoWidth : false,
				      width: '100%',
				      data: res.data.scity
				    });
				    $('#ncity').val(res.data.ncity_one).trigger('change');
	    			$('#ndistrict').select2({
				      dropdownAutoWidth : false,
				      width: '100%',
				      data: res.data.sdistrict
				    });
				    $('#ndistrict').val(res.data.ndistrict_one).trigger('change');
				    $('#nsubsidiary').val(res.data.nsubsidiary).trigger('change');
				    /*$('input#nfname').prop('readonly', true);
				    $('input#nlname').prop('readonly', true);
				    $('input#nemail').prop('readonly', true);
				    $('input#nbarcode').prop('readonly', true);*/
		    		$.each(res.data, function(i,v){
		    			if(i=='ngender'){
		    				$('input#ngender_'+v).prop('checked', true);
		    			}else if(i=='nbrand_interest'){
		    				$.each(v, function(idx, item){
		    					$('input#bi_'+item.toLowerCase().split(' ').join('_')).prop('checked', true);
		    				});
		    			}else if(i!='nprovince'&&i!='ncity'&&i!='ndistrict'&&i!='nsubsidiary'){
		    				$('input#'+i).val(v);
		    				$('span#'+i).html(v);
		    				$('input[name="'+i+'"]').val(v);
		    			}
		    		})
		    		$('#btn-reg').html('Update');
		    		$('#btn-update-panel').show();
		    		
		    	}else{
		    		$('#new-customer').modal('show');
		    		/*$('input#nfname').prop('readonly', false);
				    $('input#nlname').prop('readonly', false);
				    $('input#nemail').prop('readonly', false);
				    $('input#nbarcode').prop('readonly', false);*/
		    		$.each(res.data, function(i,v){
		    			if(i=='ngender'){
		    				$('input#ngender_FEMALE').prop('checked', true);
		    			}else if(i=='nbrand_interest'){
		    				$.each(v, function(idx, item){
		    					$('input.bi').prop('checked', false);
		    				});
		    			}else if(i!='nprovince'&&i!='ncity'&&i!='ndistrict'&&i!='nsubsidiary'){
		    				$('input#'+i).val(v);
		    				$('span#'+i).html('');
		    				$('input[name="'+i+'"]').val('');
		    			}
		    		})
		    		$('#action').val('new');
		    		$('#btn-update-panel').hide();

		    		$('#nprovince').val('').trigger('change');
		    		$('#ncity').val('').trigger('change');
		    		$('#ndistrict').val('').trigger('change');
		    		$('#warning').html('Searched Customer details not available. Please enter below details to get register with Us');
		    		$('#title-form-new').html('New Customer Registration');
		    		$('#btn-reg').html('Register');
		    		$('input#nphone').val(res.data.nphone);
		    	}
	    	}).fail(function(xhr, res, status){

	    	}).always(function(){
	    		$('#btn-search').html('<i class="fa fa-search"></i>');
	    		$('#btn-search').prop('disabled',false);
	    	})
	    	).then(function(){
	    		if($('#action').val()=='update'){
	    			reload_table();
		    	}
		    	reload_table_ticket();
    		})
	    }

	    $('#btn-update').click(function(e){
	    	e.preventDefault();
	    	$('#new-customer').modal('show');
	    })

	    $('#form-new').submit(function(e){
	    	e.preventDefault();
	    	$('#btn-reg').prop('disabled', true);
	    	$('#btn-reg').append('<i class="fa fa-circle-o-notch fa-spin fa-fw" id="loading-save"></i>');
	    	var is_success = false;
	    	$.when(
	    	$.ajax({
	    		url:'<?=base_url('api/save_customer')?>',
	    		type: 'post',
	    		dataType: 'json',
	    		data: $('#form-new').serialize()
	    	})
	    	.done(function(res){
    			if(res.status){
					$('#fname').prop('readonly',true);
					$('#lname').prop('readonly',true);
					$('#phone').prop('readonly',true);
					$('#email').prop('readonly',true);
					$('#btn-reg').html('Update');
		    		$('#btn-update-panel').show();
		    		if($('#phone').val()==''){
						$('#phone').val(res.data.nphone);
					}
    				is_success = true;
	    			$('#alert-update').removeClass('alert-danger');
	    			$('#alert-update').addClass('alert-success');
    				$.each(res.data, function(i, v){
    					console.log(i);
    					console.log(v);
	    				$('span#'+i).html(v);
	    				$('input[name="'+i+'"]').val(v);
	    			})
	    		}else{
	    			$.each(data.e, function(key, val){
	                	$('[name="'+key+'"] + .info').html(val);
	                });
	    			$('#alert-update').removeClass('alert-success');
	    			$('#alert-update').addClass('alert-danger');
	    		}
		    	$('#alert-update').html('<i>'+res.msg+'</i>');
		    	$('#alert-update').show();
	    	})
	    	.fail(function(xhr, error, status){
	    		console.log(xhr);
	    	})
	    	.always(function(){
	    		$('#btn-reg').prop('disabled', false);
	    		$('#loading-save').remove();
	    	})
	    	).then(function(){
	    		if(is_success){
	    			//reload_table();
		    		reload_table_ticket();
		    		$('#new-customer').modal('hide');
	    		}
	    	})
	    });

	    var init = true;

		  $(document).ready(function(){
		  	//outbound call
		  	$('#btn-call').click(function(){
		  		$('#btn-call').prop('disabled', true);
		      	$('#btn-call').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Call');
		      	$('#cphone').val($('input#phone').val());
		  		$.ajax({
		  			'url':'<?=base_url('api/outgoing_call')?>',
		  			'type':'post',
		  			'dataType':'json',
		  			'data':{'ext':'<?=$agent?>', 'dn':$('input#phone').val()}
		  		}).done(function(res){
		  			if(res.status){
		      			$('#btn-call').html('<i class="fa fa-phone"></i> Call');
		      			$('#outgoing_id').val(res.outgoing_id);
		  			}else{
		  				$('#btn-call').prop('disabled', false);
		      			$('#btn-call').html('<i class="fa fa-phone"></i> Call');
		  				$().toastmessage('showToast', {
		                  text     : res.msg,
		                  position : 'top-center',
		                  type     : 'error',
		                });
		  			}
		  		}).fail(function(xhr, error, status){

		  		})
		  	})

		  	//load data first call
		  	<?php if(isset($data)):?>
		  	$('#nprovince').val('<?=isset($nprovince_one)?$nprovince_one:''?>').trigger('change');
			$('#ncity').select2({
		      dropdownAutoWidth : false,
		      width: '100%',
		      data: <?=json_encode($scity)?>
		    });
		    $('#ncity').val('<?=isset($ncity_one)?$ncity_one:''?>').trigger('change');
			$('#ndistrict').select2({
		      dropdownAutoWidth : false,
		      width: '100%',
		      data: <?=json_encode($sdistrict)?>
		    });
		    $('#ndistrict').val('<?=isset($ndistrict_one)?$ndistrict_one:''?>').trigger('change');
		    <?php if(isset($nbrand_interest)):?>
		    	<?php foreach($nbrand_interest as $bi):?>
		    		$('input#bi_<?=strtolower(str_replace(' ', '_', $bi))?>').prop('checked', true);
		   		<?php endforeach;?>
		    <?php endif;?>
			<?php endif;?>
		  	//Date picker
		    $('.datepicker').datepicker({
		      autoclose: true,
		      format: 'yyyy-mm-dd'
		    });
		    
		  	$('select.select2').select2({
		      dropdownAutoWidth : false,
		      width: '100%',
		    });
		  	$('#seach_cus').keypress(function (event) {
			    if (event.keyCode === 10 || event.keyCode === 13) {
			        event.preventDefault();
			        search();
			    }
			});
			$('#btn-search').click(function(){
				search();
			})
		  	$('.loading').hide();
		  	$('#assign_to').change(function(){
		  		var email = $(this).find('option:selected').data('email');
		  		if(email!=''){
		  			$('[name="email_assign"]').prop('readonly', true);
		  		}else{
		  			$('[name="email_assign"]').prop('readonly', false);
		  		}
		  		$('[name="email_assign"]').val(email);
		  	});
		  	$('#status').change(function(){
		  		if($(this).val()=='OPEN'){
		  			$('#assign').css('display', 'block');
		  			$('#panel-callback').css('display', 'block');
		  			$('#panel-cc').css('display', 'block');
		  			$('#panel-closed').css('display', 'none');
		  		}else{
		  			$('#assign').css('display', 'none');
		  			$('#panel-callback').css('display', 'none');
		  			$('#panel-cc').css('display', 'none');
		  			$('#panel-closed').css('display', 'block');
		  		}
		  	});


		  	$('.fperiode').daterangepicker({autoUpdateInput:false,locale: {format: 'MMMM DD, YYYY', cancelLabel: 'Clear'}});
		  	$('.fperiode').on('apply.daterangepicker', function(ev, picker) {
			    $(this).val(picker.startDate.format('MMMM DD, YYYY') + ' - ' + picker.endDate.format('MMMM DD, YYYY'));
			});
		  	$('.tperiode').daterangepicker({autoUpdateInput:false,locale: {format: 'MMMM DD, YYYY', cancelLabel: 'Clear'}});
		  	$('.tperiode').on('apply.daterangepicker', function(ev, picker) {
			    $(this).val(picker.startDate.format('MMMM DD, YYYY') + ' - ' + picker.endDate.format('MMMM DD, YYYY'));
			});

			$('.fperiode').on('cancel.daterangepicker', function(ev, picker) {
			    $(this).val('');
			});
			$('.tperiode').on('cancel.daterangepicker', function(ev, picker) {
			    $(this).val('');
			});

			$('.nav-pills a').on('shown.bs.tab', function(event){
			  var x = $(event.target).text();         // active tab
			  if(x=='Customer Ticket History'){
			  	if(init){
				  	init = false;
				  	reload_table_ticket();
				}
			  }
			});
		  	reload_table();
		    $('form#form_ticketing').on('submit', function(e) {
		      e.preventDefault();
		      $('#btn-save').prop('disabled', true);
		      $('#btn-save').html('Save <i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
		      $.ajax({
		          url : '<?=base_url('api/save_ticket/'.$auth)?>',
		          type: "POST",
		          data : $('#form_ticketing').serialize(),
		          dataType: 'json',
		          success:function(data, textStatus, jqXHR){
		              if(!data.status){
		                $.each(data.e, function(key, val){
		                	$('[name="'+key+'"] + .info').html(val);
		                });
		              }else{
		                /*$('#alert').removeClass('alert-danger');
		                $('#alert').addClass('alert-success');
		                $('#alert').html('<i>Save Ticket Data Success</i>');*/
		                /*alert('Save Ticket Data Success');
		                $('#btn-update-panel').hide();
		                $('input[type="text"]').val('');
		                $('input[type="hidden"]').val('');
		                $('[name="content"]').text('');
		                $('[name="content"]').val('');
		                $('input[type="radio"]').prop('checked', false);
		                $('input[type="checkbox"]').prop('checked', false);
		                $('span.ftext').html('');
		                $('select').val('').trigger('change');
		                reload_table();
		                reload_table_ticket();*/
		                $('#content').html('<div class="alert alert-success text-center" ><i>Save Ticket Success</i></div>');
		              }
		          },
		          error: function(jqXHR, textStatus, errorThrown){
		          	$.post('<?=base_url('logger/writexhrlog')?>', {'act':'submit ticket call','xhr':jqXHR.responseText, 'status':textStatus, 'error':errorThrown});
		              alert('Error,something goes wrong');
		          },
		          complete: function(){
		          	$('#btn-save').prop('disabled', false);
		             $('#btn-save').html('Save');
		          }
		      });
		    });



		    $('[name="main_category"]').change(function(){
		  		var id = $(this).val();
		  		$('[name="meta_category"]').html('<option value=""> --Meta Category-- </option>');
		  		$('[name="category"]').html('<option value=""> --Category-- </option>');
		  		$('[name="sub_category"]').html('<option value=""> --Sub Category-- </option>');
		  		$.post('<?=base_url('api/api/get_meta_category')?>',{'id':id})
		  		.done(function(res){
		  			var data = JSON.parse(res);
		  			$.each(data, function(i,v){
		  				$('[name="meta_category"]').append('<option value="'+v.id+'">'+v.text+'</option>');
		  			})
		  		})
		  	})

		  	$('[name="meta_category"]').change(function(){
		  		var id = $(this).val();
		  		$('[name="category"]').html('<option value=""> --Category-- </option>');
		  		$('[name="sub_category"]').html('<option value=""> --Sub Category-- </option>');
		  		$.post('<?=base_url('api/api/get_category')?>',{'id':id})
		  		.done(function(res){
		  			var data = JSON.parse(res);
		  			$.each(data, function(i,v){
		  				$('[name="category"]').append('<option value="'+v.id+'">'+v.text+'</option>');
		  			})
		  		})
		  	})
		  	$('[name="category"]').change(function(){
		  		var id = $(this).val();
		  		$('[name="sub_category"]').html('<option value=""> --Sub Category-- </option>');
		  		$.post('<?=base_url('api/api/get_subcategory')?>',{'id':id})
		  		.done(function(res){
		  			var data = JSON.parse(res);
		  			$.each(data, function(i,v){
		  				$('[name="sub_category"]').append('<option value="'+v.id+'">'+v.text+'</option>');
		  			})
		  		})
		  	})



		    
		  });
		</script> 

        <!-- Bootstrap 3.3.6 -->
        <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
        <!-- iCheck 1.0.1 -->
        <script src="<?php echo base_url(); ?>assets/plugins/iCheck/icheck.min.js"></script>
        <!-- Select2 -->
        <script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
        <!-- Toast Message -->
		<script src="<?php echo base_url(); ?>assets/plugins/toastMessage/js/jquery.toastmessage.js"></script>
</body>
</html>
