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

.inline-block{
    display: inline-block;
    width: 100%;
}

.icon{
    font-size: 3.5rem;
}

.float-right{
    float: right;
}

.text{
    font-size: 1.6rem;
}

.for-card{
    margin-top: 20px;
    margin-bottom: 20px;
}

.total-call{
    background-color: #17a2b8;
    color: white;
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
                  <?php if($rules['e']||$rules['c']):?>
                  <li role="presentation"><a href="<?=base_url('panel/campaign/agents/'.$data->campaign_id);?>">Agents</a></li>
                  <li role="presentation"><a href="<?=base_url('panel/campaign/assignment/'.$data->campaign_id);?>">Assignment</a></li>
                  <?php endif;?>
                  <li role="presentation"><a href="<?=base_url('panel/campaign/report/'.$data->campaign_id);?>">Report</a></li>
                  <?php if($rules['e']||$rules['c']):?>
                  <li role="presentation"><a href="<?=base_url('panel/campaign/wallboard/'.$data->campaign_id);?>">Wallboard</a></li>
                  <?php endif;?>
              </ul>

              <div class="box" style="border:1px solid #ddd;border-top:none;border-top-left-radius:0;border-top-right-radius:0;">
                <!--start filter!-->
                <?php
                $for_date = explode(' - ',$data->date_range);
                $for_hour = explode(' - ',$data->schedule_per_day);
                ?>
                        <!--div class="box-header with-border">
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
                        </div-->
                        <!--end filter!-->

                        <div class="box-body">
                            <div class = "row">
                                <div class="col-sm-3">
                                    <div class="inline-block total-call">
                                        <div class="col-sm-3 for-card">
                                            <i class="fa fa-address-book float-left icon"></i>
                                        </div>

                                        <div class="col-sm-9">
                                            <div class="float-right text">
                                                <p class="">Total Data</p>
                                                <p class="" id="total_data">0</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="inline-block total-call" style="background-color: #729d39;">
                                        <div class="col-sm-3 for-card">
                                            <i class="fa fa-percent float-left icon"></i>
                                        </div>

                                        <div class="col-sm-9">
                                            <div class="float-right text">
                                                <p class="">Data touch</p>
                                                <p class="" id="precentage">0</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="inline-block total-call" style="background-color: #ffc107;">
                                        <div class="col-sm-3 for-card">
                                            <i class="fa fa-clock-o float-left icon"></i>
                                        </div>

                                        <div class="col-sm-9">
                                            <div class="float-right text">
                                                <p class="">ATT</p>
                                                <p class="" id="aht">0</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="inline-block total-call" style="background-color: #e4734f;">
                                        <div class="col-sm-3 for-card">
                                            <i class="fa fa-phone float-left icon"></i>
                                        </div>

                                        <!-- <div class="col-sm-9">
                                            <div class="float-right text">
                                                <p class="">Remaining Call</p>
                                                <p class="" id="total_remain">0</p>
                                            </div>
                                        </div> -->
                                        <div class="col-sm-9">
                                            <div class="float-right text">
                                                <p class="">Closing Number</p>
                                                <p class="" id="closing_number">0</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class = "col-md-8">
                                    <p class="text-center">
                                        <strong><?=date('j F Y')?></strong>
                                    </p>

                                    <div class="chart">
                                        <!-- Sales Chart Canvas -->
                                        <canvas data-id = "<?php echo $data->campaign_id; ?>" id="callChart" style="height: 260px;"></canvas>
                                    </div>
                                </div>

                                <div class = "col-md-4" id="answer-st" data-id = "<?php echo $data->campaign_id; ?>">
                                    <p class="text-center">
                                        <strong>Call Status</strong>
                                    </p>

                                    <div class="progress-group">
                                        <span class="progress-text">Contacted</span>
                                        <span class="progress-number">
                                            <b><span id = "contacted"><?=$call_status->contacted?>/ <?php echo $call_status->total; ?></span></b>
                                        </span>

                                        <div class="progress sm">
                                            <div id = "contacted-width" class="progress-bar progress-bar-green" style="width:<?=($call_status->total>0?($call_status->contacted/$call_status->total*100):0)?>%;"></div>
                                        </div>
                                    </div>

                                    <div class="progress-group" id="busy-st">
                                        <span class="progress-text">Not Answer</span>
                                        <span class="progress-number">
                                            <b><span id = "not_answer"><?=$call_status->no_answer?>/ <?php echo $call_status->total; ?></span></b>
                                        </span>
                                        <div class="progress sm">
                                            <div id = "not_answer-width" class="progress-bar progress-bar-aqua" style="width:<?=($call_status->total>0?($call_status->no_answer/$call_status->total*100):0)?>%;"></div>
                                        </div>
                                    </div>

                                    <div class="progress-group" id="cancel-st">
                                        <span class="progress-text">Not Active</span>
                                        <span class="progress-number">
                                            <b>
                                                <span id = "not_active"><?=$call_status->no_active?>/
                                                <?php echo $call_status->total; ?></span></b>
                                            </span>
                                            <div class="progress sm">
                                                <div id = "not_active-width" class="progress-bar progress-bar-yellow" style="width:<?=($call_status->total>0?($call_status->no_active/$call_status->total*100):0)?>%;"></div>
                                            </div>
                                        </div>

                                        <div class="progress-group" id="chan-st">
                                            <span class="progress-text">Reject</span>
                                            <span class="progress-number">
                                                <b>
                                                    <span id = "reject"><?=$call_status->reject?>/
                                                    <?php echo $call_status->total; ?></span></b>
                                                </span>

                                                <div class="progress sm">
                                                    <div id = "reject-width" class="progress-bar progress-bar-red" style="width:<?=($call_status->total>0?($call_status->reject/$call_status->total*100):0)?>%;"></div>
                                                </div>
                                            </div>

                                            <div class="progress-group" id="chan-st">
                                                <span class="progress-text">Busy</span>
                                                <span class="progress-number">
                                                    <b>
                                                        <span id = "busy"><?=$call_status->busy?>/
                                                        <?php echo $call_status->total; ?></span></b>
                                                    </span>

                                                    <div class="progress sm">
                                                        <div id = "busy-width" class="progress-bar progress-bar-grey" style="width:<?=($call_status->total>0?($call_status->busy/$call_status->total*100):0)?>%;"></div>
                                                    </div>
                                                </div>

                                                <div class="progress-group" id="chan-st">
                                                    <span class="progress-text">Wrong Number</span>
                                                    <span class="progress-number">
                                                        <b>
                                                            <span id = "wrong_numb"><?=$call_status->wrong_numb?>/
                                                            <?php echo $call_status->total; ?></span></b>
                                                        </span>

                                                        <div class="progress sm">
                                                            <div id = "wrong_numb-width" class="progress-bar progress-bar-grey" style="width:<?=($call_status->total>0?($call_status->wrong_numb/$call_status->total*100):0)?>%;background-color:#ccc;"></div>
                                                        </div>
                                                    </div>

                                                <div class="progress-group" id="chan-st">
                                                    <span class="progress-text">Callback</span>
                                                    <span class="progress-number">
                                                        <b>
                                                            <span id = "callback"></span></b>
                                                        </span>

                                                        <div class="progress sm">
                                                            <div id = "callback-width" class="progress-bar progress-bar-grey" style="width:0%;background-color:#996633;"></div>
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
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class = "col-md-4">
                                        <p class="text-center">
                                            <strong>Top 5 Best Agent</strong>
                                        </p>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped table-bordered" id="tbl_best">
                                                <thead>
                                                    <tr>
                                                        <th>Rank</th>
                                                        <th>Agent Name</th>
                                                       <!--  <th>Total Call Complete</th> -->
                                                        <th>Total Contacted</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class = "col-md-4">
                                        <p class="text-center">
                                            <strong>Top 5 Worst Agent</strong>
                                        </p>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped table-bordered" id="tbl_worst">
                                                <thead>
                                                    <tr>
                                                        <th>Rank</th>
                                                        <th>Agent Name</th>
                                                        <!-- <th>Total Call Complete</th> -->
                                                        <th>Total Contacted</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class = "col-md-4">
                                        <p class="text-center">
                                            <strong>Top 5 Success Agent</strong>
                                        </p>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped table-bordered" id="tbl_success_agent">
                                                <thead>
                                                    <tr>
                                                        <th>Rank</th>
                                                        <th>Agent Name</th>
                                                        <th>Total Success</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
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
        <script src="<?php echo base_url(); ?>assets/plugins/chartjs/Chart.2.7.3.min.js"></script>
        <script src="<?php echo base_url('assets/plugins/chartjs/line_chart.js'); ?>"></script>
<!--<script src="<//?php echo base_url('assets/plugins/chartjs/campaign_status_data.js'); ?>"></script>
    <script src="<//?php echo base_url('assets/plugins/chartjs/campaign_status_call.js'); ?>"></script>!-->
    <script>
        function data_best(data){
            var html = '';
            $.each(data, function(i,v){
                html += '<tr>';
                html += '<td>'+v.rank+'</td>';
                html += '<td>'+v.adm_name+'</td>';
                /*html += '<td>'+v.total_completed+'</td>';*/
                html += '<td>'+v.total_contacted+'</td>';
                html += '</tr>';
            });
            $('#tbl_best tbody').html(html);
        }
        function data_worst(data){
            var html = '';
            $.each(data, function(i,v){
                html += '<tr>';
                html += '<td>'+v.rank+'</td>';
                html += '<td>'+v.adm_name+'</td>';
                /*html += '<td>'+v.total_completed+'</td>';*/
                html += '<td>'+v.total_contacted+'</td>';
                html += '</tr>';
            })
            $('#tbl_worst tbody').html(html);
        }

		function data_success_closing(data){
            var html = '';
            var counter	=	1;
            for (var i = 0; i < data.length; i++) {
            	html += '<tr>';
                html += '<td>'+counter+'</td>';
                html += '<td>'+data[i].adm_name+'</td>';
                html += '<td>'+data[i].result_status_number+'</td>';
                html += '</tr>';
                counter = counter + 1;
            }
            $('#tbl_success_agent tbody').html(html);
            /*$.each(data, function(i,v){
                html += '<tr>';
                html += '<td>'+v.rank+'</td>';
                html += '<td>'+v.adm_name+'</td>';
                html += '<td>'+v.total_contacted+'</td>';
                html += '</tr>';
            })
            $('#tbl_worst tbody').html(html);*/
        }

        function call_status(data,total){
            var html = '';
            $.each(data, function(i,v){
                $('#'+i).html(v+'/'+total);
                $('#'+i+'-width').css('width',((parseInt(v)/parseInt(total))*100));
            })
            
        }

        $(document).ready(function(){

            if (!!window.EventSource) {
                var url_    =   "<?php echo base_url('panel/campaign/board_widget/'); ?>";
                var id      =   "<?php echo $id; ?>";
                var source  = new EventSource(url_+id);
                source.addEventListener('message', function(event) {
            /*console.log(event.data);*/
            var data = JSON.parse(event.data);
            $('#total_data').text(data.total_data);
            $('#precentage').text(data.success_percentage);
            $('#closing_number').text(data.closing_number);
            $('#aht').text(data.aht);
            set_line_data(data.line_chart);
            data_best(data.best_agent);
            data_worst(data.worst_agent);
            call_status(data.call_status,data.call_status_total);
            data_success_closing(data.success_selling);
        });
            }
        })

//$("[data-mask]").inputmask("hh:mm:ss", {"placeholder": "--:--:--"});

//$('.sdate').datepicker({
//      format: 'yyyy-mm-dd',
//      autoclose: true
//  }).on('hide', function(e) {
        /*var date = new Date($(this).val());
        date.setDate(date.getDate() + 30);
        $('.edate').datepicker('setStartDate',new Date($(this).val()));
        $('.edate').datepicker('setEndDate',date); */
//  });

//  var date = new Date($('.sdate').val());
//  date.setDate(date.getDate() + 30);
//  $('.edate').datepicker({
    //startDate:new Date($('.sdate').val()),
    //endDate: date,
//    format: 'yyyy-mm-dd',
//    autoclose: true
//  });
</script>
