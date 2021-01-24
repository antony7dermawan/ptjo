<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_User extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('UserModel');
  }

  public function index()
  {
    $data = [
      "C_User" => $this->UserModel->select_user(),
      "title" => "Daftar User",
      "description" => "Daftar Level Users"
    ];
    $this->render_backend('template/backend/pages/daftar_user', $data);
  }



  public function delete($id)
  {
    $this->UserModel->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data Berhasil DIhapus!</p></div>');
    redirect('/C_User');
  }


  function tambah()
  {
    $name = $this->input->post("name");
    $username = $this->input->post("username");
    $password = $this->input->post("password");
    $password2 = $this->input->post("password2");
    $company_id = $this->input->post("company_id");
    $level_user_id = $this->input->post("level_user_id");

    //Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'NAME' => $name,
      'USERNAME' => $username,
      'PASSWORD' => $password,
      'PASSWORD2' => $password2,
      'COMPANY_ID' => $company_id,
      'LEVEL_USER_ID' => $level_user_id
    );

    $this->UserModel->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Ditambahkan!</strong></p></div>');
    redirect('C_User');
  }






  public function edit_action()
  {
    $id = $this->input->post("id");
    $name = $this->input->post("name");
    $username = $this->input->post("username");
    $password = $this->input->post("password");
    $password2 = $this->input->post("password2");
    $company_id = $this->input->post("company_id");
    $level_user_id = $this->input->post("level_user_id");

    $data = array(
      'NAME' => $name,
      'USERNAME' => $username,
      'PASSWORD' => $password,
      'PASSWORD2' => $password2,
      'COMPANY_ID' => $company_id,
      'LEVEL_USER_ID' => $level_user_id
    );
    $this->UserModel->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data Berhasil Diupdate!</strong></p></div>');
    redirect('/C_User');
  }
}
