<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_m_d_sales extends CI_Model {
    
   

public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_M_D_SALES', $data);
}

public function select_id($id)
{
  $this->db->select('ID');
  $this->db->from('T_M_D_SALES');
  $this->db->where('SALES', $id);
  $akun = $this->db->get ();
  return $akun->result ();
}





  public function select()
  {
    $this->db->select('*');
    $this->db->from('T_M_D_SALES');
    if($this->session->userdata('t_m_d_sales_delete_logic')==0)
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
    $this->db->delete('T_M_D_SALES');
  }

  function tambah($data)
  {
    $this->db->insert('T_M_D_SALES', $data);
    return TRUE;
  }

}


