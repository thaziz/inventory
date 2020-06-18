<html>
<head>
</head>
<script type="text/javascript">
	window.print()
</script>
<style type="">
	#ttt {
		border-collapse: collapse;
	}

	#ttt table, #ttt th, #ttt td {
		border: 1px solid black;
	}

</style>
<style type="text/css" media="print">
	@page {
		size: auto;  
		margin: 0;  
	}
</style>
<style>
	body{
		padding-left: 1.3cm;
		padding-right: 1.3cm; 
		padding-top: 1.1cm;
	}
</style>
<body>
	<table width="100%"> 
		<tbody>
			<tr> 
				<th width="15%"><img src="https://localhost/outbound/assets/dist/img/banjar.jpeg" style="width:70px;height: 90px"></th>		
				<th width="60%">
					<div style="font-size:16px">PEMERINTAH KABUPATEN BANJAR</div>
					<div  style="font-size:16px"> PD. PASAR BAUNTUNG BATUAH</div>
					<div  style="font-size:small;">JL. SukaramaiPertokoanBerlian LT.II Martapura-Kalimantan Selatan 70614</div>
					<div style="font-size:small;">Telp. 0511-4721134 / Fax. 0511-4720055</div>
				</th>
				<th width="15%"><img src="https://localhost/outbound/assets/dist/img/pbb.jpeg" style="width:70px;height: 90px">
				</th>		
			</tr>
			<tr><td colspan="3"><hr style="border: outset 2px black"></td></tr>
			<tr> 
				<td colspan="3" >
					<div align="center"> SURAT PERMOHONAN PERMINTAAN</div>
					<div align="center" style="font-style: bold">
						<?=strtoupper($data['master']->ro_type) ?>
					</div>
				</td>
			</tr>
			<tr> 
				<td colspan="2">
					<table>
						<tr>
							<td>Kepada Yth.td</td>
							<td>:  Kepala Bidang <?=$data['master']->fro ?></td>
						</tr>
						<tr>
							<td>Dari</td>
							<td>:  <?=$data['master']->fro ?></td>
						</tr>
						<tr>
							<td>Tanggal</td>
							<td>:   <?=date('d-M-Y',strtotime($data['master']->ro_date)) ?></td>
						</tr>
						<tr>
							<td>Perihal</td>
							<td><span style=" border-bottom: 1px solid black;">:   <?=$data['master']->ro_note ?></span></td>
						</tr>
					</table>
				<!-- <div>Kepada Yth. : Kepala Bidang Ketatausahaan</div>
<div>Dari :Plh. Bendahara Barang</div>
<div>Tanggal : 16 Maret 2020</div>
<div>Perihal <span style=" border-bottom: 1px solid black;">: Permohonan permintaan Alat Tulis Kantor (ATK) Bidang Ketatausahaan</span></div>
-->
</td>
<td></td>
</tr>
<tr> 
	<td colspan="3">
		<br>  
		<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Untuk mendukung kegiatan kerja di Bidang <?=$data['master']->fro ?> pada PD. Pasar Bauntung Batuah,
			maka diperlukan sarana dan prasarana yang mendukung kegiatan tersebut.
		</div>
		<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Sehubungan hal tersebut diatas, kami bermaksud mengajukan permintaan <?=$data['master']->ro_type ?>
			untuk keperluan Bidang <?=$data['master']->fro ?> <!-- untuk bulan Maret 2020 -->
		</div>
	</td>
</tr>
<tr> 
	<td colspan="3" align="center">
		<br> 
		<table width="60%" id="ttt">
			<thead> 
				<th>No</th>
				<th align="left">Nama</th>
				<th>Jumlah</th>
				<th>Catatan</th>
			</thead>
			<tbody>
				<?php $index=1; foreach ($data['detail'] as $key => $v): ?>

				<?php 

				$ax='';
				$string=$v->rod_item_name;

				$split = explode(' - ', $string);
				if (count($split) === 1) {
    // do you still want to drop the first word even if string only contains 1 word?
    // also string might be empty
				} else {
    // remove first word
					unset($split[0]);
					$ax= implode(' ', $split);
				}


				?>

				<tr> 
					<td align="center"><?=$index ?></td>
					<td><?=$ax ?></td>
					<td align="center"><?=$v->rod_qty ?></td>
					<td align="center"><?=$v->rod_note?></td>
				</tr>

				<?php $index++; endforeach ?> 

			</tbody>
		</table>
		<br> 				
	</td>
</tr>
<tr> 
	<td colspan="3">				
		Demikian surat permohonan ini dibuat, atas perhatiannya diucapkan terima kasih.
	</td>
</tr>
<tr>
	<td colspan="3" align="right">
		<table>
			<tr> 
				<th>
					Pemohon
				</th>
			</tr>
			<tr style="height: 100px"> 
				<th></th>
			</tr>
			<tr>
				<th>
					<div><?=$data['master']->adm_name ?></div>
					<div><?=$data['master']->adm_nik ?></div>
				</th>
			</tr>
		</table>
	</td>

</tr>
</tbody>
</table>
</body>
</html>