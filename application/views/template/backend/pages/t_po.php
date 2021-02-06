<div class="card">
  <div class="card-header">
    <form action='<?php echo base_url("c_t_po/date_po"); ?>' class='no_voucer_area' method="post" id=''>
      <table>
        <tr>
          <th>
            Tanggal Pembuatan PO:
          </th>
          <th>
            <form action='/action_page.php'>
              <input type='date' class='form-control' name='date_po' value='<?= $this->session->userdata('date_po') ?>' onchange='this.form.submit();'>
          </th>
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
            <th>Date/Time</th>
            <th>No Po</th>
            <th>Supplier</th>
            <th>Jumlah</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($c_t_po as $key => $value) {
            echo "<tr>";
            echo "<td>" . ($key + 1) . "</td>";
            echo "<td>" . date('d-m-Y', strtotime($value->DATE)) . " / " . date('H:i', strtotime($value->TIME)) ." / " . ($value->CREATED_BY) . "</td>";

            echo "<td>" . $value->NO_PO . "</td>";
            echo "<td>" . $value->SUPPLIER . "</td>";


            //satu button
            echo "<td>";
            echo "<a href='" . site_url('c_t_po_rincian/index/' . $value->ID) .  "' ";
            echo "onclick=\"return confirm('Lanjut?')\"";
            echo "> <i class='fa fa-search-plus text-c-blue'></i></a> ";
            echo " Rp" . number_format(intval($value->SUM_TOTAL)) . "</td>";
            //satu button

            echo "<td>";



            /*
              echo "<a "; #/1 ini artinya kena pajak

              echo "onclick= 'p_1_" . $key . "()'";

              echo "> <i class='fa fa-print text-c-black'></i></a> ";

              echo "<script>";
              echo "function p_1_" . $key . "()";
              echo "{";
              echo "window.open('laporan_pdf/c_t_po_print/index/" . $value->ID . "');";
              echo "}";
              echo "</script>";

            */
        
            if(intval($value->SUM_TOTAL)==0)
            {
              
              echo "<a href='javascript:void(0);' data-toggle='modal' data-target='#Modal_Edit' class='btn-edit' data-id='".$value->ID."'>";
              echo "<i class='icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green'></i>";
              echo "</a>";

              echo "<a href='".site_url('c_t_po/delete/' . $value->ID)."' ";
              ?>
              onclick="return confirm('Apakah kamu yakin ingin menghapus data ini?')"
              <?php
              echo "> <i class='feather icon-trash-2 f-w-600 f-16 text-c-red'></i></a>";
              
            }
            echo "</td>";
            



            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>



<!-- MODAL TAMBAH PEMASUKAN! !-->
<form action="<?php echo base_url('c_t_po/tambah') ?>" method="post" id='add_data'>
  <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tanggal Transaksi:
            <form action='/action_page.php'>
              <input type='date' class='form-control' name='date' value='<?= $this->session->userdata('date_jurnal_create') ?>'>
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          
          <div class="form-group">
              <label>No PO</label>
              <input type='text' class='form-control' placeholder='Input Text' name='no_po' value=''>
              <label>Supplier</label>
              <input type='text' class='form-control' placeholder='Input Number' name='supplier' value=''>
          </div>




        <div class="form-group">
              <label>Keterangan</label>
              <textarea rows='4' cols='20' name='ket' id='' form='add_data' class='form-control'></textarea>
        </div>



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
    <form action="<?php echo base_url('c_t_po/edit_action') ?>" id='edit_data' method="post">
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


              <label>No PO</label>
              <input type='text' class='form-control' placeholder='Input Text' name='no_po' value=''>
              <label>Supplier</label>
              <input type='text' class='form-control' placeholder='Input Number' name='supplier' value=''>

            </div><!-- Membungkus Row Kedua !-->

            <div class="form-group">
              <label>Keterangan</label>
              <textarea rows='4' cols='20' name='ket' id='' form='edit_data' class='form-control'></textarea>
            </div>



          </div> <!-- Membungkus Row !-->
        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
          <button type="Submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
        </div>

      </div>


      <script>
        const read_data = <?= json_encode($c_t_po) ?>;
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
              NO_PO: no_po,
              SUPPLIER: supplier,
              KET: ket
            } = User[0];

            elModalEdit.querySelector("[name=id]").value = ID;


            elModalEdit.querySelector("[name=no_po]").value = no_po;
            elModalEdit.querySelector("[name=supplier]").value = supplier;
            elModalEdit.querySelector("[name=ket]").value = ket;






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