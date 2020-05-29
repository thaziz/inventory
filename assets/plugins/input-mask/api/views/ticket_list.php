<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
	<!-- iCheck for checkboxes and radio inputs -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/iCheck/all.css">
	<!-- Select2 -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/toastMessage/css/jquery.toastmessage.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/ticket.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/style.css">

	<!-- <script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script> -->

	<script src="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/moment.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
	<style type="text/css">
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
		.breadcrumb{
			margin-bottom: 5px !important;
			margin-right: 20px !important;
		}
		.row{
			margin-right: 0;
		}
		.neo-module-content{
			min-height: 500px;
		}
		.cke_dialog{
			width: 400px !important;
		}
		.cke_dialog_contents{
			width: 100% !important;
		}
	</style>
</head>
<body>
	<!-- Content Header (Page header) -->
	<section class="content-header">
	  <div id="search-form" class="collapse">
	    <div class="flex" style="flex-direction: column;margin-left: -15px;justify-content: space-between;">
	      <form id="search-form">
	        <div class="col-md-8 col-md-offset-2">
	            <div class="form-group" style="display: flex;margin-bottom:7px;">
	              <label class="col-md-2">Ticket ID</label>
	              <div class="col-md-3">
	                <input type="text" name="ti" class="form-control input-sm">
	              </div>
	              <div class="col-md-2" style="margin-left: auto">
	                <select name="opt_ti" id="status" class="form-control input-sm" style="height: 30px !important;width: 100% !important; background-color: #ddd;float:right">
	                  <option value="exact">Exact</option>
	                  <option value="begins with">Begins with</option>
	                  <option value="ends with">Ends with</option>
	                  <option value="contain">Contain</option>
	                </select>
	              </div>
	          	</div>
	          	<div class="form-group" style="display: flex;margin-bottom:7px;">
	              <label class="col-md-2">Subject</label>
	              <div class="col-md-6">
	                <input type="text" name="sub" class="form-control input-sm">
	              </div>
	              <div class="col-md-2"  style="margin-left: auto">
	                <select name="opt_sub" id="status" class="form-control input-sm" style="height: 30px !important;width: 100% !important; background-color: #ddd;float:right">
	                  <option value="exact">Exact</option>
	                  <option value="begins with">Begins with</option>
	                  <option value="ends with">Ends with</option>
	                  <option value="contain">Contain</option>
	                </select>
	              </div>
	          	</div>
	          	<?php if($type=='kanmo'):?>
	          	<div class="form-group" style="display: flex;margin-bottom:7px;">
	              <label class="col-md-2">Brand</label>
	              <div class="col-md-4">
	                <select name="brand" id="status" class="form-control input-sm" style="height: 34px !important;width: 98% !important;">
	                  <option value=" "> --Brand-- </option>
	                  <?php foreach ($brand as $key => $b) {
	                  	echo '<option value="'.$b['id'].'">'.$b['text'].'</option>';
	                  }?>
	                  
	                </select>
	              </div>
	          	</div>
	          	<?php endif;?>
	          	<div class="form-group" style="display: flex;margin-bottom:7px;">
	              <label class="col-md-2">Main Category</label>
	              <div class="col-md-4">
	                <select name="maincat" id="status" class="form-control input-sm" style="height: 34px !important;width: 98% !important;">
	                  <option value=""> --Main Category-- </option>
	                  <?php foreach ($maincat as $key => $c) {
	                  	echo '<option value="'.$c['id'].'">'.$c['text'].'</option>';
	                  }?>
	                </select>
	              </div>
	          	</div>

	          	<div class="form-group" style="display: flex;margin-bottom:7px;">
	              <label class="col-md-2">Category</label>
	              <div class="col-md-4">
	                <select name="cat" id="status" class="form-control input-sm" style="height: 34px !important;width: 98% !important;">
	                  <option value=""> --Category-- </option>
	                  <?php foreach ($cat as $key => $c) {
	                  	echo '<option value="'.$c['id'].'">'.$c['text'].'</option>';
	                  }?>
	                </select>
	              </div>
	          	</div>

	          	<?php if($type=='kanmo'):?>
	          	<div class="form-group" style="display: flex;margin-bottom:7px;">
	              <label class="col-md-2">Sub Category</label>
	              <div class="col-md-4">
	                <select name="subcat" id="status" class="form-control input-sm" style="height: 34px !important;width: 98% !important;">
	                  <option value=""> --Sub Category-- </option>
	                </select>
	              </div>
	          	</div>
	          	<?php endif;?>
	          	<!--div class="form-group" style="display: flex;margin-bottom:7px;">
	              <label class="col-md-2">Status</label>
	              <div class="col-md-3">
	                <select name="stat" id="status" class="form-control input-sm" style="height: 34px !important;width: 98% !important;">
	                  <option value=""> --Status-- </option>
	                  <option value="OPEN">Open</option>
	                  <option value="CLOSED">Closed</option>
	                </select>
	              </div>
	          	</div-->
	          	<div class="form-group" style="display: flex;margin-bottom:7px;">
	              <label class="col-md-2">Customer Name</label>
	              <div class="col-md-6">
	                <input type="text" name="cn" id="customer" class="form-control input-sm">
	              </div>
	              <div class="col-md-2"  style="margin-left: auto">
	                <select name="opt_cn" id="status" class="form-control input-sm" style="height: 30px !important;width: 100% !important; background-color: #ddd;float:right">
	                  <option value="exact">Exact</option>
	                  <option value="begins with">Begins with</option>
	                  <option value="ends with">Ends with</option>
	                  <option value="contain">Contain</option>
	                </select>
	              </div>
	          	</div>
	          	<div class="form-group" style="display: flex;margin-bottom:7px;">
	              <label class="col-md-2">Customer Email</label>
	              <div class="col-md-6">
	                <input type="text" name="eml" id="email" class="form-control input-sm">
	              </div>
	              <div class="col-md-2"  style="margin-left: auto">
	                <select name="opt_eml" id="status" class="form-control input-sm" style="height: 30px !important;width: 100% !important; background-color: #ddd;float:right">
	                  <option value="exact">Exact</option>
	                  <option value="begins with">Begins with</option>
	                  <option value="ends with">Ends with</option>
	                  <option value="contain">Contain</option>
	                </select>
	              </div>
	          	</div>
	          	<div class="form-group" style="display: flex;margin-bottom:7px;">
	              <label class="col-md-2">Open By</label>
	              <div class="col-md-4">
	                <select name="openby" id="status" class="form-control input-sm" style="height: 34px !important;width: 98% !important;">
	                  <option value=""> --Open By-- </option>
	                  <?php foreach ($userlist as $key => $c) {
	                  	echo '<option value="'.$c->number.'">'.$c->name.'</option>';
	                  }?>
	                </select>
	              </div>
	          	</div>
	          	<div class="form-group" style="display: flex;margin-bottom:7px;">
	              <label class="col-md-2">Date Range</label>
	              <div class="col-md-4">
	                <input type="text" name="s_date" id="s_date" class="sdate form-control input-sm">
	              </div>
	            </div>
	            <div class="form-group" style="display: flex;margin-bottom:7px;">
	              <label class="col-md-2">Phone</label>
	              <div class="col-md-4">
	                <input type="text" name="phone" id="phone" class="form-control input-sm">
	              </div>
	            </div>
	            <div class="form-group" style="display:flex;justify-content:center;">
	              <button id = "clear" type="button" class="btn btn-default">Clear</button>
	              <button type="submit" class="btn btn-primary ml-20">Search</button>
	            </div>
	        </div>
	      </form>
	    </div>
	  </div>
	  <div>
	    <div class="btn-group btn-group-sm btn-filter">
	      <button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="text">All Tickets</span>
	        <span class="caret"></span>
	        <span class="sr-only">Toggle Dropdown</span>
	      </button>
	      <ul class="dropdown-menu" role="menu" style="width: 200px;">
	        <li>
	          <label for="rd1">
	            <input type="radio" id="rd1" name="filter" value="All Tickets"> All Tickets
	          </label>
	        </li>
	        <li>
	          <label for="rd2">
	            <input type="radio" id="rd2" name="filter" value="Open Tickets"> Open Tickets
	          </label>
	        </li>
	        <li>
	          <label for="rd3">
	            <input type="radio" id="rd3" name="filter" value="Closed Tickets"> Closed Tickets
	          </label>
	        </li>
	        <li>
	          <label for="rd4">
	            <input type="radio" id="rd4" name="filter" value="Callback Tickets"> Callback Tickets
	          </label>
	        </li>
	        <li>
	          <label for="rd5">
	            <input type="radio" id="rd5" name="filter" value="Unread Ticket"> Unread Ticket
	          </label>
	        </li>
	        <li>
	          <label for="rd6">
	            <input type="radio" id="rd6" name="filter" value="Unread Comment"> Unread Comment
	          </label>
	        </li>
	      </ul>
	    </div>

	    <label class="form-label mb-0 mt-2">Sort By:</label>
	    <div class="btn-group btn-group-sm btn-filter sort">
	      <button type="button" class="btn btn-sm btnsort"><span>Latest Comment</span> <i class="fa fa-sort-alpha-asc"></i></button>
	      <button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
	        <span class="caret"></span>
	        <span class="sr-only">Toggle Dropdown</span>
	      </button>
	      <ul class="dropdown-menu" role="menu" style="width: 170px;">
	        <li>
	          <label for="cb1">
	            <input type="radio" id="cb1" checked name="sort" value="Latest Comment"> Latest Comment
	          </label>
	        </li>
	        <li>
	          <label for="cb2">
	            <input type="radio" id="cb2" name="sort" value="Customer Name"> Customer Name
	          </label>
	        </li>
	        <li>
	          <label for="cb3">
	            <input type="radio" id="cb3" name="sort" value="Status"> Status
	          </label>
	        </li>
	        <li>
	          <label for="cb4">
	            <input type="radio" id="cb4" name="sort" value="Country of Origin"> Country of Origin
	          </label>
	        </li>
	        <li>
	          <label for="cb5">
	            <input type="radio" id="cb5" name="sort" value="City"> City
	          </label>
	        </li>
	        <li>
	          <label for="cb6">
	            <input type="radio" id="cb6" name="sort" value="Create Date"> Create Date
	          </label>
	        </li>
	      </ul>
	    </div>
	    <span class="ml-2 mr-2">
	      <span class="circle bg-open text-white" id="copen">0</span> Open
	    </span>
	    <!--span class="mr-2">
	      <span class="circle bg-stoped text-white" id="ccallback">0</span> Stoped
	    </span->
	    <span class="mr-2">
	      <span class="circle bg-closed text-white" id="ccallback">0</span> Callback
	    </span-->
	    <span class="mr-2">
	      <span class="circle bg-solved text-white" id="cclosed">0</span> Closed
	    </span>

	    <button class="btn btn-primary btn-circle btn-sm pull-right" style="padding:2px 10px;" data-toggle="collapse" data-target="#search-form">Search <i class="fa fa-search"></i></button>
	  </div>

	</section>
	<!-- Main content -->
	<section class="content" style="display: flex;">
	  <!-- Content -->
	  <div class="row" style="width: 100%;display: block">
	    <div class="col-md-12">
	      <div class="box box-info">
	        <div class="box-body table-responsive no-padding">
	          <table id="ticket_table" class="table table-bordered table-striped table-ticket">
	            <thead>
	              <tr>
	                <th width="10px">
	                  <input type="checkbox" id="checkall">
	                </th>
	                <th colspan="2" style="border-right-color: transparent;">
	                  <button id="btn-assign" class="btn btn-primary" disabled onclick="show_assign()">Assign to</button>
	                  <button id="btn-closed" class="btn btn-info" disabled onclick="show_closed()">Closed</button>
	                  <a href="<?=base_url('api/'.(strtolower($type)=='kanmo'?'kanmo/':'').'form_ticket/3ec8112b9e277cf4d24c85136fc9ee95?agent='.$user)?>" id="btn-new" class="btn btn-warning" target="_blank" style="display: none;">Create Ticket</a>
	                  <button style="display: none;" id="btn-export" class="btn btn-success" onclick="export_excel()">Export</button>
	                </th>
	                <th colspan="2" style="border-right-color: transparent;border-left-color: transparent;">
	                <select name="curr_assign" id="curr_assign" class="form-control input-sm" style="height: 34px !important;width: 60% !important; float: right">
	                  <option value="">All Assigment</option>
	                  <?php 
	                  	foreach ($assignment as $key => $assign) {
	                  		echo '<option value="'.$assign['id'].'">'.$assign['text'].'</option>';
	                  	}
	                  ?>
	                </select>
	                </th>
	                <th style="border-left-color: transparent;"></th>
	              </tr>
	            </thead>
	            <tbody>
	              
	            </tbody>
	          </table>
	        </div>
	        <div class="box-footer clear-fix">
	          <ul class="pagination no-margin pull-right" id="paging">
	          </ul>
	        </div>
	      </div>
	    </div>
	  </div>

