<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_laporan extends MY_Controller {

	  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_laporan');
    $this->load->model('m_ak_m_sub');
  }

	public function index(){
		$data = [
      		"c_ak_m_sub" => $this->m_ak_m_sub->select(),
			"title" => "Laporan",
			"description" => "Pilih Detail"
		  ];
		// function render_backend tersebut dari file core/MY_Controller.php
		$this->render_backend('template/backend/pages/laporan', $data);
	}



}


