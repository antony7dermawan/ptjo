<div class="card">
  <div class="card-header">

    
    

    <form action='<?php echo base_url("c_t_m_d_barang/change_company_id"); ?>' class='' method="post" id=''>

    <label>Pilih Gudang:</label>

    <select name="company_id" class='' onchange='this.form.submit();' id='select-state' placeholder='Pick a state...'>

      <?php
      foreach ($c_t_m_d_company as $key => $value) 
      {
              if($this->session->userdata('master_barang_company_id')==$value->ID)
              {
                echo "<option value='".$value->ID."' selected>".$value->COMPANY."</option>";
              }
              else
              {
                echo "<option value='".$value->ID."'>".$value->COMPANY."</option>";
              }
              

      }
      ?>
    </select>
    </form>
    <br>

    <form action='<?php echo base_url("c_t_m_d_barang/change_kategori_id"); ?>' class='' method="post" id=''>
    <label>Pilih Kategori:</label>

    <select name="kategori_id" class='' onchange='this.form.submit();' id='select-state' placeholder='Pick a state...'>
      <option value='0'>Semua</option>
      <?php
      foreach ($c_t_m_d_kategori as $key => $value) 
      {
              if($this->session->userdata('master_barang_kategori_id')==$value->ID)
              {
                echo "<option value='".$value->ID."' selected>".$value->KATEGORI."</option>";
              }
              else
              {
                echo "<option value='".$value->ID."'>".$value->KATEGORI."</option>";
              }
              

      }
      ?>
    </select>
    </form>
          

      


    
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
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Merk Barang</th>
            <th>Part Number</th>
            <th>Posisi</th>
            <th>Satuan</th>
            <th>Harga Jual</th>
            <th>Min Stok</th>
            <th>Kategori</th>
            <th>Jenis Barang</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($c_t_m_d_barang as $key => $value) 
          {
            if($value->MARK_FOR_DELETE == 'f')
            {
              echo "<tr>";
              echo "<td>".($key + 1)."</td>";
              echo "<td>".$value->KODE_BARANG."</td>";
              echo "<td>".$value->BARANG."</td>";
              echo "<td>".$value->MERK_BARANG."</td>";
              echo "<td>".$value->PART_NUMBER."</td>";
              echo "<td>".$value->POSISI."</td>";
              echo "<td>".$value->SATUAN."</td>";
              echo "<td>" . number_format(floatval(intval($value->HARGA_JUAL*100))/100) . "</td>";
              echo "<td>".$value->MINIMUM_STOK."</td>";
              echo "<td>".$value->KATEGORI."</td>";
              echo "<td>".$value->JENIS_BARANG."</td>";
            
              echo "<td>";
              

              echo "<a href='javascript:void(0);' data-toggle='modal' data-target='#Modal_Edit_forward' class='btn-edit_forward' data-id='".$value->ID."'>";
                echo "<i class='fa fa-mail-forward f-w-600 f-16 m-r-15 text-c-black'></i>";
              echo "</a>";


              echo "<a href='javascript:void(0);' data-toggle='modal' data-target='#Modal_Edit' class='btn-edit' data-id='".$value->ID."'>";
                echo "<i class='icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green'></i>";
              echo "</a>";

              echo "<a href='".site_url('c_t_m_d_barang/delete/' . $value->ID)."' ";
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
              echo "<td><s>".$value->KODE_BARANG."</s></td>";
              echo "<td><s>".$value->BARANG."</s></td>";
              echo "<td><s>".$value->MERK_BARANG."</s></td>";
              echo "<td><s>".$value->PART_NUMBER."</s></td>";
              echo "<td><s>".$value->POSISI."</s></td>";
              echo "<td><s>".$value->SATUAN."</s></td>";
              echo "<td><s>".$value->HARGA_JUAL."</s></td>";
              echo "<td><s>".$value->MINIMUM_STOK."</s></td>";
              echo "<td><s>".$value->KATEGORI."</s></td>";
              echo "<td><s>".$value->JENIS_BARANG."</s></td>";
            
              echo "<td>";
               
              



              echo "<a href='".site_url('c_t_m_d_barang/undo_delete/' . $value->ID)."' ";
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
<form action="<?php echo base_url('c_t_m_d_barang/tambah') ?>" method="post">
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
              <label>Kategori</label>
              <select name="kategori_id" class='custom_width' id='select-state' placeholder='Pick a state...'>
              <?php
              foreach ($c_t_m_d_kategori as $key => $value) 
              {
                echo "<option value='".$value->ID."'>".$value->KATEGORI."</option>";

              }
              ?>
              </select>
            </div>

            <div class="form-group">
              <label>Kode Barang</label>
              <input type='text' class='form-control' placeholder='Input Text' name='kode_barang'>
            </div>
            <div class="form-group">
              <label>Nama Barang</label>
              <input type='text' class='form-control' placeholder='Input Text' name='barang'>
            </div>
            <div class="form-group">
              <label>Merk Barang</label>
              <input type='text' class='form-control' placeholder='Input Text' name='merk_barang'>
            </div>
            <div class="form-group">
              <label>Part Number</label>
              <input type='text' class='form-control' placeholder='Input Text' name='part_number'>
            </div>
            <div class="form-group">
              <label>Posisi</label>
              <input type='text' class='form-control' placeholder='Input Text' name='posisi'>
            </div>
            <div class="form-group">
              <label>Satuan</label>
              <select name="satuan_id" class='custom_width' id='select-state' placeholder='Pick a state...'>
              <?php
              foreach ($c_t_m_d_satuan as $key => $value) 
              {
                echo "<option value='".$value->ID."'>".$value->SATUAN."</option>";

              }
              ?>
              </select>
            </div>

            <div class="form-group">
              <label>Jenis Barang</label>
              <select name="jenis_barang_id" class='custom_width' id='select-state' placeholder='Pick a state...'>
              <?php
              foreach ($c_t_m_d_jenis_barang as $key => $value) 
              {
                echo "<option value='".$value->ID."'>".$value->JENIS_BARANG."</option>";

              }
              ?>
              </select>
            </div>


            <div class="form-group">
              <label>Harga Jual</label>
              <input type='text' class='form-control' placeholder='Input Number' name='harga_jual'>
            </div>
            <div class="row">
              <div class="col-md-6">

                <fieldset class="form-group">
                  <label>Minimum Stok</label>
                  <input type='text' class='form-control' placeholder='Input Number' name='minimum_stok'>
                </fieldset>

              </div><!-- Membungkus Row Kedua !-->


              <div class="col-md-6">

                <fieldset class="form-group">
                  <label>Maximum Stok</label>
                  <input type='text' class='form-control' placeholder='Input Number' name='maximum_stok'>
                </fieldset>
              </div> <!-- Membungkus Row !-->
            
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
<div class="modal fade" id="Modal_Edit_forward" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="<?php echo base_url('c_t_m_d_barang/pinlok_company_id') ?>" autocomplete="off" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Move ID</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="">

            <input type="hidden" name="id" value="" class="form-control">


            <div class="form-group">
              <label>Company Tujuan</label>


              <div class="searchable">
                  <input type="text" name='company' placeholder="search" onkeyup="filterFunction(this,event)">
                  <ul>
                    <?php
                    foreach ($c_t_m_d_company as $key => $value) 
                    {
                      echo "<li>".$value->COMPANY."</li>";
                    }
                    ?>
                  </ul>
              </div>
            </div>



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
  const read_db_2 = <?= json_encode($c_t_m_d_barang) ?>;
  console.log(read_db_2);
  let elModalEdit_2 = document.querySelector("#Modal_Edit_forward");
  console.log(elModalEdit_2);
  let elBtnEdits_2 = document.querySelectorAll(".btn-edit_forward");
  [...elBtnEdits_2].forEach(taik => {
    taik.addEventListener("click", (e) => {
      let id = taik.getAttribute("data-id");
      let User = read_db_2.filter(user => {
        if (user.ID == id)
          return user;
      });
      const {
        ID,

        COMPANY : company,
        UPDATED_BY : updated_by,
        CREATED_BY : created_by
        
      } = User[0];

      elModalEdit_2.querySelector("[name=id]").value = ID;
      elModalEdit_2.querySelector("[name=company]").value = company;
      elModalEdit_2.querySelector("[name=updated_by]").text = updated_by;
      elModalEdit_2.querySelector("[name=created_by]").text = created_by;

    })
  })
</script>

    </form>
  </div>
</div>
<!-- MODAL EDIT AKUN! SELESAI !-->




<!-- MODAL EDIT AKUN !-->
<div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="<?php echo base_url('c_t_m_d_barang/edit_action') ?>" autocomplete="off" method="post">
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
              <label>Kategori</label>


              <div class="searchable">
                  <input type="text" name='kategori' placeholder="search" onkeyup="filterFunction(this,event)">
                  <ul>
                    <?php
                    foreach ($c_t_m_d_kategori as $key => $value) 
                    {
                      echo "<li>".$value->KATEGORI."</li>";
                    }
                    ?>
                  </ul>
              </div>
            </div>


            <div class="form-group">
              <label>Kode Barang</label>
              <input type='text' class='form-control' placeholder='Input Text' name='kode_barang'>
            </div>
            <div class="form-group">
              <label>Nama Barang</label>
              <input type='text' class='form-control' placeholder='Input Text' name='barang'>
            </div>
            <div class="form-group">
              <label>Merk Barang</label>
              <input type='text' class='form-control' placeholder='Input Text' name='merk_barang'>
            </div>
            <div class="form-group">
              <label>Part Number</label>
              <input type='text' class='form-control' placeholder='Input Text' name='part_number'>
            </div>
            <div class="form-group">
              <label>Posisi</label>
              <input type='text' class='form-control' placeholder='Input Text' name='posisi'>
            </div>

            <div class="form-group">
              <label>Satuan</label>


              <div class="searchable">
                  <input type="text" name='satuan' placeholder="search" onkeyup="filterFunction(this,event)">
                  <ul>
                    <?php
                    foreach ($c_t_m_d_satuan as $key => $value) 
                    {
                      echo "<li>".$value->SATUAN."</li>";
                    }
                    ?>
                  </ul>
              </div>
            </div>

             <div class="form-group">
              <label>Jenis Barang</label>


              <div class="searchable">
                  <input type="text" name='jenis_barang' placeholder="search" onkeyup="filterFunction(this,event)">
                  <ul>
                    <?php
                    foreach ($c_t_m_d_jenis_barang as $key => $value) 
                    {
                      echo "<li>".$value->JENIS_BARANG."</li>";
                    }
                    ?>
                  </ul>
              </div>
            </div>

            <div class="form-group">
              <label>Harga Jual</label>
              <input type='text' class='form-control' placeholder='Input Number' name='harga_jual'>
            </div>
            

            <div class="row">
              <div class="col-md-6">

                <fieldset class="form-group">
                  <label>Minimum Stok</label>
                  <input type='text' class='form-control' placeholder='Input Number' name='minimum_stok'>
                </fieldset>

              </div><!-- Membungkus Row Kedua !-->


              <div class="col-md-6">

                <fieldset class="form-group">
                  <label>Maximum Stok</label>
                  <input type='text' class='form-control' placeholder='Input Number' name='maximum_stok'>
                </fieldset>
              </div> <!-- Membungkus Row !-->
            
            </div>

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
  const users = <?= json_encode($c_t_m_d_barang) ?>;
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

        KODE_BARANG : kode_barang,
        BARANG : barang,
        MERK_BARANG : merk_barang,
        PART_NUMBER : part_number,
        POSISI : posisi,
        HARGA_JUAL : harga_jual,
        MINIMUM_STOK : minimum_stok,
        KATEGORI : kategori,
        SATUAN : satuan,
        UPDATED_BY : updated_by,
        CREATED_BY : created_by,
        MAXIMUM_STOK : maximum_stok,
        JENIS_BARANG : jenis_barang
        
      } = User[0];

      elModalEdit.querySelector("[name=id]").value = ID;
      elModalEdit.querySelector("[name=kode_barang]").value = kode_barang;
      elModalEdit.querySelector("[name=barang]").value = barang;
      elModalEdit.querySelector("[name=merk_barang]").value = merk_barang;
      elModalEdit.querySelector("[name=part_number]").value = part_number;
      elModalEdit.querySelector("[name=posisi]").value = posisi;
      elModalEdit.querySelector("[name=harga_jual]").value = harga_jual;
      elModalEdit.querySelector("[name=minimum_stok]").value = minimum_stok;
      elModalEdit.querySelector("[name=satuan]").value = satuan;
      elModalEdit.querySelector("[name=updated_by]").text = updated_by;
      elModalEdit.querySelector("[name=created_by]").text = created_by;
      elModalEdit.querySelector("[name=kategori]").value = kategori;
      elModalEdit.querySelector("[name=maximum_stok]").value = maximum_stok;
      elModalEdit.querySelector("[name=jenis_barang]").value = jenis_barang;

    })
  })
