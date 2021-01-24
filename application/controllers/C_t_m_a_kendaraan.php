<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_m_a_kendaraan extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_m_a_kendaraan');
  }

  public function index()
  {
    $data = [
      "c_t_m_a_kendaraan" => $this->m_t_m_a_kendaraan->select(),
      "title" => "Master Kendaraan",
      "description" => "Kendaraan Untuk T Penjualan PKS"
    ];
    $this->render_backend('template/backend/pages/t_m_a_kendaraan', $data);
  }



  public function delete($id)
  {
    $this->m_t_m_a_kendaraan->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('/c_t_m_a_kendaraan');
  }


  function tambah()
  {
    $kendaraan_id = intval($this->input->post("kendaraan_id"));
    $kendaraan = $this->input->post("kendaraan");

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'KENDARAAN_ID' => $kendaraan_id,
      'KENDARAAN' => $kendaraan,
    );

    $this->m_t_m_a_kendaraan->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_m_a_kendaraan');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");
    $kendaraan_id = intval($this->input->post("kendaraan_id"));
    $kendaraan = $this->input->post("kendaraan");

    $data = array(
      'KENDARAAN_ID' => $kendaraan_id,
      'KENDARAAN' => $kendaraan
    );
    $this->m_t_m_a_kendaraan->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    redirect('/c_t_m_a_kendaraan');
  }
}
