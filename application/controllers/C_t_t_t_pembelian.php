<?php
defined('BASEPATH') or exit('No direct script access allowed');


class C_t_t_t_pembelian extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_t_t_pembelian');
    $this->load->model('m_t_m_d_company');
    $this->load->model('m_t_m_d_payment_method');
    $this->load->model('m_t_m_d_supplier');   
    $this->load->model('m_t_t_t_po_manual_rincian');  
  }


  public function index()
  {
    $this->session->set_userdata('t_m_d_payment_method_delete_logic', '0');
    $this->session->set_userdata('t_m_d_supplier_delete_logic', '0');


    $this->session->set_userdata('t_t_t_pembelian_delete_logic', '1');


    if($this->session->userdata('date_pembelian')=='')
    {
      $date_pembelian = date('Y-m-d');
      $this->session->set_userdata('date_pembelian', $date_pembelian);
    }

    
    $data = [
      "c_t_t_t_pembelian" => $this->m_t_t_t_pembelian->select($this->session->userdata('date_pembelian')),
      "c_t_m_d_company" => $this->m_t_m_d_company->select(),
      "c_t_m_d_payment_method" => $this->m_t_m_d_payment_method->select(),
      "c_t_m_d_supplier" => $this->m_t_m_d_supplier->select(),
      "title" => "Transaksi Pembelian",
      "description" => "form Pembelian"
    ];
    $this->render_backend('template/backend/pages/t_t_t_pembelian', $data);
  }


  public function date_pembelian()
  {
    $date_pembelian = ($this->input->post("date_pembelian"));
    $this->session->set_userdata('date_pembelian', $date_pembelian);
    redirect('/c_t_t_t_pembelian');
  }


  public function delete($id)
  {
    $data = array(
        'UPDATED_BY' => $this->session->userdata('username'),
        'MARK_FOR_DELETE' => TRUE
    );
    $this->m_t_t_t_pembelian->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('/c_t_t_t_pembelian');
  }

  public function undo_delete($id)
  {
    $data = array(
        'UPDATED_BY' => $this->session->userdata('username'),
        'MARK_FOR_DELETE' => FALSE
    );
    $this->m_t_t_t_pembelian->update($data, $id);
    
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Dikembalikan!</strong></p></div>');
    redirect('/c_t_t_t_pembelian');
  }

 







  function tambah()
  {
    $supplier_id = intval($this->input->post("supplier_id"));
    $payment_method_id = intval($this->input->post("payment_method_id"));
    $ket = substr($this->input->post("ket"), 0, 200);
    $date = $this->input->post("date");
    $inv_supplier = substr($this->input->post("inv_supplier"), 0, 50);
    $inv_int = 0;

    
    $read_select = $this->m_t_t_t_pembelian->select_inv_int();
    foreach ($read_select as $key => $value) 
    {
      $inv_int = intval($value->INV_INT)+1;
    }

    $read_select = $this->m_t_m_d_company->select_by_company_id();
    foreach ($read_select as $key => $value) 
    {
      $inv_pembelian = $value->INV_PEMBELIAN;
      $inv_retur_pembelian = $value->INV_RETUR_PEMBELIAN;
      $inv_penjualan = $value->INV_PENJUALAN;
      $inv_retur_penjualan = $value->INV_RETUR_PENJUALAN;
      $inv_po = $value->INV_PO;
      $inv_pinlok = $value->INV_PINLOK;
    }

    $live_inv = $inv_pembelian.date('y-m').'.'.sprintf('%05d', $inv_int);

    $date_pembelian = $date;
    $this->session->set_userdata('date_pembelian', $date_pembelian);

    if($supplier_id!=0 and $payment_method_id!=0)
    {
      $data = array(
        'DATE' => $date,
        'TIME' => date('H:i:s'),
        'NEW_DATE' => $date,
        'INV' => $live_inv,
        'INV_INT' => $inv_int,
        'COMPANY_ID' => $this->session->userdata('company_id'),
        'PAYMENT_METHOD_ID' => $payment_method_id,
        'SUPPLIER_ID' => $supplier_id,
        'KET' => $ket,
        'CREATED_BY' => $this->session->userdata('username'),
        'UPDATED_BY' => '',
        'MARK_FOR_DELETE' => FALSE,
        'PRINTED' => FALSE,
        'INV_SUPPLIER' => $inv_supplier,
        'T_STATUS' => 0, //ini kode pembelian
        'TABLE_CODE' => 'PEMBELIAN',
        'PAYMENT_T' => 0,
        'ENABLE_EDIT' => 1 //MASI BISA EDIT
      );

      $this->m_t_t_t_pembelian->tambah($data);

      $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    }

    else
    {
      $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Gagal!</strong> Data Tidak Lengkap!</p></div>');
    }
    

    
    redirect('c_t_t_t_pembelian');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");

    $date_pembelian = $this->input->post("date");
    $ket = substr($this->input->post("ket"), 0, 200);
    $supplier = $this->input->post("supplier");
    $payment_method = $this->input->post("payment_method");
    $inv_supplier = substr($this->input->post("inv_supplier"), 0, 50);

    if($date_pembelian=='')
    {
      $date_pembelian = date('Y-m-d');
    }

    $this->session->set_userdata('date_pembelian', $date_pembelian);
    $supplier_id = 0;
    $payment_method_id = 0;

    $read_select = $this->m_t_m_d_supplier->select_id($supplier);
    foreach ($read_select as $key => $value) {
      $supplier_id = $value->ID;
    }


    $read_select = $this->m_t_m_d_payment_method->select_id($payment_method);
    foreach ($read_select as $key => $value) {
      $payment_method_id = $value->ID;
    }
    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.

    if($supplier_id!=0 and $payment_method_id!=0)
    {
      $data = array(
        'PAYMENT_METHOD_ID' => $payment_method_id,
        'SUPPLIER_ID' => $supplier_id,
        'KET' => $ket,
        'UPDATED_BY' => $this->session->userdata('username'),
        'INV_SUPPLIER' => $inv_supplier,
        'DATE' => $date_pembelian
      );
      $this->m_t_t_t_pembelian->update($data, $id);

      $data = array(
        'UPDATED_BY' => $this->session->userdata('username'),
        'SUPPLIER_ID' => $supplier_id
      );
      $this->m_t_t_t_po_manual_rincian->update_by_pembelian_id($data, $id);
      $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    }
    else
    {
      $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Gagal!</strong> Data Tidak Lengkap!</p></div>');
    }
    
    redirect('/c_t_t_t_pembelian');
  }
}
