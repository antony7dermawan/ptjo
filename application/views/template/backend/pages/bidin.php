<div class="card">
  <div class="card-header">
    <h5>Daftar Pemasukan</h5>
  </div>
  <div class="card-block">
    <!-- Menampilkan notif !-->
    <?= $this->session->flashdata('notif') ?>
    <!-- Tombol untuk menambah data akun !-->
    <button data-toggle="modal" data-target="#addModal" class="btn btn-success waves-effect waves-light">Tambah Pemasukan</button>

    <div class="table-responsive dt-responsive">
      <table id="dom-jqry" class="table table-striped table-bordered nowrap">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode Pemasukan</th>
            <th>Tanggal</th>
            <th>Jenis Pemasukan</th>
            <th>Nominal</th>
            <th>Keterangan</th>
            <th>Aksi</th>
          </tr> 
        </thead>
        <tbody>

          <?php
          foreach ($C_Pemasukan as $key => $value) {
          ?>
            <td><?php echo $key + 1; ?></td>
            <td><?php echo $value->kode_transaksi; ?></td>
            <td><?php echo $value->tanggal_transaksi; ?></td>
            <td><?php echo $value->nama_akun2; ?></td>
            <td><p class="kanan"><?php echo rupiah($value->debit); ?></p></td>
            <td><?php echo $value->ket_transaksi; ?></td>
            <td>
              <!--Edit-->
              <a href="javascript:void(0);" data-toggle="modal" data-target="#Modal_Edit" class="btn-edit" data-id="<?php echo $value->id_transaksi; ?>">
                <i class="icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green"></i>
              </a>

              <!--Hapus-->
              <a href="<?php echo site_url('C_Pemasukan/delete/' . $value->id_transaksi) ?>" onclick="return confirm('Apakah kamu yakin ingin menghapus data ini?')"> <i class="feather icon-trash-2 f-w-600 f-16 text-c-red"></i></a>
            </td>


            </tr>
          <?php } ?>


          </tfoot>
      </table>

    </div>
  </div>
</div>




<!-- MODAL TAMBAH PEMASUKAN! !-->
<form action="<?php echo base_url('C_Pemasukan/tambah') ?>" method="post">
  <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Pemasukan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="row">
           <div class="col-md-6">

            <fieldset class="form-group">
              <label>Kode Periode</label>
              <?php foreach($periodes as $row) : ?>
              <input type="hidden" class="form-control" id="periode" name="periode" value="<?= $row->id_periode; ?>" readonly>
              <input type="text" class="form-control" value="<?= $row->kode_periode; ?>"<?php echo $row->kode_periode; ?> readonly>
              <?php endforeach; ?>
           </fieldset> 

            <fieldset class="form-group">
              <label>Kode Pemasukan</label>
              <input type="text" class="form-control" id="kode_transaksi" name="kode_transaksi" value="PM<?php echo sprintf("%04s", $kode_masuk) ?>" readonly>
            </fieldset>

            <fieldset class="form-group">
              <label>Jenis Pemasukan (Debit) </label>
              <select name="rid_akun_debit" class="form-control" value="rid_akun_debit">
                <?php
                $groupid = 001;
                $star = false;
                foreach ($kasbank as $row) : ?>
                  <?php if ($row->id_akun1 != $groupid) : ?>
                    <?= $star ? "</optgroup>" : ''; ?>
                    <optgroup label="<?= $row->nama_akun1; ?>">
                      <option class="rid_akun_debit" value="<?= $row->id_akun2; ?>"><?php echo $row->kode_akun2 . ' ' . '-' . ' ' . $row->nama_akun2; ?></option>
                      <?php $groupid = $row->id_akun1;
                      $start = true; ?>
                    <?php else : ?>
                      <option class="rid_akun_debit" value="<?= $row->id_akun2; ?>"><?php echo $row->kode_akun2 . ' ' . '-' . ' ' . $row->nama_akun2; ?></option>
                  <?php endif;
                endforeach; ?>
                    </optgroup>
              </select>
            </fieldset>

          </div> 

          <div class="col-md-6">

            <fieldset class="form-group">
              <label>Tanggal Pemasukan</label>
              <input type="date" placeholder="yyyy-mm-dd" class="form-control datepicker" name="tanggal_transaksi">
            </fieldset>

            <fieldset class="form-group">
              <label>Nominal</label>
              <input type="text" class="form-control" name="debit" placeholder="Debit">
            </fieldset>

            <fieldset class="form-group">
              <label>Di Kreditkan Kepada</label>
              <select name="rid_akun_kredit" class="form-control" value="rid_akun_kredit">
                <?php
                $groupid = 001;
                $star = false;
                foreach ($pemasukans as $row) : ?>
                  <?php if ($row->id_akun1 != $groupid) : ?>
                    <?= $star ? "</optgroup>" : ''; ?>
                    <optgroup label="<?= $row->nama_akun1; ?>">
                      <option class="rid_akun_kredit" value="<?= $row->id_akun2; ?>"><?php echo $row->kode_akun2 . ' ' . '-' . ' ' . $row->nama_akun2; ?></option>
                      <?php $groupid = $row->id_akun1;
                      $start = true; ?>
                    <?php else : ?>
                      <option class="rid_akun_kredit" value="<?= $row->id_akun2; ?>"><?php echo $row->kode_akun2 . ' ' . '-' . ' ' . $row->nama_akun2; ?></option>
                  <?php endif;
                endforeach; ?>
                    </optgroup>
              </select>
            </fieldset>

            <fieldset class="form-group">
              <label>Keterangan</label>
              <input type="text" class="form-control" name="ket_transaksi" placeholder="Keterangan">
            </fieldset>

            <input type="text" hidden="" name="jenis_transaksi" value="1" placeholder="jenisnya apa">

          </div><!-- Membungkus Row Kedua !-->
        </div> <!-- Membungkus Row !-->
        </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
            <button type="Submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
          </div>
      </div>
    </div>
  </div>
