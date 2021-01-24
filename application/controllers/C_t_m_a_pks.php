<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_m_a_pks extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_m_a_pks');
  }

  public function index()
  {
    $data = [
      "c_t_m_a_pks" => $this->m_t_m_a_pks->select(),
      "title" => "Master PKS",
      "description" => "Pilihan PKS Untuk T Penjualan PKS"
    ];
    $this->render_backend('template/backend/pages/t_m_a_pks', $data);
  }



  public function delete($id)
  {
    $this->m_t_m_a_pks->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('/c_t_m_a_pks');
  }


  function tambah()
  {
    $pks_id = intval($this->input->post("pks_id"));
    $pks = $this->input->post("pks");
    $no_pelanggan = $this->input->post("no_pelanggan");
    $nama = $this->input->post("nama");
    $alamat = $this->input->post("alamat");
    $npwp = $this->input->post("npwp");
    $telepon = $this->input->post("telepon");
    $created_by = $this->session->userdata('name');
    $updated_by = $this->session->userdata('name');


    $data = array(
      'PKS_ID' => $pks_id,
      'PKS' => $pks,
      'NO_PELANGGAN' => $no_pelanggan,
      'NAMA' => $nama,
      'ALAMAT' => $alamat,
      'NPWP' => $npwp,
      'TELEPON' => $telepon,
      'CREATED_BY' => $created_by,
      'UPDATED_BY' => $updated_by
    );

    $this->m_t_m_a_pks->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_m_a_pks');
  }





  public function edit_action()
  {
    $id = $this->input->post("id");
    $pks_id = intval($this->input->post("pks_id"));
    $pks = $this->input->post("pks");
    $no_pelanggan = $this->input->post("no_pelanggan");
    $nama = $this->input->post("nama");
    $alamat = $this->input->post("alamat");
    $npwp = $this->input->post("npwp");
    $telepon = $this->input->post("telepon");
    $updated_by = $this->session->userdata('name');


    $data = array(
      'PKS_ID' => $pks_id,
      'PKS' => $pks,
      'NO_PELANGGAN' => $no_pelanggan,
      'NAMA' => $nama,
      'ALAMAT' => $alamat,
      'NPWP' => $npwp,
      'TELEPON' => $telepon,
      'UPDATED_BY' => $updated_by
    );
    $this->m_t_m_a_pks->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    redirect('/c_t_m_a_pks');
  }
}
