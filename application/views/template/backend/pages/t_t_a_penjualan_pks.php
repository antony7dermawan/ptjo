<div class="card">
  <div class="card-header">
    <form action='<?php echo base_url("c_t_t_a_penjualan_pks/date_penjualan_pks"); ?>' class='no_voucer_area' method="post" id=''>
      <table>
        <tr>
          <th>
            Tanggal Pengiriman:
          </th>
          <th>
            <form action='/action_page.php'>
              <input type='date' class='form-control' name='date_penjualan_pks' value='<?= $this->session->userdata('date_penjualan_pks') ?>' onchange='this.form.submit();'>
          </th>
          <?php
            if($this->session->userdata('level_user_id')==1)
            {
              ?>
                <th>
                  <input type='button' name='' class='btn btn-primary waves-effect waves-light' onclick='send_to_cloud()' value='Send to Cloud'>


                    <script>
                    function send_to_cloud()
                    {
                      if(confirm('Sudah Yakin Data Ini Semua Benar?!?'))
                      {
                        window.open('send_cloud/send_t_t_a_penjualan_pks');
                      }
                      
                    }
                    </script>
                  
                </th>
              <?php
            }
            ?>

            
          
        </tr>
      </table>


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
            <th>PKS</th>
            <th>Supir</th>
            <th>Bruto</th>
            <th>Sortase</th>
            <th>Neto</th>
            <th>Uang Jalan</th>
            <th>Total Penjualan</th>
            <th>No Tiket</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sum_total_penjualan = 0;
          $sum_bruto = 0;
          $sum_neto = 0;
          $sum_uang_jalan = 0;
          foreach ($c_t_t_a_penjualan_pks as $key => $value) {
            echo "<tr>";
            echo "<td>" . ($key + 1) . "</td>";
            echo "<td>" . $value->PKS . "</td>";
            echo "<td>" . $value->SUPIR . "</td>";
            echo "<td>" . $value->BRUTO . "</td>";
            echo "<td>" . $value->SORTASE_PERCENTAGE . "</td>";
            echo "<td>" . (intval($value->NETO * 100) / 100) . "</td>";
            echo "<td>Rp" . number_format(intval($value->UANG_JALAN + $value->TAMBAHAN)) . "</td>";

            #echo "<td>".date('d-m-Y', strtotime($value->DATE))." / ".date('H:i', strtotime($value->TIME))." / ".$value->CREATED_BY."</td>";
            echo "<td>Rp" . number_format(intval($value->TOTAL_PENJUALAN)) . "</td>";
            echo "<td>" . $value->NO_TIKET . "</td>";

            $sum_total_penjualan = $sum_total_penjualan+intval($value->TOTAL_PENJUALAN);
            $sum_bruto = $sum_bruto + $value->BRUTO;
            $sum_neto = $sum_neto + (intval($value->NETO * 100) / 100);
            $sum_uang_jalan = $sum_uang_jalan + intval($value->UANG_JALAN + $value->TAMBAHAN);
            if ($value->ENABLE_EDIT == 1) {
              echo "<td>";

              $ok_color = 'red';
              if ($value->CHECKED_ID == 1) {
                $ok_color = 'green';
              }
              if ($value->SPECIAL_ID > 0) {
                echo "<a href='" . site_url('c_t_t_a_penjualan_pks/checked_ok/' . $value->ID) . "' ";
              ?>
                onclick="return confirm('Apakah kamu yakin ini BENAR?')"
              <?php

                echo "> <i class='fa fa-check f-w-600 f-16 text-c-" . $ok_color . "'></i></a>";
              }

              echo "<a href='javascript:void(0);' data-toggle='modal' data-target='#Modal_Edit' class='btn-edit' data-id='" . $value->ID . "'>";
              echo "<i class='icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green'></i>";
              echo "</a>";

              
              echo "<a href='" . site_url('c_t_t_a_penjualan_pks/delete/' . $value->ID) . "' ";
              ?>
              onclick="return confirm('Apakah kamu yakin ingin menghapus data ini?')"
          <?php
              echo "> <i class='feather icon-trash-2 f-w-600 f-16 text-c-red'></i></a>";

              echo "</td>";
            }
            if ($value->ENABLE_EDIT == 0) {
              echo "<td class='text-c-green'>";
              echo "Sudah Ditagih";
              echo "</td>";
            }




            echo "</tr>";
          }
          ?>
        </tbody>

        <tfoot>
          <tr>
            <th></th>
            <th></th>
            <th>Total</th>
            <th><?=number_format(intval($sum_bruto))?></th>
            <th></th>
            <th><?=number_format(intval($sum_neto))?></th>
            <th>Rp<?=number_format(intval($sum_uang_jalan))?></th>
            <th>Rp<?=number_format(intval($sum_total_penjualan))?></th>
            <th></th>
            <th></th>
          </tr>
        </tfoot>


      </table>
    </div>
  </div>
