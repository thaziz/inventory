<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$search_f = isset($this->session->userdata['asearch']['campaign_search'])?$this->session->userdata['asearch']['campaign_search']:'';
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Detail Permintaan
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url().'panel';?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Detail Permintaan</li>
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
            <label>Bidang<span style="color: red"> </span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input type="hidden" name="ro_id" id="ro_id" class="form-control" readonly="" value="<?=$ro['master']->ro_id?>">        
              <input value="<?=$ro['master']->fro ?>" type="text" name="vendor" id="unit" class="form-control" disabled="">
              <input value="<?=$ro['master']->ro_from ?>" type="hidden" name="from" id="unit" class="form-control" >        
            </div>
          </div>  

          <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Tujuan Divisi</label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
                <input value="<?=$ro['master']->too ?>" type="text" name="vendor" id="unit" class="form-control" disabled="">

              <input value="<?=$ro['master']->ro_to ?>" type="hidden" name="to" id="unit" class="form-control" >        
            </div>
          </div>
           <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Kode Permintaan</label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input id="tgl" type="text" value="<?=$ro['master']->ro_code ?>" class="form-control reset " name="no"  autocomplete="off" readonly>
            </div>
          </div>
          
          <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Tanggal Digunakan</label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input id="tgl" value="<?=date('d-m-Y',strtotime($ro['master']->ro_date)); ?>" type="text" class="form-control reset " name="tanggal"  autocomplete="off" readonly>
            </div>
          </div>
          <div class="col-md-2 col-sm-6 col-xs-12">
              <label>Kategori</label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input type="" name="type" value="<?=$ro['master']->k_name?>" class="form-control" readonly>
            </div>
          </div>
          <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Perihal</label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input type="text" value="<?=$ro['master']->ro_note ?>" name="perihal" id="perihal" class="form-control" placeholder="Perihal" readonly>        
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
    <?php foreach ($ro['detail'] as $key => $v): ?>
      <tr>
        <td><?=$v->rod_item_name ?>
        <input type="hidden" name="barang[]" value="<?=$v->rod_item_name ?>">
        <input type="hidden" name="barang_id[]" value="<?=$v->rod_item ?>">
          <input type="hidden" name="id[]" value="<?=$v->rod_request_order ?>">          
          <input type="hidden" name="detail[]" value="<?=$v->rod_detailid ?>">
        </td>
        <td><?=$v->rod_qty ?>
          <input type="hidden" name="jumlah[]" value="<?=$v->rod_qty ?>">
        </td>
        <td><?=$v->rod_note ?> <input type="hidden" name="node_etail[]" value="<?=$v->rod_note ?>"></td>
      </tr>      
    <?php endforeach ?>
  </tbody>
</tbody>
</table>






</div>




  <div class="row">
            <div class="col-sm-6"> 
                    <div class="widget-footer enter ">                      
                      <button class="btn btn-success upload-image" onclick="cetak(<?=$ro['master']->ro_id?>)">Cetak</button>
                     
                      <a href="<?php echo base_url('panel/request_order'); ?>" class="btn btn-default">Kembali</a>
                    </div>

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
  function cetak(id) {
     $url='<?php echo base_url("panel/request_order/cetak/"); ?>'+id;
             window.open($url);
  }
</script>