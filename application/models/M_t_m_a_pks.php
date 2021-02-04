<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_m_a_pks extends CI_Model {
    


public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_M_A_PKS', $data);
}


public function select_id($id)
{
  $this->db->select('PKS_ID');
  $this->db->from('T_M_A_PKS');
  $this->db->where('PKS', $id);
  $akun = $this->db->get ();
  return $akun->result ();
}


public function select_by_id($id)
{
  $this->db->select('*');
  $this->db->from('T_M_A_PKS');
  $this->db->where('ID', $id);
  $akun = $this->db->get ();
  return $akun->result ();
}



  public function select()
  {
    $this->db->select('*');
    $this->db->from('T_M_A_PKS');
    $this->db->order_by("ID", "asc");
    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_M_A_PKS');
  }

  function tambah($data)
  {
        $this->db->insert('T_M_A_PKS', $data);
        return TRUE;
  }

}


