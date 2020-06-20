<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$search_f = isset($this->session->userdata['asearch']['campaign_search'])?$this->session->userdata['asearch']['campaign_search']:'';
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Edit Nota
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
           
<div class="col-md-12">
  <div class="row">        
      



  <form class="form-horizontal" method="post" id="admin_form">
    <div class="row">
        <div class="col-md-12">
            <input type="hidden" name="ro_id" id="ro_id" class="form-control" readonly="" value="<?=$po['master']->po_request_id?>"> 
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
            <label>Kode Telaahan<span style="color: red"> *</span></label>
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
              <input type="text" value="<?=number_format($po['master']->po_anggaran,0,',','.') ?>" name="anggaran" id="anggaran" class="form-control" placeholder="Anggaran" readonly>        
            </div>
          </div> 

           <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Total<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input type="text" name="total" id="total" class="form-control currency" placeholder="Anggaran" value="<?=number_format($po['master']->total_nota,0,',','.') ?>" readonly>        
            </div>
          </div> 




        </div>
    </div>

<div style="width:100%; padding-left:-10px">
<div class="table-responsive">
<table class="table table-bordered table stripped"  id="table_" cellspacing="0" width="100%">
<thead>
<th width="25%" data-header="nama">Nama</th>
<th width="5%">Qty</th>

<th width="18%">Note</th>
<th width="10%">Harga</th>
<th width="10%">Sub Total</th>
<th width="20%">Merk</th>


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
        <td>
          <?=$v->pod_qty_approve ?>
          <input type="hidden" value="<?=$v->pod_qty_approve ?>" name="qty[]" placeholder="Harga" class="form-control currency qty-<?=$key?> " >
        </td>
        <td><?=$v->pod_note ?>
        </td>
        <td>
          <input onkeyup="subharga(<?=$key?>)" type="text" name="harga[]" placeholder="Harga" class="form-control currency harga-<?=$key?> " value="<?=$v->pod_harga ?>" >
        </td>
        <td>
          <input type="text" name="subharga[]" placeholder="Harga" class="form-control currency subharga-<?=$key?>" value="<?=($v->pod_harga*$v->pod_qty_approve) ?>" readonly>
        </td>
  
        <td>
          <textarea class="form-control" name="merk[]"><?=$v->pod_merk ?></textarea>
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
                     
                    
                       <a href="<?php echo base_url("panel/nota"); ?>" class="btn btn-default">Kembali</a>

          </div>
          </div>
     
</form>     
    
  </div>  
</div>
<div class="col-md-12">
  <div class="row">  
    <hr>
  </div>
</div>

        </div>              


          </div>
        </div>
      </div>
    </div>
  </section>
</div>


<script src="<?=base_url('assets')?>/plugins/input-mask/jquery.inputmask.bundle.js"></script>
<script type="text/javascript">
  $(".currency").inputmask({alias : "currency", prefix: '', digits: 0, groupSeparator: "."});


</script>



<script type="text/javascript">
  $(document).ready(function(){
    $('form#admin_form').on('submit', function(e) {
      e.preventDefault();
      var anggaran=parseInt($('#anggaran').val().split('.').join(''))
      var total=parseInt($('#total').val().split('.').join(''))
      if(anggaran<total){
          
           $().toastmessage('showToast', {
                          text     :'Total Melebihi Anggaran',
                          position : 'top-center',
                          type     : 'error',
                          close    : function () {
                            
                          }
                      });
       

          return false;
      }
       
       
      $.ajax({
           url : '<?php echo base_url("panel/nota/update/").$po['master']->po_id; ?>',
          type: "POST",
          data : $('#admin_form').serialize(),
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
            
              if(!data.status){
                      $().toastmessage('showToast', {
                          text     : data.e,
                          position : 'top-center',
                          type     : 'error',
                          close    : function () {
                            
                          }
                      });
              }else{
                $().toastmessage('showToast', {
            text     : 'Insert data success',
            position : 'top-center',
            type     : 'success',
            close    : function () {
              window.location = "<?=base_url('panel/nota');?>";
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

  function subharga(id){
    var qty=$('.qty-'+id).val()
    var harga=$('.harga-'+id).val()
    var harga= harga.split('.').join('');
    var subharga=qty*harga;
    $('.subharga-'+id).val(subharga)  
    total()  
  }
  function total(){
    var total=0
    $('#table_ > tbody  > tr').each(function(index) {
       var tamp=$('.subharga-'+index).val();
       total+= parseInt(tamp.split('.').join(''));  
    });
    $('#total').val(total)    

  }
</script>
