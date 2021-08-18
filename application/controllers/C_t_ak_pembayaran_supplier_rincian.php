<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_ak_pembayaran_supplier_rincian extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_ak_pembayaran_supplier_rincian');
    $this->load->model('m_t_ak_pembayaran_supplier');

    $this->load->model('m_t_t_t_pembelian');
  }


  public function index($id, $supplier_id)
  {
    $data = [
      "c_t_ak_pembayaran_supplier_rincian" => $this->m_t_ak_pembayaran_supplier_rincian->select($id),
      "c_t_ak_pembayaran_supplier" => $this->m_t_ak_pembayaran_supplier->select_by_id($id),
      "pembayaran_supplier_id" => $id,
      "supplier_id" => $supplier_id,
      
      "title" => "Rincian Faktur Penjualan",
      "description" => "Faktur Penjualan"
    ];
    $this->render_backend('template/backend/pages/t_ak_pembayaran_supplier_rincian', $data);
  }



  function create_pembayaran_supplier($id, $supplier_id)
  {
    $date_from_select_pembelian = ($this->input->post("date_from_select_pembelian"));
    $date_to_select_pembelian = ($this->input->post("date_to_select_pembelian"));

    $this->session->set_userdata('date_from_select_pembelian', $date_from_select_pembelian);
    $this->session->set_userdata('date_to_select_pembelian', $date_to_select_pembelian);


    #$this->m_t_ak_pembayaran_supplier_rincian->delete_id($id);




    $read_select = $this->m_t_t_t_pembelian->select_date($supplier_id, $date_from_select_pembelian, $date_to_select_pembelian);
    foreach ($read_select as $key => $value) {
      $pembelian_id = $value->ID;

      $data = array(
        'DATE' => date('Y-m-d'),
        'TIME' => date('H:i:s'),
        'PEMBAYARAN_SUPPLIER_ID' => $id,
        'PEMBELIAN_ID' => $pembelian_id,
        'CREATED_BY' => $this->session->userdata('username'),
        'UPDATED_BY' => '',
        'KETERANGAN' => $value->TABLE_CODE,
        'ENABLE_EDIT' => 1
      );

      $this->m_t_ak_pembayaran_supplier_rincian->tambah($data);

      // $data = array(
      //   'ENABLE_EDIT' => 0
      // );
      // $this->m_t_t_t_pembelian->update($data, $pembelian_id);
    }




    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_ak_pembayaran_supplier_rincian/index/' . $id . '/' . $supplier_id);
  }


  public function delete($id_pembayaran_supplier_rincian,$pembelian_id,$id_pembayaran_supplier,$supplier_id)
  {
    $data = array(
        'ENABLE_EDIT' => 1
      );
      $this->m_t_t_t_pembelian->update($data, $pembelian_id);

    $this->m_t_ak_pembayaran_supplier_rincian->delete($id_pembayaran_supplier_rincian);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('c_t_ak_pembayaran_supplier_rincian/index/' . $id_pembayaran_supplier . '/' . $supplier_id);
  }



}
