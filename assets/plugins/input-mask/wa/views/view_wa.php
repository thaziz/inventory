
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Kanmo Chat</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/iCheck/all.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/datatables-bulma/css/bulma.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/datatables-bulma/css/dataTables.bulma.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/toastMessage/css/jquery.toastmessage.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/sliptree/css/bootstrap-tokenfield.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/ticket.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/style.css">

<!--  <script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>  ->
  <script src="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.js"></script-->



  <script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-3.4.1.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/moment.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/switch/bootstrap-toggle.min.css" />
  <script src="<?php echo base_url(); ?>assets/plugins/switch/bootstrap-toggle.min.js"></script>

       <!-- Toast Message -->
  <script src="<?php echo base_url(); ?>assets/plugins/toastMessage/js/jquery.toastmessage.js"></script>


  <!--script src="<?php echo base_url('node_modules/socket.io/node_modules/socket.io-client/socket.io.js');?>"></script-->
  <style>
    @media screen and (min-width: 769px), print{
      .modal-card, .modal-content {
        min-width: 100% !important;
        max-width: 100% !important;
        max-height:  100% !important;
      }
    /* Absolute Center Spinner */
.loading {
  position: fixed;
  z-index: 999;
  height: 2em;
  width: 2em;
  overflow: visible;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}

/* Transparent Overlay */
.loading:before {
  content: '';
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.3);
}

/* :not(:required) hides these rules from IE9 and below */
.loading:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

.loading:not(:required):after {
  content: '';
  display: block;
  font-size: 10px;
  width: 1em;
  height: 1em;
  margin-top: -0.5em;
  -webkit-animation: spinner 1500ms infinite linear;
  -moz-animation: spinner 1500ms infinite linear;
  -ms-animation: spinner 1500ms infinite linear;
  -o-animation: spinner 1500ms infinite linear;
  animation: spinner 1500ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
  box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
  </style>

  <style>
    ::placeholder {
      color: white;
      opacity: 1; /* Firefox */
    }

    :-ms-input-placeholder { /* Internet Explorer 10-11 */
     color: white;
   }

   ::-ms-input-placeholder { /* Microsoft Edge */
     color: white;
   }
 </style>

 <style type="text/css">
.max-lines {
  display: block;/* or inline-block */
  text-overflow: ellipsis;
  word-wrap: break-word;
  overflow: hidden;
  max-height: 3.6em;
  line-height: 1.8em;
}

.box_reply {
  /*border: #968585 1px solid;*/
  background: #f0f0f0 none repeat scroll 0 0;
  border-radius: 0 15px 15px 15px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}

.reply {
  background: white none repeat scroll 0 0;
  border-radius: 8px 8px 8px 8px;
  color: #646464;
  font-size: 14px;
  margin: 0px 0px 10px 0px;
  padding: 2px 8px 2px 10px;
  width: 100%;
  /*border-bottom: 2px green solid;  */
  border-left: 4px #35cd96 solid;
  /*box-shadow: 0px 10px 2px 0px #888888;*/
}


.received_withd_msg_r {
  width: 57%;
}

  /*---------chat window---------------*/
  .chat_people_header {
    margin-bottom: 0 !important;
  }
  .chat_date {
    margin-bottom: 10px;
  }
  .container{
    max-width:1600px;
  }
  .inbox_people {
    background: #fff;
    float: left;
    overflow: hidden;
    width: 25%;
    border-right: 1px solid #ddd;
  }

  .inbox_people2 {
    background: #fff;
    float: left;
    overflow: hidden;
    width: 40%;
    border-right: 1px solid #ddd;
  }

  .inbox_people3 {
    background: #fff;
    float: left;
    overflow: hidden;
    width: 35%;
    border-right: 1px solid #ddd;
  }


  .inbox_msg {
    /*border: 1px solid #ddd;*/
    clear: both;
    overflow: hidden;
  }

  .top_spac {
    margin: 20px 0 0;
  }

  .recent_heading {
    float: left;
    width: 40%;
  }

  .srch_bar {
    display: inline-block;
    text-align: right;
    width: 100%;
    padding:
  }

  .headind_srch {
    border-bottom: 1px solid #c4c4c4;
  }


  .headind_srch_all {
    border-bottom: 1px solid #c4c4c4;
  }

  .recent_heading h4 {
    color: #0465ac;
    font-size: 16px;
    margin: auto;
    line-height: 29px;
  }

  .srch_bar input {
    /*  background-color: #3CBC8D;*/
    color: white;
    outline: none;
    border: 1px solid #cdcdcd;
    border-width: 0 0 1px 0;
    width: 80%;
    padding: 2px 0 4px 6px;
    background: none;
  }

  .srch_bar .input-group-addon button {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border: medium none;
    padding: 0;
    color: #707070;
    font-size: 18px;
  }

  .srch_bar .input-group-addon {
    margin: 0 0 0 -27px;
  }

  .chat_ib h5 {
    font-size: 15px;
    color: #464646;
    margin: 0 0 8px 0;
  }

  .chat_ib h5 span {
    font-size: 13px;
    float: right;
  }

  .wordwrap { 
   white-space: pre-wrap;      /* CSS3 */   
   white-space: -moz-pre-wrap; /* Firefox */    
   white-space: -pre-wrap;     /* Opera <7 */   
   white-space: -o-pre-wrap;   /* Opera 7 */    
   word-wrap: break-word;      /* IE */
 }


 .chat_ib p {
  font-size: 12px;
  color: #989898;
  margin: auto;
  display: inline-block;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.chat_img {
  float: left;
  width: 11%;
}

.chat_img img {
  width: 100%
}

.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people {
  overflow: hidden;
  clear: both;
}

.chat_list {
  border-bottom: 1px solid #ddd;
  margin: 0;
  padding: 18px 16px 10px;
}

.chat_list_all {
  border-bottom: 1px solid #ddd;
  margin: 0;
  padding: 18px 16px 10px;
}

.inbox_chat, .allinbox_chat {
  height: calc(100vh - 87px);
  overflow-y: scroll;
}

.active_chat {
  background: #fffef9;
  /*#e8f6ff;*/
}

.active_chat_all {
  background: #fffef9;
  /*#e8f6ff;*/
}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}

.incoming_msg_img img {
  width: 100%;
}

.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
}

.received_withd_msg p {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 0 15px 15px 15px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}

.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}

.received_withd_msg {
  width: 90%;
}

.mesgs{
  float: left;
  /*padding: 30px 15px 0 25px;*/
  width:100%;
}

.sent_msg p {
  background:#0465ac;
  border-radius: 12px 15px 15px 0;
  font-size: 14px;
  margin: 0;
  color: #fff;
  padding: 5px 10px 5px 12px;
  width: 100%;
}

.outgoing_msg {
  overflow: hidden;
  margin: 26px 0 26px;
}

.sent_msg {
  float: right;
  width: 90%;
}

.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
  outline:none;
}

.type_msg {
  border-top: 1px solid #c4c4c4;
  position: relative;
}

.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border:none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 15px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
}



.msg_history {
  height: calc(100vh - 160px);
  overflow-y: auto;
  padding: 10px 0 0 25px !important;
}

.msg_history1 {
  /*height: calc(100vh - 160px);*/
  overflow-y: auto;
  padding: 10px 0 0 25px !important;
}

.ellipsis { text-overflow: ellipsis; }

.nav > li > a {
    padding: 5px 15px !important;
}
.tabs-custom {
  padding: 5px 0 !important;
}
</style>

<style type="text/css">
  body {
  -ms-overflow-style:none;
}
  html, body {
  /*  margin: 0; height: 100%; overflow: hidden;position: relative;*/
  }
  span.required, span.info{
    color: red;
  }
  .overlay{
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background: rgba(255,255,255,.7);
    z-index: 31;
    display: none;
  }
  .loading{
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 10em;
    color: lavender;
  }
  .ticket-detail-info{
    width: 100%;
    height: 100%;
    background: #fff;
    overflow-y: auto;
    display: none;
  }
  .content.detail-ticket table td{
    border: none !important;
  }
  .content.detail-ticket .nav.nav-pills {
    margin-left: 5px !important;
  }
  .ticket-pane{
    padding: 15px;
  }
  .btn-close-detail{
    position: absolute;
    right: 5px;
    font-size: 1.5em;
  }
  .cus-field-info{
    margin-bottom: -2px;
    font-size: 1.1em;
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
  td.align-right{
    text-align: right;
  }
  .select2-container--default .select2-selection--single{
    height: 34px !important;
  }
  .select2-container--default .select2-selection--single .select2-selection__rendered{
    line-height: 32px !important
  }
  /*color tabs*/
  .nav-pills>li.active>a#a1, .nav-pills>li.active>a#a1:focus, .nav-pills>li.active>a#a1:hover{
    color: #fff;
    background-color: #e95926;
  }
  .nav-pills>li.active>a#a2, .nav-pills>li.active>a#a2:focus, .nav-pills>li.active>a#a2:hover{
    color: #fff;
    background-color:  #5f5f5f;
  }

  textarea {
min-height: 60px;
overflow-y: auto;
word-wrap:break-word
}
   
</style>
</head>
<body><!-- 
 <audio id="notif_audio"><source src="<?php echo base_url('sounds/notify.ogg');?>" type="audio/ogg"><source src="<?php echo base_url('sounds/notify.mp3');?>" type="audio/mpeg"><source src="<?php echo base_url('sounds/notify.wav');?>" type="audio/wav"></audio>
 -->
 <div class="loading" style="display: none;">Loading</div>
 <audio id="myAudio" >
  <source src="<?php echo base_url('sounds/notify.mp3');?>" type="audio/mpeg">
    Your browser does not support the audio element.
  </audio>

  <div class="overlay">
    <div class="loading"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i></div>
    <div class="ticket-detail-info">
      <a class="btn-close-detail" href="#"><i class="fa fa-times"></i></a>
      <div class="ticket-pane">
        
      </div>
    </div>
  </div>



  <nav class="navbar" style="background: #fff5f5; margin-bottom:0px !important; height: 55px">
    <div class="container">
    <div class="navbar-header"><!-- 
      <a class="navbar-brand" href="#">WebSiteName</a> -->
      <a href="<?=base_url('assets/images/kanmo.png')  ?>" data-fancybox="images"><img src="<?=base_url('assets/images/kanmo.png')  ?>" width="250px"></a><br>
    </div>


    <div class="btn-group btn-group-lg col-md-9" role="group" aria-label="Large button group" id="dashboardmy">
      <div class="col-md-11 col-md-offset-3">

         <button type="button" class="btn btn-default" style="height: 50px;width: 125px;background: #c62828;color: white; border: 2px solid"><strong style="color: white"> Agent Available <br> <span class="agent_ol">0</span></strong></button>

        <button type="button" class="btn btn-default" style="height: 50px;width: 100px;background: #c62828;color: white; border: 2px solid"><strong style="color: white"> Queue <br> <span class="queue_m"><?=isset($dashboard['queue'])?$dashboard['queue']:0 ?></span></strong></button>
        <button type="button" class="btn btn-default" style="height: 50px;width: 100px;background: #c62828;color: white; border: 2px solid"><strong style="color: white"> Received <br> <span class="received"><?=isset($dashboard['recieve'])?$dashboard['recieve']:0 ?></span></strong></button>

        <button type="button" class="btn btn-default" style="height: 50px;width: 100px;background: #c62828;color: white;border: 2px solid"><strong style="color: white"> Sent <br> <span class="sent"><?=isset($dashboard['send'])?$dashboard['send']:0 ?></span></strong></button>

        <button type="button" class="btn btn-default" style="height: 50px;width: 100px;background: #c62828;color: white;border: 2px solid"><strong style="color: white"> All <br> <span class="all"><?=isset($dashboard['total'])?$dashboard['total']:0 ?></span></strong></button>


      </div>
    </div>


    <div class="btn-group btn-group-lg col-md-9" role="group" aria-label="Large button group" style="display: none;" id="dashboardall">
      <div class="col-md-11 col-md-offset-4" >
         <button type="button" class="btn btn-default" style="height: 50px;width: 110px;background: #c62828;color: white; border: 2px solid"><strong style="color: white"> Agent Online <br> <span class="agent_ol">0</span></strong></button>

        <button type="button" class="btn btn-default" style="height: 50px;width: 100px;background: #c62828;color: white; border: 2px solid"><strong style="color: white"> Queue <br> <span class="queue_all"><?=isset($dashboardall['queue'])?$dashboardall['queue']:0 ?></span></strong></button>
        <button type="button" class="btn btn-default" style="height: 50px;width: 100px;background: #c62828;color: white; border: 2px solid"><strong style="color: white"> Received <br> <span class="received_all"><?=isset($dashboardall['recieve'])?$dashboardall['recieve']:0 ?></span></strong></button>

        <button type="button" class="btn btn-default" style="height: 50px;width: 100px;background: #c62828;color: white;border: 2px solid"><strong style="color: white"> Sent <br> <span class="sent_all"><?=isset($dashboardall['send'])?$dashboardall['send']:0 ?></span></strong></button>

        <button type="button" class="btn btn-default" style="height: 50px;width: 100px;background: #c62828;color: white;border: 2px solid"><strong style="color: white"> All <br> <span class="all_all"><?=isset($dashboardall['total'])?$dashboardall['total']:0 ?></span></strong></button>


      </div>
    </div>

    <div class="col-md-4" style="height: 50px;">
         <!--  <div class="srch_bar">
          <div class="stylish-input-group">
            <input type="text" class="search-bar"  placeholder="Search" >
          </div>
        </div> -->

        <div class="form-group" style="padding-top: 10px;">
          <div class="input-group" style="margin-right:-1px">
            <input type="text" id="search_number" class="form-control" placeholder="Search Chat">
            <div class="input-group-btn">
              <button onclick="searchNumber()" type="button" class="btn btn-primary" id="btn-chat" style="padding:6px 12px;"><i class="fa fa-search"></i></button>
            </div>
          </div>
        </div>


      </div>

    </div>
  </nav>

  <div class="messaging">
    <div class="inbox_msg">
      <div class="inbox_people">


        <ul class="nav nav-tabs">
          <li class="active">
            <a class="nav-link active" onclick="tab_chat('1')" href="#my_chat" role="tab" data-toggle="tab">My Chats</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#all_chat" onclick="tab_chat('0')" role="tab" data-toggle="tab">All Chats</a>
          </li>
           <li class="nav-item">
            <?php if ($status_chat==false): ?>                
            <a class="nav-link play_pause" onclick="tab_chat('2')" role="tab"> <i class="fa fa-play-circle"></i>Online Chats</a>
            <?php else: ?>              
            <a class="nav-link play_pause" onclick="tab_chat('2')" role="tab"> <i class="fa fa-stop-circle"></i>Offline Chats</a>
            <?php endif ?>
          </li>
        </ul>

        <div class="tab-content">
          <div role="tabpanel" class="tab-pane fade  in active" id="my_chat">
            <div class="inbox_chat scroll"   style="background: #e3f2fd">
              <div class="chat_list active_chat">

              </div>
            </div>
          </div>
          <div role="tabpanel" class="tab-pane fade" id="all_chat">
            <div class="allinbox_chat scroll"   style="background: #e3f2fd">
              <div class="chat_list_all active_chat_all">

              </div>
            </div>
          </div>

        </div>


      </div>

      <div class="inbox_people2" style="display: none;">
        <div class="headind_srch">
        	<div style=" padding: 10px 10px 10px 10px">
            <table width="100%">
              <td>
                <span><strong  class="nama"> </strong></span>
              </td>
              <td>
                
            <div id="btn_assign_my" style="text-align: center;display: none"><button class="btn btn-primary btn-xs" onclick="assigment()">Assign Chat</button></div>
              </td>
              <td>
                <span class="pull-right"><strong  class="no_hp"> </strong></span>    
              </td>
            </table>
            
            
          </div>
        </div>
        <div class="headind_srch_all" style="display: none;">
              <div style=" padding: 10px 10px 10px 10px">
                <span><strong  class="nama_all"> </strong></span>
                 <span ><button class="btn btn-primary btn-xs" onclick="assigment_all()">Assignment All Chat</button></span>
                <span class="pull-right"><strong  class="no_hp_all"> </strong></span></div>
        </div>
        <div class="mesgs" >
          <div class="msg_history">
            <div id="chatu"> 
            </div>
            <div id="chatu_all" style="display: none"> 
            </div>

          </div>
  

        <div class="chat-text" style="display: flex;bottom: 0;
