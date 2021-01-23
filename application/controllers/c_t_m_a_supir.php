<?php
defined('BASEPATH') or exit('No direct script access allowed');

class c_t_m_a_supir extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_m_a_supir');
  }

  public function index()
  {
    $data = [
      "c_t_m_a_supir" => $this->m_t_m_a_supir->select(),
      "title" => "Master Supir",
      "description" => "Pilihan Supir Untuk T Penjualan PKS"
    ];
    $this->render_backend('template/backend/pages/t_m_a_supir', $data);
  }



  public function delete($id)
  {
    $this->m_t_m_a_supir->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data User Berhasil Dihapus!</p></div>');
    redirect('/c_t_m_a_supir');
  }


  function tambah()
  {
    $supir_id = intval($this->input->post("supir_id"));
    $supir = $this->input->post("supir");

//Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'SUPIR_ID' => $supir_id,
      'SUPIR' => $supir,
    );

    $this->m_t_m_a_supir->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data User Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_m_a_supir');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");
    $supir_id = intval($this->input->post("supir_id"));
    $supir = $this->input->post("supir");

//Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'SUPIR_ID' => $supir_id,
      'SUPIR' => $supir,
    );
    $this->m_t_m_a_supir->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data User Berhasil Diupdate!</strong></p></div>');
    redirect('/c_t_m_a_supir');
  }

}
