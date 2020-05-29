<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
	<section class="content-header">
	    <h1>
	      Customer
	      <small> View</small>
	    </h1>
	    <ol class="breadcrumb">
	      <li><a href="<?=base_url('panel');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	      <li><a href="<?=base_url('panel/customer');?>">Customer</a></li>
	      <li class="active">Veiw</li>
	    </ol>
  	</section>

  	<section class="content">
	  	<div class="row">
	  		<div class="col-xs-12">
	  			<div class="box">
		            <div class="box-header">
		              <h3 class="box-title">Detail <?=$data->cus_name;?></h3>
		            </div>
				    <div class="box-body">
				        <table class="table table-condensed">
				            <?php
				            	foreach ($data as $key => $value) {
				            		$field = str_replace('cus_', '', $key);
				            		$field = str_replace('_', ' ', $field);
				            		if($key == 'cus_id'){
				            			$field = 'Identifier';
				            		}elseif ($key == 'cus_firstname') {
				            			$field = 'First Name';
				            		}elseif ($key == 'cal_id' || $key=='tim_id' || $key=='cus_currency') {
				            			continue;
				            		}elseif ($key == 'cur_name') {
				            			$field = 'Currency';
				            		}elseif ($key == 'tim_zone') {
				            			$field = 'Timezone';
				            		}elseif ($key == 'cal_name') {
				            			$field = 'Call Plan';
				            		}elseif ($key == 'cus_accounttype') {
				            			$field = 'Type';
				            			$value = $value==1?'Postpaid':'Prepaid';
				            		}elseif ($key == 'cus_creditlimitnotify' || $key == 'cus_generateinvoice') {
				            			$value = $value==1?'Yes':'No';
				            		}elseif ($key == 'cus_ip') {
				            			$field = 'IP Address';
				            		}elseif ($key == 'cus_enabled' || $key == 'cus_sendinvoice') {
				            			$value = '<input type="checkbox" '.($value?'checked':'').' disabled>';
				            		}
				            		echo '<tr>
				            				<td style="width:250px;background-color:#eee;padding-left:15px;">'
				            				.ucwords($field).' :</td><td style="padding-left:25px;">'.$value.'</td>
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