position: fixed;
width: 39%;
margin-left: -20px;background: #fff;">

          <div style="width: 100%;padding: 10px;position: relative;">
            <div id="img-preview">
              <!--img src="https://mdbootstrap.com/wp-content/uploads/2018/02/modal-new.jpg"><a id="rmv-img">×</a-->
              </div>
              <textarea class="text-input" id="text-chat" onkeyup="adjustHeight(this)"  rows="1"></textarea>  
            </div>
            <div class="btn-send-panel">
              <!--input type="file" id="attach_pick" style="display: none" accept="*"-->
              <input type="file" id="file_pick" style="display: none" accept="*">
              <a href="" id="btn-file">
                <i class="fa fa-paperclip fa-2x"></i>
              </a>
              <!--a href="" id="btn-file">
                <i class="fa fa-file-photo-o fa-2x"></i>
              </a-->
              <a href="" id="btn-send">
                <i class="fa fa-send fa-2x fa-rotate-45"></i>
              </a>
            </div>
          </div>


          <!-- send all -->

           <div class="chat-text-all" style="display: none;bottom: 0;
position: fixed;
width: 39%;
margin-left: -20px;background: #fff;">

          <div style="width: 100%;padding: 10px;position: relative;">
            <div id="img-preview-all">
              <!--img src="https://mdbootstrap.com/wp-content/uploads/2018/02/modal-new.jpg"><a id="rmv-img">×</a-->
              </div>
              <textarea class="text-input" id="text-chat-all"  rows="1"></textarea>  
            </div>
            <div class="btn-send-panel">
              <!--input type="file" id="attach_pick" style="display: none" accept="*"-->
              <input type="file" id="file_pick_all" style="display: none" accept="*">
              <a href="" id="btn-file-all">
                <i class="fa fa-paperclip fa-2x"></i>
              </a>
              <!--a href="" id="btn-file">
                <i class="fa fa-file-photo-o fa-2x"></i>
              </a-->
              <a href="" id="btn-send-all">
                <i class="fa fa-send fa-2x fa-rotate-45"></i>
              </a>
            </div>
          </div>

        </div>
      </div>
      <div class="inbox_people3" style="padding:0px 0px 0px 0px !important;display: none;">
        <div class="mesgs" style="overflow-y: scroll;padding: 0px 10px 0 10px !important">
          <div class="msg_history1" style="overflow-x: hidden;">
            <div class="col-md-12 col-sm-12 flex flex-column p-0">
<!-- <div class="col-md-12 col-sm-12 flex flex-column p-0" style="height:calc(100vh - 100px);"> -->

             <div class="row" style="padding: 5px 15px;">
               <div class="col-md-12" style="padding:0px"> 


                <ul class="nav nav-pills">
                 <li class="active">
                  <a id="a1" class="nav-link btn-tab" href="#profile_user" role="tab" data-toggle="tab" style="font-size: 11px">Profile</a>
                </li>
                <li class="nav-item">
                  <a id="a2" class="nav-link btn-tab" href="#history_ticket" role="tab" data-toggle="tab" style="font-size: 11px">Ticket History</a>
                </li>
                <li >
                  <button class="nav-link btn btn-sm active btn-success bt_chat" onclick="createTicket()"  role="tab" data-toggle="tab" style="font-size: 11px"> Create Ticket</button>
                </li>
                <li class="nav-item">
                  <button class="nav-link btn btn-sm btn-warning bt_chat" onclick="show_closed()" role="tab" data-toggle="tab" style="font-size: 11px">Close Chat</button>
                </li>
                <li class="nav-item">
                  <button class="nav-link btn btn-sm btn-primary btn-daftar" role="tab" data-toggle="tab" style="font-size: 11px" disabled="">Create Account</button>
                </li>
                <!--li class="nav-item">
                  <button class="nav-link btn btn-sm bt_chat" role="tab" onclick="new_customer()" data-toggle="tab" style="background: #00d1b2;font-size: 11px;color: white">New Customer</button>
                </li-->

              </ul>


               <!--  <button class="btn btn-primary btn-circle btn-sm" onclick="createTicket()"> <i class="fa fa-ticket"></i> Create Ticket</button>

                <input data-toggle="toggle" value="1" type="checkbox" id="status_wa" data-width="120px" data-on="Complete" data-off="Not Complete"> -->

              </div>
            </div>
            <div class="tabs-custom" id="profile_user">
              <div style="border-radius: 5px;border: 0px solid #ccc; margin-bottom: 10px; padding: 0 15px;display: none">


                <div class="form-group" style="margin-bottom: 0px;">
                  <div class="input-group" style="margin-right:-1px">
                    <input type="text" id="seach_cus" class="form-control" placeholder="Search Customer Phone">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-primary" id="btn-search" style="padding:6px 12px;"><i class="fa fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <div style="border-radius: 5px;border: 1px solid #ccc; margin-bottom: 10px;font-size: 10px">
                <div class="form-group" style="margin-bottom: 0px;display: flex;">
                  <label class="col-md-12 col-sm-12" style="font-size: 1.3em;">Customer's Information <span id="pnumber"></span></label>
                </div>

                <div class="form-group cus-field-info">
                  <label class="col-md-5 col-sm-5" for="callback">Current Tier</label>
                  <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tcurrent_slab"></span></label>
                  <input type="hidden" name="current_slab" value="">
                </div>
                <div class="form-group cus-field-info">
                  <label class="col-md-5 col-sm-5" for="callback">Loyalty Points</label>
                  <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tloyalty_points"></span></label>
                  <input type="hidden" name="loyalty_points" value="">
                </div>
                <div class="form-group cus-field-info">
                  <label class="col-md-5 col-sm-5" for="callback">Registered on</label>
                  <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tregistered_on"></span></label>
                  <input type="hidden" name="registered_on" value="">
                </div>
                <div class="form-group cus-field-info">
                  <label class="col-md-5 col-sm-5" for="callback">Registered Store</label>
                  <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tregistered_store"></span></label>
                  <input type="hidden" name="registered_store" value="">
                </div>
                <div class="form-group cus-field-info">
                  <label class="col-md-5 col-sm-5" for="callback">Subsidiary</label>
                  <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tsubsidiary"></span></label>
                  <input type="hidden" name="subsidiary" value="">
                </div>
                <div class="form-group cus-field-info">
                  <label class="col-md-5 col-sm-5" for="callback">Birthdate</label>
                  <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tdob_mom"></span></label>
                  <input type="hidden" name="dob_mom" value="">
                </div>
                <div class="form-group cus-field-info">
                  <label class="col-md-5 col-sm-5" for="callback">Anniversary Date</label>
                  <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tanniversary_date"></span></label>
                  <input type="hidden" name="anniversary_date" value="">
                </div>
                <div class="form-group cus-field-info">
                  <label class="col-md-5 col-sm-5" for="callback">Fraud Status</label>
                  <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tfraud_status"></span></label>
                  <input type="hidden" name="fraud_status" value="">
                </div>
                <div class="form-group cus-field-info">
                  <label class="col-md-5 col-sm-5" for="callback">Gender</label>
                  <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tgender"></span></label>
                  <input type="hidden" name="gender" value="">
                </div>
                <div class="form-group cus-field-info">
                  <label class="col-md-5 col-sm-5" for="callback">Email</label>
                  <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="temail"></span></label>
                  <input type="hidden" name="email" value="">
                </div>

                <br> 

                <div class="form-group" style="display: flex;">
                  <label class="col-md-12"  style="font-size: 1.3em;">Transaction Summary</label>
                </div>
                <div class="form-group cus-field-info">
                  <label class="col-md-5 col-sm-5" for="callback">First Sale Date</label>
                  <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tfirst_sale_date"></span></label>
                  <input type="hidden" name="first_sale_date" value="">
                </div>
                <div class="form-group cus-field-info">
                  <label class="col-md-5 col-sm-5" for="callback">Last Modified Date</label>
                  <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tlast_modified_date"></span></label>
                </div>
                <div class="form-group cus-field-info">
                  <label class="col-md-5 col-sm-5" for="callback">Last Sale Amount</label>
                  <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tlast_sale_amount"></span></label>
                  <input type="hidden" name="last_sale_amount" value="">
                </div>
                <div class="form-group cus-field-info">
                  <label class="col-md-5 col-sm-5" for="callback">Last Sale Date</label>
                  <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tlast_sale_date"></span></label>
                  <input type="hidden" name="last_sale_date" value="">
                </div>
                <div class="form-group cus-field-info">
                  <label class="col-md-5 col-sm-5" for="callback">Last 12 Month Sale Amount</label>
                  <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tlast_twelve_mon_sale"></span></label>
                  <input type="hidden" name="last_twelve_mon_sale" value="">
                </div>

                <br> 

                <div class="form-group" style="display: flex;">
                  <label class="col-md-12"  style="font-size: 1.3em;">Customer's Address</label>
                </div>
                <div class="form-group cus-field-info">
                  <label class="col-md-5 col-sm-5" for="callback">Home Address</label>
                  <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="taddress"></span></label>
                  <input type="hidden" name="address_one_home_one" value="">
                </div>
                <div class="form-group cus-field-info">
                  <label class="col-md-5 col-sm-5" for="callback">Zip/Postal Code</label>
                  <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tzip_code"></span></label>
                  <input type="hidden" name="zip_code" value="">
                </div>
                <div class="form-group cus-field-info">
                  <label class="col-md-5 col-sm-5" for="callback">City</label>
                  <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tcity_one"></span></label>
                  <input type="hidden" name="city_one" value="">
                </div>
                <div class="form-group cus-field-info">
                  <label class="col-md-5 col-sm-5" for="callback">Province</label>
                  <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tprovince_one"></span></label>
                  <input type="hidden" name="province_one" value="">
                </div>
                <div class="form-group cus-field-info">
                  <label class="col-md-5 col-sm-5" for="callback">Country of Origin</label>
                  <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tcountry_origin"></span></label>
                  <input type="hidden" name="country_origin" value="">
                </div>



              </div>








              <div style="border-radius: 5px;border: 1px solid #ccc; margin-top: 10px; padding: 0 15px;display:none;" id="btn-update-panel">
                <div class="form-group" style="margin-bottom: 0px;">
                  <div class="col-md-12" style="margin-right:-1px;padding:0;">
                    <button type="button" class="btn btn-primary btn-sm" id="btn-update" style="width:100%;">Edit Profile</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

            <div class="tabs-custom" id="history_ticket" style="display: none">
              <div style="border-radius: 5px;border: 0px solid #ccc; margin-bottom: 10px; padding: 0 15px;">
                <div class="form-group" style="display: flex;">
                  <label class="col-md-12"  style="font-size: 1.3em;">Ticket History</label>
                </div>
                <div>
                  <table class="table history-ticket" id="table-ticket">
                    <thead>
                      <tr>
                        <th>Ticket ID</th>
                        <th>Category</th>
                        <th>Subject</th>
                        <th>Source</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>


  </div>
</div>
</div>