</script>

    </form>
  </div>
</div>
<!-- MODAL EDIT AKUN! SELESAI !-->







































<script type="text/javascript">
    $(document).ready(function () {
      $('select').selectize({
          sortField: 'text'
      });
  });
</script>





<style type="text/css">
    div.searchable {
    width: 100%;
    
}

.searchable input {
    width: 100%;
    height: 30px;
    font-size: 14px;
    padding: 10px;
    -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
    -moz-box-sizing: border-box; /* Firefox, other Gecko */
    box-sizing: border-box; /* Opera/IE 8+ */
    display: block;
    font-weight: 400;
    line-height: 1.6;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    background: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3E%3C/svg%3E") no-repeat right .75rem center/8px 10px;
}

.searchable ul {
    display: none;
    list-style-type: none;
    background-color: #fff;
    border-radius: 0 0 5px 5px;
    border: 1px solid #add8e6;
    border-top: none;
    max-height: 180px;
    margin: 0;
    overflow-y: scroll;
    overflow-x: hidden;
    padding: 0;
}

.searchable ul li {
    padding: 7px 9px;
    border-bottom: 1px solid #e1e1e1;
    cursor: pointer;
    color: #6e6e6e;
}

.searchable ul li.selected {
    background-color: #e8e8e8;
    color: #333;
}
</style>