</form>
<!-- MODAL TAMBAH PEMASUKAN SELESAI !-->


<!-- MODAL EDIT PEMASUKAN !-->
<div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="<?php echo base_url('C_Pemasukan/edit_action') ?>" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Pemasukan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="row">
          <div class="col-md-6">

          <fieldset>
          <input type="text" class="form-control" hidden="" name="id_transaksi" value="">
          </fieldset>

          <fieldset class="form-group">
            <label>Kode Periode</label>
            <?php foreach($periodes as $row) : ?>
            <input type="hidden" class="form-control" id="periode" name="periode" value="<?= $row->id_periode; ?>" readonly>
            <input type="text" class="form-control" value="<?= $row->kode_periode; ?>"<?php echo $row->kode_periode; ?> readonly>
            <?php endforeach; ?>
          </fieldset>

          <fieldset class="form-group">
          <label>Kode Pemasukan</label>
          <input type="text" class="form-control" id="kode_transaksi" name="kode_transaksi" value="PM<?php echo sprintf("%04s", $kode_masuk) ?>" readonly>
          </fieldset>

          <fieldset class="form-group">
            <label>Jenis Pemasukan (Debit)</label>
            <select name="rid_akun_debit" class="form-control" value="rid_akun_debit">
              <?php
              $groupid = 001;
              $star = false;
              foreach ($kasbank as $row) : ?>
                <?php if ($row->id_akun1 != $groupid) : ?>
                  <?= $star ? "</optgroup>" : ''; ?>
                  <optgroup label="<?= $row->nama_akun1; ?>">
                    <option class="rid_akun_debit" value="<?= $row->id_akun2; ?>"><?php echo $row->kode_akun2 . ' ' . '-' . ' ' . $row->nama_akun2; ?></option>
                    <?php $groupid = $row->id_akun1;
                    $start = true; ?>
                  <?php else : ?>
                    <option class="rid_akun_debit" value="<?= $row->id_akun2; ?>"><?php echo $row->kode_akun2 . ' ' . '-' . ' ' . $row->nama_akun2; ?></option>
                <?php endif;
              endforeach; ?>
                  </optgroup>
            </select>
          </fieldset>

          </div><!-- Membungkus Col md 6 !-->

          <div class="col-md-6">

          <fieldset class="form-group">
          <label>Tanggal Pemasukan</label>
          <input type="date" class="form-control" name="tanggal_transaksi">
          </fieldset>

          <fieldset class="form-group">
          <label>Nominal Pemasukan</label>
          <input type="text" class="form-control" name="debit" placeholder="Nominal Pemasukan">
          </fieldset>

          <fieldset class="form-group">
            <label>Di Kreditkan Kepada</label>
            <select name="rid_akun_kredit" class="form-control" value="rid_akun_kredit">
              <?php
              $groupid = 001;
              $star = false;
              foreach ($pemasukans as $row) : ?>
                <?php if ($row->id_akun1 != $groupid) : ?>
                  <?= $star ? "</optgroup>" : ''; ?>
                  <optgroup label="<?= $row->nama_akun1; ?>">
                    <option class="rid_akun_kredit" value="<?= $row->id_akun2; ?>"><?php echo $row->kode_akun2 . ' ' . '-' . ' ' . $row->nama_akun2; ?></option>
                    <?php $groupid = $row->id_akun1;
                    $start = true; ?>
                  <?php else : ?>
                    <option class="rid_akun_kredit" value="<?= $row->id_akun2; ?>"><?php echo $row->kode_akun2 . ' ' . '-' . ' ' . $row->nama_akun2; ?></option>
                <?php endif;
              endforeach; ?>
                  </optgroup>
            </select>
          </fieldset>

          <fieldset class="form-group">
          <label>Keterangan</label>
          <input type="text" class="form-control" name="ket_transaksi" placeholder="Keterangan">
          </fieldset>
        </div><!-- Membungkus Col md 6 !-->

          </div><!-- Membungkus Row !-->
        </div><!-- Membungkus Body !-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
          <button type="Submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- MODAL EDIT AKUN! SELESAI !-->


