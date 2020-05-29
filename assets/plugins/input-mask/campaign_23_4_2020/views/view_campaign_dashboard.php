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
            <div class="col-xs-12 col-content">
                <ul class="nav nav-tabs">
                  <li role="presentation" class="active"><a href="#">Dashboard</a></li>
                  <li role="presentation"><a href="<?=base_url('panel/campaign/detail/'.$data->campaign_id);?>">Detail</a></li>
                  <?php if($rules['e']||$rules['c']):?>
                  <li role="presentation"><a href="<?=base_url('panel/campaign/agents/'.$data->campaign_id);?>">Agents</a></li>
                  <li role="presentation"><a href="<?=base_url('panel/campaign/assignment/'.$data->campaign_id);?>">Assignment</a></li>
                  <li role="presentation"><a href="<?=base_url('panel/campaign/target/'.$data->campaign_id);?>">Target Tools</a></li>
                  <?php endif;?>
                          
                  <?php if($data->outbound_type=='predictive'):?>                    
                  <li role="presentation"><a href="<?=base_url('panel/campaign/remaining_data/'.$data->campaign_id);?>">Remaining Data</a></li>          
                  <?php endif;?>
                  <li role="presentation"><a href="<?=base_url('panel/campaign/report/'.$data->campaign_id);?>">Report</a></li>
                  
              </ul>

              <div class="wrap-wallboard" id="wrap-wallboard">
                <div class="box" style="border:1px solid #ddd;border-top:none;border-top-left-radius:0;border-top-right-radius:0;">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12" style="margin-bottom: 10px">
                                <div class="action pull-right">
                                    <a href="#" id="fullscreen" title="Fullscreen"><i class="fa fa-arrows-alt"></i></a>
                                    <a href="#" id="expand" title="Expand"><i class="fa fa-expand"></i></a>
                                    <a href="#" id="close-fullscreen" class="close-wb" style="display: none"><i class="fa fa-compress"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class = "row">
                            <div class="col-sm-3">
                                <div class="inline-block total-call bg-yellow">
                                    <div class="col-sm-3 for-card">
                                        <i class="fa fa-handshake-o float-left icon"></i>
                                    </div>

                                    <div class="col-sm-9">
                                        <div class="text">
                                            <p class="text-bold">Total PTP</p>
                                            <p class="" id="total_ptp">0</p>
                                            <p class="" id="total_ptp_amount">Rp 0</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="inline-block total-call bg-red">
                                    <div class="col-sm-3 for-card">
                                        <span class="fa-stack float-left icon" style="font-size: 2.2rem">
                                          <i class="fa fa-handshake-o fa-stack-1x"></i>
                                          <i class="fa fa-ban fa-stack-2x text-danger"></i>
                                        </span>
                                    </div>

                                    <div class="col-sm-9 pl-0">
                                        <div class="text">
                                            <p class="text-bold">Total Broken Promise</p>
                                            <p class="" id="total_bp">0</p>
                                            <p class="" id="total_bp_amount">Rp 0</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="inline-block total-call bg-blue">
                                    <div class="col-sm-3 for-card">
                                        <i class="fa fa-thumbs-o-up float-left icon"></i>
                                    </div>

                                    <div class="col-sm-9 pl-0">
                                        <div class="text">
                                            <p class="text-bold">Total Paid</p>
                                            <p class="" id="total_paid">0</p>
                                            <p class="" id="total_paid_amount">Rp 0</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="inline-block total-call bg-green">
                                    <div class="col-sm-3 for-card">
                                        <i class="fa fa-thumbs-up float-left icon"></i>
                                    </div>

                                    <div class="col-sm-9 pl-0">
                                        <div class="text">
                                            <p class="text-bold">Total Paid Off</p>
                                            <p class="" id="total_paidoff">0</p>
                                            <p class="" id="total_paidoff_amount">Rp 0</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--div class = "col-md-8">
                                <p class="text-center">
                                    <strong><?=date('j F Y')?></strong>
                                </p>

                                <div class="chart">
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
                                        <b><span id = "contacted"><?=$call_status->contact?>/ <?php echo $call_status->total; ?></span></b>
                                    </span>

                                    <div class="progress sm">
                                        <div id = "contacted-width" class="progress-bar progress-bar-green" style="width:<?=($call_status->total>0?($call_status->contact/$call_status->total*100):0)?>%;"></div>
                                    </div>
                                </div>

                                <div class="progress-group" id="busy-st">
                                    <span class="progress-text">UnContact</span>
                                    <span class="progress-number">
                                        <b><span id = "not_answer"><?=$call_status->UnContact?>/ <?php echo $call_status->total; ?></span></b>
                                    </span>
                                    <div class="progress sm">
                                        <div id = "not_answer-width" class="progress-bar progress-bar-aqua" style="width:<?=($call_status->total>0?($call_status->UnContact/$call_status->total*100):0)?>%;"></div>
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
                                        <span id = "busy"><?=$call_status->busy?>/<?php echo $call_status->total; ?></span></b>
                                    </span>

                                    <div class="progress sm">
                                        <div id = "busy-width" class="progress-bar progress-bar-grey" style="width:<?=($call_status->total>0?($call_status->busy/$call_status->total*100):0)?>%;"></div>
                                    </div>
                                </div>

                                <div class="progress-group" id="chan-st">
                                    <span class="progress-text">Wrong Number</span>
                                    <span class="progress-number">
                                        <b>
                                            <span id = "wrong_numb"><?=$call_status->wrong_numb?>/<?php echo $call_status->total; ?></span>
                                        </b>
                                    </span>

                                    <div class="progress sm">
                                        <div id = "wrong_numb-width" class="progress-bar progress-bar-grey" style="width:<?=($call_status->total>0?($call_status->wrong_numb/$call_status->total*100):0)?>%;background-color:#ccc;"></div>
                                    </div>
                                </div>

                                <div class="progress-group" id="chan-st">
                                    <span class="progress-text">Call Back</span>
                                    <span class="progress-number">
                                        <b><span id = "callback"></span></b>
                                    </span>

                                    <div class="progress sm">
                                        <div id = "callback-width" class="progress-bar progress-bar-grey" style="width:0%;background-color:#996633;"></div>
                                    </div>
                                </div>
                            </div-->
                        </div>
                        <div class="row">
                            <div class = "col-md-12">
                                <p class="text-left">
                                    <!--strong>Agent Wallboard</strong-->
                                </p>
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-bordered" id="tbl_agent_wb">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="text-center" style="width: 50px;">No</th>
                                                <th rowspan="2" class="text-center">Agent Name</th>
                                                <th rowspan="2" class="text-center">OS Balance</th>
                                                <th rowspan="2" class="text-center" style="width: 115px;">Total Account</th>
                                                <th colspan="2" class="text-center">Total Payment</th>
                                                <th rowspan="2" class="text-center" style="width: 105px;">% of Target</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center">Paid</th>
                                                <th class="text-center">Paid Off</th>
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
        <script src="<?php echo base_url(); ?>assets/plugins/chartjs/Chart.2.7.3.min.js"></script>
        <!--script src="<?php echo base_url('assets/plugins/chartjs/line_chart.js'); ?>"></script-->
