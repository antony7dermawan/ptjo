<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_m_d_divisi extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_m_d_divisi');
  }

  public function index()
  {
    $this->session->set_userdata('t_m_d_divisi_delete_logic', '1');
    $data = [
      "c_t_m_d_divisi" => $this->m_t_m_d_divisi->select(),
      "title" => "Master Divisi",
      "description" => ""
    ];
    $this->render_backend('template/backend/pages/t_m_d_divisi', $data);
  }



  public function delete($id)
  {
    $data = array(
        'UPDATED_BY' => $this->session->userdata('username'),
        'MARK_FOR_DELETE' => TRUE
    );
    $this->m_t_m_d_divisi->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('/c_t_m_d_divisi');
  }

  public function undo_delete($id)
  {
    $data = array(
        'UPDATED_BY' => $this->session->userdata('username'),
        'MARK_FOR_DELETE' => FALSE
    );
    $this->m_t_m_d_divisi->update($data, $id);
    
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Dikembalikan!</strong></p></div>');
    redirect('/c_t_m_d_divisi');
  }


  function tambah()
  {
    
    $divisi = substr($this->input->post("divisi"), 0, 50);

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'DIVISI' => $divisi,
      'CREATED_BY' => $this->session->userdata('username'),
      'UPDATED_BY' => '',
      'MARK_FOR_DELETE' => FALSE
    );

    $this->m_t_m_d_divisi->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_m_d_divisi');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");
    $divisi = substr($this->input->post("divisi"), 0, 50);

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'DIVISI' => $divisi,
      'UPDATED_BY' => $this->session->userdata('username')
    );

    $this->m_t_m_d_divisi->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    redirect('/c_t_m_d_divisi');
  }
}
