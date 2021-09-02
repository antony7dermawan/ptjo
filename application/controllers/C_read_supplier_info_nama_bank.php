<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_read_supplier_info_nama_bank extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('m_t_m_d_supplier');
  }


  public function index()
  {
    $supplier_id = intval($this->input->post("id"));
    $read_select = $this->m_t_m_d_supplier->select_by_id($supplier_id);
    foreach ($read_select as $key => $value) 
    {

      echo $value->NAMA_BANK;
      
      
    }
  }


}
