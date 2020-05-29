<?php
defined('BASEPATH') or exit('No direct script access allowed');
$opt = array('exact' => 'Exact', 'begins with' => 'Begins With', 'contains' => 'Contains', 'ends with' => 'Ends With');
?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/dist/css/progressbar.css') ?>">
<!-- daterange picker -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/materialtimepicker/mdtimepicker.min.css">
<style type="text/css">
  .p-0 {
    padding: 0;
  }

  .table-box {
    border: 1px solid #ddd;
    border-radius: 4px;
  }

  .table-box>tbody>tr>th {
    background-color: #f9f9f9;
    font-weight: bold;
    color: #000;
    text-align: center;
  }

  table.table-box tr:last-child td:first-child {
    border-bottom-left-radius: 10px;
  }

  table.table-box tr:last-child td:last-child {
    border-bottom-right-radius: 10px;
  }

  .note {
    position: relative;
  }

  .note>label:hover+.note-content,
  .note-content:hover {
    display: block;
  }

  .note-content {
    display: none;
    position: absolute;
    width: 250px;
    min-height: 75px;
    max-height: 400px;
    right: 60px;
    top: 0;
    padding: 6px 12px;
    border-radius: 4px;
    background-color: #555;
    color: #fff;
    border: 1px solid #ddd;
    overflow-y: auto;
    z-index: 999;
  }

  .dt-button.buttons-columnVisibility:first-child {
    display: none;
  }
