<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$search_f = isset($this->session->userdata['asearch']['campaign_search'])?$this->session->userdata['asearch']['campaign_search']:'';
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
     Input Nota
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url().'panel';?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Input Nota</li>
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
              <input value="IT" type="text" name="vendor" id="unit" class="form-control" disabled="">        
            </div>
          </div>                  
          <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Tujuan Divisi<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
                <select class="form-control" disabled="">
                    <?php foreach ($divisi as $key => $v): ?>
                      <option value="<?=$v->d_id ?>"> <?php 
                                                      $a=$v->desc==''?'':' - '.$v->desc;
                                                      echo $v->name.$a ?> 
                      </option>  
                    <?php endforeach ?>
                </select>
            </div>
          </div>
          <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Tanggal<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input id="tgl" type="text" class="form-control reset date" name="tanggal"  autocomplete="off">
            </div>
          </div>
          <div class="col-md-2 col-sm-6 col-xs-12">
              <label>Tipe<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
             <select class="form-control" id="barang_jasa" onchange="barang_jasa1()" disabled=""> 
                <option>Barang</option>
                <option>Jasa</option>
             </select>
            </div>
          </div>
          <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Perihal<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input type="text" value="peminjaman" name="vendor" id="vendor" class="form-control" disabled="">        
            </div>
          </div> 

          <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Anggaran<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input type="text" value="20.000" name="vendor" id="vendor" class="form-control" >        
            </div>
          </div> 

            <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Minus<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="input-group">
    <input id="email" type="text" value="200.000" class="form-control" name="email" placeholder="Email">
    <a class="input-group-addon"><i class="fa fa-credit-card"></i></a>
  </div>
          </div> 






        </div>
    </div>
<!-- <div class="row">
  <div class="col-md-12">
    <div class="table-responsive">
        <table id="d" class="table cc table-striped table-bordered " style="width: 100%">
            <thead>
              <th width="20%">Nama</th>
              <th width="20%">Jumlah</th>
              <th width="20%">Satuan</th>
              <th width="20%">Note</th>
              <th width="20%">-</th>
            </thead>
            <tbody>
              <td width="20%">
                <select class="form-control" id="jenis_barang" >
                  <option value=""> ---Barang---</option>
                  <?php foreach ($item['barang'] as $key => $v): ?>
                    <option data-pcs="<?=$v->pcs ?>" data-name="<?=$v->name ?>" value="<?=$v->i_id ?>"> <?=$v->name ?> </option>  
                  <?php endforeach ?>    
                </select>
                <select class="form-control" id="jenis_jasa" >
                  <option> ---Barang---</option>
                  <?php foreach ($item['jasa'] as $key => $v): ?>
                    <option data-pcs="<?=$v->pcs ?>" data-name="<?=$v->name ?>" value="<?=$v->i_id ?>"> <?=$v->name ?> </option>  
                  <?php endforeach ?>    
                </select>
                 <input placeholder="Jumlah" id="dt_name" style="width:100%;display: none;" type="text" class="form-control reset1" >
                  <input placeholder="Jumlah" id="dt_id" style="width:100%;display: none;" type="number" class="form-control reset1" >
              </td>
              <td width="10%">
                  <input placeholder="Jumlah" id="dt_jumlah" style="width:100%" type="number" class="form-control reset1" >
              </td>
              <td width="10%">
                  <input placeholder="Satuan" id="dt_satuan" style="width:100%" type="text" class="form-control reset1" readonly="">
              </td>
              <td width="10%">
                  <input placeholder="Catatan" id="dt_note" style="width:100%" type="text" class="form-control reset1" >
              </td>
              <td width="5%">
                  <button class="btn btn-primary btn-sm" onclick="tambah()" id="btn_click"  type="button"><i class="fa fa-plus-square" ></i></button>
              </td>
            </tbody>
        </table>
        </div>
    </div>
</div> -->

<div style="width:100%; padding-left:-10px">
<div class="table-responsive">
<table class="table"  id="table" cellspacing="0" width="100%">
<thead>
<th width="20%" data-header="nama">Nama</th>
<th width="7%">Qty</th>
<th width="7%">Qty Approve</th>
<th width="7%">Satuan</th>
<th>Merk</th>
<th width="30%">Note</th>
<th width="5%">-</th>
</thead>
<tbody id="detail_item">
  <tbody id="detail_item">





