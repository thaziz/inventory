
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
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/sliptree/css/bootstrap-tokenfield.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/ticket.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/style.css">

<!-- 	<script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>  -->
	<script src="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/moment.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>


  <style type="text/css">
    /*---------chat window---------------*/
    .chat_people_header {
      margin-bottom: 0 !important;
    }
    .chat_date {
      margin-bottom: 10px;
    }
    .container{
      max-width:900px;
    }
    .inbox_people {
      background: #fff;
      float: left;
      overflow: hidden;
      width: 25%;
      border-right: 1px solid #ddd;
    }

    .inbox_people2 {
      background: #fff;
      float: left;
      overflow: hidden;
      width: 100%;
      border-right: 1px solid #ddd;
    }

    .inbox_people3 {
      background: #fff;
      float: left;
      overflow: hidden;
      width: 35%;
      border-right: 1px solid #ddd;
    }


    .inbox_msg {
      /*border: 1px solid #ddd;*/
      clear: both;
      overflow: hidden;
    }

    .top_spac {
      margin: 20px 0 0;
    }

    .recent_heading {
      float: left;
      width: 40%;
    }

    .srch_bar {
      display: inline-block;
      text-align: right;
      width: 60%;
      padding:
    }

    .headind_srch {
      padding: 10px 29px 10px 20px;
      overflow: hidden;
      border-bottom: 1px solid #c4c4c4;
    }

    .recent_heading h4 {
      color: #0465ac;
      font-size: 16px;
      margin: auto;
      line-height: 29px;
    }

    .srch_bar input {
      outline: none;
      border: 1px solid #cdcdcd;
      border-width: 0 0 1px 0;
      width: 80%;
      padding: 2px 0 4px 6px;
      background: none;
    }

    .srch_bar .input-group-addon button {
      background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
      border: medium none;
      padding: 0;
      color: #707070;
      font-size: 18px;
    }

    .srch_bar .input-group-addon {
      margin: 0 0 0 -27px;
    }

    .chat_ib h5 {
      font-size: 15px;
      color: #464646;
      margin: 0 0 8px 0;
    }

    .chat_ib h5 span {
      font-size: 13px;
      float: right;
    }

    .wordwrap { 
     white-space: pre-wrap;      /* CSS3 */   
     white-space: -moz-pre-wrap; /* Firefox */    
     white-space: -pre-wrap;     /* Opera <7 */   
     white-space: -o-pre-wrap;   /* Opera 7 */    
     word-wrap: break-word;      /* IE */
   }


   .chat_ib p {
    font-size: 12px;
    color: #989898;
    margin: auto;
    display: inline-block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .chat_img {
    float: left;
    width: 11%;
  }

  .chat_img img {
    width: 100%
  }

  .chat_ib {
    float: left;
    padding: 0 0 0 15px;
    width: 88%;
  }

  .chat_people {
    overflow: hidden;
    clear: both;
  }

  .chat_list {
    border-bottom: 1px solid #ddd;
    margin: 0;
    padding: 18px 16px 10px;
  }

  .inbox_chat {
    height: 530px;
    overflow-y: scroll;
  }

  .active_chat {
    background: #e8f6ff;
  }

  .incoming_msg_img {
    display: inline-block;
    width: 6%;
  }

  .incoming_msg_img img {
    width: 100%;
  }

  .received_msg {
    display: inline-block;
    padding: 0 0 0 10px;
    vertical-align: top;
    width: 92%;
  }

  .received_withd_msg p {
    background: #ebebeb none repeat scroll 0 0;
    border-radius: 0 15px 15px 15px;
    color: #646464;
    font-size: 14px;
    margin: 0;
    padding: 5px 10px 5px 12px;
    width: 100%;
  }

  .time_date {
    color: #747474;
    display: block;
    font-size: 12px;
    margin: 8px 0 0;
  }

  .received_withd_msg {
    width: 90%;
  }

  .mesgs{
    float: left;
    padding: 30px 15px 0 25px;
    width:100%;
  }

  .sent_msg p {
    background:#0465ac;
    border-radius: 12px 15px 15px 0;
    font-size: 14px;
    margin: 0;
    color: #fff;
    padding: 5px 10px 5px 12px;
    width: 100%;
  }

  .outgoing_msg {
    overflow: hidden;
    margin: 26px 0 26px;
  }

  .sent_msg {
    float: right;
    width: 90%;
  }

  .input_msg_write input {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border: medium none;
    color: #4c4c4c;
    font-size: 15px;
    min-height: 48px;
    width: 100%;
    outline:none;
  }

  .type_msg {
    border-top: 1px solid #c4c4c4;
    position: relative;
  }

  .msg_send_btn {
    background: #05728f none repeat scroll 0 0;
    border:none;
    border-radius: 50%;
    color: #fff;
    cursor: pointer;
    font-size: 15px;
    height: 33px;
    position: absolute;
    right: 0;
    top: 11px;
    width: 33px;
  }



  .msg_history {/*
    height: 420px;
    overflow-y: auto;*/
  }

   .msg_history1 {
    height: 420px;
    overflow-y: auto;
  }

  .ellipsis { text-overflow: ellipsis; }
</style>


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
		.neo-module-content{
			min-height: 400px;
		}
		.cus-detail tr>td:first-child{

		}
		.table-bordered > thead > tr > th{
			color: #333;
		}
		.cke_dialog{
			width: 400px !important;
		}
		.cke_dialog_contents{
			width: 100% !important;
		}
		.tokenfield{
			min-height: auto !important;
		}

		.modal-dialog.modal-custom.full{
			padding: 0 !important;
		}
	</style>
	<section class="content detail-ticket">
	<!-- Content -->
	<div class="row">
		<div class="col-md-12">
			<span class="fa-stack fa-lg fa-custome-size pull-left mt-4px">
				<i class="fa fa-circle fa-stack-2x text-info"></i>
				<i class="fa fa-ticket fa-stack-1x fa-inverse"></i>
			</span>
			<div class="col-lg-11 col-md-11 col-sm-11">
				<div class="breacrumb">
					<span>
						<a href="<?=str_replace('covaid/','index.php?menu=ticket_data',base_url())?>">Ticket</a>
					</span>
					<span>
						<a href=""><?=$data->ticket_code?></a>
					</span>
				</div>
				<h5 class="title"><?=$data->category?> - <?=$data->subject?></h5>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 pt-15 fs-2">
			<div class="row" style="display:flex;">
				<div class="col-md-8">
					<div class="row mb-3">
						<div class="col-md-12">
						<?php if($editable==1):?>
							<!--a href="<?=base_url('ticket/edit/'.$data->ticket_code)?>" class="btn btn-default btn-top"><i class="fa fa-pencil"></i> Edit</a-->
							
							<div class="btn-group btn-top" data-toggle="buttons">
								<button class="btn btn-default" onclick="show_assign()" <?=($data->status!='CLOSED'?'':'disabled')?>>Assign to</button>
								<button class="btn btn-warning" onclick="show_closed()" <?=($data->status!='CLOSED'?'':'disabled')?>>Closed</button>
							</div>
						<?php endif;?>
							<button class="btn btn-info" onclick="show_reopen()" <?=($data->status!='CLOSED'?'disabled':'')?>>Reopen</button>
						<?php if($editable==1):?>

<?php  if($user==801 || $user==800 || $user=='admin' || $user==816): ?>
		            
							<!--button class="btn btn-info" onclick="edit_ticket(<?=$data->id?>)">Edit Ticket</button-->
<?php  endif ?>
							<?php if($data->need_callback==1):?>
								<button class="btn btn-success" onclick="callback()" id="btn-callback" <?=($data->status!='CLOSED'?'':'disabled')?>><i class="fa fa-phone"></i> Callback</button>
							<?php endif;?>
						<?php endif;?>
						</div>
					</div>
					<div class="row mb-3" style="display: flex;">
						<div class="col-md-6">
							<table class="borderless table-detail cus-detail">
							<caption><strong>Customer Details</strong></caption>
							<tbody><tr><td class="text-muted">Nama:</td><td><?=$data->cus_name?></td></tr>
								<tr><td class="text-muted">Phone:</td><td id="phone"><?=$data->phone?></td></tr>
								<tr><td class="text-muted">Alamat:</td><td><?=$data->address?></td></tr>
								<tr>
									<td class="text-muted">Kecamatan:</td>
									<td><?=$data->district?></td>
								</tr>
								<tr>
									<td class="text-muted">Kota:</td>
									<td><?=$data->city?></td>
								</tr>
								<tr>
									<td class="text-muted">Propinsi:</td>
									<td><?=$data->province?></td>
								</tr>
								<tr>
									<td class="text-muted">Negara:</td>
									<td><?=$data->country_origin?></td>
								</tr>
							</tbody></table>
						</div>
						<div class="col-md-6">
							<table class="borderless table-detail side">
								<caption>Ticket Detail</caption>
								<tbody>
									<!--tr>
										<td class="text-muted">Main Category:</td>
										<td><?=$data->main_category?></td>
									</tr-->
									<tr>
										<td class="text-muted">Category:</td>
										<td><?=$data->category?></td>
									</tr>
									<tr>
										<td class="text-muted">Sub Category:</td>
										<td><?=$data->sub_category?></td>
									</tr>
									<tr>
										<td class="text-muted">Status:</td><td><span class="label label-<?=($data->status=='OPEN'?'info':($data->status=='CALLBACK'?'warning':'success'))?>"><?=strtoupper($data->status)?></span></td>
									</tr>
									<tr>
										<td class="text-muted">Source:</td><td><?=$data->source?></td>
									</tr>
								
							</tbody></table>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-12 desc">
							<p><strong style="font-size: 1.3em;">Content</strong></p>
							<div class="detail-content">
								<div class="editable">
									<div><?=$data->content?></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- right side -->
				<div class="col-md-4 pull-right" style="margin-top: 30px;">
					<div class="row mb-3">
					</div>
					<div class="row mb-4">
						<div class="col-md-12">
							<table class="borderless table-detail side">
								<caption>People</caption>
								<tbody>
									<tr>
										<td class="text-muted">Assign to:</td>
										<!--?php if(!empty($data->username)):?>
											<td><?=$data->username?></td-->
										<!--?php else:?-->
											<td><?=$data->department_name?></td>
										<!--?php endif;?-->
									</tr>
									<tr>
										<td class="text-muted">Open By:</td>
										<td><?=$data->open_by_name?></td>
									</tr>
									<?php if($data->reopen_by!=0){?>
										<tr>
											<td class="text-muted">Reopen By:</td>
											<td><?=$data->reopen_by_name?></td>
										</tr>
									<?php }?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<table class="borderless table-detail side">
								<caption>Date</caption>
								<tbody>
									<tr>
										<td class="text-muted">Created on:</td>
											<td><?=$data->open_date?></td>
									</tr>
									<tr>
										<td class="text-muted">Closed on:</td>
										<td><?=$data->closed_date=='0000-00-00 00:00:00'?'n/a':$data->closed_date?></td>
									</tr>
									<?php if($data->reopen_by!=0){?>
										<tr>
											<td class="text-muted">Reopen on:</td>
											<td><?=$data->reopen_date?></td>
										</tr>
									<?php }?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- bottom tab -->
			<div class="row">
				<div class="col-md-8 pt-30">
					<div class="tabset">
						<ul class="nav nav-pills" role="tablist">
						  <li <?=isset($reply)?'':'class="active"'?>><a href="#history" aria-controls="history" role="tab" data-toggle="tab">History</a></li>
						  
						</ul>

						<!-- Tab panes -->
						<div class="tab-content">
						  <div role="tabpanel" class="tab-pane <?=isset($reply)?'':'active'?>" id="history">
							  	<div class="col-md-12 table-responsive" style="padding:0">
							  		<table class="table table-striped table-colored" id="tb-history" width="100%">
							  			<!--thead>
							  				<tr>
							  					<th>User / Department</th>
							  					<th>Time</th>
							  					<th>Activity</th>
							  				</tr>
							  			</thead-->
							  			<tbody>
							  				<?php foreach ($history as $key => $value):?>
							  				<tr>
							  					<td>
							  						<div><strong><?=$value->username?></strong></div>
							  						<div><p><?=date('F d, Y H:i', strtotime($value->time))?></p></div>
							  						<div><small><?=nl2br($value->activity)?></small></div>
							  						<div><!--button type="button" title="reply comment" class="pull-right" onclick="reply_comment('<?=$value->history_id?>')"><i class="fa fa-comment-o"></i></button--></div>
							  					</td>
							  				</tr>
							  				<?php endforeach;?>
							  			</tbody>
							  		</table>
							  	</div>
							  	<div class="col-md-12 p-0">
							  		<button class="btn btn-default" onclick="reply_mail()" <?=($data->status!='CLOSED'?'':'disabled')?>><i class="fa fa-reply"></i> Reply Email</button>
							  		<button type="button" title="reply comment" class="btn btn-default" onclick="reply_comment(0)" <?=($data->status!='CLOSED'?'':'disabled')?>><i class="fa fa-comment-o"></i> Comment</button>
							  	</div>
						  </div>


						  <!--div role="tabpanel" class="tab-pane" id="comments">
                            <!--ul class="comments-list">
                            	<?php foreach ($comments as $key => $v):?>
                            	<li>
                            		<p>
                            			<span><img src="<?=base_url($v['avatar'])?>" width="20" height="20"></span>
                            			<span><?=$v['username']?></span>
                            			<span>added a comment - <?=$v['create_time']?></span>
                            		</p>
                            		<div class="comment-content">
                            			<?=$v['comment_text']?>
                            		</div>
                            		<div class="col-md-12"><a class="pull-right link-reply" onclick="scm(true,<?=$v['comment_id']?>)"><i class="fa fa-reply"></i> Reply</a></div>
                            		<?php if(isset($v['child']) & count($v['child'])>0):?>
                            		<ul class="comments-list child">
                            		<?php foreach ($v['child'] as $c):?>
                            			<li>
                            				<p>
		                            			<span><img src="<?=base_url($c['cavatar'])?>" width="20" height="20"></span>
		                            			<span><?=$c['child_name']?></span>
		                            			<span>added a comment - <?=$c['child_time']?></span>
		                            		</p>
		                            		<div class="comment-content"><?=$c['child_text']?></div>
                            			</li>
                            		<?php endforeach;?>
                            		</ul>
                            		<?php endif;?>
                            	</li>
                            	<?php endforeach;?>
                            	
                            </ul->
                            <!->
                            <button class="btn btn-default btn-round mt-3" onclick="scm(false,0)" <?=($data->status!='CLOSED'?'':'disabled')?>><i class="fa fa-comment-o"></i> Comment</button>
						  </div-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<!-- modal assign -->
<div class="modal fade" id="modal-assign">
  <div class="modal-dialog modal-custom full">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Assignment</h4>
      </div>
        <form role="form" id="assign-form">
          <div class="modal-body">
          <div class="row">
            <div class="col-md-3 pl-20">
            	<input type="hidden" name="user_id" value="<?=$user?>">
              <input type="hidden" name="tick_ids" value="<?=$data->id?>">
              <div class="form-group">
                <label for="assign_to">Assign to</label>
                <select class="form-control input-sm" name="assign_to" id="assign_to" style="height: 34px !important;width: 100% !important;">
                  <option value="" data-email="" selected> -- Select Department -- </option>
                  <?php 
                  $listemail = array();;
                  	foreach ($assignment as $key => $assign) {
                  		echo '<option value="'.$assign['id'].'" data-email="'.trim($assign['email']).'">'.$assign['text'].'</option>';
                  		$listemail[] = trim($assign['email']);
                  	}
                  ?>
                </select>
                <span class="info"></span>
              <input type="hidden" name="level">
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
          <div class="row">
        	<div class="col-md-11 px-20" style="width: 96%; margin-left: -8px;">
        		<div class="form-group">
        			<div id="assign-dropzone" class="dz-wrapper dz-multiple dz-clickable dropzone">
						<div class="dz-message">
							<div class="dz-text">Click or drag files here to attach</div><!---->
						</div>
					</div>
					<input type="hidden" name="attachments" id="assign-attach">
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
  <div class="modal-dialog modal-custom full">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal-status-title">Close Ticket</h4>
      </div>
      <form role="form" id="status-form">
          <div class="modal-body">
          	<input type="hidden" name="user_id" value="<?=$user?>">
          	<input type="hidden" name="tick_ids" value="<?=$data->id?>">
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

<!-- modal status -->
<div class="modal fade" id="modal-reopen" tabindex="-1" data-backdrop="false">
  <div class="modal-dialog modal-custom full">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal-status-title">Reopen Ticket</h4>
      </div>
      <form role="form" id="reopen-form">
          <div class="modal-body">
          	<input type="hidden" name="user_id" value="<?=$user?>">
          	<input type="hidden" name="tick_ids" value="<?=$data->id?>">
          <div class="row">
            <div class="col-md-11 px-20" style="width: 96%;">
              <div class="form-group">
                <label for="comment">Note</label>
                <textarea class="form-control" id="reopen-note"></textarea>
            	<input type="hidden" name="reopen_note">
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

<!-- modal status -->
<div class="modal fade" id="modal-comment">
  <div class="modal-dialog modal-custom full">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal-status-title">Reply Comment</h4>
      </div>
      <form role="form" id="comment-form">
          <div class="modal-body">
          	<input type="hidden" name="user_id" value="<?=$user?>">
          	<input type="hidden" name="tick_ids" value="<?=$data->id?>">
          	<input type="hidden" name="history_id" value="">
          <div class="row">
            <div class="col-md-11 px-20" style="width: 96%;">
              <div class="form-group">
                <label for="comment">Comment</label>
                <textarea class="form-control" id="comment-note"></textarea>
            	<input type="hidden" name="comment_note">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- modal status -->
<div class="modal fade" id="modal-reply">
  <div class="modal-dialog modal-custom full">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal-status-title">Reply Email</h4>
      </div>
      <form role="form" id="reply-form">
          <div class="modal-body">
          	<input type="hidden" name="user_id" value="<?=$user?>">
          	<input type="hidden" name="tick_ids" value="<?=$data->id?>">
          <div class="row" style="padding: 5px 0;">
            <div class="col-md-11 px-20" style="width: 96%;">
              <div class="form-group">
                <label for="comment" class="col-md-1 col-sm-1 p-0" style="width: 45px;margin-top:5px;">To</label>
                <div class="col-md-4 col-sm-4">
	                <input type="text" class="form-control select-tag2 input-xs tokenfield" multiple="multiple" name="to" value="<?=isset($assign_dept)?$assign_dept->department_email:''?>">
	            </div>
              </div>
            </div>
          </div>
          <div class="row" style="padding: 5px 0;">
            <div class="col-md-11 px-20" style="width: 96%;">
              <div class="form-group">
                <label for="comment" class="col-md-1 col-sm-1 p-0" style="width: 45px;margin-top:5px;">Cc</label>
                <div class="col-md-7 col-sm-7">
	                <input type="text" class="form-control select-tag2 input-xs tokenfield" multiple="multiple" name="cc">
	            </div>
              </div>
            </div>
          </div>
          <div class="row" style="padding: 5px 0;">
            <div class="col-md-11 px-20" style="width: 96%;">
              <div class="form-group">
                <label for="comment" class="col-md-1 col-sm-1 p-0" style="width: 45px;margin-top:5px;">Bcc</label>
                <div class="col-md-7 col-sm-7">
	                <input type="text" class="form-control select-tag2 input-xs tokenfield" multiple="multiple" name="bcc">
	            </div>
              </div>
            </div>
          </div>
          <div class="row" style="padding: 5px 0;">
            <div class="col-md-11 px-20" style="width: 96%;">
              <div class="form-group">
                <label for="comment" class="col-md-2 col-sm-2 p-0" style="width: 45px;margin-top:5px;">Subject</label>
                <div class="col-md-9 col-sm-9">
	                <input type="text" class="form-control select-tag2 input-xs" name="subject" value="Re: Ticket ID <?=$data->ticket_code?> membutuhkan respon anda segera.">
	            </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-11 px-20" style="width: 96%;">
              <div class="form-group">
                <label for="comment">Message</label>
                <textarea class="form-control" id="reply-note"></textarea>
            	<input type="hidden" name="reply_note">
              </div>
            </div>
          </div>
          <div class="row">
        	<div class="col-md-11 px-20" style="width: 96%; margin-left: -8px;">
        		<div class="form-group">
        			<div id="main-dropzone" class="dz-wrapper dz-multiple dz-clickable dropzone">
						<div class="dz-message">
							<div class="dz-text">Click or drag files here to attach</div><!---->
						</div>
					</div>
					<input type="hidden" name="attachments" id="main-attach">
        		</div>
        	</div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="pull-left">
        	<label class="checkbox">
        		<input type="checkbox" name="send_history"> Send Include Ticket History
        	</label>		
          </div>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Send</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- modal status -->
<div class="modal fade" id="modal-customer-reply">
  <div class="modal-dialog modal-custom full">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal-status-title">Reply to Customer</h4>
      </div>
      <form role="form" id="reply-customer-form">
          <div class="modal-body">
          	<input type="hidden" name="user_id" value="<?=$user?>">
          	<input type="hidden" name="tick_ids" value="<?=$data->id?>">
          <div class="row" style="padding: 5px 0;">
            <div class="col-md-11 px-20" style="width: 96%;">
              <div class="form-group">
                <label for="comment" class="col-md-1 col-sm-1 p-0" style="width: 45px;margin-top:5px;">To</label>
                <div class="col-md-4 col-sm-4">
	                <input type="text" class="form-control select-tag2 input-xs tokenfield" multiple="multiple" name="to" value="<?=$data->email?>">
	            </div>
              </div>
            </div>
          </div>
          <div class="row" style="padding: 5px 0;">
            <div class="col-md-11 px-20" style="width: 96%;">
              <div class="form-group">
                <label for="comment" class="col-md-1 col-sm-1 p-0" style="width: 45px;margin-top:5px;">Cc</label>
                <div class="col-md-7 col-sm-7">
	                <input type="text" class="form-control select-tag2 input-xs tokenfield" multiple="multiple" name="cc">
	            </div>
              </div>
            </div>
          </div>
          <div class="row" style="padding: 5px 0;">
            <div class="col-md-11 px-20" style="width: 96%;">
              <div class="form-group">
                <label for="comment" class="col-md-1 col-sm-1 p-0" style="width: 45px;margin-top:5px;">Bcc</label>
                <div class="col-md-7 col-sm-7">
	                <input type="text" class="form-control select-tag2 input-xs tokenfield" multiple="multiple" name="bcc">
	            </div>
              </div>
            </div>
          </div>
          <div class="row" style="padding: 5px 0;">
            <div class="col-md-11 px-20" style="width: 96%;">
              <div class="form-group">
                <label for="comment" class="col-md-2 col-sm-2 p-0" style="width: 45px;margin-top:5px;">Subject</label>
                <div class="col-md-9 col-sm-9">
	                <input type="text" class="form-control select-tag2 input-xs" name="subject" value="Re: [Ticket ID: <?=$data->ticket_code?>]<?=$data->subject?>">
	            </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-11 px-20" style="width: 96%;">
              <div class="form-group">
                <label for="comment">Message</label>
                <textarea class="form-control" id="reply-customer-note"></textarea>
            	<input type="hidden" name="reply_customer_note">
              </div>
            </div>
          </div>
          <div class="row">
        	<div class="col-md-11 px-20" style="width: 96%; margin-left: -8px;">
        		<div class="form-group">
        			<div id="cus-dropzone" class="dz-wrapper dz-multiple dz-clickable dropzone">
						<div class="dz-message">
							<div class="dz-text">Click or drag files here to attach</div><!---->
						</div>
					</div>
					<input type="hidden" name="attachments" id="cus-attach">
        		</div>
        	</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Send</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<!-- modal edit ticket -->


<!-- modal status -->
<div class="modal fade" id="modal-edit-ticket">
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
						<div class="col-md-3 col-sm-4">
							<input type="text" name="ticket_id" class="form-control input-sm" id="ticket"  readonly style="height:32px !important;">
							<input type="hidden" name="user_id" value="<?=$user?>">
							<span class="info"></span>
						</div>

						<label for="comment" class="col-md-2 col-sm-2">Brand <span class="required">*</span></label>
						<div class="col-md-3 col-sm-4">
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
						<div class="col-md-3 col-sm-4">
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
						<div class="col-md-3 col-sm-4">
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
					<div class="col-md-3 col-sm-4">
						<select id="category" class="form-control" name="category" style="height:32px !important;">
							<option value=""> --Ticket Category-- </option>
						</select>
						<span class="info"></span>
					</div>

					<label for="comment" class="col-md-2 col-sm-2">Sub Category <span class="required">*</span></label>
					<div class="col-md-3 col-sm-4">
						<select id="sub_category" class="form-control" name="sub_category" style="height:32px !important;">
							<option value=""> --Sub Category-- </option>
						</select>
						<span class="info"></span>
					</div>
					</div>
				</div> 

				<div class="form-group row" style="margin-bottom: 15px;">
					<div class="col-md-12 col-sm-9 p-0">
					<label for="comment" class="col-md-2 col-sm-2">Source <span class="required">*</span></label>
					<div class="col-md-3 col-sm-4">
						<select id="source" class="form-control" name="source" style="height:32px !important;">
							<option value=""> --Source-- </option>
						</select>
						<span class="info"></span>
					</div>
				</div> 
<?php endif ?>

<!-- nespresso  -->
<?php if($type=='nespresso'):?>
				<div class="form-group row">
					<div class="col-md-12 col-sm-9 p-0">
						<label class="col-md-2 col-sm-2 mt-5" for="ticket_id">Ticket ID</label>
						<div class="col-md-3 col-sm-4">
							<input type="text" name="ticket_id" class="form-control input-sm" id="ticket"  readonly style="height:32px !important;">
							<input type="hidden" name="user_id" value="<?=$user?>">
							<span class="info"></span>
						</div>

						<label for="comment" class="col-md-2 col-sm-2">Call Type <span class="required">*</span></label>
						<div class="col-md-3 col-sm-4">
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
						<div class="col-md-3 col-sm-4">
							<select id="meta_category" class="form-control" name="meta_category" style="height:32px !important;">
								<option value=""> --Meta Category-- </option>
							</select>
							<span class="info"></span>
						</div>

						<label for="comment" class="col-md-2 col-sm-2">Category <span class="required">*</span></label>
					<div class="col-md-3 col-sm-4">
						<select id="category" class="form-control" name="category" style="height:32px !important;">
							<option value=""> --Ticket Category-- </option>
						</select>
						<span class="info"></span>
					</div>


					</div>
				</div> 

				<div class="form-group row">
					<label for="comment" class="col-md-2 col-sm-2">Sub Category <span class="required">*</span></label>
					<div class="col-md-3 col-sm-4">
						<select id="sub_category" class="form-control" name="sub_category" style="height:32px !important;">
							<option value=""> --Sub Category-- </option>
						</select>
						<span class="info"></span>
					</div>
				</div>

				<div class="form-group row" style="margin-bottom: 15px;">
					<div class="col-md-12 col-sm-9 p-0">
					<label for="comment" class="col-md-2 col-sm-2">Source <span class="required">*</span></label>
					<div class="col-md-3 col-sm-4">
						<select id="source" class="form-control" name="source" style="height:32px !important;">
							<option value=""> --Source-- </option>
						</select>
						<span class="info"></span>
					</div>
				</div> 
				
<?php endif ?>

				<div class="form-group row" id="ccbcc">
					<label class="col-md-2 col-sm-2 mt-5" for="status">Content</label>
					<div class="col-md-8 col-sm-10 p-0">
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



<link rel="stylesheet" href="<?=base_url()?>assets/dist/css/dropzone.min.css"/>
<script src="<?=base_url()?>assets/dist/js/dropzone.min.js"></script>
<script src="<?=base_url()?>assets/plugins/ckeditor/ckeditor.js"></script>
<script src="<?=base_url()?>assets/plugins/sliptree/bootstrap-tokenfield.min.js"></script>
	<script type="text/javascript">
		function show_closed(){
			$('#modal-status').modal('show');
		}
		function show_reopen(){
			$('#modal-reopen').modal('show');
		}
		function show_assign(){
			$('#modal-assign').modal('show');
		}
		function reply_comment(id){
			$('[name="history_id"]').val(id);
			$('#modal-comment').modal('show');
		}
		function reply_mail(id){
			$('#modal-reply').modal('show');
		}
		function reply_customer_mail(id){
			$('#modal-customer-reply').modal('show');
		}

		function callback(){
			$('#btn-callback').prop('disabled', true);
		    $('#btn-callback').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Callback');
			$.ajax({
			      url: '<?=base_url('api/ticket/callback/3ec8112b9e277cf4d24c85136fc9ee95')?>',
			      type: 'post',
			      dataType: 'json',
			      data: {'dn':$('td#phone').text(), 'ext':'<?=$user?>', 'ticket_id':'<?=$data->id?>'}
			    }).done(function(res){
			      if(res.status){
		      		$('#btn-callback').html('<i class="fa fa-phone"></i> Callback');
			      }else{
			        $('#btn-callback').prop('disabled', false);
		      		$('#btn-callback').html('<i class="fa fa-phone"></i> Callback');
			        $().toastmessage('showToast', {
	                  text     : res.msg,
	                  position : 'top-center',
	                  type     : 'error',
	                });
			      }
			      console.log(res)
			    }).fail(function(xhr, status, error){
			      alert('Something goes wrong, please call your aplication vendor');
			      console.log(xhr);
			      console.log(status);
			      console.log(error);
			    });
		}
		$(function(){
			<?php if($editable==1):?>
			$('.tokenfield').tokenfield({
				autocomplete: {
				    source: ['<?=implode("','", $listemail)?>'],
				    delay: 100
				  },
  				showAutocompleteOnFocus: true
			});
		<?php endif;?>
		  	$('#assign_to').change(function(){
		  		var email = $(this).find('option:selected').data('email');
		  		if(email!=''){
		  			$('[name="email_assign"]').prop('readonly', true);
		  		}else{
		  			$('[name="email_assign"]').prop('readonly', false);
		  		}
		  		$('[name="email_assign"]').val(email);
		  	});

			$('.modal').on('show.bs.modal', function (e) {
			  	$('.modal').css('top', window.pageYOffset);
			  	//$('.toast-container');
			});

			var toolbars = [{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Font','FontSize','Bold', 'Italic','Underline'] }, { name: 'colors', items: [ 'TextColor', 'BGColor' ] },{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'] },{ name: 'links', items: [ 'Link', 'Unlink' ] }];
		    //CKEDITOR.replace('comment-note', {height:130,toolbar: toolbars});
		    CKEDITOR.replace('assign-note',{height:250,toolbar:toolbars,removePlugins: 'elementspath',resize_enabled: true});
		    CKEDITOR.replace('status-note',{height:250,toolbar:toolbars,removePlugins: 'elementspath',resize_enabled: true});
		    CKEDITOR.replace('reopen-note',{height:250,toolbar:toolbars,removePlugins: 'elementspath',resize_enabled: true});
		    CKEDITOR.replace('comment-note',{height:250,toolbar:toolbars,removePlugins: 'elementspath',resize_enabled: true});
		    CKEDITOR.replace('reply-note', {height:250,toolbar: toolbars,removePlugins: 'elementspath',resize_enabled: true});
		    CKEDITOR.replace('reply-customer-note', {height:250,toolbar: toolbars,removePlugins: 'elementspath',resize_enabled: true});
			//alert('hello');

			var mainattach = [];
			var assignattach = [];
			var cusattach = [];
			//var stop_attachments = [];
			Dropzone.autoDiscover = false;
			var myDropzone = new Dropzone("div#assign-dropzone", { url: "<?=base_url('media/attach')?>",
				addRemoveLinks: true,
				params:{'type':'reply_mailcust'}
			}).on('success', function(data, r){
				var json = JSON.parse(r);
				data.previewElement.id = json.id;
				assignattach.push(json.id);
				$('#assign-attach').val(assignattach.join(','));
			}).on('removedfile',function(data){
				var idremove = data.previewElement.id;
				$.post('<?=base_url('media/delete')?>', {'id':idremove})
				.done(function(done){
					var res = JSON.parse(done);
					if(res.status){assignattach.splice(assignattach.indexOf(idremove), 1);}
					$('#assign-attach').val(assignattach.join(','));
				})
				.fail(function(xhr, status, error){
					alert('Something goes wrong');
					console.log(xhr);
				})
			});
			Dropzone.autoDiscover = false;
			var myDropzone = new Dropzone("div#main-dropzone", { url: "<?=base_url('media/attach')?>",
				addRemoveLinks: true,
				params:{'type':'reply_mailcust'}
			}).on('success', function(data, r){
				var json = JSON.parse(r);
				data.previewElement.id = json.id;
				mainattach.push(json.id);
				$('#main-attach').val(mainattach.join(','));
			}).on('removedfile',function(data){
				var idremove = data.previewElement.id;
				$.post('<?=base_url('media/delete')?>', {'id':idremove})
				.done(function(done){
					var res = JSON.parse(done);
					if(res.status){mainattach.splice(mainattach.indexOf(idremove), 1);}
					$('#main-attach').val(mainattach.join(','));
				})
				.fail(function(xhr, status, error){
					alert('Something goes wrong');
					console.log(xhr);
				})
			});
			Dropzone.autoDiscover = false;
			var myDropzone = new Dropzone("div#cus-dropzone", { url: "<?=base_url('media/attach')?>",
				addRemoveLinks: true,
				params:{'type':'reply_mailcust'}
			}).on('success', function(data, r){
				var json = JSON.parse(r);
				data.previewElement.id = json.id;
				cusattach.push(json.id);
				$('#cus-attach').val(cusattach.join(','));
			}).on('removedfile',function(data){
				var idremove = data.previewElement.id;
				$.post('<?=base_url('media/delete')?>', {'id':idremove})
				.done(function(done){
					var res = JSON.parse(done);
					if(res.status){cusattach.splice(cusattach.indexOf(idremove), 1);}
					$('#cus-attach').val(cusattach.join(','));
				})
				.fail(function(xhr, status, error){
					alert('Something goes wrong');
					console.log(xhr);
				})
			});

			$('#assign-form').on('submit', function(e){
			    e.preventDefault();
			    var asgnote = CKEDITOR.instances['assign-note'].getData();
			    $('[name="assign_note"]').val(asgnote);
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
			                    text     : 'Assign ticket failed',
			                    position : 'top-center',
			                    type     : 'error',
			                    
			                  });
			        }
			      }
			    }).fail(function(xhr, status, error){
			    	$.post('<?=base_url('logger/writexhrlog')?>', {'xhr':xhr, 'act':'save_assign', 'error':error, 'status':status});
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
			                    text     : 'Close ticket failed',
			                    position : 'top-center',
			                    type     : 'error',
			                    
			                  });
			        }
			      }
			    }).fail(function(xhr, status, error){
			    	$.post('<?=base_url('logger/writexhrlog')?>', {'xhr':xhr, 'act':'save_closed', 'error':error, 'status':status});
			      alert('Something goes wrong, please call your aplication vendor');
			      console.log(xhr);
			      console.log(status);
			      console.log(error);
			    });
			});

			$('#reopen-form').on('submit', function(e){
			    e.preventDefault();
			    var reopennote = CKEDITOR.instances['reopen-note'].getData();
			    $('[name="reopen_note"]').val(reopennote);
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

			$('#comment-form').on('submit', function(e){
			    e.preventDefault();
			    var asgnote = CKEDITOR.instances['comment-note'].getData();
			    $('[name="comment_note"]').val(asgnote);
			    var dt = $(this).serialize();
			    //alert(dt);
			    $.ajax({
			      url: '<?=base_url('api/ticket/save_comment')?>',
			      type: 'post',
			      dataType: 'json',
			      data: $(this).serialize()
			    }).done(function(res){
			      if(res.status){
			        /*$().toastmessage('showToast', {
			                  text     : 'Comment ticket success',
			                  position : 'top-center',
			                  type     : 'success',
			                  close    : function () {*/
			                    location.reload();
			                  /*}
			                });*/
			      }else{
			        if(res.code==200){
			          $.each(res.e, function(key,msg){
			            var info = $('[name="'+key+'"]').closest('.form-group').find('.info');
			                  info.html(msg);
			                });
			        }else{
			          $().toastmessage('showToast', {
			                    text     : 'Comment ticket failed',
			                    position : 'top-center',
			                    type     : 'error',
			                    
			                  });
			        }
			      }
			    }).fail(function(xhr, status, error){
			    	$.post('<?=base_url('logger/writexhrlog')?>', {'xhr':xhr, 'act':'save_comment', 'error':error, 'status':status});
			      alert('Something goes wrong, please call your aplication vendor');
			      console.log(xhr);
			      console.log(status);
			      console.log(error);
			    });
			});

			$('#reply-form').on('submit', function(e){
			    e.preventDefault();
			    var asgnote = CKEDITOR.instances['reply-note'].getData();
			    $('[name="reply_note"]').val(asgnote);
			    var dt = $(this).serialize();
			    //alert(dt);
			    $.ajax({
			      url: '<?=base_url('api/ticket/save_reply')?>',
			      type: 'post',
			      dataType: 'json',
			      data: $(this).serialize()
			    }).done(function(res){
			      if(res.status){
			        /*$().toastmessage('showToast', {
			                  text     : 'Comment ticket success',
			                  position : 'top-center',
			                  type     : 'success',
			                  close    : function () {*/
			                    location.reload();
			                  /*}
			                });*/
			      }else{
			        if(res.code==200){
			          $.each(res.e, function(key,msg){
			            var info = $('[name="'+key+'"]').closest('.form-group').find('.info');
			                  info.html(msg);
			                });
			        }else{
			          $().toastmessage('showToast', {
			                    text     : 'Comment ticket failed',
			                    position : 'top-center',
			                    type     : 'error',
			                    
			                  });
			        }
			      }
			    }).fail(function(xhr, status, error){
			    	$.post('<?=base_url('logger/writexhrlog')?>', {'xhr':xhr, 'act':'save_reply', 'error':error, 'status':status});
			      alert('Something goes wrong, please call your aplication vendor');
			      console.log(xhr);
			      console.log(status);
			      console.log(error);
			    });
			});

			$('#reply-customer-form').on('submit', function(e){
			    e.preventDefault();
			    var note = CKEDITOR.instances['reply-customer-note'].getData();
			    $('[name="reply_customer_note"]').val(note);
			    var dt = $(this).serialize();
			    //alert(dt);
			    $.ajax({
			      url: '<?=base_url('api/ticket/save_reply_customer')?>',
			      type: 'post',
			      dataType: 'json',
			      data: $(this).serialize()
			    }).done(function(res){
			      if(res.status){
			        /*$().toastmessage('showToast', {
			                  text     : 'Comment ticket success',
			                  position : 'top-center',
			                  type     : 'success',
			                  close    : function () {*/
			                    location.reload();
			                  /*}
			                });*/
			      }else{
			        if(res.code==200){
			          $.each(res.e, function(key,msg){
			            var info = $('[name="'+key+'"]').closest('.form-group').find('.info');
			                  info.html(msg);
			                });
			        }else{
			          $().toastmessage('showToast', {
			                    text     : 'Comment ticket failed',
			                    position : 'top-center',
			                    type     : 'error',
			                    
			                  });
			        }
			      }
			    }).fail(function(xhr, status, error){
			    	$.post('<?=base_url('logger/writexhrlog')?>', {'xhr':xhr, 'act':'send_reply_customer', 'error':error, 'status':status});
			      alert('Something goes wrong, please call your aplication vendor');
			      console.log(xhr);
			      console.log(status);
			      console.log(error);
			    });
			});
		})

