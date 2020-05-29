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
       <div class="col-md-2 date-ranged">    
          <input style="width: 80%"  placeholder="Date Range" type="text" name="s_date" id="date-range-atas" class="sdate form-control input-sm" autocomplete="off" " value="<?= date('F d, Y').' - '.date('F d, Y')?>" >
       </div>

       <div class="col-md-2">    
          <select class="select" id="level_atas" name="level_atas" style="width: 80%;height: 25px !important;">
                <option value="0">All</option>
                <option value="1">Meta Category</option>
                <option value="2">Main Category</option>
                <option value="3">Category</option>
                <option value="4">Sub Category</option>
          </select>
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
<div class="table-responsive">
<table id="u_table_atas" class="table table-bordered ">
         <thead id="dataHeadAtas">
           <tr>             
             <th >Meta Category</th>
             <th >Main Category</th>
             <th >Category</th>
             <th >Sub Category</th>
             <th >Grand Total</th>
             <th >%</th>
            </tr>
         </thead>
          <tbody id="dataReportAtas">
            
          </tbody>
</table>
</div>

              <br>

<div class="row">
  <div class="col-md-12">
    <div class="col-md-2 date-ranged">    
      <input  placeholder="Date Range" type="text" name="s_date" id="date-range" class="sdate form-control input-sm" autocomplete="off" " value="<?= date('F d, Y').' - '.date('F d, Y')?>"  >
    </div>
    <div class="col-md-2">    
          <select class="select" id="level" name="level" style="width: 80%;height: 25px !important;">
                <option value="0">All</option>
                <option value="1">Meta Category</option>
                <option value="2">Main Category</option>
                <option value="3">Category</option>
                <option value="4">Sub Category</option>
          </select>
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
<div class="table-responsive">
<table id="u_table" class="table table-bordered ">
         <thead id="dataHead">
           <tr>             
             <th rowspan="2">Meta Category</th>
             <th rowspan="2">Main Category</th>
             <th rowspan="2">Category</th>
             <th rowspan="2">Sub Category</th>
             <th colspan="3">Grand Total</th>
            </tr>
            <th>Open</th>
            <th>Close</th>
            <th>%</th>
         </thead>
          <tbody id="dataReport">
            
          </tbody>
</table>
</div>


