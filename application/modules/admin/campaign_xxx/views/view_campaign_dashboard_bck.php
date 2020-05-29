<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/dist/css/progressbar.css')?>">

<style type="text/css">
    .p-0{
        padding: 0;
    }
    .table-box{
        border:1px solid #ddd;
        border-radius: 4px;
    }
    .table-box>tbody>tr>th{
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
</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Campaign <?=$data->campaign_name;?><small>Dashboard</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('panel');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?=base_url('panel/campaign');?>">Campaign</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <ul class="nav nav-tabs">
                  <li role="presentation" class="active"><a href="#">Dashboard</a></li>
                  <li role="presentation"><a href="<?=base_url('panel/campaign/detail/'.$data->campaign_id);?>">Detail</a></li>
                  <li role="presentation"><a href="<?=base_url('panel/campaign/agents/'.$data->campaign_id);?>">Agents</a></li>
                  <li role="presentation"><a href="<?=base_url('panel/campaign/assignment/'.$data->campaign_id);?>">Assignment</a></li>
                  <li role="presentation"><a href="<?=base_url('panel/campaign/report/'.$data->campaign_id);?>">Report</a></li>
                  <li role="presentation"><a href="<?=base_url('panel/campaign/wallboard/'.$data->campaign_id);?>">Wallboard</a></li>
                </ul>

                <div class="box" style="border:1px solid #ddd;border-top:none;border-top-left-radius:0;border-top-right-radius:0;">
                    <!--start filter!-->
                    <?php
                    $for_date = explode(' - ',$data->date_range);
                    $for_hour = explode(' - ',$data->schedule_per_day);
                    ?>
                        <div class="box-header with-border">
                            <div class=" col-md-6">
                                <label class="col-md-12" style="padding:0"><small>From</small></label>
                                <input type="text" id="from_date" class="sdate form-control col-md-6 input-sm" style="display:inline;width:180px;" value="<?php /*echo date("Y-m-d", strtotime("-5 day"));*/echo date('Y-m-d',strtotime($for_date[0])); ?>">

                                <label class="col-md-12" style="padding:0"><small>From</small></label>
                                <input type="text" id="from_time" class="time form-control col-md-6 input-sm" style="display:inline;width:180px;" value="00:00:00" data-mask>
                            </div>

                            <div class=" col-md-6">
                                <label class="col-md-12" style="padding:0"><small>To</small></label>
                                <input type="text" id="to_date" class="sdate form-control col-md-6 input-sm" style="display:inline;width:180px;" value="<?php echo date('Y-m-d',strtotime($for_date[1])); ?>">

                                <label class="col-md-12" style="padding:0"><small>To</small></label>
                                <input type="text" id="to_time" class="time form-control col-md-6 input-sm" style="display:inline;width:180px;" value="23:59:59" data-mask>
                            </div>

                            <div class=" col-md-12" style="margin-top: 5px; margin-bottom: 5px;">
                                <button class="col-md-2 btn btn-sm btn-default btn-flat col-md-offset-3" id = "re-fresh"><i class="fa fa-gear"></i> Refresh Call Per-Day</button>
                            </div>
                        </div>
                    <!--end filter!-->

                        <div class="box-body">
                            <div class = "row">
                                <div class = "col-md-8">
                                    <p class="text-center">
                                        <strong><?=date('j F Y')?></strong>
                                    </p>

                                     <div class="chart">
                                        <!-- Sales Chart Canvas -->
                                        <canvas data-id = "<?php echo $data->campaign_id; ?>" id="callChart" style="height: 180px;"></canvas>
                                    </div>
                                </div>

                                <div class = "col-md-4" id="answer-st" data-id = "<?php echo $data->campaign_id; ?>">
                                    <p class="text-center">
                                        <strong>Call Status</strong>
                                    </p>

                                    <div class="progress-group">
                                        <span class="progress-text">Contacted</span>
                                        <span class="progress-number">
                                            <b><span id = "status-contacted"><?=$call_status->contacted?></span>/ <?php echo $call_status->total; ?>
                                        </span>

                                        <div class="progress sm">
                                            <div id = "status-contacted-width" class="progress-bar progress-bar-green" style="width:<?=($call_status->total>0?($call_status->contacted/$call_status->total*100):0)?>%;"></div>
                                        </div>
                                    </div>

                                    <div class="progress-group" id="busy-st">
                                        <span class="progress-text">Not Answer</span>
                                        <span class="progress-number">
                                            <b><span id = "no-answer"><?=$call_status->no_answer?></span></b>/ <?php echo $call_status->total; ?>
                                        </span>
                                        <div class="progress sm">
                                            <div id = "no-answer-width" class="progress-bar progress-bar-aqua" style="width:<?=($call_status->total>0?($call_status->no_answer/$call_status->total*100):0)?>%;"></div>
                                        </div>
                                    </div>

                                    <div class="progress-group" id="cancel-st">
                                        <span class="progress-text">Not Active</span>
                                        <span class="progress-number">
                                        <b>
                                            <span id = "no-active"><?=$call_status->no_active?></span></b>/
                                            <?php echo $call_status->total; ?>
                                        </span>
                                        <div class="progress sm">
                                            <div id = "no-active-width" class="progress-bar progress-bar-yellow" style="width:<?=($call_status->total>0?($call_status->no_active/$call_status->total*100):0)?>%;"></div>
                                        </div>
                                    </div>

                                    <div class="progress-group" id="chan-st">
                                        <span class="progress-text">Reject</span>
                                        <span class="progress-number">
                                        <b>
                                            <span id = "reject"><?=$call_status->reject?></span></b>/
                                            <?php echo $call_status->total; ?>
                                        </span>

                                        <div class="progress sm">
                                            <div id = "reject-width" class="progress-bar progress-bar-red" style="width:<?=($call_status->total>0?($call_status->reject/$call_status->total*100):0)?>%;"></div>
                                        </div>
                                    </div>

                                    <div class="progress-group" id="chan-st">
                                        <span class="progress-text">Busy</span>
                                        <span class="progress-number">
                                        <b>
                                            <span id = "busy"><?=$call_status->busy?></span></b>/
                                            <?php echo $call_status->total; ?>
                                        </span>

                                        <div class="progress sm">
                                            <div id = "busy-width" class="progress-bar progress-bar-grey" style="width:<?=($call_status->total>0?($call_status->busy/$call_status->total*100):0)?>%;"></div>
                                        </div>
                                    </div>

                                    <div class="progress-group" id="chan-st">
                                        <span class="progress-text">Wrong Number</span>
                                        <span class="progress-number">
                                        <b>
                                            <span id = "wrong_numb"><?=$call_status->wrong_numb?></span></b>/
                                            <?php echo $call_status->total; ?>
                                        </span>

                                        <div class="progress sm">
                                            <div id = "wrong_numb-width" class="progress-bar progress-bar-grey" style="width:<?=($call_status->total>0?($call_status->wrong_numb/$call_status->total*100):0)?>%;background-color:#ccc;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--div class = "row">
                                <div class = "col-md-3">
                                    <p class="text-center">
                                        <strong>Merchant Status</strong>
                                    </p>

                                    <div class = "col-md-12">
                                        <canvas data-id="<?php echo $data->campaign_id; ?>" id="merchant_status_Chart" style="height: 180px;"></canvas>
                                    </div>
                                </div>

                                <div class = "col-md-3">
                                    <ul id = "legend_target" class = "chart-legend clearfix">
                                        <!--<li><i class="fa fa-circle-o" style="color:#4ca423"></i> JAKARTA</li>
                                        <li><i class="fa fa-circle-o" style="color:#1e728d"></i> SURABAYA</li>
                                        <li><i class="fa fa-circle-o" style="color:#bc87e4"></i> BANDUNG</li>!-->
                                    <!--/ul>
                                </div>

                                <!--div class = "col-md-5">
                                    <p class="text-center">
                                        <strong>Merchant Status</strong>
                                    </p>

                                    <div class = "col-md-7">
                                        <canvas data-id = "<?php echo $data->campaign_id; ?>" id="merchant_status_Chart" style="height: 180px;"></canvas>
                                    </div>
                                    <div class="col-md-5">
                                        <ul style="list-style:none;padding-left:0;">
                                            <li id="ls-intrest"><i class="fa fa-pie-chart"></i> Interest <span class="pull-right">140</span></li>
                                            <li id="ls-nointrest"><i class="fa fa-pie-chart"></i> Not Interest <span class="pull-right">150</span></li>
                                            <li id="ls-call-back"><i class="fa fa-pie-chart"></i> Call Back <span class="pull-right">251</span></li>
                                        </ul>
                                    </div>
                                </div-->
                            <!--/div-->

                        </div>
                </div>
            </div>
        </div>
    </section>
</div>

<link rel="stylesheet" href="<?=base_url('assets')?>/plugins/datepicker/datepicker3.css">
<script src="<?=base_url('assets')?>/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?=base_url('assets')?>/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?=base_url('assets')?>/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo base_url('assets/plugins/chartjs/campaign_status_data.js'); ?>"></script>
<script src="<?php echo base_url(); ?>assets/plugins/chartjs/Chart.min.js"></script>
<script src="<?php echo base_url('assets/plugins/chartjs/call_perday.js'); ?>"></script>
<!--<script src="<//?php echo base_url('assets/plugins/chartjs/campaign_status_data.js'); ?>"></script>
<script src="<//?php echo base_url('assets/plugins/chartjs/campaign_status_call.js'); ?>"></script>!-->
<script>
$("[data-mask]").inputmask("hh:mm:ss", {"placeholder": "--:--:--"});

$('.sdate').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
  }).on('hide', function(e) {
        /*var date = new Date($(this).val());
        date.setDate(date.getDate() + 30);
        $('.edate').datepicker('setStartDate',new Date($(this).val()));
        $('.edate').datepicker('setEndDate',date); */
  });

  var date = new Date($('.sdate').val());
  date.setDate(date.getDate() + 30);
  $('.edate').datepicker({
    //startDate:new Date($('.sdate').val()),
    //endDate: date,
    format: 'yyyy-mm-dd',
    autoclose: true
  });
</script>
