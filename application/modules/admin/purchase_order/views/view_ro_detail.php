
           


  <form class="form-horizontal" method="post" id="admin_form">
    <div class="row">
        <div class="col-md-12">
          <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Bidang<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input type="hidden" name="ro_id" id="ro_id" class="form-control" readonly="" value="<?=$ro['master']->ro_id?>">        
              <input value="<?=$ro['master']->fro ?>" type="text" name="vendor" id="unit" class="form-control" disabled="">
              <input value="<?=$ro['master']->ro_from ?>" type="hidden" name="from" id="unit" class="form-control" >        
            </div>
          </div>                  
          <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Tujuan Divisi<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
                <input value="<?=$ro['master']->too ?>" type="text" name="vendor" id="unit" class="form-control" disabled="">

              <input value="<?=$ro['master']->ro_to ?>" type="hidden" name="to" id="unit" class="form-control" >        
            </div>
          </div>
           <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Kode RO.<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input id="tgl" type="text" value="<?=$ro['master']->ro_code ?>" class="form-control reset " name="no"  autocomplete="off" readonly>
            </div>
          </div>

          <input id="asli" value="<?=$asli ?>" type="hidden" value="" class="form-control reset " name="asli"  autocomplete="off" readonly>

           <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Kode PO.<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm input-group" id="div_kategori">
              <input id="kode" value="<?=$kode ?>" type="text" value="" class="form-control reset " name="no"  autocomplete="off" readonly>
              
              <span class="info"></span>  
              <div class="input-group-btn">
                <button class="btn btn-default btn-sm" type="button" onclick="refresh_kode()">
                  <i class="fa fa-refresh"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Tanggal Digunakan<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input id="tgl" value="<?=date('d-m-Y',strtotime($ro['master']->ro_date)); ?>" type="text" class="form-control reset " name="tanggal"  autocomplete="off" readonly>
            </div>
          </div>
          <div class="col-md-2 col-sm-6 col-xs-12">
              <label>Kategori<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input type="" name="" value="<?=$ro['master']->k_name?>" class="form-control" readonly>
              <input type="hidden" name="type" value="<?=$ro['master']->k_id?>" class="form-control" readonly>
            </div>
          </div>
          <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Perihal<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input type="text" value="<?=$ro['master']->ro_note ?>" name="perihal" id="perihal" class="form-control" placeholder="Perihal" readonly>        
            </div>
          </div> 

           <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Anggaran<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
              <input type="text" value="" name="anggaran" id="anggaran" class="form-control currency" placeholder="Anggaran">                
              <span class="info"></span>      
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
<th width="7%">Qty Approve</th>
<th width="30%">Note</th>
<th width="15%">-</th>
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
        <td>
          <input class="form-control" type="" name="jumlah_apr[]" value="<?=$v->rod_qty ?>">
        </td>
        <td><?=$v->rod_note ?> <input type="hidden" name="node_etail[]" value="<?=$v->rod_note ?>"></td>
        <td>
          <select class="form-control" name="status_dt[]">
            <option>Setuju</option>
            <option>Tolak</option>
          </select>
        </td>
      </tr>      
    <?php endforeach ?>
  </tbody>
</tbody>
</table>



<div class="form-group">
                     
                      <div class="col-sm-12  col-xs-12">
                        <textarea name="script" class="form-control" id="script" ></textarea>
                        <span class="info"></span>
                      </div>
                    </div>




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

      
<script src="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- CKEditor -->
<script src="<?php echo base_url(); ?>assets/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript">

 var toolbars = [{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline'] },{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },{ name: 'links', items: [ 'Link', 'Unlink' ] },];
  CKEDITOR.replace('script', {height:130,toolbar: toolbars,removePlugins: 'elementspath',resize_enabled: false});

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
    $('.reset1').val('')
    $('#jenis_barang').val('');    
    $("#jenis_barang").select2().trigger('change');
  }
  function hapus(a){
    $('.item-'+a).remove();
  }

  function cetak(){
    window.open("https://localhost/outbound/panel/request_order/print")
  }

 // $('#jenis_barang').select2()
</script>

<script src="<?=base_url('assets')?>/plugins/input-mask/jquery.inputmask.bundle.js"></script>
<script type="text/javascript">
  $(".currency").inputmask({alias : "currency", prefix: '', digits: 0, groupSeparator: "."});
  $(document).ready(function(){
    $('form#admin_form').on('submit', function(e) {
       var script = CKEDITOR.instances['script'].getData();
    $('[name="script"]').val(script);
      e.preventDefault();
      
      $.ajax({
           url : '<?php echo base_url("panel/purchase_order/insert"); ?>',
          type: "POST",
          data : $('#admin_form').serialize(),
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
         //   console.log('ini'+data.gagal)
              if(!data.status){
               // alert(3)
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

  function refresh_kode(){
    var id="<?=$ro['master']->ro_id?>";
          $.ajax({
          url : '<?php echo base_url("panel/purchase_order/refresh_kode/"); ?>'+id,
          type: "POST",
         // data : $('#admin_form').serialize(),
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
            $('#kode').val(data.kode);
            $('#asli').val(data.asli);
          
          },
          error: function(jqXHR, textStatus, errorThrown){
              alert('Error,something goes wrong');
          }
      });

  }
</script>