</div>





<!-- MODAL TAMBAH PEMASUKAN! !-->
<form action="<?php echo base_url('c_t_t_a_penjualan_pks/tambah') ?>" method="post">
  <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tanggal Pengiriman:
            <form action='/action_page.php'>
              <input type='date' class='form-control' name='date' value='<?= $this->session->userdata('date_penjualan_pks') ?>'>
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>



        </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">

              <fieldset class="form-group">


                <label>Divisi</label>
                <select name="divisi_id" class='custom_width' id='select-state' placeholder='Pick a state...'>
                  <?php
                  foreach ($c_t_m_a_divisi as $key => $value) {
                    echo "<option value='" . $value->DIVISI_ID . "'>" . $value->DIVISI . "</option>";
                  }
                  ?>
                </select>

                <label>PKS</label>
                <select name="pks_id" class='custom_width' id='select-state' placeholder='Pick a state...'>
                  <?php
                  foreach ($c_t_m_a_pks as $key => $value) {
                    echo "<option value='" . $value->PKS_ID . "'>" . $value->PKS . "</option>";
                  }
                  ?>
                </select>

                <label>No Polisi</label>
                <select name="no_polisi_id" class='custom_width' id='select-state' placeholder='Pick a state...'>
                  <?php
                  foreach ($c_t_m_a_no_polisi as $key => $value) {
                    echo "<option value='" . $value->NO_POLISI_ID . "'>" . $value->NO_POLISI . "</option>";
                  }
                  ?>
                </select>

                <label>Bruto</label>
                <input type='text' class='form-control' placeholder='Input Number' name='bruto'>


                <label>Sortase(%)</label>
                <input type='text' class='form-control' placeholder='Input Number' name='sortase_percentage'>



              </fieldset>

            </div><!-- Membungkus Row Kedua !-->


            <div class="col-md-6">

              <fieldset class="form-group">
                <label>Supir</label>
                <select name="supir_id" class='custom_width' id='select-state' placeholder='Pick a state...'>
                  <?php
                  foreach ($c_t_m_a_supir as $key => $value) {
                    echo "<option value='" . $value->SUPIR_ID . "'>" . $value->SUPIR . "</option>";
                  }
                  ?>
                </select>

                <label>Kendaraan</label>
                <select name="kendaraan_id" class='custom_width' id='select-state' placeholder='Pick a state...'>
                  <?php
                  foreach ($c_t_m_a_kendaraan as $key => $value) {
                    echo "<option value='" . $value->KENDARAAN_ID . "'>" . $value->KENDARAAN . "</option>";
                  }
                  ?>
                </select>

                <label>No Tiket</label>
                <input type='text' class='form-control' placeholder='Input Text' name='no_tiket'>


                <label>Tambahan Uang Jalan</label>
                <input type='text' class='form-control' placeholder='Input Number' name='tambahan'>

                <label>Harga Sawit / Kg</label>
                <input type='text' class='form-control' placeholder='Input Number' name='harga'>

              </fieldset>

            </div>
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





