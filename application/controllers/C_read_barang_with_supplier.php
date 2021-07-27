<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_read_barang_with_supplier extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('m_t_t_t_pembelian_rincian');
  }


  public function index()
  {
    $barang_id = intval($this->input->post("id"));
    $read_select = $this->m_t_t_t_pembelian_rincian->select_barang_with_supplier($barang_id);
    foreach ($read_select as $key => $value) 
    {



      echo "<tr>";
      
      echo "<td>";
      echo $key+1;
      echo "</td>";

      echo "<td>";
      echo $value->SUPPLIER;
      echo "</td>";

      echo "<td>";
      echo 'Rp'.number_format($value->HARGA);
      echo "</td>";
      
      echo "<td>";
      echo date('d-m-Y', strtotime($value->DATE));
      echo "</td>";
      
      echo "</tr>";
    }
  }


}
