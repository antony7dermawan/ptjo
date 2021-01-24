<div class="card">
  <div class="card-header">
    <form action='<?php echo base_url("c_t_ak_jurnal_history/search_date"); ?>' class='no_voucer_area' method="post" id=''>

      <label>Pilih Akun:</label>

      <select name="coa_id_jurnal_history" class='custom_width' id='select-state' placeholder='Pick a state...'>
        <?php
        foreach ($no_akun_option as $key => $value) {
          $coa_id_jurnal_history = $this->session->userdata('coa_id_jurnal_history');
          if ($value->NO_AKUN_3 != '') {
            $no_akun = $value->NO_AKUN_3;
          } elseif ($value->NO_AKUN_2 != '') {
            $no_akun = $value->NO_AKUN_2;
          } else {
            $no_akun = $value->NO_AKUN_1;
          }
          $selected = '';
          if ($coa_id_jurnal_history == $value->ID) {
            $selected = 'selected';
          }
          echo "<option value=" . $value->ID . " " . $selected . ">" . $no_akun . " / " . $value->NAMA_AKUN . "</option>";
        }
        ?>
      </select>
      <table>
        <tr>
          <th>Periode:</th>
          <th>
            <form action='/action_page.php'>
              <input type='date' class='form-control' name='date_from_select_jurnal' value='<?php echo $this->session->userdata('date_from_select_jurnal'); ?>'>
          </th>
          <th>-</th>
          <th>
            <form action='/action_page.php'>
              <input type='date' class='form-control' name='date_to_select_jurnal' value='<?php echo $this->session->userdata('date_to_select_jurnal'); ?>'>
          </th>
          <th>
            <input type="submit" name="submit" class='btn btn-primary waves-effect waves-light' value="Search">
          </th>
        </tr>
      </table>


    </form>
  </div>
  <div class="card-block">
    <!-- Menampilkan notif !-->
    <?= $this->session->flashdata('notif') ?>
    <!-- Tombol untuk menambah data akun !-->

    <div class="table-responsive dt-responsive">
      <table id="dom-jqry" class="table table-striped table-bordered nowrap">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Akun</th>
            <th>Date</th>
            <th>NO AKUN</th>
            <th>No Voucer</th>
            <th>Debit</th>
            <th>Kredit</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php

          $total_debit = 0;
          $total_kredit = 0;
          foreach ($c_t_ak_jurnal_history as $key => $value) {

            if ($value->NO_AKUN_3 != '') {
              $no_akun = $value->NO_AKUN_3;
            } elseif ($value->NO_AKUN_2 != '') {
              $no_akun = $value->NO_AKUN_2;
            } else {
              $no_akun = $value->NO_AKUN_1;
            }
            $total_debit = intval($value->DEBIT) + $total_debit;
            $total_kredit = intval($value->KREDIT) + $total_kredit;

            if ($key > 0) {
              $color = 'background-white text-c-black';
              echo "<tr>";

              echo "<td class='" . $color . "'>" . ($key + 1) . "</td>";
              echo "<td class='" . $color . "'>" . $value->NAMA_AKUN . "</td>";
              echo "<td class='" . $color . "'>" . date('d-m-Y', strtotime($value->DATE)) . " / " . date('H:i', strtotime($value->TIME)) . "</td>";
              echo "<td class='" . $color . "'>" . $no_akun . "</td>";

              echo "<td class='" . $color . "'>" . $value->NO_VOUCER . "</td>";
              echo "<td class='" . $color . "'>Rp" . number_format(intval($value->DEBIT)) . "</td>";
              echo "<td class='" . $color . "'>Rp" . number_format(intval($value->KREDIT)) . "</td>";

              echo "<td class='" . $color . "'>";

              echo "<a href='" . site_url('c_t_ak_jurnal_history/move/' . $value->CREATED_ID) . "' ";
          ?>
              onclick="return confirm('Edit Data?')"
            <?php
              echo "> <i class='fa fa-search-plus text-c-blue'></i></a>";




              echo "<a href='javascript:void(0);' data-toggle='modal' data-target='#Modal_Edit' class='btn-edit' data-id='" . $value->ID . "'>";
              echo "<i class='icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green'></i>";
              echo "</a>";




              echo "</td>";
            }


            if ($key == 0) {
              $color = 'background-blue';
              echo "<tr>";

              echo "<td class='" . $color . "'>" . ($key + 1) . "</td>";
              echo "<td class='" . $color . "'>" . $value->NAMA_AKUN . "</td>";
              echo "<td class='" . $color . "'>" . date('d-m-Y', strtotime($value->DATE)) . " / " . date('H:i', strtotime($value->TIME)) . "</td>";
              echo "<td class='" . $color . "'>" . $no_akun . "</td>";
              echo "<td class='" . $color . "'>" . $value->NO_VOUCER . "</td>";
              echo "<td class='" . $color . "'>Rp" . number_format(intval($value->DEBIT)) . "</td>";
              echo "<td class='" . $color . "'>Rp" . number_format(intval($value->KREDIT)) . "</td>";

              $color = 'background-white text-c-black';
              echo "<td class='" . $color . "'>";

              echo "<a href='" . site_url('c_t_ak_jurnal_history/move/' . $value->CREATED_ID) . "' ";
            ?>
              onclick="return confirm('Edit Data?')"
          <?php
              echo "> <i class='fa fa-search-plus text-c-blue'></i></a>";



              echo "<a href='javascript:void(0);' data-toggle='modal' data-target='#Modal_Edit' class='btn-edit' data-id='" . $value->ID . "'>";
              echo "<i class='icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green'></i>";
              echo "</a>";



              //batas new window
              echo "<a "; #/1 ini artinya kena pajak

              echo "onclick= 'p_1_" . $key . "()'";

              echo "> <i class='fa fa-file-pdf-o text-c-red'></i></a> ";

              echo "<script>";
              echo "function p_1_" . $key . "()";
              echo "{";
              echo "window.open('laporan_pdf/c_t_ak_jurnal_history_print');";
              echo "}";
              echo "</script>";
              //batas new window





              //batas new window
              echo "<a "; #/1 ini artinya kena pajak

              echo "onclick= 'p_2_" . $key . "()'";

              echo "> <i class='fa fa-file-excel-o text-c-green'></i></a> ";

              echo "<script>";
              echo "function p_2_" . $key . "()";
              echo "{";
              echo "window.open('laporan_excel/lap_jurnal_history_print');";
              echo "}";
              echo "</script>";
              //batas new window

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
            <th></th>
            <th></th>
            <th>Total</th>
            <th>Rp <?= number_format(intval($total_debit)) ?></th>
            <th>Rp <?= number_format(intval($total_kredit)) ?></th>
            <th></th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>






<!-- MODAL EDIT AKUN !-->
<div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="<?php echo base_url('c_t_ak_jurnal_history/edit_action') ?>" method="post" autocomplete="off" id='edit_data'>
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">View Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>


        <div class="modal-body">
          <input type="hidden" name="id" value="" class="form-control">




          <div class="form-group">
            <label>Catatan</label>
            <textarea rows='4' cols='20' name='catatan' id='' form='edit_data' class='form-control'></textarea>
          </div>


          <div class="row">
            <div class="col-md-6">

              <fieldset class="form-group">
                <label>Departemen</label>
                <input type='text' class='form-control' placeholder='' name='departemen'>
              </fieldset>

            </div><!-- Membungkus Row Kedua !-->




            <div class="modal-footer">
              <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
            </div>

          </div>


          <script>
            const read_data = <?= json_encode($c_t_ak_jurnal_history) ?>;
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
                  CATATAN: catatan,
                  DEPARTEMEN: departemen
                } = User[0];

                elModalEdit.querySelector("[name=id]").value = ID;

                elModalEdit.querySelector("[name=catatan]").value = catatan;
                elModalEdit.querySelector("[name=departemen]").value = departemen;





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

  .background-white {
    background-color: white;
  }

  .background-blue {
    background-color: #151B54;
    color: white;
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




<style type="text/css">
  .text_red {
    color: red;
  }

  .text_black {
    color: black;
  }
</style>