<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>


           

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
      
        $(this).val(picker.startDate.format('MMMM DD, YYYY') + ' - ' + picker.endDate.format('MMMM DD, YYYY'));
    });
    $('#date-range').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
})



  $(function(){
    $('#date-range-atas').daterangepicker({autoUpdateInput:false,locale: {format: 'MMMM DD, YYYY', cancelLabel: 'Clear'}});
      $('#date-range-atas').on('apply.daterangepicker', function(ev, picker) {
      
        $(this).val(picker.startDate.format('MMMM DD, YYYY') + ' - ' + picker.endDate.format('MMMM DD, YYYY'));
    });
    $('#date-range-atas').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
})


  report();
  function report(){
    var range=$('#date-range').val();
    var level=$('#level').val();
     var datas = {
      'range'   :range,
      'level' :level,
     };
    $.ajax({
      url: "<?php echo base_url('api/master_reports/report/').$type."/3ec8112b9e277cf4d24c85136fc9ee95"; ?>",
      type: "POST",        
      data:datas, 
      dataType: "json",            
      success: function(response) {
  $html='';
  $head='';
  $('#dataReport').html('')

  $head+='<tr>';
  if(level==1 || level==2 || level==3 || level==4 || level==0){
        $head+='<th rowspan="2">Meta Category</th>';
  }
  if(level==2 || level==3 || level==4 || level==0){
        $head+='<th rowspan="2">Main Category</th>'
  }
  if(level==3 || level==4 || level==0){
        $head+='<th rowspan="2">Category</th>';
  }
  if(level==4 || level==0){
        $head+='<th rowspan="2">Sub Category</th>';
  }
  



  var j=7+(response.brands.length*2);

  $.each(response.brands, function(key, brand){                    
   $head+='<th colspan="2" align="center">'
        +brand.brand_name
        +'</th>'
  })
  $head+='<th colspan="3">Grand Total</th>'
        +'</tr>';

  $.each(response.brands, function(key, brand){                    
  $head+='<th>Open</th>'
         +'<th>Close</th>';
  })

  $head+='<th>Open</th>'
         +'<th>Close</th>'
         +'<th>%</th>';



  for (var i = 0; i < response.data.length; ++i) {


var css=''
if(response.data[i]['type']=='meta_c' || response.data[i]['type']=='main_c' ||
  response.data[i]['type']=='c'){
  var css=' style="font-weight: bold;"';
}
if(response.data[i]['type']=='akhir'){
  var css=' style="font-weight: bold; background:yellow"';
}
 $html+='<tr '+css+'>';
 if(level==1 || level==2 || level==3 || level==4 || level==0){
 $html+='<td class="meta">'
        +response.data[i]['meta_categorys']
        +'</td>';
 }
 if(level==2 || level==3 || level==4 || level==0){
 $html+='<td class="main">'
        +response.data[i]['main_categorys']
        +'</td>';
 }

 if(level==3 || level==4 || level==0){
 $html+='<td class="cat">'
        +response.data[i]['category']
        +'</td>';
 }
 if(level==4 || level==0){
 $html+='<td>'
        +response.data[i]['sub_category']
        +'</td>';
 }
  $.each(response.brands, function(key, brand){                    
        $html+='<td>'
        +response.data[i][brand.brand_name]['open']
        +'</td>'
        +'<td>'
        +response.data[i][brand.brand_name]['close']
        +'</td>';
  });
  $html+='<td>'
         +response.data[i]['open']
         +'</td>'
         +'<td>'
         +response.data[i]['close']
         +'</td>'
         +'<td>'
         +response.data[i]['presentase']
         +'</td>'
         +'</tr>';
  }


if(response.data.length==0){
    $('#dataReport').html('</tr><tr><td colspan="'+j+'" align="center"><i>No Data Found</i></td></tr>')
    
}else{
  $('#dataReport').html($html);
}

  
  $('#dataHead').html($head).after(function() {
    merge_data('td.meta');
    merge_data('td.main');
    merge_data('td.cat');

  });
      },
      error: function(xhr) {
        alert('Something goes wrong, please call your aplication vendor')
      }
    })
  }



function export_data(){
    var range=$('#date-range').val();
    var level=$('#level').val();
     var datas = {
      'range'   :range,
      'level' :level,
     };

    
    

    var form='<form id="export_form" method="post" action="">';
      $.each(datas, function(key, val){
        form += '<input type="hidden" name="'+key+'" value="'+val+'">';
      });
      form+='</form>';
      $(document.body).append(form);
      $('#export_form').attr('action','<?=base_url('api/master_reports/export/').$type."/3ec8112b9e277cf4d24c85136fc9ee95";?>');
      $('#export_form').submit();
      $('#export_form').remove();
  }


