<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_m_d_satuan extends CI_Model {
    
  

public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_M_D_SATUAN', $data);
}

public function select_id($id)
{
  $this->db->select('ID');
  $this->db->from('T_M_D_SATUAN');
  $this->db->where('SATUAN', $id);
  $akun = $this->db->get ();
  return $akun->result ();
}


  public function select_option()
  {
    $this->db->select('*');
    $this->db->from('T_M_D_SATUAN');
    $this->db->where("MARK_FOR_DELETE=false");
    $this->db->order_by("ID", "asc");
    $akun = $this->db->get ();
    return $akun->result ();
  } 


  public function select()
  {
    $this->db->select('*');
    $this->db->from('T_M_D_SATUAN');

    if($this->session->userdata('t_m_d_satuan_delete_logic')==0)
    {
      $this->db->where('MARK_FOR_DELETE',FALSE);
    }
    $this->db->order_by("ID", "asc");
    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_M_D_SATUAN');
  }

  function tambah($data)
  {
    $this->db->insert('T_M_D_SATUAN', $data);
    return TRUE;
  }

}


