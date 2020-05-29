
<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header"><label id="timer"></label></li>
        <?php if(isset($menu['sidebar'])){ ?>
        <?php 
        $uri =  trim(implode('/', $this->uri->segment_array()));
        foreach ($menu['sidebar'] as $key => $value){
          echo '<li class="'.(($uri==$value['link_menu'])?'active':'').'">
                <a href="'.base_url().$value['link_menu'].'">
                   <i class="fa fa-bars"></i><span> '.$value['menu_name'].'</span>
                </a>
            </li>';
        }
        ?>
        <?php }?>
      </ul>
    </section>
    <?php $today = getdate(); ?>
    <script>
      var xmlHttp;
      function srvTime(){
          try {
              //FF, Opera, Safari, Chrome
              xmlHttp = new XMLHttpRequest();
          }
          catch (err1) {
              //IE
              try {
                  xmlHttp = new ActiveXObject('Msxml2.XMLHTTP');
              }
              catch (err2) {
                  try {
                      xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
                  }
                  catch (eerr3) {
                      //AJAX not supported, use CPU time.
                      alert("AJAX not supported");
                  }
              }
          }
          xmlHttp.open('HEAD',window.location.href.toString(),false);
          xmlHttp.setRequestHeader("Content-Type", "text/html");
          xmlHttp.send('');
          return xmlHttp.getResponseHeader("Date");
      }

      var st = srvTime();
      var d = new Date(st);
      setInterval(function() {
            d.setSeconds(d.getSeconds() + 1);
            $('#timer').text(((d.getHours()<10?'0'+d.getHours():d.getHours()) +':' 
              + (d.getMinutes()<10?'0'+d.getMinutes():d.getMinutes()) + ':' 
              + (d.getSeconds()<10?'0'+d.getSeconds():d.getSeconds())));
      }, 1000);
    </script>
    <style type="text/css">
      .skin-blue-light .sidebar-menu>li.header{
        text-align: center;
        font-size: 16px;
        padding-top: 2px;
        color:#337ab7;
      }
    </style>
    <!-- /.sidebar -->
  </aside>