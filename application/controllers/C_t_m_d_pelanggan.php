<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_m_d_pelanggan extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_m_d_pelanggan');
  }

  public function index()
  {
    $this->session->set_userdata('t_m_d_pelanggan_delete_logic', '1');
    $data = [
      "c_t_m_d_pelanggan" => $this->m_t_m_d_pelanggan->select(),
      "title" => "Master Nama Pelanggan",
      "description" => "Hati Hati dalam mengisi master data"
    ];
    $this->render_backend('template/backend/pages/t_m_d_pelanggan', $data);
  }



  public function delete($id)
  {
    $data = array(
        'UPDATED_BY' => $this->session->userdata('username'),
        'MARK_FOR_DELETE' => TRUE
    );
    $this->m_t_m_d_pelanggan->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('/c_t_m_d_pelanggan');
  }

  public function undo_delete($id)
  {
    $data = array(
        'UPDATED_BY' => $this->session->userdata('username'),
        'MARK_FOR_DELETE' => FALSE
    );
    $this->m_t_m_d_pelanggan->update($data, $id);
    
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Dikembalikan!</strong></p></div>');
    redirect('/c_t_m_d_pelanggan');
  }


  function tambah()
  {
    $email = substr($this->input->post("email"), 0, 100);
    $pelanggan = substr($this->input->post("pelanggan"), 0, 100);
    $no_telp = substr($this->input->post("no_telp"), 0, 50);
    $alamat = substr($this->input->post("alamat"), 0, 50);
    $nik = substr($this->input->post("nik"), 0, 50);
    $npwp = substr($this->input->post("npwp"), 0, 50);

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'PELANGGAN' => $pelanggan,
      'NO_TELP' => $no_telp,
      'ALAMAT' => $alamat,
      'CREATED_BY' => $this->session->userdata('username'),
      'UPDATED_BY' => '',
      'MARK_FOR_DELETE' => FALSE,
      'EMAIL' => $email,
      'NIK' => $nik,
      'NPWP' => $npwp
    );

    $this->m_t_m_d_pelanggan->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_m_d_pelanggan');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");
    $email = substr($this->input->post("email"), 0, 100);
    $pelanggan = substr($this->input->post("pelanggan"), 0, 100);
    $no_telp = substr($this->input->post("no_telp"), 0, 50);
    $alamat = substr($this->input->post("alamat"), 0, 200);
    $nik = substr($this->input->post("nik"), 0, 50);
    $npwp = substr($this->input->post("npwp"), 0, 50);

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'PELANGGAN' => $pelanggan,
      'NO_TELP' => $no_telp,
      'ALAMAT' => $alamat,
      'CREATED_BY' => $this->session->userdata('username'),
      'UPDATED_BY' => '',
      'MARK_FOR_DELETE' => FALSE,
      'EMAIL' => $email,
      'NIK' => $nik,
      'NPWP' => $npwp
    );

    $this->m_t_m_d_pelanggan->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    redirect('/c_t_m_d_pelanggan');
  }
}
