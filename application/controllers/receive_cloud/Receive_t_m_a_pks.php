<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Receive_t_m_a_pks extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('m_t_m_a_pks');
  }




  public function index()
  {
    include('db_connection.php');
    if( $conn )
    {
      $query = "SELECT * FROM \"T_M_A_PKS\" ";
      $result = pg_query($query) or die('Error message: ' . pg_last_error());

      while($value = pg_fetch_row($result))
      {
        $r_id[] = ($value[0]);
        $r_pks_id[] = ($value[1]);
        $r_pks[] = ($value[2]);
        $r_no_pelanggan[] = ($value[3]);
        $r_nama[] = ($value[4]);
        $r_alamat[] = ($value[5]);
        $r_npwp[] = ($value[6]);
        $r_telepon[] = ($value[7]);
        $r_created_by[] = ($value[8]);
        $r_updated_by[] = ($value[9]);
      }
      foreach( array_keys($r_id) as $total_r_id){}




      for($i=0;$i<=$total_r_id;$i++)
      {
        $insert_logic = 1;
        $read_select = $this->m_t_m_a_pks->select_by_id($r_id[$i]);
        foreach ($read_select as $key => $value) 
        {
          $insert_logic = 0;
        }
        if($insert_logic==0) //melakukan update coa
        {
          $data = array(
            'PKS_ID' => $r_pks_id[$i],
            'PKS' => $r_pks[$i],
            'NO_PELANGGAN' => $r_no_pelanggan[$i],
            'NAMA' => $r_nama[$i],
            'ALAMAT' => $r_alamat[$i],
            'NPWP' => $r_npwp[$i],
            'TELEPON' => $r_telepon[$i],
            'CREATED_BY' => $r_created_by[$i],
            'UPDATED_BY' => $r_updated_by[$i]
          );

          $this->m_t_m_a_pks->update($data, $r_id[$i]);
          echo "done update ID={$r_id[$i]} , PKS={$r_pks[$i]} <br>";
        }
        if($insert_logic==1) //melakukan insert coa
        {
          $data = array(
            'ID' => $r_id[$i],
            'PKS_ID' => $r_pks_id[$i],
            'PKS' => $r_pks[$i],
            'NO_PELANGGAN' => $r_no_pelanggan[$i],
            'NAMA' => $r_nama[$i],
            'ALAMAT' => $r_alamat[$i],
            'NPWP' => $r_npwp[$i],
            'TELEPON' => $r_telepon[$i],
            'CREATED_BY' => $r_created_by[$i],
            'UPDATED_BY' => $r_updated_by[$i]
          );

          $this->m_t_m_a_pks->tambah($data);
          echo "done insert ID={$r_id[$i]} , PKS={$r_pks[$i]} <br>";
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