<!-- SCRIPT UNTUK DATA EDIT !-->
<script>
  const kasbank = <?= json_encode($C_Pemasukan) ?>;
  const pemasukans = <?= json_encode($C_Pemasukan) ?>;
  const rids = <?= json_encode($kasbank) ?>;
  const rids1 = <?= json_encode($pemasukans) ?>;
  let elModalEdit = document.querySelector("#Modal_Edit");
  console.log(elModalEdit);
  let elBtnEdits = document.querySelectorAll(".btn-edit");
  [...elBtnEdits].forEach(edit => {
    edit.addEventListener("click", (e) => {
      let id = edit.getAttribute("data-id");
      let Beban = kasbank.filter(beban => {
        if (beban.id_transaksi == id)
          return beban;
      });
      const {
        id_transaksi,
        tanggal_transaksi,
        rid_akun_debit,
        rid_akun_kredit,
        debit,
        ket_transaksi,
        rid_kredit,
        id_akun2,
        kode_transaksi,
        periode
      } = Beban[0];

      console.log(Beban[0]);
      elModalEdit.querySelector("[name=id_transaksi]").value = id_transaksi;
      elModalEdit.querySelector("[name=tanggal_transaksi]").value = tanggal_transaksi;
      elModalEdit.querySelector("[name=debit]").value = debit;
      elModalEdit.querySelector("[name=ket_transaksi]").value = ket_transaksi;
      elModalEdit.querySelector("[name=kode_transaksi]").value = kode_transaksi;
      elModalEdit.querySelector("[name=periode]").value = periode;
      let elOptRids = elModalEdit.querySelectorAll("option.rid_akun_debit");

      [...elOptRids].forEach(rid => {
        let idRid = rid.getAttribute("value");
        if (rid.getAttribute("value") == id_akun2) {
          rid.setAttribute("selected", 'selected')
        }
      })

      let elOptRidsKredit = elModalEdit.querySelectorAll("option.rid_akun_kredit");
      [...elOptRidsKredit].forEach(rid => {
        let idRid = rid.getAttribute("value");
        if (rid.getAttribute("value") == rid_kredit) {
          rid.setAttribute("selected", 'selected')
        }
      })
    })
  })
</script>


<!-- Untuk rupiah pemisah angka koma dan RP !-->
<?php

function rupiah($angka)
{

  $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
  return $hasil_rupiah;
}
?>