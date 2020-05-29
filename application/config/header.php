<!-- navbar-fixed-top-->
<nav class="header-navbar navbar navbar-with-menu navbar-static-top navbar-light navbar-border navbar-brand-center">
  <div class="navbar-wrapper">
    <div class="navbar-header">
      <ul class="nav navbar-nav">
        <li class="nav-item mobile-menu hidden-md-up float-xs-left"><a class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="icon-menu5 font-large-1"></i></a></li>
        <li class="nav-item">
          <a href="index.html" class="navbar-brand nav-link">
            <img alt="branding logo" src="<?php echo base_url('assets/images/logo.png'); ?>" data-expand="<?php echo base_url('assets/images/logo.png'); ?>" data-collapse="<?php echo base_url('assets/images/logo.png'); ?>" class="brand-logo" style = "height: 43px; width: 150px;">
          </a>
        </li>
        <li class="nav-item hidden-md-up float-xs-right">
          <a data-toggle="collapse" data-target="#navbar-mobile" class="nav-link open-navbar-container"><i class="icon-ellipsis pe-2x icon-icon-rotate-right-right"></i>
          </a>
        </li>
      </ul>
    </div>
    <div class="navbar-container container center-layout">
      <div id="navbar-mobile" class="collapse navbar-toggleable-sm">
        <ul class="nav navbar-nav">
          <li class="nav-item hidden-sm-down"><a class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="icon-menu5"></i></a></li>
          <li class="nav-item hidden-xs-down">
            <form class="search-form-top">
              <div class="input-group search-control-wrap">
                <input type="text" class="form-control round" aria-label="..." placeholder="Search...">
                <div class="input-group-btn">
                  <button class="btn btn-default round" type="submit"><i class="ficon icon-search7"></i></button>
                </div>
              </div>
            </form>
          </li>
          <li class="nav-item nav-search hidden-sm-up"><a href="#" data-toggle="dropdown" class="nav-link nav-link-search"><i class="ficon icon-search7"></i></a>
            <div class="dropdown-menu">
              <form class="search-form-top">
                <div class="input-group">
                  <input type="text" class="form-control round" aria-label="..." placeholder="Search...">
                  <div class="input-group-btn">
                    <button class="btn btn-default round" type="submit"><i class="ficon icon-search7"></i></button>
                  </div>
                </div>
              </form>
            </div>
          </li>
          <li class="nav-item hidden-sm-down"><a href="#" class="nav-link nav-link-expand"><i class="ficon icon-expand2"></i></a></li>
          <!--li class="dropdown nav-item mega-dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link">Mega</a>
            <ul class="mega-dropdown-menu dropdown-menu row">
              <li class="col-md-2">
                <h6 class="dropdown-menu-header text-uppercase mb-1"><i class="icon-paper"></i> News</h6>
                <div id="mega-menu-carousel-example" class="responsive-slick">
                  <div><img src="images/slider/slider-2.png" alt="First slide" class="rounded img-fluid mb-1"><a href="#" class="news-title mb-0">Poster Frame PSD</a>
                    <p class="news-content"><span class="font-small-2">January 26, 2016</span></p>
                  </div>
                  <div><img src="images/slider/slider-5.png" alt="First slide" class="rounded img-fluid mb-1"><a href="#" class="news-title mt-1 mb-0">Header MockUp</a>
                    <p class="news-content"><span class="font-small-2">January 15, 2016</span></p>
                  </div>
                  <div><img src="images/slider/slider-6.png" alt="First slide" class="rounded img-fluid mb-1"><a href="#" class="news-title mt-1 mb-0">2 Poster PSD</a>
                    <p class="news-content"><span class="font-small-2">January 15, 2016</span></p>
                  </div>
                </div>
              </li>
              <li class="col-md-3">
                <h6 class="dropdown-menu-header text-uppercase"><i class="icon-shuffle3"></i> Drill down menu</h6>
                <ul class="drilldown-menu">
                  <li class="menu-list">
                    <ul>
                      <li><a href="layout-2-columns.html" class="dropdown-item"><i class="icon-layout"></i> Page layouts & Templates</a></li>
                      <li><a href="#"><i class="icon-layers"></i> Multi level menu</a>
                        <ul>
                          <li><a href="#" class="dropdown-item"><i class="icon-share4"></i>  Second level</a></li>
                          <li><a href="#"><i class="icon-umbrella3"></i> Second level menu</a>
                            <ul>
                              <li><a href="#" class="dropdown-item"><i class="icon-microphone2"></i>  Third level</a></li>
                              <li><a href="#" class="dropdown-item"><i class="icon-head"></i> Third level</a></li>
                              <li><a href="#" class="dropdown-item"><i class="icon-signal2"></i> Third level</a></li>
                              <li><a href="#" class="dropdown-item"><i class="icon-camera8"></i> Third level</a></li>
                            </ul>
                          </li>
                          <li><a href="#" class="dropdown-item"><i class="icon-flag4"></i> Second level, third link</a></li>
                          <li><a href="#" class="dropdown-item"><i class="icon-box"></i> Second level, fourth link</a></li>
                        </ul>
                      </li>
                      <li><a href="color-palette-primary.html" class="dropdown-item"><i class="icon-marquee-plus"></i> Color pallet system</a></li>
                      <li><a href="sk-2-columns.html" class="dropdown-item"><i class="icon-edit2"></i> Page starter kit</a></li>
                      <li><a href="changelog.html" class="dropdown-item"><i class="icon-files-empty"></i> Change log</a></li>
                      <li><a href="http://support.pixinvent.com/" class="dropdown-item"><i class="icon-tencent-weibo"></i> Customer support center</a></li>
                    </ul>
                  </li>
                </ul>
              </li>
              <li class="col-md-3">
                <h6 class="dropdown-menu-header text-uppercase"><i class="icon-list2"></i> Accordion</h6>
                <div id="accordionWrap" role="tablist" aria-multiselectable="true">
                  <div class="card no-border box-shadow-0 collapse-icon accordion-icon-rotate">
                    <div id="headingOne" role="tab" class="card-header p-0 pb-1 no-border"><a data-toggle="collapse" data-parent="#accordionWrap" href="#accordionOne" aria-expanded="true" aria-controls="accordionOne" class="card-title">Accordion Group Item #1</a></div>
                    <div id="accordionOne" role="tabpanel" aria-labelledby="headingOne" aria-expanded="true" class="card-collapse collapse in">
                      <div class="card-body">
                        <p class="accordion-text">Caramels dessert chocolate cake pastry jujubes bonbon. Jelly wafer jelly beans. Caramels chocolate cake liquorice cake wafer jelly beans croissant apple pie.</p>
                      </div>
                    </div>
                    <div id="headingTwo" role="tab" class="card-header p-0 pb-1 no-border"><a data-toggle="collapse" data-parent="#accordionWrap" href="#accordionTwo" aria-expanded="false" aria-controls="accordionTwo" class="card-title collapsed">Accordion Group Item #2</a></div>
                    <div id="accordionTwo" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" class="card-collapse collapse">
                      <div class="card-body">
                        <p class="accordion-text">Sugar plum bear claw oat cake chocolate jelly tiramisu dessert pie. Tiramisu macaroon muffin jelly marshmallow cake. Pastry oat cake chupa chups.</p>
                      </div>
                    </div>
                    <div id="headingThree" role="tab" class="card-header p-0 pb-1 no-border"><a data-toggle="collapse" data-parent="#accordionWrap" href="#accordionThree" aria-expanded="false" aria-controls="accordionThree" class="card-title collapsed">Accordion Group Item #3</a></div>
                    <div id="accordionThree" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false" class="card-collapse collapse">
                      <div class="card-body">
                        <p class="accordion-text">Candy cupcake sugar plum oat cake wafer marzipan jujubes lollipop macaroon. Cake dragée jujubes donut chocolate bar chocolate cake cupcake chocolate topping.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="col-md-4">
                <h6 class="dropdown-menu-header text-uppercase mb-1"><i class="icon-mail6"></i> Contact Us</h6>
                <form>
                  <fieldset class="form-group position-relative has-icon-left">
                    <label for="inputName1" class="col-sm-3 form-control-label">Name</label>
                    <div class="col-sm-9">
                      <input type="text" id="inputName1" placeholder="John Doe" class="form-control">
                      <div class="form-control-position"><i class="icon-head"></i></div>
                    </div>
                  </fieldset>
                  <fieldset class="form-group position-relative has-icon-left">
                    <label for="inputEmail1" class="col-sm-3 form-control-label">Email</label>
                    <div class="col-sm-9">
                      <input type="email" id="inputEmail1" placeholder="john@example.com" class="form-control">
                      <div class="form-control-position"><i class="icon-mail6"></i></div>
                    </div>
                  </fieldset>
                  <fieldset class="form-group position-relative has-icon-left">
                    <label for="inputMessage1" class="col-sm-3 form-control-label">Message</label>
                    <div class="col-sm-9">
                      <textarea id="inputMessage1" rows="2" placeholder="Simple Textarea" class="form-control"></textarea>
                      <div class="form-control-position"><i class="icon-file-text"></i></div>
                    </div>
                  </fieldset>
                  <div class="col-sm-12 mb-1">
                    <button type="button" class="btn btn-primary float-xs-right"><i class="icon-send-o"></i> Send</button>
                  </div>
                </form>
              </li>
            </ul>
          </li-->
        </ul>
        <ul class="nav navbar-nav float-xs-right">
          <!--li class="dropdown dropdown-language nav-item"><a id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle nav-link"><i class="flag-icon flag-icon-gb"></i><span class="selected-language">English</span></a>
            <div aria-labelledby="dropdown-flag" class="dropdown-menu"><a href="#" class="dropdown-item"><i class="flag-icon flag-icon-gb"></i> English</a><a href="#" class="dropdown-item"><i class="flag-icon flag-icon-fr"></i> French</a><a href="#" class="dropdown-item"><i class="flag-icon flag-icon-cn"></i> Chinese</a><a href="#" class="dropdown-item"><i class="flag-icon flag-icon-de"></i> German</a></div>
          </li-->
          <li class="dropdown dropdown-notification nav-item"><a href="#" data-toggle="dropdown" class="nav-link nav-link-label"><i class="ficon icon-bell4"></i><!--span class="tag tag-pill tag-default tag-danger tag-default tag-up">5</span--></a>
            <!--ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
              <li class="dropdown-menu-header">
                <h6 class="dropdown-header m-0"><span class="grey darken-2">Notifications</span><span class="notification-tag tag tag-default tag-danger float-xs-right m-0">5 New</span></h6>
              </li>
              <li class="list-group scrollable-container"><a href="javascript:void(0)" class="list-group-item">
                <div class="media">
                  <div class="media-left valign-middle"><i class="icon-cart3 icon-bg-circle bg-cyan"></i></div>
                  <div class="media-body">
                    <h6 class="media-heading">You have new order!</h6>
                    <p class="notification-text font-small-3 text-muted">Lorem ipsum dolor sit amet, consectetuer elit.</p><small>
                    <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">30 minutes ago</time></small>
                  </div>
                </div></a><a href="javascript:void(0)" class="list-group-item">
                <div class="media">
                  <div class="media-left valign-middle"><i class="icon-monitor3 icon-bg-circle bg-red bg-darken-1"></i></div>
                  <div class="media-body">
                    <h6 class="media-heading red darken-1">99% Server load</h6>
                    <p class="notification-text font-small-3 text-muted">Aliquam tincidunt mauris eu risus.</p><small>
                    <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">Five hour ago</time></small>
                  </div>
                </div></a><a href="javascript:void(0)" class="list-group-item">
                <div class="media">
                  <div class="media-left valign-middle"><i class="icon-server2 icon-bg-circle bg-yellow bg-darken-3"></i></div>
                  <div class="media-body">
                    <h6 class="media-heading yellow darken-3">Warning notifixation</h6>
                    <p class="notification-text font-small-3 text-muted">Vestibulum auctor dapibus neque.</p><small>
                    <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">Today</time></small>
                  </div>
                </div></a><a href="javascript:void(0)" class="list-group-item">
                <div class="media">
                  <div class="media-left valign-middle"><i class="icon-check2 icon-bg-circle bg-green bg-accent-3"></i></div>
                  <div class="media-body">
                    <h6 class="media-heading">Complete the task</h6><small>
                    <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">Last week</time></small>
                  </div>
                </div></a><a href="javascript:void(0)" class="list-group-item">
                <div class="media">
                  <div class="media-left valign-middle"><i class="icon-bar-graph-2 icon-bg-circle bg-teal"></i></div>
                  <div class="media-body">
                    <h6 class="media-heading">Generate monthly report</h6><small>
                    <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">Last month</time></small>
                  </div>
                </div></a></li>
                <li class="dropdown-menu-footer"><a href="javascript:void(0)" class="dropdown-item text-muted text-xs-center">Read all notifications</a></li>
              </ul-->
            </li>
            <li class="dropdown dropdown-notification nav-item"><a href="#" data-toggle="dropdown" class="nav-link nav-link-label"><i class="ficon icon-mail6"></i><!--span class="tag tag-pill tag-default tag-info tag-default tag-up">8</span--></a>
              <!--ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                <li class="dropdown-menu-header">
                  <h6 class="dropdown-header m-0"><span class="grey darken-2">Messages</span><span class="notification-tag tag tag-default tag-info float-xs-right m-0">4 New</span></h6>
                </li>
                <li class="list-group scrollable-container"><a href="javascript:void(0)" class="list-group-item">
                  <div class="media">
                    <div class="media-left"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="images/portrait/small/avatar-s-1.png" alt="avatar"><i></i></span></div>
                    <div class="media-body">
                      <h6 class="media-heading">Margaret Govan</h6>
                      <p class="notification-text font-small-3 text-muted">I like your portfolio, let's start the project.</p><small>
                      <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">Today</time></small>
                    </div>
                  </div></a><a href="javascript:void(0)" class="list-group-item">
                  <div class="media">
                    <div class="media-left"><span class="avatar avatar-sm avatar-busy rounded-circle"><img src="images/portrait/small/avatar-s-2.png" alt="avatar"><i></i></span></div>
                    <div class="media-body">
                      <h6 class="media-heading">Bret Lezama</h6>
                      <p class="notification-text font-small-3 text-muted">I have seen your work, there is</p><small>
                      <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">Tuesday</time></small>
                    </div>
                  </div></a><a href="javascript:void(0)" class="list-group-item">
                  <div class="media">
                    <div class="media-left"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="images/portrait/small/avatar-s-3.png" alt="avatar"><i></i></span></div>
                    <div class="media-body">
                      <h6 class="media-heading">Carie Berra</h6>
                      <p class="notification-text font-small-3 text-muted">Can we have call in this week ?</p><small>
                      <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">Friday</time></small>
                    </div>
                  </div></a><a href="javascript:void(0)" class="list-group-item">
                  <div class="media">
                    <div class="media-left"><span class="avatar avatar-sm avatar-away rounded-circle"><img src="images/portrait/small/avatar-s-6.png" alt="avatar"><i></i></span></div>
                    <div class="media-body">
                      <h6 class="media-heading">Eric Alsobrook</h6>
                      <p class="notification-text font-small-3 text-muted">We have project party this saturday night.</p><small>
                      <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">last month</time></small>
                    </div>
                  </div></a></li>
                  <li class="dropdown-menu-footer"><a href="javascript:void(0)" class="dropdown-item text-muted text-xs-center">Read all messages</a></li>
                </ul-->
              </li>
              <li class="dropdown dropdown-user nav-item"><a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link dropdown-user-link"><span class="avatar avatar-online"><img src="<?=base_url('assets/')?>images/portrait/small/avatar-s-1.png" alt="avatar"><i></i></span><span class="user-name">John Doe</span></a>
                <div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item"><i class="icon-head"></i> Edit Profile</a><a href="#" class="dropdown-item"><i class="icon-mail6"></i> My Inbox</a><a href="#" class="dropdown-item"><i class="icon-clipboard2"></i> Task</a><a href="#" class="dropdown-item"><i class="icon-calendar5"></i> Calender</a>
                  <div class="dropdown-divider"></div><a href="#" class="dropdown-item"><i class="icon-power3"></i> Logout</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <!-- Horizontal navigation-->
    <div role="navigation" data-menu="menu-wrapper" class="header-navbar navbar navbar-horizontal navbar-fixed navbar-light navbar-without-dd-arrow navbar-bordered navbar-shadow">
      <!-- Horizontal menu content-->
      <div data-menu="menu-container" class="navbar-container main-menu-content container center-layout">
        <!-- include ../../../includes/mixins-->
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="nav navbar-nav">
          <?php
            if(isset($menu['main'])){
              $uri =  trim(implode('/', $this->uri->segment_array()));
              foreach ($menu['main'] as $key => $value){
                if(isset($value['sub_menu'])){
                  echo '<li data-menu="dropdown" class="dropdown nav-item'.($value['active_menu']?' active':'').'">
                          <a href='.(!empty($value['menu_url'])?base_url($value['menu_url']):'#').' data-toggle="dropdown" class="dropdown-toggle nav-link">'.
                          (!empty($value['menu_icon'])?'<i class="'.$value['menu_icon'].'"></i> ':'')
                            .'<span>'.$value['menu_title'].
                          '</span></a>
                          <ul class="dropdown-menu">';
                  foreach ($value['sub_menu'] as $key => $value) {
                      /*echo '<li data-menu="dropdown-submenu" class="dropdown dropdown-submenu'.(($uri==$value['menu_url'])?' active':'').'">*/
                      echo '<li data-menu="" class="'.(($uri==$value['menu_url'])?'active':'').'">
                              <a href="'.base_url().$value['menu_url'].'" data-toggle="dropdown" class="dropdown-item">'
                              .$value['menu_title'].
                              '</a>
                            </li>';
                  }
                  echo '</ul></li>';
                }else{
                  echo '<li class="nav-item'.($value['active_menu']?' active':'').'">
                          <a href='.(!empty($value['menu_url'])?base_url($value['menu_url']):'#').' 
                          class="nav-link">'.
                          (!empty($value['menu_icon'])?'<i class="'.$value['menu_icon'].'"></i> ':'')
                            .'<span>'.$value['menu_title'].
                          '</span></a>
                        </li>';
                }
              }
            }
            ?>
        </ul>
      </div>
      <!-- /horizontal menu content-->
    </div>
    <!-- Horizontal navigation-->