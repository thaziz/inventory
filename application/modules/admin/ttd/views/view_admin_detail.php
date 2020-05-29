<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
	<section class="content-header">
	    <h1>
	      Administrator
	      <small> View</small>
	    </h1>
	    <ol class="breadcrumb">
	      <li><a href="<?=base_url('panel');?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	      <li><a href="<?=base_url('panel/admin');?>">Administrator</a></li>
	      <li class="active">View</li>
	    </ol>
  	</section>

  	<section class="content">
	  	<div class="row">
	  		<div class="col-xs-12">
	  			<div class="box">
		            <div class="box-header">
		              <h3 class="box-title">Detail</h3>
		            </div>
				    <div class="box-body">
				        <table class="table table-condensed">
				            <?php
				            	foreach ($data as $key => $value) {
				            		$field = str_replace('adm_', '', $key);
				            		$field = str_replace('_', ' ', $field);
				            		if($key == 'adm_id'){
				            			$field = 'Identifier';
				            		}elseif ($key == 'adm_firstname') {
				            			$field = 'First Name';
				            		}elseif ($key == 'adm_lastconnection') {
				            			$field = 'Last Connection';
				            		}elseif ($key == 'grp_id' || $key == 'adm_password') {
				            			continue;
				            		//}elseif ($key == 'adm_password') {
				            		//	$value = str_repeat("*", strlen($value));
				            		}elseif ($key == 'grp_name') {
				            			$field = 'Group';
				            		}elseif ($key == 'adm_ip') {
				            			$field = 'IP Address';
				            		}elseif ($key == 'status') {
				            			$value = '<input type="checkbox" '.($value?'checked':'').' disabled>';
				            		}
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
