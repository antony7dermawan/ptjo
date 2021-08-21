<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_ak_faktur_penjualan_rincian extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_ak_faktur_penjualan_rincian');
    $this->load->model('m_t_ak_faktur_penjualan');
    $this->load->model('m_t_t_a_penjualan_pks');
    $this->load->model('m_t_m_a_no_polisi');
    $this->load->model('m_t_m_a_pks');
    $this->load->model('m_t_m_a_divisi');
    $this->load->model('m_t_m_a_kendaraan');
    $this->load->model('m_t_m_a_supir');
  }


  public function index($id, $pks_id)
  {
    $data = [
      "c_t_ak_faktur_penjualan_rincian" => $this->m_t_ak_faktur_penjualan_rincian->select($id),
      "c_t_ak_faktur_penjualan" => $this->m_t_ak_faktur_penjualan->select_by_id($id),
      "faktur_penjualan_id" => $id,
      "pks_id" => $pks_id,
      "c_t_m_a_no_polisi" => $this->m_t_m_a_no_polisi->select(),
      "c_t_m_a_pks" => $this->m_t_m_a_pks->select(),
      "c_t_m_a_divisi" => $this->m_t_m_a_divisi->select(),
      "c_t_m_a_kendaraan" => $this->m_t_m_a_kendaraan->select(),
      "c_t_m_a_supir" => $this->m_t_m_a_supir->select(),
      "title" => "Rincian Faktur Penjualan",
      "description" => "Pilih Tanggal Transkasi Pengiriman TBS"
    ];
    $this->render_backend('template/backend/pages/t_ak_faktur_penjualan_rincian', $data);
  }



  function create_faktur_penjualan($id, $pks_id)
  {
    $date_from_select_penjualan = ($this->input->post("date_from_select_penjualan"));
    $date_to_select_penjualan = ($this->input->post("date_to_select_penjualan"));

    $this->session->set_userdata('date_from_select_penjualan', $date_from_select_penjualan);
    $this->session->set_userdata('date_to_select_penjualan', $date_to_select_penjualan);


    #$this->m_t_ak_faktur_penjualan_rincian->delete_id($id);


    $read_select = $this->m_t_t_a_penjualan_pks->select_date($pks_id, $date_from_select_penjualan, $date_to_select_penjualan);
    foreach ($read_select as $key => $value) {
      $penjualan_pks_id = $value->ID;

      $data = array(
        'DATE' => date('Y-m-d'),
        'TIME' => date('H:i:s'),
        'FAKTUR_PENJUALAN_ID' => $id,
        'PENJUALAN_PKS_ID' => $penjualan_pks_id,
        'CREATED_BY' => $this->session->userdata('username'),
        'UPDATED_BY' => $this->session->userdata('username'),
        'KETERANGAN' => 'PENJUALAN TBS'
      );

      $this->m_t_ak_faktur_penjualan_rincian->tambah($data);

      $data = array(
        'ENABLE_EDIT' => 0
      );
      $this->m_t_t_a_penjualan_pks->update($data, $penjualan_pks_id);
    }




    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_ak_faktur_penjualan_rincian/index/' . $id . '/' . $pks_id);
  }


  public function delete($id_faktur_penjualan_rincian,$penjualan_pks_id,$id_faktur_penjualan,$pks_id)
  {
    $data = array(
        'ENABLE_EDIT' => 1
      );
      $this->m_t_t_a_penjualan_pks->update($data, $penjualan_pks_id);

    $this->m_t_ak_faktur_penjualan_rincian->delete($id_faktur_penjualan_rincian);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('c_t_ak_faktur_penjualan_rincian/index/' . $id_faktur_penjualan . '/' . $pks_id);
  }



  function tambah()
  {
    $pks_id = intval($this->input->post("pks_id"));
    $keterangan = '';
    $no_faktur = ($this->input->post("no_faktur"));


    $data = array(
      'DATE' => date('Y-m-d'),
      'TIME' => date('H:i:s'),
      'PKS_ID' => $pks_id,
      'CREATED_BY' => $this->session->userdata('username'),
      'UPDATED_BY' => $this->session->userdata('username'),
      'KETERANGAN' => $keterangan,
      'NO_FAKTUR' => $no_faktur
    );

    $this->m_t_ak_faktur_penjualan->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_ak_faktur_penjualan_rincian');
  }
}
