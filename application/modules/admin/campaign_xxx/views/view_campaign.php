<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$search_f = isset($this->session->userdata['asearch']['campaign_search'])?$this->session->userdata['asearch']['campaign_search']:'';
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Request Order
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url().'panel';?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Request Order</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">
              
            </h3>
         
       
          </div>
          <div class="box-body">
           


<form  enctype="multipart/form-data" id="uploadForm" autocomplete="off">
<div class="row">
<div class="col-md-12">

    <div class="col-md-2 col-sm-6 col-xs-12">
      <label>Divisi<span style="color: red"> *</span></label>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="form-group form-group-sm" id="div_kategori">
        <input type="hidden" name="unit_id" id="unit_id" class="form-control" readonly="">        
        <input type="text" name="vendor" id="unit" class="form-control" disabled="">        
      </div>
    </div>

                     
    <input type="hidden" name="m_id">
    <div class="col-md-2 col-sm-6 col-xs-12">
      <label>Tujuan Divisi<span style="color: red"> *</span></label>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="form-group form-group-sm" id="div_kategori">

<select onchange="kt()"  id="select_kontrak" name="kontrak" data-placeholder="pilih Kontrak..." class="chosen-select form-control" style="width:100%;" >

</select>



        
      </div>
    </div>

 
   


    <div class="col-md-2 col-sm-6 col-xs-12">
      <label>Tanggal<span style="color: red"> *</span></label>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="form-group form-group-sm" id="div_kategori">
        <input id="tgl" type="text" class="form-control reset" name="tanggal"  autocomplete="off">
      </div>
    </div>

     <div class="col-md-2 col-sm-6 col-xs-12">
      <label>Perihal<span style="color: red"> *</span></label>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="form-group form-group-sm" id="div_kategori">
        <input type="text" name="vendor" id="vendor" class="form-control" >        
      </div>
    </div>

 
    </div>
    </div>



<div class="row">
<div class="col-md-12">
<div class="table-responsive">
<table id="d" class="table cc table-striped table-bordered "
  style="width: 100%">
 <thead>
<th width="20%">Nama</th>
<th width="20%">Jumlah</th>
<th width="20%">-</th>
</thead>
<tbody>
<!-- <table class="table table-striped table-bordered " width="100%"> -->
<td width="20%"><input placeholder="Nama" id="dt_nama" style="width:100%" type="" name="dt_nama" class="form-control reset1"></td>
<td width="10%"><input placeholder="Jumlah" id="dt_jumlah" style="width:100%" type="number" name="dt_jumlah"class="form-control reset1" onchange="id_hitung_p()" onkeyup="id_hitung_p()" ></td>
<td width="5%">
<button class="btn btn-primary btn-sm" id="btn_click"  type="button"><i class="fa fa-plus-square"></i></button>
</td>
</tbody>
</table>
</div>
</div>
</div>





<div style="width:100%; padding-left:-10px">
<div class="table-responsive">
<table class="table"  id="table" cellspacing="0" width="100%">
<thead>
<th width="20%" data-header="nama">Nama</th>
<th width="7%">Jumlah</th>
<th width="7%">Satuan</th>
<th width="10%">-</th>
</thead>
<tbody>
  <td>Pensil</td>  
  <td>5 </td>
  <td>PCS </td>
  <td width="5%">
<button class="btn btn-danger btn-sm" id="btn_click"  type="button"><i class="fa fa-minus-square"></i></button>
</td>
<tr>
   <td>Buku</td>  
  <td>50 </td>
  <td>PCS </td>
  <td width="5%">
<button class="btn btn-danger btn-sm" id="btn_click"  type="button"><i class="fa fa-minus-square"></i></button>
</td>
</tr>
</tbody>
</table>
</div>
</div>
     
          
          <div class="row">
            <div class="col-sm-6"> 
                    <div class="widget-footer enter ">                      
                      <button class="btn btn-success upload-image" type="submit">Simpan</button>
                      <a href="{{route('index_inspeksi')}}" class="btn btn-default">Kembali</a>
                    </div>

          </div>
          </div>
</form>     

        </div>              


          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.js"></script>
