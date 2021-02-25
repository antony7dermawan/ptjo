<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_send_t_po_rincian extends CI_Model {
    
    





  public function select($po_id)
  {
    $this->db->select("*");
   

    $this->db->from('T_PO_RINCIAN');
    
    $this->db->where('PO_ID',$po_id); //nol = yang belum disend to cloud

    $this->db->order_by("ID", "asc");

    $akun = $this->db->get ();
    return $akun->result ();
  }



}


