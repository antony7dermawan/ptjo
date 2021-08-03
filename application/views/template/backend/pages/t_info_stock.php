<div class="card">
  <div class="card-header">

    
    

    <form action='<?php echo base_url("c_t_info_stock/change_company_id"); ?>' class='' method="post" id=''>

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

    <form action='<?php echo base_url("c_t_info_stock/change_kategori_id"); ?>' class='' method="post" id=''>
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
            <th>Qty</th>
            <th>Harga Jual</th>
            <th>Min Stock</th>
            <th>Max Stock</th>
            <th>Kategori</th>
            <th>Jenis Barang</th>
            
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($c_t_info_stock as $key => $value) 
          {

              echo "<tr>";
              echo "<td>".($key + 1)."</td>";
              echo "<td>".$value->KODE_BARANG."</td>";
              echo "<td>".$value->BARANG."</td>";
              echo "<td>".$value->MERK_BARANG."</td>";
              echo "<td>".$value->PART_NUMBER."</td>";
              echo "<td>".$value->POSISI."</td>";
              echo "<td>".number_format($value->SUM_SISA_QTY).' '.$value->SATUAN."</td>";
              echo "<td>" . number_format(floatval(intval($value->HARGA_JUAL*100))/100) . "</td>";
              echo "<td>".$value->MINIMUM_STOK."</td>";
              echo "<td>".$value->MAXIMUM_STOK."</td>";
              echo "<td>".$value->KATEGORI."</td>";
              echo "<td>".$value->JENIS_BARANG."</td>";
            
             


              echo "</tr>";
            

            
            

          }
          ?>
        </tbody>
      </table>
    </div>
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