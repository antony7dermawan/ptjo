<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_ak_m_coa extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_ak_m_coa');
    $this->load->model('m_ak_m_db_k');
    $this->load->model('m_ak_m_family');
    $this->load->model('m_ak_m_type');
    $this->load->model('m_t_ak_jurnal');
  }


  public function index()
  {
    $data = [
      "c_ak_m_coa" => $this->m_ak_m_coa->select(),
      "c_ak_m_db_k" => $this->m_ak_m_db_k->select(),
      "c_ak_m_family" => $this->m_ak_m_family->select(),
      "c_ak_m_type" => $this->m_ak_m_type->select(),
      "c_t_ak_jurnal" => $this->m_t_ak_jurnal->select('2020-01-01', '2100-01-01'),
      "title" => "Master Coa",
      "description" => "Coa untuk Accounting"
    ];

    $this->render_backend('template/backend/pages/ak_m_coa', $data);
  }

  public function update_coa_saldo($coa_id)
  {
    $read_select = $this->m_ak_m_coa->select_coa_id($coa_id);
    foreach ($read_select as $key => $value) {
      $sum_kredit = 0;
      $sum_debit = 0;

      $read_select_1 = $this->m_t_ak_jurnal->select_sum_kredit_detail($coa_id);
      foreach ($read_select_1 as $key_1 => $value_1) {
        $sum_kredit = $value_1->KREDIT;
      }
      $read_select_1 = $this->m_t_ak_jurnal->select_sum_debit_detail($coa_id);
      foreach ($read_select_1 as $key_1 => $value_1) {
        $sum_debit = $value_1->DEBIT;
      }




      if ($value->DB_K_ID == 1) {
        $saldo = $sum_debit - $sum_kredit;
      }
      if ($value->DB_K_ID == 2) {
        $saldo = $sum_kredit - $sum_debit;
      }

      if ($value->FAMILY_ID == 3) {
        $data = array(
          'SALDO' => $saldo
        );
        $this->m_ak_m_coa->update($data, $coa_id);
      }
    }
  }


  public function delete($id)
  {
    $this->m_ak_m_coa->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('/c_ak_m_coa');
  }



  function tambah()
  {
    $no_akun_1 = substr($this->input->post("no_akun_1"), 0, 50);
    $no_akun_2 = substr($this->input->post("no_akun_2"), 0, 50);
    $no_akun_3 = substr($this->input->post("no_akun_3"), 0, 50);


    $nama_akun = substr($this->input->post("nama_akun"), 0, 100);

    $type_id = intval($this->input->post("type_id"));
    $saldo = 0;
    $db_k_id = intval($this->input->post("db_k_id"));
    $family_id = intval($this->input->post("family_id"));

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'NO_AKUN_1' => $no_akun_1,
      'NAMA_AKUN' => $nama_akun,
      'TYPE_ID' => $type_id,
      'SALDO' => $saldo,
      'DB_K_ID' => $db_k_id,
      'FAMILY_ID' => $family_id,
      'NO_AKUN_2' => $no_akun_2,
      'NO_AKUN_3' => $no_akun_3,
      'COMPANY_ID' => $this->session->userdata('company_id')
    );

    $this->m_ak_m_coa->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_ak_m_coa');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");


    $no_akun_1 = ($this->input->post("no_akun_1"));
    $no_akun_2 = ($this->input->post("no_akun_2"));
    $no_akun_3 = ($this->input->post("no_akun_3"));


    $nama_akun = ($this->input->post("nama_akun"));


    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'NO_AKUN_1' => $no_akun_1,
      'NAMA_AKUN' => $nama_akun,
      'NO_AKUN_2' => $no_akun_2,
      'NO_AKUN_3' => $no_akun_3
    );
    $this->m_ak_m_coa->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    redirect('/c_ak_m_coa');
  }
}
