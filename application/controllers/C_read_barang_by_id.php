<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_read_barang_by_id extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('m_t_m_d_barang');
  }


  public function index()
  {
    $barang_id = intval($this->input->post("id"));
    $read_select = $this->m_t_m_d_barang->select_by_id($barang_id);
    foreach ($read_select as $key => $value) 
    {



      
      echo $value->HARGA_JUAL;
      
    }
  }


}
