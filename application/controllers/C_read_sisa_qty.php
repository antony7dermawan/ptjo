<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_read_sisa_qty extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('m_t_t_t_pembelian_rincian');
  }


  public function index()
  {
    $barang_id = intval($this->input->post("id"));
    $sisa_qty_tt = 0;
    $read_select = $this->m_t_t_t_pembelian_rincian->select_sisa_qty_for_1_barang_id($barang_id);
    foreach ($read_select as $key => $value) 
    {
      $sisa_qty_tt = $value->SUM_SISA_QTY;
    }

    echo $sisa_qty_tt;
  }


}