<!-- modal assign -->
<div class="modal fade" id="modal-assign">
  <div class="modal-dialog modal-custom">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Assignment</h4>
      </div>
        <form role="form" id="assign-form">
          <div class="modal-body">
          <div class="row">
            <div class="col-md-4 pl-20">
              <input type="hidden" name="user_id" value="<?=$user?>">
              <input type="hidden" name="tick_ids">
              <div class="form-group">
                <label for="assign_to">Assign to</label>
                <select class="form-control input-sm" name="assign_to" id="assign_to" style="height: 34px !important;width: 100% !important;">
                  <option value="" data-email="" selected> -- Assign to -- </option>
                  <?php 
                  	foreach ($assignment as $key => $assign) {
                  		echo '<option value="'.$assign['id'].'" data-email="'.$assign['email'].'">'.$assign['text'].'</option>';
                  	}
                  ?>
                </select>
                <span class="info"></span>
              </div>
            </div>
            <div class="col-md-6" style="margin-top: 25px;">
              <div class="form-group">
                <input type="text" name="email_assign" id="email_assign" class="form-control" placeholder="Email">
                <span class="info"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-11 px-20" style="width: 96%;">
              <div class="form-group">
                <label for="assign_to">Note</label>
                <textarea class="form-control" id="assign-note"></textarea>
                <input type="hidden" name="assign_note">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Assignment</button>
        </div>
        </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- modal status -->
