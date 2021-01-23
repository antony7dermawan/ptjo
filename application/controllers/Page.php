<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends MY_Controller {

	  public function __construct()
  {
    parent::__construct();

    $this->load->model('Dashboard_Model');
  }

	public function home(){
		$data = [
			
			"title" => "Dashboard SIA",
			"description" => "Sistem Informasi Akuntansi"
		  ];
		// function render_backend tersebut dari file core/MY_Controller.php
		$this->render_backend('home',$data); // load view home.php
	}



}


