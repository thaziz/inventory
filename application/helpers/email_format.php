<?php 
	$url = base_url();
	$url = str_replace('api','',str_replace('api/','',$url));
 ?>
<html>
	<head>
		<style>
			.ios.box-wrapper{
				border: 0;
				background-color: #f5f5f5;
				font-family: Arial,sans-serif;
				font-size: 14px;
				width: 100%;
			}
			.ios.box-wrapper>tbody>tr>td{
				padding: 10px 20px;
			}
			.ios.box-wrapper .avatar{
				height: 30px;
				width: 30px;
				margin-bottom: -10px;
			}
			.ios.box-wrapper a{
				text-decoration: none;
			}
			.ios.box-wrapper .box{
				padding: 20px 15px;
				background-color: #fff;
				border: 1px solid #cfcfcf;
				border-radius: 5px;
			}
			.ios.box-wrapper .box ul.nav{
				padding: 0;
				list-style: none;
			}
			.ios.box-wrapper .box ul.nav>li{
				display: inline;
				margin-right: 3px;
			}
			.ios-ticket-desc{
				font-family: Arial,sans-serif;
				font-size: 14px;
			}
			.ios-ticket-desc caption{
				text-align: left;
				color: #666;
				font-weight: bold;
				margin-bottom: 10px;
			}
			.ios-ticket-desc td.text-muted{
				color: #666;
				padding-right: 30px;
				padding-bottom: 5px;
			}
			.ios-ticket-desc span.label{
				padding: 2px 5px;
				border-radius: 2px;
				color: #fff;
			}
			.ios-ticket-desc span.label.label-info{
				background-color: #2196F3;
			}
			.ios-ticket-desc span.label.label-warning{
				background-color: #ff9800;
			}
			.ios-ticket-desc span.label.label-danger{
				background-color: #d9534f;
			}

		</style>
	</head>
	<body>
		<table class="ios box-wrapper">
			<tbody>
				<tr>
					<td>
						<span><img class="avatar" src="<?=$url.$avatar?>"></span>
						<span><a href="<?=$url.'/user/detail/'+$assign_by?>"><?=$username?></a></span>
						<span><strong>Update</strong></span>
						<span>a ticket assignment to <?=$msg?></span>
					</td>
				</tr>
				<tr>
					<td style="padding-top:0">
						<div class="box">
							<div>
								<ul class="nav">
									<li class="first"><a href="<?=$url?>">IOS Infokom</a></li>
									<li>/</li>
									<li><a href="<?=$url.'/ticket/detail/'.$ticket_id?>"><?=$ticket_id?></a></li>
								</ul>
							</div>
							<h3 class="title"><a href="<?=$url.'/ticket/detail/'.$ticket_id?>"><?=$subject?></a></h3>
							<table class="ios-ticket-desc">
								<caption>Ticket Detail</caption>
								<tr>
									<td class="text-muted">Category:</td><td><?=$cat_name?></td>
								</tr>
								<tr>
									<td class="text-muted">Topic:</td><td><?=$topic_name?></td>
								</tr>
								<tr>
									<td class="text-muted">Subject:</td><td><?=$subject?></td>
								</tr>
								<tr>
									<td class="text-muted">Priority:</td><td><span class="label <?=$label?>"><?=ucfirst($severety)?></span></td>
								</tr>
								<tr>
									<td class="text-muted">Assign by:</td><td><a href="<?=$url.'/user/detail/'+$assign_by?>"><?=$username?></a></td>
								</tr>
								<tr>
									<td class="text-muted">Assignee:</td><td><a href="<?=$url.$to_url?>"><?=$assignee?></a></td>
								</tr>
								<tr>
									<td class="text-muted">Assign Time:</td><td><?=$assign_time?></td>
								</tr>
								<tr>
									<td class="text-muted">Your Due Date:</td><td><?=$irt_time?></td>
								</tr>
								<tr>
									<td class="text-muted">Description</td><td><?=$ticket_desc?></td>
								</tr>
								<tr>
									<td class="text-muted">Note</td><td><?=$note?></td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
				<tr>
					<td></td>
				</tr>
			</tbody>
		</table>
	</body>
</html>