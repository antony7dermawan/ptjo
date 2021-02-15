<div class="pcoded-inner-content">
  <div class="main-body">
    <div class="page-wrapper">
      <div class="page-body">

        <div class="row">


          <?php

          $total_box = 4;
          foreach ($c_setting_db_bank_coa as $key => $value) {
            $rmd = (float)($key / $total_box);
            $rmd = ($rmd - (int)$rmd) * $total_box;
            if ($rmd == 0) {
              $color = 'red';
            }
            if ($rmd == 1) {
              $color = 'blue';
            }
            if ($rmd == 2) {
              $color = 'green';
            }
            if ($rmd == 3) {
              $color = 'yellow';
            }
            if ($value->DB_K_ID == 1) {
              $read_saldo = $value->SUM_DEBIT - $value->SUM_KREDIT;
            }
            if ($value->DB_K_ID == 2) {
              $read_saldo = $value->SUM_KREDIT - $value->SUM_DEBIT;
            }


            echo "<div class='col-xl-3 col-md-6'>";
            echo "<div class='card prod-p-card card-" . $color . "'>";
            echo "<div class='card-body'>";
            echo "<div class='row align-items-center m-b-30'>";
            echo "<div class='col'>";

            echo "<h4 class='m-b-0 f-w-700 text-white'>  " . $value->NAMA_AKUN . "</h3>";
            echo "<br>";
            echo "<h6 class='m-b-5 text-white'>Rp" . number_format(intval($read_saldo)) . "</h6>";
            echo "</div>";
            echo "<div class='col-auto'>";
            echo "<i class='fas fa-money-bill-alt text-c-" . $color . " f-18'></i>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
          }
          ?>









          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5>Invoice</h5>
                <span>List Tagihan Tagihan Pelanggan yang Belum Dibayarkan</span>

              </div>
              <div class="card-block">

                <div class="table-responsive dt-responsive">
                  <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>PKS</th>
                        <th>No Faktur</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($select_no_faktur as $key => $value) {
                        echo "<tr>";
                        echo "<td>" . ($key + 1) . "</td>";
                        echo "<td>" . $value->PKS . "</td>";
                        echo "<td>" . $value->NO_FAKTUR . "</td>";
                        echo "<td>" . date('d-m-Y', strtotime($value->DATE)) . "</td>";
                        echo "<td>Rp" . number_format(intval($value->SUM_TOTAL_PENJUALAN)) . "</td>";


                        /*
            echo "<td>";
              

              echo "<a href='".site_url('c_t_ak_terima_pelanggan_no_faktur/delete/' . $value->ID)."' ";
              
              echo "onclick=\"return confirm('Apakah kamu yakin ingin menghapus data ini?')\"";


              echo "> <i class='feather icon-trash-2 f-w-600 f-16 text-c-red'></i></a>";
            echo "</td>";

            echo "</tr>";
            */
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>



            </div>
          </div>



          <!-- !-->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5>Rekap Transaksi Pengiriman</h5>

                <form action='<?php echo base_url("c_dashboard/search_date"); ?>' class='no_voucer_area' method="post" id=''>
                  <table>
                    <tr>

                      <th>
                        <form action='/action_page.php'>
                          <input type='date' class='form-control' name='date_from_dashboard' value='<?php echo $this->session->userdata('date_from_dashboard'); ?>'>
                      </th>
                      <th>-</th>
                      <th>
                        <form action='/action_page.php'>
                          <input type='date' class='form-control' name='date_to_dashboard' value='<?php echo $this->session->userdata('date_to_dashboard'); ?>'>
                      </th>
                      <th>
                        <input type="submit" name="submit_date" class='btn btn-primary waves-effect waves-light' value="Search">
                      </th>
                    </tr>
                  </table>


                </form>
              </div>
              <div class="card-block">
                <div class="dt-responsive table-responsive">
                  <table id="order-table" class="table table-striped table-bordered nowrap">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>PKS</th>
                        <th>Trip</th>
                        <th>Bruto</th>
                        <th>Sortase</th>
                        <th>Neto</th>
                        <th>Total Penjualan</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($pengiriman_select as $key => $value) {
                        $total_trip = $value->SUM_TRIP;
                        if ($value->SUM_TRIP == 0) {
                          $total_trip = 1;
                        }
                        $sortase = (intval((floatval($value->SUM_SORTASE_PERCENTAGE) / $total_trip) * 100)) / 100;
                        echo "<tr>";
                        echo "<td>" . ($key + 1) . "</td>";
                        echo "<td>" . $value->PKS . "</td>";
                        echo "<td>" . number_format(intval($value->SUM_TRIP)) . "</td>";
                        echo "<td>" . number_format(intval($value->SUM_BRUTO)) . "</td>";
                        echo "<td>" . $sortase . "</td>";
                        echo "<td>" . number_format(intval($value->SUM_NETO)) . "</td>";
                        echo "<td>Rp" . number_format(intval($value->SUM_TOTAL_PENJUALAN)) . "</td>";


                        /*
            echo "<td>";
              

              echo "<a href='".site_url('c_t_ak_terima_pelanggan_no_faktur/delete/' . $value->ID)."' ";
              
              echo "onclick=\"return confirm('Apakah kamu yakin ingin menghapus data ini?')\"";


              echo "> <i class='feather icon-trash-2 f-w-600 f-16 text-c-red'></i></a>";
            echo "</td>";

            echo "</tr>";
            */
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>












          <!-- !-->
          <div class="col-xl-8 col-md-12">
            <div class="card">
              <div class="card-header">
                <h5>Hutang Supplier</h5>

                
              </div>
              <div class="card-block">
                <div class="dt-responsive table-responsive">
                   <table id="order-table" class="table table-striped table-bordered nowrap">
                    <thead>
                      <th>Nama Akun</th>
                      <th>Saldo</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($c_setting_db_supplier_coa as $key => $value) {
                        echo "<tr>";
                        echo "<td>" . $value->NAMA_AKUN . "</td>";


                        if ($value->DB_K_ID == 1) {
                          $read_saldo = $value->SUM_DEBIT - $value->SUM_KREDIT;
                        }
                        if ($value->DB_K_ID == 2) {
                          $read_saldo = $value->SUM_KREDIT - $value->SUM_DEBIT;
                        }
                        echo "<td> Rp" . number_format(intval($read_saldo)) . "</td>";


                        echo "</tr>";
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>



          


        </div>