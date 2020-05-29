
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Kanmo Chat</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
  <script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/switch/bootstrap-toggle.min.css" />
  <script src="<?php echo base_url(); ?>assets/plugins/switch/bootstrap-toggle.min.js"></script>

  <!--script src="<?php echo base_url('node_modules/socket.io/node_modules/socket.io-client/socket.io.js');?>"></script-->

  <style type="text/css">
    /*---------chat window---------------*/
    .chat_people_header {
      margin-bottom: 0 !important;
    }
    .chat_date {
      margin-bottom: 10px;
    }
    .container{
      max-width:900px;
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
      width: 60%;
      padding:
    }

    .headind_srch {
      padding: 10px 29px 10px 20px;
      overflow: hidden;
      border-bottom: 1px solid #c4c4c4;
    }

    .recent_heading h4 {
      color: #0465ac;
      font-size: 16px;
      margin: auto;
      line-height: 29px;
    }

    .srch_bar input {
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

  .inbox_chat {
    height: 530px;
    overflow-y: scroll;
  }

  .active_chat {
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
    padding: 30px 15px 0 25px;
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
    height: 420px;
    overflow-y: auto;
  }

  .msg_history1 {
    height: 420px;
    overflow-y: auto;
  }

  .ellipsis { text-overflow: ellipsis; }
</style>

<style type="text/css">
  html, body {
    overflow-x: hidden;
  }
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
  td.align-right{
    text-align: right;
  }
  .select2-container--default .select2-selection--single{
    height: 34px !important;
  }
  .select2-container--default .select2-selection--single .select2-selection__rendered{
    line-height: 32px !important
  }
</style>
</head>
</style><!-- 
 <audio id="notif_audio"><source src="<?php echo base_url('sounds/notify.ogg');?>" type="audio/ogg"><source src="<?php echo base_url('sounds/notify.mp3');?>" type="audio/mpeg"><source src="<?php echo base_url('sounds/notify.wav');?>" type="audio/wav"></audio>
 -->
 <audio id="myAudio" >
  <source src="<?php echo base_url('sounds/notify.mp3');?>" type="audio/mpeg">
    Your browser does not support the audio element.
  </audio>



  <nav class="navbar" style="background: #c62828; margin-bottom:0px !important; height: 55px">
    <div class="container-fluid">
    <!-- <div class="navbar-header">
      <a class="navbar-brand" href="#">WebSiteName</a>
    </div> -->


    <div class="btn-group btn-group-lg col-md-12" role="group" aria-label="Large button group" >
      <div class="col-md-12 col-md-offset-4">
        <button type="button" class="btn btn-default" style="height: 50px;width: 100px;background: #c62828;color: white; border: 2px solid"><strong> Received <br> <span class="received"><?=isset($dashboard->recieve)?$dashboard->recieve:0 ?></span></strong></button>

        <button type="button" class="btn btn-default" style="height: 50px;width: 100px;background: #c62828;color: white;border: 2px solid"><strong> Sent <br> <span class="sent"><?=isset($dashboard->send)?$dashboard->send:0 ?></span></strong></button>

        <button type="button" class="btn btn-default" style="height: 50px;width: 100px;background: #c62828;color: white;border: 2px solid"><strong> All <br> <span class="all"><?=isset($dashboard->total)?$dashboard->total:0 ?></span></strong></button>

      </div>
    </div>

  </div>
</nav>

<div class="messaging">
  <div class="inbox_msg">
    <div class="inbox_people">
      <div class="headind_srch"   style="background: #e3f2fd">
        <div class="recent_heading">
          <h4>Recent</h4>
        </div>
        <div class="srch_bar">
          <div class="stylish-input-group">
            <input type="text" class="search-bar"  placeholder="Search" >
          </div>
        </div>
      </div>
      <div class="inbox_chat scroll"   style="background: #e3f2fd">
        <div class="chat_list active_chat">
      <!--     <div class="chat_people">
            <div class="chat_img"> 
              <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> 
            </div>
            <div class="chat_ib">
              <h5 class="chat_people_header">Sunil Rajput <span class="badge badge-danger" style="background: red">4</span></h5>
              <div class="chat_date"> Dec 25</div>
              <p class="ellipsis">Test, which is a new approach to have all solutions 
              astrology under one roof.</p>
            </div>
          </div> -->
        </div>
      </div>
    </div>

    <div class="inbox_people2" style="display: none;">
      <div class="headind_srch">
        <div class="recent_heading">
          <h4>Info</h4>
        </div>
        <div class="srch_bar">
          <div class="stylish-input-group">
            <div class="nama">Nama : <span id="fname"></span> <span id="lname"></span></div>
            <div class="no_hp">No Wa : -</div>
            <!--  <div > Email: ahmad@kanmo.com</div> -->
          </div>
        </div>
      </div>
      <div class="mesgs" >
        <div class="msg_history">
          <div id="chatu"> 
          </div>

        </div>
       <!--  <div class="type_msg">
          <div class="input_msg_write">
            <input type="text" class="write_msg" placeholder="Type a message" />
            <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
            <input type="file" name="">
          </div>
        </div> -->

        <div class="chat-text" style="display: flex;">

          <div style="width: 100%;padding: 10px;position: relative;">
            <div id="img-preview">
              <!--img src="https://mdbootstrap.com/wp-content/uploads/2018/02/modal-new.jpg"><a id="rmv-img">×</a-->
              </div>
              <textarea class="text-input" id="text-chat"  rows="1"></textarea>  
            </div>
            <div class="btn-send-panel">
              <input type="file" id="file_pick" style="display: none" accept="image/*">
              <a href="" id="btn-file">
                <i class="fa fa-paperclip fa-2x"></i>
              </a>
              <a href="" id="btn-send">
                <i class="fa fa-send fa-2x fa-rotate-45"></i>
              </a>
            </div>
          </div>


        </div>
      </div>
      <div class="inbox_people3" style=" margin-top: 10px;padding:0px 0px 0px 0px !important;display: none;">
        <div class="mesgs" style="overflow-y: scroll;padding: 10px 10px 0 10px !important">
          <div class="msg_history1" style="height: 550px !important;overflow-x: hidden;">
            <div class="col-md-12 col-sm-12 flex flex-column p-0" style="max-height:770px;">

             <div class="row">
               <div class="col-md-12"> 
                <button class="btn btn-primary btn-circle btn-sm" onclick="createTicket()"> <i class="fa fa-ticket"></i> Create Ticket</button>

                <input data-toggle="toggle" value="1" type="checkbox" id="status_wa" data-width="120px" data-on="Complete" data-off="Not Complete">

              </div>
            </div>
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
            <div style="border-radius: 5px;border: 1px solid #ccc; margin-bottom: 10px">
              <div class="form-group" style="margin-bottom: 5px;display: flex;">
                <label class="col-md-12 col-sm-12" style="font-size: 1.2em">Customer's Information</label>
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
            </div>

            <div style="border-radius: 5px;border: 1px solid #ccc; margin-bottom: 10px">
              <div class="form-group" style="margin-bottom: 5px;display: flex;">
                <label class="col-md-12" style="font-size: 1.2em">Transaction Summary</label>
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
            </div>
            <div style="border-radius: 5px;border: 1px solid #ccc; height: 230px;">
              <div class="form-group" style="margin-bottom: 5px;display: flex;">
                <label class="col-md-12" style="font-size: 1.2em">Customer's Address</label>
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
                  <button type="button" class="btn btn-primary" id="btn-update" style="padding:8px 12px;width:100%;">Edit Profile</button>
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
                 /* foreach ($province as $key => $v) {
                    echo '<option value="'.$v['text'].'">'.$v['text'].'</option>';
                  }*/
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
             /*     foreach ($subsidiary as $key => $v) {
                    $sel = $fields['subsidiary']==$v['text']?'selected':'';
                    echo '<option value="'.$v['text'].'" '.$sel.'>'.$v['text'].'</option>';
                  }*/
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

</body>
</html>
<script src="<?=base_url('assets/dist/js/autobahn.js')?>"></script>
<script>
  var conn = new ab.Session('ws://al-tele.dutamedia.com:8080',
    function () {
      conn.subscribe('wa<?php echo $number ?>', function (topic, data) {
                    // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
                    console.log('Receive new chat "' + data.dashboard + '" : ');
                    console.log(data);

                    $('.received').text(data.dashboard.recieve)   
                    $('.sent').text(data.dashboard.send)                  
                    $('.all').text(data.dashboard.total)
                    var v=data.data;



                    var endchat = '';
                    endchat+='<div class="chat_list active_chat '+v.wa_number+'"" onclick="setHp('+v.wa_number+');'+
                    'openchat('+v.wa_number+',\''+v.wa_customer+'\')">'+
                    '<div class="chat_people">'+
                    '<div class="chat_img">'+
                    '<img src="https://ptetutorials.com/images/user-profile.png">'+
                    '</div>'+
                    '<div class="chat_ib">'+
                    '<h5 class="chat_people_header">'+v.wa_customer+' <span class="badge badge-danger badge-'+v.wa_number+'" style="background: red">'+data.history_chat+'</span></h5>'+
                    '<div class="chat_date">'+v.date+' - '+v.time +'</div>'+
                    '<p class="ellipsis">'+v.wa_text+'</p>'+
                    '</div>'+
                    '</div>'+
                    '</div>';



                    var promise =$('#myAudio')[0].play(); 


                    if (promise) {
    //Older browsers may not return a promise, according to the MDN website
    promise.catch(function(error) { console.error(error); });
  }

  $('.'+v.wa_number).remove();

  $('.inbox_chat').prepend(endchat);


  if(hpChat!='' ){    

      $('.chat_list').removeClass('active_chat');
      $('.'+hpChat).addClass('active_chat');
}


  if(hpChat!='' && hpChat==v.wa_number){

    var img = '';

      /*        if(v.image!=null){
                img = '<a href="'+url_base+'assets/wa_images/'+v.image+'" data-fancybox="images"><img src="'+url_base+'assets/wa_images/'+v.image+'" width="300px"></a><br>';
              }*/
              chats='';
              if(v.is_reply==1){
                chats+='<div class="incoming_msg">'+
                '<div class="incoming_msg_img">'+
                '<img src="https://ptetutorials.com/images/user-profile.png" alt="sunil">'+
                '</div>'+
                '<div class="received_msg">'+
                '<div class="received_withd_msg">'+
                '<p>'+img +' '+v.wa_text+'</p>'+
                '<span class="time_date">'+ v.time+' | '+v.date+'</span>'+
                '</div>'+
                '</div>'+
                '</div>';
              }else{


                chats+='<div class="outgoing_msg">'+
                '<div class="sent_msg">'+
                '<p>'+img +' '+v.wa_text+'</p>'+
                '<span class="time_date">'+ v.time+' | '+v.date+'</span>'+
                '</div>'+
                '</div>';

              }


              $('#chatu').append(chats);


              if ($('#chatu').height() > $('.msg_history').height()) {
                $('.msg_history').animate({
                  scrollTop: $('#chatu')[0].scrollHeight
                }, 200);



              }



            }

          });
    },
    function () {
      console.warn('WebSocket connection closed');
    },
    {'skipSubprotocolCheck': true}
    );

    /*var conn = new WebSocket('wss://al-tele.dutamedia.com/wss2/NNN');
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
</script>

<script type="text/javascript">
  var url_base = '<?=base_url()?>';
  var hpChat='';
  var wa='';

    //menampilkan pesan sisi kiri
    last_chat();
    function last_chat(){
      $.ajax({
        url : "<?=base_url('wa/lastchat/').$type?>"+"?agent="+<?php echo $number ?>,
        type: "Get",
        dataType: 'json',
      })
      .done(function(res){

        var endchat = '';
        $.each(res, function(i,v){
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
          '</div>'+
          '</div>';
        });
        $('.inbox_chat').html(endchat);


  if(hpChat!='' ){    

      $('.chat_list').removeClass('active_chat');
      $('.'+hpChat).addClass('active_chat');
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
    $('#text-chat').keydown(function(event) {
      if (event.which == 13) {          
        event.preventDefault();

        var wa_number=hpChat;
        var imgfile = '';
        if($('#img-send').length > 0){
          imgfile = $('#img-send').attr('src');

        } else{
          imgfile = '';
        }
        $.ajax({
          url : '<?php echo base_url("wa/send"); ?>',
          type: "POST",
          data : {'number':wa_number, 'message':$('#text-chat').val(), 'img':imgfile,'type':'<?=$type ?>'},
          dataType: 'json',
        })
        .done(function(res){
          console.log(res);
          if(res.status==true && res.status!=200){
            im = '';
            if(imgfile!=''){
              im = '<a href="'+url_base+'assets/wa_images/'+res.image+'" data-fancybox="images"><img src="'+url_base+'assets/wa_images/'+res.image+'" width="200px"></a><br>';
            }
            var chats='';
            chats+='<div class="outgoing_msg">'+
            '<div class="sent_msg">'+
            '<p>'+im +' '+res.text+'</p>'+
            '<span class="time_date">'+ res.time+' | '+res.date+'</span>'+
            '</div>'+
            '</div>';

            $('#chatu').append(chats)

            if ($('#chatu').height() > $('.msg_history').height()) {
              $('.msg_history').animate({
                scrollTop: $('#chatu')[0].scrollHeight
              }, 200);

            }
            $('#text-chat').val('')
            $('#img-preview').html('');

          }else if(res.status==false){
        /*$().toastmessage('showToast', {
          text     : res.msg,
          sticky   : false,
          position : 'top-center',
          type     : 'error',
        });*/
        alert(res.msg)
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
      var wa_number=hpChat;
      var imgfile = '';
      if($('#img-send').length > 0){
        imgfile = $('#img-send').attr('src');

      } else{
        imgfile = '';
      }
      $.ajax({
        url : '<?php echo base_url("wa/send"); ?>',
        type: "POST",
        data : {'number':wa_number, 'message':$('#text-chat').val(), 'img':imgfile,'type':'<?=$type ?>'},
        dataType: 'json',
      })
      .done(function(res){
        console.log(res);
        if(res.status==true && res.status!=200){
          im = '';
          if(imgfile!=''){
            im = '<a href="'+url_base+'assets/wa_images/'+res.image+'" data-fancybox="images"><img src="'+url_base+'assets/wa_images/'+res.image+'" width="200px"></a><br>';
          }
          var chats='';
          chats+='<div class="outgoing_msg">'+
          '<div class="sent_msg">'+
          '<p>'+im +' '+res.text+'</p>'+
          '<span class="time_date">'+ res.time+' | '+res.date+'</span>'+
          '</div>'+
          '</div>';

          $('#chatu').append(chats)

          if ($('#chatu').height() > $('.msg_history').height()) {
            $('.msg_history').animate({
              scrollTop: $('#chatu')[0].scrollHeight
            }, 200);

          }
          $('#text-chat').val('')
          $('#img-preview').html('');

        }else if(res.status==false){
        /*$().toastmessage('showToast', {
          text     : res.msg,
          sticky   : false,
          position : 'top-center',
          type     : 'error',
        });*/
        alert(res.msg)
      }
    })
      .fail(function(jqXHR, textStatus, errorThrown){
        $.post('<?=base_url('logger/writexhrlog')?>', {'act':'calling', 'xhr':jqXHR.responseText, 'status':textStatus, 'error':errorThrown});
        alert('Error,something goes wrong');
      });
    });





    $('#file_pick').change(function () {
      var reader = new FileReader();
      var file    = document.querySelector('#file_pick').files[0];
      reader.onloadend = function () {
       $('#img-preview').html('<img src="'+reader.result+'" id="img-send"><a id="rmv-img">×</a>');
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


    function setHp(hp){
      hpChat=hp;
    }


    function openchat(number,nama){
      numberChat=number;

      $('.chat_list').removeClass('active_chat');
      $('.'+number).addClass('active_chat');

      $.ajax({
        url : '<?php echo base_url("wa/chat/"); ?><?php echo $type.'/'.$number ?>',
        type: "POST",
        data : {'phone':numberChat},
        dataType: 'json',
        success:function(data, textStatus, jqXHR){
          console.log(data);
          if(data.status){
            $('.chat-panel').addClass('open');
            var html = '';
            $.each(data.data, function(i,v){
             //open ini
             if(i!='status_wa' && i.indexOf('whatsapp') < 0){
              html+='<div style="display:flex;margin-left:-15px;margin-right:-15px;">';
              html+='<label class="col-md-4">'+i.replace('form_','').split('_').join(' ')+'</label><label class="col-md-8">: '+v+'</label>';
              html+='</div>';
            }else{
              if(v=='Complete'){
                $('#text-chat').prop('disabled',true);
                $('#btn-send').prop('disabled',true);
                $('#status_wa').bootstrapToggle('on')
                $('#status_wa').bootstrapToggle('disable')
              }else{
                $('#text-chat').prop('disabled',false);
                $('#btn-send').prop('disabled',false);
              }
            }
          });
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
                '<img src="https://ptetutorials.com/images/user-profile.png" alt="sunil">'+
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
                '<span class="time_date">'+ v.time+' | '+v.date+'</span>'+
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
      });

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
      //$('#btn-update-panel').show();
    })
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
          url: '<?=base_url('wa/search_add/3ec8112b9e277cf4d24c85136fc9ee95')?>',
          data: {'phone':$('#seach_cus').val()},
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
            $.each(res.data, function(i,v){
              if(i=='ngender'){
                $('input#ngender_'+v).prop('checked', true);
              }else if(i=='nbrand_interest'){
                $.each(v, function(idx, item){
                  $('input#bi_'+item.toLowerCase().split(' ').join('_')).prop('checked', true);
                });
              }else if(i!='nprovince'&&i!='ncity'&&i!='ndistrict'&&i!='nsubsidiary'){
                $('input#'+i).val(v);
                $('span#'+i).html(v);
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

      function createTicket(){
        var win = window.open('<?=base_url('api/kanmo/form_ticket/3ec8112b9e277cf4d24c85136fc9ee95?agent=')?>'+<?php echo $number ?>+'&phone='+hpChat+'&wa=1', '_blank');
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
	    socket = new WebSocket('wss://al-tele.dutamedia.com/wss2/NNN');
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