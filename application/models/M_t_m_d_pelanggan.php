<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_m_d_pelanggan extends CI_Model {
    
   

public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_M_D_PELANGGAN', $data);
}

public function select_id($id)
{
  $this->db->select('ID');
  $this->db->from('T_M_D_PELANGGAN');
  $this->db->where('PELANGGAN', $id);
  $akun = $this->db->get ();
  return $akun->result ();
}


  public function select_by_id($id)
  {
    $this->db->select('*');
    $this->db->from('T_M_D_PELANGGAN');

    
    $this->db->where('ID',$id);
    
    
    $akun = $this->db->get ();
    return $akun->result ();
  }


  public function select()
  {
    $this->db->select('*');
    $this->db->from('T_M_D_PELANGGAN');

    if($this->session->userdata('t_m_d_pelanggan_delete_logic')==0)
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
    $this->db->delete('T_M_D_PELANGGAN');
  }

  function tambah($data)
  {
    $this->db->insert('T_M_D_PELANGGAN', $data);
    return TRUE;
  }

}


