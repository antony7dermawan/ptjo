<?php
defined('BASEPATH') or exit('No direct script access allowed');


class C_t_t_t_pemakaian extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_t_t_pemakaian');
    $this->load->model('m_t_m_d_company');
    $this->load->model('m_t_m_d_payment_method');
    $this->load->model('m_t_m_d_anggota');

    $this->load->model('m_t_m_d_sales');
    $this->load->model('m_t_m_d_no_polisi');
    $this->load->model('m_t_m_d_supir');

    $this->load->model('m_t_m_d_barang');
    $this->load->model('m_t_m_d_lokasi');
  }

  public function index()
  {
    $this->session->set_userdata('t_t_t_pemakaian_delete_logic', '1');
    $this->session->set_userdata('t_m_d_payment_method_delete_logic', '0');
    $this->session->set_userdata('t_m_d_anggota_delete_logic', '0');
    $this->session->set_userdata('t_m_d_sales_delete_logic', '0');
    $this->session->set_userdata('t_m_d_no_polisi_delete_logic', '0');
    $this->session->set_userdata('t_m_d_supir_delete_logic', '0');
    $this->session->set_userdata('t_m_d_lokasi_delete_logic', '0');

    if($this->session->userdata('date_pemakaian')=='')
    {
      $date_pemakaian = date('Y-m-d');
      $this->session->set_userdata('date_pemakaian', $date_pemakaian);
    }
    $data = [
      "c_t_t_t_pemakaian" => $this->m_t_t_t_pemakaian->select($this->session->userdata('date_pemakaian')),

      "c_t_m_d_company" => $this->m_t_m_d_company->select(),
      "c_t_m_d_payment_method" => $this->m_t_m_d_payment_method->select(),
      "c_t_m_d_anggota" => $this->m_t_m_d_company->select(),

      "c_t_m_d_sales" => $this->m_t_m_d_sales->select(),

      "c_t_m_d_lokasi" => $this->m_t_m_d_lokasi->select(),
      "c_t_m_d_no_polisi" => $this->m_t_m_d_no_polisi->select(),
      "c_t_m_d_supir" => $this->m_t_m_d_supir->select(),

      "title" => "Transaksi Pemakaian",
      "description" => "form Pemakaian"
    ];
    $this->render_backend('template/backend/pages/t_t_t_pemakaian', $data);
  }


  public function date_pemakaian()
  {
    $date_pemakaian = ($this->input->post("date_pemakaian"));
    $this->session->set_userdata('date_pemakaian', $date_pemakaian);
    redirect('/c_t_t_t_pemakaian');
  }


  public function delete($id)
  {
    $data = array(
        'UPDATED_BY' => $this->session->userdata('username'),
        'MARK_FOR_DELETE' => TRUE
    );
    $this->m_t_t_t_pemakaian->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('/c_t_t_t_pemakaian');
  }

  public function undo_delete($id)
  {
    $data = array(
        'UPDATED_BY' => $this->session->userdata('username'),
        'MARK_FOR_DELETE' => FALSE
    );
    $this->m_t_t_t_pemakaian->update($data, $id);
    
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Dikembalikan!</strong></p></div>');
    redirect('/c_t_t_t_pemakaian');
  }

 







  function tambah()
  {
    $anggota_id = intval($this->input->post("anggota_id"));
    $payment_method_id = intval($this->input->post("payment_method_id"));
    $inv_head = substr($this->input->post("inv_head"), 0, 50);
    $no_polisi_id = intval($this->input->post("no_polisi_id"));
    $supir_id = intval($this->input->post("supir_id"));
    $sales_id = intval($this->input->post("sales_id"));

    $lokasi_id = intval($this->input->post("lokasi_id"));

    $ket = substr($this->input->post("ket"), 0, 200);
    $date = $this->input->post("date");

    $inv_int = 0;
    $read_select = $this->m_t_t_t_pemakaian->select_inv_int();
    foreach ($read_select as $key => $value) 
    {
      $inv_int = intval($value->INV_INT)+1;
    }

    $read_select = $this->m_t_m_d_company->select_by_company_id();
    foreach ($read_select as $key => $value) 
    {
      $inv_pembelian = $value->INV_PEMBELIAN;
      $inv_retur_pembelian = $value->INV_RETUR_PEMBELIAN;
      $inv_pemakaian = $value->INV_PEMAKAIAN;
      $inv_retur_pemakaian = $value->INV_RETUR_PEMAKAIAN;
      $inv_po = $value->INV_PO;
    }

    $live_inv = $inv_pemakaian.date('y-m').'.'.sprintf('%05d', $inv_int);

    $date_pemakaian = $date;
    $this->session->set_userdata('date_pemakaian', $date_pemakaian);

    if($anggota_id!=0 and $payment_method_id!=0 and $no_polisi_id!=0 and $supir_id!=0  and $sales_id!=0 )
    {
      $data = array(
        'DATE' => $date,
        'TIME' => date('H:i:s'),
        'NEW_DATE' => $date,
        'INV' => $live_inv,
        'INV_INT' => $inv_int,
        'COMPANY_ID' => $this->session->userdata('company_id'),
        'PAYMENT_METHOD_ID' => $payment_method_id,
        'ANGGOTA_ID' => $anggota_id,
        'NO_POLISI_ID' => $no_polisi_id,
        'SUPIR_ID' => $supir_id,
        'SALES_ID' => $sales_id,
        'KET' => $ket,
        'CREATED_BY' => $this->session->userdata('username'),
        'UPDATED_BY' => '',
        'MARK_FOR_DELETE' => FALSE,
        'PRINTED' => FALSE,
        'LOKASI_ID' => $lokasi_id,
        'INV_HEAD' => $inv_head,
        'TABLE_CODE' => 'PEMAKAIAN',
        'ENABLE_EDIT' => 1
      );

      $this->m_t_t_t_pemakaian->tambah($data);



      


      $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    }

    else
    {
      $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Gagal!</strong> Data Tidak Lengkap!</p></div>');
    }
    

    
    redirect('c_t_t_t_pemakaian');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");
    $inv_head = substr($this->input->post("inv_head"), 0, 50);
    $ket = substr($this->input->post("ket"), 0, 200);
    $anggota = $this->input->post("anggota");
    $payment_method = $this->input->post("payment_method");


    $no_polisi = $this->input->post("no_polisi");
    $supir = $this->input->post("supir");
    $sales = $this->input->post("sales");
    $lokasi = $this->input->post("lokasi");

    $supplier_id = 0;
    $payment_method_id = 0;


    $read_select = $this->m_t_m_d_no_polisi->select_id($no_polisi);
    foreach ($read_select as $key => $value) {
      $no_polisi_id = $value->ID;
    }

    $read_select = $this->m_t_m_d_supir->select_id($supir);
    foreach ($read_select as $key => $value) {
      $supir_id = $value->ID;
    }

    $read_select = $this->m_t_m_d_sales->select_id($sales);
    foreach ($read_select as $key => $value) {
      $sales_id = $value->ID;
    }

    $read_select = $this->m_t_m_d_lokasi->select_id($lokasi);
    foreach ($read_select as $key => $value) {
      $lokasi_id = $value->ID;
    }


    $read_select = $this->m_t_m_d_payment_method->select_id($payment_method);
    foreach ($read_select as $key => $value) {
      $payment_method_id = $value->ID;
    }

    $read_select = $this->m_t_m_d_company->select_id($anggota);
    foreach ($read_select as $key => $value) {
      $anggota_id = $value->ID;
    }
    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.

    if($anggota_id!=0 and $payment_method_id!=0 and $no_polisi_id!=0 and $supir_id!=0  and $sales_id!=0 and $lokasi_id!=0 )
    {
      $data = array(
        'PAYMENT_METHOD_ID' => $payment_method_id,
        'ANGGOTA_ID' => $anggota_id,
        'SUPIR_ID' => $supir_id,
        'NO_POLISI_ID' => $no_polisi_id,
        'SALES_ID' => $sales_id,
        'KET' => $ket,
        'UPDATED_BY' => $this->session->userdata('username'),
        'LOKASI_ID' => $lokasi_id,
        'INV_HEAD' => $inv_head
      );
      $this->m_t_t_t_pemakaian->update($data, $id);
      $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    }
    else
    {
      $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Gagal!</strong> Data Tidak Lengkap!</p></div>');
    }
    
    redirect('/c_t_t_t_pemakaian');
  }
}
