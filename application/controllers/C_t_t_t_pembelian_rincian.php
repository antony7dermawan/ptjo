<?php
defined('BASEPATH') or exit('No direct script access allowed');


class C_t_t_t_pembelian_rincian extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_t_t_pembelian');
    $this->load->model('m_t_m_d_company');
    $this->load->model('m_t_m_d_barang');
    $this->load->model('m_t_m_d_supplier');
    $this->load->model('m_t_t_t_pembelian_rincian'); 
  }
  
  public function index($pembelian_id)
  {

    $this->session->set_userdata('t_t_t_pembelian_delete_logic', '1');
    
    $this->session->set_userdata('t_m_d_barang_delete_logic', '0');
    $this->session->set_userdata('t_m_d_barang_delete_logic', '0');

    $this->session->set_userdata('master_barang_kategori_id', '0');
    $this->session->set_userdata('master_barang_company_id', $this->session->userdata('company_id'));
    
    $data = [
      //"select_barang_with_supplier" => $this->m_t_t_t_pembelian_rincian->select_barang_with_supplier(),
      "c_t_t_t_pembelian_rincian" => $this->m_t_t_t_pembelian_rincian->select($pembelian_id),
      "c_t_t_t_pembelian_by_id" => $this->m_t_t_t_pembelian->select_by_id($pembelian_id),
      "c_t_m_d_barang" => $this->m_t_m_d_barang->select(),
      "c_t_m_d_supplier" => $this->m_t_m_d_supplier->select(),
      "pembelian_id" => $pembelian_id,
      "title" => "Transaksi Pembelian",
      "description" => "form Pembelian"
    ];
    $this->render_backend('template/backend/pages/t_t_t_pembelian_rincian', $data);
  }




  public function delete($id,$retur_pembelian_id)
  {
    $data = array(
        'UPDATED_BY' => $this->session->userdata('username'),
        'MARK_FOR_DELETE' => TRUE
    );
    $this->m_t_t_t_pembelian_rincian->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');

    redirect('c_t_t_t_pembelian_rincian/index/' . $retur_pembelian_id);
  }

  public function undo_delete($id,$retur_pembelian_id)
  {
    $data = array(
        'UPDATED_BY' => $this->session->userdata('username'),
        'MARK_FOR_DELETE' => FALSE
    );
    $this->m_t_t_t_pembelian_rincian->update($data, $id);
    
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Dikembalikan!</strong></p></div>');
    redirect('c_t_t_t_pembelian_rincian/index/' . $retur_pembelian_id);
  }

 







  function tambah($pembelian_id)
  {
    $barang_id = intval($this->input->post("barang_id"));
    $qty = floatval($this->input->post("qty"));
    $harga = floatval($this->input->post("harga"));
    $qty_datang = floatval($this->input->post("qty_datang"));
    $ppn_percentage = floatval($this->input->post("ppn_percentage"));

    $sub_total = $qty * $harga;


    $ppn_value = ($sub_total*$ppn_percentage)/100;

    $read_select = $this->m_t_t_t_pembelian->select_by_id($pembelian_id);
    foreach ($read_select as $key => $value) 
    {
      $supplier_id = $value->SUPPLIER_ID;
    }

    $sisa_qty_tt = 0;
    $read_select = $this->m_t_t_t_pembelian_rincian->select_sisa_qty_for_1_barang_id($barang_id);
    foreach ($read_select as $key => $value) 
    {
      $sisa_qty_tt = $value->SUM_SISA_QTY;
    }




    if($barang_id!=0 and $qty_datang<=$qty)
    {
      $data = array(
        'PEMBELIAN_ID' => $pembelian_id,
        'BARANG_ID' => $barang_id,
        'QTY' => $qty,
        'SISA_QTY_RB' => $qty,
        'SISA_QTY' => $qty_datang,
        'HARGA' => $harga,
        'SUB_TOTAL' => $sub_total,
        'SISA_QTY_TT' => $sisa_qty_tt,
        'SPECIAL_CASE_ID' => 0, //nol kode barang uda jelas masuk stok
        'SUPPLIER_ID' => $supplier_id,
        'CREATED_BY' => $this->session->userdata('username'),
        'UPDATED_BY' => '',
        'MARK_FOR_DELETE' => FALSE,
        'COMPANY_ID' => $this->session->userdata('company_id'),
        'QTY_DATANG' => $qty_datang,
        'PPN_PERCENTAGE' => $ppn_percentage,
        'PPN_VALUE' => $ppn_value
      );

      $this->m_t_t_t_pembelian_rincian->tambah($data);

      $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    }

    else
    {
      $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Gagal!</strong> Data Tidak Lengkap/Stok Kurang!</p></div>');
    }
    

    
    redirect('c_t_t_t_pembelian_rincian/index/'.$pembelian_id);
  }






  public function edit_action($pembelian_id)
  {
    $id = $this->input->post("id");
   
    $qty = floatval($this->input->post("qty"));
    $harga = floatval($this->input->post("harga"));
    $qty_datang = floatval($this->input->post("qty_datang"));
    $ppn_percentage = floatval($this->input->post("ppn_percentage"));

    $sub_total = $qty * $harga;

    
    $ppn_value = ($sub_total*$ppn_percentage)/100;


    $sisa_qty_tt = 0;

    if($qty_datang<=$qty)
    {
      $read_select = $this->m_t_t_t_pembelian_rincian->select_by_id($id);
      foreach ($read_select as $key => $value) 
      {
        $e_qty_datang = $value->QTY_DATANG;
        $e_sisa_qty = $value->SISA_QTY;
      }

      $update_sisa_qty = ($qty_datang-$e_qty_datang)+$e_sisa_qty;

        $data = array(
          
          'SISA_QTY_RB' => $qty,
          'QTY' => $qty,
          'SISA_QTY' => $update_sisa_qty,
          'HARGA' => $harga,
          'SUB_TOTAL' => $sub_total,
          'SISA_QTY_TT' => $sisa_qty_tt,
          'UPDATED_BY' => $this->session->userdata('username'),
          'QTY_DATANG' => $qty_datang,
          'PPN_PERCENTAGE' => $ppn_percentage,
          'PPN_VALUE' => $ppn_value
        );

        $this->m_t_t_t_pembelian_rincian->update($data,$id);

        $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    }


    else
    {
      $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Gagal!</strong> QTY Datang > QTY Pembelian!</p></div>');
    }
    
    



    
    redirect('c_t_t_t_pembelian_rincian/index/'.$pembelian_id);
  }
}
