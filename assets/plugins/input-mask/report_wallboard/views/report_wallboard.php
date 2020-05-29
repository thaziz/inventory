<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/iCheck/all.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
  <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.css"> -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
    <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/toastMessage/css/jquery.toastmessage.css"> -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/ticket.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/style.css">

    <script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js
      "></script>
  <script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>

    <!-- Bootstrap 3.3.6 -->
    <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
    <style type="text/css">
    #u_table {
      font-size: .9em;
    }
    #u_table th{
      font-weight: bold;
      color: #333;
      background: #ccc;
    }
    #u_table th, #u_table td{
      padding: 3px 5px;
    }

    #u_table_atas {
      font-size: .9em;
    }
    #u_table_atas th{
      font-weight: bold;
      color: #333;
      background: #ccc;
    }
    #u_table_atas th, #u_table_atas td{
      padding: 3px 5px;
    }
    /*.dataTables_wrapper.no-footer>.row:last-child>div{
      float: left;
      height: 60px;
      }*/
      .dataTables_wrapper .dataTables_info.dataTables_info, .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter{
        display: none;
      }
      .dataTables_wrapper.no-footer>.row:last-child>div:last-child{
        border-left: 1px solid #ebebeb;
        border-radius: 0 0 3px 3px;
        background-color: #fafafa;
        width: 99% !important;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <section class="content" style="display: ;">
      <!-- Content -->
      <div class="row" style="width: 97%;display: block">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-body">

<div class="row">
    <div class="col-md-12">
       <div class="col-md-3 date-ranged">              
           <input  placeholder="Date Range" type="text" name="s_date" id="date-range" class="sdate form-control input-sm" autocomplete="off" value="<?=date('d-m-Y'); ?>">
       </div>
    <div class="col-md-6">
      <div class="form-group" style="display: flex;margin-bottom:7px;">
        <div class="col-md-5">
              <button type="button" onclick="export_data()" class="btn btn-success btn-sm pull-right btn-circle" style="padding: 2px 10px !important;">
                      <i class="fa fa-file-excel-o" style="font-size: 16px"></i> Export
              </button>
              <button  onclick="report()" class="btn btn-primary btn-circle btn-sm pull-right ml-20" style="padding:2px 10px;">Search <i class="fa fa-search"></i>
              </button>
        </div>
      </div>
    </div>
    </div>
</div>

<br>
<br>

<div class="row">
    <div class="col-md-12">
       <div class="col-md-3 date-ranged">              
           <input  placeholder="Date Range" type="text" name="s_date" id="date-range1" class="sdate form-control input-sm" autocomplete="off" value="<?php echo date('M d, Y').' - '.date('M d, Y'); ?>">
       </div>
    <div class="col-md-6">
      <div class="form-group" style="display: flex;margin-bottom:7px;">
        <div class="col-md-5">   
             <button type="button" onclick="export_data_atas()" class="btn btn-success btn-sm pull-right btn-circle" style="padding: 2px 10px !important;">
                      <i class="fa fa-file-excel-o" style="font-size: 16px"></i> Export
              </button>          
              <button  onclick="report_atas()" class="btn btn-primary btn-circle btn-sm pull-right ml-20" style="padding:2px 10px;">Search <i class="fa fa-search"></i>
              </button>
        </div>
      </div>
    </div>
    </div>
</div>

<br>
<br>


<table  class="table table-striped table-sm mb-0">
              <thead>
                <tr>
                  <th >Inbound (%)</th>
                  <th >Serviced (%)</th> 
                  <!-- <th >AHT</th> -->
                  <!-- <th >Total Calls</th> -->
                  <th >Answered Calls</th>
                  <th >Abandoned Calls</th> 
                  <th >Offered Calls</th>
                  <th >SLA</th> 
                  <th >early Abandoned</th>
                  <th >Abandoned IVR</th>
                  <th >Abn Call Reachout</th>
                  <th >Abn Call Unique</th>
                </tr>

              </thead>
              <tbody id="call">

              </tbody>
            </table>

<br>
<br>

<div class="row">
    <div class="col-md-12">       
      <div class="col-md-3 daily">
        <input placeholder="Date" type="text" name="s_date" id="date-range2" class="sdate form-control input-sm" autocomplete="off"  value="<?= date('d-m-Y'); ?>" >
      </div>
      <div class="col-md-6">
      <div class="form-group" style="display: flex;margin-bottom:7px;">
        <div class="col-md-5">  
             <button type="button" onclick="export_data_bawah()" class="btn btn-success btn-sm pull-right btn-circle" style="padding: 2px 10px !important;">
                      <i class="fa fa-file-excel-o" style="font-size: 16px"></i> Export
              </button>           
              <button  onclick="report_bawah()" class="btn btn-primary btn-circle btn-sm pull-right ml-20" style="padding:2px 10px;">Search <i class="fa fa-search"></i>
              </button>
        </div>
      </div>
    </div>
    </div>
</div>
<br>
<br>
<label><strong>Agent Activity</strong></label>
<div class="table-responsive">

<table onclick="showhiden()" id="agent_report_activity" class="table table-striped table-sm mb-0">
              <thead>
                <tr>
                  <th rowspan = "2">Agent Name</th>
                  <th rowspan = "2">Login Time</th>
                  <th style="display: none;" rowspan = "2">Total Login Time</th>
                  <th rowspan = "2">Incoming Calls</th>
                  <th rowspan = "2">Outgoing Calls</th>
                  <th rowspan = "2">Agent Abandoned</th>
                  <th rowspan = "2">Total Minutes</th>
                  <th rowspan = "2">AVG Handling Time</th>
                  <th rowspan = "2">Total Follow UP</th>
                  <th rowspan = "2">Total Break</th>
                  <th rowspan = "2">Total Other</th>
                </tr>

              </thead>
              <tbody id="tbody-agent-act">

              </tbody>
            </table>


</div>

              <br>
              <br>


<div class="table-responsive">

  <table id="agent_report_activity" class="table table-striped table-sm mb-0">
              <thead id="head-break-down">
                              
              </thead>
              <tbody id="tbody-break-down">

              </tbody>
  </table>
</div>

<br>
<br>

<label><strong>Agent Level Tickets</strong></label>
<div class="table-responsive">

<table id="agent_report" class="table table-striped table-sm mb-0">
              <thead >
                              <th>Agent Name</th>
                              <th>Number of Tickets raised</th>
                              <th>No of Tickets Closed</th>
                              <th>Average Ticket closed time</th>
                              <th>Number of Comments</th>
                              <th>Closed <5 days'</th>
                              <th>Closed <10 Days </th>
                              <th>Open >  5 days'</th>
                              <th>Open> 10 Days</th>
                              <th>All Open</th>

              </thead>
              <tbody id="data-table">

              </tbody>
            </table>
          </div>
           

        </div>

        



   </div>
 </div>
</div>
</div>
</div>

</section>  
<!-- CKEditor -->
<script src="<?=base_url()?>assets/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript">

$(function(){
    $('#date-range1').daterangepicker({autoUpdateInput:false,locale: {format: 'MMMM DD, YYYY', cancelLabel: 'Clear'}});
      $('#date-range1').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MMMM DD, YYYY') + ' - ' + picker.endDate.format('MMMM DD, YYYY'));
    });
    $('#date-range1').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
})