/*thoriq*/
function edit_ticket(id){
			$(".info").html('');
			var data={
				'ticket_id': id,
			}
			
			$.ajax({
			      url: '<?=base_url('api/ticket/edit_ticket')?>',
			      type: 'POST',
			      dataType: 'json',
			      data: data,
			    }).done(function(v){

				$('#meta_category').html('');
				$('#category').html('');
				$('#sub_category').html('');

			   $("#brand option").filter(function() {
				    return this.text == v.brand; 
				}).attr('selected', true);
				

			   $("#main_category option").filter(function() {
				    return this.text == v.main_category; 
				}).attr('selected', true);

			   $.post('<?=base_url('api/ticket/get_source')?>/')
		  		.done(function(res){
		  			$html='';
		  			$status='';
		  			var data = JSON.parse(res);
		  			$html+='<option '+$status+' value="">--- Source ---</option>';
		  			$.each(data, function(i,d){
		  				$status='';
		  				if(v.source==d.source_name){
		  					$status='selected';
		  				}
		  				$html+='<option '+$status+' value="'+d.source_name+'">'+d.frontend_display+'</option>';
		  			})

		  			$('#source').html($html)
		  		})

		  		$.post('<?=base_url('api/ticket/get_meta_category')?>/',{'id':v.main_id})
		  		.done(function(res){
		  			$html='';
		  			$status='';
		  			var data = JSON.parse(res);
		  			$html+='<option '+$status+' value="">--- Meta Category ---</option>';
		  			$.each(data, function(i,d){
		  				$status='';
		  				if(v.meta_category==d.text){
		  					$status='selected';
		  				}
		  				$html+='<option '+$status+' value="'+d.id+'">'+d.text+'</option>';
		  			})

		  			$('#meta_category').html($html)
		  		})


		  		$.post('<?=base_url('api/ticket/get_category')?>/',{'id':v.meta_id})
		  		.done(function(res){
		  			$html='';
		  			$status='';
		  			var data = JSON.parse(res);
		  			$html+='<option '+$status+' value="">--- Category ---</option>';
		  			$.each(data, function(i,d){
		  				$status='';
		  				if(v.category==d.text){
		  					$status='selected';
		  				}
		  				$html+='<option '+$status+' value="'+d.id+'">'+d.text+'</option>';
		  			})
		  			$('#category').html($html)
		  		})


		  		$.post('<?=base_url('api/ticket/get_sub_category')?>/',{'id':v.cat_id})
		  		.done(function(res){
		  			$html='';
		  			$status='';
		  			var data = JSON.parse(res);
		  			$html+='<option '+$status+' value="">--- Sub Category ---</option>';
		  			$.each(data, function(i,d){
		  				$status='';
		  				if(v.sub_category==d.text){
		  					$status='selected';
		  				}
		  				$html+='<option '+$status+' value="'+d.id+'">'+d.text+'</option>';
		  			})
		  			$('#sub_category').html($html)
		  		})



				$('#content').val(v.content);
				$('#ticket').val(v.ticket_id);
				$('#modal-edit-ticket').modal('show');

			    }).fail(function(xhr, status, error){
			      alert('Something goes wrong, please call your aplication vendor');
			      console.log(xhr);
			      console.log(status);
			      console.log(error);
			    });
		}



			
			//thoriq 
			$('[name="main_category"]').change(function(){
		  		var id = $(this).val();
		  		$('[name="meta_category"]').html('<option value=""> --Meta Category-- </option>');
		  		$('[name="category"]').html('<option value=""> --Category-- </option>');
		  		$('[name="sub_category"]').html('<option value=""> --Sub Category-- </option>');
		  		$.post('<?=base_url('api/ticket/get_meta_category/')?>',{'id':id})
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
		  		$.post('<?=base_url('api/ticket/get_category')?>/',{'id':id})
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
		  		$.post('<?=base_url('api/ticket/get_sub_category')?>/',{'id':id})
		  		.done(function(res){
		  			var data = JSON.parse(res);
		  			$.each(data, function(i,v){
		  				$('[name="sub_category"]').append('<option value="'+v.id+'">'+v.text+'</option>');
		  			})
		  		})
		  	})


		  	function save(){
		  		var data=$('#ticket-form').serialize();
		  		var brand=$("#brand option:selected").text();
		  		var main_category=$("#main_category option:selected").text();
		  		var meta_category=$("#meta_category option:selected").text();
		  		var category=$("#category option:selected").text();
		  		var sub=$("#sub_category option:selected").text();
		  		var source=$("#source").val();

		  		$.ajax({
			      url: '<?=base_url('api/ticket/update_ticket')?>/',
			      type: 'POST',
			      dataType: 'json',
			      data: data+'&dbrand='+brand+'&dmain_category='+main_category+'&dmeta_category='+meta_category+'&dcategory='+category+'&dsub_category='+sub+'&source='+source,
			    }).done(function(res){
			      if(res.status){
			        $().toastmessage('showToast', {
			                  text     : 'Update ticket success',
			                  position : 'top-center',
			                  type     : 'success',
			                  close    : function () {

			                    $('#modal-edit-ticket').modal('hide');
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
			                    text     : 'Assign ticket failed',
			                    position : 'top-center',
			                    type     : 'error',
			                    
			                  });
			        }
			      }
			    }).fail(function(xhr, status, error){
			      alert('Something goes wrong, please call your aplication vendor');
			    });
		  	}
/*selesai*/
	</script>
        <!-- Bootstrap 3.3.6 -->
        <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
        <!-- iCheck 1.0.1 -->
        <script src="<?php echo base_url(); ?>assets/plugins/iCheck/icheck.min.js"></script>
        <!-- Select2 -->
        <script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
        <!-- Toast Message -->
		<script src="<?php echo base_url(); ?>assets/plugins/toastMessage/js/jquery.toastmessage.js"></script>
