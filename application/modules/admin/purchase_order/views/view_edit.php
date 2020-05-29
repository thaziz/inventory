<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$search_f = isset($this->session->userdata['asearch']['campaign_search'])?$this->session->userdata['asearch']['campaign_search']:'';
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Edit Purchase Order
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url().'panel';?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Edit Purchase Order</li>
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
          <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Bidang<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input type="hidden" name="po_id" id="po_id" class="form-control" readonly="" value="<?=$po['master']->po_id?>">        
              <input value="<?=$po['master']->fro ?>" type="text" name="vendor" id="unit" class="form-control" disabled="">
             </div>
          </div>                  
          <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Tujuan Divisi<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
                <input value="<?=$po['master']->too ?>" type="text" name="vendor" id="unit" class="form-control" disabled="">
      
            </div>
          </div>
        
           <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Kode PO.<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input id="tgl" value="<?=$po['master']->po_code_a?>" type="text" value="" class="form-control reset " name="no"  autocomplete="off" readonly>
            </div>
          </div>
          <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Tanggal<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input id="tgl" value="<?=date('d-m-Y',strtotime($po['master']->po_date)); ?>" type="text" class="form-control reset " name="tanggal"  autocomplete="off" readonly>
            </div>
          </div>
          <div class="col-md-2 col-sm-6 col-xs-12">
              <label>Kategori<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input type="" name="type" value="<?=$po['master']->po_type?>" class="form-control" readonly>
            </div>
          </div>
          <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Perihal<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input type="text" value="<?=$po['master']->po_note ?>" name="perihal" id="perihal" class="form-control" placeholder="Perihal" readonly>        
            </div>
          </div> 

           <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Anggaran<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input type="text" value="<?=$po['master']->po_anggaran?>" name="anggaran" id="anggaran" class="form-control currency" placeholder="Anggaran" >        
            </div>
          </div> 


    

        

        </div>
    </div>

<div style="width:100%; padding-left:-10px">
<div class="table-responsive">
<table class="table table-bordered table stripped"  id="table" cellspacing="0" width="100%">
<thead>
<th width="30%" data-header="nama">Nama</th>
<th width="7%">Qty</th>

<th width="30%">Note</th>
<th width="15%">-</th>

</thead>
<tbody id="detail_item">
  <tbody>

     <?php foreach ($po['detail'] as $key => $v): ?>
      <tr>
        <td><?=$v->pod_item_name ?>
        <input type="hidden" name="barang[]" value="<?=$v->pod_item_name ?>">
        <input type="hidden" name="barang_id[]" value="<?=$v->pod_item ?>">
          <input type="hidden" name="id[]" value="<?=$v->pod_purchase_order ?>">          
          <input type="hidden" name="detail[]" value="<?=$v->pod_detailid ?>">
        </td>
        <td><?=$v->pod_qty ?>
          <input type="hidden" name="jumlah[]" value="<?=$v->pod_qty ?>">
        </td>
        <td>
          <input class="form-control" type="" name="jumlah_apr[]" value="<?=$v->pod_qty_approve ?>">
        </td>
        <td><?=$v->pod_note ?> <input type="hidden" name="node_etail[]" value="<?=$v->pod_note ?>"></td>
        <td>
          <select class="form-control" name="status_dt[]">
            <option <?php if($v->pod_status=='Setuju'){echo 'selected=""';} ?> >Setuju</option>
            <option <?php if($v->pod_status=='Tolak'){echo 'selected=""';} ?> >Tolak</option>
          </select>
        </td>
      </tr>      
    <?php endforeach ?>


  </tbody>
</tbody>
</table>
</div>
</div>

  <div class="row">
            <div class="col-sm-6"> 
                    <div class="widget-footer enter ">                      
                      <button class="btn btn-success upload-image" type="submit">Simpan</button>
                     
                      <a href="<?php echo base_url("panel/purchase_order"); ?>" class="btn btn-default">Kembali</a>
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

<script src="<?=base_url('assets')?>/plugins/input-mask/jquery.inputmask.bundle.js"></script>
<script type="text/javascript">
  $(".currency").inputmask({alias : "currency", prefix: '', digits: 0, groupSeparator: "."});

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
                        '<input type="" style="display: none;" name="id[]" value="'+id+'" class="form-control id-'+ii+'">'+
                        '<input type="" name="barang[]" value="'+name+'" class="form-control barang-'+ii+'" readonly="" >'+
                  '</td>'+
                        '<td><input type="" name="jumlah[]" value="'+jml+'" class="form-control jumlah-'+ii+'" ></td>'+
                        /*'<td><input type="" name="pcs[]" value="'+pcs+'" class="form-control" pcs-'+ii+' readonly="" ></td>'+*/
                        '<td><input type="" name="note[]" value="'+note+'"  class="form-control" note-'+ii+'></td>'+
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
   // window.open("https://localhost/outbound/panel/purchase_order/print")


      $.ajax({
          url : '<?php echo base_url("panel/purchase_order/edit/"); ?>'+<?=$po['master']->po_id?>,
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
               $url='<?php echo base_url("panel/purchase_order/cetak/"); ?>'+data.r;
             window.open($url);
              }
              
             window.location = "<?=base_url('panel/purchase_order');?>";
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
          url : '<?php echo base_url("panel/purchase_order/edit/"); ?>'+<?=$po['master']->po_id?>,
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
           
             window.location = "<?=base_url('panel/purchase_order');?>";
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