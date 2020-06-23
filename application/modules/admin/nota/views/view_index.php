<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Nota
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url().'panel';?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Nota</li>
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
              <a href="<?=base_url('panel/nota/insert');?>" class="btn btn-success btn-sm btn-circle"><i class="fa fa-plus"></i> Insert</a>
              <?php }?>
            </div>
          </div>
          <div class="box-body">
            <table id="ro_table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="20px"></th>
                  <th width="70px;">Kode</th>
                   <th>Dari</th>
                  <th>Tanggal</th>
                  <th>Kategori</th>    
                  
                  <th>Kode Anggaran</th> 
                  <th>Anggaran</th> 
                  <th>Total Nota</th> 

                  <th>Status</th>                
                  <th>&nbsp;</th>
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
<script type="text/javascript">
  function remove(id){
    if (confirm( "Are you sure you want to delete the selected admin?" )) {
      $.ajax({
          url : '<?php echo base_url("panel/admin/delete"); ?>',
          type: "POST",
          data : {'adm_id':[id]},
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
              if(data.status){
                $().toastmessage('showToast', {
                  text     : 'Delete data success',
                  position : 'top-center',
                  type     : 'success',
                  close    : function () {
                    window.location = "<?=base_url('panel/admin');?>";
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

  $(document).ready(function(){

    $('#ro_table').dataTable({
      "aLengthMenu":  [10, 25, 50, 100, 500, 1000, 2500, 5000],
      "ajax": {
              "url": "<?php echo base_url('panel/nota'); ?>",
              "type": "POST"
          },
      "aaSorting": [[ 1, "desc" ]],
      "searching": true,
      "paging": true,
      "bFilter": false,
      "bStateSave": true,
      "bServerSide": true,
      "sPaginationType": "full_numbers",
      "aoColumnDefs": [
      { "title":"<input type='checkbox' class='check-all'></input>","sClass": "center","aTargets":[0],
        "render": function(data, type, full){
          return '<input type="checkbox" class="check-item" value="'+full[0]+'">';
        },
        "bSortable": false
      },
      { "sClass": "center", "aTargets": [ 1 ], "data":0 },
      { "sClass": "center", "aTargets": [ 2 ], "data":1 },
      { "sClass": "center", "aTargets": [ 3 ], "data":2 },
      { "sClass": "center", "aTargets": [ 4 ], "data":3 },
      { "sClass": "center", "aTargets": [ 5 ], "data":4 },
      { "sClass": "center", "aTargets": [ 6 ], "data":5 },
      { "sClass": "center", "aTargets": [ 7 ], "data":6 },
      { "sClass": "center", "aTargets": [ 8 ], "data":7 },
      { "sClass": "center", "aTargets": [ 8 ],
        "mRender": function(data, type, full) {
//console.log(full[7]);
            if(full[7]=='Bendahara')
              return '<span class="label label-primary">'+full[7]+'</span>';
            else
              return '<span class="label label-warning">'+full[7]+'</span>';
        },
        "bSortable": false
      },
      /*{ "sClass": "center", "aTargets": [ 5 ], "data":4 ,
        "render" : function (data, type, full, meta){
          return '<input disabled="true" type="checkbox" '+(data=='1'?'checked':'')+' "/>'
        }
      }, */    
      //{ "sClass": "center", "aTargets": [ 9 ], "data":8 },
      { "sClass": "center", "aTargets": [ 9 ],
        "mRender": function(data, type, full) {
          var btn='';
            if(full[7]='Done'){
              btn='disabled';
            }
            <?php if($rules['v']){ ?>
          return '<a href=<?=base_url('panel/nota/detail');?>/' + full[8]
              + ' class="btn btn-default btn-xs btn-col icon-black"><i class="fa fa-search"></i> Detail'
              <?php } ?>
                <?php if($rules['e']){?>
              + '</a>'+'<a '+btn+' href=<?=base_url('panel/nota/edit');?>/' + full[8]
              + ' class="btn btn-info btn-xs btn-col icon-green"><i class="fa fa-pencil"></i> Edit'
              <?php }?>
              
           
              + '</a>';
        },
        "bSortable": false
      },
      ]
    });

    //action to change all checkbox
    $('.check-all').change(function(){
      $('.check-item').prop('checked', $(this).prop('checked'));
    });
    //action to delete selected items
    $('#delete-all').click(function(){
      if (confirm( 'Are you sure you want to delete the selected admin?' )) {
        var data = {};
        var adm_id = [];
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
          adm_id.push(parseInt($(el).val()));
        });
        data.adm_id = adm_id;
        $.ajax({
          url : '<?php echo base_url("panel/admin/delete"); ?>',
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
                    window.location = "<?=base_url('panel/admin');?>";
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

  });

</script>
