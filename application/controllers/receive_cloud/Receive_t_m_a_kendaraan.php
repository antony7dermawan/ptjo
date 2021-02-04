<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Receive_t_m_a_kendaraan extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('m_t_m_a_kendaraan');
  }




  public function index()
  {
    include('db_connection.php');
    if( $conn )
    {
      $query = "SELECT * FROM \"T_M_A_KENDARAAN\" ";
      $result = pg_query($query) or die('Error message: ' . pg_last_error());

      while($value = pg_fetch_row($result))
      {
        $r_id[] = ($value[0]);
        $r_kendaraan_id[] = ($value[1]);
        $r_kendaraan[] = ($value[2]);
      }
      foreach( array_keys($r_id) as $total_r_id){}




      for($i=0;$i<=$total_r_id;$i++)
      {
        $insert_logic = 1;
        $read_select = $this->m_t_m_a_kendaraan->select_by_id($r_id[$i]);
        foreach ($read_select as $key => $value) 
        {
          $insert_logic = 0;
        }
        if($insert_logic==0) //melakukan update coa
        {
          $data = array(
            'KENDARAAN_ID' => $r_kendaraan_id[$i],
            'KENDARAAN' => $r_kendaraan[$i]
          );

          $this->m_t_m_a_kendaraan->update($data, $r_id[$i]);
          echo "done update ID={$r_id[$i]} , KENDARAAN={$r_kendaraan[$i]} <br>";
        }
        if($insert_logic==1) //melakukan insert coa
        {
          $data = array(
            'ID' => $r_id[$i],
            'KENDARAAN_ID' => $r_kendaraan_id[$i],
            'KENDARAAN' => $r_kendaraan[$i]
          );

          $this->m_t_m_a_kendaraan->tambah($data);
          echo "done insert ID={$r_id[$i]} , KENDARAAN={$r_kendaraan[$i]} <br>";
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
