<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class c_laporan extends MY_Controller {

	  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_laporan');
  }

	public function index(){
		$data = [
			
			"title" => "Laporan",
			"description" => "Pilih Detail"
		  ];
		// function render_backend tersebut dari file core/MY_Controller.php
		$this->render_backend('template/backend/pages/laporan', $data);
	}



}