<!-- Modal New -->
<div id="new-customer" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" style="width: 100%;height: 100%;margin-top:0;">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="title-form-new"><?=isset($data)?'Update Customer Data':'New Customer Registration'?></h4>
      </div>
      <div class="modal-body">
        <form method="post" id="form-new">
          <p id="warning" style="color:red;text-align:center;"></p>
          <div class="alert" id="alert-update" style="display: none;text-align: center;"></div>
          <div class="row">
            <div class="col-md-4 col-sm-4">
              <input type="hidden" name="action" id="action" value="<?=isset($data)?'update':'new'?>">
              <div class="form-group">
                <label class="form-label">First Name<span class="required">*</span></label>
                <input type="text" name="firstname" id="nfname" class="form-control" value="<?=isset($nfname)?$nfname:''?>">
                <span class="info"></span>
              </div>
            </div>
            <div class="col-md-4 col-sm-4">
              <div class="form-group">
                <label class="form-label">Last Name<span class="required">*</span></label>
                <input type="text" name="lastname" id="nlname" class="form-control" value="<?=isset($nlname)?$nlname:''?>">
                <span class="info"></span>
              </div>
            </div>
            <div class="col-md-4 col-sm-4">
              <div class="form-group">
                <label class="form-label">Email<span class="required">*</span></label>
                <input type="email" name="email" id="nemail" class="form-control" value="<?=isset($nemail)?$nemail:''?>">
                <span class="info"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 col-sm-4">
              <div class="form-group">
                <label class="form-label">Mobile Number<span class="required">*</span></label>
                <input type="text" name="mobile" id="nphone" class="form-control" value="<?=isset($nphone)?$nphone:''?>">
                <span class="info"></span>
              </div>
            </div>
            <div class="col-md-4 col-sm-4">
              <div class="form-group">
                <label class="form-label">Bar Code<span class="required">*</span></label>
                <input type="text" name="external_id" id="nbarcode" class="form-control" value="<?=isset($nbarcode)?$nbarcode:''?>">
                <span class="info"></span>
              </div>
            </div>
            <div class="col-md-4 col-sm-4">
              <div class="form-group">
                <label class="form-label">Gender<span class="required">*</span></label>
                <div class="col-md-12 col-sm-12 p-0">
                  <label class="radio-inline" style="margin-right: 25px;">
                    <input type="radio" name="field[gender]" value="MALE" id="ngender_MALE" <?=isset($ngender) && $ngender=='MALE'?'checked':''?>> Male
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="field[gender]" value="FEMALE" id="ngender_FEMALE" <?=isset($ngender) && $ngender=='FEMALE'?'checked':''?>> Female
                  </label>
                  <span class="info"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 col-sm-4">
              <div class="form-group">
                <label class="form-label">Birthday<span class="required">*</span></label>
                <input type="text" name="field[dob_mom]" id="ndob_mom" class="form-control datepicker" value="<?=isset($ndob_mom)?$ndob_mom:''?>">
                <span class="info"></span>
              </div>
            </div>
            <div class="col-md-4 col-sm-4">
              <div class="form-group">
                <label class="form-label">Country of Origin<span class="required">*</span></label>
                <input type="text" name="field[country_origin]" id="ncountry_origin" class="form-control" value="<?=isset($ncountry_origin)?$ncountry_origin:''?>">
                <span class="info"></span>
              </div>
            </div>
            <div class="col-md-4 col-sm-4">
              <div class="form-group">
                <label class="form-label">Company</label>
                <input type="text" name="field[company]" id="ncompany" class="form-control" value="<?=isset($ncompany)?$ncompany:''?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 col-sm-4">
              <div class="form-group">
                <label class="form-label">Address 1<span class="required">*</span></label>
                <input type="text" name="field[address_one_home_one]" id="nadd1" class="form-control" value="<?=isset($nadd1)?$nadd1:''?>">
                <span class="info"></span>
              </div>
            </div>
            <div class="col-md-4 col-sm-4">
              <div class="form-group">
                <label class="form-label">Address 2</label>
                <input type="text" name="field[address_one_home_two]" id="nadd2" class="form-control" value="<?=isset($nadd2)?$nadd2:''?>">
              </div>
            </div>
            <div class="col-md-4 col-sm-4">
              <div class="form-group">
                <label class="form-label">Province<span class="required">*</span></label>
                <select class="form-control select2" name="field[province_one]" id="nprovince">
                  <?php
                  foreach ($province as $key => $v) {
                    echo '<option value="'.$v['text'].'">'.$v['text'].'</option>';
                  }
                  ?>
                </select>
                <span class="info"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 col-sm-4">
              <div class="form-group">
                <label class="form-label">City<span class="required">*</span></label>
                <select class="form-control select2" name="field[city_one]" id="ncity">
                  <?php
                  //foreach ($city as $key => $v) {
                    //$sel = $fields['city_one']==$v['text']?'selected':'';
                    //echo '<option value="'.$v['text'].'" '.$sel.'>'.$v['text'].'</option>';
                  //}
                  ?>
                </select>
                <span class="info"></span>
              </div>
            </div>
            <div class="col-md-4 col-sm-4">
              <div class="form-group">
                <label class="form-label">District<span class="required">*</span></label>
                <select class="form-control select2" name="field[district_one]" id="ndistrict">
                  <?php
                  //foreach ($district as $key => $v) {
                    //$sel = $fields['district_one']==$v['text']?'selected':'';
                    //echo '<option value="'.$v['text'].'" '.$sel.'>'.$v['text'].'</option>';
                  //}
                  ?>
                </select>
                <span class="info"></span>
              </div>
            </div>
            <div class="col-md-4 col-sm-4">
              <div class="form-group">
                <label class="form-label">Zip Code<span class="required">*</span></label>
                <input type="text" name="field[zip_code]" id="nzip_code" class="form-control" value="<?=isset($nzip_code)?$nzip_code:''?>">
                <span class="info"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 col-sm-4">
              <div class="form-group">
                <label class="form-label">Subsidiary<span class="required">*</span></label>
                <select class="form-control select2" name="field[subsidiary]" id="nsubsidiary">
                 <?php
                  foreach ($subsidiary as $key => $v) {
                    //$sel = $fields['subsidiary']==$v['text']?'selected':'';
                    echo '<option value="'.$v['text'].'">'.$v['text'].'</option>';
                  }
                ?>
                </select>
                <span class="info"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="form-group">
                <label class="form-label">Brand Interest<span class="required">*</span></label>
                <div class="col-md-12 col-sm-12 p-0">
                  <label class="checkbox-inline" style="margin-right: 25px;">
                    <input type="checkbox" name="field[brand_interest][]" class="bi" id="bi_mothercare" value="Mothercare"> Mothercare
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="field[brand_interest][]" class="bi" id="bi_elc" value="ELC"> ELC
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="field[brand_interest][]" class="bi" id="bi_gingersnaps" value="Gingersnaps"> Gingersnaps
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="field[brand_interest][]" class="bi" id="bi_justice" value="Justice"> Justice
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="field[brand_interest][]" class="bi" id="bi_wilio" value="Wilio"> Wilio
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="field[brand_interest][]" class="bi" id="bi_coach" value="Coach"> Coach
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="field[brand_interest][]" class="bi" id="bi_karen_millen" value="Karen Millen"> Karen Millen
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="field[brand_interest][]" class="bi" id="bi_women_secret" value="Women Secret"> Women Secret
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="field[brand_interest][]" class="bi" id="bi_havaianas" value="Havaianas"> Havaianas
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="field[brand_interest][]" class="bi" id="bi_kanmoretail" value="Kanmoretail"> Kanmoretail
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="field[brand_interest][]" class="bi" id="bi_kate_spade" value="Kate Spade"> Kate Spade
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="field[brand_interest][]" class="bi" id="bi_nespresso" value="Nespresso"> Nespresso
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="form-group">
                <label class="form-label">We would like to keep you updated on new products, services and exclusive offers. Please tick below if you:</label>
                <div class="col-md-12 col-sm-12 p-0">
                  <label class="checkbox-inline" style="margin-right: 25px;">
                    <input type="checkbox"> DO NOT wish to receive any form of marketing & promotion communication from us
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="btn-reg">Register</button>
        </div>
      </div>
    </form>
  </div>
</div>





<!-- modal status -->
<div class="modal fade" id="modal-status">
  <div class="modal-dialog modal-custom full">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal-status-title">Close Ticket</h4>
      </div>
      <form role="form" id="status-form">
          <div class="modal-body">
            <input type="hidden" name="user_id" id="user_id" value="<?=$number?>">
            <input type="hidden" name="tick_ids" id="tick_ids" value="12">
            <input type="hidden" name="status_chat" id="status_chat" value="5">
          <div class="row">
            <div class="col-md-11 px-20" style="width: 96%;">
              <div class="form-group">
                <label for="comment">Note</label>
                <textarea class="form-control" id="status-note"></textarea>
              <input type="hidden" name="status_note">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- modal status -->



<!-- assign -->



<!-- modal status -->
<div class="modal fade" id="modal-assign">
  <div class="modal-dialog modal-custom" style="width: 40% !important">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal-status-title">Select Agent</h4>
      </div>
      <form role="form" id="form-assign">
          <div class="modal-body">
            <input type="hidden" name="user_id" id="user_id" value="<?=$number?>">            
          <div class="row">
            <div class="col-md-11 px-20" style="width: 96%;">
               <div class="form-group">
                <label for="comment">No. Wa</label>
                <input type="" name="hp" id="hp_assign" class="form-control" readonly="">
              
              
              </div>

              <div class="form-group">
                
                <label for="comment">Agent</label>
                <span id="refresh_ag">
                <select class="form-control" id="agent_ass">
                  <option value="">---Agent---</option>
                  <?php foreach ($agent as $key => $v): ?>
                    <option value="<?=$v->number ?>"><?=$v->number ?> - <?=$v->name ?></option>
                  <?php endforeach ?>
                </select>
              </span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Assigment</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- modal status -->


</body>
</html>

<script src="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.js"></script>
<!--script src="<?php echo base_url(); ?>assets/plugins/datatables/datatables-bulma/js/dataTables.bulma.min.js"></script-->
<script src="<?=base_url('assets/dist/js/autobahn.js')?>"></script>
<script src="<?=base_url()?>assets/plugins/ckeditor/ckeditor.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
<script>

  var url_base = '<?=base_url()?>';
  var url_socket = 'kanmo-web.dutamedia.com';//'<?=str_replace('https://','',str_replace('http://','',$_SERVER['SERVER_NAME']))?>'
var tabn=1;
var buka='';
<?php if ($status_chat==false): ?>         
    var Tplay_pause='Play';
<?php else: ?>
    var Tplay_pause='Stop';
<?php endif ?>
function tab_chat(a){
	 tabn=a;
  if(a==0){
    $('.bt_chat').attr('disabled','disabled')
    $('#chatu_all').css('display','')            
    $('#chatu').css('display','none')    
    $('.headind_srch').css('display','none')  
    $('.headind_srch_all').css('display','')


    $('#dashboardmy').css('display','none')  
    $('#dashboardall').css('display','')

    if(hpChat_all!=''){
      $('.chat-text-all').css('display','flex')  
      $('.chat-text').css('display','none')  
    }else{
       $('.chat-text').css('display','none')  
    }
     
  }
  if(a==1){ 

    $('#dashboardmy').css('display','')  
    $('#dashboardall').css('display','none')
 	
    $('.headind_srch').css('display','')  
    $('.headind_srch_all').css('display','none')
    $('.bt_chat').removeAttr('disabled','disabled')
    $('#chatu').css('display','')            
    $('#chatu_all').css('display','none')    
    if(hpChat!=''){
    $('.chat-text').css('display','flex')      
    $('.chat-text-all').css('display','none')
    }else{
       $('.chat-text-all').css('display','none')  
    }
  }
  if(a==2){
    if(Tplay_pause=='Play'){

         $.ajax({
            url: '<?=base_url('wa/status_chat')?>',
            type: 'post',
            dataType: 'json',
            data: {status:'stop',ext:'<?php echo $number ?>'},
          }).done(function(res){
            if(res.status){
               Tplay_pause='Stop'
                
        $('.play_pause').html('<i class="fa fa-pause-circle"></i>Offline Chats');
              
            }else{
              if(res.code==200){
                $.each(res.e, function(key,msg){
                  var info = $('[name="'+key+'"]').closest('.form-group').find('.info');
                        info.html(msg);
                      });
              }else{
                $().toastmessage('showToast', {
                          text     : 'Close chat failed',
                          position : 'top-center',
                          type     : 'error',
                          
                        });
              }
            }
          }).fail(function(xhr, status, error){
            $.post('<?=base_url('logger/writexhrlog')?>', {'xhr':xhr, 'act':'save_closed', 'error':error, 'status':status});
            alert('Something goes wrong, please call your aplication vendor');
            console.log(xhr);
            console.log(status);
            console.log(error);
          });


       
    }
    else if(Tplay_pause=='Stop'){
      


         $.ajax({
            url: '<?=base_url('wa/status_chat')?>',
            type: 'post',
            dataType: 'json',
            data: {status:'play',ext:'<?php echo $number ?>'},
          }).done(function(res){
            if(res.status){
        Tplay_pause='Play'
        $('.play_pause').html('<i class="fa fa-play-circle"></i>Online Chats');
        
            }else{
              if(res.code==200){
                $.each(res.e, function(key,msg){
                  var info = $('[name="'+key+'"]').closest('.form-group').find('.info');
                        info.html(msg);
                      });
              }else{
                $().toastmessage('showToast', {
                          text     : 'Close chat failed',
                          position : 'top-center',
                          type     : 'error',
                          
                        });
              }
            }
          }).fail(function(xhr, status, error){
            $.post('<?=base_url('logger/writexhrlog')?>', {'xhr':xhr, 'act':'save_closed', 'error':error, 'status':status});
            alert('Something goes wrong, please call your aplication vendor');
            console.log(xhr);
            console.log(status);
            console.log(error);
          });

    }
  }
    

}

