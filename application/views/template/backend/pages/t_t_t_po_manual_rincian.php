<div class="card">
  <div class="card-header">
    <form action='<?php echo base_url("c_t_t_t_po_manual/date_po_manual"); ?>' class='no_voucer_area' method="post" id=''>
      <h5>
      <?php
      $level_user_id = $this->session->userdata('level_user_id');
      foreach ($c_t_t_t_po_manual_by_id as $key => $value) {
        $inv = $value->INV;
        $t_status = $value->T_STATUS;
      }


      echo 'No INV: '.$inv;
      ?>


      </h5>
    </form>
  </div>
  <div class="card-block">
    <!-- Menampilkan notif !-->
    <?= $this->session->flashdata('notif') ?>

    <a href="<?= base_url("c_t_t_t_po_manual"); ?>" class="btn waves-effect waves-light btn-inverse"><i class="icofont icofont-double-left"></i>Back</a>
    <!-- Tombol untuk menambah data akun !-->
    <?php
    if($t_status != 1)
    {
      ?>
      <button data-toggle="modal" data-target="#addModal" class="btn btn-success waves-effect waves-light">New Data</button>

      <?php
    }
    ?>

    <div class="table-responsive dt-responsive">
      <table id="dom-jqry" class="table table-striped table-bordered nowrap">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Barang</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Sub Total</th>
            <th>Sisa Qty</th>

            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($c_t_t_t_po_manual_rincian as $key => $value) {

            if($value->MARK_FOR_DELETE == 'f')
            {
              echo "<tr>";
              echo "<td>" . ($key + 1) . "</td>";
              echo "<td>" . $value->KODE_BARANG . "</td>";
              echo "<td>" . $value->BARANG . "</td>";
              
              echo "<td>" . number_format(floatval(intval($value->QTY*100))/100) . "</td>";
              echo "<td>" . number_format(floatval(intval($value->HARGA*100))/100) . "</td>";
              echo "<td>" . number_format(floatval(intval($value->SUB_TOTAL*100))/100) . "</td>";
              echo "<td>" . number_format(floatval(intval($value->SISA_QTY*100))/100) . "</td>";

              
              echo "<td>";
              if (intval($value->QTY) == intval($value->SISA_QTY))
              {
                echo "<a href='javascript:void(0);' data-toggle='modal' data-target='#Modal_Edit' class='btn-edit' data-id='" . $value->ID . "'>";
                echo "<i class='icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green'></i>";
                echo "</a>";

                echo "<a href='".site_url('c_t_t_t_po_manual_rincian/delete/'.$value->ID.'/'.$pembelian_id)."' ";

                echo "onclick=\"return confirm('Apakah kamu yakin ingin menghapus data ini?')\"";


                echo "> <i class='feather icon-trash-2 f-w-600 f-16 text-c-red'></i></a>";
              }
              echo "</td>";


              echo "</tr>";
            }


            if($value->MARK_FOR_DELETE == 't')
            {
              echo "<tr>";
              echo "<td><s>" . ($key + 1) . "</s></td>";
              echo "<td><s>" . $value->KODE_BARANG . "</s></td>";
              echo "<td><s>" . $value->BARANG . "</s></td>";
              
              echo "<td><s>" . number_format(floatval(intval($value->QTY*100))/100) . "</s></td>";
              echo "<td><s>" . number_format(floatval(intval($value->HARGA*100))/100) . "</s></td>";
              echo "<td><s>" . number_format(floatval(intval($value->SUB_TOTAL*100))/100) . "</s></td>";
              echo "<td><s>" . number_format(floatval(intval($value->SISA_QTY*100))/100) . "</s></td>";

              
              echo "<td>";
              if (intval($value->QTY) == intval($value->SISA_QTY))
              {
                
                echo "<a href='".site_url('c_t_t_t_po_manual_rincian/undo_delete/'.$value->ID.'/'.$pembelian_id)."' ";
                ?>
                onclick="return confirm('Apakah kamu yakin ingin mengembalikan data ini?')"
                <?php
                echo "> <i class='fa fa-refresh f-w-600 f-16 text-c-red'></i></a>";

                echo ' '.$value->UPDATED_BY;
              }
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









<!-- MODAL TAMBAH PEMASUKAN! !-->
<form action="<?php echo base_url('c_t_t_t_po_manual_rincian/tambah/'.$pembelian_id) ?>" method="post" id='add_data'>
  <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">New Data
            
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          
        

        <div class="form-group">
            <label>Kode Barang</label>
            <select name="barang_id" class='barang_id' id='select-state' placeholder='Pick a state...'>
              <option value="0"></option>
              <?php
              foreach ($c_t_m_d_barang as $key => $value) 
              {
                echo "<option value='".$value->BARANG_ID."'>".$value->KODE_BARANG."/".$value->BARANG."/".$value->MERK_BARANG."/".$value->PART_NUMBER."</option>";

              }
              ?>
              </select>
        </div>


        <div class="row">
          <div class="col-md-6">

            <fieldset class="form-group">
              <label>QTY</label>
              <input type='text' class='form-control' placeholder='Input Number' name='qty'>
            </fieldset>

          </div><!-- Membungkus Row Kedua !-->


          <div class="col-md-6">

            <fieldset class="form-group">
              <fieldset class="form-group">
              <label>Harga</label>
              <input type='text' class='form-control' placeholder='Input Number' name='harga'>
            </fieldset>
          </div> <!-- Membungkus Row !-->
        </div>



        <?php
        if($level_user_id==1)
        {
        ?>
        <div class="history_pembelian">
            <label>History Pembelian</label>
            <table name="" class="table table-xs">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Toko</th>
                  <th>Harga</th>
                  <th>Tanggal</th>
                </tr>
              </thead>
              <tbody class="return_data">
                
              </tbody>
            </table>
        </div>
        <style type="text/css">
          .history_pembelian
          {
            overflow: scroll;
          }
        </style>
        <?php
        }
        ?>



        </div>

          <div class="modal-footer">






            <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
            <button type="Submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
          </div>



      </div>
    </div>
  </div>

  

</script>
<script type="text/javascript">
$(document).ready(function()
{
$(".barang_id").change(function()
{
var barang_id=$(this).val();
var post_id = 'id='+ barang_id;
 
$.ajax
({
type: "POST",
url: '<?php echo base_url('c_read_barang_with_supplier') ?>',
data: post_id,
cache: false,
success: function(reading_feedback)
{
$(".return_data").html(reading_feedback);


console.log(reading_feedback);
} 
});
 
});
});

</script>


</form>
<!-- MODAL TAMBAH PEMASUKAN SELESAI !-->









<!-- MODAL EDIT AKUN !-->
<div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="<?php echo base_url('c_t_t_t_po_manual_rincian/edit_action/'.$pembelian_id) ?>" method="post" autocomplete="off" id='edit_data'>
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        
        <div class="modal-body">
        <input type="hidden" name="id" value="" class="form-control">


        <div class="row">
          <div class="col-md-6">

            <fieldset class="form-group">
              <label>QTY</label>
              <input type='text' class='form-control' placeholder='Input Number' name='qty'>
            </fieldset>

          </div><!-- Membungkus Row Kedua !-->


          <div class="col-md-6">

            <fieldset class="form-group">
              <fieldset class="form-group">
              <label>Harga</label>
              <input type='text' class='form-control' placeholder='Input Number' name='harga'>
            </fieldset>
          </div> <!-- Membungkus Row !-->
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
  const read_data = <?= json_encode($c_t_t_t_po_manual_rincian) ?>;
  console.log(read_data);
  let elModalEdit = document.querySelector("#Modal_Edit");
  console.log(elModalEdit);
  let elBtnEdits = document.querySelectorAll(".btn-edit");

  console.log(elBtnEdits);

  [...elBtnEdits].forEach(taik => {
    taik.addEventListener("click", (e) => {
      let id = taik.getAttribute("data-id");

      console.log(id);
      let Anjing = read_data.filter(user => {
        if (user.ID == id)
          return user;
      });
      const {
        ID,
        QTY : qty,
        HARGA : harga,
        UPDATED_BY : updated_by,
        CREATED_BY : created_by
      } = Anjing[0];

      elModalEdit.querySelector("[name=id]").value = ID;
      
      
      elModalEdit.querySelector("[name=qty]").value = qty;
      elModalEdit.querySelector("[name=harga]").value = harga;
      elModalEdit.querySelector("[name=updated_by]").text = updated_by;
      elModalEdit.querySelector("[name=created_by]").text = created_by;

  



    })
  })
</script>






    </form>
  </div>
</div>



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