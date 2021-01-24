<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_ak_m_family extends CI_Model {
    


public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('AK_M_FAMILY', $data);
}


public function select_id($id)
{
  $this->db->select('FAMILY_ID');
  $this->db->from('AK_M_FAMILY');
  $this->db->where('FAMILY', $id);
  $akun = $this->db->get ();
  return $akun->result ();
}





  public function select()
  {
    $this->db->select('*');
    $this->db->from('AK_M_FAMILY');
    $this->db->order_by("ID", "asc");
    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('AK_M_FAMILY');
  }

  function tambah($data)
  {
        $this->db->insert('AK_M_FAMILY', $data);
        return TRUE;
  }

}


