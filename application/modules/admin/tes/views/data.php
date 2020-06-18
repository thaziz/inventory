<?php 
foreach ($data as $key => $value): ?>
  <div class="col-md-12">
    <table class="table" width="100%">
      <th>Nama Sekolah</th>
      <td><?=$value['kls']; ?></td>  
      <th>Alamat Sekolah</th>
      <td><?=$value['alamat']; ?> </td>
      <th>Telpon sekolah</th>
      <td><?=$value['tlp']; ?> </td>
    </table>
  </div>
  <br>

  
  <?php if(isset($value['siswa'])): ?>
    <div class="col-md-12">
     <table class="table" width="100%">
      <th>Nis</th>
      <th>Nama</th>
      <th>Tgl Lahir</th>      
      
      <?php foreach ($value['siswa'] as $k => $v): ?>
        <tr>
          <td><?=$v['nis']; ?></td>
          <td><?=$v['nama']; ?></td>
          <td><?=$v['tgl_lahir']; ?></td>
          
        </tr>
        
      <?php endforeach ?>
    </table>
  </div>

<?php endif; ?>


<?php if(isset($value['siswa'])==false): ?>
  <div class="col-md-12">
   <table class="table" width="100%">
    <thead>
      <th>Nis</th>
      <th>Nama</th>
      <th>Tgl Lahir</th>      
    </thead>
    <tbody>
      <tr>
        <td colspan="3" align="center">Tidak ada data siswa</td>
      </tr>
    </tbody>
  </table>
</div>

<?php endif; ?>
<?php endforeach ?>