$(function(){
    $('#date-range2').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
      });
})
  
$(function(){
    $('#date-range').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
      });
})



report();
function report(){
var tgl=$('#date-range').val();
            $.ajax({
                  url:"<?php echo base_url('report_wallboard/data/').$type; ?>",
                  type: 'GET',
                  dataType: 'json',
                  data: 'tanggal='+tgl,
                }).done(function(res){

          var tr='';

          
          tr += '<tr>';
          tr += '<td>'+res.call.m+'</td>';
          tr += '<td>'+res.call.k+'</td>';
          /*tr += '<td>'+res.call.j+'</td>';*/
          /*tr += '<td>'+res.call.l+'</td>';*/
          tr += '<td>'+res.call.a+'</td>';
          tr += '<td>'+res.call.b+'</td>';
          tr += '<td>'+res.call.c+'</td>';
          tr += '<td>'+res.call.d+'</td>';
          tr += '<td>'+res.call.e+'</td>';
          tr += '<td>'+res.call.f+'</td>';
          tr += '<td>'+res.call.i+'</td>';          
          tr += '<td>'+res.call.g+'('+res.call.h+')</td>';
          tr += '</tr>';
        

          $('#call').html(tr);




          if(res.agent_a.length<1){
$('#tbody-agent-act').html('<tr><td class="text-center" colspan="9"><i>No Data Available</i></td></tr>');
          }else{
          var tr='';
          $.each(res.agent_a, function(i, m){
          tr += '<tr>';
          tr += '<td>'+m.name+'</td>';
          tr += '<td>'+m.login+'</td>';
          //tr += '<td>'+results[i]['total_login']+'</td>';
          tr += '<td>'+m.incoming+'</td>';
          tr += '<td>'+m.outgoing+'</td>';
          tr += '<td>'+m.abandoned_in_number+'</td>';
          tr += '<td>'+m.total_minutes+'</td>';
          tr += '<td>'+m.avg+'</td>';
          tr += '<td>'+m.follow+'</td>';
          tr += '<td>'+m.break+'</td>';
          tr += '<td>'+m.other+'</td>';
          tr += '</tr>';
          });
          $('#tbody-agent-act').html(tr);
        }
      
      







            $headBreak='<th>Agent Name</th>';

            $.each(res.breakdown_fu.break, function(i, v){
                $headBreak+='<th>'+v.description+'</th>';
            })
            
            $('#head-break-down').html('');
            $('#head-break-down').html($headBreak);

if(res.breakdown_fu.data.length<1){
$('#tbody-break-down').html('<tr><td class="text-center" colspan="6"><i>No Data Available</i></td></tr>');
}else{
  
            $headBreak='';

            $.each(res.breakdown_fu.data, function(i, c){   
                $headBreak+='<tr >';
                $headBreak+='<td>'+c.name+'</td>';
                
              $.each(res.breakdown_fu.break, function(m, e){  
                if(c[e.description]==null){
                $headBreak+='<td style="vertical-align: middle;" align="center"  class="meta">00:00:00</td>'; 
                }else{
                $headBreak+='<td style="vertical-align: middle;" align="center" rowspan=" class="cat">'+c[e.description]+'</td>';
                }
                
              })
              
                $headBreak+='</tr>';
            })
            $('#tbody-break-down').html('');
            $('#tbody-break-down').html($headBreak);  
}

             var detail='';
    var $headBreak='';
if(res.agent_lt.length<1){
$('#data-table').html('<tr><td class="text-center" colspan="10"><i>No Data Available</i></td></tr>');
}else{
        $.each(res.agent_lt, function(i, v){
                $headBreak+='<tr><td>'+v.agent+'</td>';
                $headBreak+='<td>'+v.raised+'</td>';
                $headBreak+='<td>'+v.closed+'</td>';
                $headBreak+='<td>'+v.avg+'</td>';
                $headBreak+='<td>'+v.comment+'</td>';
                $headBreak+='<td>'+v.closed_day5+'</td>';
                $headBreak+='<td>'+v.closed_day10+'</td>';
                $headBreak+='<td>'+v.open_day5+'</td>';
                $headBreak+='<td>'+v.open_day10+'</td>';
                $headBreak+='<td>'+v.open_all+'</td></tr>';
    })

                    $('#data-table').html('');
                    $('#data-table').html($headBreak);
                    
   }                }).fail(function(xhr, status, error){
                  alert('Something goes wrong, please call your aplication vendor');
                });

}


  
  function export_data(){
    var tanggal=$('#date-range').val();
     var datas = {
      'tanggal'   :tanggal,
     };

    var form='<form id="export_form" method="post" action="">';
      $.each(datas, function(key, val){
        form += '<input type="hidden" name="'+key+'" value="'+val+'">';
      });
      form+='</form>';
      $(document.body).append(form);
      $('#export_form').attr('action','<?=base_url('report_wallboard/export/').$type."/3ec8112b9e277cf4d24c85136fc9ee95";?>');
      $('#export_form').submit();
      $('#export_form').remove();
  }



  function export_data_bawah(){
    var tanggal=$('#date-range2').val();
     var datas = {
      'tanggal'   :tanggal,
     };

    var form='<form id="export_form" method="post" action="">';
      $.each(datas, function(key, val){
        form += '<input type="hidden" name="'+key+'" value="'+val+'">';
      });
      form+='</form>';
      $(document.body).append(form);
      $('#export_form').attr('action','<?=base_url('report_wallboard/report_wallboard/export_bawah/').$type."/3ec8112b9e277cf4d24c85136fc9ee95";?>');
      $('#export_form').submit();
      $('#export_form').remove();
  }


  function export_data_atas(){
    var tanggal=$('#date-range1').val();
     var datas = {
      'tanggal'   :tanggal,
     };

    var form='<form id="export_form" method="post" action="">';
      $.each(datas, function(key, val){
        form += '<input type="hidden" name="'+key+'" value="'+val+'">';
      });
      form+='</form>';
      $(document.body).append(form);
      $('#export_form').attr('action','<?=base_url('report_wallboard/report_wallboard/export_atas/').$type."/3ec8112b9e277cf4d24c85136fc9ee95";?>');
      $('#export_form').submit();
      $('#export_form').remove();
  }


  //atas
  function report_atas(){
var tgl=$('#date-range1').val();
      $.ajax({
          url:"<?php echo base_url('report_wallboard/report_wallboard/data_atas/').$type; ?>",
          type: 'GET',
          dataType: 'json',
          data: 'tanggal='+tgl,
        }).done(function(res){
            var tr='';
            tr += '<tr>';
            tr += '<td>'+res.call.m+'</td>';
            tr += '<td>'+res.call.k+'</td>';
            /*tr += '<td>'+res.call.j+'</td>';*/
            /*tr += '<td>'+res.call.l+'</td>';*/
            tr += '<td>'+res.call.a+'</td>';
            tr += '<td>'+res.call.b+'</td>';
            tr += '<td>'+res.call.c+'</td>';
            tr += '<td>'+res.call.d+'</td>';
            tr += '<td>'+res.call.e+'</td>';
            tr += '<td>'+res.call.f+'</td>';
            tr += '<td>'+res.call.i+'</td>';          
            tr += '<td>'+res.call.g+'('+res.call.h+')</td>';
            tr += '</tr>';
            $('#call').html(tr);
    }).fail(function(xhr, status, error){
      alert('Something goes wrong, please call your aplication vendor');
    });

}



  function export_data_atas(){
    var tanggal=$('#date-range1').val();
     var datas = {
      'tanggal'   :tanggal,
     };

    var form='<form id="export_form" method="post" action="">';
      $.each(datas, function(key, val){
        form += '<input type="hidden" name="'+key+'" value="'+val+'">';
      });
      form+='</form>';
      $(document.body).append(form);
      $('#export_form').attr('action','<?=base_url('report_wallboard/report_wallboard/export_atas/').$type."/3ec8112b9e277cf4d24c85136fc9ee95";?>');
      $('#export_form').submit();
      $('#export_form').remove();
  }


