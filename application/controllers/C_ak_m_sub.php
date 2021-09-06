<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_ak_m_sub extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_ak_m_sub');
  }

  public function index()
  {
    $data = [
      "c_ak_m_sub" => $this->m_ak_m_sub->select(),
      "title" => "Master COA Sub",
      "description" => "Pilihan COA Sub"
    ];
    $this->render_backend('template/backend/pages/ak_m_sub', $data);
  }



  public function delete($id)
  {
    $this->m_ak_m_sub->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button sub="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('/c_ak_m_sub');
  }


  function tambah()
  {
    $sub_id = intval($this->input->post("sub_id"));
    $sub = $this->input->post("sub");

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'SUB_ID' => $sub_id,
      'SUB' => $sub,
    );

    $this->m_ak_m_sub->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button sub="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_ak_m_sub');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");
    $sub_id = intval($this->input->post("sub_id"));
    $sub = $this->input->post("sub");

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'SUB_ID' => $sub_id,
      'SUB' => $sub,
    );

    $this->m_ak_m_sub->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button sub="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    redirect('/c_ak_m_sub');
  }
}
