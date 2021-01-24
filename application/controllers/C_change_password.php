<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_change_password extends MY_Controller {

	  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_login_user');
  }

	public function index(){
		$data = [
			
			"title" => "Change Password",
			"description" => "Ganti Password Disini"
		  ];
		// function render_backend tersebut dari file core/MY_Controller.php
		$this->render_backend('template/backend/pages/change_password', $data);
	}


	public function change_password()
	{
		$password = ($this->input->post("password"));
		$new_password = ($this->input->post("new_password"));
		$new_passwordc = ($this->input->post("new_passwordc"));

		if($password==$this->session->userdata('password') and $new_password==$new_passwordc)
	    {
	      $data = array(
	        'PASSWORD' => $new_password,
	        'PASSWORD2' => $new_password
	      );
	      $this->m_t_login_user->update($data, $this->session->userdata('id'));
	      $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data User Berhasil Diupdate!</strong></p></div>');
	    }
	    else
	    {
	      $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Gagal Update!</strong> Periksa Ulang Password</p></div>');
	    }

	    redirect('c_change_password');
	}

	


}


