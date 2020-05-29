<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Insert Bendahara
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url().'panel';?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Inser Bendahara</li>
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
           




  <form >
    <div class="row">
        <div class="col-md-12">
          <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Bidang<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
                    
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
              <input style="text-align: right;" type="text" value="<?=number_format($po['master']->po_anggaran,0,',','.') ?>" name="anggaran" id="anggaran" class="form-control" placeholder="Anggaran" readonly>        
            </div>
          </div> 


          
          
          <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Jumlah Anggaran<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input type="text" value="<?=number_format($po['master']->po_anggaran,0,',','.'); ?>" name="jml_anggaran" id="saldo" class="form-control" placeholder="Jumlah Anggaran" readonly="" style="text-align: right;">        
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
        </td>
        <td><?=$v->pod_note ?>
       
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
                      <button type="button" class="btn btn-info " data-toggle="modal" onclick="as()">Voucer Pengembalian</button>
                
                      <a href="<?php echo base_url("panel/bendahara"); ?>" class="btn btn-default">Kembali</a>
          </div>
          </div>
     
</form>    







          </div>
        </div>
      </div>
    </div>
  </section>
</div>



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Voucer Pinjaman</h4>
      </div>
      <div class="modal-body">
        

  <form class="form-horizontal" method="post" id="admin_form">
    <div class="row">
        <div class="col-md-12">
          <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Nama Anggaran</label>
          </div>
          <input type="hidden" name="po_id" id="po_id" class="form-control" readonly="" value="<?=$po['master']->po_id?>">  
          <div class="col-md-9 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
                   
              <input value="<?=$po['master']->a_code ?> - <?=$po['master']->a_name ?>" type="text" name="vendor" id="unit" class="form-control" disabled="">
             </div>
          </div>                  
          

           <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Anggaran</label>
          </div>
          <div class="col-md-9 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input style="text-align: right;" type="text" value="<?=number_format($po['master']->po_anggaran,0,',','.') ?>" name="" id="anggaran_awal" class="form-control" placeholder="" readonly>        
            </div>
          </div> 

          <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Jumlah Anggaran</label>
          </div>
          <div class="col-md-9 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input type="text"  name="jumlah_anggaran" id="jumlah_anggaran" class="form-control currency" placeholder="" onkeyup="sisa()">        
            </div>
          </div> 

          <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Sisa Anggaran</label>
          </div>
          <div class="col-md-9 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input type="text" name="sisa_anggaran" id="sisa_anggaran" class="form-control currency" placeholder=""  readonly="">        
            </div>
          </div> 



          <div class="col-md-3 col-sm-6 col-xs-12">
            <label>Keterangan</label>
          </div>
          <div class="col-md-9 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
             <textarea name="Keterangan" style="width: 100%"></textarea>      
            </div>
          </div> 


  </div>
  </div>
  </form>      


      </div>
      <div class="modal-footer">
        <button type="button" onclick="simpan()" class="btn btn-primary simpan">Simpan</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
      </div>
    </div>

  </div>
</div>

<script src="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.js"></script>
<script type="text/javascript"> 
  
function as(){
  $('#myModal').modal('show');
} 
function sisa(){    
    var anggaran_awal   =$('#anggaran_awal').val();
    var jumlah_anggaran=$('#jumlah_anggaran').val();

    anggaran_awal = anggaran_awal.replace(".", "");
    jumlah_anggaran = jumlah_anggaran.replace(".", "");
    console.log(parseInt(anggaran_awal)<parseInt(jumlah_anggaran))
    //console.log(anggaran_awal+'<'+jumlah_anggaran)
    if(parseInt(anggaran_awal)<parseInt(jumlah_anggaran)){
     $('.simpan').attr('disabled',true);

      $().toastmessage('showToast', {
            text     : 'Sisa anggaran minus',
            position : 'top-center',
            type     : 'error',
            close    : function () {
               $('.simpan').attr('disabled',false);
                var jumlah_anggaran=$('#jumlah_anggaran').val("");
                $('#sisa_anggaran').val("");
              
            }
          })
    }
    var hasil=anggaran_awal-jumlah_anggaran;

    $('#sisa_anggaran').val(hasil);
  }

</script>



<script src="<?=base_url('assets')?>/plugins/input-mask/jquery.inputmask.bundle.js"></script>
<script type="text/javascript">
  $(".currency").inputmask({alias : "currency", prefix: '', digits: 0, groupSeparator: "."});
  function simpan(){
    
  
  
      $.ajax({
           url : '<?php echo base_url("panel/bendahara/insert_pengembalian"); ?>',
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
              window.location = "<?=base_url('panel/bendahara');?>";
            }
        });
              }
          },
          error: function(jqXHR, textStatus, errorThrown){
              alert('Error,something goes wrong');
          }
      });
    
}
</script>
