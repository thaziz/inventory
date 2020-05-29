
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

<!--script src="<?php echo base_url('node_modules/socket.io/node_modules/socket.io-client/socket.io.js');?>"></script-->

<style type="text/css">
  /*---------chat window---------------*/
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
  height: 550px;
  overflow-y: scroll;
}

.active_chat {
  background: #e8f6ff;
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


.d {
  /*border: #968585 1px solid;*/
  background: #f0f0f0 none repeat scroll 0 0;
  border-radius: 0 15px 15px 15px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}

.f {
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

.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}

.received_withd_msg {
  width: 57%;
}

.received_withd_msg_r {
  width: 57%;
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
  width: 46%;
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
  height: 450px;
  overflow-y: auto;
}

.ellipsis { text-overflow: ellipsis; }
</style>

<style type="text/css">
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
    td.align-right{
      text-align: right;
    }
    .select2-container--default .select2-selection--single{
      height: 34px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered{
      line-height: 32px !important
    }
    .max-lines {
  display: block;/* or inline-block */
  text-overflow: ellipsis;
  word-wrap: break-word;
  overflow: hidden;
  max-height: 3.6em;
  line-height: 1.8em;
}
  </style>
</head>
</style>
<nav class="navbar" style="background: #c62828; margin-bottom:0px !important">
  <div class="container-fluid">
    <!-- <div class="navbar-header">
      <a class="navbar-brand" href="#">WebSiteName</a>
    </div> -->
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
          <div class="chat_people">
            <div class="chat_img"> 
                <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
            <div class="chat_ib">
              <h5>Sunil Rajput <span class="badge badge-danger" style="background: red">4</span> <div class="chat_date"> Dec 25</div></h5>
              <p class="ellipsis">Test, which is a new approach to have all solutions 
              astrology under one roof.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

  <div class="inbox_people2">
      <div class="headind_srch">
        <div class="recent_heading">
          <h4>Info</h4>
        </div>
        <div class="srch_bar">
          <div class="stylish-input-group">
            <div>Nama : Ali Ahmad</div>
            <div>No Wa : 091232526617</div>
            <div> Email: ahmad@kanmo.com</div>
          </div>
        </div>
      </div>
      <div class="mesgs">
        <div class="msg_history">
       <!--  //repl -->
        <div class="incoming_msg">
            <div class="incoming_msg_img">
               <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> 
             </div>
            <div class="received_msg">
              <div class="received_withd_msg_r">

                <div class="d">

                <div class="f row max-lines">

                	<div class="col-md-10"  style="padding: 0px	">ini  all dsfdsf sdfdsfdsf dsfdsfdsfdsf sdfdsfdsfdsfdsf dsfdsfdsfdsf sdfsdfsd 
                	</div>
                	<div  class="col-md-2" style="padding: 0px"> 

                	<img  src="/kanmo/assets/wa_images/486A5013CB0B4F43651F0DBD9BAA34E3.jpeg" width="40px">
                	</div>
                </div>
                  Test which is a new approach to have all
                solutions
              </div>
                <span class="time_date"> 11:01 AM    |    June 9</span>
              </div>
            </div>
          </div>

          <div class="incoming_msg">
            <div class="incoming_msg_img">
               <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> 
             </div>
            <div class="received_msg">
              <div class="received_withd_msg">
                <p>Test which is a new approach to have all
                solutions</p>
                <span class="time_date"> 11:01 AM    |    June 9</span>
              </div>
            </div>
          </div>
          <div class="outgoing_msg">
            <div class="sent_msg">
              <p>Test which is a new approach to have all
                solutions</p>
              <span class="time_date"> 11:01 AM    |    June 9</span> 
            </div>
          </div>
        </div>
        <div class="type_msg">
          <div class="input_msg_write">
            <input type="text" class="write_msg" placeholder="Type a message" />
            <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
          </div>
        </div>
      </div>
    </div>
    <div class="inbox_people3" style=" margin-top: 10px">
      <div class="col-md-12 col-sm-12 flex flex-column p-0" style="max-height:770px;margin-left:10px;overflow-y:auto;">
        <div style="border-radius: 5px;border: 0px solid #ccc; margin-bottom: 10px; padding: 0 15px;">
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
          <div class="form-group" style="margin-bottom: 5px;">
            <label class="col-md-12 col-sm-12" style="font-size: 1.2em">Customer's Information</label>
          </div>
          <div class="form-group cus-field-info">
            <label class="col-md-5 col-sm-5" for="callback">Current Tier</label>
            <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="current_slab"></span></label>
            <input type="hidden" name="current_slab" value="">
          </div>
          <div class="form-group cus-field-info">
            <label class="col-md-5 col-sm-5" for="callback">Loyalty Points</label>
            <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="loyalty_points"></span></label>
            <input type="hidden" name="loyalty_points" value="">
          </div>
          <div class="form-group cus-field-info">
            <label class="col-md-5 col-sm-5" for="callback">Registered on</label>
            <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tregistered_on"></span></label>
            <input type="hidden" name="registered_on" value="">
          </div>
          <div class="form-group cus-field-info">
            <label class="col-md-5 col-sm-5" for="callback">Registered Store</label>
            <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="registered_store"></span></label>
            <input type="hidden" name="registered_store" value="">
          </div>
          <div class="form-group cus-field-info">
            <label class="col-md-5 col-sm-5" for="callback">Subsidiary</label>
            <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="subsidiary"></span></label>
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
            <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="fraud_status"></span></label>
            <input type="hidden" name="fraud_status" value="">
          </div>
          <div class="form-group cus-field-info">
            <label class="col-md-5 col-sm-5" for="callback">Gender</label>
            <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="gender"></span></label>
            <input type="hidden" name="gender" value="">
          </div>
        </div>

        <div style="border-radius: 5px;border: 1px solid #ccc; margin-bottom: 10px">
          <div class="form-group" style="margin-bottom: 5px;">
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
            <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="last_sale_amount"></span></label>
            <input type="hidden" name="last_sale_amount" value="">
          </div>
          <div class="form-group cus-field-info">
            <label class="col-md-5 col-sm-5" for="callback">Last Sale Date</label>
            <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="tlast_sale_date"></span></label>
            <input type="hidden" name="last_sale_date" value="">
          </div>
          <div class="form-group cus-field-info">
            <label class="col-md-5 col-sm-5" for="callback">Last 12 Month Sale Amount</label>
            <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="last_twelve_mon_sale"></span></label>
            <input type="hidden" name="last_twelve_mon_sale" value="">
          </div>
        </div>
        <div style="border-radius: 5px;border: 1px solid #ccc; height: 230px;">
          <div class="form-group" style="margin-bottom: 5px;">
            <label class="col-md-12" style="font-size: 1.2em">Customer's Address</label>
          </div>
          <div class="form-group cus-field-info">
            <label class="col-md-5 col-sm-5" for="callback">Home Address</label>
            <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="address_one_home_one"></span></label>
            <input type="hidden" name="address_one_home_one" value="">
          </div>
          <div class="form-group cus-field-info">
            <label class="col-md-5 col-sm-5" for="callback">Zip/Postal Code</label>
            <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="zip_code"></span></label>
            <input type="hidden" name="zip_code" value="">
          </div>
          <div class="form-group cus-field-info">
            <label class="col-md-5 col-sm-5" for="callback">City</label>
            <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="city_one"></span></label>
            <input type="hidden" name="city_one" value="">
          </div>
          <div class="form-group cus-field-info">
            <label class="col-md-5 col-sm-5" for="callback">Province</label>
            <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="province_one"></span></label>
            <input type="hidden" name="province_one" value="">
          </div>
          <div class="form-group cus-field-info">
            <label class="col-md-5 col-sm-5" for="callback">Country of Origin</label>
            <label class="col-md-7 col-sm-7 info-value">: <span class="ftext" id="country_origin"></span></label>
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
                    //$sel = $fields['province_one']==$v['text']?'selected':'';
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
                    $sel = $fields['subsidiary']==$v['text']?'selected':'';
                    echo '<option value="'.$v['text'].'" '.$sel.'>'.$v['text'].'</option>';
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





</body>
</html>
<!--script src="<?php echo base_url('node_modules/socket.io/node_modules/socket.io-client/socket.io.js');?>"></script-->
<script type="text/javascript">


  //var socket = io.connect( 'http://'+window.location.hostname+':3000' );


/*  socket.on( 'new_messag', function( data ) {
  endchat='<div class="chat_list '+data.wa_number+'" onclick="chatOpen('+data.wa_number+');openchat('+data.wa_number+')">'+
                        '<div class="chat_people ">'+
                            '<div class="chat_img">'+
                              '<img src="https://ptetutorials.com/images/user-profile.png" alt="sunil">'+
                               '</div>'+
                                  '<div class="chat_ib">'+
                                  '<h5>'+data.name+'<span class="chat_date">'+data.date+'</span></h5>'+
                  '<p>'+data.text+'</p>'+
                '</div>'+
              '</div>'+
            '</div>';
        $('.'+data.wa_number).remove();
        
        $('.inbox_chat').prepend(endchat);

  });
*/




 end();
function end(){
  $.ajax({
        url : "<?=base_url('wa/endchat')?>"+"?agent="+<?php echo $number ?>,
        type: "Get",
        dataType: 'json',
    })
    .done(function(res){

          var endchat = '';
        $.each(res, function(i,v){
        endchat+='<div class="chat_list '+v.wa_number+'"" onclick="chatOpen('+v.wa_number+');openchat('+v.wa_number+')">'+
                        '<div class="chat_people">'+
                            '<div class="chat_img">'+
                              '<img src="https://ptetutorials.com/images/user-profile.png" alt="sunil">'+
                               '</div>'+
                                  '<div class="chat_ib">'+
                                  '<h5>'+v.name+'<span class="chat_date">'+v.date+' - '+v.time +'</span></h5>'+
                  '<p>'+v.text+'</p>'+
                '</div>'+
              '</div>'+
            '</div>';
        });
        $('.inbox_chat').html(endchat);


          })
    .fail(function(jqXHR, textStatus, errorThrown){
        
    });
}

</script>



<script type="text/javascript">
  
      $('#btn-search').click(function(){
        alert(1);
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
</script>

<script type="text/javascript">
	var conn = new WebSocket('ws://al-tele.dutamedia.com:8080');
	conn.onopen = function (e) {
		console.log('Connection established! ');
		console.log(e)
	}
	conn.send(JSON.stringify({
	  action: "login",
	  data: '<?php echo $number ?>'
	}))
</script>