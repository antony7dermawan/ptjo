<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_ak_m_db_k extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_ak_m_db_k');
  }

  public function index()
  {
    $data = [
      "c_ak_m_db_k" => $this->m_ak_m_db_k->select(),
      "title" => "Master Debit Kredit",
      "description" => "Pilihan Debit Kredit"
    ];
    $this->render_backend('template/backend/pages/ak_m_db_k', $data);
  }



  public function delete($id)
  {
    $this->m_ak_m_db_k->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('/c_ak_m_db_k');
  }


  function tambah()
  {
    $db_k_id = intval($this->input->post("db_k_id"));
    $db_k = $this->input->post("db_k");

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'DB_K_ID' => $db_k_id,
      'DB_K' => $db_k,
    );

    $this->m_ak_m_db_k->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_ak_m_db_k');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");
    $db_k_id = intval($this->input->post("db_k_id"));
    $db_k = $this->input->post("db_k");

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'DB_K_ID' => $db_k_id,
      'DB_K' => $db_k,
    );
    $this->m_ak_m_db_k->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    redirect('/c_ak_m_db_k');
  }
}