</style>

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Campaign <?= $data->campaign_name; ?><small>Report</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url('panel'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="<?= base_url('panel/campaign'); ?>">Campaign</a></li>
      <li class="active">Report</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <ul class="nav nav-tabs">
          <li role="presentation"><a href="<?= base_url('panel/campaign/dashboard/' . $data->campaign_id); ?>">Dashboard</a></li>
          <li role="presentation"><a href="<?= base_url('panel/campaign/detail/' . $data->campaign_id); ?>">Detail</a></li>
          <?php if ($rules['e'] || $rules['c']) : ?>
            <li role="presentation"><a href="<?= base_url('panel/campaign/agents/' . $data->campaign_id); ?>">Agents</a></li>
            <li role="presentation"><a href="<?= base_url('panel/campaign/assignment/' . $data->campaign_id); ?>">Assignment</a></li>
            <li role="presentation"><a href="<?= base_url('panel/campaign/target/' . $data->campaign_id); ?>">Target Tools</a></li>
          <?php endif; ?>
          <li role="presentation" class="active"><a href="#">Report</a></li>

        </ul>
        <div class="box" style="border:1px solid #ddd;border-top:none;border-top-left-radius:0;border-top-right-radius:0;">


          <div class="box-body">

            <div class="col-md-12 p-0">
              <div class="box">
                <!-- Start advancd search form -->
                <div class="row" style="padding-top: 15px;">
                  <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-primary collapse" id="search" style="margin-bottom: 0;">
                      <div class="panel-body">
                        <form class="form-horizontal" method="post" id="search_form">
                          <?php $form = json_decode($data->form); ?>
                          <?php foreach ($form as $item) : ?>
                            <div class="form-group">
                              <label class="col-sm-2 control-label" for="<?= $item->name ?>"><?= $item->label ?></label>
                              <?php if ($item->type == 'number') : ?>
                                <div class="col-sm-4">
                                  <input type="number" name="adv_search[form_<?= $item->name ?>]" class="form-control" placeholder="<?= $item->label ?>" min="<?= $item->min ?>" max="<?= $item->max ?>" id="<?= $item->name ?>">
                                </div>
                              <?php elseif ($item->type == 'dropdown' || $item->type == 'radio' || $item->type == 'checkbox') : ?>
                                <div class="col-sm-6">
                                  <select class="form-control" name="adv_search[form_<?= $item->name ?>]" id="<?= $item->name ?>">
                                    <option value=""> --<?= $item->label ?>-- </option>
                                    <?php
                                    foreach ($item->option as $key => $v) {
                                      echo '<option value="' . $v . '">' . $v . '</option>';
                                    }
                                    ?>
                                  </select>
                                </div>
                              <?php elseif ($item->type == 'date') : ?>
                                <div class="col-sm-5">
                                  <input type="text" name="adv_search[form_<?= $item->name ?>]" class="form-control date" placeholder="<?= $item->label ?>" id="<?= $item->name ?>">
                                </div>
                              <?php elseif ($item->type == 'text' || $item->type == 'email' || $item->type == 'textarea') : ?>
                                <div class="col-sm-6">
                                  <input type="text" name="adv_search[form_<?= $item->name ?>]" class="form-control" placeholder="<?= $item->label ?>" id="<?= $item->name ?>">
                                </div>
                                <div class="col-sm-2 pull-right">
                                  <select name="opt[form_<?= $item->name ?>]" class="form-control input-sm" readonly>
                                    <?php
                                    foreach ($opt as $key => $value) {
                                      $sel = '';
                                      /*if(is_array($search_f)){
                                            $sel = $search_f['opt']['pre_prefix']==$key?'selected':'';
                                          }*/
                                      echo '<option value="' . $key . '" ' . $sel . '>' . $value . '</option>';
                                    }
                                    ?>
                                  </select>
                                </div>
                              <?php elseif ($item->type == 'password' || $item->type == 'file') :
                                continue; ?>
                              <?php endif; ?>
                            </div>
                          <?php endforeach; ?>
                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="assignment">Assignment</label>
                            <div class="col-sm-5">
                              <select name="adv_search[assign_id]" class="form-control select2" id="assignment">
                                <option value="">-- Assignment --</option>
                                <?php
                                foreach ($assigns as $key => $value) {
                                  echo '<option value="' . $value->assign_id . '">' . $value->adm_name . '</option>';
                                }
                                ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="caller">Caller</label>
                            <div class="col-sm-5">
                              <select name="adv_search[agent_id]" class="form-control select2" id="caller">
                                <option value="">-- Caller --</option>
                                <?php
                                foreach ($agents as $key => $value) {
                                  echo '<option value="' . $value->adm_id . '">' . $value->adm_name . '</option>';
                                }
                                ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="caller">Attemp</label>
                            <div class="col-sm-3">
                              <input type="number" name="adv_search[retries]" class="form-control">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="call_date">Call Date</label>
                            <div class="col-sm-5">
                              <input type="text" name="adv_search[call_date]" value="<?= date('F d, Y') . " 01:00 AM - " . date('F d, Y') . ' 11:59 PM' ?>" class="form-control date_range" id="call_date">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="api-status">Response Status</label>
                            <div class="col-sm-3">
                              <select name="adv_search[api_status]" class="form-control" id="api-status">
                                <option value="">-- Response Status --</option>
                                <option value="ANSWER">ANSWER</option>
                                <option value="CANCEL">CANCEL</option>
                                <option value="BUSY">BUSY</option>
                                <option value="CONGESTION">CONGESTION</option>
                                <option value="CHANUNAVAIL">CHANUNAVAIL</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="status">Call Status</label>
                            <div class="col-sm-3">
                              <select name="adv_search[call_status]" class="form-control" id="call_status">
                                <option value="">-- Call Status --</option>
                                <option value="Contacted">Contacted</option>
                                <option value="Not Contacted">Not Contacted</option>
                              </select>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="status">Call Status</label>
                            <div class="col-sm-3">
                              <select name="adv_search[status]" class="form-control" id="statuss">
                                <option value=""> -- Status -- </option>
                              </select>
                            </div>
                          </div>

                          <!--div class="form-group">
                          <label class="col-sm-2 control-label" for="mstatus">Data Status</label>
                          <div class="col-sm-3">
                            <select name="adv_search[merchant_status]" class="form-control" id="mstatus">
                              <option value="">-- Merchant Status --</option>
                              <option value="Interest (Meeting BD)">Interest (BD)</option>
                              <option value="Interest (Meeting SALES)">Interest (SALES)</option>
                              <option value="Follow Up BD">Follow Up BD</option>
                              <option value="Follow Up Sales">Follow Up Sales</option>
                              <option value="Call Back">Call Back</option>
                              <option value="Not Interest">Not Interest</option>
                            </select>
                          </div>
                        </div-->
                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="note">Note</label>
                            <div class="col-sm-6">
                              <input type="text" name="adv_search[note]" class="form-control" placeholder="Note" id="note">
                            </div>
                            <div class="col-sm-2 pull-right">
                              <select name="opt[note]" class="form-control input-sm" readonly>
                                <?php
                                foreach ($opt as $key => $value) {
                                  $sel = '';
                                  /*if(is_array($search_f)){
                                        $sel = $search_f['opt']['pre_prefix']==$key?'selected':'';
                                      }*/
                                  echo '<option value="' . $key . '" ' . $sel . '>' . $value . '</option>';
                                }
                                ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-4 col-md-offset-5">
                              <button type="submit" class="btn btn-primary">Search</button>
                              <button type="button" class="btn btn-default" id="clear">Clear</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End advancd search form -->

                <div class="box-header">
                  <h3 class="box-title pull-left" style="margin-top:10px;">Campaign Report

                  </h3>
                  <div class="col-md-3">
                    <select class="form-control" id="type-report">
                      <option value="call" selected>Call</option>
                      <option value="data">Data</option>
                    </select>
                  </div>
                  <div class="action pull-right">
                    <a class="btn btn-primary btn-sm btn-circle" data-toggle="collapse" data-target="#search">
                      <i class="fa fa-search"></i> Search
                    </a>
                    <?php
                    $grp_id = $this->session->userdata();
                    $display = '';
                    if ($grp_id['grp_id']  ==  2) {
                      $display = 'none';
                    } else {
                      $display = '';
                    }
                    ?>
                    <a style="display: <?php echo $display; ?>" class="btn btn-success btn-sm btn-circle" id="export-data"><i class="fa fa-file-excel-o"></i> Export</a>
                  </div>
                </div>
                <div class="box-body table-reponsive">
                  <table style="width:100%" id="report_table" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th></th>
                        <th width="30">NO</th>
                        <?php
                        foreach (json_decode($data->form) as $key => $value) {
                          echo '<th title="' . $value->label . '">' . substr($value->label, 0, 25) . '</th>';
                        }
                        if ($sms_enabled == 1) {
                          echo '<th>Receiver</th>';
                          echo '<th>SMS Text</th>';
                          echo '<th>SMS Return Status</th>';
                        }
                        ?>
                        <th>Called Phone</th>
                        <th>Assignment</th>
                        <th>Caller</th>
                        <th>Attemp</th>
                        <th>Call Date</th>
                        <th>Response Status</th>
                        <th>Call Status</th>
                        <th>Status</th>
                        <th>PTP Date</th>
                        <th>PTP Amount</th>
                        <th>Last Call Duration</th>
                        <!--th width="75">Merchant Status</th-->
                        <th>Note</th>
                        <th>Reason</th>
                        <th>Campaign</th>
                        <?php

                        if ($wa_enabled == 1) {
                          echo '<th>Wa Status</th>';
                        }
                        ?>
                        <th>Recording File</th>
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
  </section>
  <div class="chat-panel" style="display:none;">
    <div class="chat-wrap">
      <div class="col-md-8" style="padding:0; display: flex;flex-direction: column;">
        <div class="header-chat">
          <a href="" class="close"><i class="fa fa-times"></i></a>
          <span class="header-icon">
            <i class="fa fa-user fa-2x"></i>
          </span>
          <span class="header-text">Whatsapp Chat</span>
        </div>
        <div class="chat-content" style="overflow-y: auto;width: 100%;">
          <ul id="chat">
            <!--li class="rchat"><span>Hello dasdfa dsfa sdf<br>selamat pagi,<small class="time">09:10</small></span></li>
            <li class="achat"><span>hello to<small class="time">09:10</small></span></li>
            <li class="achat"><span>bisa dibantu<small class="time">09:10</small></span></li>
            <li class="rchat"><span>Hello<small class="time">09:10</small></span></li-->
          </ul>
        </div>

      </div>
      <div class="col-md-4 siderbar-chat">
        <div class="panel-info" style="display: flex; flex-direction: column;">
          <h4>Data Info</h4>
          <div id="info" style="overflow-y: auto">

          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<style type="text/css">
  .chat-panel {
    position: fixed;
    width: 0;
    height: 100%;
    top: 50px;
    background: #fafafa;
    z-index: 999;
    -webkit-transition: right .5s;
    /* Safari */
    transition: right .5s;
  }

  .chat-panel.open {
    right: 0 !important;
  }

  .chat-panel .chat-wrap {
    display: flex;
    flex-direction: row;
    height: 100%
  }

  .chat-panel .chat-wrap .header-chat {
    width: 100%;
    padding: 10px 0;
    display: flex;
    border-bottom: 1px solid #cfcfcf;
    background: #eee;
  }

  .chat-panel .chat-wrap .header-chat a.close {
    font-size: 1.4em;
    margin: 0 15px 0 5px;
    color: #999;
  }

  .chat-panel .chat-wrap .header-chat .header-icon {
    border-radius: 50%;
    width: 30px;
    height: 30px;
    background: #fff;
    color: #bbb;
    display: inline-block;
    overflow: hidden;
    text-align: center;
  }

  .chat-panel .chat-wrap .header-chat .header-text {
    font-size: 1.5rem;
    font-weight: bold;
    display: inline-block;
    margin-top: 5px;
    margin-left: 15px;
  }

  .chat-content {
    padding: 5px 10px;
    background: url('<?= base_url('assets/dist/img/wabg.png') ?>');
  }

  .chat-content ul#chat {
    padding-left: 0;
    margin: 0;
    list-style: none;
    width: 100%;
  }

  .chat-content ul#chat li {
    display: flex;
    width: 100%;
  }

  .chat-content ul#chat li>span {
    padding: 5px 10px;
    margin: 2px 0;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
  }

  .chat-content ul#chat li>span>small.time {
    margin-left: 15px;
    margin-top: 2px;
    margin-bottom: -1px;
    color: #999;
    float: right;
    bottom: -5px;
    position: relative;
  }

  .chat-content ul#chat li.rchat {
    justify-content: flex-start;
  }

  .chat-content ul#chat li.achat {
    justify-content: flex-end;
  }

  .chat-content ul#chat li.rchat span {
    background: #fff;
    border-top-right-radius: 5px;
  }

  .chat-content ul#chat li.achat span {
    background: #99ffcc;
    border-top-left-radius: 5px;
  }

  .siderbar-chat {
    border-left: 1px solid #cfcfcf;
    height: 100%;
    background: #eee;
    display: flex;
    flex-direction: column;
  }