<script type="text/javascript">
    
    function filterFunction(that, event) {
    let container, input, filter, li, input_val;
    container = $(that).closest(".searchable");
    input_val = container.find("input").val().toUpperCase();

    if (["ArrowDown", "ArrowUp", "Enter"].indexOf(event.key) != -1) {
        keyControl(event, container)
    } else {
        li = container.find("ul li");
        li.each(function (i, obj) {
            if ($(this).text().toUpperCase().indexOf(input_val) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        container.find("ul li").removeClass("selected");
        setTimeout(function () {
            container.find("ul li:visible").first().addClass("selected");
        }, 100)
    }
}

function keyControl(e, container) {
    if (e.key == "ArrowDown") {

        if (container.find("ul li").hasClass("selected")) {
            if (container.find("ul li:visible").index(container.find("ul li.selected")) + 1 < container.find("ul li:visible").length) {
                container.find("ul li.selected").removeClass("selected").nextAll().not('[style*="display: none"]').first().addClass("selected");
            }

        } else {
            container.find("ul li:first-child").addClass("selected");
        }

    } else if (e.key == "ArrowUp") {

        if (container.find("ul li:visible").index(container.find("ul li.selected")) > 0) {
            container.find("ul li.selected").removeClass("selected").prevAll().not('[style*="display: none"]').first().addClass("selected");
        }
    } else if (e.key == "Enter") {
        container.find("input").val(container.find("ul li.selected").text()).blur();
        onSelect(container.find("ul li.selected").text())
    }

    container.find("ul li.selected")[0].scrollIntoView({
        behavior: "smooth",
    });
}



$(".searchable input").focus(function () {
    $(this).closest(".searchable").find("ul").show();
    $(this).closest(".searchable").find("ul li").show();
});
$(".searchable input").blur(function () {
    let that = this;
    setTimeout(function () {
        $(that).closest(".searchable").find("ul").hide();
    }, 300);
});

$(document).on('click', '.searchable ul li', function () {
    $(this).closest(".searchable").find("input").val($(this).text()).blur();
    onSelect($(this).text())
});

$(".searchable ul li").hover(function () {
    $(this).closest(".searchable").find("ul li.selected").removeClass("selected");
    $(this).addClass("selected");
});
</script>