<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Laporan Anggaran
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url().'panel';?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active"> Laporan Anggaran</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">

            </h3>
            <div class="action pull-right">
              <?php if($rules['d']){?>
              <a id="delete-all" title="Delete selected data" class="btn btn-danger btn-sm btn-circle"><i class="fa fa-trash"></i></a>
              <?php }?>
              <?php if($rules['c']){?>
              <a href="<?=base_url('panel/laporan_anggaran/insert');?>" class="btn btn-success btn-sm btn-circle"><i class="fa fa-plus"></i> Insert</a>
              <?php }?>
            </div>
          </div>
          <div class="box-body">
          <form class="form-horizontal" method="post" id="search_form">
            <table class="table table-bordered table-striped">
              <td width="15%">Nama Anggaran</td>
              <td width="30%">
                <select class="form-control" name="adv_search[j_a_code]">
                  <option value="">---Pilih account---</option>  
                  <?php foreach ($account  as $key => $v): ?>
                      <option value="<?=$v->id ?>"><?=$v->name ?></option>  
                  <?php endforeach ?>
                    
                </select>
              </td>
              <td width="10%">Periode</td>
              <td width="35%">
    <input type="text" name="adv_search[call_date]" value="May 12, 2020 01:00 AM - May 12, 2020 11:59 PM" class="form-control date_range" id="call_date">
              </td>
              <th><button class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button></th>
            </table>
          </form>
            <br>
            <table id="admin_table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Kode</th>
                  <th>Nama</th>
                  <th>Tahun</th>
                  <th>Saldo</th>
                  <th>Keterangan</th>
                  <th>Tanggal Dibuat</th>                  
                 <!--  <th>&nbsp;</th> -->
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script src="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">

<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/moment.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>

<script type="text/javascript">
    $('.date_range').daterangepicker({
      locale: {
        format: 'MMMM DD, YYYY hh:mm A',
        cancelLabel: 'Clear'
      },
      autoUpdateInput: false,
      timePicker: true,
    });
    $('.date_range').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('MMMM DD, YYYY hh:mm A') + ' - ' + picker.endDate.format('MMMM DD, YYYY hh:mm A'));
    });

    $('.date_range').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
    });

  function remove(id){
    if (confirm( "Apakah Kamu Ingin Menghapus Data laporan_anggaran?" )) {
      $.ajax({
          url : '<?php echo base_url("panel/laporan_anggaran/delete"); ?>',
          type: "POST",
          data : {'d_id':[id]},
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
              if(data.status){
                $().toastmessage('showToast', {
                  text     : 'Delete data success',
                  position : 'top-center',
                  type     : 'success',
                  close    : function () {
                    window.location = "<?=base_url('panel/laporan_anggaran');?>";
                  }
              });
            }
          },
          error: function(jqXHR, textStatus, errorThrown){
              alert('Error,something goes wrong');
          }
      });
    }
  }


    reload_table();
    function reload_table() {
    $('#admin_table').dataTable({
      "aLengthMenu":  [10, 25, 50, 100, 500, 1000, 2500, 5000],
      "ajax": {
              "url": "<?php echo base_url('panel/laporan_anggaran'); ?>",
              "type": "POST",
               "data": data_builder(),
          },
      "aaSorting": [[ 1, "desc" ]],
      "searching": true,
      "paging": true,      
      "destroy": true,
      "bFilter": false,
      "bStateSave": true,
      "bServerSide": true,
      "sPaginationType": "full_numbers",
      "aoColumnDefs": [
     /* { "title":"<input type='checkbox' class='check-all'></input>","sClass": "center","aTargets":[0],
        "render": function(data, type, full){
          console.log(full);
          return '<input type="checkbox" class="check-item" value="'+full[7]+'">';
        },
        "bSortable": false
      },*/
      
      { "sClass": "center", "aTargets": [ 0 ], "data":0, "visible":false },
      /*{ "sClass": "center", "aTargets": [ 0 ], "data":0 },*/
      { "sClass": "center", "aTargets": [ 1 ], "data":1 },

      { "sClass": "center", "aTargets": [ 2 ], "data":2 },
      { "sClass": "center", "aTargets": [ 3 ], "data":3 },

      { "sClass": "center", "aTargets": [ 4 ], "data":4 },
      { "sClass": "center", "aTargets": [ 5 ], "data":5 },
      
      /*
      { "sClass": "center", "aTargets": [ 7 ],
        "mRender": function(data, type, full) {
            <?php if($rules['v']){ ?>
          return ''
              <?php } ?>
              <?php if($rules['e']){?>
              + ''+'<a href=<?=base_url('panel/laporan_anggaran/edit');?>/' + full[7]
              + ' class="btn btn-info btn-xs btn-col icon-green"><i class="fa fa-pencil"></i> Edit'
              <?php }?>
              <?php if($rules['d']){?>
              + '</a>'+'<a href="javascript:;" onclick="remove(\'' + full[7] + '\');" id="btn-delete" class="btn btn-danger btn-xs btn-col icon-black"><i class="fa fa-close"></i> ' + 'Delete'
              <?php }?>
              + '</a>';
        },
        "bSortable": false
      },*/
      ]
    });
  }

    //action to change all checkbox
    $('.check-all').change(function(){
      $('.check-item').prop('checked', $(this).prop('checked'));
    });
    //action to delete selected items
    $('#delete-all').click(function(){
      if (confirm( 'Apakah Kamu Ingin Menghapus Data laporan_anggaran??' )) {
        var data = {};
        var d_id = [];
        if($('.check-item:checked').length<1){
          $().toastmessage('showToast', {
            text     : "Delete failed, you don't select any data.",
            sticky   : false,
            position : 'top-center',
            type     : 'error',
          });
          return false;
        }
        $('.check-item:checked').each(function(idx, el){
          
          d_id.push(parseInt($(el).val()));
        });
        data.d_id = d_id;
        $.ajax({
          url : '<?php echo base_url("panel/laporan_anggaran/delete"); ?>',
          type: "POST",
          data : data,
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
              if(data.status){
                $().toastmessage('showToast', {
                  text     : 'Delete data success',
                  position : 'top-center',
                  type     : 'success',
                  close    : function () {
                    window.location = "<?=base_url('panel/laporan_anggaran');?>";
                  }
                });
              }else{
                console.log(data);
              }
          },
          error: function(jqXHR, textStatus, errorThrown){
              alert('Error,something goes wrong');
          }
        });
      }
    });


function data_builder() {
      var data_set = {};
      var array = $("#search_form, #column-form").serializeArray();
      $.each(array, function(key, val) {
        data_set[val.name] = val.value;
      });
      data_set['report_type'] = $('#type-report').val();
      return data_set;
    }

  $('form#search_form').on('submit', function(e) {
      e.preventDefault();
      $('#search').removeClass('in');
      reload_table();
    });
</script>
