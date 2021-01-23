<!--Hari ini tanggal <?php echo date("F j, Y, g:i a"); ?> !-->

Hari Ini tanggal <?php echo date("j F Y, g:i a "); ?>
<br /><br />
<div class="row">
<!-- UNTUK CARD PERTAMA !-->


</div>


    <!-- KONTEN INFO !-->
<div class="card">
  <div class="card-header">
    <h5>Info</h5>
  </div>
  <div class="card-block">
<div class="card list-view-media">
<div class="card-block">
<div class="media">
<a class="media-left" href="#">
<img class="media-object card-list-img"  style="width:125px; height:125px" src="<?= base_url('assets/images/'.$this->session->userdata('photo')); ?>">
</a>
<div class="media-body">
<div class="col-xs-12">
<h6 class="d-inline-block">
 <?php echo $this->session->userdata('nama') ?>
<label class="label label-info"><?php echo $this->session->userdata('role') ?></label>
</div>
<div class="f-13 text-muted m-b-15">
 <?php echo $this->session->userdata('email') ?>
</div>

<?php
// Cek role user
if($this->session->userdata('role') == 'bendahara'){ // Jika role-nya admin
    ?>
   <p>Bendahara berwenang untuk merekam transaksi yang terjadi di Sekolah Insan Teladan Pekanbaru</p>
    <?php
}else{ // Jika role-nya operator
    ?>
  <p> Yayasan memantau alur keuangan dan transaksi yang terjadi di Sekolah Insan Teladan Pekanbaru </p>
    <?php
}
?>

</div>
</div>
</div>
</div>


    </div>
  </div>

<!-- Untuk rupiah pemisah angka koma dan RP !-->
<?php

function rupiah($angka)
{

  $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
  return $hasil_rupiah;
}
?>