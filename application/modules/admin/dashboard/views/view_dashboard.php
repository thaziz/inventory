<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*echo $all_call_records[0]->counter;
exit;
print_r($all_call_records);
exit;*/
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Dashboard
      <small>Version 2.0</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>
<?php if(false):?>
      <section class="content">  
      <!-- /.row -->
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Total Call Per-Day</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-wrench"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                  <p class="text-center">
                    <strong><?=date('j F Y')?></strong>
                  </p>

                  <div class="chart">
                    <!-- Sales Chart Canvas -->
                    <canvas id="callChart" style="height: 180px;"></canvas>
                  </div>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <p class="text-center">
                    <strong>Status Call</strong>
                  </p>

                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Answer</span>
                    <span class="progress-number">
                      <b>
                        <?php echo number_format($call_status_answer); ?></b>/ 
                        <?php echo $all_call_records[0]->counter; ?>
                    </span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-aqua" style="width: <?php echo str_replace(",", ".",number_format($call_status_answer)); ?>% "></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Busy</span>
                    <span class="progress-number">
                      <b>
                        <?php echo number_format($call_status_busy); ?></b>/ 
                        <?php echo $all_call_records[0]->counter; ?>
                    </span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-red" style="width: <?php echo str_replace(",", ".",number_format($call_status_busy)); ?>% "></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Cancel</span>
                    <span class="progress-number">
                      <b>
                        <?php echo number_format($call_status_cancel); ?></b>/ 
                        <?php echo $all_call_records[0]->counter; ?>
                    </span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-green" style="width: <?php echo str_replace(",", ".",number_format($call_status_cancel)); ?>% "></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->

                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Chaunavail</span>
                    <span class="progress-number">
                      <b>
                        <?php echo number_format($call_status_chaunavail); ?></b>/ 
                        <?php echo $all_call_records[0]->counter; ?>
                    </span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-green" style="width: <?php echo str_replace(",", ".",number_format($call_status_chaunavail)); ?>% "></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->

                  <!--<div class="progress-group">
                    <span class="progress-text">Failed</span>
                    <span class="progress-number"><b>250</b>/ <?php //echo $for_off_date[0]->counter; ?></span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-yellow" style="width: 80%"></div>
                    </div>
                  </div>
                   /.progress-group -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <!--<div class="box-footer">
              <div class="row">
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> <?php //echo $number_of_calls['for_precentage'] ?>%</span>
                    <h5 class="description-header"><?php //echo $number_of_calls['for_number']; ?></h5>
                    <span class="description-text">Number Of Calls</span>
                  </div>
            
                </div>
            
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> <?php //echo $number_of_calls['for_precentage'] ?>%</span>
                    <h5 class="description-header"><?php //echo $number_of_calls['for_number']; ?></h5>
                    <span class="description-text">Average Calls Per Hour</span>
                  </div>
            
                </div>
            
                <div class="col-sm-2 col-xs-5">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> <?php //echo $total_call_duration['precentage']; ?>%</span>
                    <h5 class="description-header"><?php //echo $total_call_duration['duration']; ?></h5>
                    <span class="description-text">TOTAL CALL DURATION</span>
                  </div>
                  
                </div>
                
                <div class="col-sm-2 col-xs-5">
                  <div class="description-block">
                    <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> <?php //echo $average_call['precentage']; ?>%</span>
                    <h5 class="description-header"><?php //echo $average_call['avg']; ?></h5>
                    <span class="description-text">Average Call Duration</span>
                  </div>
                
                </div>

                <div class="col-sm-2 col-xs-2">
                  <div class="description-block">
                    <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> <?php //echo $average_call['precentage']; ?>%</span>
                    <h5 class="description-header"><?php //echo number_format($total_sellcost[0]->last_month_sale); ?></h5>
                    <span class="description-text">Total Sell Cost</span>
                  </div>
                  
                </div>

              </div>
              
            </div>!-->
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-8">
        <!-- TABLE: LATEST ORDERS -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Latest Failed Rating</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>DID</th>
                    <th>Destination</th>
                    <th>Duration</th>
                    <th>Date</th>
                    <th>Error</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($failed_rating as $value):?>
                  <tr>
                    <td><a href="<?=base_url('panel/failed_rating')?>"><?=$value->did?></a></td>
                    <td><?=$value->destination?></td>
                    <td><?=$value->duration?></td>
                    <td><?=$value->datecall?></td>
                    <td><?=$value->error?></td>
                  </tr>
                  <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <a href="<?=base_url('panel/failed_rating')?>" class="btn btn-sm btn-default btn-flat pull-right">View All</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Customer In Group</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                  <div class="chart-responsive">
                    <canvas id="pieChart" height="150"></canvas>
                  </div>
                  <!-- ./chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <ul class="chart-legend clearfix">
                  <?php foreach ($cus_sip['label'] as $value) {
                    echo '<li><i class="fa fa-circle-o" style="color:'.$value['color'].'"></i> '.$value['name'].'</li>';
                  }?>
                  </ul>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              <ul class="nav nav-pills nav-stacked">
                <?php foreach ($cus_sip['data'] as $value) {
                    echo '<li><a href="#"> '.$value['label'].'<span class="pull-right" style="color:'.$value['color'].'"> '.$value['value'].' Customers</span></a></li>';
                }?>
              </ul>
            </div>
            <!-- /.footer -->
          </div>
        </div>
        <!-- /.col -->

        <!--Total Call (In Summary)!-->

      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-12">
        <!-- TABLE: LATEST ORDERS -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Latest Call</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Extension</th>
                    <th>Caller ID</th>
                    <th>Destination</th>
                    <th>Call Plan</th>
                    <th>Call List</th>
                    <th>Sell Price</th>
                    <th>Call Status</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($last_call as $value):?>
                  <tr>
                    <td><?=$value->ext?></td>
                    <td><?=$value->callerid?></td>
                    <td><?=$value->pre_destination?></td>
                    <td><?=$value->cus_cal_name?></td>
                    <td><?=$value->lis_name?></td>
                    <td><?=number_format($value->cdr_customersellprice, 2, ',','.')?></td>
                    <td><?=$value->cdr_terminatecause?></td>
                  </tr>
                  <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <a href="<?=base_url('panel/cdr')?>" class="btn btn-sm btn-default btn-flat pull-right">View All</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        </div>
      </section>
        <!-- ChartJS 1.0.1 -->
        <script src="<?php echo base_url(); ?>assets/plugins/chartjs/Chart.min.js"></script>
      <script src="<?php echo base_url('assets/plugins/chartjs/call_perday.js'); ?>"></script>
    <?php endif;?>
      </div>
<script type="text/javascript">
  var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
  var pieChart = new Chart(pieChartCanvas);
  var PieData = <?=json_encode($cus_sip['data'])?>;
  var pieOptions = {
    segmentShowStroke: true,
    segmentStrokeColor: "#fff",
    segmentStrokeWidth: 1,
    percentageInnerCutout: 50,
    animationSteps: 100,
    animationEasing: "easeOutBounce",
    animateRotate: true,
    animateScale: false,
    responsive: true,
    maintainAspectRatio: false,
    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>",
    tooltipTemplate: "<%=value %> <%=label%> Customers"
  };
  pieChart.Doughnut(PieData, pieOptions);
</script>