</style>

<form id="column-form">
  <?php
  $clabel = array('No');
  $cname = array('no');
  $addc = array(
    'called_phone' => 'Called Phone',
    'adm_name' => 'Assignment',
    'caller' => 'Caller',
    'retries' => 'Attemp',
    'call_date' => 'Call Date',
    'api_status' => 'Reponse Status',
    'call_status' => 'Call Status',
    'status' => 'Status',
    'ptp_date' => 'PTP Date',
    'ptp_amount' => 'PTP Amount',
    'duration' => 'Duration',
    'note' => 'Note',
    '' => 'Reason',
    'campaign_name' => 'Campaign'
  );
  $idx = 1;
  foreach ($form as $f) {
    echo '<input type="hidden" name="col[' . $idx . ']" value="form_' . $f->name . '">';
    $cname[] = 'form_' . $f->name;
    echo '<input type="hidden" name="col_name[' . $idx . ']" value="' . $f->label . '">';
    $clabel[] = $f->label;
    $idx++;
  }

  if ($sms_enabled == 1) {
    echo '<input type="hidden" name="col[' . $idx . ']" value="sms_phone">';
    echo '<input type="hidden" name="col_name[' . $idx . ']" value="Receiver">';
    $cname[] = 'sms_phone';
    $clabel[] = 'Receiver';
    $idx++;
    echo '<input type="hidden" name="col[' . $idx . ']" value="sms_text">';
    echo '<input type="hidden" name="col_name[' . $idx . ']" value="SMS Text">';
    $cname[] = 'sms_text';
    $clabel[] = 'SMS Text';
    $idx++;
    echo '<input type="hidden" name="col[' . $idx . ']" value="sms_send_status">';
    echo '<input type="hidden" name="col_name[' . $idx . ']" value="SMS Return Status">';
    $cname[] = 'sms_send_status';
    $clabel[] = 'SMS Return Status';
    $idx++;
  }
  if ($wa_enabled == 1) {
    echo '<input type="hidden" name="col[' . $idx . ']" value="status_wa">';
    echo '<input type="hidden" name="col_name[' . $idx . ']" value="Status WA">';
    $cname[] = 'status_wa';
    $clabel[] = 'Status WA';
    $idx++;
  }
  foreach ($addc as $key => $val) {
    echo '<input type="hidden" name="col[' . $idx . ']" value="' . $key . '">';
    $cname[] = $key;
    echo '<input type="hidden" name="col_name[' . $idx . ']" value="' . $val . '">';
    $clabel[] = $val;
    $idx++;
  }
  ?>