<div class="modal fade" id="modal-status">
  <div class="modal-dialog modal-custom">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal-status-title">Close Ticket</h4>
      </div>
      <form role="form" id="status-form">
          <div class="modal-body">
          
          <input type="hidden" name="user_id" value="<?=$user?>">
          <input type="hidden" name="tick_ids">
          <div class="row">
            <div class="col-md-11 px-20" style="width: 96%;">
              <div class="form-group">
                <label for="comment">Note</label>
                <textarea class="form-control" id="status-note"></textarea>
            	<input type="hidden" name="status_note">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>





<!-- modal edit ticket -->


<!-- modal status -->
<div class="modal fade" id="modal-comment">
  <div class="modal-dialog modal-custom full">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal-status-title">Edit Ticket</h4>
      </div>
      <form role="form" id="ticket-form">
          <div class="modal-body">
          	
          <div class="row">
            <div class="col-md-11 px-20" style="width: 96%;">





<!-- kanmo  -->
<?php if($type=='kanmo'):?>
				<div class="form-group row">
					<div class="col-md-12 col-sm-9 p-0">
						<label class="col-md-2 col-sm-2 mt-5" for="ticket_id">Ticket ID</label>
						<div class="col-md-4 col-sm-4">
							<input type="text" name="ticket_id" class="form-control input-sm" id="ticket"  readonly>
							<input type="hidden" name="user_id" value="<?=$user?>">
							<span class="info"></span>
						</div>

						<label for="comment" class="col-md-2 col-sm-2">Brand <span class="required">*</span></label>
						<div class="col-md-4 col-sm-4">
							<select class="form-control" name="brand" id="brand" style="height:32px !important;">
								<option value=""> --Brand-- </option>
								<?php foreach ($brand as $key => $value) {
									echo '<option value="'.$value['id'].'">'.$value['text'].'</option>';
								}?>
							</select>
							<span class="info"></span>
						</div>
					</div>
				</div> 
