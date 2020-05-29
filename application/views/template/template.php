<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Outbound Call | First Routes</title>

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Toas message -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/toastMessage/css/jquery.toastmessage.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/iCheck/all.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/year-calendar/css/bootstrap-year-calendar.min.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/style.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css">
  <style>
    /*html{
      zoom: 90%;
    }
    @media only screen and (max-width:1024px){
        html{
          zoom: 80%;
        }
    }*/
    .navbar-nav.navbar-main>li>.dropdown-menu{padding: 0;height: auto !important;}
    .navbar-nav.navbar-main>li>.dropdown-menu li{border-top: 1px solid #efefef;}
    .navbar-nav.navbar-main>li>.dropdown-menu li:first-of-type{border-top: none;}
    .navbar-nav.navbar-main>li>.dropdown-menu li>a, .navbar-custom-menu>.navbar-nav>li>.dropdown-menu li>a{padding: 10px;}
  </style>
  <script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
  <script>
    var base_url  = "<?php echo base_url(); ?>";
  </script>
</head>
    <body class="hold-transition skin-red-light sidebar-mini fixed">
        <div class="wrapper">
        <!-- BEGIN HEADER -->
        <?=$_header?>
        <!-- END HEADER -->
        <!-- BEGIN SIDEBAR -->
        <?=$_sidebar?>
        <!-- END SIDEBAR -->
        <!-- Content Wrapper. Contains page content -->
        
            <!-- Content Header (Page header) -->
            

            <!-- Main content -->
            
            <!-- BEGIN CONTENT -->
            <?=@$_content;?>
    		<!-- END CONTENT -->
            
            <!-- /.content -->
         
          <!-- /.content-wrapper -->

        <!-- BEGIN FOOTER -->
        <?=$_footer?>
        <!-- END FOOTER -->
        </div>
        
        <!-- Bootstrap 3.3.6 -->
        <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
        <!-- FastClick -->
        <script src="<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url(); ?>assets/dist/js/app.min.js"></script>
        <!-- SlimScroll 1.3.0 -->
        <script src="<?php echo base_url(); ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- Toast Message -->
        <script src="<?php echo base_url(); ?>assets/plugins/toastMessage/js/jquery.toastmessage.js"></script>
        <!-- iCheck 1.0.1 -->
        <script src="<?php echo base_url(); ?>assets/plugins/iCheck/icheck.min.js"></script>
        <!-- Select2 -->
        <script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
        <!-- ChartJS 1.0.1 -->
        <script src="<?php echo base_url(); ?>assets/plugins/chartjs/Chart.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/year-calendar/js/bootstrap-year-calendar.js"></script>
        <?php
          if (isset($this->session->userdata['logged_in'])) {
        ?>
            <!-- <script type="text/javascript" src="<?php //echo base_url(); ?>assets/dist/js/check_session.js">
            </script> -->
        <?php
          }
        ?>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->

        <script type="text/javascript">
          $(function(){
              $('select.select2').select2({
                dropdownAutoWidth : true,
                width: '100%'
              });
              $('input[type="checkbox"].icheck, input[type="radio"].icheck').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
              });
              $('.number-only').keypress(function (e) {
                  $(this).next('.info').html('');
                  if (String.fromCharCode(e.which).match(/[^0-9]/g)&&e.which!=0&&e.which!=8&&e.which!=13){
                    $(this).next('.info').html('<div class="has-error">Input number only</div>');
                   return false;
                  }
              });
              $('.number-only').focusout(function(){
                $(this).next('.info').html('');
              });
              $('.allow-decimal').focusout(function(){
                $(this).next('.info').html('');
              });
              $('.allow-decimal').keypress(function(e) {
                  if (String.fromCharCode(e.which).match(/[^0-9\.]/g)&&e.which!=0&&e.which!=8&&e.which!=13){
                    $(this).next('.info').html('<div class="has-error">Input decimal only</div>');
                   return false;
                  }else{
                    $(this).next('.info').html('');
                  }
              });
              function check(v){
                $("#ajax-loading").hide();
                $.ajax({
                  url:'<?=base_url('panel/download/check')?>/'+v,
                  type: 'post',
                  dataType: 'json',
                  success: function(data){
                    if(data.status){
                      var html = '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'+
                          '<i class="fa fa-bell-o"></i>'+
                          ((data.bedge)?'<span class="label label-warning">'+data.count+'</span>':'')+
                          '</a><ul class="dropdown-menu" style="height: auto; width: auto">';
                          $.each(data.files, function(i,v){
                            var color = '';
                            var file_name = '';
                            //alert(v.substr(v.length-6, 6));
                            if(v.substr(v.length-6, 6)=='n.xlsx'){
                              file_name = v.substr(0,v.length-6)+'.xlsx';
                              color='class="bg-success"';
                            }else{
                              file_name = v;
                            }
                            html+= '<li '+color+'><a href="<?=base_url('panel/download/download/')?>'+v+'" id="download"><i class="fa fa-download text-aqua"></i> <span>Your file '+file_name+' is ready to download</span></a></li>';
                          });
                          html += '</ul>';
                      $('#notifications').html(html);
                    }else{
                      $('#notifications').html('');
                    }
                  },
                  beforeSend: function(){
                    $("#ajax-loading").hide();
                  }
                });
              }
              check(0);
              setInterval(function() {
                check(0);
              }, 30000);
          });
            window.loading = $("#ajax-loading").hide();
            $(document)
              .ajaxStart(function () {
                window.loading.show();
              })
              .ajaxStop(function () {
                window.loading.hide();
              });
        </script>
    </body>
</html>