{      var toolbars = [{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Font','FontSize','Bold', 'Italic','Underline'] }, { name: 'colors', items: [ 'TextColor', 'BGColor' ] },{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'] },{ name: 'links', items: [ 'Link', 'Unlink' ] }];
   }   CKEDITOR.replace('status-note',{height:250,toolbar:toolbars,removePlugins: 'elementspath',resize_enabled: true});
  function show_closed(){
      close_chat();
    }

  function close_chat(){

     var wa_number=hpChat;
           $.ajax({
            url: '<?=base_url('wa/save_closed')?>',
            type: 'post',
            dataType: 'json',
            data: $('#status-form').serialize()+'&phone='+wa_number,
          }).done(function(res){
            if(res.status){
              $().toastmessage('showToast', {
                        text     : 'Close chat success',
                        position : 'top-center',
                        type     : 'success',
                        close    : function () {
                          location.reload();
                        }
                      });
              //location.reload();
            }else{
              if(res.code==200){
                $.each(res.e, function(key,msg){
                  var info = $('[name="'+key+'"]').closest('.form-group').find('.info');
                        info.html(msg);
                      });
              }else{
                $().toastmessage('showToast', {
                          text     : 'Close chat failed',
                          position : 'top-center',
                          type     : 'error',
                          
                        });
              }
            }
          }).fail(function(xhr, status, error){
            $.post('<?=base_url('logger/writexhrlog')?>', {'xhr':xhr, 'act':'save_closed', 'error':error, 'status':status});
            alert('Something goes wrong, please call your aplication vendor');
            console.log(xhr);
            console.log(status);
            console.log(error);
          });
   
  }

  /*function chek_ticket(){
     var wa_number=hpChat;
     $.ajax({
            url : "<?=base_url('wa/chek_ticket/').$type?>"+"?agent="+<?php echo $number ?>,            
            type: 'post',
            dataType: 'json',
            data : {'phone':wa_number},
          }).done(function(res){
            if(res.id!=0){
              $('#tick_ids').val(res.id)
              $('#status_chat').val(1)

      $('#modal-status').modal('show');
               
             
            }else{
              $('#status_chat').val(0)              
              close_chat();
              return false;            
            }
          }).fail(function(xhr, status, error){
            $.post('<?=base_url('logger/writexhrlog')?>', {'xhr':xhr, 'act':'save_closed', 'error':error, 'status':status});
            alert('Something goes wrong, please call your aplication vendor');
            console.log(xhr);
            console.log(status);
            console.log(error);
          });
  }*/

  $('#status-form').on('submit', function(e){
          e.preventDefault();
          var asgnote = CKEDITOR.instances['status-note'].getData();
          $('[name="status_note"]').val(asgnote);
          var dt = $(this).serialize();
          //alert(dt);
          $.ajax({
            url: '<?=base_url('api/ticket/save_closed')?>',
            type: 'post',
            dataType: 'json',
            data: $(this).serialize()
          }).done(function(res){
            if(res.status){
              $().toastmessage('showToast', {
                        text     : 'Close ticket success',
                        position : 'top-center',
                        type     : 'success',
                        close    : function () {
                          location.reload();
                        }
                      });
              //location.reload();
            }else{
              if(res.code==200){
                $.each(res.e, function(key,msg){
                  var info = $('[name="'+key+'"]').closest('.form-group').find('.info');
                        info.html(msg);
                      });
              }else{
                $().toastmessage('showToast', {
                          text     : 'Close ticket failed',
                          position : 'top-center',
                          type     : 'error',
                          
                        });
              }
            }
          }).fail(function(xhr, status, error){
            $.post('<?=base_url('logger/writexhrlog')?>', {'xhr':xhr, 'act':'save_closed', 'error':error, 'status':status});
            alert('Something goes wrong, please call your aplication vendor');
            console.log(xhr);
            console.log(status);
            console.log(error);
          });
      });


  var conn = new ab.Session('ws://'+url_socket+':8080',
    function () {
      conn.subscribe('wa<?php echo $number ?>', function (topic, data) {
        // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
        console.log('Receive new chat "' + data.dashboard + '" : ');
        console.log(data);

        $('.queue_m').text(data.dashboard.result_my.queue)
        $('.received').text(data.dashboard.result_my.recieve)   
        $('.sent').text(data.dashboard.result_my.send)                  
        $('.all').text(data.dashboard.result_my.total)


        $('.queue_all').text(data.dashboard.result_my.queue)
        $('.received_all').text(data.dashboard.result_all.recieve)   
        $('.sent_all').text(data.dashboard.result_all.send)                  
        $('.all_all').text(data.dashboard.result_all.total)
        var v=data.data;

        var endchat = '';
        var flag='';
        if(v.flag==1){
            flag='<span class="badge badge-danger badge-'+v.wa_number+'" style="background: red">'+data.history_chat+'</span>';
        }
        endchat+='<div class="chat_list active_chat '+v.wa_number+'"" onclick="setHp('+v.wa_number+');'+
        'openchat('+v.wa_number+',\''+v.wa_customer+'\')">'+
        '<div class="chat_people">'+
        '<div class="chat_img">'+
        '<img src="https://ptetutorials.com/images/user-profile.png">'+
        '</div>'+
        '<div class="chat_ib">'+
        '<h5 class="chat_people_header">'+v.wa_customer+''+flag+'</h5>'+
        '<div class="chat_date">'+v.date+' - '+v.time +'</div>'+
        '<p class="ellipsis">'+v.wa_text+'</p>'+
        '</div>'+
        '</div>'+
        '</div>';
        if(v.id !== undefined && v.id.substring(0, 5) === 'false' ) {
	        var promise =$('#myAudio')[0].play(); 

	        if (promise) {
	          //Older browsers may not return a promise, according to the MDN website
	          promise.catch(function(error) { console.error(error); });
	        }
	    }

        $('.'+v.wa_number).remove();
       // $('.inbox_chat').prepend(endchat);
        $.when($('.inbox_chat').prepend(endchat)).then(function(){
        if(hpChat!='' && hpChat==v.wa_number && tabn==1){ 
        
          $('.chat_list').removeClass('active_chat');
          $('.'+hpChat).addClass('active_chat');
        }else{
              $('.chat_list').removeClass('active_chat');
              $('.'+hpChat).addClass('active_chat');
        }   
      })


        if(hpChat!='' && hpChat==v.wa_number ){

          var img = '';

                  if(v.wa_images!=null){
                img = '<a href="'+url_base+'assets/wa_images/'+v.wa_images+'" data-fancybox="images"><img src="'+url_base+'assets/wa_images/'+v.wa_images+'" width="300px"></a><br>';
              }

             if(v.jenis==1){
              im = '<a href="'+url_base+'assets/wa_images/'+v.image+'" data-fancybox="images"><img src="'+url_base+'assets/wa_images/'+v.image+'" width="200px"></a><br>';
              }
              else if(v.jenis==2){
              im = '<a href="'+url_base+'assets/wa_files/'+v.file+'" data-fancybox="images"><img src="'+url_base+'assets/images/file.png" width="50px"></a><br>';
              }

          chats='';
          if(v.is_reply==1){
            /*chats+='<div class="incoming_msg">'+
            '<div class="incoming_msg_img">'+
            '<img src="https://ptetutorials.com/images/user-profile.png">'+
            '</div>'+
            '<div class="received_msg">'+
            '<div class="received_withd_msg">'+
            '<p>'+img +' '+v.wa_text+'</p>'+
            '<span class="time_date">'+ v.time+' | '+v.date+'</span>'+
            '</div>'+
            '</div>'+
            '</div>';*/

            if(v.quoteText==null && v.quoteImage==null){
                chats+='<div class="incoming_msg">'+
                '<div class="incoming_msg_img">'+
                '<img src="https://ptetutorials.com/images/user-profile.png">'+
                '</div>'+
                '<div class="received_msg">'+
                '<div class="received_withd_msg">'+
                '<p>'+img +' '+v.wa_text+'</p>'+
                '<span class="time_date">'+ v.time+' | '+v.date+'</span>'+
                '</div>'+
                '</div>'+
                '</div>';


                }else if(v.quoteImage!=null){


	            chats+='<div class="incoming_msg">'+
	            '<div class="incoming_msg_img">'+
	            '<img src="https://ptetutorials.com/images/user-profile.png">'+
	            '</div>'+
	            '<div class="received_msg">'+
	            '<div class="received_withd_msg_r">'+
	            
	            '<div class="box_reply">'+
	            '<div class="reply row max-lines">'+
	            '<div  class="col-md-10"  style="padding: 0px">'+v.quoteText+'</div><div class="col-md-2" style="padding: 0px"><img src="'+url_base+'assets/wa_images/'+v.quoteImage+'" style="width:100%;"></div></div>'+v.wa_text+'</div>'+
	            '<span class="time_date">'+ v.time+' | '+v.date+'</span>'+
	            '</div>'+
	            '</div>'+
	            '</div>';
	          }else if(v.quoteText!=null){

	            chats+='<div class="incoming_msg">'+
	            '<div class="incoming_msg_img">'+
	            '<img src="https://ptetutorials.com/images/user-profile.png">'+
	            '</div>'+
	            '<div class="received_msg">'+
	            '<div class="received_withd_msg_r">'+
	            
	            '<div class="box_reply">'+
	            '<div class="reply row max-lines">'+
	            '<div  class="col-md-12"  style="padding: 0px">'+v.quoteText+'</div></div>'+v.wa_text+'</div>'+
	            '<span class="time_date">'+ v.time+' | '+v.date+'</span>'+
	            '</div>'+
	            '</div>'+
	            '</div>';

	          }
            
          }else{
         

             chats+='<div class="outgoing_msg">'+
                '<div class="sent_msg">'+
                '<p>'+img +' '+v.wa_text+'</p>'+
                '<span class="time_date"><span style="background:#fff5f5" class="'+v.ack_id+'"><img src="'+url_base+'assets/images/send.png" width="15px" height="15px">'+ v.time+' | '+v.date+' <span class="assign pull-right '+v.status_chat+'" style="font-size: 0.9em;color: #999;margin-top: -8px;"><i class="fa fa-reply"></i> Replied by '+v.agent_name+'</span></span>'+
                '</div>'+
                '</div>';

          }
          if(tabn==1){
            $('#chatu').css('display','')            
            $('#chatu_all').css('display','none')
          }
          if(tabn==0){
            $('#chatu_all').css('display','')            
            $('#chatu').css('display','none')
          }
          $('#chatu').append(chats);

          //$('.update_agent').html('<i class="fa fa-reply"></i> Replied by '+v.agent+'')
          if ($('#chatu').height() > $('.msg_history').height()) {
            $('.msg_history').animate({
              scrollTop: $('#chatu')[0].scrollHeight
            }, 200);
          }
        }

      });

      conn.subscribe('wa-rm<?php echo $number ?>', function (topic, data) {
        //console.log('remove');
        //console.log(data);
        $('.inbox_chat .chat_list.'+data.data.wa_number).remove();
        $('#chatu .incoming_msg.private'+data.data.wa_number).remove();
        $('#chatu .outgoing_msg.private'+data.data.wa_number).remove();        
        $('.nama').text('');
        $('.no_hp').text('');
      })
      conn.subscribe('wa-all', function (topic, data) {
        console.log('all');
        console.log(data);
        var nolistchatting='';

          nolistchatting=hpChat_all;
        /*if(tabn==0){
          nolistchatting=hpChat_all;
        }*/
      /*  else if(tabn==1){
          nolistchatting=hpChat;
        }*/

         if(data.history_chat=='open'){   
            $('.badge-'+v).text('');
            return false;
        }

//console.log(data.history_chat);

        if(data.history_chat=='ack'){
          
          
        var r='<img src="'+url_base+'assets/images/'+data.data.status+'.png" width="17px" height="17px">';   
            $('.'+data.data.id).html(r);
            return false;
        }

        
        $('.queue_m').text(data.dashboard.result_all.queue)              
        $('.all').text(data.dashboard.result_all.total)
        $('.queue_all').text(data.dashboard.result_all.queue)                 
        $('.all_all').text(data.dashboard.result_all.total)
        var v=data.data;

       
         console.log('sip');
        
        console.log('all'+JSON.stringify(v));

        var endchat = '';
        var flag='';
        if(v.flag==1){
            flag='<span class="badge badge-danger badge-'+v.wa_number+'" style="background: red">'+data.history_chat+'</span>';
        }
        //alert(v.wa_customer)
        //v.assign='ali'
        endchat+='<div class="chat_list_all active_chat_all l'+v.wa_number+'"" onclick="setHp_all('+v.wa_number+');'+
        'openchat_all('+v.wa_number+',\''+v.wa_customer+'\')">'+
        '<div class="chat_people">'+
        '<div class="chat_img">'+
        '<img src="https://ptetutorials.com/images/user-profile.png">'+
        '</div>'+
        '<div class="chat_ib">'+
        '<h5 class="chat_people_header">'+v.wa_customer+' '+flag+'</h5>'+
        '<div class="chat_date">'+v.date+' - '+v.time +' <span class="assign pull-right" style="font-size: 0.9em;color: #999;"><i class="fa fa-share"></i> '+(v.agent_name!==''?v.agent_name.substring(0, 10):'In Queue')+'</span></div>'+
        '<p class="ellipsis">'+v.wa_text+'</p>'+
        '</div>'+
        '</div>'+
        '</div>';

        $.when($('.l'+v.wa_number).remove()).then(function(){
          		$.when($('.allinbox_chat').prepend(endchat)).then(function(){
                
		        		if(nolistchatting==v.wa_number && nolistchatting!='' && tabn==0){    
                  
				          $('.chat_list_all').removeClass('active_chat_all');
				          $('.l'+nolistchatting).addClass('active_chat_all');
				        }else{
				          
                  $('.chat_list_all').removeClass('active_chat_all');
                  $('.l'+nolistchatting).addClass('active_chat_all');
				        }
  
        		});
        });
        

        if(nolistchatting!='' && nolistchatting==v.wa_number){

          var img = '';
           var quote_image='';
              if(v.wa_images!=null){
                img = '<a href="'+url_base+'assets/wa_images/'+v.wa_images+'" data-fancybox="images"><img src="'+url_base+'assets/wa_images/'+v.wa_images+'" width="300px"></a><br>';
              }

              if(v.wa_files!=null){
                   img = '<a href="'+url_base+'assets/wa_files/'+v.wa_files+'" data-fancybox="images"><img src="'+url_base+'assets/images/file.png" width="50px"></a><br>';
              }
              if(v.quote_image!=''){
                 quote_image = '<img src="'+url_base+'assets/wa_images/'+v.quote_image+'" width="100px" height="100px">';
              }
            

          chats='';
          if(v.is_reply==1){
            /*chats+='<div class="incoming_msg">'+
            '<div class="incoming_msg_img">'+
            '<img src="https://ptetutorials.com/images/user-profile.png">'+
            '</div>'+
            '<div class="received_msg">'+
            '<div class="received_withd_msg">'+
            '<p>'+img +' '+v.wa_text+'</p>'+
            '<span class="time_date">'+ v.time+' | '+v.date+'</span>'+
            '</div>'+
            '</div>'+
            '</div>';*/


            if(v.quoteText==null && v.quoteImage == null){
                chats+='<div class="incoming_msg">'+
                '<div class="incoming_msg_img">'+
                '<img src="https://ptetutorials.com/images/user-profile.png">'+
                '</div>'+
                '<div class="received_msg">'+
                '<div class="received_withd_msg">'+
                '<p>'+img +' '+v.wa_text+'</p>'+
                '<span class="time_date">'+ v.time+' | '+v.date+'</span>'+
                '</div>'+
                '</div>'+
                '</div>';


                }else if(v.quoteImage!=null){


            chats+='<div class="incoming_msg">'+
            '<div class="incoming_msg_img">'+
            '<img src="https://ptetutorials.com/images/user-profile.png">'+
            '</div>'+
            '<div class="received_msg">'+
            '<div class="received_withd_msg_r">'+
            
            '<div class="box_reply">'+
            '<div class="reply row max-lines">'+
            '<div  class="col-md-10"  style="padding: 0px">'+v.quoteText+'</div><div class="col-md-2" style="padding: 0px"><img src="'+url_base+'assets/wa_images/'+v.quoteImage+'" style="width:100%;"></div></div>'+v.wa_text+'</div>'+
            '<span class="time_date">'+ v.time+' | '+v.date+'</span>'+
            '</div>'+
            '</div>'+
            '</div>';
          }else if(v.quoteText!=null){

            chats+='<div class="incoming_msg">'+
            '<div class="incoming_msg_img">'+
            '<img src="https://ptetutorials.com/images/user-profile.png">'+
            '</div>'+
            '<div class="received_msg">'+
            '<div class="received_withd_msg_r">'+
            
            '<div class="box_reply">'+
            '<div class="reply row max-lines">'+
            '<div  class="col-md-12"  style="padding: 0px">'+v.quoteText+'</div></div>'+v.wa_text+'</div>'+
            '<span class="time_date">'+ v.time+' | '+v.date+'</span>'+
            '</div>'+
            '</div>'+
            '</div>';

          }



          }else{
       /*     chats+='<div class="outgoing_msg">'+
            '<div class="sent_msg">'+
            '<p>'+img +' '+v.wa_text+'</p>'+
            '<span class="time_date">'+ v.time+' | '+v.date+'</span>'+
            '</div>'+
            '</div>';*/


             chats+='<div class="outgoing_msg">'+
                '<div class="sent_msg">'+
                '<p>'+img +' '+v.wa_text+'</p>'+
                '<span class="time_date">'+ v.time+' | '+v.date+' <span class="assign pull-right '+v.status_chat+'" style="font-size: 0.9em;color: #999;margin-top: -8px;"><i class="fa fa-reply"></i> Replied by '+v.agent+'</span></span>'+
                '</div>'+
                '</div>';
          }
          
          $('#chatu_all').append(chats);


          //$('.update_agent').html('<i class="fa fa-reply"></i> Replied by '+v.agent+'')

          if ($('#chatu_all').height() > $('.msg_history').height()) {
            $('.msg_history').animate({
              scrollTop: $('#chatu_all')[0].scrollHeight
            }, 200);
          }
        }
      })
    },
    function () {
      console.warn('WebSocket connection closed');
    },{'skipSubprotocolCheck': true}
    );

    /*var conn = new WebSocket('wss://'+url_socket+'/wss2/NNN');
conn.onopen = function(e) {
    console.log("Connection established!");
    conn.subscribe('kittensCategory', function (topic, data) {
                    // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
                    console.log('New article published to category "' + topic + '" : ' + data.title);
                });
};

conn.onmessage = function(e) {
    console.log(e.data);
  };*/

  $(function(){
    $('.btn-tab').click(function(ev){
      ev.preventDefault();
      var target = $(this).attr('href');
      $('.tabs-custom').hide();
      $(target).show();
    })
  })