<!-- line 2 -->
				<div class="form-group row" >
					<div class="col-md-12 col-sm-9 p-0">
						<label for="comment" class="col-md-2 col-sm-2">Call Type <span class="required">*</span></label>
						<div class="col-md-4 col-sm-4">
							<select class="form-control" name="main_category" id="main_category" style="height:32px !important;">
								<option value=""> --Call Type-- </option>
								<?php foreach ($maincat as $key => $value) {
									if($value['text']!='Order')
									echo '<option value="'.$value['id'].'">'.$value['text'].'</option>';
								}?>
							</select>
							<span class="info"></span>
						</div>
						
						<label for="comment" class="col-md-2 col-sm-2">Meta Category <span class="required">*</span></label>
						<div class="col-md-4 col-sm-4">
							<select class="form-control" id="meta_category" name="meta_category" style="height:32px !important;">							
								<option value=""> --Meta Category-- </option>
							</select>
							<span class="info"></span>
						</div>

					</div>
				</div> 



				<div class="form-group row" >
					<div class="col-md-12 col-sm-9 p-0">
					<label for="comment" class="col-md-2 col-sm-2">Category <span class="required">*</span></label>
					<div class="col-md-4 col-sm-4">
						<select id="category" class="form-control" name="category" style="height:32px !important;">
							<option value=""> --Ticket Category-- </option>
						</select>
						<span class="info"></span>
					</div>

					<label for="comment" class="col-md-2 col-sm-2">Sub Category <span class="required">*</span></label>
					<div class="col-md-4 col-sm-4">
						<select id="sub_category" class="form-control" name="sub_category" style="height:32px !important;">
							<option value=""> --Sub Category-- </option>
						</select>
						<span class="info"></span>
					</div>
					</div>
				</div> 