<tr class="item-0">
  <td><input type="" style="display: none;" name="id[]" value="4" class="form-control id-0"><input type="" name="   barang[]" value="e-10 - tisu / mil" class="form-control barang-0" readonly="">
  </td>
  <td>
    <input type="" name="jumlah[]" value="10" class="form-control jumlah-0" readonly="">
  </td>

  <td>
    <input type="" name="jumlah_apr[]" value="10" class="form-control jumlah-0">
  </td>
  <td>
    <input type="" name="pcs[]" value="mil" class="form-control" pcs-0="" readonly="">
  </td>
  <td>
    <input type="" name="note[]" value="-" class="form-control" note-0="" >
  </td>

  <td>
    <input type="" name="note[]" value="-" class="form-control" note-0="" readonly="">
  </td>
  <td width="10%">
      <button class="btn btn-primary btn-sm" onclick="tambah()" id="btn_click"  type="button"><i class="fa fa-plus-square" ></i></button>
  </td>
</tr>



<tr class="item-0">
  <td><input type="" style="display: none;" name="id[]" value="4" class="form-control id-0"><input type="" name="   barang[]" value="e-10 - tisu / mil" class="form-control barang-0" readonly="">
  </td>
  <td>
    <input type="" name="jumlah[]" value="10" class="form-control jumlah-0" readonly="">
  </td>

  <td>
    <input type="" name="jumlah_apr[]" value="10" class="form-control jumlah-0">
  </td>
  <td>
    <input type="" name="pcs[]" value="mil" class="form-control" pcs-0="" readonly="">
  </td>
  <td>
    <input type="" name="merek[]" value="-" class="form-control" note-0="" >
  </td>

  <td>
    <input type="" name="note[]" value="-" class="form-control" note-0="" readonly="">
  </td>
  <td width="10%">
     <button class="btn btn-primary btn-sm" onclick="tambah()" id="btn_click"  type="button"><i class="fa fa-plus-square" ></i></button>
  </td>
</tr>

</tbody>
</table>


<br> 

</div>
</div>
     
          
          <div class="row">
            <div class="col-sm-6"> 
                    <div class="widget-footer enter ">                      
                      <button class="btn btn-success upload-image" type="submit">Simpan</button>
                      <button class="btn btn-primary upload-image" type="submit">Simpan & Cetak</button>
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
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
  barang_jasa1();
  function barang_jasa1(){   
    if($('#barang_jasa').val()=='Barang'){
      $('#jenis_barang').css('display','')
      $('#jenis_jasa').css('display','none')
    }   
    else if($('#barang_jasa').val()=='Jasa'){      
      $('#jenis_barang').css('display','none')
      $('#jenis_jasa').css('display','')
      
    }

  }
   var ii=0;

 /*  function setBarang(){
    alert($('#barang_jasa').data('pcs'))
   }*/

$('#jenis_barang').on("change", function() {

  var id=$('option:selected',this).val();
  var name=$('option:selected',this).data('name');
  var pcs=$('option:selected',this).data('pcs');
  $('#dt_name').val(name);
  $('#dt_id').val(id);
  $('#dt_satuan').val(pcs);
})

$('#jenis_jasa').on("change", function() {
  var id=$('option:selected',this).val();
  var name=$('option:selected',this).data('name');
  var pcs=$('option:selected',this).data('pcs');
  $('#dt_name').val(name);
  $('#dt_id').val(id);
  $('#dt_satuan').val(pcs);
})


  /*$('select').change(function(){
    alert($(this).data('id'));
});*/

  $('.date').datepicker({autoclose:true,format: 'dd-mm-yyyy'});
 
  function tambah(){
    
    var id=$('#dt_id').val();
    var name=$('#dt_name').val();
    var jml=$('#dt_jumlah').val();
    var note=$('#dt_note').val();
    var pcs=$('#dt_satuan').val();
    var html='<tr class="item-'+ii+'">'+
                  '<td>'+
                        '<input type="" style="display: none;" name="id[]" value="'+id+'" class="form-control id-'+ii+'">'+
                        '<input type="" name="barang[]" value="'+name+'" class="form-control barang-'+ii+'" readonly="" >'+
                  '</td>'+
                        '<td><input type="" name="jumlah[]" value="'+jml+'" class="form-control jumlah-'+ii+'" ></td>'+
                        '<td><input type="" name="pcs[]" value="'+pcs+'" class="form-control" pcs-'+ii+' readonly="" ></td>'+
                        '<td><input type="" name="note[]" value="'+note+'"  class="form-control" note-'+ii+'></td>'+
                        '<td width="5%">'+
                        '<button class="btn btn-danger btn-sm" onclick=hapus('+ii+') id="btn_click"  type="button"><i class="fa fa-minus-square "></i></button>'+
                  '</td>'+
              '</tr>';
    $('#detail_item').append(html)
    ii++;
  }
  function hapus(a){
    $('.item-'+a).remove();
  }
</script>