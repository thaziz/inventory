<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<style type="text/css">
	body{
		margin: 8px 0;
		height: 100vh;
		position: relative;
	}
	footer{
		position: absolute;
		bottom: 0;
		width: 100%;
		background-color: #f9f9f9;
		border-top: 1px outset #ddd;
		padding: 5px 0 5px 0;
		margin-top: 15px;
	}
	footer *{
		text-align: center;
	}
	footer img{
		margin: 0 auto;
		display: block;
	}
	footer h4{
		margin: .2em;
		font-size: .9em;
	}
	footer p{
		color: #555;
	}
	footer .company-address{
		margin: .4em;
		font-size: .9em;
	}
	footer .copy{
		margin: 2em 0 .9em 0;
		font-size: .8em;
	}
	footer .copy a{
		text-decoration: none;
	}
</style>
<header></header>
<div class="content"><?=$message?></div>
<footer>
	<img src="<?=base_url('assets/images/infokom-small-logo.png')?>">
	<h4 class="company-name">PT. INFOKOM ELEKTRINDO</h4>
	<p class="company-address">Jl.Yos Sudarso Jakarta Utara</p>
	<p class="copy">&copy; 2018 <a href="http://infokom.id">PT. Infokom Elektrindo</a></p>
</footer>
</body>
</html>