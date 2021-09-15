<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_video_streaming extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

 
  }


  public function index()
  {
    $title = "Dashboard";

    $data = [
     
      "title" => $title,
      "description" => "Web Version:21-06-01 19:30"
    ];

    $this->render_backend_page_only('template/record/index', $data);
  }


  

}



