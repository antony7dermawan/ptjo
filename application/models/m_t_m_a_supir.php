<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_m_a_supir extends CI_Model {
    
    public function get($username){
        $this->db->where('USERNAME', $username); // Untuk menambahkan Where Clause : username='$username'
        $result = $this->db->get('T_M_A_SUPIR')->row(); // Untuk mengeksekusi dan mengambil data hasil query
        return $result;
    }

public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_M_A_SUPIR', $data);
}








  public function select()
  {
    $this->db->select('*');
    $this->db->from('T_M_A_SUPIR');
    $this->db->order_by("ID", "asc");
    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_M_A_SUPIR');
  }

  function tambah($data)
  {
        $this->db->insert('T_M_A_SUPIR', $data);
        return TRUE;
  }

}


