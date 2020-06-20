<html>
<head>
<title>Cetak Pengembalian</title>
</head>

<body>
<table align="center" border="0" cellpadding="1" style="width: 700px;"><tbody>
<tr>     <td colspan="3"><div align="center">
<span style="font-family: Verdana; font-size: small;"><b>
	

<div >PEMERINTAH KABUPATEN BANJAR</div>
				<div > PD. PASAR BAUNTUNG BATUAH</div>
				<div  style="font-size:x-small;">JL. SukaramaiPertokoanBerlian LT.II Martapura-Kalimantan Selatan 70614</div>
				<div  style="font-size:x-small;">Telp. 0511-4721134 / Fax. 0511-4720055</div>
				<div  style="font-size:small;"><span style="border-bottom: 2px black solid">Tanda Bukti Penerimaan</span></div>
				<br> 
			



</b></span>

</div>
</td>   </tr>
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
	 			<tr> 
	 				<td colspan="3" height="50px"></td>
	 			</tr>
	 			<tr>
	 				<td colspan="2"></td>
	 				
	 				<td> <hr style="border: 1px black solid"></td>
	 			</tr>
	 			<tr>	 				
	 			<td colspan="2" align="right">Total Rp.</td>
	 			<td  align="right"><?=number_format($po->po_anggaran,0,',','.') ?></td>
	 			</tr>

	 			<tr>
	 				<td colspan="2"></td>
	 				<td> <hr style="border: 1px black double"></td>
	 			</tr>
	 		</tbody>
	 	</table>

	</td>
	</tr> 

	<tr>
		<td colspan="3" height="30px"></td>		
	</tr>
	<!-- <tr>
		<td align="center">Penerima</td>
		<td align="center">Pembayar</td>
		<td></td>		
	</tr>

	<tr>
		<td colspan="3" height="60px"></td>		
	</tr>

	<tr>
		<td align="center">Yazid</td>
		<td align="center">Lutfi</td>
		<td></td>		
	</tr> -->
</tbody></table></body>
</html>

<style>
  body{
    padding-left: 1.3cm;
    padding-right: 1.3cm; 
    padding-top: 1.1cm;
  }
</style>
<style type="text/css" media="print">
  @page {
    size: auto;  
    margin: 0;  
  }
</style>


<style media="print">
    @page 
    {
        size: auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
    }

    body 
    {
        background-color:#FFFFFF; 
        border: solid 1px black ;
        margin: 0px;  /* this affects the margin on the content before sending to printer */
   }
</style>

<style type="text/css" media="print">
	@media print 
{
   @page
   {
    size: 5.5in 8.5in ;
    size: landscape;
  }

}
@print{
    @page :footer {color: #fff }
    @page :header {color: #fff}
}




</style>