<div class="card">
  <div class="card-header">
    <?php
    #echo $faktur_penjualan_id;
    #echo $pks_id;

    $today = date('Y-m-d');

    $disabled = '';

    foreach ($c_t_ak_terima_pelanggan as $key => $value) {
      if ($value->ENABLE_EDIT == 0) {
        $disabled = 'disabled';
      }
    }
    
    ?>
    
  </div>
  <div class="card-block">
    <!-- Menampilkan notif !-->
    <?= $this->session->flashdata('notif') ?>
    <!-- Tombol untuk menambah data akun !-->
    
    <a href="<?= base_url("c_t_ak_terima_pelanggan"); ?>" class="btn waves-effect waves-light btn-inverse"><i class="icofont icofont-double-left"></i>Back</a>
    
    <?php
    if($disabled == '')
    {
      echo "<button data-toggle='modal' data-target='#addModal' class='btn btn-success waves-effect waves-light'>New Data</button>";
    }
    ?>
    

    <div class="table-responsive dt-responsive">
      <table id="dom-jqry" class="table table-striped table-bordered nowrap">
        <thead>
          <tr>
            <th>No</th>
            <th>No Faktur</th>
            <th>Tanggal</th>
            <th>Jumlah</th>
            <th>Sudah Dibayar</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($c_t_ak_terima_pelanggan_no_faktur as $key => $value) 
          {
            echo "<tr>";
            echo "<td>".($key + 1)."</td>";
            echo "<td>".$value->NO_FAKTUR."</td>";
            echo "<td>".date('d-m-Y', strtotime($value->DATE))."</td>";
            echo "<td>Rp".number_format(intval($value->TOTAL_PENJUALAN))."</td>";
            
            echo "<td>Rp".number_format(intval($value->PAYMENT_T))."</td>";
          

            
            echo "<td>";
            if($disabled == '')
            {

              echo "<a href='".site_url('c_t_ak_terima_pelanggan_no_faktur/delete/' . $value->ID.'/'.$terima_pelanggan_id.'/'.$pks_id)."' ";
              echo "onclick=\"return confirm('Apakah kamu yakin ingin menghapus data ini?')\"";
              echo "> <i class='feather icon-trash-2 f-w-600 f-16 text-c-red'></i></a>";
              
              if(intval($value->PAYMENT_T)>0)
              {
                echo "Sudah Ditagih";
              }
              
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
<form action="<?php echo base_url("c_t_ak_terima_pelanggan_no_faktur/tambah/".$terima_pelanggan_id."/".$pks_id) ?>" method="post">
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
          <div class="row">
           
          <div class="col-md-6">
            <fieldset class="form-group">
              <label>No Faktur</label>
              <select name="faktur_penjualan_id" class='custom_width' id='select-state' placeholder='Pick a state...'>
              <?php
              foreach ($select_no_faktur as $key => $value) 
              {
                echo "<option value='".$value->ID."'>".$value->NO_FAKTUR."</option>";
              }
              ?>
              </select>
            </fieldset>
          </div><!-- Membungkus Row Kedua !-->


          <div class="col-md-6">
            <fieldset class="form-group">
              
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






<script type="text/javascript">
    $(document).ready(function () {
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

function onSelect(val) {
    alert(val)
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