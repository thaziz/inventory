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
            Campaign <small>Dashboard</small>
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
                 

              </ul>

              <div class="box" style="border:1px solid #ddd;border-top:none;border-top-left-radius:0;border-top-right-radius:0;">
             

                        
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class = "col-md-12">
                                        
                                        <div class="table-responsive">







<?php 
echo '<table class="table table-bordered table-striped" id="tb-wise" border="1" style="width:100%">';
            echo '<tr><th rowspan="2">Status</th>';
            foreach ($d['agent'] as $key => $value) {
              echo '<th colspan="2">'.$value->name.'</th>';
            }
           
            echo '</tr>';
            foreach ($d['agent'] as $key => $value) {
              echo '<th>Account</th>';
              echo '<th>OS</th>';
            }
            foreach ($d['data'] as $d['status'] =>$val) {
                echo '<tr>';
                echo '<td>'.$d['status'].'</td>';
                foreach ($d['agent']  as $key => $value) {
                echo '<td>'.(isset($val[strtolower($value->name)]['a'])?$val[strtolower($value->name)]['a']:'0').'</td>';
                 echo '<td>'.(isset($val[strtolower($value->name)]['b'])?$val[strtolower($value->name)]['b']:'0').'</td>';
              }
            
                echo '</tr>';
            }
            echo '</table>';

 ?>


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

        <script src="<?php echo base_url(); ?>assets/plugins/chartjs/Chart.2.7.3.min.js"></script>
        <script src="<?php echo base_url('assets/plugins/chartjs/line_chart.js'); ?>"></script>
<!--<script src="<//?php echo base_url('assets/plugins/chartjs/campaign_status_data.js'); ?>"></script>
    <script src="<//?php echo base_url('assets/plugins/chartjs/campaign_status_call.js'); ?>"></script>!-->
    