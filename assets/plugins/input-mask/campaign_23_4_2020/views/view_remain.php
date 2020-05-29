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
                  <li role="presentation"><a href="<?=base_url('panel/campaign/dashboard/'.$data->campaign_id);?>">Dashboard</a></li>
                  <li role="presentation"><a href="<?=base_url('panel/campaign/detail/'.$data->campaign_id);?>">Detail</a></li>
                  <?php if($rules['e']||$rules['c']):?>
                  <li role="presentation"><a href="<?=base_url('panel/campaign/agents/'.$data->campaign_id);?>">Agents</a></li>
                  <li role="presentation"><a href="<?=base_url('panel/campaign/assignment/'.$data->campaign_id);?>">Assignment</a></li>
                  <li role="presentation"><a href="<?=base_url('panel/campaign/target/'.$data->campaign_id);?>">Target Tools</a></li>
                  <?php endif;?>

                  <li class="active"><a href="">Remaining Data</a></li>
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
                           
                            <div class="col-sm-4">
                                <div class="inline-block total-call bg-yellow">
                                    <div class="col-sm-3 for-card">
                                        <i class="fa fa-phone-square float-left icon"></i>
                                    </div>

                                    <div class="col-sm-9">
                                        <div class="text">
                                            <p class="text-bold">Total Remaining Data</p>
                                            <p class="" id="total_remain">0</p>
                                            <p class="" id="total_ptp_amount"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class = "col-md-12">
                                <p class="text-left">
                                    <!--strong>Agent Wallboard</strong-->
                                </p>
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-bordered" id="tbl_agent_wb">
                                        
                                            <tr>
                                                <td  class="text-center" style="width: 50px;">Re Spin</td>
                                            
                                                <td  class="text-center" style="width: 50px;">
                                                    <button class="btn btn-sm btn-success" type="button" onclick="putar(1)">Re Spin </button>
                                                </td>
                                            </tr>
                                           
                                             <tr>
                                                <td  class="text-center" style="width: 50px;">select the field</td>
                                                <td  class="text-center" style="width: 50px;">
                                                    <select class="form-control" id="field">
                                                       <?php foreach ($form as $key => $value): ?>
                                                        <option value="<?=$value['form'] ?>"><?=$value['form'] ?> </option> 
                                                       <?php endforeach ?>
                                                    </select>
                                                </td>
                                                 <td  class="text-center" style="width: 50px;">
                                                    <button class="btn btn-sm btn-success" type="button" onclick="putar(2)">Go </button>
                                                </td>
                                            
                                               
                                            </tr>
                                        
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
            $(document).ready(function() {
        if (!!window.EventSource) {
            var url_ = "<?php echo base_url('panel/campaign/data_remaining/'); ?>";
            /* var id = "<?php echo $id; ?>"; */
            var id = "<?php echo $id ;?>";
            var source = new EventSource(url_ + id);
            source.addEventListener('message', function(event) {                
                var data = JSON.parse(event.data);
                console.log(data);
                $('#total_remain').text(data.data);
            });
        }
    })   

    function putar(flag){
    		var field=$('#field').val();
    		var campaign="<?=$id ?>";
    		
    		$.ajax({
          	url : '<?php echo base_url("panel/campaign/reply_data"); ?>',
          	type: "POST",
          	data : {'flag':flag,'campaign':campaign,'field':field},
          	dataType: 'json',
          	success:function(data, textStatus, jqXHR){
              	if(data){
	                $().toastmessage('showToast', {
                        text     : 'success',
                        position : 'top-center',
                        type     : 'success',
                       /* close    : function () {
                            window.location = "<?=base_url('panel/campaign/dashboard/');?>"+data.id;
                        }*/
                    });
              	}else{
	                $().toastmessage('showToast', {
					    text     : 'success',
					    position : 'top-center',
					    type     : 'success',
					   /* close    : function () {
					    	window.location = "<?=base_url('panel/campaign/dashboard/');?>"+data.id;
					    }*/
					});
              	}
          	},
          	error: function(jqXHR, textStatus, errorThrown){
          		$.post('<?=base_url('logger/writexhrlog')?>', {'act':'submit call','xhr':jqXHR.responseText, 'status':textStatus, 'error':errorThrown});
              alert('Error,something goes wrong');
          	}
      	});
    }   
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
