<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$search_f = isset($this->session->userdata['asearch']['campaign_search'])?$this->session->userdata['asearch']['campaign_search']:'';
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Campaign
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url().'panel';?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Campaign</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">
              
            </h3>
              <!--collapsible form-->
                <div class="row" style="padding-top: 15px;">
                  <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-success collapse" id="search">
                      <div class="panel-body">
                        <form class="form-horizontal" method="post" id="search_form">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="col-sm-3 control-label" for="campaign_name">Campaign Name </label>
                              <div class="col-sm-9">
                                <input type="text" name ="adv_search[campaign_name]" id = "adv_search[campaign_name]" class="form-control input-sm">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-sm-3 control-label" for="date">Date Range </label>
                              <div class="col-sm-9">
                                <input class = "col-sm-4" type="text" name="adv_search[start_date]" class="form-control input-sm">&nbsp;&nbsp;
                                <input class = "col-sm-4" type="text" name="adv_search[end_date]" class="form-control input-sm">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-sm-3 control-label" for="creator_id">Created By</label>
                              <div class="col-sm-9">
                                <select name="adv_search[creator_id]" id="adv_search[creator_id]" class="form-control input-sm">
                                  <?php
                                    $opt = '';
                                    $opt .= '<option value=""></option>';
                                    for ($i=0; $i < count($created_by); $i++) { 
                                      $opt .= '<option value='.$created_by[$i]->adm_id.'>'.$created_by[$i]->adm_name.'</option>';
                                    }
                                    echo $opt;
                                  ?>
                                </select>
                              </div>
                            </div>

                            <div class="form-group">
                              <div class = "col-md-12">
                                <button type="submit" class="btn btn-default btn btn-default col-md-3 col-md-offset-3">Show</button>
                                <button id = "reset" type="button" class="btn btn-default btn btn-default col-md-3 col-md-offset-1">Reset</button>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              <!--end collapsible!-->

              <!--start import form!-->
                <div class="row">
                  <div class="col-md-12" style="text-align: center">
                    <div id="import" class="collapse" style="margin:15px auto; width: 450px;">
                      <form id="importform" method="post" action="<?=base_url('panel/campaign/import')?>" enctype="multipart/form-data">
                        <div class="form-group">
                          <div class="input-group">
                            <input type="file" name="file" id="input-file" class="form-control">
                            <span class="input-group-btn">
                              <button class="btn btn-primary" id="btn-import" type="subtmi">Import</button>
                            </span>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              <!--end import form!-->
            <div class="action pull-right">
              <?php if($rules['d']){?>
              <a id="delete-all" title="Delete selected data" class="btn btn-danger btn-sm btn-circle"><i class="fa fa-trash"></i></a>
              <?php }?>
              <?php if($rules['c']){?>
              <a href="<?=base_url('panel/campaign/insert');?>" class="btn btn-success btn-sm btn-circle"><i class="fa fa-plus"></i> Create</a>
              <?php }?>
              <a style = "display : none;" data-toggle="collapse" data-target="#search" id = "advanced_search" name = "advanced_search" class = "btn btn-info btn-sm btn-circle"><i class="fa fa-search"></i>&nbsp;&nbsp;Search</a>
              <a style = "display : none;" href="#import" data-toggle="collapse" class="btn btn-success btn-sm btn-circle"><i class="fa fa-file-excel-o"></i> Import</a>
            </div>
          </div>
          <div class="box-body">
            <table id="campaign_table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="20px"></th>
                  <th width="70px;">NO</th>
                  <th>Campaign Name</th>
                  <th>Date Range</th>
                  <th>Created by</th>
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
    if (confirm( "Are you sure you want to delete the selected campaign?" )) {
      $.ajax({
          url : '<?php echo base_url("panel/campaign/delete"); ?>',
          type: "POST",
          data : {'c_id':[id]},
          dataType: 'json',
          success:function(data, textStatus, jqXHR){
              if(data.status){
                $().toastmessage('showToast', {
                  text     : 'Delete data success',
                  position : 'top-center',
                  type     : 'success',
                  close    : function () {
                    window.location = "<?=base_url('panel/campaign');?>";
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

    function reload_table() {
      $('#campaign_table').dataTable({
        "aLengthMenu":  [10, 25, 50, 100, 500, 1000, 2500, 5000],
        "ajax": {
                "url": "<?php echo base_url('panel/campaign'); ?>",
                "type": "POST",
                "data": data_builder()
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
        { "sClass": "center", "aTargets": [ 1 ], "data":1 },
        { "sClass": "center", "aTargets": [ 2 ], "data":2 },
        { "sClass": "center", "aTargets": [ 3 ], "data":3 },
        { "sClass": "center", "aTargets": [ 4 ], "data":4 },
        { "sClass": "center", "aTargets": [ 5 ],
          "mRender": function(data, type, full) {
            return '<a href=<?=base_url('panel/campaign/dashboard');?>/' + full[0] 
                + ' class="btn btn-default btn-xs btn-col icon-black"><i class="fa fa-search"></i> View' 
                <?php if($rules['e']){?>
                + '</a>'+'<a href=<?=base_url('panel/campaign/edit');?>/' + full[0] 
                + ' class="btn btn-info btn-xs btn-col icon-green"><i class="fa fa-pencil"></i> Edit' 
                <?php }?>
                <?php if($rules['d']){?>
                + '</a>'+'<a href="javascript:;" onclick="remove(\'' + full[0] + '\');" id="btn-delete" class="btn btn-danger btn-xs btn-col icon-black"><i class="fa fa-close"></i> ' + 'Delete' 
                <?php }?>
                + '</a>';
          },
          "bSortable": false
        },
        ],
        "destroy":true
      });
    }

    reload_table();

    function data_builder(){
      var data_set = {};
      var array = $("#search_form").serializeArray();
      $.each(array, function(key, val){
        data_set[val.name] = val.value;
      })
      return data_set;
    }

    $('form#search_form').on('submit', function(e) {
      e.preventDefault();
      reload_table();
    });

    //action to change all checkbox
    $('.check-all').change(function(){
      $('.check-item').prop('checked', $(this).prop('checked'));
    });
    //action to delete selected items
    $('#delete-all').click(function(){
      if (confirm( 'Are you sure you want to delete the selected campaign?' )) {
        var data = {};
        var c_id = [];
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
          c_id.push(parseInt($(el).val()));
        });

        data.c_id = c_id;

        $.ajax({
          url : '<?php echo base_url("panel/campaign/delete"); ?>',
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
                    window.location = "<?=base_url('panel/campaign');?>";
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


    var files;

    $('input[type=file]').on('change', function(event){
      files = event.target.files;
    });

    $('#importform').on('submit', function(event){
      event.preventDefault();
      var f = $('input[type=file]').val();
      if(f!==''){
        $('#loading').css( 'display', 'inline-block');

        var data = new FormData();
        $.each(files, function(key, value){
            data.append('file', value);
        });

        $.ajax({
            url: '<?=base_url('panel/campaign/import')?>',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(response){
              if(response.status){
                $().toastmessage('showToast', {
                    text     : 'Import data success, '+response.rows+' rows inserted',
                    position : 'top-center',
                    type     : 'success',
                    close    : function () {
                      reload_table()
                  }
                });
                console.log('existing extension: '+response.exist);
              }else{
                $().toastmessage('showToast', {
                    text     : 'Import data failed',
                    position : 'top-center',
                    type     : 'error'
                  });
              }
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log('ERRORS: ' + textStatus+' '+ jqXHR.responseText);
            },
            complete:function(){
              $('#loading').css( 'display', 'none');
              $('input[type=file]').val('');
            }
        });
      }
    });
  });

</script>