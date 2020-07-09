<html>
<head>
</head>
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
    size: A4;  
    margin: 0;  
  }
@media print {
  html, body {
    width: 210mm;
    height: 297mm;
  }
  /* ... the rest of the rules ... */
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
				
			<th colspan="3" width="60%">
				<div style="font-size:40px">TELAAHAN STAF</div>				
			</th>
				
		</tr>
		<tr><td colspan="3"><hr style="border: outset 2px black"></td></tr>
		<!-- <tr> 
			<td colspan="3" >
								<div align="center"> SURAT PERMOHONAN PERMINTAAN</div>
								<div align="center" style="font-style: bold"><?=$po['master']->po_type ?></div>
			</td>
		</tr> -->
		<tr>
			<td colspan="3">
				<table>
					<tr>
						<td>Kepada Yth.td</td>
						<td style="width: 1%">:</td>
						<td >  DIREKTUR  PD.Pasar Bauntung Batuah</td>

					</tr>
					<tr>
						<td>Dari</td>
						<td style="width: 1%">:</td>
						<td>Kepala Bidang Ketatausahaan</td>
					</tr>
					<tr>
						<td>Tanggal</td>
						<td style="width: 1%">:</td>
						<td><?=$po['master']->po_date ?></td>
					</tr>
					<tr>
						<td>Nomor</td>
						<td style="width: 1%">:</td>
						<td> <?=$po['master']->po_code_a ?>/PD.PBB/<?=$po['master']->year ?></td>
					</tr>
					<tr>
						<td style="vertical-align:top"><div >Perihal</div></td>
						<td style="width: 1%">:</td>
						<td><span><?=$po['master']->po_note ?></span></td>
					</tr>
					<tr>
						<td>Lampiran</td>
						<td style="width: 1%">:</td>
						<td>1  (Satu) Lembar.</td>
					</tr>
					<tr>
						<td style="vertical-align:top">Dasar</td>
						<td style="width: 1%;vertical-align:top">:</td>
						<td>
							<ul>
  <li>Peraturan Daerah Kabupaten Banjar Nomor 03 Tahun 2014 tentang Perusahaan Daerah Pasar Bauntung Batuah Atas Perubahan Peraturan Daerah Kabupaten Banjar Nomor 05 Tahun 2009 Tentang Perusahaan Daerah Pasar Bauntung Batuah Kabupaten Banjar</li>
  
  <li>Peraturan Bupati Banjar Nomor 41 Tahun 2014 tentang Susunan Organisasi dan Tata Kerja Perusahaan Daerah Pasar Bauntung Batuah Kabupaten Banjar</li>

  <li>Keputusan Bupati Nomor <?=$po['master']->k_sk_bupati ?> Tentang Pengesahan Rencana Kerja Dan Anggaran Perusahaan PD.Pasar Bauntung Batuah Kabupaten Banjar Tahun  2020;</li>

  <li>Keputusan Direktur  Nomor : <?=$po['master']->k_sk ?> ;</li>

  <li>Program dan Rencana Kerja Anggaran PD. Pasar Bauntung Batuah Kabupaten Banjar Tahun Anggaran 2020;</li>

  <li><?=$po['master']->a_name ?> Kode Anggaran <?=$po['master']->a_code ?></li>
</ul>
							  <!-- <table>
							  	<tr>
							  	<td style="vertical-align:top">*</td>
							  	<td>Peraturan Daerah Kabupaten Banjar Nomor 03 Tahun 2014 tentang Perusahaan Daerah Pasar Bauntung Batuah Atas Perubahan Peraturan Daerah Kabupaten Banjar Nomor 05 Tahun 2009 Tentang Perusahaan Daerah Pasar Bauntung Batuah Kabupaten Banjar; </td>
							  	</tr>
							
							  </table> -->
						</td>
					</tr>
				</table>
		
			</td>
		</tr>
		<tr> 
			<td colspan="3">
			<br>  
				<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php $result = str_replace(['<p>','</p>'],['',''],$po['master']->po_script); echo $result;  ?>
				</div>
				<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
Untuk ini kami mohon kepada Bapak Direktur agar kiranya dapat merekomendasikan biaya pengadaan pemeliharaan perawatan dan pendukung inventaris kantor pada Bidang Ketatausahaan dengan anggaran biaya sebesar Rp. <?=number_format($po['master']->po_anggaran,0,',','.') ?>,-(<?=$po['master']->terbilang ?> rupiah).	
				</div>
				<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demikian telaahan ini di buat, mohon petunjuk dan keputusannya.</div>
			</td>
		</tr>
		
		</tr>
		<tr>
			<td colspan="3">
				<table width="100%">
					<tr> 
						<th>
							Mengetahui <br>
					Kepala Bidang Ketatausahaan

						</th>
						<th>
						
						</th>
						<th>
							Pengawas Kegiatan <br> 
Kasubbid
						</th>
					</tr>
					<tr style="height: 100px"> 
						<th></th>
						<th></th>
						<th></th>
					</tr>
					<tr>
						<th>
							<div><?=$ttd->telaahan1; ?></div>
							<div>NIK. <?=$ttd->nik1; ?></div>
						</th>
						<th>
							
						</th>
						<th>
							<div><?=$ttd->telaahan2; ?></div>
							<div>NIK. <?=$ttd->nik2; ?></div>
						</th>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<table width="100%">
					<tr>						
						<td colspan="2">VERIFIKASI ANGGARAN</td>
						<td > </td>

					</tr>
					
					<tr>						
						<td style="width: 1%">1.</td>
						<td width="25%">Sisa Anggaran       </td>
						<td>: <?=number_format($po['master']->sisa_anggaran_acc,0,',','.') ?>,00</td>
						<td>Petugas Varifikasi</td>
					</tr>
					<tr>						
						<td style="width: 1%">2.</td>
						<td>Catatan              </td>
						<td>: ..................................</td>
						<td></td>
					</tr>
					<tr>
						<td style="width: 1%"></td>
						<td style="height: 100px"></td>
						<td></td>
						<td>
							<table>
								<td align="center">
							<div><?=$ttd->telaahan3; ?></div>
							<div>NIK. <?=$ttd->nik3; ?></div></td>
								<td> </td>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table width="100%" id="ttt">
					<th width="70%">Disposisi</th>
					<th>Direktur</th>
					<tr style="height: 200px">					
						<td></td>
						<td style="vertical-align:bottom;text-align: center;">
							<div><?=$ttd->telaahan4; ?></div>
							<div>NIK. <?=$ttd->nik4; ?></div>
						</td>
					</tr>
				</table>
			</td>
		</tr>


		
			</td>
		</tr>
	</tbody>
</table>
</body>
</html>