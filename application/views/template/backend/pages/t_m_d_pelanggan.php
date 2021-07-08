<div class="card">
  <div class="card-header">
    <h5>Master Pelanggan</h5>
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
            <th>Nama Pelanggan</th>
            <th>NIK</th>
            <th>NPWP</th>
            <th>Email</th>
            <th>No HP</th>
            <th>Alamat</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($c_t_m_d_pelanggan as $key => $value) 
          {
            if($value->MARK_FOR_DELETE == 'f')
            {
              echo "<tr>";
              echo "<td>".($key + 1)."</td>";
              echo "<td>".$value->PELANGGAN."</td>";
              echo "<td>".$value->NIK."</td>";
              echo "<td>".$value->NPWP."</td>";
              echo "<td>".$value->EMAIL."</td>";
              echo "<td>".$value->NO_TELP."</td>";
              echo "<td>".$value->ALAMAT."</td>";
            
              echo "<td>";
               
              echo "<a href='javascript:void(0);' data-toggle='modal' data-target='#Modal_Edit' class='btn-edit' data-id='".$value->ID."'>";
                echo "<i class='icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green'></i>";
              echo "</a>";

              echo "<a href='".site_url('c_t_m_d_pelanggan/delete/' . $value->ID)."' ";
              ?>
              onclick="return confirm('Apakah kamu yakin ingin menghapus data ini?')"
              <?php
              echo "> <i class='feather icon-trash-2 f-w-600 f-16 text-c-red'></i></a>";

              echo "</td>";


              echo "</tr>";
            }

            if($value->MARK_FOR_DELETE == 't')
            {
              echo "<tr>";
              echo "<td><s>".($key + 1)."</s></td>";
              echo "<td><s>".$value->PELANGGAN."</s></td>";
              echo "<td><s>".$value->NIK."</s></td>";
              echo "<td><s>".$value->NPWP."</s></td>";
              echo "<td><s>".$value->EMAIL."</s></td>";
              echo "<td><s>".$value->NO_TELP."</s></td>";
              echo "<td><s>".$value->ALAMAT."</s></td>";
            
              echo "<td>";
               
              

              echo "<a href='".site_url('c_t_m_d_pelanggan/undo_delete/' . $value->ID)."' ";
              ?>
              onclick="return confirm('Apakah kamu yakin ingin mengembalikan data ini?')"
              <?php
              echo "> <i class='fa fa-refresh f-w-600 f-16 text-c-red'></i></a>";

              echo ' '.$value->UPDATED_BY;
              echo "</td>";


              echo "</tr>";
            }
            

          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>




<!-- MODAL TAMBAH Beban! !-->
<form action="<?php echo base_url('c_t_m_d_pelanggan/tambah') ?>" method="post">
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
              <label>Nama Pelanggan</label>
              <input type='text' class='form-control' placeholder='Input Text' name='pelanggan'>
            </div>
            <div class="form-group">
              <label>NIK</label>
              <input type='text' class='form-control' placeholder='Input Text' name='nik'>
            </div>
            <div class="form-group">
              <label>NPWP</label>
              <input type='text' class='form-control' placeholder='Input Text' name='npwp'>
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type='text' class='form-control' placeholder='Input Text' name='email'>
            </div>
            <div class="form-group">
              <label>No Telp</label>
              <input type='text' class='form-control' placeholder='Input Text' name='no_telp'>
            </div>
            <div class="form-group">
              <label>Alamat</label>
              <input type='text' class='form-control' placeholder='Input Text' name='alamat'>
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
    <form action="<?php echo base_url('c_t_m_d_pelanggan/edit_action') ?>" method="post">
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
              <label>Nama Pelanggan</label>
              <input type='text' class='form-control' placeholder='Input Text' name='pelanggan'>
            </div>
            <div class="form-group">
              <label>NIK</label>
              <input type='text' class='form-control' placeholder='Input Text' name='nik'>
            </div>
            <div class="form-group">
              <label>NPWP</label>
              <input type='text' class='form-control' placeholder='Input Text' name='npwp'>
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type='text' class='form-control' placeholder='Input Text' name='email'>
            </div>
            <div class="form-group">
              <label>No Telp</label>
              <input type='text' class='form-control' placeholder='Input Text' name='no_telp'>
            </div>
            <div class="form-group">
              <label>Alamat</label>
              <input type='text' class='form-control' placeholder='Input Text' name='alamat'>
            </div>


          </div>
          <div class="modal-footer">
            <div class="created_form">
              Created By : <a name='created_by'></a>
              <br>
              Updated By : <a name='updated_by'></a>
            </div>
            <style type="text/css">
              .created_form
              {
                float: left;
                margin right: : 20px;
                font-size: 10px;
              }
            </style>
            <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
            <button type="Submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
          </div>

        </div>


<script>
  const users = <?= json_encode($c_t_m_d_pelanggan) ?>;
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
        PELANGGAN : pelanggan,
        NO_TELP : no_telp,
        ALAMAT : alamat,
        CREATED_BY : created_by,
        UPDATED_BY : updated_by,
        EMAIL : email,
        NIK : nik,
        NPWP : npwp
      } = User[0];

      elModalEdit.querySelector("[name=id]").value = ID;
      elModalEdit.querySelector("[name=pelanggan]").value = pelanggan;
      elModalEdit.querySelector("[name=no_telp]").value = no_telp;
      elModalEdit.querySelector("[name=alamat]").value = alamat;
      elModalEdit.querySelector("[name=created_by]").text = created_by;
      elModalEdit.querySelector("[name=updated_by]").text = updated_by;
      elModalEdit.querySelector("[name=email]").value = email;
      elModalEdit.querySelector("[name=nik]").value = nik;
      elModalEdit.querySelector("[name=npwp]").value = npwp;

    })
  })
</script>

    </form>
  </div>
</div>
<!-- MODAL EDIT AKUN! SELESAI !-->

