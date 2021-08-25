<div class="pcoded-inner-content">
  <div class="main-body">
    <div class="page-wrapper">
      <div class="page-body">

        <div class="row">



<?php

$level_user_id = $this->session->userdata('level_user_id');


if($level_user_id>=1)
{


?>

















          <!-- !-->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5>Rekap Invoice PO yang Belum Lunas

                <?= $this->session->flashdata('notif') ?>

                </h5>

                
              </div>
              <div class="card-block">
                <div class="dt-responsive table-responsive">
                  <table id="order-table" class="table table-striped table-bordered nowrap">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>INV</th>
                        <th>Date</th>
                        <th>Ket</th>
                        <th>Supplier</th>
                        <th>INV Sp</th>
                        <th>Payment Method</th>
                        
                        <th>Total</th>
                        <th>Sudah Dibayar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($c_t_t_t_pembelian as $key => $value) {
                        if($value->MARK_FOR_DELETE == 'f')
                        {
                          echo "<tr>";
                          echo "<td>" . ($key + 1) . "</td>";
                          echo "<td>" . $value->INV . "</td>";
                          echo "<td>" . date('d-m-Y', strtotime($value->DATE)) . " / " . date('H:i', strtotime($value->TIME)) . "</td>";
                          echo "<td>" . $value->KET . "</td>";
                          echo "<td>" . $value->SUPPLIER . "</td>";
                          echo "<td>" . $value->INV_SUPPLIER . "</td>";
                          echo "<td>" . $value->PAYMENT_METHOD . "</td>";



                          //satu button
                          echo "<td>";
                        
                          echo " Rp" . number_format(intval($value->SUM_SUB_TOTAL + $value->SUM_PPN)) . "</td>";
                          //satu button


                          echo "<td>";

                          echo " Rp" . number_format(intval($value->PAYMENT_T)) . "</td>";
                          
                   

                          echo "</tr>";
                        }









                        

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
                <h5>Rekap Hutang Supplier

                <?= $this->session->flashdata('notif') ?>

                </h5>

                
              </div>
              <div class="card-block">
                <div class="dt-responsive table-responsive">
                  <table id="order-table" class="table table-striped table-bordered nowrap">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Supplier</th>
                        <th>Total Pembelian</th>
                        <th>Sudah Dibayarkan</th>
                        <th>Sisa Utang</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($select_hutang_supplier as $key => $value) {
                  
                          echo "<tr>";
                          echo "<td>" . ($key + 1) . "</td>";
                          echo "<td>" . $value->SUPPLIER. "</td>";
                         

                          echo "<td> Rp" . number_format(intval($value->SUM_SUB_TOTAL+$value->SUM_PPN)) . "</td>";
                          echo "<td> Rp" . number_format(intval($value->SUM_PAYMENT_T)) . "</td>";
                          echo "<td> Rp" . number_format(intval($value->SUM_SUB_TOTAL+$value->SUM_PPN)-($value->SUM_PAYMENT_T)) . "</td>";



                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>















<?php
}
?>



          


        </div>