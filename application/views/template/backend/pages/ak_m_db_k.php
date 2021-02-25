
<div class="card">
  <div class="card-header">
    <h5>Master Debit/Kredit</h5>
  </div>
  <div class="card-block">
    <!-- Menampilkan notif !-->
    <?= $this->session->flashdata('notif') ?>
    <!-- Tombol untuk menambah data akun !-->
    <button data-toggle="modal" data-target="#addModal" class="btn btn-success waves-effect waves-light">New Data</button>

    <div class="table-responsive dt-responsive">
      <table id="dom-jqry" class="table table-striped table-bordered nowrap">
        <thead>
          <tr>
            <th>No</th>
            <th>Debit/Kredit Id</th>
            <th>Debit/Kredit</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($c_ak_m_db_k as $key => $value) 
          {
            echo "<tr>";
            echo "<td>".($key + 1)."</td>";
            echo "<td>".$value->DB_K_ID."</td>";
            echo "<td>".$value->DB_K."</td>";
          
            echo "<td>";
             
            echo "<a href='javascript:void(0);' data-toggle='modal' data-target='#Modal_Edit' class='btn-edit' data-id='".$value->ID."'>";
              echo "<i class='icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green'></i>";
            echo "</a>";

            echo "<a href='".site_url('c_ak_m_db_k/delete/' . $value->ID)."' ";
            ?>
            onclick="return confirm('Apakah kamu yakin ingin menghapus data ini?')"
            <?php
            echo "> <i class='feather icon-trash-2 f-w-600 f-16 text-c-red'></i></a>";

            echo "</td>";


            echo "</tr>";

          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>




<!-- MODAL TAMBAH Beban! !-->
<form action="<?php echo base_url('c_ak_m_db_k/tambah') ?>" method="post">
  <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">New Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="">

            <div class="form-group">
              <label>Debit/Kredit ID</label>
              <input type='text' class='form-control' placeholder='Harus Angka' name='db_k_id'>
            </div>

            <div class="form-group">
              <label>Debit/Kredit</label>
              <input type='text' class='form-control' placeholder='Input Text' name='db_k'>
            </div>

            

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
            <button type="Submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
<!-- MODAL TAMBAH AKUN! SELESAI !-->


<!-- MODAL EDIT AKUN !-->
<div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="<?php echo base_url('c_ak_m_db_k/edit_action') ?>" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="">

            <input type="hidden" name="id" value="" class="form-control">

            <div class="form-group">
              <label>Debit/Kredit ID</label>
              <input type='text' class='form-control' placeholder='Harus Angka' name='db_k_id'>
            </div>

            <div class="form-group">
              <label>Debit/Kredit</label>
              <input type='text' class='form-control' placeholder='Input Text' name='db_k'>
            </div>


          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
            <button type="Submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
          </div>

        </div>


<script>
  const users = <?= json_encode($c_ak_m_db_k) ?>;
  console.log(users);
  let elModalEdit = document.querySelector("#Modal_Edit");
  console.log(elModalEdit);
  let elBtnEdits = document.querySelectorAll(".btn-edit");
  [...elBtnEdits].forEach(edit => {
    edit.addEventListener("click", (e) => {
      let id = edit.getAttribute("data-id");
      let User = users.filter(user => {
        if (user.ID == id)
          return user;
      });
      const {
        ID,
        DB_K_ID : db_k_id,
        DB_K : db_k
      } = User[0];

      elModalEdit.querySelector("[name=id]").value = ID;
      elModalEdit.querySelector("[name=db_k_id]").value = db_k_id;
      elModalEdit.querySelector("[name=db_k]").value = db_k;

    })
  })
</script>

    </form>
  </div>
</div>
<!-- MODAL EDIT AKUN! SELESAI !-->

