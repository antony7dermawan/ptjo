<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Send_t_ak_jurnal extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('m_t_ak_jurnal');
    $this->load->model('m_send_t_ak_jurnal');
  }




  public function index()
  {
    include('db_connection.php');
    if( $conn )
    {
      $read_select = $this->m_send_t_ak_jurnal->select($this->session->userdata('date_from_select_jurnal'), $this->session->userdata('date_to_select_jurnal'));
      foreach ($read_select as $key => $value) 
      {
        $read_id = $value->ID;
        $read_coa_id = intval($value->COA_ID);
        $read_debit = intval($value->DEBIT);
        $read_kredit = intval($value->KREDIT);
        $read_catatan = ($value->CATATAN);
        $read_departemen = ($value->DEPARTEMEN);
        $read_no_voucer = ($value->NO_VOUCER);
        $read_date = ($value->DATE);
        $read_time = ($value->TIME);
        $read_created_by = ($value->CREATED_BY);
        $read_updated_by = ($value->UPDATED_BY);
        $read_created_id = intval($value->CREATED_ID);
        $read_checked_id = 1; // satu di online buka buku
        $read_special_id = intval($value->SPECIAL_ID);


        $query = pg_query($conn, "INSERT INTO public.\"T_AK_JURNAL\"(
        \"COA_ID\", \"DEBIT\", \"KREDIT\", \"CATATAN\", \"DEPARTEMEN\", \"NO_VOUCER\", \"DATE\", \"TIME\", \"CREATED_BY\", \"UPDATED_BY\", \"CREATED_ID\", \"CHECKED_ID\", \"SPECIAL_ID\")
        VALUES ('{$read_coa_id}', '{$read_debit}', '{$read_kredit}', '{$read_catatan}', '{$read_departemen}', '{$read_no_voucer}', '{$read_date}', '{$read_time}', '{$read_created_by}', '{$read_updated_by}', '{$read_created_id}', '{$read_checked_id}', '{$read_id}');");
        if ( $query ) {
            echo  "Record Successfully Added! for ID = {$read_id} / NO_VOUCER = {$read_no_voucer}<br>";

            $data = array(
            'CHECKED_ID' => 1
            );
            $this->m_t_ak_jurnal->update($data, $read_id);
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
