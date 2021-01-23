<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_m_d_level_user extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_m_d_level_user');
  }

  public function index()
  {
    $data = [
      "c_t_m_d_level_user" => $this->m_t_m_d_level_user->select(),
      "title" => "Master Level User",
      "description" => "Level User untuk Login"
    ];
    $this->render_backend('template/backend/pages/t_m_d_level_user', $data);
  }



  public function delete($id)
  {
    $this->m_t_m_d_level_user->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data User Berhasil Dihapus!</p></div>');
    redirect('/c_t_m_d_level_user');
  }


  function tambah()
  {
    $level_user_id = intval($this->input->post("level_user_id"));
    $level_user = $this->input->post("level_user");

//Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'LEVEL_USER_ID' => $level_user_id,
      'LEVEL_USER' => $level_user,
    );

    $this->m_t_m_d_level_user->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data User Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_m_d_level_user');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");
    $level_user_id = intval($this->input->post("level_user_id"));
    $level_user = $this->input->post("level_user");

//Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'LEVEL_USER_ID' => $level_user_id,
      'LEVEL_USER' => $level_user,
    );
    
    $this->m_t_m_d_level_user->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data User Berhasil Diupdate!</strong></p></div>');
    redirect('/c_t_m_d_level_user');
  }

}
