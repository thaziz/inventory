<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$search_f = isset($this->session->userdata['asearch']['campaign_search'])?$this->session->userdata['asearch']['campaign_search']:'';
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Insert Permintaan
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url().'panel';?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Insert Permintaan</li>
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
           


  <form class="form-horizontal" method="post" id="admin_form">
    <div class="row">
        <div class="col-md-12">
                 <input autocomplete="off"  type="hidden" name="from" id="from" class="form-control" readonly="" value="<?=$this->session->userdata('bidang_id')?>">                      
          <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Tujuan Divisi<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
                <select class="form-control" name="to">
                    <?php foreach ($divisi as $key => $v): ?>
                      <?php if ($v->d_id==1): ?>
                      <option  value="<?=$v->d_id ?>"> <?php 
                                                      $a=$v->desc==''?'':' - '.$v->desc;
                                                      echo $v->name.$a ?> 
                      </option>  
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
            </div>
          </div>
           <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Kode<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm input-group" id="div_kategori">
              <input autocomplete="off"  id="kode" type="text" value="<?=$kode ?>" class="form-control reset " name="no"  autocomplete="off" readonly>
              <div class="input-group-btn">
                <button class="btn btn-default btn-sm" type="button" onclick="refresh_kode()">
                  <i class="fa fa-refresh"></i>
                </button>
              </div>
              <span class="info"></span>
            </div>
          </div>
          <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Tanggal Digunakan<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input autocomplete="off"  id="tgl" value="<?=date('d-m-Y') ?>" type="text" class="form-control reset date" name="tanggal"  autocomplete="off">
            </div>
          </div>
         
          <div class="col-md-2 col-sm-6 col-xs-12">
              <label>Kategori<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
             <select class="form-control" id="barang_jasa" name="type">                
                <?php foreach ($kategori  as $key => $v): ?>
                  <option value="<?=$v->id?>"><?=$v->name ?></option>
                <?php endforeach ?>

             </select>
             <span class="info"></span>
            </div>
          </div>
          <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Perihal<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input autocomplete="off"  type="text" name="perihal" id="perihal" class="form-control" placeholder="Perihal">        
              <span class="info"></span>
            </div>
          </div> 
        </div>
    </div>
<div class="row">
  <div class="col-md-12">
    <div class="table-responsive">
            <input type="hidden" class="form-control" name="detail" width="100%">      
              *<span class="info"></span>
        <table id="d" class="table cc table-striped table-bordered " style="width: 100%">
            <thead>
              <th width="30%">Nama</th>
              <th width="10%">Jumlah</th>
              <th width="40%">Note</th>
              <th width="5%">-</th>
            </thead>
            <tbody>
              <td width="20%">
                <select class="form-control select2" id="jenis_barang" >
                  <option value=""> ---Barang---</option>
                  <?php foreach ($item as $key => $v): ?>
                    <option data-pcs="<?=$v->pcs ?>" data-name="<?=$v->name ?>" value="<?=$v->i_id ?>"> <?=$v->name ?> </option>  
                  <?php endforeach ?>    
                </select>
                 <input autocomplete="off"  placeholder="Jumlah" id="dt_name" style="width:100%;display: none;" type="text" class="form-control reset1" >
                  <input autocomplete="off"  placeholder="Jumlah" id="dt_id" style="width:100%;display: none;" type="number" class="form-control reset1" >
              </td>
              <td width="10%">
                  <input autocomplete="off"  placeholder="Jumlah" id="dt_jumlah" style="width:100%" type="number" class="form-control reset1" >
              </td>
             
              <td width="10%">
                  <input autocomplete="off"  placeholder="Catatan" id="dt_note" style="width:100%" type="text" class="form-control reset1" >
              </td>
              <td width="5%">
                  <button class="btn btn-primary btn-sm" onclick="tambah()" id="btn_click"  type="button"><i class="fa fa-plus-square" ></i></button>
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
<th width="30%">Note</th>
<th width="5%">-</th>
</thead>
<tbody id="detail_item">

</tbody>
</table>
</div>
</div>
     
          
          <div class="row">
            <div class="col-sm-6"> 
                    <div class="widget-footer enter ">                      
                      <button class="btn btn-success upload-image" type="submit">Simpan</button>
                      <button class="btn btn-primary upload-image" type="button" onclick="cetak()">Simpan & Cetak</button>
                          <a href="<?php echo base_url("panel/request_order"); ?>" class="btn btn-default">Kembali</a>
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
})

$('#jenis_jasa').on("change", function() {
  var id=$('option:selected',this).val();
  var name=$('option:selected',this).data('name');
  var pcs=$('option:selected',this).data('pcs');
  $('#dt_name').val(name);
  $('#dt_id').val(id);
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
    //alert(jml==''); return false;
    if(id==''|| jml=='' || jml==0){
      alert("data belum di isi");
      return false;
    }
    var html='<tr class="item-'+ii+'">'+
                  '<td>'+
                        '<input autocomplete="off"  type="" style="display: none;" name="id[]" value="'+id+'" class="form-control id-'+ii+'">'+
                        '<input autocomplete="off"  type="" name="barang[]" value="'+name+'" class="form-control barang-'+ii+'" readonly="" >'+
                  '</td>'+
                        '<td><input autocomplete="off"  type="" name="jumlah[]" value="'+jml+'" class="form-control jumlah-'+ii+'" ></td>'+
                        /*'<td><input autocomplete="off"  type="" name="pcs[]" value="'+pcs+'" class="form-control" pcs-'+ii+' readonly="" ></td>'+*/
                        '<td><input autocomplete="off"  type="" name="note[]" value="'+note+'"  class="form-control" note-'+ii+'></td>'+
                        '<td width="5%">'+
                        '<button class="btn btn-danger btn-sm" onclick=hapus('+ii+') id="btn_click"  type="button"><i class="fa fa-minus-square "></i></button>'+
                  '</td>'+
              '</tr>';
    $('#detail_item').append(html)
    ii++;
    $('.reset1').val('')
    $('#jenis_barang').val('');    
    $("#jenis_barang").select2().trigger('change');
  }
  function hapus(a){
    $('.item-'+a).remove();
  }

  function cetak(){
   // window.open("https://localhost/outbound/panel/request_order/print")


      $.ajax({
          url : '<?php echo base_url("panel/request_order/insert"); ?>',
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
            if(data.r!=''){
               $url='<?php echo base_url("panel/request_order/cetak/"); ?>'+data.r;
             window.open($url);
              }
              
             window.location = "<?=base_url('panel/request_order');?>";
            }
        });
              }
          },
          error: function(jqXHR, textStatus, errorThrown){
              alert('Error,something goes wrong');
          }
      });
   

  }

 // $('#jenis_barang').select2()
</script>


<script type="text/javascript">
  $(document).ready(function(){
    $('form#admin_form').on('submit', function(e) {
      e.preventDefault();
      $.ajax({
          url : '<?php echo base_url("panel/request_order/insert"); ?>',
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
           
             window.location = "<?=base_url('panel/request_order');?>";
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

  function refresh_kode(){
          $.ajax({
          url : '<?php echo base_url("panel/request_order/refresh_kode"); ?>',
          type: "POST",
         // data : $('#admin_form').serialize(),
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
            $('#kode').val(data);
          
          },
          error: function(jqXHR, textStatus, errorThrown){
              alert('Error,something goes wrong');
          }
      });

  }
</script>

<script type="text/javascript">
  $('form input').keydown(function (e) {
if (e.keyCode == 13) {
    e.preventDefault();
    return false;
}
});
</script>