<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$search_f = isset($this->session->userdata['asearch']['campaign_search'])?$this->session->userdata['asearch']['campaign_search']:'';
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Telaahan
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url().'panel';?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Telaahan</li>
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
         <div class="col-md-2 col-sm-6 col-xs-12">
                <label>Kode Permintaan<span style="color: red"> *</span></label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group form-group-sm" id="div_kategori">
                <select class="form-control" id="id_ro" onchange="search_ro()">
                    <option value="">--- Pilih ---</option>
                    <?php foreach ($ro as $key => $v): ?>
                      <option value="<?=$v->id ?>"> <?php echo $v->name ?> 
                      </option>  
                    <?php endforeach ?>
                </select>
            </div>
          </div>
  </div>  
</div>
<div class="col-md-12">
  <div class="row">  
    <hr>
  </div>
</div>

<div class="form_ro">
  
</div>
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
  function search_ro(){
    var id=$('#id_ro').val();

     $.ajax({
          url : '<?php echo base_url("panel/purchase_order/get_ro/"); ?>'+id,
          type: "get",        
          //dataType: 'json',
          success:function(data, textStatus, jqXHR){
            $('.form_ro').html(data);
             
          },
          error: function(jqXHR, textStatus, errorThrown){
              alert('Error,something goes wrong');
          }
      });

  }
</script>