</form>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script><!-- date-range-picker -->
<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script><!-- bootstrap time picker -->
<script src="<?php echo base_url(); ?>assets/plugins/materialtimepicker/mdtimepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/buttons.colVis.min.js"></script>
<script type="text/javascript">
  $(function() {
    var height = $(window).height() - $('.navbar-static-top').height();
    var cheight = height - $('.header-chat').height();
    $('.chat-panel').css('right', -$('.content-wrapper').width());
    $('.chat-panel').css('width', $('.content-wrapper').width());
    $('.chat-panel').css('height', height);
    $('.panel-info').css('height', height);
    $('#info').css('height', height - $('.panel-info h4').height());
    $('.chat-panel').show();

    $('.chat-content').css('height', cheight);
    $('.chat-content').css('max-height', cheight);

    $('.close').click(function(e) {
      e.preventDefault();
      $.get('<?= base_url('panel/wa/close_chat') ?>').done(function() {
        $('.chat-panel').removeClass('open');
      })
    });
  })

  var url_base = '<?= base_url() ?>';

  function openchat(dataid) {
    $.ajax({
      url: '<?php echo base_url("panel/wa/chat/" . $data->campaign_id); ?>',
      type: "POST",
      data: {
        'dataid': dataid
      },
      dataType: 'json',
      success: function(data, textStatus, jqXHR) {
        if (data.status) {
          $('.chat-panel').addClass('open');
          var html = '';
          $.each(data.data, function(i, v) {
            if (i != 'status_wa') {
              html += '<div style="display:flex;margin-left:-15px;margin-right:-15px;">';
              html += '<label class="col-md-4">' + i.replace('form_', '').split('_').join(' ') + '</label><label class="col-md-8">: ' + v + '</label>';
              html += '</div>';
            } else {}
          });
          $('#info').html(html);
          var chats = '';
          $.each(data.chats, function(i, v) {
            var img = '';
            if (v.image != null) {
              img = '<a href="' + url_base + 'assets/wa_images/' + v.image + '" data-fancybox="images"><img src="' + url_base + 'assets/wa_images/' + v.image + '" width="300px"></a><br>';
            }
            chats += '<li class="' + v.type + '"><span>' + img + v.text + '<small class="time">' + v.time + '</small></span></li>'
          });
          $('#chat').html(chats);
          if ($('#chat').height() > $('.chat-content').height()) {
            $('.chat-content').animate({
              scrollTop: $('#chat')[0].scrollHeight
            }, 200);
          }
          //$("#chat").scrollTop($("#chat")[0].scrollHeight);
        } else {
          $().toastmessage('showToast', {
            text: data.msg,
            sticky: false,
            position: 'top-center',
            type: 'error',
          });
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $.post('<?= base_url('logger/writexhrlog') ?>', {
          'act': 'calling',
          'xhr': jqXHR.responseText,
          'status': textStatus,
          'error': errorThrown
        });
        alert('Error,something goes wrong');
      }
    });
  }

  function show(el) {
    var f = el.attr('aria-expanded');
    el.closest('.btn-group').toggleClass('open');
    el.attr('aria-expanded', (!f));
  }

  function set_status(id, status) {
    if (confirm("Are you sure you want to change status this data to " + status + "?")) {
      $.ajax({
        url: '<?= base_url('panel/campaign/change_status/' . $data->campaign_id) ?>',
        type: 'post',
        data: {
          'data_id': id,
          'status': status
        },
        dataType: 'json'
      }).done(function(res) {
        if (res.status) {
          $().toastmessage('showToast', {
            text: 'Change status success',
            position: 'top-center',
            type: 'success',
            close: function() {
              location.reload();
            }
          });
        } else {
          $().toastmessage('showToast', {
            text: 'Change status failed',
            position: 'top-center',
            type: 'error',
          });
        }
      }).fail(function(xhr, error, status) {
        console.log(xhr);
        console.log(error);
        console.log(status);
      });
    }
  }
  $(document).ready(function() {
    $('.date').datepicker({
      dateFormat: 'yy-mm-dd',
      format: 'yyyy-mm-dd',
      //altFormat: "mm-dd-yyyy",
      //appendText: "(yyyy-mm-dd)",
      startDate: '-3d',
      //dateFormat: 'yyyy-mm-dd'
    });
    $('.date_range').daterangepicker({
      locale: {
        format: 'MMMM DD, YYYY hh:mm A',
        cancelLabel: 'Clear'
      },
      autoUpdateInput: false,
      timePicker: true,
    });
    $('.date_range').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('MMMM DD, YYYY hh:mm A') + ' - ' + picker.endDate.format('MMMM DD, YYYY hh:mm A'));
    });

    $('.date_range').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
    });
    //Timepicker
    $('.timepicker').mdtimepicker();
    <?php
    echo 'var columns = ["' . implode('","', $cname) . '"];';
    echo 'var col_name = ["' . implode('","', $clabel) . '"];';
    ?>


    function reload_table() {
      var table = $('#report_table').DataTable({
        dom: 'Bfrtip',
        buttons: [
          'colvis'
        ],
        "aLengthMenu": [10, 25, 50, 100, 500, 1000, 2500, 5000],
        "ajax": {
          "url": "<?php echo current_url() ?>",
          "type": "POST",
          "data": data_builder(),
        },
        "aaSorting": [
          [1, "desc"]
        ],
        "searching": false,
        "paging": true,
        "responsive": true,
        "bFilter": false,
        "bStateSave": false,
        "bServerSide": true,
        "sPaginationType": "full_numbers",
        "aoColumnDefs": [{
            "sClass": "center",
            "aTargets": [0],
            "data": 0,
            "visible": false
          },
          {
            "sClass": "center",
            "aTargets": [1],
            "data": 1
          },
          <?php
          $idx = 2;

          foreach (json_decode($data->form) as $value) {
            echo '{ "sClass": "center", "aTargets": [ ' . $idx . ' ], "data":' . $idx . ' },' . PHP_EOL;
            $idx++;
          }
          if ($sms_enabled == 1) {
            echo '{ "sClass": "center", "aTargets": [ ' . $idx . ' ], "data":' . $idx . ' },' . PHP_EOL;
            $idx++;
            echo '{ "sClass": "center", "aTargets": [ ' . $idx . ' ], "data":' . $idx . ' },' . PHP_EOL;
            $idx++;
            echo '{ "sClass": "center", "aTargets": [ ' . $idx . ' ], "data":' . $idx . ' },' . PHP_EOL;
            $idx++;
          }
          echo '{ "sClass": "center", "aTargets": [ ' . $idx . ' ], "data":' . $idx . ' },' . PHP_EOL;
          $idx++;
          echo '{ "sClass": "center", "aTargets": [ ' . $idx . ' ], "data":' . $idx . ' },' . PHP_EOL;
          $idx++;
          echo '{ "sClass": "center", "aTargets": [ ' . $idx . ' ], "data":' . $idx . ' },' . PHP_EOL;
          $idx++;
          echo '{ "sClass": "center", "aTargets": [ ' . $idx . ' ], "data":' . $idx . ' },' . PHP_EOL;
          $idx++;
          echo '{ "sClass": "center", "aTargets": [ ' . $idx . ' ], "data":' . $idx . ' },' . PHP_EOL;
          $idx++;
          echo '{ "sClass": "center", "aTargets": [ ' . $idx . ' ], "data":' . $idx . ' },' . PHP_EOL;
          $idx++;
          echo '{ "sClass": "center", "aTargets": [ ' . $idx . ' ], "data":' . $idx . ' },' . PHP_EOL;
          $idx++;
          echo '{ "sClass": "center", "aTargets": [ ' . $idx . ' ], "data":' . $idx . ' },' . PHP_EOL;
          $idx++;
          echo '{ "sClass": "center", "aTargets": [ ' . $idx . ' ], "data":' . $idx . ' },' . PHP_EOL;
          $idx++;
          echo '{ "sClass": "center", "aTargets": [ ' . $idx . ' ], "data":' . $idx . ' },' . PHP_EOL;
          $idx++;
          echo '{ "sClass": "center", "aTargets": [ ' . $idx . ' ], "data":' . $idx . ' },' . PHP_EOL;
          $idx++;
          /*echo '{ "sClass": "center", "aTargets": [ '.$idx.' ], "data":'.$idx.', "render":function(data, type, full){
              var color = \'default\';
              if(data==\'Interest (Meeting BD)\'){
                color = \'success\';
              }else if(data==\'Follow Up BD\'){
                color = \'info\';
              }else if(data==\'Call Back\'){
                color = \'warning\';
              }else if(data==\'Not Interest\'){
                color = \'danger\';
              }
              var html = \'<div class="btn-group" style="display:block;">\'
          +\'<button type="button" class="btn btn-\'+color+\' btn-xs" style="width:70%;cursor:default;" disabled>\'+data+\'</button>\'
          +\'<button type="button" class="btn btn-\'+color+\' btn-xs dropdown-toggle" data-toggle="dropdown" onclick="show($(this))">\'
          +\'<span class="caret"></span>\'
          +\'<span class="sr-only">Toggle Dropdown</span>\'
          +\'</button>\'
          +\'<ul class="dropdown-menu" role="menu" style="top:20px;">\'
          +\'<!--li><a href="javascript:;" onclick="set_status(\'+full[0]+\',\\\'Interest (Meeting BD)\\\')">Interest (Meeting BD)</a></li>\'
          +\'<li><a href="javascript:;" onclick="set_status(\'+full[0]+\',\\\'Follow Up BD\\\')">Follow Up BD</a></li>\'
          +\'<li><a href="javascript:;" onclick="set_status(\'+full[0]+\',\\\'Not Interested\\\')">Not Interested</a></li-->\'
          +\'<li><a href="javascript:;" onclick="set_status(\'+full[0]+\',\\\'Call Back\\\')">Call Back</a></li>\'
          +\'</ul>\'
          +\'</div>\';
      return html;}
           },'.PHP_EOL;
          $idx++;*/
          echo '{ "sClass": "center", "aTargets": [ ' . $idx . ' ], "data":' . $idx . ', "render" : function(data, type, full){ if(data.trim()!=="n/a"){return "<span class=\"note\"><label class=\"label label-default label-xs\">View Note</label><div class=\"note-content\">"+data+"</div></span>";}else{return data;}} },' . PHP_EOL;
          $idx++;
          echo '{ "sClass": "center", "aTargets": [ ' . $idx . ' ], "data":' . $idx . ' },' . PHP_EOL;
          $idx++;
          echo '{ "sClass": "center", "aTargets": [ ' . $idx . ' ], "data":' . $idx . ' },' . PHP_EOL;
          $idx++;
          if ($wa_enabled == 1) {
            echo '{ "sClass": "center", "aTargets": [ ' . $idx . ' ], "data":' . $idx . ' },' . PHP_EOL;
            $idx++;
          } else {
            //$idx++;
          }
          echo '{ "sClass": "center", "aTargets": [ ' . $idx . ' ], "data":' . $idx . ', "render" : function(data, type, full){
            html = data!=\'\'?\'<a href="#" onclick="window.open(\\\'' . base_url('campaign/play/') . '\'+data+\'\\\', \\\'Play Recording\\\', \\\'width=315,height=58\\\');" class="btn btn-xs btn-primary">Play</a>&nbsp;&nbsp;<a href="' . str_replace('telmark/', '', base_url()) . 'api/recording/?key=jkHAK23kjhsd223klja677skajskkjsh&filename=\'+data+\'">Download</a>\':\'\';';
          if ($wa_enabled == 1) {
            echo 'html += \'<button type="button" onclick="openchat(\'+full[0]+\')" class="btn btn-success btn-xs" id="show-chat"><i class="fa fa-whatsapp"></i> View Chat</button>\'; ';
          }

          echo 'return html;} },' . PHP_EOL;
          ?>
        ],
        "destroy": true
      }).on('draw.dt', function() {
        var colvis = table.columns().visible();
        $.each(colvis, function(column, state) {
          column = column - 1;
          if (state) {
            $('[name="col[' + column + ']"]').val(columns[column]);
            $('[name="col_name[' + column + ']"]').val(col_name[column]);
          } else {
            $('[name="col[' + column + ']"]').val(0);
            $('[name="col_name[' + column + ']"]').val(0);
          }
        });

      });
      $('#report_table').on('column-visibility.dt', function(e, settings, column, state) {
        column = column - 1;
        if (state) {
          $('[name="col[' + column + ']"]').val(columns[column]);
          $('[name="col_name[' + column + ']"]').val(col_name[column]);
        } else {
          $('[name="col[' + column + ']"]').val(0);
          $('[name="col_name[' + column + ']"]').val(0);
        }
        //alert( 'Table\'s column visibility are set to: '+table.columns().visible().join(', ') );
      });

    }
    $('#type-report').change(function() {
      reload_table();
    })


    reload_table();
    $('form#search_form').on('submit', function(e) {
      e.preventDefault();
      $('#search').removeClass('in');
      reload_table();
    });

    $('#clear').on('click', function(e) {
      e.preventDefault();
      $('form#search_form input').val('');
      $('form#search_form select').prop('selectedIndex', 0);
      $('form#search_form .select2').val('').trigger("change");
      $('#search').removeClass('in');
      reload_table();
    });

    function data_builder() {
      var data_set = {};
      var array = $("#search_form, #column-form").serializeArray();
      $.each(array, function(key, val) {
        data_set[val.name] = val.value;
      });
      data_set['report_type'] = $('#type-report').val();
      return data_set;
    }

    function form_builder() {
      var form = '<form id="export_form" method="post" action="">';
      var array = $("#column-form, #search_form").serializeArray();
      $.each(array, function(key, val) {
        form += '<input type="hidden" name="' + val.name + '" value="' + val.value + '">';
      });
      form += '<input type="hidden" name="report_type" value="' + $('#type-report').val() + '">';
      form += '</form>';
      $(document.body).append(form);
    }

    $('#export-data').click(function() {
      form_builder();
      $('#export_form').attr('action', '<?= base_url('panel/campaign/export/' . $data->campaign_id) ?>');
      $('#export_form').submit();
      $('#export_form').remove();
    });

    
    var contacted = ['PTP', 'Paid', 'Leave Message', 'No PTP', 'Refuse To pay', 'Call Back', 'Broken Promise', 'Drop Call by customer', 'Paid OFF'];

    var notcontacted = ['Answering Machine', 'Call Disconect', 'Ringing No Pick Up', 'Busy Tone', 'Invalid Number', 'No Sound', 'Inactive Number', 'File Back','WHATSAPP','Fake Contact','SMS'];


  /*  var contacted = ['PTP', 'Paid', 'Leave Message', 'No PTP', 'Refuse To pay', 'Call Back', 'Broken Promise', 'Drop Call by customer', 'Customer Busy', 'Paid OFF', 'Fake Contact'];

    var notcontacted = ['Answering Machine', 'Call Disconect', 'Ringing No Pick Up', 'Busy Tone', 'Invalid Number', 'No Sound', 'Inactive Number', 'File Back'];*/

    $('#call_status').change(function() {
      $('#statuss').html('<option value=""> -- Status -- </option>')
      if ($(this).val() == 'Contacted') {

        $.each(contacted, function(i, v) {
          $('#statuss').append('<option value="' + v + '">' + v + '</option>')

        })
      } else if ($(this).val() == 'Not Contacted') {
        $.each(notcontacted, function(i, v) {
          $('#statuss').append('<option value="' + v + '">' + v + '</option>')
        })
      }
    })

  });
</script>