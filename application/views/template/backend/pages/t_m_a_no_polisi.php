<div class="card">
  <div class="card-header">
    <h5>Master No Polisi</h5>
  </div>
  <div class="card-block">
    <!-- Menampilkan notif !-->
    <?= $this->session->flashdata('notif') ?>
    <!-- Tombol untuk menambah data akun !-->
    <?php
    if($this->session->userdata('level_user_id')==1)
    {
      ?>
        <table>
          <tr>
            <th>
              <input type='button' name='' class='btn btn-primary waves-effect waves-light' onclick='receive_from_cloud()' value='Receive From Cloud'>


                <script>
                function receive_from_cloud()
                {
                  if(confirm('Yakin Untuk Menarik Data?!?'))
                  {
                    window.open('receive_cloud/receive_t_m_a_no_polisi');
                  }
                  
                }
                </script>
              </th>
          </tr>
        </table>
      <?php
    }
    ?>


    <div class="table-responsive dt-responsive">
      <table id="dom-jqry" class="table table-striped table-bordered nowrap">
        <thead>
          <tr>
            <th>No</th>
            <th>No Polisi Id</th>
            <th>No Polisi</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($c_t_m_a_no_polisi as $key => $value) 
          {
            echo "<tr>";
            echo "<td>".($key + 1)."</td>";
            echo "<td>".$value->NO_POLISI_ID."</td>";
            echo "<td>".$value->NO_POLISI."</td>";
          
            echo "<td>";
            
            /*
            echo "<a href='javascript:void(0);' data-toggle='modal' data-target='#Modal_Edit' class='btn-edit' data-id='".$value->ID."'>";
              echo "<i class='icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green'></i>";
            echo "</a>";

            echo "<a href='".site_url('c_t_m_a_no_polisi/delete/' . $value->ID)."' ";
            ?>
            onclick="return confirm('Apakah kamu yakin ingin menghapus data ini?')"
            <?php
            echo "> <i class='feather icon-trash-2 f-w-600 f-16 text-c-red'></i></a>";
            */
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
<form action="<?php echo base_url('c_t_m_a_no_polisi/tambah') ?>" method="post">
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
              <label>No Polisi ID</label>
              <input type='text' class='form-control' placeholder='Harus Angka' name='no_polisi_id'>
            </div>

            <div class="form-group">
              <label>No Polisi</label>
              <input type='text' class='form-control' placeholder='Input Text' name='no_polisi'>
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
    <form action="<?php echo base_url('c_t_m_a_no_polisi/edit_action') ?>" method="post">
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
              <label>No Polisi ID</label>
              <input type='text' class='form-control' placeholder='Harus Angka' name='no_polisi_id'>
            </div>

            <div class="form-group">
              <label>No Polisi</label>
              <input type='text' class='form-control' placeholder='Input Text' name='no_polisi'>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
            <button type="Submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
          </div>

        </div>


<script>
  const users = <?= json_encode($c_t_m_a_no_polisi) ?>;
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
        NO_POLISI_ID : no_polisi_id,
        NO_POLISI : no_polisi
      } = User[0];

      elModalEdit.querySelector("[name=id]").value = ID;
      elModalEdit.querySelector("[name=no_polisi_id]").value = no_polisi_id;
      elModalEdit.querySelector("[name=no_polisi]").value = no_polisi;

    })
  })
</script>

    </form>
  </div>
</div>
<!-- MODAL EDIT AKUN! SELESAI !-->

