<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_ak_jurnal_history extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_ak_jurnal_history');
    $this->load->model('m_t_ak_jurnal_edit');
    $this->load->model('m_ak_m_coa');
    $this->load->model('m_ak_m_family');
    $this->load->model('m_ak_m_type');
  }


  public function index()
  {
    $this->m_t_ak_jurnal_history->delete_created_by();
    $data = [
      "c_t_ak_jurnal_history" => $this->m_t_ak_jurnal_history->select($this->session->userdata('date_from_select_jurnal'), $this->session->userdata('date_to_select_jurnal'), $this->session->userdata('coa_id_jurnal_history')),
      "no_akun_option" => $this->m_ak_m_coa->select_no_akun(),
      "c_ak_m_family" => $this->m_ak_m_family->select(),
      "c_ak_m_type" => $this->m_ak_m_type->select(),
      "title" => "History Detail Jurnal",
      "description" => ""
    ];
    $this->render_backend('template/backend/pages/t_ak_jurnal_history', $data);
  }

  public function search_date()
  {
    $date_from_select_jurnal = ($this->input->post("date_from_select_jurnal"));
    $this->session->set_userdata('date_from_select_jurnal', $date_from_select_jurnal);

    $date_to_select_jurnal = ($this->input->post("date_to_select_jurnal"));
    $this->session->set_userdata('date_to_select_jurnal', $date_to_select_jurnal);

    $coa_id_jurnal_history = intval($this->input->post("coa_id_jurnal_history"));
    $this->session->set_userdata('coa_id_jurnal_history', $coa_id_jurnal_history);



    redirect('/c_t_ak_jurnal_history');
  }





}
