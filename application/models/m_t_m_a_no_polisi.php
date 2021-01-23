<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_t_m_a_no_polisi extends CI_Model {
    
    public function get($username){
        $this->db->where('USERNAME', $username); // Untuk menambahkan Where Clause : username='$username'
        $result = $this->db->get('T_M_A_NO_POLISI')->row(); // Untuk mengeksekusi dan mengambil data hasil query
        return $result;
    }

public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_M_A_NO_POLISI', $data);
}



public function select_id($id)
{
  $this->db->select('NO_POLISI_ID');
  $this->db->from('T_M_A_NO_POLISI');
  $this->db->where('NO_POLISI', $id);
  $akun = $this->db->get ();
  return $akun->result ();
}




  public function select()
  {
    $this->db->select('*');
    $this->db->from('T_M_A_NO_POLISI');
    $this->db->order_by("ID", "asc");
    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_M_A_NO_POLISI');
  }

  function tambah($data)
  {
        $this->db->insert('T_M_A_NO_POLISI', $data);
        return TRUE;
  }

}


