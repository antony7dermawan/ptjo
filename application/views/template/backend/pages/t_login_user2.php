<div class="card">
  <div class="card-header">
    <h5>Daftar Level User</h5>
  </div>
  <div class="card-block">
    <!-- Menampilkan notif !-->
    <?= $this->session->flashdata('notif') ?>
    <!-- Tombol untuk menambah data akun !-->
    <button data-toggle="modal" data-target="#addModal" class="btn btn-success waves-effect waves-light">Tambah User</button>
    <div class="col-sm-12 col-xl-4 m-b-30">
<a class="btn waves-effect waves-light btn-warning btn-icon" href="<?php echo base_url('Excel/print_excel'); ?>"><i class="ti-printer"></i></a>
</div>

    <div class="table-responsive dt-responsive">
      <table id="dom-jqry" class="table table-striped table-bordered nowrap">
        <thead>
          <tr>
            <th>No</th>
            <th>Level User Id</th>
            <th>Company ID</th>
            <th>Username</th>
            <th>Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($c_t_login_user as $key => $value) {
          ?>
            <td><?php echo $key + 1; ?></td>
            <td><?php echo $value->LEVEL_USER_ID; ?></td>
            <td><?php echo $value->COMPANY_ID; ?></td>
            <td><?php echo $value->USERNAME; ?></td>
            <td><?php echo $value->NAME; ?></td>

            <td>
              <!--Edit-->
              <a href="javascript:void(0);" data-toggle="modal" data-target="#Modal_Edit" class="btn-edit" data-id="<?php echo $value->ID; ?>">
                <i class="icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green"></i>
              </a>

              <!--Hapus-->
              <a href="<?php echo site_url('c_t_login_user/delete/' . $value->ID) ?>" onclick="return confirm('Apakah kamu yakin ingin menghapus data ini?')"> <i class="feather icon-trash-2 f-w-600 f-16 text-c-red"></i></a>
            </td>


            </tr>
          <?php } ?>


          </tfoot>
      </table>
    </div>
  </div>
</div>




<!-- MODAL TAMBAH Beban! !-->
<form action="<?php echo base_url('c_t_login_user/tambah') ?>" method="post">
  <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah User</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="">

            <div class="form-group">
              <label>Name</label>
              <input type="text" class="form-control" name="name">
            </div>

            <div class="form-group">
              <label>Username</label>
              <input type="text" class="form-control" name="username">
            </div>

            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" name="password">
            </div>

            <div class="form-group">
              <label>Password 2</label>
              <input type="password" class="form-control" name="password2">
            </div>

            <div class="form-group">
              <label>Company ID</label>
              <input type="number" class="form-control" name="company_id">
            </div>

            <div class="form-group">
              <label>Level User ID</label>
              <input type="number" class="form-control" name="level_user_id">
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
    <form action="<?php echo base_url('c_t_login_user/edit_action') ?>" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit User</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="">

            <input type="hidden" name="id" value="" class="form-control">

            <div class="form-group">
              <label>Name</label>
              <input type="text" class="form-control" name="name">
            </div>

            <div class="form-group">
              <label>Username</label>
              <input type="text" class="form-control" name="username">
            </div>

            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" name="password">
            </div>

            <div class="form-group">
              <label>Password 2</label>
              <input type="password" class="form-control" name="password2">
            </div>

            <div class="form-group">
              <label>Company ID</label>
              <input type="number" class="form-control" name="company_id">
            </div>

            <div class="form-group">
              <label>Level User ID</label>
              <input type="number" class="form-control" name="level_user_id">
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
            <button type="Submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
          </div>

        </div>


<script>
  const users = <?= json_encode($c_t_login_user) ?>;
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
        NAME:name,
        USERNAME : username,
        PASSWORD : password,
        PASSWORD2 : password2,
        COMPANY_ID : company_id,
        LEVEL_USER_ID : level_user_id
      } = User[0];

      elModalEdit.querySelector("[name=id]").value = ID;
      elModalEdit.querySelector("[name=name]").value = name;
      elModalEdit.querySelector("[name=username]").value = username;
      elModalEdit.querySelector("[name=password]").value = password;
      elModalEdit.querySelector("[name=password2]").value = password2;
      elModalEdit.querySelector("[name=company_id]").value = company_id;
      elModalEdit.querySelector("[name=level_user_id]").value = level_user_id;

    })
  })
</script>

    </form>
  </div>
</div>
<!-- MODAL EDIT AKUN! SELESAI !-->

