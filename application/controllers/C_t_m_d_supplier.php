<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_m_d_supplier extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_m_d_supplier');
  }

  public function index()
  {
    $this->session->set_userdata('t_m_d_supplier_delete_logic', '1');


    $data = [
      "c_t_m_d_supplier" => $this->m_t_m_d_supplier->select(),
      "title" => "Master Nama Supplier",
      "description" => "Hati Hati dalam mengisi master data"
    ];
    $this->render_backend('template/backend/pages/t_m_d_supplier', $data);
  }



  public function delete($id)
  {
    $data = array(
        'UPDATED_BY' => $this->session->userdata('username'),
        'MARK_FOR_DELETE' => TRUE
    );
    $this->m_t_m_d_supplier->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('/c_t_m_d_supplier');
  }

  public function undo_delete($id)
  {
    $data = array(
        'UPDATED_BY' => $this->session->userdata('username'),
        'MARK_FOR_DELETE' => FALSE
    );
    $this->m_t_m_d_supplier->update($data, $id);
    
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Dikembalikan!</strong></p></div>');
    redirect('/c_t_m_d_supplier');
  }


  function tambah()
  {
    
    $supplier = substr($this->input->post("supplier"), 0, 100);
    $no_telp = substr($this->input->post("no_telp"), 0, 50);
    $alamat = substr($this->input->post("alamat"), 0, 200);
    $email = substr($this->input->post("email"), 0, 100);
    $nik = substr($this->input->post("nik"), 0, 50);
    $npwp = substr($this->input->post("npwp"), 0, 50);

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'SUPPLIER' => $supplier,
      'NO_TELP' => $no_telp,
      'ALAMAT' => $alamat,
      'CREATED_BY' => $this->session->userdata('username'),
      'UPDATED_BY' => '',
      'MARK_FOR_DELETE' => FALSE,
      'EMAIL' => $email,
      'NIK' => $nik,
      'NPWP' => $npwp
    );

    $this->m_t_m_d_supplier->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_m_d_supplier');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");
    $supplier = substr($this->input->post("supplier"), 0, 100);
    $no_telp = substr($this->input->post("no_telp"), 0, 50);
    $alamat = substr($this->input->post("alamat"), 0, 200);
    $email = substr($this->input->post("email"), 0, 100);
    $nik = substr($this->input->post("nik"), 0, 50);
    $npwp = substr($this->input->post("npwp"), 0, 50);

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'SUPPLIER' => $supplier,
      'NO_TELP' => $no_telp,
      'ALAMAT' => $alamat,
      'CREATED_BY' => $this->session->userdata('username'),
      'UPDATED_BY' => '',
      'MARK_FOR_DELETE' => FALSE,
      'EMAIL' => $email,
      'NIK' => $nik,
      'NPWP' => $npwp
    );

    $this->m_t_m_d_supplier->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    redirect('/c_t_m_d_supplier');
  }
}
