<div class="card">
  <div class="card-header">
    <h5>Master COA</h5>
  </div>
  <div class="card-block">
    <!-- Menampilkan notif !-->
    <?= $this->session->flashdata('notif') ?>
    <!-- Tombol untuk menambah data akun !-->
    <button data-toggle='modal' data-target='#addModal' class='btn btn-success waves-effect waves-light'>New Data</button>

    <div class="table-responsive dt-responsive">
      <table id="dom-jqry" class="table table-striped table-bordered nowrap">
        <thead>
          <tr>
            <th>No</th>
            <th>NO AKUN</th>
            <th>Nama Akun</th>
            <th>Type</th>
            
            <th>Db/K</th>
            <th>Family</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($c_ak_m_coa as $key => $value) 
          {
            echo "<tr>";
            if($value->FAMILY_ID==1)
            {
              echo "<td class='parent_1'>".($key + 1)."</td>";
              if($value->NO_AKUN_3!=null)
              {
                echo "<td class='parent_1'>".$value->NO_AKUN_3."</td>";
              }
              elseif($value->NO_AKUN_2!=null)
              {
                echo "<td class='parent_1'>".$value->NO_AKUN_2."</td>";
              }
              else
              {
                echo "<td class='parent_1'>".$value->NO_AKUN_1."</td>";
              }
              echo "<td class='parent_1'>".$value->NAMA_AKUN."</td>";
              echo "<td class='parent_1'>".$value->TYPE."</td>";
              //echo "<td class='parent_1'>Rp".number_format(intval($value->SALDO))."</td>";
              echo "<td class='parent_1'>".$value->DB_K."</td>";
              echo "<td class='parent_1'>".$value->FAMILY."</td>";
            }
            elseif($value->FAMILY_ID==2)
            {
              echo "<td class='parent_2'>".($key + 1)."</td>";
              if($value->NO_AKUN_3!=null)
              {
                echo "<td class='parent_2'>".$value->NO_AKUN_3."</td>";
              }
              elseif($value->NO_AKUN_2!=null)
              {
                echo "<td class='parent_2'>".$value->NO_AKUN_2."</td>";
              }
              else
              {
                echo "<td class='parent_2'>".$value->NO_AKUN_1."</td>";
              }
              echo "<td class='parent_2'>".$value->NAMA_AKUN."</td>";
              echo "<td class='parent_2'>".$value->TYPE."</td>";
              //echo "<td class='parent_2'>Rp".number_format(intval($value->SALDO))."</td>";
              echo "<td class='parent_2'>".$value->DB_K."</td>";
              echo "<td class='parent_2'>".$value->FAMILY."</td>";
            }
            elseif($value->FAMILY_ID==3)
            {
              echo "<td class='parent_3'>".($key + 1)."</td>";
              if($value->NO_AKUN_3!=null)
              {
                echo "<td class='parent_3'>".$value->NO_AKUN_3."</td>";
              }
              elseif($value->NO_AKUN_2!=null)
              {
                echo "<td class='parent_3'>".$value->NO_AKUN_2."</td>";
              }
              else
              {
                echo "<td class='parent_3'>".$value->NO_AKUN_1."</td>";
              }
              
              echo "<td class='parent_3'>".$value->NAMA_AKUN."</td>";
              echo "<td class='parent_3'>".$value->TYPE."</td>";
              //echo "<td class='parent_3'>Rp".number_format(intval($value->SALDO))."</td>";
              echo "<td class='parent_3'>".$value->DB_K."</td>";
              echo "<td class='parent_3'>".$value->FAMILY."</td>";
            }
            
            
            echo "<td class='white'>";
             
            echo "<a href='javascript:void(0);' data-toggle='modal' data-target='#Modal_Edit' class='btn-edit' data-id='".$value->ID."'>";
              echo "<i class='icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green'></i>";
            echo "</a>";
            echo "<a href='".site_url('c_ak_m_coa/delete/' . $value->ID)."' ";
            ?>
            onclick="return confirm('Apakah kamu yakin ingin menghapus data ini?')"
            <?php
            echo "> <i class='feather icon-trash-2 f-w-600 f-16 text-c-red'></i></a>";

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
<form action="<?php echo base_url('c_ak_m_coa/tambah') ?>" method="post">
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
              
              <label>No Akun 1</label>
              <input type='text' class='form-control' placeholder='Input Number' name='no_akun_1'>

              <label>No Akun 2</label>
              <input type='text' class='form-control' placeholder='Input Number' name='no_akun_2'>

              <label>No Akun 3</label>
              <input type='text' class='form-control' placeholder='Input Number' name='no_akun_3'>



            </fieldset>

          </div><!-- Membungkus Row Kedua !-->


          <div class="col-md-6">

            <fieldset class="form-group">

              <label>Nama Akun</label>
              <input type='text' class='form-control' placeholder='Input Number' name='nama_akun'>

              <label>Type</label>
              <select name="type_id" class='custom_width' id='select-state' placeholder='Pick a state...'>
              <?php
              foreach ($c_ak_m_type as $key => $value) 
              {
                echo "<option value='".$value->TYPE_ID."'>".$value->TYPE."</option>";

              }
              ?>
              </select>

              <label>Debit/Kredit</label>
              <select name="db_k_id" class='custom_width' id='select-state' placeholder='Pick a state...'>
              <?php
              foreach ($c_ak_m_db_k as $key => $value) 
              {
                echo "<option value='".$value->DB_K_ID."'>".$value->DB_K."</option>";
              }
              ?>
              </select>

              <label>Family</label>
              <select name="family_id" class='custom_width' id='select-state' placeholder='Pick a state...'>
              <?php
              foreach ($c_ak_m_family as $key => $value) 
              {
                echo "<option value='".$value->FAMILY_ID."'>".$value->FAMILY."</option>";

              }
              ?>
              </select>

              

              
              
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
    <form action="<?php echo base_url('c_ak_m_coa/edit_action') ?>" method="post" autocomplete="off">
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
              <label>No Akun 1</label>
              <input type='text' class='form-control' placeholder='Input Text' name='no_akun_1'>
            </div>
            <div class="form-group">
              <label>No Akun 2</label>
              <input type='text' class='form-control' placeholder='Input Text' name='no_akun_2'>
            </div>
            <div class="form-group">
              <label>No Akun 3</label>
              <input type='text' class='form-control' placeholder='Input Text' name='no_akun_3'>
            </div>
            



            <div class="form-group">
              <label>Nama Akun</label>
              <input type='text' class='form-control' placeholder='Input Text' name='nama_akun'>
            </div>


          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
            <button type="Submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
          </div>

        </div>


<script>
  const read_data = <?= json_encode($c_ak_m_coa) ?>;
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
        NAMA_AKUN : nama_akun,
        NO_AKUN_1 : no_akun_1,
        NO_AKUN_2 : no_akun_2,
        NO_AKUN_3 : no_akun_3
      } = User[0];

      elModalEdit.querySelector("[name=id]").value = ID;
      
      
      elModalEdit.querySelector("[name=nama_akun]").value = nama_akun;
      elModalEdit.querySelector("[name=no_akun_1]").value = no_akun_1;
      elModalEdit.querySelector("[name=no_akun_2]").value = no_akun_2;
      elModalEdit.querySelector("[name=no_akun_3]").value = no_akun_3;

  



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





<style type="text/css">
.white
{
  background-color: white;
}
.parent_1
{
  background-color: #151B54;
  color: white;
}
.parent_2
{
  background-color: #82CAFF;
  color: black;
}
.parent_3
{
  background-color: white;
  color: black;
}
</style>