<!--<script src="<//?php echo base_url('assets/plugins/chartjs/campaign_status_data.js'); ?>"></script>
    <script src="<//?php echo base_url('assets/plugins/chartjs/campaign_status_call.js'); ?>"></script>!-->
    <script>
        function data_agent(data){
            var html = '';
            var no = 1;
            if(data.length > 0){
                $.each(data, function(i,v){
                    html += '<tr>';
                    html += '<td class="text-center">'+(no)+'</td>';
                    html += '<td>'+v.adm_name+'</td>';
                    html += '<td class="text-right">Rp '+v.os_balance+'</td>';
                    html += '<td class="text-center">'+v.total_account+'</td>';
                    html += '<td class="text-right">Rp '+v.total_paid+'</td>';
                    html += '<td class="text-right">Rp '+v.total_paidoff+'</td>';
                    html += '<td class="text-right">'+v.percentage+'%</td>';
                    html += '</tr>';
                    no++;
                });
            } else {
                html += '<tr><td class="text-center" colspan="7">There\'s no agent assigned to this campaign</td></tr>';
            }
            $('#tbl_agent_wb tbody').html(html);
        }

        $(document).ready(function(){

            $('#expand').click(function(e){
                e.preventDefault();
                $('body').toggleClass('expand');
                $(this).find('.fa').toggleClass('fa-expand');
                $(this).find('.fa').toggleClass('fa-compress');
            })
            $('#fullscreen').click(function(e){
                e.preventDefault();
                $('body').removeClass('expand');
                //$('body').addClass('fullscreen');
                $('#expand').find('.fa').addClass('fa-expand');
                $('#expand').find('.fa').removeClass('fa-compress');
                $('#fullscreen').hide();
                $('#expand').hide();
                $('#close-fullscreen').show();
                var elem = document.getElementById("wrap-wallboard");
                if (elem.requestFullscreen) {
                    elem.requestFullscreen();
                } else if (elem.mozRequestFullScreen) { /* Firefox */
                    elem.mozRequestFullScreen();
                } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
                    elem.webkitRequestFullscreen();
                } else if (elem.msRequestFullscreen) { /* IE/Edge */
                    elem.msRequestFullscreen();
                }
            })
            $('#close-fullscreen').click(function(e){
                e.preventDefault();
                //$('body').removeClass('fullscreen');
                $('#fullscreen').show();
                $('#expand').show();
                $('#close-fullscreen').hide();
                if (document.exitFullscreen) {
                document.exitFullscreen();
              } else if (document.mozCancelFullScreen) { /* Firefox */
                document.mozCancelFullScreen();
              } else if (document.webkitExitFullscreen) { /* Chrome, Safari and Opera */
                document.webkitExitFullscreen();
              } else if (document.msExitFullscreen) { /* IE/Edge */
                document.msExitFullscreen();
              }
            })
            document.getElementById("wrap-wallboard").onfullscreenchange = function ( event ) { 
              $('body').toggleClass('fullscreen');
            }; 

            if (!!window.EventSource) {
                var url_    =   "<?php echo base_url('panel/campaign/wallboard/widget/'.$id); ?>";
                var source  = new EventSource(url_);
                source.addEventListener('message', function(event) {
                    /*console.log(event.data);*/
                    var data = JSON.parse(event.data);
                    $.each(data, function(key, val){
                        $('#'+key).text(val)
                    });
                });

                var urlAgent    =   "<?php echo base_url('panel/campaign/wallboard/agent_wb/'.$id); ?>";
                var source  = new EventSource(urlAgent);
                source.addEventListener('message', function(event) {
                    /*console.log(event.data);*/
                    var data = JSON.parse(event.data);
                    data_agent(data.data_agent);
                });
            }
        })

</script>
<style type="text/css">
    #tbl_agent_wb.table>thead>tr>th {
        padding: 4px;
        vertical-align: middle !important;
    }
    .pl-0{
        padding-left: 0 !important;
    }
    body.expand{
        position: relative;
        width: 100%;
        height: 100%;
    }
    body.expand .col-content{
        position: unset;
    }
    body.expand .wrap-wallboard{
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 9999;
        max-height: 100vh;
        height: 100vh;
        width: 100vw;
        overflow-y: auto;
    }
    body.fullscreen .wrap-wallboard{
        max-height: 100vh;
        height: 100vh;
        width: 100vw;
        overflow-y: auto;
    }
    body.expand .wrap-wallboard .box, body.fullscreen .wrap-wallboard .box{
        height: 100%;
    }
</style>
