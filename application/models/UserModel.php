<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserModel extends CI_Model {
    
    public function get($username){
        $this->db->where('USERNAME', $username);
        $this->db->where('MARK_FOR_DELETE', FALSE);
        $result = $this->db->get('T_LOGIN_USER')->row(); // Untuk mengeksekusi dan mengambil data hasil query
        return $result;
    }

public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_LOGIN_USER', $data);
}






public function save($data, $id)
 {
    $this->db->where('id', $id);
    return $this->db->update('T_LOGIN_USER', $data);
 }


 public function cek_old()
  {
   $old = $this->input->post('old');    $this->db->where('password',$old);
   $query = $this->db->get('T_LOGIN_USER');
      return $query->result();;
  }


  public function select_user()
  {
    $this->db->select('*');
    $this->db->from('T_LOGIN_USER');
    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_LOGIN_USER');
  }

  function tambah($data)
  {
        $this->db->insert('T_LOGIN_USER', $data);
        return TRUE;
    }

}


