<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
	<section class="content-header">
	    <h1>
	      IVR
	      <small> View</small>
	    </h1>
	    <ol class="breadcrumb">
	      <li><a href="<?=base_url('panel');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	      <li><a href="<?=base_url('panel/ivr');?>">IVR</a></li>
	      <li class="active">View</li>
	    </ol>
  	</section>

  	<section class="content">
	  	<div class="row">
	  		<div class="col-xs-12">
	  			<div class="box">
		            <div class="box-header">
		              <h3 class="box-title">Detail <?=$data->ivr_name;?></h3>
		            </div>
				    <div class="box-body">
				        <table class="table table-condensed">
				            <?php
				            	foreach ($data as $key => $value) {
				            		$field = str_replace('_', '', $key);
				            		/*if($key == 'pro_id'){
				            			$field = 'Identifier';
				            		}elseif ($key == 'adm_firstname') {
				            			$field = 'First Name';
				            		}elseif ($key == 'limitbalance') {
				            			$field = 'Limit Balance';
				            		}elseif ($key == 'pro_creation') {
				            			$field = 'Created Date';
				            		}elseif ($key == 'billcycle') {
				            			$field = 'Billing Cycle';
				            		}elseif ($key == 'pro_enabled') {
				            			$value = '<input type="checkbox" '.($value?'checked':'').' disabled>';
				            		}*/
				            		echo '<tr>
				            				<td style="width:250px;background-color:#eee;padding-left:15px;">'
				            				.ucfirst($field).' :</td><td style="padding-left:25px;">'.$value.'</td>
				            			  </tr>';
				            	}
				            	?>
				        </table>
				    </div>
	  			</div>
	  		</div>
	  	</div>
  </section>
</div>