<?php endif ?>

<!-- nespresso  -->
<?php if($type=='nespresso'):?>
				<div class="form-group row">
					<div class="col-md-12 col-sm-9 p-0">
						<label class="col-md-2 col-sm-2 mt-5" for="ticket_id">Ticket ID</label>
						<div class="col-md-4 col-sm-4">
							<input type="text" name="ticket_id" class="form-control input-sm" id="ticket"  readonly>
							<input type="hidden" name="user_id" value="<?=$user?>">
							<span class="info"></span>
						</div>

						<label for="comment" class="col-md-2 col-sm-2">Call Type <span class="required">*</span></label>
						<div class="col-md-4 col-sm-4">
							<select id="main_category" class="form-control" name="main_category" style="height:32px !important;">
								<option value=""> --Main Category-- </option>
								<?php foreach ($maincat as $key => $value) {
									echo '<option value="'.$value['id'].'">'.$value['text'].'</option>';
								}?>
							</select>
							<span class="info"></span>
						</div>





					</div>
				</div> 
<!-- line 2 -->
				<div class="form-group row" >
					<div class="col-md-12 col-sm-9 p-0">
						<label for="comment" class="col-md-2 col-sm-2">Meta Category <span class="required">*</span></label>
						<div class="col-md-4 col-sm-4">
							<select id="meta_category" class="form-control" name="meta_category" style="height:32px !important;">
								<option value=""> --Meta Category-- </option>
							</select>
							<span class="info"></span>
						</div>

						<label for="comment" class="col-md-2 col-sm-2">Category <span class="required">*</span></label>
					<div class="col-md-4 col-sm-4">
						<select id="category" class="form-control" name="category" style="height:32px !important;">
							<option value=""> --Ticket Category-- </option>
						</select>
						<span class="info"></span>
					</div>


					</div>
				</div> 

				<div class="form-group row">
					<label for="comment" class="col-md-2 col-sm-2">Sub Category <span class="required">*</span></label>
					<div class="col-md-4 col-sm-4">
						<select id="sub_category" class="form-control" name="sub_category" style="height:32px !important;">
							<option value=""> --Sub Category-- </option>
						</select>
						<span class="info"></span>
					</div>
				</div>
				
