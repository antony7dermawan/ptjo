<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_setting_db_bank_coa extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_setting_db_bank_coa');
    $this->load->model('m_ak_m_coa');
  }

  public function index()
  {
    $data = [
      "c_setting_db_bank_coa" => $this->m_setting_db_bank_coa->select('2021-01-01', '2100-01-01'),
      "no_akun_option" => $this->m_ak_m_coa->select_no_akun(),
      "title" => "SETTING BANK COA",
      "description" => "Pilihan COA Bank untuk nampil di DASHBOARD"
    ];
    $this->render_backend('template/backend/pages/setting_db_bank_coa', $data);
  }



  public function delete($id)
  {
    $this->m_setting_db_bank_coa->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil Dihapus!</p></div>');
    redirect('/c_setting_db_bank_coa');
  }


  function tambah()
  {
    $coa_id = intval($this->input->post("coa_id"));

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'COA_ID' => $coa_id,
      'CREATED_BY' => $this->session->userdata('username'),
      'UPDATED_BY' => $this->session->userdata('username')
    );

    $this->m_setting_db_bank_coa->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_setting_db_bank_coa');
  }





  /*
  public function edit_action()
  {
    $id = $this->input->post("id");
    $coa_id = intval($this->input->post("type_id"));

//Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'COA_ID' => $coa_id,
      'CREATED_BY' => $this->session->userdata('name'),
      'UPDATED_BY' => $this->session->userdata('name')
    );

    $this->m_ak_m_type->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    redirect('/c_setting_db_bank_coa');
  }
*/
}
