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
      #weekly .datepicker table tr:hover
       { 
        background-color:#808080
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
       <div class="col-md-1 date-ranged">    
            <select id="jenis" class="sdate form-control input-sm" onchange="jenis()">
              <option selected="">Date</option>
              <option>Range</option>
            </select>
       </div>
      <div class="col-md-1 date_calls">      	
         <input  placeholder="Date" type="text" name="tgl_d" id="tgl_d" class="sdate form-control input-sm" autocomplete="off" value="<?php echo date('Y-m-d') ?>" onchange="chekDate()">
      </div>


      <div class="col-md-2 range_calls" style="display: none;">

              <input  placeholder="Date Range" type="text" name="s_date" id="date-range" class="sdate form-control input-sm" autocomplete="off" value="<?php echo $range ?>" >
    </div>

    



    <!-- <div class="col-md-1">
           <select class="form-control" id="qeu" name="qeu">	           	
	           	<option >KANMO</option>
	           	<option >NESPRESSO</option>
           </select>
    </div> -->

       
  
    <!-- <div class="col-md-6"> -->
      <div class="form-group" style="display: flex;margin-bottom:7px;">
        <div class="col-md-5">
              <button type="button" onclick="export_data()" class="btn btn-success btn-sm pull-right btn-circle" style="padding: 2px 10px !important;">
                      <i class="fa fa-file-excel-o" style="font-size: 16px"></i> Export
              </button>
              <button  onclick="report()" class="btn btn-primary btn-circle btn-sm pull-right ml-20" style="padding:2px 10px;">Search <i class="fa fa-search"></i>
              </button>
        </div>
      </div>
    <!-- </div> -->
    </div>
</div>

<br>
<br>
<label><strong ><div class="cccb"></div></label>
<div class="table-responsive">

<table  id="agent_report_activity" class="table table-striped table-sm mb-0">
              <thead>
                <tr>                  
                  <th  class="lg_hide">Date</th>
                  <th >Agent's name</th>
                  <th >Inbound Calls</th>
                  <th >Outgoing Call</th>
                  <th >Call Type</th>
                  <th >Total Calls</th>
                 
                </tr>

              </thead>
              <tbody id="tbody-agent-act">

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
    $('#date-range').daterangepicker({autoUpdateInput:false,locale: {format: 'MMMM DD, YYYY', cancelLabel: 'Clear'}});
      $('#date-range').on('apply.daterangepicker', function(ev, picker) {
      	$('#tgl_d').val('');
        $(this).val(picker.startDate.format('MMMM DD, YYYY') + ' - ' + picker.endDate.format('MMMM DD, YYYY'));
    });
    $('#date-range').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
})

$("#tgl_d").datepicker({
      format: 'yyyy-mm-dd',      
      autoclose: true
          /*format: 'MM dd, yyyy',*/
    });

  $("#weekly").datepicker({
      format: 'yyyy-mm-dd',
      calendarWeeks:true,
       autoclose: true
          /*format: 'MM dd, yyyy',*/
    });
  $('#weekly').on('change', function (e) {
    value = $("#weekly").val();
    firstDate = moment(value, "YYYY-MM-DD").day(0).format("YYYY-MM-DD");
    lastDate =  moment(value, "YYYY-MM-DD").day(6).format("YYYY-MM-DD");
    if(firstDate!='Invalid date'){
      $("#weekly").val(firstDate + "  -  "+lastDate);
    }else{
      $("#weekly").val('');
    }
});

$("#monthly").datepicker( {
    format: "mm-yyyy",
    viewMode: "months", 
    minViewMode: "months"
});

  jenis();

  function jenis(){
    var jenis=$('#jenis').val();
    if(jenis=='Date'){
      $('.date_calls').css('display','');
      $('.range_calls').css('display','none');
      
    }
    else if(jenis=='Range'){
      $('.date_calls').css('display','none');
      $('.range_calls').css('display','');

    }
  }

function chekDate(){	
	$('#date-range').val('');
}


report();
function report(){
  $('#tbody-agent-act').html('');   
  var jenis=$('#jenis').val();  
    if(jenis=='Date'){      
      $('.cccb').html('Calls Date');
    	var tgl=$('#tgl_d').val()+' - '+$('#tgl_d').val();
    }
    else if(jenis=='Range'){

      $('.cccb').html('Calls Range');
        var tgl=$('#date-range').val();
      }      
   

            $.ajax({
                  url:"<?php echo base_url('report_calls/data/').$type; ?>",
                  type: 'GET',
                  dataType: 'json',
                  data: 'tanggal='+tgl+'&jenis='+jenis,
                }).done(function(res){
          
          
          if(res.agent_a.length<1){
                $('#tbody-agent-act').html('<tr><td class="text-center" colspan="11"><i>No Data Available</i></td></tr>');
          }else{

          var tr='';
          var rank=1;
          for (var i = 0 ; i < res.agent_a.length ; i++) {     
          //console.log(res.agent_a[i]["name"]);return false;     
                tr += '<tr>';
                tr += '<td class="lg_hide">'+res.date+'</td>';
                tr += '<td>'+res.agent_a[i]["name"]+'</td>';
                //tr += '<td>'+results[i]['total_login']+'</td>';
                tr += '<td>'+res.agent_a[i]["incoming"]+'</td>';
                tr += '<td>'+res.agent_a[i]["outgoing"]+'</td>';
                tr += '<td>'+res.agent_a[i]["type"]+'</td>';
                
                tr += '<td>'+res.agent_a[i]["total_calls"]+'</td>';
                
                tr += '</tr>';
                rank++;
                
          }
          
          $('#tbody-agent-act').html(tr);

        }
      $('.lg_hide').css('display',res.hide)

          

                }).fail(function(xhr, status, error){
                  alert('Something goes wrong, please call your aplication vendor');
                });

}


  
  function export_data(){
    var jenis=$('#jenis').val();
    if(jenis=='Date'){      
      $('.cccb').html('Calls Date');
      var tgl=$('#tgl_d').val()+' - '+$('#tgl_d').val();
    }
    else if(jenis=='Range'){

      $('.cccb').html('Calls Range');
        var tgl=$('#date-range').val();
      }      
   
    
     var datas = {
      'tanggal'   :tgl,
      'jenis'    :jenis,
     };

    
    

    var form='<form id="export_form" method="GET" action="">';
      $.each(datas, function(key, val){
        form += '<input type="hidden" name="'+key+'" value="'+val+'">';
      });
      form+='</form>';
      $(document.body).append(form);
      $('#export_form').attr('action','<?=base_url('report_calls/export/').$type."/3ec8112b9e277cf4d24c85136fc9ee95";?>');
      $('#export_form').submit();
      $('#export_form').remove();
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


