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
						<input type="hidden" name="call_id" value="<?=$call_id?>">
						<input type="hidden" name="agent" value="<?=$agent?>">
						<div class="flex">
							<div class="col-md-6 col-sm-" style="border-radius: 5px;border: 1px solid #ccc;">
								<div class="form-group" style="margin-bottom: 5px;">
									<label class="col-md-12" style="font-size: 1.2em">Ticket Form</label>

								</div>
								<div class="form-group field-flex">
									<label class="col-md-3 col-sm-3 mt-5" for="name">Nama <span class="required">*</span></label>
									<div class="col-md-6 col-sm-6">
										<input type="text" name="cus_name" class="form-control" placeholder="Nama" id="name" value="<?=isset($data)?$data->cus_name:''?>">
										<span class="info"></span>
									</div>
								</div>
								<div class="form-group field-flex">
									<label class="col-md-3 col-sm-3 mt-5" for="phone">Phone</label>
									<div class="col-md-6 col-sm-6">
										<?php if(isset($phone) && ($call_id!=0)):?>
										<input type="text" name="cus_phone" class="form-control" id="phone" value="<?=isset($phone)?$phone:''?>" <?=!isset($phone)?'':'readonly'?>>
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
									<!--div class="col-md-5 col-sm-5 col-sm-5">
										<input type="text" name="email" class="form-control" placeholder="Email" id="email" value="<?=isset($email)?$email:''?>" <?=!isset($data)?'':'readonly'?>>
										<span class="info"></span>
									</div-->
								</div>

								<div class="form-group field-flex">
									<label class="col-md-3 col-sm-3 mt-5" for="alamat">Alamat</label>
									<div class="col-md-9 col-sm-9">
										<textarea class="form-control" name="address" id="address"><?=isset($data)?$data->address:''?></textarea>
										<span class="info"></span>
									</div>
								</div>


								<div class="form-group">
									<label class="col-md-3 col-sm-3 mt-5" for="province">Propinsi</label>
									<div class="col-md-6 col-sm-6">
										<select name="province" id="province" class="form-control select2">
											<option value=""> --Propinsi-- </option>
											<?php foreach ($province as $key => $value) {
												
												echo "<option value='".$value['id']."'>".$value['text']."</option>";
											}
											?>
										</select>
										<span class="info"></span>
									</div>

								</div>

								<div class="form-group">
									<label class="col-md-3 col-sm-3 mt-5" for="city">Kota</label>
									<div class="col-md-9 col-sm-9">
										<div class="col-md-5 col-sm-5 p-0">
										<select name="city" id="city" class="form-control select2">
											<option value=""> --Kota-- </option>
										</select>
										<span class="info"></span>
										</div>

										<label class="col-md-2 col-sm-2 mt-5" for="district">Kecamatan</label>
										<div class="col-md-5 col-sm-5">
											<select name="district" id="district" class="form-control">
												<option value=""> --Kecamatan-- </option>
											</select>
											<span class="info"></span>
										</div>
									</div>



								</div>
								
								<div class="form-group">
									<label class="col-md-3 col-sm-3 mt-5" for="ticket_id">Ticket ID</label>
									<div class="col-md-9 col-sm-9">
										<div class="col-md-5 col-sm-5 p-0" style="margin-right: 15px;">
										<input type="text" name="ticket_id" class="form-control" id="ticket" value="<?=isset($ticket_id)?$ticket_id:''?>" readonly>
										<span class="info"></span>
									</div>

									<label class="col-md-2 col-sm-2 mt-5 p-0" for="ticket_id">Source <span class="required">*</span></label>
										<div class="col-md-4 col-sm-4 p-0">
											<select name="source" class="form-control">
												<option value=""> --Ticket Source-- </option>
												<option value="Inbound Call">Inbound Call</option>
												<option value="Outbound Call">Outbound Call</option>
											</select>
											<span class="info"></span>
										</div>
									</div>



								</div>

								<div class="form-group">
									<label class="col-md-3 col-sm-3 mt-5" for="ticket_id">Kategori <span class="required">*</span></label>
									<div class="col-md-9 col-sm-9 p-0">
										<div class="col-md-5 col-sm-5">
											<select id = "category" name="category" class="form-control">
												<option value=""> --Kategori-- </option>
												<?php
													$opt = '';
													for ($i=0; $i < count($category); $i++) { 
														$opt .= '<option value="'.$category[$i]['id'].'">'.$category[$i]['text'].'</option>';
													}
													echo $opt;
												?>
												<!-- <option value="covid 19">covid 19</option>
												<option value="Tenaga Kerja">Tenaga Kerja</option>
												<option value="Transportasi">Transportasi</option>
												<option value="Sosial">Sosial</option>
												<option value="Bencana">Bencana</option>
												<option value="Ketertiban Umum">Ketertiban Umum</option>
												<option value="Kesehatan">Kesehatan</option>
												<option value="pendidikan">pendidikan</option>
												<option value="pajak">pajak</option>
												<option value="Ekonomi">Ekonomi</option> -->

											</select>
											<span class="info"></span>
										</div>
										<div class="col-md-7 col-sm-7">
											<select name="sub_category" class="form-control select2">
												<option value=""> --Sub Kategori-- </option>
												<!-- <option value="penanganan covid-19">penanganan covid-19</option>
												<option value="penanganan Pelaku perjalanan">penanganan Pelaku perjalanan</option>
												<option value="Sebaran covid-19 Tabanan">Sebaran covid-19 Tabanan</option>
												<option value="Penanganan Pekerja Migran Indonesia">Penanganan Pekerja Migran Indonesia</option>
												<option value="Info Orang Dalam Pengawasan">Info Orang Dalam Pengawasan</option>
												<option value="Info Pasien dalam Pegawasan">Info Pasien dalam Pegawasan</option>
												<option value="Protokol Isolasi mandiri">Protokol Isolasi mandiri</option>
												<option value="lain-lain">lain-lain</option>
												<option value="Kartu prakerja">Kartu prakerja</option>
												<option value="Tempat isolasi Mandiri PMI">Tempat isolasi Mandiri PMI</option>
												<option value="Data Pekerja Migran Indonesia">Data Pekerja Migran Indonesia</option>
												<option value="Pemutusan Hubungan Kerja">Pemutusan Hubungan Kerja</option>
												<option value="Penjemputan Pekerja Migran Indonesia">Penjemputan Pekerja Migran Indonesia</option>
												<option value="info tempat penjemputan Pekerja Migran">info tempat penjemputan Pekerja Migran</option>
												<option value="Bantuan Langsung Tunai">Bantuan Langsung Tunai</option>
												<option value="Pra-keluarga sejahtera">Pra-keluarga sejahtera</option>
												<option value="Pembagian sembako">Pembagian sembako</option>
												<option value="Laporan Penerima Bantuan">Laporan Penerima Bantuan</option>
												<option value="Banjir">Banjir</option>
												<option value="gempa">gempa</option>
												<option value="pohon tumbang">pohon tumbang</option>
												<option value="kecelakaan lalu lintas">kecelakaan lalu lintas</option>
												<option value="gelandangan">gelandangan</option>
												<option value="orang gila">orang gila</option>
												<option value="pelanggaran perda">pelanggaran perda</option>
												<option value="Demam berdarah">Demam berdarah</option>
												<option value="pengawasan survilence">pengawasan survilence</option>
												<option value="promosi kesehatan">promosi kesehatan</option>
												<option value="Puskesmas">Puskesmas</option>
												<option value="Penerimaan Siswa Baru">Penerimaan Siswa Baru</option>
												<option value="Pembayaran SPP">Pembayaran SPP</option>
												<option value="dana BOS">dana BOS</option>
												<option value="Data sekolah SD-SMP-SMA">Data sekolah SD-SMP-SMA</option>
												<option value="Pajak Bumi dan bangunan">Pajak Bumi dan bangunan</option>
												<option value="pajak Hotel dan restoran">pajak Hotel dan restoran</option>
												<option value="pajak BPHTB">pajak BPHTB</option>
												<option value="Penerimaan Siswa Baru">Penerimaan Siswa Baru</option>
												<option value="Pajak lainnya">Pajak lainnya</option>
												<option value="Harga Sembako">Harga Sembako</option>
												<option value="laporan kelangkaan Barang">laporan kelangkaan Barang</option>
												<option value="Kenaikan harga sembako">Kenaikan harga sembako</option>
												<option value="Info Pasar">Info Pasar</option>
												<option value="jam operational pasar">jam operational pasar</option>
												<option value="lokasi pasar tradisional dan moder">lokasi pasar tradisional dan moder</option> -->
											</select>
											<span class="info"></span>
										</div>
									</div>
								</div>


								<div class="form-group field-flex">
									<label class="col-md-3 col-sm-3 mt-5" for="subject">Subjek <span class="required">*</span></label>
									<div class="col-md-9 col-sm-9">
										<input type="text" name="subject" class="form-control" id="subject">
										<span class="info"></span>
									</div>
								</div>
								<div class="form-group field-flex">
									<label class="col-md-3 col-sm-3 mt-5" for="content">Isi Ticket <span class="required">*</span></label>
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
													foreach($departments as $assign){
														echo '<option value="'.$assign['id'].'" data-email="">'.$assign['text'].'</option>';
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
								<!--div class="form-group field-flex" id="panel-callback">
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
								</div-->
								<!--div class="form-group field-flex" id="panel-cc">
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
								</div-->

								<div class="form-group field-flex" style="padding-top: 15px;margin-bottom: 0;">
									<div class="col-md-5 col-sm-5 col-md-offset-3 col-sm-offset-3">
										<button type="reset" class="btn btn-default" style="margin-right: 15px">Reset</button>
										<button type="submit" class="btn btn-primary" id="btn-save">Save</button>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 flex flex-column p-0" style="max-height:700px;margin-left:10px;overflow-y:auto;">
								<div style="border-radius: 5px;border: 1px solid #ccc; margin-bottom: 10px">
									<div class="form-group" style="margin-bottom: 5px;">
										<label class="col-md-12" style="font-size: 1.2em">Call Information</label>
									</div>
									<div class="form-group cus-field-info">
										<label class="col-md-5 col-sm-5" for="callback"></label>

									</div>
								</div>

								<!--div style="border-radius: 5px;border: 1px solid #ccc; margin-bottom: 10px">
									<div class="form-group" style="margin-bottom: 5px;">
										<label class="col-md-12" style="font-size: 1.2em">Transaction Summary</label>
									</div>
									<div class="form-group cus-field-info">
										<label class="col-md-5 col-sm-5" for="callback">First Sale Date</label>
									</div>
								</div>

								<div style="border-radius: 5px;border: 1px solid #ccc; height: 223px;">
									<div class="form-group" style="margin-bottom: 5px;">
										<label class="col-md-12" style="font-size: 1.2em">Customer's Address</label>
									</div>
									<div class="form-group cus-field-info">
										<label class="col-md-5 col-sm-5" for="callback">Home Address</label>
									</div>
								</div-->

							</div>
						</div>
						<div class="flex">
							<div class="col-md-12 col-sm-12" style="border-radius: 5px;border: 1px solid #ccc; margin-top: 15px;padding-top: 5px;">
								<ul class="nav nav-pills spc">
								  <li class="active"><a data-toggle="tab" href="#ticket_history">Ticket History</a></li>
								</ul>
								<div class="tab-content">

									<div id="ticket_history" class="tab-pane fade in active">
										<div class="form-group" style="margin-top: 15px;margin-bottom: 5px;">
											<label class="col-md-5 col-sm-5 pull-left" style="font-size: 1.2em">Ticket History</label>
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

<div class="loading" style="display: flex; align-items: middle; justify-content: center; position: fixed; width: 100vw; height: 100vh; "><i class="fa fa-circle-o-notch fa5x"></i></div>
		<script type="text/javascript">
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

$('#province').change(function(){
	var province = $(this).val();
	$('#city').html('<option value=""> --Kota-- </option>');
	$('#district').html('<option value=""> --Kecamatan-- </option>');
	if(province!==null && province!==''){

		<?php if(isset($data)): ?>
		$.ajax({url:'<?=base_url('api/get_city')?>', data:{'province':province}, type:'post', dataType:'json'})
		.done(function(res){
			if(res.status){
				$.when($('select#city').select2({
				  placeholder: " --Kota-- ",
			      dropdownAutoWidth : false,
			      width: '100%',
			      data: res.data
			    })
			    ).then(
					<?php echo "$('#city').val('".$data->city."').trigger('change')"; ?>
				);
			}
		})
		
		<?php else:?>
			$.ajax({url:'<?=base_url('api/get_city')?>', data:{'province':province}, type:'post', dataType:'json'})
			.done(function(res){
				if(res.status){
					$('select#city').select2({
				      dropdownAutoWidth : false,
				      width: '100%',
				      data: res.data
				    });
				}
			})
		<?php endif;?>
	}
});
$('#city').change(function(){
	var city = $(this).val();
	$('#district').html('<option value=""> --Kecamatan-- </option>');
	if(city!==null && city!==''){
		<?php if(isset($data)): ?>
		$.ajax({url:'<?=base_url('api/get_district')?>', data:{'city':city}, type:'post', dataType:'json'})
		.done(function(res){
			if(res.status){
				$.when($('select#district').select2({
				  placeholder: " --Kecamatan-- ",
			      dropdownAutoWidth : false,
			      width: '100%',
			      data: res.data
			    })).then(
					<?php echo "$('#district').val('".$data->district."').trigger('change')"; ?>
				);
			}
		})
		<?php else:?>
		$.ajax({url:'<?=base_url('api/get_district')?>', data:{'city':city}, type:'post', dataType:'json'})
		.done(function(res){
			if(res.status){
				$('select#district').select2({
			      dropdownAutoWidth : false,
			      width: '100%',
			      data: res.data
			    });
			}
		})
		<?php endif;?>
	}
});
<?php
	if(isset($data)){
		echo "$('#province').val('".$data->province."').trigger('change')";
	}
?>



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
	    			//
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
		  	/*$('#assign_to').change(function(){
		  		var email = $(this).find('option:selected').data('email');
		  		if(email!=''){
		  			$('[name="email_assign"]').prop('readonly', true);
		  		}else{
		  			$('[name="email_assign"]').prop('readonly', false);
		  		}
		  		$('[name="email_assign"]').val(email);
		  	});*/
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
		                
		                reload_table_ticket();*/
		                $('#content').html('<div class="alert alert-success text-center" ><i>Save Ticket Success</i></div>');
		              }
		          },
		          error: function(jqXHR, textStatus, errorThrown){
		              alert('Error,something goes wrong');
		          },
		          complete: function(){
		          	$('#btn-save').prop('disabled', false);
		             $('#btn-save').html('Save');
		          }
		      });
		    });

		  	$('[name="category"]').change(function(){
		  		var id = $(this).val();
		  		$('[name="sub_category"]').html('<option value=""> --Sub Category-- </option>');
		  		$.post('<?php echo base_url('api/api/get_subcategory')?>',{'id':id})
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
