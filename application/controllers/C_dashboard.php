<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_dashboard extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_setting_db_supplier_coa');
    $this->load->model('m_setting_db_bank_coa');
    $this->load->model('m_t_ak_faktur_penjualan');
    $this->load->model('m_t_t_a_penjualan_pks');
  }


  public function index()
  {
    $data = [
      "c_setting_db_bank_coa" => $this->m_setting_db_bank_coa->select('2021-01-01','2100-01-01'),
      "c_setting_db_supplier_coa" => $this->m_setting_db_supplier_coa->select('2021-01-01','2100-01-01'),
      "select_no_faktur" => $this->m_t_ak_faktur_penjualan->select_no_faktur(),
      "pengiriman_select" => $this->m_t_t_a_penjualan_pks->select_sum_in_date($this->session->userdata('date_from_dashboard'),$this->session->userdata('date_to_dashboard')),
      "title" => "Dashboard",
      "description" => "Web Version:21-01-25 20:28"
    ];

    $this->render_backend('template/backend/pages/dashboard', $data);
  }

  public function search_date()
  {
    $date_from_dashboard = ($this->input->post("date_from_dashboard"));
    $this->session->set_userdata('date_from_dashboard', $date_from_dashboard);

    $date_to_dashboard = ($this->input->post("date_to_dashboard"));
    $this->session->set_userdata('date_to_dashboard', $date_to_dashboard);
    redirect('/c_dashboard');
  }

}
