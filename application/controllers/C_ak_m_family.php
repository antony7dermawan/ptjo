<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_ak_m_family extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_ak_m_family');
  }

  public function index()
  {
    $data = [
      "c_ak_m_family" => $this->m_ak_m_family->select(),
      "title" => "Master COA Family",
      "description" => "Pilihan COA Family"
    ];
    $this->render_backend('template/backend/pages/ak_m_family', $data);
  }



  public function delete($id)
  {
    $this->m_ak_m_family->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('/c_ak_m_family');
  }


  function tambah()
  {
    $family_id = intval($this->input->post("family_id"));
    $family = $this->input->post("family");

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'FAMILY_ID' => $family_id,
      'FAMILY' => $family,
    );

    $this->m_ak_m_family->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_ak_m_family');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");
    $family_id = intval($this->input->post("family_id"));
    $family = $this->input->post("family");

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'FAMILY_ID' => $family_id,
      'FAMILY' => $family,
    );

    $this->m_ak_m_family->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    redirect('/c_ak_m_family');
  }
}
