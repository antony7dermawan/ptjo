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
    if($this->session->userdata('date_from_select_jurnal')=='')
    {
      $date_from_select_jurnal = date('Y-m-d');
      $this->session->set_userdata('date_from_select_jurnal', $date_from_select_jurnal);
    }

    if($this->session->userdata('date_to_select_jurnal')=='')
    {
      $date_to_select_jurnal = date('Y-m-d');
      $this->session->set_userdata('date_to_select_jurnal', $date_to_select_jurnal);
    }


    if($this->session->userdata('coa_id_jurnal_history')=='')
    {
      $coa_id_jurnal_history = 1;
      $this->session->set_userdata('coa_id_jurnal_history', $coa_id_jurnal_history);
    }


    $read_select = $this->m_t_ak_jurnal_history->select_old_data($this->session->userdata('date_from_select_jurnal'),$this->session->userdata('coa_id_jurnal_history'));
    foreach ($read_select as $key => $value) 
    {
      $sum_debit = $value->DEBIT;
      $sum_kredit = $value->KREDIT;
    }


    $read_select = $this->m_ak_m_coa->select_coa_id($this->session->userdata('coa_id_jurnal_history'));
    foreach ($read_select as $key => $value) 
    {
      $db_k_id = $value->DB_K_ID;
    }

    if($db_k_id==1)#kode 1 debit / 2 kredit
    {
      $saldo_awal = $sum_debit - $sum_kredit;
    }

    if($db_k_id==2)#kode 1 debit / 2 kredit
    {
      $saldo_awal = $sum_kredit - $sum_debit;
    }


    

    $this->m_t_ak_jurnal_history->delete_created_by();
    $data = [
      "c_t_ak_jurnal_history" => $this->m_t_ak_jurnal_history->select($this->session->userdata('date_from_select_jurnal'), $this->session->userdata('date_to_select_jurnal'), $this->session->userdata('coa_id_jurnal_history')),
      "no_akun_option" => $this->m_ak_m_coa->select_no_akun(),
      "c_ak_m_family" => $this->m_ak_m_family->select(),
      "c_ak_m_type" => $this->m_ak_m_type->select(),
      "title" => "History Detail Jurnal",
      "description" => "",
      "saldo_awal" => $saldo_awal
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
