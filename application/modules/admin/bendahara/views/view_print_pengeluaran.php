<html>
<head>
	<title>Print Pengeluaran</title>
</head>

<body>
	<table align="center" border="0" cellpadding="1" style="width: 700px;"><tbody>
		<tr>     <td colspan="3"><div align="center">
			<span style="font-family: Verdana; font-size: small;"><b>


				<div >PEMERINTAH KABUPATEN BANJAR</div>
				<div > PD. PASAR BAUNTUNG BATUAH</div>
				<div  style="font-size:x-small;">JL. SukaramaiPertokoanBerlian LT.II Martapura-Kalimantan Selatan 70614</div>
				<div  style="font-size:x-small;">Telp. 0511-4721134 / Fax. 0511-4720055</div>
				<div  style="font-size:small;"><span style="border-bottom: 2px black solid">VOUCHER PENGELUARAN KAS</span></div>
				<br> 
			</b></span>
		</div>
	</td>   
</tr>
<tr> <!-- a_code,a_name -->
	<td>Sumber Dana : <?=$po->a_code.' - '.$po->a_name ?></td>
	<td> </td>
	<td>Tgl	: <?=date('d-m-Y',strtotime($po->tgl)) ?></td>
</tr>
<tr> 
	<td>Dikeluarkan Oleh:	Bendahara Pengeluaran</td>
	<td> </td>
	<td>No.Vcr :  <?=$po->no ?></td>
</tr>
<tr> 
	<td colspan="3">Dibayar Kepada		: <?=$ttd->peminjaman4?></td>
</tr>

<tr> 
	<td colspan="3" align="center">

		<table width="100%">
			<thead> 
				<tr>
					<th colspan="3">
						<hr> 
					</th>
				</tr>
				<tr> 
					<th align="left">	 			
					No</th>
					<th align="left">Keterangan</th>
					<th align="right" width="15%">Jumlah</th>
				</tr>
				<tr>
					<th colspan="3">
						<hr> 
					</th>
				</tr>				
			</thead>
			<tbody> 
				<tr> 
					<td>1</td>
					<td><?=$po->po_ket_voucer_pinjaman ?></td>
					<td  align="right"><?=number_format($po->po_anggaran,0,',','.') ?></td>
				</tr>
					<!-- <tr>
						<td> </td>
						<td colspan="2"><?=$po->po_code_a?></td>
					</tr> -->
				<tr> 
					<td colspan="3" height="10px"></td>
				</tr>
				<tr>
					<td colspan="2"></td>

					<td> <hr ></td>
				</tr>
				<tr>	 				
					<td colspan="2" align="right">Total Rp.</td>
					<td  align="right"><?=number_format($po->po_anggaran,0,',','.') ?></td>
				</tr>

				<tr>
					<td colspan="2"></td>
					<td> <hr ></td>
				</tr>
			</tbody>
		</table>

	</td>
</tr> 

<tr>
	<td colspan="3" height="30px"></td>		
</tr>
<tr>
	<td colspan="3" height="30px">
		<table width="100%">
			<td align="center">
				Menyetujui,<br>
				Pengguna Anggaran			

			</td>
			<td align="center">
			Diperiksa Oleh	<br> 
			Kabid Keuangan	
			</td>
			<td align="center">
				TTD Pembayar
			<br>Bendahara 
			</td>
			<td align="center">TTD. Penerima</td>
			<tr>
				<td colspan="4" height="60px"></td>		
			</tr>
			<tr>
	<td align="center"><span style="border-bottom: 2px black solid"><?=$ttd->peminjaman1?></span><br>NIK.<?=$ttd->nikp1?></td>
	<td align="center"><span style="border-bottom: 2px black solid"><?=$ttd->peminjaman2?></span><br>NIK.<?=$ttd->nikp2?></td>
	<td align="center"><span style="border-bottom: 2px black solid"><?=$ttd->peminjaman3?></span><br>NIK.<?=$ttd->nikp3?></td>
	<?php
$a=explode("-", $po->penerima1);
	?>
	<td align="center"><span style="border-bottom: 2px black solid"><?=$a[2]?></span><br>NIK.<?=$a[1]?></td>
</tr>

		</table>
	</td>			
</tr>



</tbody></table></body>
</html>

<style>
	body{
		padding-left: 1.3cm;
		padding-right: 1.3cm; 
		padding-top: 1.1cm;
	}
</style>



<style media="print">
	@media print {
  html, body {
    width: 21.59cm;
    height:  13.97cm;
  }
  /* ... the rest of the rules ... */
}
 
</style>

<style type="text/css" media="print">

table {
   border-collapse: collapse;
}

/* And this to your table's `td` elements. */
table td {
   padding: 0; 
   margin: 0;
}

</style>
<script type="text/javascript">
	window.print();
</script>