<!-- MODAL EDIT AKUN !-->
<div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="<?php echo base_url('c_t_t_a_penjualan_pks/edit_action') ?>" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <input type="hidden" name="id" value="" class="form-control">
              <fieldset class="form-group">


                <label>Bruto</label>
                <input type='text' class='form-control' placeholder='Input Number' name='bruto'>


                <label>Sortase(%)</label>
                <input type='text' class='form-control' placeholder='Input Number' name='sortase_percentage'>



              </fieldset>

            </div><!-- Membungkus Row Kedua !-->


            <div class="col-md-6">

              <fieldset class="form-group">


                <label>No Tiket</label>
                <input type='text' class='form-control' placeholder='Input Text' name='no_tiket'>


                <label>Tambahan Uang Jalan</label>
                <input type='text' class='form-control' placeholder='Input Number' name='tambahan'>

                <label>Harga Sawit / Kg</label>
                <input type='text' class='form-control' placeholder='Input Number' name='harga'>

              </fieldset>

            </div>
          </div> <!-- Membungkus Row !-->
        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
          <button type="Submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
        </div>

      </div>


      <script>
        const read_data = <?= json_encode($c_t_t_a_penjualan_pks) ?>;
        console.log(read_data);
        let elModalEdit = document.querySelector("#Modal_Edit");
        console.log(elModalEdit);
        let elBtnEdits = document.querySelectorAll(".btn-edit");
        [...elBtnEdits].forEach(edit => {
          edit.addEventListener("click", (e) => {
            let id = edit.getAttribute("data-id");
            let User = read_data.filter(user => {
              if (user.ID == id)
                return user;
            });
            const {
              ID,
              BRUTO: bruto,
              SORTASE_PERCENTAGE: sortase_percentage,
              NO_TIKET: no_tiket,
              TAMBAHAN: tambahan,
              HARGA: harga
            } = User[0];

            elModalEdit.querySelector("[name=id]").value = ID;


            elModalEdit.querySelector("[name=bruto]").value = bruto;
            elModalEdit.querySelector("[name=sortase_percentage]").value = sortase_percentage;
            elModalEdit.querySelector("[name=no_tiket]").value = no_tiket;
            elModalEdit.querySelector("[name=tambahan]").value = tambahan;

            elModalEdit.querySelector("[name=harga]").value = harga;






          })
        })
      </script>

    </form>
  </div>
</div>



<script type="text/javascript">
  $(document).ready(function() {
    $('select').selectize({
      sortField: 'text'
    });
  });
</script>







<style type="text/css">
  div.searchable {
    width: 90%;
    margin: 0 15px;
  }

  .searchable input {
    width: 100%;
    height: 25px;
    font-size: 12px;
    padding: 10px;
    -webkit-box-sizing: border-box;
    /* Safari/Chrome, other WebKit */
    -moz-box-sizing: border-box;
    /* Firefox, other Gecko */
    box-sizing: border-box;
    /* Opera/IE 8+ */
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
      li.each(function(i, obj) {
        if ($(this).text().toUpperCase().indexOf(input_val) > -1) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });

      container.find("ul li").removeClass("selected");
      setTimeout(function() {
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

  function onSelect(val) {
    alert(val)
  }

  $(".searchable input").focus(function() {
    $(this).closest(".searchable").find("ul").show();
    $(this).closest(".searchable").find("ul li").show();
  });
  $(".searchable input").blur(function() {
    let that = this;
    setTimeout(function() {
      $(that).closest(".searchable").find("ul").hide();
    }, 300);
  });

  $(document).on('click', '.searchable ul li', function() {
    $(this).closest(".searchable").find("input").val($(this).text()).blur();
    onSelect($(this).text())
  });

  $(".searchable ul li").hover(function() {
    $(this).closest(".searchable").find("ul li.selected").removeClass("selected");
    $(this).addClass("selected");
  });
</script>