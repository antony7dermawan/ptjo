<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Send_t_t_a_penjualan_pks extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('m_t_t_a_penjualan_pks');
    $this->load->model('m_send_t_t_a_penjualan_pks');
  }

  public function index()
  {
    include('db_connection.php');
    if( $conn )
    {
      $read_select = $this->m_send_t_t_a_penjualan_pks->select($this->session->userdata('date_penjualan_pks'));
      foreach ($read_select as $key => $value) 
      {
        $read_id = $value->ID;
        $read_date = $value->DATE;
        $read_time = $value->TIME;
        $read_divisi_id = intval($value->DIVISI_ID);
        $read_pks_id = intval($value->PKS_ID);
        $read_no_polisi_id = intval($value->NO_POLISI_ID);
        $read_supir_id = intval($value->SUPIR_ID);
        $read_kendaraan_id = intval($value->KENDARAAN_ID);
        $read_no_tiket = $value->NO_TIKET;
        $read_bruto = floatval($value->BRUTO);
        $read_sortase_percentage = floatval($value->SORTASE_PERCENTAGE);
        $read_sortase_kg = floatval($value->SORTASE_KG);
        $read_neto = floatval($value->NETO);
        $read_r_jo = intval($value->R_JO);
        $read_r_ex = intval($value->R_EX);
        $read_r_div_1 = intval($value->R_DIV_1);
        $read_r_div_2 = intval($value->R_DIV_2);
        $read_r_div_3 = intval($value->R_DIV_3);
        $read_r_div_4 = intval($value->R_DIV_4);
        $read_rumus = floatval($value->RUMUS);
        $read_uang_jalan = floatval($value->UANG_JALAN);
        $read_tambahan = floatval($value->TAMBAHAN);
        $read_total_uang_jalan = floatval($value->TOTAL_UANG_JALAN);
        $read_harga = floatval($value->HARGA);
        $read_total_penjualan = floatval($value->TOTAL_PENJUALAN);
        $read_ppn = floatval($value->PPN);
        $read_created_by = $value->CREATED_BY;
        $read_updated_by = $value->UPDATED_BY;
        $read_area_id = intval($value->AREA_ID);
        $read_company_id = intval($value->COMPANY_ID);
        $read_inv = $value->INV;
        $read_inv_int = intval($value->INV_INT);
        $read_enable_edit = intval($value->ENABLE_EDIT);
        $read_checked_id = intval($value->CHECKED_ID);
        $read_special_id = intval($value->SPECIAL_ID);

        //send to cloud
        //$DB_TABLE_NAME = 'T_T_A_PENJUALAN_PKS';
        /*
        $insert_db = "insert into {$DB_TABLE_NAME} values ('{$read_date}','{$read_time}','{$read_divisi_id}','{$read_pks_id}','{$read_no_polisi_id}','{$read_supir_id}','{$read_kendaraan_id}','{$read_no_tiket}','{$read_bruto}','{$read_sortase_percentage}','{$read_sortase_kg}','{$read_neto}','{$read_r_jo}','{$read_r_ex}','{$read_r_div_1}','{$read_r_div_2}','{$read_r_div_3}','{$read_r_div_4}','{$read_rumus}','{$read_uang_jalan}','{$read_tambahan}','{$read_total_uang_jalan}','{$read_harga}','{$read_total_penjualan}','{$read_ppn}','{$read_created_by}','{$read_updated_by}','{$read_area_id}','{$read_company_id}','{$read_inv}','{$read_inv_int}','{$read_enable_edit}','{$read_checked_id}','{$read_special_id}')";
        $insert_ex = $conn->query($insert_db); */

       // $values_insert = '{$read_date}','{$read_time}','{$read_divisi_id}','{$read_pks_id}','{$read_no_polisi_id}','{$read_supir_id}','{$read_kendaraan_id}','{$read_no_tiket}','{$read_bruto}','{$read_sortase_percentage}','{$read_sortase_kg}','{$read_neto}','{$read_r_jo}','{$read_r_ex}','{$read_r_div_1}','{$read_r_div_2}','{$read_r_div_3}','{$read_r_div_4}','{$read_rumus}','{$read_uang_jalan}','{$read_tambahan}','{$read_total_uang_jalan}','{$read_harga}','{$read_total_penjualan}','{$read_ppn}','{$read_created_by}','{$read_updated_by}','{$read_area_id}','{$read_company_id}','{$read_inv}','{$read_inv_int}','{$read_enable_edit}','{$read_checked_id}','{$read_special_id}';

        $query = pg_query($conn, "INSERT INTO public.\"T_T_A_PENJUALAN_PKS\"(
    \"DATE\", \"TIME\", \"DIVISI_ID\", \"PKS_ID\", \"NO_POLISI_ID\", \"SUPIR_ID\", \"KENDARAAN_ID\", \"NO_TIKET\", \"BRUTO\", \"SORTASE_PERCENTAGE\", \"SORTASE_KG\", \"NETO\", \"R_JO\", \"R_EX\", \"R_DIV_1\", \"R_DIV_2\", \"R_DIV_3\", \"R_DIV_4\", \"RUMUS\", \"UANG_JALAN\", \"TAMBAHAN\", \"TOTAL_UANG_JALAN\", \"HARGA\", \"TOTAL_PENJUALAN\", \"PPN\", \"CREATED_BY\", \"UPDATED_BY\", \"AREA_ID\", \"COMPANY_ID\", \"INV\", \"INV_INT\", \"ENABLE_EDIT\", \"CHECKED_ID\", \"SPECIAL_ID\")
    VALUES ('{$read_date}','{$read_time}','{$read_divisi_id}','{$read_pks_id}','{$read_no_polisi_id}','{$read_supir_id}','{$read_kendaraan_id}','{$read_no_tiket}','{$read_bruto}','{$read_sortase_percentage}','{$read_sortase_kg}','{$read_neto}','{$read_r_jo}','{$read_r_ex}','{$read_r_div_1}','{$read_r_div_2}','{$read_r_div_3}','{$read_r_div_4}','{$read_rumus}','{$read_uang_jalan}','{$read_tambahan}','{$read_total_uang_jalan}','{$read_harga}','{$read_total_penjualan}','{$read_ppn}','{$read_created_by}','{$read_updated_by}','{$read_area_id}','{$read_company_id}','{$read_inv}','{$read_inv_int}','{$read_enable_edit}','{$read_checked_id}','{$read_id}');");
        if ( $query ) {
            echo  "Record Successfully Added! for ID = {$read_id} / NO_TIKET = {$read_no_tiket}<br>";
            $data = array(
            'CHECKED_ID' => 1
            );
            $this->m_t_t_a_penjualan_pks->update($data, $read_id);
        }


        





      }
      echo  "Semua Data Sudah Dikirim";
   
    }
    else
    {
      echo "Tidak Ada Internet, Silahkan Periksa Jaringan dan Ulangi Send to Cloud!";
      
    }

     
  }


}
