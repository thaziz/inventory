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
                  <li role="presentation"><a href="<?=base_url('panel/campaign/wallboard/'.$data->campaign_id);?>">Wallboard</a></li>
                  <li role="presentation"><a href="<?=base_url('panel/campaign/detail/'.$data->campaign_id);?>">Detail</a></li>
                  <?php if($rules['e']||$rules['c']):?>
                  <li role="presentation"><a href="<?=base_url('panel/campaign/agents/'.$data->campaign_id);?>">Agents</a></li>
                  <li role="presentation"><a href="<?=base_url('panel/campaign/assignment/'.$data->campaign_id);?>">Assignment</a></li>
                  <li role="presentation"><a href="<?=base_url('panel/campaign/target/'.$data->campaign_id);?>">Target Tools</a></li>
                  <?php endif;?>
                  <li role="presentation"><a href="<?=base_url('panel/campaign/report/'.$data->campaign_id);?>">Report</a></li>
                  
              </ul>

              <div class="wrap-wallboard" id="wrap-wallboard">
                <div class="box" style="border:1px solid #ddd;border-top:none;border-top-left-radius:0;border-top-right-radius:0;">
                    <div class="box-body">
                        

                        <div class="row">
                            <div class = "col-md-6">
                                <p class="text-left">
                                    <strong>Productivity Call</strong>
                                    <!-- <button class="btn btn-primary btn-xs">Export</button> -->
                                </p>
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-bordered" id="tbl_agent_wb">
                                        <thead>
                                            <tr>
                                                <th  style="width: 50px;">No</th>
                                                <th >Agent Name</th>
                                                <th >Outgoing Call</th>
                                                <th  style="width: 115px;">Duration</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class = "col-md-6">
                                <p class="text-left">
                                    <strong>Performance Daily</strong>
                                </p>
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-bordered" id="data_perform_daily">
                                        <thead>
                                            <tr>
                                                <th >Agent Name</th>
                                                <th >Performace by Acoount</th>
                                                <th >Performace by Amount   </th>
                                                <th  style="width: 115px;">Ranking by Amount</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <div class = "col-md-6">
                                <p class="text-left">
                                    <strong>Performance Agent</strong>
                                </p>
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-bordered" id="data_perform">
                                        <thead>
                                            <tr>
                                                <th >Agent Name</th>
                                                <th >Performace by Acoount</th>
                                                <th >Performace by Amount   </th>
                                                <th  style="width: 115px;">Ranking by Amount</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class = "col-md-12">
                                <p class="text-left">
                                    <strong>Coding Team Leader</strong>
                                </p>
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-bordered" id="">
                                        <thead class="ct_header">
                                           
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-left">
                                    <strong>Coding Agent</strong>
                                </p>
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-bordered" id="">
                                        <thead>
                                            <td> Status Call</td>
                                            <td> Account</td>
                                            <td> Os</td>

                                        </thead>
                                        <tbody class="coding_agent"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class = "col-md-12">
                                <p class="text-left">
                                    <strong>Achievement by OS Clasification</strong>
                                </p>
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-bordered" id="achievement_by_os">
                                        <thead>
                                            <tr>
                                                <td rowspan="2" scope="colgroup" >Agent Name</td>
                                                <th colspan="2" scope="colgroup"> < 10.000.000</th>
                                                <th colspan="2" scope="colgroup"> 10.000.000 - 50.000.000</th>
                                                <th colspan="2" scope="colgroup"> > 50.000.000</th>
                                                <th colspan="2" scope="colgroup">Total achievement</th>
                                                <td rowspan="2" scope="colgroup"> Target</td>
                                                <td rowspan="2" scope="colgroup"> +/-Target</td>
                                            </tr>
                                            <tr>
                                                <th scope="col" >Account</th>
                                                <th scope="col" >Amount   </th>                                                
                                                <th scope="col">Acoount</th>
                                                <th scope="col">Amount   </th>                                                
                                                <th scope="col">Acoount</th>
                                                <th scope="col">Amount   </th>                                                
                                                <th scope="col">Acoount</th>
                                                <th scope="col">Amount   </th>                                                
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class = "col-md-6">
                                <p class="text-left">
                                    <strong>Call Status by Os Balance</strong>
                                </p>
                                <canvas id="piebalance" width="800" height="450"></canvas>
                            </div>
                            <div class = "col-md-6">
                                <p class="text-left">
                                    <strong>Call Status by Acount</strong>
                                </p>
                                <canvas id="pieacoount" width="800" height="450"></canvas>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class = "col-md-10">
                                <p class="text-center">
                                    <strong>Call Durasi</strong>
                                </p>
                                <canvas id="durasiChartcanvas"  width="800" height="450"></canvas>
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
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
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
                    html += '<td>'+(no)+'</td>';
                    html += '<td>'+v.agent+'</td>';
                    html += '<td >'+v.total+'</td>';
                    html += '<td class="text-right">'+v.duration+'</td>';
                    html += '</tr>';
                    no++;
                });
            } else {
                html += '<tr><td colspan="4">No data found</td></tr>';
            }
            $('#tbl_agent_wb tbody').html(html);
        }

        $(document).ready(function(){
            if (!!window.EventSource) {
                var urlAgent    =   "<?php echo base_url('panel/campaign/productivity_call/'.$id); ?>";
                var source  = new EventSource(urlAgent);
                source.addEventListener('message', function(event) {
                  var data = JSON.parse(event.data);
                  data_agent(data.data);
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
<script>
    function perform_daily(data) {
        var html = '';
        if(data.length > 0){
            $.each(data, function(i, v) {
                html += '<tr>';
                html += '<td>' + v.name + '</td>';
                html += '<td>' + v.accound + '</td>';
                html += '<td>' + v.amount + '</td>';
                html += '<td>' + v.rank +  '</td>';
                html += '</tr>';
                
            })
        } else {
            html += '<tr><td colspan="4">There\'s no agent assigned to this campaign</td></tr>';
        }
        $('#data_perform_daily tbody').html(html);
    }

    $(document).ready(function() {
        if (!!window.EventSource) {
            var url_ = "<?php echo base_url('panel/campaign/perform_daily/'); ?>";
            var id = "<?php echo $id; ?>";
            var source = new EventSource(url_ + id);
            source.addEventListener('message', function(event) {
                var data = JSON.parse(event.data);
                perform_daily(data.data);
            });

        }
    })
</script>

<script>
    function perform_all(data) {
        var html = '';
        if(data.length > 0){
            $.each(data, function(i, v) {
                html += '<tr>';
                html += '<td>' + v.name + '</td>';
                html += '<td>' + v.accound + '</td>';
                html += '<td>' + v.amount + '</td>';
                html += '<td>' + v.rank +  '</td>';
                html += '</tr>';
                
            })
        } else {
            html += '<tr><td colspan="4">There\'s no agent assigned to this campaign</td></tr>';
        }
        $('#data_perform tbody').html(html);
    }

    $(document).ready(function() {
        if (!!window.EventSource) {
            var url_ = "<?php echo base_url('panel/campaign/perform_all/'); ?>";
            var id = "<?php echo $id; ?>";
            var source = new EventSource(url_ + id);
            source.addEventListener('message', function(event) {
                var data = JSON.parse(event.data);
                perform_all(data.data);
            });

        }
    })
</script>
<script>
    function achievement_by_os(data) {
        var html = '';
        $.each(data, function(i, v) {
            html += '<tr>';
            html += '<td>' + v.name + '</td>';
            html += '<td>' + v.account1 + '</td>';
            html += '<td>' + v.amount1 + '</td>';
            html += '<td>' + v.account2 + '</td>';
            html += '<td>' + v.amount2 + '</td>';
            html += '<td>' + v.account3 + '</td>';
            html += '<td>' + v.amount3 + '</td>';
            html += '<td>' + v.account4 + '</td>';
            html += '<td>' + v.amount4 + '</td>';
            html += '<td>' + v.target + '</td>';
            if(v.target < v.xtarget){
                html += '<td style="color:green">' + "Lebih" + '</td>';
            } else {
                html += '<td style="color:red">' + "kurang" + '</td>';
            }
            html += '</tr>';

            
        })
        $('#achievement_by_os tbody').html(html);
    }

    $(document).ready(function() {
        if (!!window.EventSource) {
            var url_ = "<?php echo base_url('panel/campaign/achievement_by_os/'); ?>";
            var id = "<?php echo $id; ?>";
            var source = new EventSource(url_ + id);
            source.addEventListener('message', function(event) {
                var data = JSON.parse(event.data);
                achievement_by_os(data.data);
            });

        }
    })
</script>

<script>
    function data_ctl(data) {
        var html = '';

        html+='<tr><th rowspan="2">Status</th>';
        $.each(data.agent, function(i, v) {
              html+='<th colspan="2" style="text-align:center">'+v.name+'</th>';
            
        })
        html+='<th rowspan="2">Total Account</th><th rowspan="2">Total OS</th>';
        html+='</tr>';
        $.each(data.agent, function(i, v) {
              html+='<th>Account</th>';
              html+='<th>OS</th>';
            
        })

        $.each(data.data, function(i, v) {

                  html+= '<tr>';
                  html+= '<td>'+i+'</td>';
                $.each(data.agent, function(ix, a) {
                    var c=a.name;

                html+='<td>'+v[c.toString().toLowerCase()]['a']+'</td>';                
                html+='<td>'+v[c.toString().toLowerCase()]['b']+'</td>';
                 /*echo '<td>'.(isset($val[strtolower($value->name)]['b'])?$val[strtolower($value->name)]['b']:'0').'</td>';*/

                })

                html+='<td>'+v['totala']+'</td>';
                html+='<td>'+v['totalb']+'</td>';
                html+= '</tr>';

                html+='</tr>';

        })

/*
        foreach ($d['data'] as $d['status'] =>$val) {
                echo '<td>'.$d['status'].'</td>';
                foreach ($d['agent']  as $key => $value) {
                echo '<td>'.(isset($val[strtolower($value->name)]['a'])?$val[strtolower($value->name)]['a']:'0').'</td>';
                 echo '<td>'.(isset($val[strtolower($value->name)]['b'])?$val[strtolower($value->name)]['b']:'0').'</td>';
              }
            
                echo '</tr>';
            }*/

        $('.ct_header').html(html);
    }

    $(document).ready(function() {
        if (!!window.EventSource) {
            var url_ = "<?php echo base_url('panel/campaign/coding_team_leader/'); ?>";
            var id = "<?php echo $id; ?>";
            var source = new EventSource(url_ + id);
            source.addEventListener('message', function(event) {
                var data = JSON.parse(event.data);
              
                data_ctl(data.data);
            });

        }
    })
</script>


<!-- //coding agent -->

<script>
    function coding_agent(data) {
        var html = '';

        $.each(data, function(i, v) {
console.log(v.status)
                html+= '<tr>';
                html+= '<td>'+v.status+'</td>';
                html+= '<td>'+v.total_account+'</td>';
                html+= '<td>'+v.os_balance+'</td>';
                html+= '</tr>';

                html+='</tr>';

        })

        $('.coding_agent').html(html);
    }

    $(document).ready(function() {
        if (!!window.EventSource) {
            var url_ = "<?php echo base_url('panel/campaign/coding_agent/'); ?>";
            var id = "<?php echo $id; ?>";
            var source = new EventSource(url_ + id);
            source.addEventListener('message', function(event) {
                var data = JSON.parse(event.data);

              
                coding_agent(data.data);
            });

        }
    })
</script>
<script type="text/javascript">
    var ctx = document.getElementById("piebalance").getContext("2d");
    var dataChart = {
        labels: [0],
        datasets: [{
            label: "Average",
            data: [0],
            backgroundColor: [0],
        }],
    };
    var piechart = new Chart(ctx, {
        type: 'pie',
        data: dataChart,
        options: {
            title: {
                display: true,
                text: 'Call Status by Os Balance'
            }
        }
    });

     $(document).ready(function() {
        if (!!window.EventSource) {
            var url_ = "<?php echo base_url('panel/campaign/pie_balance/'); ?>";
            var id = "<?php echo $id; ?>";
            var source = new EventSource(url_ + id);
            source.addEventListener('message', function(e) {
                var data = JSON.parse(e.data);
                dataChart.labels = data.data.labels;
                dataChart.datasets[0].data = data.data.data;
                dataChart.datasets[0].backgroundColor = data.data.background;
                piechart.update();
            }, false);

         }
    }) 
</script>

<script type="text/javascript">
    var ctx = document.getElementById("pieacoount").getContext("2d");
    var pieacoount = {
        labels: [0],
        datasets: [{
            label: "Average",
            data: [0],
            backgroundColor: [0],
        }],
    };
    var piecharttwo = new Chart(ctx, {
        type: 'pie',
        data: pieacoount,
        options: {
            title: {
                display: true,
                text: 'Call Status by Os Balance'
            }
        }
    });

     $(document).ready(function() {
        if (!!window.EventSource) {
            var url_ = "<?php echo base_url('panel/campaign/pie_acoount/'); ?>";
            var id = "<?php echo $id; ?>";
            var source = new EventSource(url_ + id);
            source.addEventListener('message', function(e) {
                var data = JSON.parse(e.data);
                pieacoount.labels = data.data.labels;
                pieacoount.datasets[0].data = data.data.data;
                pieacoount.datasets[0].backgroundColor = data.data.background;
                piecharttwo.update();
            }, false);

         }
    }) 
</script>

<script type="text/javascript">
    var ctx = document.getElementById("durasiChartcanvas").getContext("2d");
    var durasiChartdata = {
        labels: [],
        datasets: [
            {   
                label: "Durasi Line",
                type: "line",
                data: [],
                borderColor: ["#000000"],
                fill: false
            },
            {   
                label: "Durasi Bar",
                type: "bar",
                data: [],
                backgroundColor: [],
            }
        ],
    };
    var durasiChart = new Chart(ctx, {
        data: durasiChartdata,
        type: 'bar',
        options: {
            title: {
                display: true,
            },
            maintainAspectRatio:true,            
            plugins: {
                datalabels: {
                    formatter: (value, ctx) => {
                        var date = new Date(0);
                        date.setSeconds(value); 
                        var timeString = date.toISOString().substr(11, 8);
                        return timeString;
                    },
                }
            }
        
        }
    });

     $(document).ready(function() {
        if (!!window.EventSource) {
            var url_ = "<?php echo base_url('panel/campaign/chart_durasi/'); ?>";
            var id = "<?php echo $id; ?>";
            var source = new EventSource(url_ + id);
            source.addEventListener('message', function(e) {
                var data = JSON.parse(e.data);
                durasiChartdata.labels = data.data.labels;
                durasiChartdata.datasets[0].data = data.data.data;
                durasiChartdata.datasets[1].data = data.data.data;
                durasiChartdata.datasets[1].backgroundColor = data.data.background;
                durasiChart.update();
            }, false);

         }
    }) 
</script>

