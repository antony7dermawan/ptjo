<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_m_a_divisi extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_m_a_divisi');
  }

  public function index()
  {
    $data = [
      "c_t_m_a_divisi" => $this->m_t_m_a_divisi->select(),
      "title" => "Master Divisi",
      "description" => "Divisi Untuk T Penjualan PKS"
    ];
    $this->render_backend('template/backend/pages/t_m_a_divisi', $data);
  }



  public function delete($id)
  {
    $this->m_t_m_a_divisi->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data User Berhasil Dihapus!</p></div>');
    redirect('/c_t_m_a_divisi');
  }


  function tambah()
  {
    $divisi_id = intval($this->input->post("divisi_id"));
    $divisi = $this->input->post("divisi");

//Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'DIVISI_ID' => $divisi_id,
      'DIVISI' => $divisi,
    );

    $this->m_t_m_a_divisi->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data User Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_m_a_divisi');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");
    $divisi_id = intval($this->input->post("divisi_id"));
    $divisi = $this->input->post("divisi");

    $data = array(
      'DIVISI_ID' => $divisi_id,
      'DIVISI' => $divisi
    );
    $this->m_t_m_a_divisi->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data User Berhasil Diupdate!</strong></p></div>');
    redirect('/c_t_m_a_divisi');
  }

}
