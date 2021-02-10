<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_m_a_uang_jalan extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_m_a_uang_jalan');
    $this->load->model('m_t_m_a_no_polisi');
    $this->load->model('m_t_m_a_pks');
    $this->load->model('m_t_m_a_divisi');
    $this->load->model('m_t_m_a_kendaraan');
  }


  public function index()
  {
    $data = [
      "c_t_m_a_uang_jalan" => $this->m_t_m_a_uang_jalan->select(),
      "c_t_m_a_no_polisi" => $this->m_t_m_a_no_polisi->select(),
      "c_t_m_a_pks" => $this->m_t_m_a_pks->select(),
      "c_t_m_a_divisi" => $this->m_t_m_a_divisi->select(),
      "c_t_m_a_kendaraan" => $this->m_t_m_a_kendaraan->select(),
      "title" => "Master Uang Jalan",
      "description" => "Lookup Uang Jalan Untuk T Penjualan PKS"
    ];
    $this->render_backend('template/backend/pages/t_m_a_uang_jalan', $data);
  }


  public function delete($id)
  {
    $this->m_t_m_a_uang_jalan->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('/c_t_m_a_uang_jalan');
  }



  function tambah()
  {
    $no_polisi_id = intval($this->input->post("no_polisi_id"));
    $pks_id = intval($this->input->post("pks_id"));
    //$divisi_id = intval($this->input->post("divisi_id"));
    $kendaraan_id = intval($this->input->post("kendaraan_id"));
    $uang_jalan = intval($this->input->post("uang_jalan"));

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'NO_POLISI_ID' => $no_polisi_id,
      'PKS_ID' => $pks_id,
      //'DIVISI_ID' => $divisi_id,
      'KENDARAAN_ID' => $kendaraan_id,
      'UANG_JALAN' => $uang_jalan
    );

    $this->m_t_m_a_uang_jalan->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_m_a_uang_jalan');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");


    $no_polisi = ($this->input->post("no_polisi"));
    $read_select = $this->m_t_m_a_no_polisi->select_id($no_polisi);
    foreach ($read_select as $key => $value) {
      $no_polisi_id = $value->NO_POLISI_ID;
    }





    $pks = ($this->input->post("pks"));
    $read_select = $this->m_t_m_a_pks->select_id($pks);
    foreach ($read_select as $key => $value) {
      $pks_id = $value->PKS_ID;
    }


/*
    $divisi = ($this->input->post("divisi"));
    $read_select = $this->m_t_m_a_divisi->select_id($divisi);
    foreach ($read_select as $key => $value) {
      $divisi_id = $value->DIVISI_ID;
    }
*/


    $kendaraan = ($this->input->post("kendaraan"));
    $read_select = $this->m_t_m_a_kendaraan->select_id($kendaraan);
    foreach ($read_select as $key => $value) {
      $kendaraan_id = $value->KENDARAAN_ID;
    }
    $uang_jalan = intval($this->input->post("uang_jalan"));

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'NO_POLISI_ID' => $no_polisi_id,
      'PKS_ID' => $pks_id,
      //'DIVISI_ID' => $divisi_id,
      'KENDARAAN_ID' => $kendaraan_id,
      'UANG_JALAN' => $uang_jalan
    );
    $this->m_t_m_a_uang_jalan->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    redirect('/c_t_m_a_uang_jalan');
  }
}