<?php endif ?>

				<div class="form-group row" id="ccbcc">
					<label class="col-md-2 col-sm-2 mt-5" for="status">Content</label>
					<div class="col-md-10 col-sm-10 p-0">
						<div class="col-md-12 col-sm-5">
							<textarea name="content" class="form-control" rows="7" id="content"></textarea>
							<span class="info"></span>
						</div>
					</div>
				</div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" onclick="save()" class="btn btn-primary" id="btn-create">Save</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- modal edit tiket selesai -->



	</section>
	<script type="text/javascript">
	  var filter='all tickets', sort='latest comment', data=[];
	  var ssort = 'desc', start=0;
	  var tick_ids=[];
	  var sids=[];


	  $('input[name="filter"]').change(function(){
	    filter = $(this).val();
	    $('.btn .text').html(filter);
	    load_data(0);
	  });
	  $('input[name="sort"]').change(function(){
	    sort = $(this).val();
	    $('.btnsort span').html(sort);
	    load_data(0);
	  });
	  $('.btnsort').click(function(){
	    if(ssort=='asc'){
	      ssort = 'desc';
	      $('.fa-sort-alpha-asc').addClass('fa-sort-alpha-desc');
	      $('.fa-sort-alpha-asc').removeClass('fa-sort-alpha-asc');
	    }else{
	      ssort = 'asc';
	      $('.fa-sort-alpha-desc').addClass('fa-sort-alpha-asc');
	      $('.fa-sort-alpha-desc').removeClass('fa-sort-alpha-desc');
	    }
	    load_data(0);
	  });
	  $('#curr_assign').change(function(){
	  	load_data(0)
	  })

	  $(function(){ load_data(0); });
	  $('#search-form').on('submit', function(e){
	    e.preventDefault();
	    load_data(0)
	  });

	  $('#clear').on('click', function(e){
	    /*e.preventDefault();*/
	    location.reload();
	  });

	  function load_data(p){
	    if(p!=undefined){
	      start = p;
	    }
	    var search = [];
	    $('#search-form .form-control').each(function(i,v){
	      var field = $(this).attr('name');
	      var val = $(this).val();
	      search.push('"'+field+'":"'+val+'"');
	    });
	    search = "{"+search.join(",")+"}";
	    search = JSON.parse(search);
	    //console.log(search)
	    $.ajax({
	      url: '<?=current_url()?>',
	      type: 'post',
	      dataType: 'json',
	      data:{'order':sort, 'type':'a', 'filter':filter, 'ortype':ssort, 'start':start, 'adv_search':search, 'curr_assign':$('#curr_assign').val()}
	    }).done(function(res){
	        data = [];
	        //var res = JSON.parse(response);
	        $('#copen').html(res.open);
	        $('#cclosed').html(res.closed);
	        //$('#ccallback').html(res.callback);
	        $('#paging').html(res.paging);
	        $('#paging a').click(function(e){
	          e.preventDefault();
	          var page = $(this).data('page');
	          load_data(page)
	        })
	        $('#ticket_table tbody').html('');
	        if(res.data.length>0){
		        $.when($.each(res.data, function(idx, val){
		          data[val.tick_id] = val;
		          var tr = '<tr data-ticket="'+val.id+'" data-ticket_id="'+val.ticket_id+'"><td>';
		          if(val.subject!==''&&val.status!='CLOSED'){
		            tr += '<input type="checkbox" class="tick_chck" value="'+val.id+'"/>';
		          }
		          tr +='</td>';
		          inverse = 'fa-inverse';
		          square = 'square';
		          if(val.status=='OPEN'){
		            status = 'primary';
		            if(val.is_read==1){
		            	inverse = 'text-primary';
		            	square = 'square-o'
		            }
		          }else if(val.status=='CALLBACK'){
		            status = 'warning';
		          }else if(val.status=='CLOSED'){
		            status = 'success';
		          }

		          tr += '<td width="70px"><span class="fa-stack fa-lg"><i class="fa fa-'+square+' fa-stack-2x text-'+status+'"></i><i class="fa fa-ticket fa-stack-1x '+inverse+'"></i></span></td>';
		          tr += '<td><span><div>'+val.ticket_id+' - '+val.subject+'</div><div class="small"><span>Created by: '+val.open_by_name+'</span></div><div class="small text-muted"><span>Created on: '+val.open_date+'</span></div></span></td>';
		          tr += '<td><span><div><i class="fa fa-user"></i> '+val.cus_fname+' '+val.cus_lname+'</div><div class="small">City: '+val.city_one+'</div><div class="small">Country: '+val.country_origin+'</div></span></td>';
		          tr += '<td><div class="text-muted small"><span>Assign to</span> : '+(val.assign_user==null?'n/a':val.assign_user)+'</div><div class="text-muted small"><span>Status</span> : <label class="label label-'+(val.status=='OPEN'?'primary':(val.status=='CALLBACK'?'warning':'success'))+'">'+val.status+'</label></div><div class="text-muted small"><span>Need Callback</span> : '+(val.need_callback==1?'Yes':'No')+'</div></td>';
		            tr += '<td>';
		            


		            tr+='<a href="<?=str_replace('kanmo/', '', base_url()).'index.php?menu='.$type.'_ticket&action=detail&id='?>'+val.ticket_id+'" class="btn btn-default btn-xs"><i class="fa fa-list"></i> Detail</a>'






		            	+'</td>'
		          tr +=  '</tr>';



		          $('#ticket_table tbody').append(tr);

		        })
		        ).then(function(x){

		          $('#checkall').change(function(){
		            $('.tick_chck').prop('checked', $(this).prop('checked'));
		            tick_ids = [];
		            $('.tick_chck:checked').each(function(i,v){
		              var f = $(this).val();
		              tick_ids.push(f);
		            });
		            if(tick_ids.length>0){
		              $('#btn-assign').prop('disabled', false);
		              $('#btn-closed').prop('disabled', false);
		            }else{
		              $('#btn-assign').prop('disabled', true);
		              $('#btn-closed').prop('disabled', true);
		            }
		          });
		          $('.tick_chck').change(function(){
		            if($(this).prop('checked')){
		              var f = $(this).val();
		              tick_ids.push(f);
		            }else{
		              var f = $(this).val();
		              tick_ids.splice(tick_ids.indexOf(f), 1);
		            }
		            if(tick_ids.length>0){
		              $('#btn-assign').prop('disabled', false);
		              $('#btn-closed').prop('disabled', false);
		            }else{
		              $('#btn-assign').prop('disabled', true);
		              $('#btn-closed').prop('disabled', true);
		            }
		            var fl = 0;
		          });

		        });
		        $('#ticket_table tbody>tr').on('dblclick', function (e) {
		            e.stopPropagation();
		              var id = $(this).data('ticket_id');
		              window.location = '<?=str_replace('kanmo/', '', base_url()).'index.php?menu='.$type.'_ticket&action=detail&id='?>'+id;
		        });
		    }else{
		    	$('#btn-assign').prop('disabled', true);
		        $('#btn-closed').prop('disabled', true);
		    	$('#ticket_table tbody').append('<tr><td colspan="6" style="text-align:center;"><i>No data found</i></td></tr>');
		    }
	        console.log(res);
	      }).fail(function(xhr, error, status){

	      })
	  }

	  $(function(){
	  	$('#s_date').daterangepicker({autoUpdateInput:false,locale: {format: 'MMMM DD, YYYY', cancelLabel: 'Clear'}});
	  	$('#s_date').on('apply.daterangepicker', function(ev, picker) {
		    $(this).val(picker.startDate.format('MMMM DD, YYYY') + ' - ' + picker.endDate.format('MMMM DD, YYYY'));
		});
		$('#s_date').on('cancel.daterangepicker', function(ev, picker) {
		    $(this).val('');
		});
	  })

	</script>
	<!-- CKEditor -->
	<script src="<?=base_url()?>assets/plugins/ckeditor/ckeditor.js"></script>
	<script type="text/javascript">
		function export_excel() {
			
			/*$('#search-form .form-control').each(function(index,value){	
				var search = [];	
				var field = $(this).attr('name')
		      	var val = $(this).val()
		      	search.push('"'+field+'":"'+val+'"')
		      	search = "{"+search.join(",")+"}"
		      	search = JSON.parse(search);
	      		$.ajax({
	      			url: "<?php //echo base_url('api/ticket/export_excel'); ?>",
				  	type: "GET",
				  	data: { 
					    search
				  	},
				  	success: function(response) {
				  		console.log(response)
				  	},
				  	error: function(xhr) {
				  		alert('Something goes wrong, please call your aplication vendor')
				  	}
      			})
			})*/
			var datas = {
							'ticket_id' : $('#search-form [name=ti]').val(),
							'ticket_position' : $('#search-form [name="opt[ti]"]').val(),
							'subject' : $('#search-form [name=sub]').val(),
							'subject_position' : $('#search-form [name="opt[sub]"]').val(),
							'category' : $('#search-form [name=cat]').val(),
							'customer_id' : $('#search-form [name=cn]').val(),
							'customer_position' : $('#search-form #status').val(),
							'date_id' : $('#search-form [name=s_date]').val(),
						};

				$.ajax({
	      			url: "<?php echo base_url('api/ticket/export_excel'); ?>",
				  	type: "GET",
				  	data: { 
					    datas
				  	},
				  	success: function(response) {
				  		console.log(response)
				  		/*var $form = $('<form action="' + window.location + '" method="post"></form>');
					  	$.each(response, function() {
					    	$('<input type="hidden" name="dane[]">').attr('value', this).appendTo($form);
					  	});

					  	$form.appendTo('body').submit();*/
					  	//download('test.csv', response)
				  	},
				  	error: function(xhr) {
				  		alert('Something goes wrong, please call your aplication vendor')
				  	}
      			})
		}

		function download(filename, text) {
		    var pom = document.createElement('a');
		    pom.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(text));
		    pom.setAttribute('download', filename);

		    if (document.createEvent) {
		        var event = document.createEvent('MouseEvents');
		        event.initEvent('click', true, true);
		        pom.dispatchEvent(event);
		    } else {
		        pom.click();
		    }
		}

		function show_closed(){
			$('#modal-status').modal('show');
		}
		function show_assign(){
			$('#modal-assign').modal('show');
		}
		$(function(){

		  	$('#assign_to').change(function(){
		  		var email = $(this).find('option:selected').data('email');
		  		if(email!=''){
		  			$('[name="email_assign"]').prop('readonly', true);
		  		}else{
		  			$('[name="email_assign"]').prop('readonly', false);
		  		}
		  		$('[name="email_assign"]').val(email);
		  	});

			var toolbars = [{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline'] },{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },{ name: 'links', items: [ 'Link', 'Unlink' ] },];
		    //CKEDITOR.replace('comment-note', {height:130,toolbar: toolbars});
		    CKEDITOR.replace('assign-note', {height:75,toolbar: toolbars,removePlugins: 'elementspath',resize_enabled: false});
		    CKEDITOR.replace('status-note', {height:75,toolbar: toolbars,removePlugins: 'elementspath',resize_enabled: false});
			//alert('hello');

			$('#assign-form').on('submit', function(e){
			    e.preventDefault();
			    var asgnote = CKEDITOR.instances['assign-note'].getData();
			    $('[name="assign_note"]').val(asgnote);
			    $('[name="tick_ids"]').val(tick_ids.join(','));
			    var dt = $(this).serialize();
			    //alert(dt);
			    $.ajax({
			      url: '<?=base_url('api/ticket/save_assign')?>',
			      type: 'post',
			      dataType: 'json',
			      data: $(this).serialize()
			    }).done(function(res){
			      if(res.status){
			        $().toastmessage('showToast', {
			                  text     : 'Assign ticket success',
			                  position : 'top-center',
			                  type     : 'success',
			                  close    : function () {
			                    $('#modal-assign').modal('hide');
			                    load_data();
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
			                    text     : 'Assign ticket failed',
			                    position : 'top-center',
			                    type     : 'error',
			                    
			                  });
			        }
			      }
			    }).fail(function(xhr, status, error){
			      alert('Something goes wrong, please call your aplication vendor');
			      console.log(xhr);
			      console.log(status);
			      console.log(error);
			    });
			})

			$('#status-form').on('submit', function(e){
			    e.preventDefault();
			    var asgnote = CKEDITOR.instances['status-note'].getData();
			    $('[name="status_note"]').val(asgnote);
			    $('[name="tick_ids"]').val(tick_ids.join(','));
			    var dt = $(this).serialize();
			    //alert(dt);
			    $.ajax({
			      url: '<?=base_url('api/ticket/save_closed')?>',
			      type: 'post',
			      dataType: 'json',
			      data: $(this).serialize()
			    }).done(function(res){
			      if(res.status){
			        $().toastmessage('showToast', {
			                  text     : 'Close ticket success',
			                  position : 'top-center',
			                  type     : 'success',
			                  close    : function () {
			                    $('#modal-status').modal('hide');
			                    load_data();
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
			                    text     : 'Close ticket failed',
			                    position : 'top-center',
			                    type     : 'error',
			                    
			                  });
			        }
			      }
			    }).fail(function(xhr, status, error){
			      alert('Something goes wrong, please call your aplication vendor');
			      console.log(xhr);
			      console.log(status);
			      console.log(error);
			    });
			});
		})
/*		function edit_ticket(id){
			var data={
				'ticket_id': id,
				'type': "<?=$type ?>",
			}
			
			$.ajax({
			      url: '<?=base_url('api/ticket/data_detail')?>',
			      type: 'POST',
			      dataType: 'json',
			      data: data,
			    }).done(function(res){

				$("#brand option").filter(function() {
				    return this.text == res.brand; 
				}).attr('selected', true);

				$("#main_category option").filter(function() {
				    return this.text == res.main_category; 
				}).attr('selected', true);


				$("#meta_category option").filter(function() {
				    return this.text == res.meta_category; 
				}).attr('selected', true);

				$("#category option").filter(function() {
				    return this.text == res.category; 
				}).attr('selected', true);


				$("#sub_category option").filter(function() {
				    return this.text == res.sub_category; 
				}).attr('selected', true);

				$('#ticket').val(res.content);
				$('#ticket').val(res.ticket_id);

			    }).fail(function(xhr, status, error){
			      alert('Something goes wrong, please call your aplication vendor');
			      console.log(xhr);
			      console.log(status);
			      console.log(error);
			    });



			$('#modal-comment').modal('show');
			
		}

*/

		
		
	</script>
        <!-- iCheck 1.0.1 -->
        <script src="<?php echo base_url(); ?>assets/plugins/iCheck/icheck.min.js"></script>
        <!-- Select2 -->
        <script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
        <!-- Toast Message -->
		<script src="<?php echo base_url(); ?>assets/plugins/toastMessage/js/jquery.toastmessage.js"></script>
</body>
</html>