</script>

<script type="text/javascript">
  var hpChat='';
  var hpChat_all='';
  var wa='';

    //menampilkan pesan sisi kiri
    function last_chat(){
      $.ajax({
        url : "<?=base_url('wa/lastchat/').$type?>"+"?agent="+<?php echo $number ?>,
        type: "Get",
        dataType: 'json',
      })
      .done(function(res){

        var endchat = '';

        $.each(res.my_chat, function(i,v){
          endchat+='<div class="chat_list '+v.wa_number+'"" onclick="setHp('+v.wa_number+');'+
          'openchat('+v.wa_number+',\''+v.name+'\')">'+
          '<div class="chat_people">'+
          '<div class="chat_img">'+
          '<img src="https://ptetutorials.com/images/user-profile.png">'+
          '</div>'+
          '<div class="chat_ib">'+
          '<h5 class="chat_people_header">'+v.name;
          if(v.unread!=0){

            endchat+='<span class="badge badge-danger badge-'+v.wa_number+'" style="background: red">'+v.unread+'</span>'; 
          }
          endchat+='</h5>'+
          '<div class="chat_date">'+v.date+' - '+v.time +'</div>'+
          '<p class="ellipsis">'+v.text+'</p>'+
          '</div>'+
          '<div style="font-size:12px">'+v.assign+'</div>'+          
          '</div>'+
          '</div>'+
          '</div>';
        });
        $('.inbox_chat').html(endchat);




        var all_chat = '';
//console.log(res.all_chat);return false;
        $.each(res.all_chat, function(i,v){
          all_chat+='<div class="chat_list_all l'+v.wa_number+'"" onclick="setHp_all('+v.wa_number+');'+
          'openchat_all('+v.wa_number+',\''+v.name+'\')">'+
          '<div class="chat_people">'+
          '<div class="chat_img">'+
          '<img src="https://ptetutorials.com/images/user-profile.png">'+
          '</div>'+
          '<div class="chat_ib">'+
          '<h5 class="chat_people_header">'+v.name;
          if(v.unread!=0){

            all_chat+='<span class="badge badge-danger badge-'+v.wa_number+'" style="background: red">'+v.unread+'</span>'; 
          }
          //v.assign='ali'
          all_chat+='</h5>'+
          '<div class="chat_date">'+v.date+' - '+v.time +' <span class="assign pull-right" style="font-size: 0.9em;color: #999;"><i class="fa fa-share"></i> '+(v.assign!==undefined?v.assign.substring(0, 10):'In Queue')+'</span></div>'+
          '<p class="ellipsis">'+v.text+'</p>'+
          '</div>'+
          '</div>'+
          '</div>';
        });
        $('.allinbox_chat').html(all_chat);


        if(hpChat!='' ){    

          $('.chat_list_all').removeClass('active_chat');
          $('.l'+hpChat).addClass('active_chat');
        }

        if ($('#chatu').height() > $('.msg_history').height()) {
          $('.msg_history').animate({
            scrollTop: $('#chatu')[0].scrollHeight
          }, 200);
        }
      })
      .fail(function(jqXHR, textStatus, errorThrown){
      });
    }


    last_chat();

    $('#text-chat').keydown(function(event) {
      if (event.which == 13) {          
        event.preventDefault();

        var wa_number=hpChat;
        var imgfile = '';
        var file = '';
        if($('#img-send').length > 0){
          //imgfile = $('#img-send').attr('src');
          imgfile = $('#img-send').val();
          file = $('#filename').val();

        } else{
          imgfile = '';
        }
        $('.loading').css('display','')
        $.ajax({
          url : '<?php echo base_url("wa/send"); ?>',
          type: "POST",
          data : {'number':wa_number, 'message':$('#text-chat').val(), 'img':imgfile,'filename':file,'type':'<?=$type ?>', 'agent':<?php echo $number ?>},
          dataType: 'json',
        })
        .done(function(res){
          console.log(res);
          if(res.status==true && res.status!=200){
            im = '';
            if(imgfile!=''){
              if(res.jenis==1){
              im = '<a href="'+url_base+'assets/wa_images/'+res.image+'" data-fancybox="images"><img src="'+url_base+'assets/wa_images/'+res.image+'" width="200px"></a><br>';
              }
              else if(res.jenis==2){
              im = '<a href="'+url_base+'assets/wa_files/'+res.file+'" data-fancybox="images"><img src="'+url_base+'assets/images/file.png" width="50px"></a><br>';
              }
            }
            $('.loading').css('display','none')
            $('#text-chat').val('')
            $('#img-preview').html('');            
            // $('.update_agent').html('<i class="fa fa-reply"></i> Replied by '+res.agent+'')
          }else if(res.status==false){
        $().toastmessage('showToast', {
          text     : res.msg,
          sticky   : false,
          position : 'top-center',
          type     : 'error',
        });
           // alert(res.msg)
          }
        })
        .fail(function(jqXHR, textStatus, errorThrown){
          $.post('<?=base_url('logger/writexhrlog')?>', {'act':'calling', 'xhr':jqXHR.responseText, 'status':textStatus, 'error':errorThrown});
          alert('Error,something goes wrong');
        });


      }
    });

    /*enter send all*/
$('#btn-send-all').click(function(e){
            event.preventDefault();
        var wa_number=hpChat_all;
        var imgfileall = '';
        var fileall = '';
        if($('#img-send-all').length > 0){
          //imgfile = $('#img-send').attr('src');
          imgfileall = $('#img-send-all').val();
          fileall = $('#filename-all').val();

        } else{
          imgfileall = '';
        }
        $('.loading').css('display','')
        $.ajax({
          url : '<?php echo base_url("wa/send"); ?>',
          type: "POST",
          data : {'number':wa_number, 'message':$('#text-chat-all').val(), 'img':imgfileall,'filename':fileall,'type':'<?=$type ?>', 'agent':<?php echo $number ?>},
          dataType: 'json',
        })
        .done(function(res){
          console.log(res);
          if(res.status==true && res.status!=200){
            im = '';
            if(imgfileall!=''){
              if(res.jenis==1){
              im = '<a href="'+url_base+'assets/wa_images/'+res.image+'" data-fancybox="images"><img src="'+url_base+'assets/wa_images/'+res.image+'" width="200px"></a><br>';
              }
              else if(res.jenis==2){
              im = '<a href="'+url_base+'assets/wa_files/'+res.file+'" data-fancybox="images"><img src="'+url_base+'assets/images/file.png" width="50px"></a><br>';
              }
            }
             $('.loading').css('display','none')
             $('#text-chat-all').val('')             
             $('#img-preview-all').html('');  
            // $('.update_agent').html('<i class="fa fa-reply"></i> Replied by '+res.agent+'')
           
          }else if(res.status==false){
        $().toastmessage('showToast', {
          text     : res.msg,
          sticky   : false,
          position : 'top-center',
          type     : 'error',
        });
           // alert(res.msg)
          }
        })
        .fail(function(jqXHR, textStatus, errorThrown){
          $.post('<?=base_url('logger/writexhrlog')?>', {'act':'calling', 'xhr':jqXHR.responseText, 'status':textStatus, 'error':errorThrown});
          alert('Error,something goes wrong');
        });

  })

    $('#text-chat-all').keydown(function(event) {
      if (event.which == 13) {          
        event.preventDefault();
        var wa_number=hpChat_all;
        var imgfileall = '';
        var fileall = '';
        if($('#img-send-all').length > 0){
          //imgfile = $('#img-send').attr('src');
          imgfileall = $('#img-send-all').val();
          fileall = $('#filename-all').val();

        } else{
          imgfileall = '';
        }
        $('.loading').css('display','')
        $.ajax({
          url : '<?php echo base_url("wa/send"); ?>',
          type: "POST",
          data : {'number':wa_number, 'message':$('#text-chat-all').val(), 'img':imgfileall,'filename':fileall,'type':'<?=$type ?>', 'agent':<?php echo $number ?>},
          dataType: 'json',
        })
        .done(function(res){
          console.log(res);
          if(res.status==true && res.status!=200){
            im = '';
            if(imgfileall!=''){
              if(res.jenis==1){
              im = '<a href="'+url_base+'assets/wa_images/'+res.image+'" data-fancybox="images"><img src="'+url_base+'assets/wa_images/'+res.image+'" width="200px"></a><br>';
              }
              else if(res.jenis==2){
              im = '<a href="'+url_base+'assets/wa_files/'+res.file+'" data-fancybox="images"><img src="'+url_base+'assets/images/file.png" width="50px"></a><br>';
              }
            }
             $('.loading').css('display','none')
             $('#text-chat-all').val('')             
             $('#img-preview-all').html('');  
            // $('.update_agent').html('<i class="fa fa-reply"></i> Replied by '+res.agent+'')
          }else if(res.status==false){
        $().toastmessage('showToast', {
          text     : res.msg,
          sticky   : false,
          position : 'top-center',
          type     : 'error',
        });
           // alert(res.msg)
          }
        })
        .fail(function(jqXHR, textStatus, errorThrown){
          $.post('<?=base_url('logger/writexhrlog')?>', {'act':'calling', 'xhr':jqXHR.responseText, 'status':textStatus, 'error':errorThrown});
          alert('Error,something goes wrong');
        });


      }
    });


    $('#btn-send').click(function(e){
      e.preventDefault();
      
              event.preventDefault();

        var wa_number=hpChat;
        var imgfile = '';
        var file = '';
        if($('#img-send').length > 0){
          //imgfile = $('#img-send').attr('src');
          imgfile = $('#img-send').val();
          file = $('#filename').val();

        } else{
          imgfile = '';
        }
        $('.loading').css('display','')
        $.ajax({
          url : '<?php echo base_url("wa/send"); ?>',
          type: "POST",
          data : {'number':wa_number, 'message':$('#text-chat').val(), 'img':imgfile,'filename':file,'type':'<?=$type ?>', 'agent':<?php echo $number ?>},
          dataType: 'json',
        })
        .done(function(res){
          console.log(res);
          if(res.status==true && res.status!=200){
            im = '';
            if(imgfile!=''){
              if(res.jenis==1){
              im = '<a href="'+url_base+'assets/wa_images/'+res.image+'" data-fancybox="images"><img src="'+url_base+'assets/wa_images/'+res.image+'" width="200px"></a><br>';
              }
              else if(res.jenis==2){
              im = '<a href="'+url_base+'assets/wa_files/'+res.file+'" data-fancybox="images"><img src="'+url_base+'assets/images/file.png" width="50px"></a><br>';
              }
            }
            $('.loading').css('display','none')
            $('#text-chat').val('')
            $('#img-preview').html('');            
             //$('.update_agent').html('<i class="fa fa-reply"></i> Replied by '+res.agent+'')
          }else if(res.status==false){
        $().toastmessage('showToast', {
          text     : res.msg,
          sticky   : false,
          position : 'top-center',
          type     : 'error',
        });
           // alert(res.msg)
          }
        })
        .fail(function(jqXHR, textStatus, errorThrown){
          $.post('<?=base_url('logger/writexhrlog')?>', {'act':'calling', 'xhr':jqXHR.responseText, 'status':textStatus, 'error':errorThrown});
          alert('Error,something goes wrong');
        });


    });




    var fileTypes = ['jpg', 'jpeg', 'png', 'gif'];

    $('#file_pick').change(function () {
      var reader = new FileReader();
      var file    = document.querySelector('#file_pick').files[0];
      var ext = file.name.split('.').pop().toLowerCase(),  //file ext from input file
      isImg = fileTypes.indexOf(ext) > -1;
      reader.onloadend = function () {
        if(!isImg){
          $('#img-preview').css('display','block');
        }else{
          $('#img-preview').css('display','flex');
        }
       $('#img-preview').html('<img src="'+(isImg?reader.result:'<?=base_url('assets/images/file.png')?>')+'"><a id="rmv-img">×</a>'+(!isImg?'<div class="fname" style="text-align: center;width: 55%;">'+file.name+'</div>':'')+'<input type="hidden" name="img"  id="img-send" value="'+reader.result+'"><input type="hidden" name="filename"  id="filename" value="'+file.name+'">');
       file = '';
       $('#img-preview #rmv-img').click(function(e){
        $('#img-preview').html('');
      });
     }

      if (file) {
        reader.readAsDataURL(file); //reads the data as a URL
      } else {
      }
    });

