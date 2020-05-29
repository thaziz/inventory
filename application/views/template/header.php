  <header class="main-header">
  <script type="text/javascript">
    var base_url  = '<?php echo base_url(); ?>';
  </script>
    <!-- Logo -->
    <a href="<?=base_url('panel')?>" class="logo" style="background-color: transparent;">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini" style="color: black"><!-- <img src="<?=base_url('assets/dist/img/logoFR.png')?>"> -->IV</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg" style="color: black">
      <!--   <img style = "width: 100%;" src="<?=base_url('assets/dist/img/logoFR.png')?>"> -->
      Inventory
      </span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div>
        <ul class="nav navbar-nav navbar-main">
          <?php
            if(isset($menu['main'])){
              $uri =  trim(implode('/', $this->uri->segment_array()));
              foreach ($menu['main'] as $key => $value){
                if(isset($value['sub_menu'])){
                  echo '<li class="dropdown'.($value['active_menu']?' active':'').'">
                          <a href='.($value['link_menu']!='#'?base_url().$value['link_menu']:'#').'>'
                            .$value['menu_name'].
                          '</a>
                          <ul class="dropdown-menu">';
                  foreach ($value['sub_menu'] as $key => $value) {
                      echo '<li class="'.(($uri==$value['link_menu'])?'active':'').'">
                              <a href="'.base_url().$value['link_menu'].'">'
                              .$value['menu_name'].
                              '</a>
                            </li>';
                  }
                  echo '</ul></li>';
                }else{
                  echo '<li'.($value['active_menu']?' class="active"':'').'>
                          <a href='.($value['link_menu']!='#'?base_url().$value['link_menu']:'#').'>'
                            .$value['menu_name'].
                          '</a>
                        </li>';
                }
              }
            }
            ?>
        </ul>
      </div>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
              <i id="ajax-loading" class="fa fa-refresh fa-spin fa-2x fa-fw" style="position:relative;top:8px;color:lightgreen"></i>
          </li>
          <li class="dropdown notifications-menu" id="notifications">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"></span>
            </a>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" style="padding-bottom: 12px;">
              <img src="<?=base_url()."assets/"?>dist/img/avatar5.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?=$this->session->userdata('name')?> - <span style="font-size: 10px"> <?=$this->session->userdata('bidang')?> ( <?=$this->session->userdata('jabatan')?> )</span></span>
            </a>
            <ul class="dropdown-menu">

              <!-- Menu Footer-->
              <li>
              <?php $mod = isset($this->session->userdata['base'])?$this->session->userdata('base'):'panel';?>
                <a href="<?=base_url($mod.'/logout')?>" >Sign out</a>
              </li>
            </ul>
          </li>

        </ul>
      </div>

    </nav>
  </header>
