<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/dist/css/progressbar.css') ?>">
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
</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Campaign <?= $data->campaign_name; ?><small>Summary Report</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('panel'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?= base_url('panel/campaign'); ?>">Campaign</a></li>
            <li class="active">Detail</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <ul class="nav nav-tabs">
                    <li role="presentation"><a href="<?= base_url('panel/campaign/dashboard/' . $data->campaign_id); ?>">Dashboard</a></li>
                    <li role="presentation"><a href="<?= base_url('panel/campaign/detail/' . $data->campaign_id); ?>">Detail</a></li>
                    <li role="presentation"><a href="<?= base_url('panel/campaign/agents/' . $data->campaign_id); ?>">Agents</a></li>
                    <li role="presentation"><a href="<?= base_url('panel/campaign/assignment/' . $data->campaign_id); ?>">Assignment</a></li>
                    <li role="presentation"><a href="<?= base_url('panel/campaign/report/' . $data->campaign_id); ?>">Report</a></li>
                    <li role="presentation" class="active"><a href="#">Summary Report</a></li>
                </ul>
                <div class="box" style="border:1px solid #ddd;border-top:none;border-top-left-radius:0;border-top-right-radius:0;">
                    <div class="box-body">
                        <div class="col-md-12 p-0">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Summary Report</h3>
                                </div>
                                <div class="box-body">
                                    <table id="summary_report" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="70px;">NO</th>
                                                <th>Agent</th>
                                                <th>Dates</th>
                                                <th>Aux</th>
                                                <th>Total Login Time</th>
                                                <th>Incoming Calls in Minutes</th>
                                                <th>Incoming Calls in Number</th>
                                                <th>Average handling Time</th>
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
</div>


<script src="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/multiselect/js/multiselect.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('#summary_report').dataTable({
            "aLengthMenu": [10, 25, 50, 100, 500, 1000, 2500, 5000],
            "ajax": {
                "url": "<?php echo current_url() ?>",
                "type": "POST"
            },
            "aaSorting": [
                [1, "desc"]
            ],
            "searching": true,
            "paging": true,
            "bFilter": false,
            "bStateSave": true,
            "bServerSide": true,
            "sPaginationType": "full_numbers",
            "aoColumnDefs": [{
                    "sClass": "center",
                    "aTargets": [0],
                    "data": 0
                },
                {
                    "sClass": "center",
                    "aTargets": [1],
                    "data": 1
                },
                {
                    "sClass": "center",
                    "aTargets": [2],
                    "data": 2
                },
                {
                    "sClass": "center",
                    "aTargets": [3],
                    "data": 3
                },
                {
                    "sClass": "center",
                    "aTargets": [4],
                    "data": 4
                },
                {
                    "sClass": "center",
                    "aTargets": [5],
                    "data": 5
                },
                {
                    "sClass": "center",
                    "aTargets": [6],
                    "data": 6
                },
                {
                    "sClass": "center",
                    "aTargets": [7],
                    "data": 7
                },
            ]
        });

        //action to change all checkbox
        $('.check-all').change(function() {
            $('.check-item').prop('checked', $(this).prop('checked'));
        });

    });
</script>