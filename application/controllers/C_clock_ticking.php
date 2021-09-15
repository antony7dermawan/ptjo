<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_clock_ticking extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('m_t_video_capture');
  }


  public function index()
  {
    $read_select = $this->m_t_video_capture->select_last_data();
    foreach ($read_select as $key => $value) 
    {
      $distance = $value->DISTANCE/100;
      $location = $value->LOCATION;
      $upstream = $value->UPSTREAM;
      $downstream = $value->DOWNSTREAM;
      $d_pipe = $value->D_PIPE;
    }



      




      
      echo "<div class='d_pipe'><table> <tr><th>Pipe Diameter</th> <th> : ".$d_pipe."</th> </tr></table> </div>";


      echo "<div class='date'>".date('Y-m-d')."</div> <br>";
      echo "<div class='time'>".date('H:i:s')."</div>";


      echo "<div class='location'>".$location."</div>";

      echo "<div class='upstream'><table> <tr><th>Upstream</th> <th> : ".$upstream."</th> </tr></table> </div>";

      echo "<div class='downstream'><table> <tr><th>Downstream</th> <th> : ".$downstream."</th> </tr></table> </div>";

      
      echo "<div class='distance'>".$distance." Cm</div>";


  }


}
