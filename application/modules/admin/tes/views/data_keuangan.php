
<table class="table" width="100%">
  <th rowspan="3">Nama Akun</th>
  <th colspan="<?=count($keuangan['tgl']) ?>">Jumlah Rekap Keuangan Februari 2020</th>
  <tr>
    <th colspan="<?=count($keuangan['tgl']) ?>">Tanggal (Ribu)</th>
  </tr>
  <tr>
    <?php foreach ($keuangan['tgl'] as $key => $v) :?>
      <th><?=$v ?></th>
    <?php endforeach; ?>
  </tr>
  <tbody>
    <?php foreach ($keuangan['data'] as $key => $v) :?>
      <tr>
        <th><?=$key ?></th>
        <?php foreach ($keuangan['tgl'] as $key => $t) :?>
          
          <td><?=$v[$t] ?></td>
        <?php endforeach; ?>
      </tr>    
    <?php endforeach; ?>
  </tbody>
</table>
