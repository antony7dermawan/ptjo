<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_m_a_no_polisi extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_m_a_no_polisi');
  }

  public function index()
  {
    $data = [
      "c_t_m_a_no_polisi" => $this->m_t_m_a_no_polisi->select(),
      "title" => "Master No Polisi",
      "description" => "Pilihan Plat Untuk T Penjualan PKS"
    ];
    $this->render_backend('template/backend/pages/t_m_a_no_polisi', $data);
  }



  public function delete($id)
  {
    $this->m_t_m_a_no_polisi->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('/c_t_m_a_no_polisi');
  }


  function tambah()
  {
    $no_polisi_id = intval($this->input->post("no_polisi_id"));
    $no_polisi = $this->input->post("no_polisi");

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'NO_POLISI_ID' => $no_polisi_id,
      'NO_POLISI' => $no_polisi,
    );

    $this->m_t_m_a_no_polisi->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_m_a_no_polisi');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");
    $no_polisi_id = intval($this->input->post("no_polisi_id"));
    $no_polisi = $this->input->post("no_polisi");

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'NO_POLISI_ID' => $no_polisi_id,
      'NO_POLISI' => $no_polisi,
    );
    $this->m_t_m_a_no_polisi->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    redirect('/c_t_m_a_no_polisi');
  }
}
