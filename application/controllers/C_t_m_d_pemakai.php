<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_m_d_pemakai extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_m_d_pemakai');
  }

  public function index()
  {
    $this->session->set_userdata('t_m_d_pemakai_delete_logic', '1');
    $data = [
      "c_t_m_d_pemakai" => $this->m_t_m_d_pemakai->select(),
      "title" => "Master Pemakai",
      "description" => "Pemakai untuk Unit Barang"
    ];
    $this->render_backend('template/backend/pages/t_m_d_pemakai', $data);
  }



  public function delete($id)
  {
    $data = array(
        'UPDATED_BY' => $this->session->userdata('username'),
        'MARK_FOR_DELETE' => TRUE
    );
    $this->m_t_m_d_pemakai->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('/c_t_m_d_pemakai');
  }

  public function undo_delete($id)
  {
    $data = array(
        'UPDATED_BY' => $this->session->userdata('username'),
        'MARK_FOR_DELETE' => FALSE
    );
    $this->m_t_m_d_pemakai->update($data, $id);
    
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Dikembalikan!</strong></p></div>');
    redirect('/c_t_m_d_pemakai');
  }


  function tambah()
  {
    
    $pemakai = substr($this->input->post("pemakai"), 0, 50);

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'PEMAKAI' => $pemakai,
      'CREATED_BY' => $this->session->userdata('username'),
      'UPDATED_BY' => '',
      'MARK_FOR_DELETE' => FALSE
    );

    $this->m_t_m_d_pemakai->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_m_d_pemakai');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");
    $pemakai = substr($this->input->post("pemakai"), 0, 50);

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'PEMAKAI' => $pemakai,
      'UPDATED_BY' => $this->session->userdata('username')
    );

    $this->m_t_m_d_pemakai->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    redirect('/c_t_m_d_pemakai');
  }
}
