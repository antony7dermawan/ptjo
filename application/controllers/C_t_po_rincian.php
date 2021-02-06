<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_po_rincian extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_po_rincian');
  }

  public function index($po_id)
  {
    $data = [
      "c_t_po_rincian" => $this->m_t_po_rincian->select($po_id),
      "po_id" => $po_id,
      
      "title" => "Rincian PO",
      "description" => "Menu Rincian PO"
    ];
    $this->render_backend('template/backend/pages/t_po_rincian', $data);
  }

  public function date_po()
  {
    $date_po = ($this->input->post("date_po"));
    $this->session->set_userdata('date_po', $date_po);
    redirect('/c_t_po');
  }


  public function delete($id,$po_id)
  {
    $this->m_t_po_rincian->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('c_t_po_rincian/index/'.$po_id);
  }



  function tambah($po_id)
  {
    $nama_barang = substr($this->input->post("nama_barang"), 0, 200);
    $qty = floatval($this->input->post("qty"));
    $satuan = substr($this->input->post("satuan"), 0, 50);
    $harga = floatval($this->input->post("harga"));
    $sub_total = $qty * $harga;

    
    

    $data = array(
      'PO_ID' => $po_id,
      'NAMA_BARANG' =>$nama_barang,
      'QTY' => $qty,
      'SATUAN' => $satuan,
      'HARGA' => $harga,
      'CREATED_BY' => $this->session->userdata('username'),
      'UPDATED_BY' => $this->session->userdata('username'),
      'SUB_TOTAL' => $sub_total
    );

    $this->m_t_po_rincian->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_po_rincian/index/'.$po_id);
  }




  public function edit_action($po_id)
  {
    $id = $this->input->post("id");


    $nama_barang = substr($this->input->post("nama_barang"), 0, 200);
    $qty = floatval($this->input->post("qty"));
    $satuan = substr($this->input->post("satuan"), 0, 50);
    $harga = floatval($this->input->post("harga"));
    $sub_total = $qty * $harga;

    
    

    $data = array(
      'NAMA_BARANG' =>$nama_barang,
      'QTY' => $qty,
      'SATUAN' => $satuan,
      'HARGA' => $harga,
      'UPDATED_BY' => $this->session->userdata('username'),
      'SUB_TOTAL' => $sub_total
    );
    $this->m_t_po_rincian->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    redirect('c_t_po_rincian/index/'.$po_id);
  }
}