//ini belum atas
  report_atas();
  function report_atas(){

    var range=$('#date-range-atas').val();
    var level=$('#level_atas').val();
     var datas = {
      'range'   :range,
      'level' :level
     };
    $.ajax({
      url: "<?php echo base_url('api/master_reports/report_atas/').$type."/3ec8112b9e277cf4d24c85136fc9ee95"; ?>",
      type: "POST",        
      data:datas, 
      dataType: "json",            
      success: function(response) {
        
  $html='';
  $head='';
  var j=7+(response.brands.length*2);
  $('#dataReportAtas').html('')
  $head+='<tr>';
  if(level==1 || level==2 || level==3 || level==4 || level==0){
        $head+='<th>Meta Category</th>';
  }
  if(level==2 || level==3 || level==4 || level==0){
        $head+='<th>Main Category</th>'
  }
  if(level==3 || level==4 || level==0){
        $head+='<th>Category</th>';
  }
  if(level==4 || level==0){
        $head+='<th>Sub Category</th>';
  }
          
          
          
  
  $.each(response.brands, function(key, brand){                    
   $head+='<th>'
        +brand.brand_name
        +'</th>'
  })
  $head+='<th>Grand Total</th>'
  $head+='<th>%</th>'
        +'</tr>';

  
if(response.data.length){
$htlm='</tr><tr><td colspan="14" align="center"><i>No Data Found</i></td></tr>';
$('#dataReportAtas').html($html)
}
  

  for (var i = 0; i < response.data.length; ++i) {

var css=''
if(response.data[i]['type']=='meta_c' || response.data[i]['type']=='main_c' ||
  response.data[i]['type']=='c'){
  var css=' style="font-weight: bold;"';
}
if(response.data[i]['type']=='akhir'){
  var css=' style="font-weight: bold; background:yellow"';
}
  $html+='<tr '+css+'>';
if(level==1 || level==2 || level==3 || level==4 || level==0){
        $html+='<td class="meta">'
                +response.data[i]['meta_categorys']
                +'</td>';
}
if(level==2 || level==3 || level==4 || level==0){
        $html+='<td class="main">'
                +response.data[i]['main_categorys']
                +'</td>';
}
if(level==3 || level==4 || level==0){
        $html+='<td class="cat">'
                +response.data[i]['category']
                +'</td>';
}
if(level==4 || level==0){
        $html+='<td>'
                  +response.data[i]['sub_category']
               +'</td>';
}

  $.each(response.brands, function(key, brand){                    
        $html+='<td>'
               +response.data[i][brand.brand_name]
               +'</td>';
  });
  $html+='<td>'
         +response.data[i]['close']
         +'</td>'
         +'<td>'
         +response.data[i]['presentase']
         +'</td>'
         +'</tr>';
  }


  if(response.data.length==0){
        $('#dataReportAtas').html('</tr><tr><td colspan="'+j+'" align="center"><i>No Data Found</i></td></tr>')
    }else{
          $('#dataReportAtas').html($html)
    }


  
  $('#dataHeadAtas').html($head).after(function() {
        merge_dataa('td.meta');
        merge_dataa('td.main');
        merge_dataa('td.cat');
    });
   

      },
      error: function(xhr) {
        alert('Something goes wrong, please call your aplication vendor')
      }
    })
  }


  function export_data_atas(){
    var range=$('#date-range-atas').val();
    var level=$('#level_atas').val();
    var datas = {
      'range'   :range,
      'level' :level
     };

    var form='<form id="export_form" method="post" action="">';
      $.each(datas, function(key, val){
        form += '<input type="hidden" name="'+key+'" value="'+val+'">';
      });
      form+='</form>';
      $(document.body).append(form);
      $('#export_form').attr('action','<?=base_url('api/master_reports/export_data_atas/').$type."/3ec8112b9e277cf4d24c85136fc9ee95";?>');
      $('#export_form').submit();
      $('#export_form').remove();
  }



    function merge_data(sel){
      
      var span = 1;
       var prevTD = "";
       var prevTDVal = "";
       $("#u_table tr>"+sel).each(function() { //for each first td in every tr
          var $this = $(this);
          if ($this.text() == prevTDVal) { // check value of previous td text
             span++;
             
             if (prevTD != "") {
                prevTD.attr("rowspan", span); // add attribute to previous td
                $this.remove(); // remove current td
             }
          } else {
             prevTD     = $this; // store current td 
             prevTDVal  = $this.text();
             span       = 1;
          }
       });
    }

    function merge_dataa(sel){
      
      var span = 1;
       var prevTD = "";
       var prevTDVal = "";
       $("#u_table_atas tr>"+sel).each(function() { //for each first td in every tr
          var $this = $(this);
          if ($this.text() == prevTDVal) { // check value of previous td text
             span++;
             
             if (prevTD != "") {
                prevTD.attr("rowspan", span); // add attribute to previous td
                $this.remove(); // remove current td
             }
          } else {
             prevTD     = $this; // store current td 
             prevTDVal  = $this.text();
             span       = 1;
          }
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


