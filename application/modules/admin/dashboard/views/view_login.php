<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Outbound Call | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/iCheck/square/blue.css">

  <style type="text/css">
      html, body{
        height: auto;
      }
      a.refresh{
        font-size: 20px;
        margin-left: 10px;
        top: 5px;
        position: relative;
        cursor: pointer;
      }
      .captcha{
        margin-top: -3px;
      }
      .login-box-msg{
        color: red;
      }
      .login-logo img{
        max-width: 70%;
        height:auto;
      }
      .text-copy{
        text-align: center;
        font-weight: bold;
        margin-top: 15px;
      }
  </style>


  <script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
</head>
<body class="hold-transition login-page">
<div class="login-box" style="margin:3% auto !important;">
  <div class="login-logo">
   <!--  <a href="#"><img src="<?=base_url('assets/dist/img/logoFR.png')?>"></a> -->
   Inventory
  </div>
  <!-- /.login-logo -->
  <?php
  if(isset($valid) && $valid):?>
    <div class="alert alert-success">Login success</div>
    <script type="text/javascript">
      setInterval(function () {
        $('.alert-success').text('Redirecting...');
        window.location = "<?=base_url('panel/login')?>";
      }, 500);
    </script>
  <?php endif; ?>
  <div class="login-box-body">
    <p class="login-box-msg"><?=isset($error)?$error:'';?></p>

    <form method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="User Name" name="adm_login" value="<?=isset($adm_login)?$adm_login:'';?>">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <!--div class="form-group has-feedback">
        <label class="label-control col-md-12 no-padding">Enter the contents of image:
</label>
        <div class="col-md-5 no-padding">
            <input type="text" class="form-control input-sm" name="captcha">
        </div>
        <div class="col-md-7 captcha">

        </div>
      </div-->
      <div class="row">
        <!--div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div-->
        <!-- /.col -->
        <div class="col-xs-12" style="padding-top: 15px;">
          <button type="submit" class="form-control btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
  <!--<p class="text-copy">Copyright &copy; 2016-2017 Dutamedia</p>-->
</div>
<!-- /.login-box -->

<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url(); ?>assets/plugins/iCheck/icheck.min.js"></script>
<script>
  /*function recaptcha(){
    $.get('<?=base_url('panel/login/captcha')?>', function(data){
        $('.captcha').html(data+'<a onclick="recaptcha()" class="refresh"><i class="fa fa-refresh"></i></a>');
    });
  }
  $(function () {
    recaptcha();
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });*/
</script>
</body>
</html>
