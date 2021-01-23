<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_ak_m_db_k extends CI_Model {
    


public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('AK_M_DB_K', $data);
}


public function select_id($id)
{
  $this->db->select('DB_K_ID');
  $this->db->from('AK_M_DB_K');
  $this->db->where('DB_K', $id);
  $akun = $this->db->get ();
  return $akun->result ();
}





  public function select()
  {
    $this->db->select('*');
    $this->db->from('AK_M_DB_K');
    $this->db->order_by("ID", "asc");
    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('AK_M_DB_K');
  }

  function tambah($data)
  {
        $this->db->insert('AK_M_DB_K', $data);
        return TRUE;
  }

}


