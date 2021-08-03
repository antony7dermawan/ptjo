<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_info_stock extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();


    $this->load->model('m_t_m_d_company');
    $this->load->model('m_t_m_d_barang');
    $this->load->model('m_t_m_d_kategori');
    $this->load->model('m_t_m_d_satuan');
  }

  public function index()
  {
    $this->session->set_userdata('t_m_d_company_delete_logic', '0');
    $this->session->set_userdata('t_m_d_kategori_delete_logic', '0');
    
    $this->session->set_userdata('t_m_d_barang_delete_logic', '1');
    $data = [
      "c_t_m_d_company" => $this->m_t_m_d_company->select(),
      "c_t_info_stock" => $this->m_t_m_d_barang->select_info_stock(),
      "c_t_m_d_kategori" => $this->m_t_m_d_kategori->select_option(),
      "c_t_m_d_satuan" => $this->m_t_m_d_satuan->select_option(),
      "title" => "Info Stock",
      "description" => "Data Barang Semua Gudang"
    ];
    $this->render_backend('template/backend/pages/t_info_stock', $data);
  }

  public function change_kategori_id()
  {
    $master_barang_kategori_id = ($this->input->post("kategori_id"));
    $this->session->set_userdata('master_barang_kategori_id', $master_barang_kategori_id);
    redirect('/c_t_info_stock');
  }

  public function change_company_id()
  {
    $master_barang_company_id = ($this->input->post("company_id"));
    $this->session->set_userdata('master_barang_company_id', $master_barang_company_id);
    redirect('/c_t_info_stock');
  }

 


}
