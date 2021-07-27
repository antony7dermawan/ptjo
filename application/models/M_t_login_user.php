<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_login_user extends CI_Model {
    
    

public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_LOGIN_USER', $data);
}







  public function select()
  {
    $this->db->select("T_LOGIN_USER.CREATED_BY,T_LOGIN_USER.UPDATED_BY,T_LOGIN_USER.MARK_FOR_DELETE,T_LOGIN_USER.ID,T_LOGIN_USER.USERNAME,T_LOGIN_USER.NAME,T_LOGIN_USER.PASSWORD,T_M_D_LEVEL_USER.LEVEL_USER,T_M_D_COMPANY.COMPANY");
    $this->db->from('T_LOGIN_USER');
    $this->db->join('T_M_D_LEVEL_USER', 'T_M_D_LEVEL_USER.ID = T_LOGIN_USER.LEVEL_USER_ID', 'left');
    $this->db->join('T_M_D_COMPANY', 'T_M_D_COMPANY.ID = T_LOGIN_USER.COMPANY_ID', 'left');

    $this->db->order_by("T_LOGIN_USER.ID", "asc");

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


