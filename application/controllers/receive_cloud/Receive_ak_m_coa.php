<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Receive_ak_m_coa extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('m_ak_m_coa');
  }




  public function index()
  {
    include('db_connection.php');
    if( $conn )
    {
      $query = "SELECT * FROM \"AK_M_COA\" ";
      $result = pg_query($query) or die('Error message: ' . pg_last_error());

      while($value = pg_fetch_row($result))
      {
        $r_id[] = ($value[0]);
        $r_no_akun_1[] = ($value[1]);
        $r_nama_akun[] = ($value[2]);
        $r_type_id[] = ($value[3]);
        $r_saldo[] = ($value[4]);
        $r_db_k_id[] = ($value[5]);
        $r_family_id[] = ($value[6]);
        $r_no_akun_2[] = ($value[7]);
        $r_no_akun_3[] = ($value[8]);
        $r_created_by[] = ($value[9]);
        $r_area_id[] = ($value[10]);
        $r_company_id[] = ($value[11]);
      }
      foreach( array_keys($r_id) as $total_r_id){}




      for($i=0;$i<=$total_r_id;$i++)
      {
        $insert_logic = 1;
        $read_select = $this->m_ak_m_coa->select_coa_id($r_id[$i]);
        foreach ($read_select as $key => $value) 
        {
          $insert_logic = 0;
        }
        if($insert_logic==0) //melakukan update coa
        {
          $data = array(
            'NO_AKUN_1' => $r_no_akun_1[$i],
            'NAMA_AKUN' => $r_nama_akun[$i],
            'TYPE_ID' => $r_type_id[$i],
            'SALDO' => $r_saldo[$i],
            'DB_K_ID' => $r_db_k_id[$i],
            'FAMILY_ID' => $r_family_id[$i],
            'NO_AKUN_2' => $r_no_akun_2[$i],
            'NO_AKUN_3' => $r_no_akun_3[$i],
            'CREATED_BY' => $r_created_by[$i],
            'AREA_ID' => $r_area_id[$i],
            'COMPANY_ID' => $r_company_id[$i]
          );

          $this->m_ak_m_coa->update($data, $r_id[$i]);
          echo "done update ID={$r_id[$i]} , NAMA AKUN={$r_nama_akun[$i]} <br>";
        }
        if($insert_logic==1) //melakukan insert coa
        {
          $data = array(
            'ID' => $r_id[$i],
            'NO_AKUN_1' => $r_no_akun_1[$i],
            'NAMA_AKUN' => $r_nama_akun[$i],
            'TYPE_ID' => $r_type_id[$i],
            'SALDO' => $r_saldo[$i],
            'DB_K_ID' => $r_db_k_id[$i],
            'FAMILY_ID' => $r_family_id[$i],
            'NO_AKUN_2' => $r_no_akun_2[$i],
            'NO_AKUN_3' => $r_no_akun_3[$i],
            'CREATED_BY' => $r_created_by[$i],
            'AREA_ID' => $r_area_id[$i],
            'COMPANY_ID' => $r_company_id[$i]
          );

          $this->m_ak_m_coa->tambah($data);
          echo "done insert ID={$r_id[$i]} , NAMA AKUN={$r_nama_akun[$i]} <br>";
        }

      }




      
      echo  "Semua Data Sudah Diupdate";
   
    }
    else
    {
      echo "Tidak Ada Internet, Silahkan Periksa Jaringan dan Ulangi Send to Cloud!";
      
    }

     
  }


}
