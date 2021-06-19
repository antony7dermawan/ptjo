<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_po extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_po');
    $this->load->model('m_t_m_d_company');
  }

  public function index()
  {

    if($this->session->userdata('date_po')=='')
    {
      $date_po = date('Y-m-d');
      $this->session->set_userdata('date_po', $date_po);
    }

    


    
    $data = [
      "c_t_po" => $this->m_t_po->select($this->session->userdata('date_po'),$this->session->userdata('po_company_id')),
      "c_t_m_d_company" => $this->m_t_m_d_company->select(),
      "title" => "PO",
      "description" => "Menu Pembuatan PO"
    ];
    $this->render_backend('template/backend/pages/t_po', $data);
  }

  public function date_po()
  {
    $date_po = ($this->input->post("date_po"));
    $this->session->set_userdata('date_po', $date_po);
    redirect('/c_t_po');
  }


  public function change_company_id()
  {
    $po_company_id = ($this->input->post("company_id"));
    $this->session->set_userdata('po_company_id', $po_company_id);
    redirect('/c_t_po');
  }


  public function delete($id)
  {
    $this->m_t_po->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('/c_t_po');
  }



  public function checked_ok($id)
  {
    $data = array(
      'ENABLE_EDIT' => 0
    );
    $this->m_t_po->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    redirect('/c_t_po');
  }



  function tambah()
  {
    $expire_date = ($this->input->post("expire_date"));
    $date = ($this->input->post("date"));
    $no_po = substr($this->input->post("no_po"), 0, 100);
    $supplier = substr($this->input->post("supplier"), 0, 100);
    $ket = substr($this->input->post("ket"), 0, 500);


    $payment_method = substr($this->input->post("payment_method"), 0, 50);
    $nama_bank = substr($this->input->post("nama_bank"), 0, 50);
    $norek = substr($this->input->post("norek"), 0, 50);
    $atas_nama = substr($this->input->post("atas_nama"), 0, 50);
    $cabang = substr($this->input->post("cabang"), 0, 50);
    $nama_penerima = substr($this->input->post("nama_penerima"), 0, 50);
    $telp_penerima = substr($this->input->post("telp_penerima"), 0, 50);
    $telp_supplier = substr($this->input->post("telp_supplier"), 0, 50);
    $alamat_supplier = substr($this->input->post("alamat_supplier"), 0, 50);

    $lainnya = substr($this->input->post("lainnya"), 0, 200);


    
    $this->session->set_userdata('date_po', $date);

    $data = array(
      'DATE' => $date,
      'TIME' => date('H:i:s'),
      'NO_PO' => $no_po,
      'SUPPLIER' => $supplier,
      'KET' => $ket,
      'CREATED_BY' => $this->session->userdata('username'),
      'UPDATED_BY' => $this->session->userdata('username'),
      'PAYMENT_METHOD' => $payment_method,
      'NAMA_BANK' => $nama_bank,
      'NOREK' => $norek,
      'ATAS_NAMA' => $atas_nama,
      'CABANG' => $cabang,
      'NAMA_PENERIMA' => $nama_penerima,
      'TELP_PENERIMA' => $telp_penerima,
      'TELP_SUPPLIER' => $telp_supplier,
      'ALAMAT_SUPPLIER' => $alamat_supplier,
      'EXPIRE_DATE' => $expire_date,
      'ENABLE_EDIT' => 1,
      'LAINNYA' => $lainnya,
      'COMPANY_ID' => $this->session->userdata('company_id')
      
    );

    $this->m_t_po->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_po');
  }




  public function edit_action()
  {
    $id = $this->input->post("id");

    $expire_date = ($this->input->post("expire_date"));
    $no_po = substr($this->input->post("no_po"), 0, 100);
    $supplier = substr($this->input->post("supplier"), 0, 100);
    $ket = substr($this->input->post("ket"), 0, 500);

    
    $payment_method = substr($this->input->post("payment_method"), 0, 50);
    $nama_bank = substr($this->input->post("nama_bank"), 0, 50);
    $norek = substr($this->input->post("norek"), 0, 50);
    $atas_nama = substr($this->input->post("atas_nama"), 0, 50);
    $cabang = substr($this->input->post("cabang"), 0, 50);
    $nama_penerima = substr($this->input->post("nama_penerima"), 0, 50);
    $telp_penerima = substr($this->input->post("telp_penerima"), 0, 50);
    $telp_supplier = substr($this->input->post("telp_supplier"), 0, 50);
    $alamat_supplier = substr($this->input->post("alamat_supplier"), 0, 50);
    $lainnya = substr($this->input->post("lainnya"), 0, 200);


    

    $data = array(
      'NO_PO' => $no_po,
      'SUPPLIER' => $supplier,
      'KET' => $ket,
      'CREATED_BY' => $this->session->userdata('username'),
      'UPDATED_BY' => $this->session->userdata('username'),
      'PAYMENT_METHOD' => $payment_method,
      'NAMA_BANK' => $nama_bank,
      'NOREK' => $norek,
      'ATAS_NAMA' => $atas_nama,
      'CABANG' => $cabang,
      'NAMA_PENERIMA' => $nama_penerima,
      'TELP_PENERIMA' => $telp_penerima,
      'TELP_SUPPLIER' => $telp_supplier,
      'ALAMAT_SUPPLIER' => $alamat_supplier,
      'EXPIRE_DATE' => $expire_date,
      'LAINNYA' => $lainnya
    );
    $this->m_t_po->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    redirect('/c_t_po');
  }
}
