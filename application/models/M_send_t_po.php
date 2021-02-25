<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_send_t_po extends CI_Model {
    
    





  public function select($date)
  {
    $this->db->select("*");
   

    $this->db->from('T_PO');
    
    $this->db->where('DATE',$date);
    $this->db->where('ENABLE_EDIT',1); //nol = yang belum disend to cloud

    $this->db->order_by("ID", "asc");

    $akun = $this->db->get ();
    return $akun->result ();
  }



}


