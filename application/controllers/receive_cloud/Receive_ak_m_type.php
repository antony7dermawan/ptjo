<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Receive_ak_m_type extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('m_ak_m_type');
  }




  public function index()
  {
    include('db_connection.php');
    if( $conn )
    {
      $query = "SELECT * FROM \"AK_M_TYPE\" ";
      $result = pg_query($query) or die('Error message: ' . pg_last_error());

      while($value = pg_fetch_row($result))
      {
        $r_id[] = ($value[0]);
        $r_type_id[] = ($value[1]);
        $r_type[] = ($value[2]);
      }
      foreach( array_keys($r_id) as $total_r_id){}




      for($i=0;$i<=$total_r_id;$i++)
      {
        $insert_logic = 1;
        $read_select = $this->m_ak_m_type->select_by_id($r_id[$i]);
        foreach ($read_select as $key => $value) 
        {
          $insert_logic = 0;
        }
        if($insert_logic==0) //melakukan update coa
        {
          $data = array(
            'TYPE_ID' => $r_type_id[$i],
            'TYPE' => $r_type[$i]
          );

          $this->m_ak_m_type->update($data, $r_id[$i]);
          echo "done update ID={$r_id[$i]} , TYPE={$r_type[$i]} <br>";
        }
        if($insert_logic==1) //melakukan insert coa
        {
          $data = array(
            'ID' => $r_id[$i],
            'TYPE_ID' => $r_type_id[$i],
            'TYPE' => $r_type[$i]
          );

          $this->m_ak_m_type->tambah($data);
          echo "done insert ID={$r_id[$i]} , TYPE={$r_type[$i]} <br>";
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