function report_bawah(){
     $('#tbody-agent-act').html('');
     $('#tbody-break-down').html('');
     $('#data-table').html('');  
    var tgl=$('#date-range2').val();
          $.ajax({
              url:"<?php echo base_url('report_wallboard/report_wallboard/data_bawah/').$type; ?>",
              type: 'GET',
              dataType: 'json',
              data: 'tanggal='+tgl,
            }).done(function(res){

          if(res.agent_a.length<1){
    $('#tbody-agent-act').html('<tr><td class="text-center" colspan="9"><i>No Data Available</i></td></tr>');
          }else{
          var tr='';
          $.each(res.agent_a, function(i, m){
          tr += '<tr>';
          tr += '<td>'+m.name+'</td>';
          tr += '<td>'+m.login+'</td>';
          //tr += '<td>'+results[i]['total_login']+'</td>';
          tr += '<td>'+m.incoming+'</td>';
          tr += '<td>'+m.outgoing+'</td>';
          tr += '<td>'+m.abandoned_in_number+'</td>';
          tr += '<td>'+m.total_minutes+'</td>';
          tr += '<td>'+m.avg+'</td>';
          tr += '<td>'+m.follow+'</td>';
          tr += '<td>'+m.break+'</td>';
          tr += '<td>'+m.other+'</td>';
          tr += '</tr>';
          });
          $('#tbody-agent-act').html(tr);
        }
      
      
            $headBreak='<th>Agent Name</th>';
            $.each(res.breakdown_fu.break, function(i, v){
                $headBreak+='<th>'+v.description+'</th>';
            })
            $('#head-break-down').html('');
            $('#head-break-down').html($headBreak);

      if(res.breakdown_fu.data.length<1){
      $('#tbody-break-down').html('<tr><td class="text-center" colspan="6"><i>No Data Available</i></td></tr>');
      }else{
        
            $headBreak='';

            $.each(res.breakdown_fu.data, function(i, c){   
                $headBreak+='<tr >';
                $headBreak+='<td>'+c.name+'</td>';
                
              $.each(res.breakdown_fu.break, function(m, e){  
                if(c[e.description]==null){
                $headBreak+='<td style="vertical-align: middle;" align="center"  class="meta">00:00:00</td>'; 
                }else{
                $headBreak+='<td style="vertical-align: middle;" align="center" rowspan=" class="cat">'+c[e.description]+'</td>';
                }
                
              })
              
                $headBreak+='</tr>';
            })
            $('#tbody-break-down').html('');
            $('#tbody-break-down').html($headBreak);  
}

            var detail='';
        var $headBreak='';
    if(res.agent_lt.length<1){
    $('#data-table').html('<tr><td class="text-center" colspan="10"><i>No Data Available</i></td></tr>');
    }else{
        $.each(res.agent_lt, function(i, v){
                $headBreak+='<tr><td>'+v.agent+'</td>';
                $headBreak+='<td>'+v.raised+'</td>';
                $headBreak+='<td>'+v.closed+'</td>';
                $headBreak+='<td>'+v.avg+'</td>';
                $headBreak+='<td>'+v.comment+'</td>';
                $headBreak+='<td>'+v.closed_day5+'</td>';
                $headBreak+='<td>'+v.closed_day10+'</td>';
                $headBreak+='<td>'+v.open_day5+'</td>';
                $headBreak+='<td>'+v.open_day10+'</td>';
                $headBreak+='<td>'+v.open_all+'</td></tr>';
      })
                    
                    $('#data-table').html($headBreak);
                    
      }   

                }).fail(function(xhr, status, error){
                  alert('Something goes wrong, please call your aplication vendor');
                });

}






  </script>
  <!-- iCheck 1.0.1 -->
  <script src="<?php echo base_url(); ?>assets/plugins/iCheck/icheck.min.js"></script>
  <!-- Select2 -->
  <script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
  <!-- Toast Message -->
  <script src="<?php echo base_url(); ?>assets/plugins/toastMessage/js/jquery.toastmessage.js"></script>
</body>
</html>