/*upload alll*/
    var fileTypes = ['jpg', 'jpeg', 'png', 'gif'];

    $('#file_pick_all').change(function () {
      var reader = new FileReader();
      var file    = document.querySelector('#file_pick_all').files[0];
      var ext = file.name.split('.').pop().toLowerCase(),  //file ext from input file
      isImg = fileTypes.indexOf(ext) > -1;
      reader.onloadend = function () {
        if(!isImg){
          $('#img-preview-all').css('display','block');
        }else{
          $('#img-preview-all').css('display','flex');
        }
       $('#img-preview-all').html('<img src="'+(isImg?reader.result:'<?=base_url('assets/images/file.png')?>')+'"><a id="rmv-img">×</a>'+(!isImg?'<div class="fname" style="text-align: center;width: 55%;">'+file.name+'</div>':'')+'<input type="hidden" name="img"  id="img-send-all" value="'+reader.result+'"><input type="hidden" name="filename"  id="filename-all" value="'+file.name+'">');
       file = '';
       $('#img-preview-all #rmv-img').click(function(e){
        $('#img-preview-all').html('');
      });
     }

      if (file) {
        reader.readAsDataURL(file); //reads the data as a URL
      } else {
      }
    });

    var chekHpRegister='';
    function setHp(hp){
      hpChat=hp;
      chekHpRegister=hp;
    }
    function setHp_all(hp){
      hpChat_all=hp;
      chekHpRegister=hp;
    }

    function show_detail_ticket(e,id) {
      $('.overlay .ticket-detail-info').hide();
      $('.overlay .loading').css('display','flex');
      $('.overlay').show();
      $.when($('.ticket-pane').load('<?=base_url('api/ticket/detail/'.strtolower($type).'/')?>3ec8112b9e277cf4d24c85136fc9ee95/0?ticket_id='+id+'&editable=0&issabel_user=<?php echo $number ?>')).then(function(){
        $('.overlay .loading').hide();
        $('.overlay .ticket-detail-info').show();
      })
    }

    $('.btn-close-detail').click(function(e){
      e.preventDefault();
      $('.ticket-pane').html('');
      $(this).closest('.overlay').hide();
    })

    function reload_table_ticket(phone){
      var periode = ''//$('.tperiode').val();
      //var store = $('.tstore').val();
         /* var table = $('#table-ticket').on( 'processing.dt', function ( e, settings, processing ) {
            $('.btn-tfilter').find('i').css( 'display', processing ? 'inline-block' : 'none' );
            $('.btn-tfilter').prop( 'disabled', processing ? true : false );
          }).*/
          $('#table-ticket').DataTable({
            responsive: false,
            "ajax": {
                  "url": "<?=base_url('wa/get_ticket/'.$type); ?>",
                  "type": "POST",
                  "data": {'phone':phone, 'periode':periode/*, 'store':store*/},
              },
            "aaSorting": [[ 5, "asc" ]],
            "bLengthChange": false,
            "bInfo": false ,
            "search": false,
            "paging": true,
            "scrollX": true,
            "bFilter": false,
            "bStateSave": false,
            "bServerSide": true,
            "sPaginationType": "full_numbers",
            "autoWidth": false,
            "aoColumnDefs": [
            { "sClass": "center", "aTargets": [ 0 ], "data":1, },
            { "sClass": "center", "aTargets": [ 1 ], "data":2, },
            { "sClass": "center", "aTargets": [ 2 ], "data":3, },
            { "sClass": "center", "aTargets": [ 3 ], "data":4, },
            { "sClass": "center", "aTargets": [ 4 ], "data":5, },
            { "sClass": "center", "aTargets": [ 5 ], 
              "mRender":function(data, type, full){
                return '<button class="btn btn-default btn-xs" onclick="show_detail_ticket(event,'+full[1]+')"><i class="fa fa-list"></i> Detail</button>';
              }
              , "bSortable":false
          },
            ],
            "destroy":true
          });

      }


    function openchat(number,nama){
      
    numberChat=number;
    $('.chat-text').css('display','flex')  
    $('.chat-text-all').css('display','none')
    $('#btn_assign_my').css('display','')
    
              if(tabn==1){              	
    $('.chat_list').removeClass('active_chat');
    $('.'+number).addClass('active_chat');

              }
              if(tabn==0){

        $('.chat_list_all').removeClass('active_chat_all');
        $('.l'+number).addClass('active_chat_all');
              }

      $('#img-preview').html('');
      $('#pnumber').html('( '+number+' )')

      $('.loading').css('display','')
      $.ajax({
        url : '<?php echo base_url("wa/chat/"); ?><?php echo $type.'/'.$number ?>',
        type: "POST",
        data : {'phone':numberChat},
        dataType: 'json',
        success:function(data, textStatus, jqXHR){
          console.log(data);
          if(data.status){
            var html = '';
            $('#info').html(html);
            $('.badge-'+number).text('');
            var chats = '';
            $.each(data.chats, function(i,v){
              var img = '';
              var quote_image='';
              var c='';
              if(tabn==1){
              	c='private';
              }
              if(tabn==0){              	
              	c='alls'
              }
              if(v.image!=null){
                img = '<a href="'+url_base+'assets/wa_images/'+v.image+'" data-fancybox="images"><img src="'+url_base+'assets/wa_images/'+v.image+'" width="200px"></a><br>';
              }
              if(v.file!=''){
                 img = '<a href="'+url_base+'assets/wa_files/'+v.file+'" data-fancybox="images"><img src="'+url_base+'assets/images/file.png" width="50px"></a><br>';
              }
              if(v.quote_image!=null){
                 quote_image = '<img src="'+url_base+'assets/wa_images/'+v.quote_image+'" width="100px" height="100px">';
              }
              if(v.type==1){

              if(v.quote_text=='' && v.quote_image==null){
                chats+='<div class="incoming_msg '+c+number+'">'+
                '<div class="incoming_msg_img">'+
                '<img src="https://ptetutorials.com/images/user-profile.png">'+
                '</div>'+
                '<div class="received_msg">'+
                '<div class="received_withd_msg">'+
                '<p>'+img +' '+v.text+'</p>'+
                '<span class="time_date">'+ v.time+' | '+v.date+'</span>'+
                '</div>'+
                '</div>'+
                '</div>';


                }else if(v.quote_image!=null){

            chats+='<div class="incoming_msg '+c+number+'">'+
            '<div class="incoming_msg_img">'+
            '<img src="https://ptetutorials.com/images/user-profile.png">'+
            '</div>'+
            '<div class="received_msg">'+
            '<div class="received_withd_msg_r">'+
            
            '<div class="box_reply">'+
            '<div class="reply row max-lines">'+
            '<div  class="col-md-10"  style="padding: 0px">'+v.quote_text+'</div><div class="col-md-2" style="padding: 0px">'+quote_image+'</div></div>'+v.text+'</div>'+
            '<span class="time_date">'+ v.time+' | '+v.date+'</span>'+
            '</div>'+
            '</div>'+
            '</div>';
          }else if(v.quote_text!=''){
//hapus detail chat
            chats+='<div class="incoming_msg '+c+number+'">'+
            '<div class="incoming_msg_img">'+
            '<img src="https://ptetutorials.com/images/user-profile.png">'+
            '</div>'+
            '<div class="received_msg">'+
            '<div class="received_withd_msg_r">'+
            
            '<div class="box_reply">'+
            '<div class="reply row max-lines">'+
            '<div  class="col-md-12"  style="padding: 0px">'+v.quote_text+'</div></div>'+v.text+'</div>'+
            '<span class="time_date">'+ v.time+' | '+v.date+'</span>'+
            '</div>'+
            '</div>'+
            '</div>';

          }





              }else{    
                if(v.status=='Pending'){
                    chats+='<div class="outgoing_msg '+c+number+'">'+
                    '<div class="sent_msg">'+
                    '<p>'+img +' '+v.text+'</p>'+
                    '<span class="time_date"><span style="background:#fff5f5" class="'+v.id_ack+'"><i class="fa fa-clock-o" aria-hidden="true"></i></span>'+ v.time+' | '+v.date+' <span class="assign pull-right '+v.status_chat+'" style="font-size: 0.9em;color: #999;margin-top: -8px;"><i class="fa fa-reply"></i> Replied by '+v.agent+'</span></span>'+
                    '<span class="time_date">'+ v.time_assign+' <span class="assign pull-right" style="font-size: 0.9em;color: #999;margin-top: -8px;">'+v.assign+'</span></span>'+
                    '</div>'+

                    '</div>';
                }else{
                    chats+='<div class="outgoing_msg '+c+number+'">'+
                    '<div class="sent_msg">'+
                    '<p>'+img +' '+v.text+'</p>'+
                    '<span class="time_date"><span style="background:#fff5f5" class="'+v.id_ack+'"><img src="'+url_base+'assets/images/'+v.status+'.png" width="17px" height="17px"></span>'+ v.time+' | '+v.date+' <span class="assign pull-right '+v.status_chat+'" style="font-size: 0.9em;color: #999;margin-top: -8px;"><i class="fa fa-reply"></i> Replied by '+v.agent+'</span></span>'+
                    '<span class="time_date">'+ v.time_assign+' <span class="assign pull-right" style="font-size: 0.9em;color: #999;margin-top: -8px;">'+v.assign+'</span></span>'+

                    '</div>'+
                    '</div>';
                  }
              }


            });

          if(tabn==0){
            $('#chatu').css('display','none')            
            $('#chatu_all').css('display','')          
            $('#chatu_all').html('');
          	$('#chatu_all').append('all'+chats);            


            if(nama==number){
              nama=' - ';
            }
            $('.nama_all').text('Nama :'+nama);
            $('.no_hp_all').text('No HP :'+number);
            
            $('.headind_srch_all').css('display','')            
            $('.headind_srch').css('display','none')

          }
          if(tabn==1){

            $('.headind_srch').css('display','')  
            $('.headind_srch_all').css('display','none')
          	
            $('#chatu_all').css('display','none')            
            $('#chatu').css('display','')
            $('#chatu').html('');
            $('#chatu').html(chats);
            if(nama==number){
              nama=' - ';
            }
            $('.nama').text('Nama :'+nama);
            $('.no_hp').text('No HP :'+number);


          }

            $('.loading').css('display','none')

            $('.inbox_people2').css('display','inline-block');
            $('.inbox_people3').css('display','inline-block');
         if(tabn==1){
            if ($('#chatu').height() > $('.msg_history').height()) {
              $('.msg_history').animate({
                scrollTop: $('#chatu')[0].scrollHeight
              }, 200);
            }
           }
         if(tabn==0){
            if ($('#chatu_all').height() > $('.msg_history').height()) {
              $('.msg_history').animate({
                scrollTop: $('#chatu_all')[0].scrollHeight
              }, 200);
            }
           }
            //$("#chat").scrollTop($("#chat")[0].scrollHeight);
          }else{
            $().toastmessage('showToast', {
              text     : data.msg,
              sticky   : false,
              position : 'top-center',
              type     : 'error',
            });
          }
        },
        error: function(jqXHR, textStatus, errorThrown){
          $.post('<?=base_url('logger/writexhrlog')?>', {'act':'calling', 'xhr':jqXHR.responseText, 'status':textStatus, 'error':errorThrown});
          alert('Error,something goes wrong');
        }
      });

      //console.log('hello');

      reload_table_ticket(numberChat);

      

      $.ajax({
        url : '<?php echo base_url("api/get_cust_wa/"); ?>'+numberChat,
        type: "GET",
        dataType: 'json'
      })
      .done(function(res){
        $.each(res, function(i, v){
          if(i!=='subsidiary')
            $('#t'+(i.substring(0,1)=='n'?i.slice( 1 ):i)).html(v);
        })
        if(res.fname === undefined) {
          $('.ftext').html('');
        } else {
         // alert(1);
          //$('.nama').text('Nama :'+res.fname+' '+res.lname);
          $('.'+numberChat+' .chat_people_header').html(res.fname+' '+res.lname)
        }

          $('#btn-update-panel').show();
          search_phone(numberChat);
      })
    }


  </script>
  <script type="text/javascript">
     

        $('#search_number').keyup(function (e) {
          numberChat=$('#search_number').val();
          number=$('#search_number').val();
          var nama='';
          if(number==''){
                $('.chat_list').css('display','inline-block');
                return false;
          }
      });  

    $('#search_number').keypress(function (e) {
       var key = e.which;
       if(key == 13)  // the enter key code
        {
          searchNumber();
        }
      });   
    
    function searchNumber(){
      numberChat=$('#search_number').val();
      number=$('#search_number').val();

      $('.inbox_people .nav>li:nth-child(2) .nav-link').trigger('click');

      var nama='';
      if(number==''){
            $('.chat_list_all').css('display','inline-block');
            return false;
      }
       var chek=numberChat.charAt(0);
       if(chek==0){
            var hasil=number.substring(1)
            number='62'+hasil;
            numberChat='62'+hasil;
       }

       	$('.chat_list_all').css('display','none');

	       //alert(number.substring(1));

	   	$('.chat_list_all').removeClass('active_chat');
	   	$('#chatu_all').html('');
	   	$('.nama_all').text('Nama :');
        $('.no_hp_all').text('No HP :');
        //$('.cus-field-info .info-value').html(':');
        $('.cus-field-info .info-value>span').html(':');
        $('.loading').css('display','')
      if($('.l'+number).length>0){
	      $('.l'+number).addClass('active_chat');
	      $('.l'+number).css('display','');
	      $('.l'+number).trigger('click');
	  } else {

	  	$.ajax({
	        url : '<?php echo base_url("api/get_cust_wa/"); ?>'+number,
	        type: "GET",
	        dataType: 'json'
	    })
	    .done(function(res){
	    	if(res.fname !== undefined ) {
	    	  
	          $('.inbox_people2').css('display','inline-block');
              
	         	all_chat='<div class="chat_list_all l'+res.phone+'"" onclick="setHp_all('+res.phone+');'+
	          'openchat_all('+res.phone+',\''+res.fname+' '+res.lname+'\')">'+
	          '<div class="chat_people">'+
	          '<div class="chat_img">'+
	          '<img src="https://ptetutorials.com/images/user-profile.png">'+
	          '</div>'+
	          '<div class="chat_ib">'+
	          '<h5 class="chat_people_header">'+res.fname+' '+res.lname+'</h5>'+
	          '<div class="chat_date"> <span class="assign pull-right" style="font-size: 0.9em;color: #999;"></span></div>'+
	          '<p class="ellipsis"></p>'+
	          '</div>'+
	          '</div>'+
	          '</div>';
	          $('.allinbox_chat').html(all_chat)
	        $.when($('.inbox_people3').css('display','inline-block')).then(function(){
	        	//$('.l'+res.phone).trigger('click');
	        	$('#pnumber').html('( '+res.phone+' )')
	        	$.each(res, function(i, v){
		          if(i!=='subsidiary'){
		            $('#t'+(i.substring(0,1)=='n'?i.slice( 1 ):i)).html(v);
		            //console.log('#t'+(i.substring(0,1)=='n'?i.slice( 1 ):i)+' = '+v)
		          }
		        })
	        //  	$('.nama').text('Nama :'+res.fname+' '+res.lname);
	          	$('.'+numberChat+' .chat_people_header').html(res.fname+' '+res.lname)
		        $('.l'+res.phone).addClass('active_chat');
		        $('.chat-text').css('display','none')  
    			$('.chat-text-all').css('display','flex')
		        $('.loading').css('display','none')
		        $('.l'+res.phone).trigger('click')
	        })

           search_phone(number);
	        } else {
	        	
	        	$('.loading').css('display','none')
	        }
	    })
	    .always(function(){
	    	
	    })
	  }


      /*$.ajax({
        url : '<?php echo base_url("wa/chat/"); ?><?php echo $type.'/'.$number ?>',
        type: "POST",
        data : {'phone':numberChat},
        dataType: 'json',
        success:function(data, textStatus, jqXHR){
          console.log(data);
          if(data.status){
            $('.chat-panel').addClass('open');
            var html = '';
            

            $('#info').html(html);
            $('.badge-'+number).text('');
            var chats = '';
            $.each(data.chats, function(i,v){
            
            
              var img = '';

              if(v.image!=null){
                img = '<a href="'+url_base+'assets/wa_images/'+v.image+'" data-fancybox="images"><img src="'+url_base+'assets/wa_images/'+v.image+'" width="200px"></a><br>';
              }
              if(v.type==1){
                chats+='<div class="incoming_msg">'+
                '<div class="incoming_msg_img">'+
                '<img src="https://ptetutorials.com/images/user-profile.png">'+
                '</div>'+
                '<div class="received_msg">'+
                '<div class="received_withd_msg">'+
                '<p>'+img +' '+v.text+'</p>'+
                '<span class="time_date">'+ v.time+' | '+v.date+'</span>'+
                '</div>'+
                '</div>'+
                '</div>';
              }else{


                chats+='<div class="outgoing_msg">'+
                '<div class="sent_msg">'+
                '<p>'+img +' '+v.text+'</p>'+
                '<span class="time_date">'+ v.time+' | '+v.date+' <span class="assign pull-right '+v.status_chat+'" style="font-size: 0.9em;color: #999;margin-top: -8px;"><i class="fa fa-reply "></i> Replied by '+v.agent+'</span></span>'+
                '</div>'+
                '</div>';

              }


            });



            $('#chatu').html('');
            $('#chatu').html(chats);
            if(nama==number){
              nama=' - ';
            }
            $('.nama').text('Nama :'+nama);
            $('.no_hp').text('No HP :'+number);

            $('.inbox_people2').css('display','inline-block');
            $('.inbox_people3').css('display','inline-block');
            $('.loading').css('display','none')

            if ($('#chatu').height() > $('.msg_history').height()) {
              $('.msg_history').animate({
                scrollTop: $('#chatu')[0].scrollHeight
              }, 200);
            }
            //$("#chat").scrollTop($("#chat")[0].scrollHeight);
          }else{
            $().toastmessage('showToast', {
              text     : data.msg,
              sticky   : false,
              position : 'top-center',
              type     : 'error',
            });
          }
        },
        error: function(jqXHR, textStatus, errorThrown){
          $.post('<?=base_url('logger/writexhrlog')?>', {'act':'calling', 'xhr':jqXHR.responseText, 'status':textStatus, 'error':errorThrown});
          alert('Error,something goes wrong');
        }
      });*/

      
    }


  </script>



  <script type="text/javascript">

    $('#btn-search').click(function(){
      search();
    })

    function search(){

      $('#alert-update').html('');
      $('#alert-update').hide();
      $('#btn-search').prop('disabled',true);
      $('#btn-search').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
      $.when(
        $.ajax({
          url: '<?=base_url('/wa/kanmo/search_add/3ec8112b9e277cf4d24c85136fc9ee95')?>',
          data: {'phone':$('#seach_cus').val()},
          dataType: 'json',
          type: 'post'
        }).done(function(res){
console.log(res.data)
          if(res.status){
            $('#fname').prop('readonly',true);
            $('#lname').prop('readonly',true);
            $('#phone').prop('readonly',true);
            $('#email').prop('readonly',true);
            if($('#phone').val()==''){
              $('#phone').val(res.data.nphone);
            }
            $('#action').val('update');
            $('#title-form-new').html('Update Customer Data');
            $('#warning').html('');
            console.log(res.data);
            $('#nprovince').val(res.data.nprovince_one).trigger('change');
            $('#ncity').select2({
              dropdownAutoWidth : false,
              width: '100%',
              data: res.data.scity
            });
            $('#ncity').val(res.data.ncity_one).trigger('change');
            $('#ndistrict').select2({
              dropdownAutoWidth : false,
              width: '100%',
              data: res.data.sdistrict
            });
            $('#ndistrict').val(res.data.ndistrict_one).trigger('change');
            $('#nsubsidiary').val(res.data.nsubsidiary).trigger('change');
            /*$('input#nfname').prop('readonly', true);
            $('input#nlname').prop('readonly', true);
            $('input#nemail').prop('readonly', true);
            $('input#nbarcode').prop('readonly', true);*/
            $.each(res.data, function(i,v){
              if(i=='ngender'){
                $('input#ngender_'+v).prop('checked', true);
              }else if(i=='nbrand_interest'){
                $.each(v, function(idx, item){
                  $('input#bi_'+item.toLowerCase().split(' ').join('_')).prop('checked', true);
                });
              }else if(i!='nprovince'&&i!='ncity'&&i!='ndistrict'&&i!='nsubsidiary'){
                console.log('ini'+i);
                
                $('input#'+i).val(v);
                $('span#'+i).html(v);
                $('span#t'+i).html(v);
                $('input#t'+i).val(v);
                
                $('input[name="'+i+'"]').val(v);
              }
            })
            $('#btn-reg').html('Update');
            $('#btn-update-panel').show();
            
          }else{
            $('#new-customer').modal('show');
            /*$('input#nfname').prop('readonly', false);
            $('input#nlname').prop('readonly', false);
            $('input#nemail').prop('readonly', false);
            $('input#nbarcode').prop('readonly', false);*/
            $.each(res.data, function(i,v){
              if(i=='ngender'){
                $('input#ngender_FEMALE').prop('checked', true);
              }else if(i=='nbrand_interest'){
                $.each(v, function(idx, item){
                  $('input.bi').prop('checked', false);
                });
              }else if(i!='nprovince'&&i!='ncity'&&i!='ndistrict'&&i!='nsubsidiary'){
                $('input#'+i).val(v);
                $('span#'+i).html('');
                $('input[name="'+i+'"]').val('');
              }
            })
            $('#action').val('new');
            $('#btn-update-panel').hide();

            $('#nprovince').val('').trigger('change');
            $('#ncity').val('').trigger('change');
            $('#ndistrict').val('').trigger('change');
            $('#warning').html('Searched Customer details not available. Please enter below details to get register with Us');
            $('#title-form-new').html('New Customer Registration');
            $('#btn-reg').html('Register');
            $('input#nphone').val(res.data.nphone);
          }
        }).fail(function(xhr, res, status){

        }).always(function(){
          $('#btn-search').html('<i class="fa fa-search"></i>');
          $('#btn-search').prop('disabled',false);
        })
        ).then(function(){
          if($('#action').val()=='update'){
            reload_table();
          }
          reload_table_ticket();
        })
      }

      $('#btn-file').click(function(e){
        e.preventDefault();
        $('#file_pick').trigger('click');
      })


       $('#btn-file-all').click(function(e){
        e.preventDefault();
        $('#file_pick_all').trigger('click');
      })

      function createTicket(){




          <?php if ($type=='KANMO'): ?>
             var win = window.open('<?=base_url('api/kanmo/form_ticket/3ec8112b9e277cf4d24c85136fc9ee95?agent=')?>'+<?php echo $number ?>+'&phone='+hpChat+'&wa=1', '_blank');             
          <?php else: ?>
             var win = window.open('<?=base_url('api/form_ticket/3ec8112b9e277cf4d24c85136fc9ee95?agent=')?>'+<?php echo $number ?>+'&phone='+hpChat+'&wa=1', '_blank');            
          <?php endif ?>
        
      }

    </script>


    <script type="text/javascript">
	//alert('<?php echo $number ?>')

	/*var socket;

	const socketMessageListener = function(event) {
	    var data = JSON.parse(event.data);
      console.log(data);
	};

	const socketOpenListener = function(event) {
	    console.log('Connected');
	    var data = {action: "login", data: "<?php echo $number ?>"};
	    sendMessage(data);
	};

	const socketCloseListener = function(event) {
	    if (socket) {
	        console.error('Disconnected.');
	    }
	    socket = new WebSocket('wss://'+url_socket+'/wss2/NNN');
	    socket.addEventListener('open', socketOpenListener);
	    socket.addEventListener('message', socketMessageListener);
	    socket.addEventListener('close', socketCloseListener);
	};

	socketCloseListener();

	function sendMessage(data) {
	    socket.send(JSON.stringify(data));
   }*/

 </script>


 <style type="text/css">
  .chat-panel{
    position:fixed;
    width:0;
    height:100%;
    top:50px;
    background: #fafafa;
    z-index: 999;
    -webkit-transition: right .5s; /* Safari */
    transition: right .5s;
  }
  .chat-panel.open{
    right: 0 !important;
  }
  .chat-panel .chat-wrap{
    display: flex; 
    flex-direction: row;
    height: 100%
  }
  .chat-panel .chat-wrap .header-chat{
    width: 100%;
    padding: 10px 0;
    display: flex; 
    border-bottom:1px solid #cfcfcf;
    background:#eee;
  }
  .chat-panel .chat-wrap .header-chat a.close{
    font-size:1.4em;
    margin: 0 15px 0 5px;
    color:#999;
  }
  .chat-panel .chat-wrap .header-chat .header-icon{
    border-radius: 50%; 
    width: 30px; 
    height: 30px;
    background: #fff;
    color:#bbb;
    display: inline-block;
    overflow: hidden;
    text-align:center;
  }
  .chat-panel .chat-wrap .header-chat .header-text{
    font-size:1.5rem;
    font-weight: bold;
    display: inline-block;
    margin-top:5px;
    margin-left:15px;
  }
  .chat-content{
    padding: 5px 10px;
    background: url('/kanmo/assets/dist/img/wabg.png');
  }
  .chat-content ul#chatu{
    padding-left: 0;
    margin: 0;
    list-style: none;
    width: 100%;
  }
  .chat-content ul#chatu li{
    display: flex;
    width: 100%;
  }
  .chat-content ul#chatu li>span{
    padding: 5px 10px;
    margin: 2px 0;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
  }
  .chat-content ul#chatu li>span>small.time{
    margin-left: 15px;
    margin-top: 2px;
    margin-bottom: -1px;
    color: #999;
    float: right;
    bottom: -5px;
    position: relative;
  }
  .chat-content ul#chatu li.rchat{
    justify-content: flex-start;
  }
  .chat-content ul#chatu li.achat{
    justify-content: flex-end;
  }
  .chat-content ul#chatu li.rchat span{
    background: #fff;
    border-top-right-radius: 5px;
  }
  .chat-content ul#chatu li.achat span{
    background: #99ffcc;
    border-top-left-radius: 5px;
  }
  .siderbar-chat{
    border-left: 1px solid #cfcfcf;
    height: 100%;
    background: #eee;
    display: flex;
    flex-direction: column;
  }
  .chat-panel .chat-wrap .chat-text{
    background:#eee;
    bottom: 0;
    border-top:1px solid #cfcfcf;
  }
  .chat-panel .chat-wrap .chat-text-all{
    background:#eee;
    bottom: 0;
    border-top:1px solid #cfcfcf;
  }
  .text-input{
    resize: none;
    border-radius: 5px;
    border-color: #ccc;
    width: 90%;
    padding: 6px 10px;
    outline: none;
    max-height: 300px;
  }
  .btn-send-panel{
    padding: 1px 15px 16px 5px;
    display: flex;
    align-items: flex-end;
  }
  .btn-send-panel a{

  }
  #btn-file{
    margin-right: 15px !important;
  }
  #btn-file-all{
    margin-right: 15px !important;
  }
  .panel-btn-complete{
    width: 100%;
    height: 30px;
  }
  #img-preview{
    position: relative;
    display: flex;
    margin-bottom: 5px;
  }
  #img-preview #rmv-img{
    position: absolute;
    top: -8px;
    cursor: pointer;
    right: 5px;
    font-size: 1.8em;
  }
  #img-preview img{
    max-width: 100%;
    width: auto;
    height: 250px !important;
    display: inline-block;
  }
