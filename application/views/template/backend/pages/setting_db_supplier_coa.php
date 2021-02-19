
<div class="card">
  <div class="card-header">
    <h5>Setting COA Supplier</h5>
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
            <th>Nama Akun</th>
            <th>Saldo</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($c_setting_db_supplier_coa as $key => $value) 
          {
            echo "<tr>";
            echo "<td>".($key + 1)."</td>";
            echo "<td>".$value->NAMA_AKUN."</td>";
          

            if($value->DB_K_ID==1)
            {
              $read_saldo=$value->SUM_DEBIT-$value->SUM_KREDIT;
            }
            if($value->DB_K_ID==2)
            {
              $read_saldo=$value->SUM_KREDIT-$value->SUM_DEBIT;
            }
            echo "<td> Rp".number_format(intval($read_saldo))."</td>";
          
            echo "<td>";
             
            //echo "<a href='javascript:void(0);' data-toggle='modal' data-target='#Modal_Edit' class='btn-edit' data-id='".$value->ID."'>";
              //echo "<i class='icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green'></i>";
            //echo "</a>";

            echo "<a href='".site_url('c_setting_db_supplier_coa/delete/' . $value->ID)."' ";
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




<!-- MODAL TAMBAH Beban! !-->
<form action="<?php echo base_url('c_setting_db_supplier_coa/tambah') ?>" method="post">
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
              <label>Pilih Akun</label>
              <select name="coa_id" class='custom_width' id='select-state' placeholder='Pick a state...'>
              <?php
              foreach ($no_akun_option as $key => $value) 
              {
                
                if($value->NO_AKUN_3!='')
                {
                  $no_akun=$value->NO_AKUN_3;
                }
                elseif($value->NO_AKUN_2!='')
                {
                  $no_akun=$value->NO_AKUN_2;
                }
                else
                {
                  $no_akun=$value->NO_AKUN_1;
                }
                echo "<option value=".$value->ID.">".$no_akun." / ".$value->NAMA_AKUN."</option>";
              }
              ?>
              </select>
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


<script type="text/javascript">
    $(document).ready(function () {
      $('select').selectize({
          sortField: 'text'
      });
  });
</script>

