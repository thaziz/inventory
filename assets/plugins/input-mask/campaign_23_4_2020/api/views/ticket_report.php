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
      span.required, span.info{
        color: red;
      }
      .cus-field-info{
        margin-bottom: -2px;
        font-size: 1em;
        display: flex;
      }
      .flex{
        display: flex;
        flex-direction: row;
        align-items: stretch;
      }
      .flex-column{
        flex-direction: column;
      }
      .flex>div{
        flex-shrink: 1;
        padding: 15px; 
      }
      .info-value>span{
        font-weight: normal;
      }
      .p-0{
        padding: 0 !important;
      }
      .mt-5{
        margin-top: 5px !important;
      }
      .breadcrumb{
        margin-bottom: 5px !important;
        margin-right: 20px !important;
      }
      .neo-module-content{
        min-height: 400px;
      }
      .cus-detail tr>td:first-child{

      }
      .table-bordered > thead > tr > th{
        color: #333;
      }
      .cke_dialog{
        width: 400px !important;
      }
      .cke_dialog_contents{
        width: 100% !important;
      }
      input[type="text"].input-xs{
        padding: 3px 10px !important;
      }
      .dataTables_scrollBody thead th::before{
        display: none !important;
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
      .datepicker table tr:hover
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
<div class="col-md-12">
  <div class="form-group" style="display: flex;margin-bottom:7px;">
    <div class="col-md-2">
      <select id="jenis" class="sdate form-control input-sm" onchange="jenis()">
        <option selected="">Daily</option>
        <option>Weekly</option>
        <option>Monthly</option>
        <option>Quarterly</option>
        <option>Yearly</option>
      </select>
    </div>
	<div class="col-md-2 blnd">
	  <select onchange="year()" name="bulan" class="input-sm form-control bln hdn2" id="bln">
	    <option disabled="" selected="selected">Month</option>
	      <?php
	      
	        $bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	          $jlh_bln=count($bulan);
	          $t=1;
	          for($c=0; $c<$jlh_bln; $c+=1){
	              echo"<option value=$t>$bulan[$c]</option>";
	              $t++;
	          }
	      ?>
	  </select>
	</div>
    <div class="col-md-2 thnd">
            <select 
            style="width: 80%" onchange="year()" name="tahun1" class="input-sm form-control thn2 hdn2" id="thn">
                  <option disabled="" selected="selected">Year</option>
                  <?php
				
                  for($i=2040; $i>=2017; $i-=1){

						
						echo"<option > $i </option>";
						
						                              }
                  ?>
            </select>
    </div>
    <div class="col-md-2 weeklyd">
    	      <input onchange="weekly()" type="text" name="" id="weekly" class="form-control input-sm" autocomplete="off" placeholder="Weekly">
    </div>
                <div class="col-md-2 date-ranged">
                  
                  <input onchange="range()" placeholder="Date Range" type="text" name="s_date" id="date-range" class="sdate form-control input-sm" autocomplete="off" value="<?php echo $range ?>">
                </div>
              



             

            <div class="col-md-1">
                <button onclick="report()" class="btn btn-primary btn-sm" style="padding: 8px 10px !important; font-size: 16px;">
                  <i class="fa fa-search"></i>
                </button>
    		</div>
    		  </div>

</div>
                  </div>
              </div>
              <br>
              <div class="row" style="width: 99%">

                <div class="col-md-12 col-xs-12">
                 <table class="table table-bordered table-striped" style="width: 70%">  
                   <thead>
                     <tr>             
                       <th>Created Ticket</th>
                       <th>Open Ticket</th>
                       <th>Closed Ticket</th>
                       <th>Closed Time VS Created Ticket</th>
                     </tr>
                   </thead>
                   <tbody>
                    <tr id="report1">
                    </tr>
                  </tbody>
                </table>
                <hr>

                <table class="table table-bordered table-striped">
                 <thead>
                   <tr>             
                     <th>Call offered</th>
                     <th>Call answered <br>
                      <select id="agent" onchange="report_call()">
                       <option value=""> -- all agent -- </option>
                       <?php
                       foreach ($agent as $key => $value) {
                         echo '<option value="'.$value->number.'">'.$value->name.'</option>';
                       }
                       ?>
                     </select>
                   </th>
                     <th>Avr Handling time</th>
                     <th>Call abandon</th>
                     <th>Abandon IVR</th>
                   </tr>
                 </thead>
                 <tbody id="call_body">
               </tbody>
               <thead>
                 <tr>             
                   <th>Email received</th>
                   <th>Email reply</th>
                   <th>Time to Reply<br>(1x24 hour)</th>
                   <th>Time to Reply<br>(2x24 hour)</th>
                   <th>Time to Reply<br>(above 2x24 hour)</th>
                 </tr>
               </thead>
               <tbody id="email_body">
             </tbody>
           </table>
           <hr>

     </div>
           
<!-- filer rang -->
                

<div class="row" style="width: 99%">
<div class="col-md-12 col-xs-12">
<div id="search-form" class="collapse">
      <div class="flex" style="flex-direction: column;margin-left: -15px;justify-content: space-between;">
        <form id="search-form">
          <div class="col-md-8 col-md-offset-2">

            <!--   <div class="form-group" style="display: flex;margin-bottom:7px;">
                <label class="col-md-2">Date Range</label>
                <div class="col-md-4">
                  <input type="text" name="s_date" id="date-range" class="sdate form-control input-sm" autocomplete="off">
                </div>
              </div> -->
               <?php if($type=='kanmo'):?>
              <div class="form-group" style="display: flex;margin-bottom:7px;">
                <label class="col-md-2">Brand</label>
                <div class="col-md-4">
                    <select style="width: 100%" class="form-control" id="brand">
                        <option>-</option>
                        <?php foreach ($brands as $brand) {
                          echo "<option>".$brand->brand."</option>";
                        } ?>
                    </select>
                </div>
              </div>
                <?php endif ?>
              <div class="form-group" style="display: flex;margin-bottom:7px;">
                <label class="col-md-2">Source </label>
                <div class="col-md-4">
                  <select style="width: 100%" class="form-control" id="source">
                     <option>-</option>
                     <?php foreach ($sources as $source) {
                      echo "<option>".$source->source."</option>";
                    } ?>
                  </select>
                </div>
              </div>

              <div class="form-group" style="display: flex;margin-bottom:7px;">
                <label class="col-md-2">Main Category </label>
                <div class="col-md-4">
                       <select style="width: 95%" class="form-control" id="main_category">
                        <option>-</option>
                        <?php foreach ($main_categorys as $main_category) {
                          echo "<option>".$main_category->main_category."</option>";
                        } ?>
                      </select>
                </div>
              </div>
              <div class="form-group" style="display:flex;justify-content:center;">
                  <button id = "clear" type="button" class="btn btn-default">Clear</button>
                  <button type="button"  onclick="report_dt()" class="btn btn-primary btn-sm pull-right ml-20" style="padding: 8px 10px !important; font-size: 16px;">
                    <i class="fa fa-search"></i>
                  </button>
              </div>
          </div>
        </form>
      </div>
    </div>

<button type="button" onclick="export_data()" class="btn btn-success btn-sm pull-right btn-circle" style="padding: 2px 10px !important;">
                    <i class="fa fa-file-excel-o" style="font-size: 16px"></i> Export
</button>
 <button class="btn btn-primary btn-circle btn-sm pull-right ml-20" style="padding:2px 10px;" data-toggle="collapse" data-target="#search-form">Search <i class="fa fa-search"></i></button>








  </div>
</div>


                
            </div>

        </div>

        <table id="u_table" class="table table-bordered table-striped">
         <thead>
           <tr>             
             <th id="hd"></th>
             <?php if($type=='kanmo'){?>
             <th>Brand</th>
             <?php } ?>
             <th>Source</th>
             <th>Main Category</th>
             <th>Category</th>
             <?php if($type=='kanmo'){?>
             <th>Sub Category</th>
             <?php } ?>
             <th>Open Status</th>
             <th>Closed Status</th>
           </tr>
         </thead>
         <tbody id="report-detail">
          
         </tbody>
         <tfoot>
           <?php if($type=='kanmo'){?>
             <th colspan="6"></th>
           <?php }else{?>
            <th colspan="4"></th>
           <?php } ?>
           <th id="total_open"></th>
           <th id="total_closed"></th>
         </tfoot>
       </table>            


   </div>
 </div>
</div>
</div>
</div>


</section>  
<!-- CKEditor -->
<script src="<?=base_url()?>assets/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
  var periode='';
  var df='';
  var status='r';
  function chek(){
    var bulan=$('#bln').val();    
    var tahun=$('#thn').val();
    var minggu=$('#weekly').val();
    var range=$('#date-range').val();
    if(bulan=='Month' && tahun=='Year' && minggu=='' && range==''){
		
			
	      	alert('Field Is Required 2');
	      	return false;
		  
    }else{
    	if(bulan=='Month' || tahun=='Year'){
	    	$('#report1').html('');
		        $("#call_body").html('')
		        $("#email_body").html('')

		        $('#report-detail').html('');
		        $("#total_open").html('')
		        $("#total_closed").html('')
		        $('#report1').html('');
		        $("#call_body").html('')
		        $("#email_body").html('')

		        $('#report-detail').html('');
		        $("#total_open").html('')
		        $("#total_closed").html('')
    		 
			      	alert('Field Is Required 1');
			      	return false;
      			  
    	}
    }



  }
  	function year(){
  		$('#date-range').val('');
  		$('#weekly').val('');
  		status='y';
  	}

  	function weekly(){
  		$('#date-range').val('');
  		$('#bln').val('Month');
  		$('#thn').val('Year');
  		status='w';

  	}
  	function range(){
  		$('#weekly').val('');
  		$('#bln').val('Month');
  		$('#thn').val('Year');
  		status='r';
  	}
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

 /* $("#weekly").click(function() {

    $(".datepicker table tr").hover(
      function() {
        console.log('in');
          $('.datepicker table tr:hover').css('background-color','#808080');
      },
      function() {
         console.log('out');
            $('.datepicker table tr').css('background-color','#fff');
      }
    );
  });*/

$(function(){
   	$('#date-range').daterangepicker({autoUpdateInput:false,locale: {format: 'MMMM DD, YYYY', cancelLabel: 'Clear'}});
	  	$('#date-range').on('apply.daterangepicker', function(ev, picker) {
	  		range()
		    $(this).val(picker.startDate.format('MMMM DD, YYYY') + ' - ' + picker.endDate.format('MMMM DD, YYYY'));
		});
		$('#date-range').on('cancel.daterangepicker', function(ev, picker) {
		    $(this).val('');
		});
})
  jenis();

  function jenis(){
  	$('#weekly').val('');
  	$('#bln').val('Month');
    $('#thn').val('Year');
      var jenis=$('#jenis').val();
      if(jenis=='Quarterly'|| jenis=='Yearly'){

  	$('#date-range').val('');
         $('.thnd').css('display','');
        $('.weeklyd').css('display','none');
        $('.blnd').css('display','none');
        $('.date-ranged').css('display','none');
      }else if(jenis=='Daily'){
        $('.thnd').css('display','none');
        $('.weeklyd').css('display','none');
        $('.blnd').css('display','none');
        $('.date-ranged').css('display','');        
	  }else if(jenis=='Weekly'){

  	    $('#date-range').val('');
        $('.thnd').css('display','');
        $('.blnd').css('display','');
        $('.weeklyd').css('display','');	  
        $('.date-ranged').css('display','');
	  }else if(jenis=='Monthly'){

  	    $('#date-range').val('');
        $('.thnd').css('display','');
        $('.blnd').css('display','');
        $('.weeklyd').css('display','none');
        $('.date-ranged').css('display','');
	  }
	 
  }
  

  report();

  
  function report(){
  	chek();
    df=1;
      	var jenis=$('#jenis').val();
    var bulan=$('#bln').val();    
    var tahun=$('#thn').val();
    var minggu=$('#weekly').val();
    var range=$('#date-range').val();
     var datas = {
      'jenis'  : $('#jenis').val(),
      'status'		:status,
      'bulan'		:bulan,
      'tahun'		:tahun,
      'minggu'		:minggu,      
      'range'		:range,
      'default':df,
      'periode':periode,
      'periode_range':$('#date-range').val(),
       <?php if($type=='kanmo'){?>
      'brand'  : $('#brand').val(),
  	   <?php }?>
      'source' : $('#source').val(),
      'main_category' : $('#main_category').val(),
      'agent'		:$('#agent').val(),
      'jenis'		:jenis,
    };




    $.ajax({
      url: "<?php echo base_url('api/ticket_report/report/').$type."/3ec8112b9e277cf4d24c85136fc9ee95"; ?>",
      type: "POST",        
      data:datas, 
      dataType: "json",            
      success: function(response) {
         if(response=='error'){
         		$('#report1').html('');
		        $("#call_body").html('')
		        $("#email_body").html('')
		        $('#report-detail').html('');
		        $("#total_open").html('')
		        $("#total_closed").html('')
      			alert('Field Is Required');
      			return false;
      		
      		}      
      			report_call();
    			report_email();
    			datatable();         
        var html='';                  
        $.each(response, function(key, val){                    
          html='<td>'+val.total_create+'</td>';                    
          html+='<td>'+val.total_open+'</td>';                    
          html+='<td>'+val.total_closed+'</td>';                    
          html+='<td>'+val.co+'</td>';                    
        });

        $('#report1').html(html);
      },
      error: function(xhr) {
        alert('Something goes wrong, please call your aplication vendor')
      }
    })

  
  }
  function report_dt(){
    df=2;
    datatable();
  }
  function report_call(){
    var jenis=$('#jenis').val();
    var bulan=$('#bln').val();    
    var tahun=$('#thn').val();
    var minggu=$('#weekly').val();
    var range=$('#date-range').val();
     var datas = {
      'jenis'  : $('#jenis').val(),
      'status'		:status,
      'bulan'		:bulan,
      'tahun'		:tahun,
      'minggu'		:minggu,      
      'range'		:range,
      'default':df,
      'periode':periode,
      'periode_range':$('#date-range').val(),
       <?php if($type=='kanmo'){?>
      'brand'  : $('#brand').val(),
  	   <?php }?>
      'source' : $('#source').val(),
      'main_category' : $('#main_category').val(),
      'agent'		:$('#agent').val(),
      'jenis'		:jenis,
    };


    $.ajax({
      url:"<?=base_url('api/ticket_report/report_call/').$type?>",
      type: 'post',
      data: datas,
      dataType: 'json'
    })
    .done(function(res){

      $("#call_body").html('<tr><td>'+res.offer+'</td><td>'+res.answer+'</td><td>'+res.aht+'</td><td>'+res.abandoned+'</td><td>'+res.abn_ivr+'</td></tr>');
    })
    .fail(function(xhr){
       alert('Something goes wrong, please call your aplication vendor');
    })
  }
  
  function report_email(){
    var jenis=$('#jenis').val();
    var bulan=$('#bln').val();    
    var tahun=$('#thn').val();
    var minggu=$('#weekly').val();
    var range=$('#date-range').val();
     var datas = {
      'jenis'  : $('#jenis').val(),
      'status'		:status,
      'bulan'		:bulan,
      'tahun'		:tahun,
      'minggu'		:minggu,      
      'range'		:range,
      'default':df,
      'periode':periode,
      'periode_range':$('#date-range').val(),
       <?php if($type=='kanmo'){?>
      'brand'  : $('#brand').val(),
  	   <?php }?>
      'source' : $('#source').val(),
      'main_category' : $('#main_category').val(),
      'agent'		:$('#agent').val(),
      'jenis'		:jenis,
    };

    $("#email_body").html('<tr><td><i class="fa fa-circle-o-notch fa-spin fa-fw"></i></td><td><i class="fa fa-circle-o-notch fa-spin fa-fw"></i></td><td><i class="fa fa-circle-o-notch fa-spin fa-fw"></i></td><td><i class="fa fa-circle-o-notch fa-spin fa-fw"></i></td><td><i class="fa fa-circle-o-notch fa-spin fa-fw"></i></td></tr>');
    $.ajax({
      url:"<?=base_url('api/ticket_report/report_email/').$type?>",
      type: 'post',
      data: datas,
      dataType: 'json'
    })
    .done(function(res){

      $("#email_body").html('<tr><td>'+res.total+'</td><td>'+res.reply+'</td><td>'+res.reply24+'</td><td>'+res.reply224+'</td><td>'+res.replymore+'</td></tr>');
    })
    .fail(function(xhr){
       alert('Something goes wrong, please call your aplication vendor');
    })
  }

  function export_data(){
  	var datas = {
      'jenis'  : $('#jenis').val(),
      'date1' : $('#date1').val(),
      'date2' : $('#date2').val(),

      <?php if($type=='kanmo'){?>
      'brand'  : $('#brand').val(),
  <?php }?>
      'source' : $('#source').val(),
      'main_category' : $('#main_category').val(),
    };

    var form='<form id="export_form" method="post" action="">';
      $.each(datas, function(key, val){
        form += '<input type="hidden" name="'+key+'" value="'+val+'">';
      });
      form+='</form>';
      $(document.body).append(form);
      $('#export_form').attr('action','<?=base_url('api/ticket_report/export/').$type."/3ec8112b9e277cf4d24c85136fc9ee95";?>');
      $('#export_form').submit();
      $('#export_form').remove();
  }




  function datatable(){
  	  	var jenis=$('#jenis').val();
    var bulan=$('#bln').val();    
    var tahun=$('#thn').val();
    var minggu=$('#weekly').val();
    var range=$('#date-range').val();
     var datas = {
      'jenis'  : $('#jenis').val(),
      'status'		:status,
      'bulan'		:bulan,
      'tahun'		:tahun,
      'minggu'		:minggu,      
      'range'		:range,
      'default':df,
      'periode':periode,
      'periode_range':$('#date-range').val(),
       <?php if($type=='kanmo'){?>
      'brand'  : $('#brand').val(),
  	   <?php }?>
      'source' : $('#source').val(),
      'main_category' : $('#main_category').val(),
      'agent'		:$('#agent').val(),
      'jenis'		:jenis,
    };



    $('#hd').html($('#jenis').val()+" Level");

     $.ajax({
      url: "<?php echo base_url('api/ticket_report/data_table/').$type."/3ec8112b9e277cf4d24c85136fc9ee95"; ?>",
      type: "POST",        
      data:
      datas
      , 
      dataType: "json",            
      success: function(response) {      
        var html='';  
        var total_open=0;
        var total_closed=0;                
        $.each(response, function(key, val){
       
        if (val.brand == null){
            val.brand="-";
        }
        if (val.source == null){
            val.source="-";
        }
        if (val.main_category == null){
            val.main_category="-";
        }
        if (val.category == null){
            val.category="-";
            }
        if (val.sub_category == null){
            val.sub_category="-";
            }
        if ($('#jenis').val() =="Weekly"){
            val.date="Week "+val.date;
        }
        if ($('#jenis').val() =="Quarterly"){
            if(val.date==1){
              val.date="Q1 (Jan - Mar)";
            }
            else if(val.date==2){
              val.date="Q2 (April - June)";
            }
            else if(val.date==3){
              val.date="Q3 (July - Sept)";
            }
            else if(val.date==3){
              val.date="Q4 (Oct - Dec)";
            }
        }


          html+='<tr>';                  
          html+='<td>'+val.date+'</td>'; 
if("<?php echo $type; ?>"=="kanmo"){
          html+='<td>'+val.brand+'</td>';                    
  }

          html+='<td>'+val.source+'</td>';                    
          html+='<td>'+val.main_category+'</td>';                  
          html+='<td>'+val.category+'</td>'; 
          if("<?php echo $type; ?>"=="kanmo"){
          html+='<td>'+val.sub_category+'</td>'; 
          }
          html+='<td>'+val.total_open+'</td>'; 
          html+='<td>'+val.total_closed+'</td>'; 
          html+='</tr>';
          total_open+=parseInt(val.total_open);
          total_closed+=parseInt(val.total_closed);

        });



        $('#report-detail').html(html);
        $('#total_open').html('Total Open: '+total_open);
        $('#total_closed').html('total Closed: '+total_closed);
      },
      error: function(xhr) {
        alert('Something goes wrong, please call your aplication vendor')
      }
    })


  
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