</style>


<!-- chat all -->
<script type="text/javascript">  
    function openchat_all(number,nama){

    $('.chat-text').css('display','none')  
    $('.chat-text-all').css('display','flex')

          numberChat_all=number;
              if(tabn==0){
        $('.chat_list_all').removeClass('active_chat_all');
        $('.l'+number).addClass('active_chat_all');
              }

              $('#pnumber').html('( '+number+' )')

      $('#img-preview').html('');
      $('.loading').css('display','')
      $.ajax({
        url : '<?php echo base_url("wa/chat/"); ?><?php echo $type.'/'.$number ?>',
        type: "POST",
        data : {'phone':numberChat_all},
        dataType: 'json',
        success:function(data, textStatus, jqXHR){
          console.log(data);
          if(data.status){
//return false;
            var html = '';
            $('#info').html(html);
            $('.badge-'+number).text('');
            var chats = '';
            $.each(data.chats, function(i,v){
              var img = '';
              var quote_image='';
              var c='';
              if(tabn==1){
                c='private';
              }
              if(tabn==0){                
                c='alls'
              }
              if(v.image!=null){
                img = '<a href="'+url_base+'assets/wa_images/'+v.image+'" data-fancybox="images"><img src="'+url_base+'assets/wa_images/'+v.image+'" width="200px"></a><br>';
              }
              if(v.file!=''){
                 img = '<a href="'+url_base+'assets/wa_files/'+v.file+'" data-fancybox="images"><img src="'+url_base+'assets/images/file.png" width="50px"></a><br>';
              }
              if(v.quote_image!=null){
                 quote_image = '<img src="'+url_base+'assets/wa_images/'+v.quote_image+'" width="100px" height="100px">';
              }
              if(v.type==1){
              	//console.log(v.quote_image)
              if(v.quote_text=='' && quote_image==''){
                chats+='<div class="incoming_msg '+c+number+'">'+
                '<div class="incoming_msg_img">'+
                '<img src="https://ptetutorials.com/images/user-profile.png">'+
                '</div>'+
                '<div class="received_msg">'+
                '<div class="received_withd_msg">'+
                '<p>'+img +' '+v.text+'</p>'+
                '<span class="time_date">'+ v.time+' | '+v.date+'</span>'+
                '</div>'+
                '</div>'+
                '</div>';


                }else if(quote_image!=''){

            chats+='<div class="incoming_msg '+c+number+'">'+
            '<div class="incoming_msg_img">'+
            '<img src="https://ptetutorials.com/images/user-profile.png">'+
            '</div>'+
            '<div class="received_msg">'+
            '<div class="received_withd_msg_r">'+
            
            '<div class="box_reply">'+
            '<div class="reply row max-lines">'+
            '<div  class="col-md-10"  style="padding: 0px">'+v.quote_text+'</div><div class="col-md-2" style="padding: 0px">'+quote_image+'</div></div>'+v.text+'</div>'+
            '<span class="time_date">'+ v.time+' | '+v.date+'</span>'+
            '</div>'+
            '</div>'+
            '</div>';
          }else if(v.quote_text!=''){
//hapus detail chat
            chats+='<div class="incoming_msg '+c+number+'">'+
            '<div class="incoming_msg_img">'+
            '<img src="https://ptetutorials.com/images/user-profile.png">'+
            '</div>'+
            '<div class="received_msg">'+
            '<div class="received_withd_msg_r">'+
            
            '<div class="box_reply">'+
            '<div class="reply row max-lines">'+
            '<div  class="col-md-12"  style="padding: 0px">'+v.quote_text+'</div></div>'+v.text+'</div>'+
            '<span class="time_date">'+ v.time+' | '+v.date+'</span>'+
            '</div>'+
            '</div>'+
            '</div>';

          }





              }else{
/*
                chats+='<div class="outgoing_msg '+c+number+'">'+
                '<div class="sent_msg">'+
                '<p>'+img +' '+v.text+'</p>'+
                '<span class="time_date">'+ v.time+' | '+v.date+' <span class="assign pull-right '+v.status_chat+'" style="font-size: 0.9em;color: #999;margin-top: -8px;"><i class="fa fa-reply"></i> Replied by '+v.agent+'</span></span>'+
                '</div>'+
                '</div>';*/

                chats+='<div class="outgoing_msg '+c+number+'">'+
                '<div class="sent_msg">'+
                '<p>'+img +' '+v.text+'</p>'+
                '<span class="time_date"><span style="background:#fff5f5" class="'+v.id_ack+'"><img src="'+url_base+'assets/images/'+v.status+'.png" width="17px" height="17px"></span>'+ v.time+' | '+v.date+' <span class="assign pull-right '+v.status_chat+'" style="font-size: 0.9em;color: #999;margin-top: -8px;"><i class="fa fa-reply"></i> Replied by '+v.agent+'</span></span>'+
                '</div>'+
                '</div>';


              }


            });

          if(tabn==0){
            $('#chatu').css('display','none')            
            $('#chatu_all').css('display','')          
            $('#chatu_all').html('');
            $('#chatu_all').append(''+chats);            


            if(nama==number){
              nama=' - ';
            }
            $('.nama_all').text('Nama :'+nama);
            $('.no_hp_all').text('No HP :'+number);
            
            $('.headind_srch_all').css('display','')            
            $('.headind_srch').css('display','none')

          }

            $('.loading').css('display','none')

            $('.inbox_people2').css('display','inline-block');
            $('.inbox_people3').css('display','inline-block');
         
            if ($('#chatu_all').height() > $('.msg_history').height()) {
              $('.msg_history').animate({
                scrollTop: $('#chatu_all')[0].scrollHeight
              }, 200);
            }
           
            //$("#chat").scrollTop($("#chat")[0].scrollHeight);
          }else{
            $().toastmessage('showToast', {
              text     : data.msg,
              sticky   : false,
              position : 'top-center',
              type     : 'error',
            });
          }
        },
        error: function(jqXHR, textStatus, errorThrown){
          $.post('<?=base_url('logger/writexhrlog')?>', {'act':'calling', 'xhr':jqXHR.responseText, 'status':textStatus, 'error':errorThrown});
          alert('Error,something goes wrong');
        }
      });

      //console.log('hello');

      reload_table_ticket(numberChat_all);

      

      $.ajax({
        url : '<?php echo base_url("api/get_cust_wa/"); ?>'+numberChat_all,
        type: "GET",
        dataType: 'json'
      })
      .done(function(res){
        $.each(res, function(i, v){
        	//console.log(i.substring(0,1)=='n'?i.slice( 1 ):i)
          if(i!=='subsidiary')
            $('#t'+(i.substring(0,1)=='n'?i.slice( 1 ):i)).html(v);
        })
        if(res.fname === undefined) {
          $('.ftext').html('');
        } else {
          //alert(9)
          //$('.nama').text('Nama :'+res.fname+' '+res.lname);
          $('.'+numberChat_all+' .chat_people_header').html(res.fname+' '+res.lname)
        }
      //$('#btn-update-panel').show();
      search_phone(numberChat_all);
      })
    }


    function new_customer(){      
            $('#new-customer').modal('show');
    }
