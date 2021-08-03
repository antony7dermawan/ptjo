<?php
defined('BASEPATH') or exit('No direct script access allowed');


class C_t_t_t_pinlok_out extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_t_t_pembelian');
    $this->load->model('m_t_m_d_company');
    $this->load->model('m_t_m_d_payment_method');
    $this->load->model('m_t_m_d_anggota');

    $this->load->model('m_t_m_d_sales');
    $this->load->model('m_t_m_d_no_polisi');
    $this->load->model('m_t_m_d_supir');

    $this->load->model('m_t_m_d_barang');
    $this->load->model('m_t_m_d_lokasi');
    $this->load->model('m_t_t_t_po_auto');
  }

  public function index()
  {
    $po_auto_notif = 0;
    $read_select = $this->m_t_t_t_po_auto->select_one_day(date('Y-m-d'));
    foreach ($read_select as $key => $value) 
    {
      $po_auto_notif = $po_auto_notif + 1;
    }
    $this->session->set_userdata('po_auto_notif', $po_auto_notif);
    
    $this->session->set_userdata('t_t_t_pemakaian_delete_logic', '1');
    $this->session->set_userdata('t_m_d_payment_method_delete_logic', '0');
    $this->session->set_userdata('t_m_d_anggota_delete_logic', '0');
    $this->session->set_userdata('t_m_d_sales_delete_logic', '0');
    $this->session->set_userdata('t_m_d_no_polisi_delete_logic', '0');
    $this->session->set_userdata('t_m_d_supir_delete_logic', '0');
    $this->session->set_userdata('t_m_d_lokasi_delete_logic', '0');

    if($this->session->userdata('date_pinlok_out')=='')
    {
      $date_pinlok_out = date('Y-m-d');
      $this->session->set_userdata('date_pinlok_out', $date_pinlok_out);
    }
    $data = [
      "c_t_t_t_pinlok_out" => $this->m_t_t_t_pembelian->select_pinlok($this->session->userdata('date_pinlok_out')),



      "c_t_m_d_company" => $this->m_t_m_d_company->select_pinlok(),
      "c_t_m_d_payment_method" => $this->m_t_m_d_payment_method->select(),
      "c_t_m_p_anggota" => $this->m_t_m_d_anggota->select(),

      "c_t_m_d_sales" => $this->m_t_m_d_sales->select(),

      "c_t_m_d_lokasi" => $this->m_t_m_d_lokasi->select(),
      "c_t_m_d_no_polisi" => $this->m_t_m_d_no_polisi->select(),
      "c_t_m_d_supir" => $this->m_t_m_d_supir->select(),

      "title" => "Transaksi Pindah Lokasi Keluar",
      "description" => "form Pinlok"
    ];
    $this->render_backend('template/backend/pages/t_t_t_pinlok_out', $data);
  }


  public function date_pinlok_out()
  {
    $date_pinlok_out = ($this->input->post("date_pinlok_out"));
    $this->session->set_userdata('date_pinlok_out', $date_pinlok_out);
    redirect('/c_t_t_t_pinlok_out');
  }


  public function delete($id)
  {
    $data = array(
        'UPDATED_BY' => $this->session->userdata('username'),
        'MARK_FOR_DELETE' => TRUE
    );
    $this->m_t_t_t_pembelian->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('/c_t_t_t_pinlok_out');
  }

  public function undo_delete($id)
  {
    $data = array(
        'UPDATED_BY' => $this->session->userdata('username'),
        'MARK_FOR_DELETE' => FALSE
    );
    $this->m_t_t_t_pembelian->update($data, $id);
    
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Dikembalikan!</strong></p></div>');
    redirect('/c_t_t_t_pinlok_out');
  }

 







  function tambah()
  {
    $company_id = intval($this->input->post("company_id"));


    $no_polisi_id = intval($this->input->post("no_polisi_id"));
    $supir_id = intval($this->input->post("supir_id"));
    

    $lokasi_id = intval($this->input->post("lokasi_id"));

    $ket = substr($this->input->post("ket"), 0, 200);
    $date = $this->input->post("date");


    if($date=='')
    {
      $date = date('Y-m-d');
    }

    
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

    $live_inv = $inv_pinlok.date('y-m').'.'.sprintf('%05d', $inv_int);

    $date_pemakaian = $date;
    $this->session->set_userdata('date_pemakaian', $date_pemakaian);

    if($company_id!=0 and $no_polisi_id!=0 and $supir_id!=0  )
    {
      $data = array(
        'DATE' => $date,
        'TIME' => date('H:i:s'),
        'NEW_DATE' => $date,
        'INV' => $live_inv,
        'INV_INT' => $inv_int,
        'COMPANY_ID' => $company_id,
        'PAYMENT_METHOD_ID' => 1,
        'SUPPLIER_ID' => 0,
        'KET' => $ket,
        'CREATED_BY' => $this->session->userdata('username'),
        'UPDATED_BY' => '',
        'MARK_FOR_DELETE' => FALSE,
        'PRINTED' => FALSE,
        'INV_SUPPLIER' => '',
        'T_STATUS' => 50, //ini kode pinlok out
        'TABLE_CODE' => 'PINLOK',
        'COMPANY_ID_FROM' => $this->session->userdata('company_id'),
        'LOKASI_ID' => $lokasi_id,
        'SUPIR_ID' => $supir_id,
        'NO_POLISI_ID' => $no_polisi_id,
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
    

    
    redirect('c_t_t_t_pinlok_out');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");
    
    $ket = substr($this->input->post("ket"), 0, 200);
    $company = $this->input->post("company");


    $no_polisi = $this->input->post("no_polisi");
    $supir = $this->input->post("supir");
    $lokasi = $this->input->post("lokasi");

    $supplier_id = 0;
    $payment_method_id = 0;



    $read_select = $this->m_t_m_d_company->select_id($company);
    foreach ($read_select as $key => $value) {
      $company_id = $value->ID;
    }


    $read_select = $this->m_t_m_d_no_polisi->select_id($no_polisi);
    foreach ($read_select as $key => $value) {
      $no_polisi_id = $value->ID;
    }

    $read_select = $this->m_t_m_d_supir->select_id($supir);
    foreach ($read_select as $key => $value) {
      $supir_id = $value->ID;
    }

   

    $read_select = $this->m_t_m_d_lokasi->select_id($lokasi);
    foreach ($read_select as $key => $value) {
      $lokasi_id = $value->ID;
    }


    

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.

    if($company_id!=0 and $no_polisi_id!=0 and $supir_id!=0  )
    {
      $data = array(
        
        'COMPANY_ID' => $company_id,
        'SUPIR_ID' => $supir_id,
        'NO_POLISI_ID' => $no_polisi_id,

        'KET' => $ket,
        'UPDATED_BY' => $this->session->userdata('username'),

        'COMPANY_ID' => $company_id
      );
      $this->m_t_t_t_pembelian->update($data, $id);
      $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    }
    else
    {
      $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Gagal!</strong> Data Tidak Lengkap!</p></div>');
    }
    
    redirect('/c_t_t_t_pinlok_out');
  }
}
