<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_ak_m_type extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_ak_m_type');
  }

  public function index()
  {
    $data = [
      "c_ak_m_type" => $this->m_ak_m_type->select(),
      "title" => "Master COA Type",
      "description" => "Pilihan COA Type"
    ];
    $this->render_backend('template/backend/pages/ak_m_type', $data);
  }



  public function delete($id)
  {
    $this->m_ak_m_type->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('/c_ak_m_type');
  }


  function tambah()
  {
    $type_id = intval($this->input->post("type_id"));
    $type = $this->input->post("type");

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'TYPE_ID' => $type_id,
      'TYPE' => $type,
    );

    $this->m_ak_m_type->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_ak_m_type');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");
    $type_id = intval($this->input->post("type_id"));
    $type = $this->input->post("type");

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'TYPE_ID' => $type_id,
      'TYPE' => $type,
    );

    $this->m_ak_m_type->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    redirect('/c_ak_m_type');
  }
}