</script>

<script type="text/javascript">
  $(document).ready(function() {
        if (!!window.EventSource) {
            var url_ = "<?php echo base_url('wa/agent_online/kanmo/'); ?><?php echo $type?>";
            
            var source = new EventSource(url_);
            source.addEventListener('message', function(event) {
                /*console.log(event.data);*/
                var data = JSON.parse(event.data);
                    
               $('.agent_ol').text(data.data);
                
            });
        }


    })
</script>

<script type="text/javascript">
   $('#form-new').submit(function(e){
    
        e.preventDefault();
        $('#btn-reg').prop('disabled', true);
        $('#btn-reg').append('<i class="fa fa-circle-o-notch fa-spin fa-fw" id="loading-save"></i>');
        var is_success = false;
        $.when(
        $.ajax({
          url:'kanmo/save_customer',
          type: 'post',
          dataType: 'json',
          data: $('#form-new').serialize()
        })
        .done(function(res){
          if(res.status){
          $('#fname').prop('readonly',true);
          $('#lname').prop('readonly',true);
          $('#phone').prop('readonly',true);
          $('#email').prop('readonly',true);
          $('#btn-reg').html('Update');
            $('#btn-update-panel').show();
          if($('#nphone').val()==''){
            $('#nphone').val(res.data.nphone);
            search_phone(res.data.nphone);
          }
          search_phone($('#nphone').val());

            is_success = true;
            $('#alert-update').removeClass('alert-danger');
            $('#alert-update').addClass('alert-success');
            /*$.each(res.data, function(i, v){
              console.log(i);
              console.log(v);
              $('span#'+i).html(v);
              $('input[name="'+i+'"]').val(v);
            }) */ 

           search_phone(res.data.nphone);
          }else{
            $('#alert-update').removeClass('alert-success');
            $('#alert-update').addClass('alert-danger');
          }
          $('#alert-update').html('<i>'+res.msg+'</i>');
          $('#alert-update').show();
        })
        .fail(function(xhr, error, status){
          console.log(xhr);
        })
        .always(function(){
          $('#btn-reg').prop('disabled', false);
          $('#loading-save').remove();
        })
        ).then(function(){
          if(is_success){
            //reload_table();
            //reload_table_ticket();
            $('#new-customer').modal('hide');
          }
        })
      });




   $('#nprovince').change(function(){
  var province = $(this).val();
  $('#ncity').html('<option></option>');
  $('#ndistrict').html('');
  if(province!==null && province!==''){
    $.ajax({url:'<?=base_url('wa/kanmo/get_city')?>', data:{'province':province}, type:'post', dataType:'json'})
    .done(function(res){
      if(res.status){
        $('select#ncity').select2({
            dropdownAutoWidth : false,
            width: '100%',
            data: res.data
          });
      }
    })
  }
});
$('#ncity').change(function(){
  var city = $(this).val();
  $('#ndistrict').html('');
  if(city!==null && city!==''){
    $.ajax({url:'<?=base_url('wa/kanmo/get_district')?>', data:{'city':city}, type:'post', dataType:'json'})
    .done(function(res){
      if(res.status){
        $('select#ndistrict').select2({
            dropdownAutoWidth : false,
            width: '100%',
            data: res.data
          });
      }
    })
  }
});

  $('#btn-update').click(function(e){
        e.preventDefault();
        $('#new-customer').modal('show');
      })
</script>

<script type="text/javascript">
  
  function search_phone(phone){

//return false;
      $('#alert-update').html('');
      $('#alert-update').hide();
      $('#btn-search').prop('disabled',true);
      $('#btn-search').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
      $.when(
        $.ajax({
          url: '<?=base_url('/wa/kanmo/search_add/3ec8112b9e277cf4d24c85136fc9ee95')?>',
          data: {'phone':phone},
          dataType: 'json',
          type: 'post'
        }).done(function(res){

          if(res.status){
            $('#fname').prop('readonly',true);
            $('#lname').prop('readonly',true);
            $('#phone').prop('readonly',true);
            $('#email').prop('readonly',true);
            if($('#phone').val()==''){
              $('#phone').val(res.data.nphone);
            }
            $('#action').val('update');
            $('#title-form-new').html('Update Customer Data');
            $('#warning').html('');
            console.log(res.data);
            $('#nprovince').val(res.data.nprovince_one).trigger('change');
            $('#ncity').select2({
              dropdownAutoWidth : false,
              width: '100%',
              data: res.data.scity
            });
            $('#ncity').val(res.data.ncity_one).trigger('change');
            $('#ndistrict').select2({
              dropdownAutoWidth : false,
              width: '100%',
              data: res.data.sdistrict
            });
            $('#ndistrict').val(res.data.ndistrict_one).trigger('change');
            $('#nsubsidiary').val(res.data.nsubsidiary).trigger('change');
            /*$('input#nfname').prop('readonly', true);
            $('input#nlname').prop('readonly', true);
            $('input#nemail').prop('readonly', true);
            $('input#nbarcode').prop('readonly', true);*/
            var setTextNama='';
            var setTextNamaB='';
            var setTextNo=phone;
            $.each(res.data, function(i,v){
              
              if(i=='ngender'){
                $('input#ngender_'+v).prop('checked', true);
              }else if(i=='nbrand_interest'){
                $.each(v, function(idx, item){
                  $('input#bi_'+item.toLowerCase().split(' ').join('_')).prop('checked', true);
                });
              }else if(i!='nprovince'&&i!='ncity'&&i!='ndistrict'&&i!='nsubsidiary'){
                console.log('ini'+i);
                  
                $('input#'+i).val(v);
                $('span#'+i).html(v);
                $('span#t'+i).html(v);
                $('input#t'+i).val(v);                
                $('input[name="'+i+'"]').val(v);
                if(i=='cus_fname'){
                  if(setTextNama=='')
                  setTextNama+=v;
                }
                if( i=='cus_lname'){
                if(setTextNamaB=='')                  
                  setTextNamaB+=v;
                }
              }
            })
         if(tabn==1){    
             $('.nama').text('Nama :'+setTextNama+' '+setTextNamaB);
              $('.'+phone+' .chat_people_header').html(setTextNama+' '+setTextNamaB)
          }

          if(tabn==0){
           $('.l'+phone+' .chat_people_header').html(setTextNama+' '+setTextNamaB)
            $('.nama_all').text('Nama :'+setTextNama+' '+setTextNamaB);
            $('.no_hp_all').text('No HP :'+phone);
          }

            $('#btn-reg').html('Update');
            $('#btn-update-panel').show();
            //$('.btn-daftar').css('display','none');
            
            $('.btn-daftar').attr('disabled','disabled')
          }else{            
            $('.btn-daftar').removeAttr('disabled','disabled')
            /*$('input#nfname').prop('readonly', false);
            $('input#nlname').prop('readonly', false);
            $('input#nemail').prop('readonly', false);
            $('input#nbarcode').prop('readonly', false);*/
            $.each(res.data, function(i,v){
              if(i=='ngender'){
                $('input#ngender_FEMALE').prop('checked', true);
              }else if(i=='nbrand_interest'){
                $.each(v, function(idx, item){
                  $('input.bi').prop('checked', false);
                });
              }else if(i!='nprovince'&&i!='ncity'&&i!='ndistrict'&&i!='nsubsidiary'){
                $('input#'+i).val(v);
                $('span#'+i).html('');
                $('input[name="'+i+'"]').val('');
              }
            })
            $('#action').val('new');
            $('#btn-update-panel').hide();

            $('#nprovince').val('').trigger('change');
            $('#ncity').val('').trigger('change');
            $('#ndistrict').val('').trigger('change');
            $('#warning').html('Searched Customer details not available. Please enter below details to get register with Us');
            $('#title-form-new').html('New Customer Registration');
            $('#btn-reg').html('Register');
            $('input#nphone').val(res.data.nphone);
          }
        }).fail(function(xhr, res, status){

        }).always(function(){
          $('#btn-search').html('<i class="fa fa-search"></i>');
          $('#btn-search').prop('disabled',false);
        })
        ).then(function(){
          if($('#action').val()=='update'){
            reload_table();
          }
          reload_table_ticket();
        })
      }


function adjustHeight(el){
    el.style.height = (el.scrollHeight > el.clientHeight) ? (el.scrollHeight)+"px" : "60px";
}


$('.btn-daftar').click(function(ev){
    ev.preventDefault();      
    $('#new-customer').modal('show');
})


function assigment(){
  $('#modal-assign').modal('show');
  $('#hp_assign').val(hpChat);
  refresh_agent();
}


function assigment_all(){
  $('#modal-assign').modal('show');    
  $('#hp_assign').val(hpChat_all);
  refresh_agent();  
}


$('#form-assign').on('submit', function(e){
          e.preventDefault();

  var txt;
  var r = confirm("Are you sure you want to assign chat to "+$("#agent_ass option:selected").text()+ "?");
  if (r == true) {


   $.ajax({
            url: '<?=base_url('wa/chat_assign')?>',
            type: 'post',
            dataType: 'json',
            data: 'phone='+$('#hp_assign').val()+'&number='+<?=$number ?>+'&type=<?=$type ?>&agent_ass='+$('#agent_ass').val(),
          }).done(function(res){
            if(res.status){
              $('#modal-assign').modal('hide');  
              $().toastmessage('showToast', {
                        text     : 'Chat Assignment success',
                        position : 'top-center',
                        type     : 'success',
                        close    : function () {
                         // location.reload();  
                        }
                      });
            }else{
              if(res.code==200){
                $.each(res.e, function(key,msg){
                  var info = $('[name="'+key+'"]').closest('.form-group').find('.info');
                        info.html(msg);
                      });
              }else{
                $().toastmessage('showToast', {
                          text     : 'Close chat failed',
                          position : 'top-center',
                          type     : 'error',
                          
                        });
              }
            }
          }).fail(function(xhr, status, error){
            $.post('<?=base_url('logger/writexhrlog')?>', {'xhr':xhr, 'act':'save_closed', 'error':error, 'status':status});
            alert('Something goes wrong, please call your aplication vendor');
            console.log(xhr);
            console.log(status);
            console.log(error);
          });

   
  } else {

  $('#modal-assign').modal('hide');    
   
  }
  






})



$('select#agent_ass').select2({
            dropdownAutoWidth : false,
            width: '100%',
            
});

refresh_agent();
function refresh_agent(){
  
   $.ajax({
            url: '<?=base_url('wa/agent_ass/'.$type)?>',
            type: 'post',
            dataType: 'json',
            data: 'number='+<?=$number ?>,
          }).done(function(res){
            $("#refresh_ag").html(res)
          }).fail(function(xhr, status, error){
            $.post('<?=base_url('logger/writexhrlog')?>', {'xhr':xhr, 'act':'save_closed', 'error':error, 'status':status});
            alert('Something goes wrong, please call your aplication vendor');
            console.log(xhr);
            console.log(status);
            console.log(error);
          });

}

</script>