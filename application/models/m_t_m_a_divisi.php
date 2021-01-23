<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_t_m_a_divisi extends CI_Model {
    
    public function get($username){
        $this->db->where('USERNAME', $username); // Untuk menambahkan Where Clause : username='$username'
        $result = $this->db->get('T_M_A_DIVISI')->row(); // Untuk mengeksekusi dan mengambil data hasil query
        return $result;
    }

public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_M_A_DIVISI', $data);
}

public function select_id($id)
{
  $this->db->select('DIVISI_ID');
  $this->db->from('T_M_A_DIVISI');
  $this->db->where('DIVISI', $id);
  $akun = $this->db->get ();
  return $akun->result ();
}






  public function select()
  {
    $this->db->select('*');
    $this->db->from('T_M_A_DIVISI');
    $this->db->order_by("ID", "asc");
    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_M_A_DIVISI');
  }

  function tambah($data)
  {
        $this->db->insert('T_M_A_DIVISI', $data);
        return TRUE;
  }

}


