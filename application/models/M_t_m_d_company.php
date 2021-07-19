<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_m_d_company extends CI_Model {
    
    

public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_M_D_COMPANY', $data);
}

public function select_id($id)
{
  $this->db->select('ID');
  $this->db->from('T_M_D_COMPANY');
  $this->db->where('COMPANY', $id);
  $akun = $this->db->get ();
  return $akun->result ();
}




public function select_by_id($company_id)
{
  $this->db->select('*');
  $this->db->from('T_M_D_COMPANY');
  $this->db->where('ID', $company_id);
  $akun = $this->db->get ();
  return $akun->result ();
}



  public function select_by_company_id()
  {
    $this->db->select('*');
    $this->db->from('T_M_D_COMPANY');
    $this->db->where("ID={$this->session->userdata('company_id')}");
    $akun = $this->db->get ();
    return $akun->result ();
  }


  public function select()
  {
    $this->db->select('*');
    $this->db->from('T_M_D_COMPANY');

    if($this->session->userdata('t_m_d_company_delete_logic')==0)
    {
      $this->db->where('MARK_FOR_DELETE',FALSE);
    }

    $this->db->order_by("ID", "asc");
    $akun = $this->db->get ();
    return $akun->result ();
  }


  

  public function select_pinlok()
  {
    $this->db->select('*');
    $this->db->from('T_M_D_COMPANY');

    if($this->session->userdata('t_m_d_company_delete_logic')==0)
    {
      $this->db->where('MARK_FOR_DELETE',FALSE);
    }

    $this->db->where("ID<>{$this->session->userdata('company_id')}");

    $this->db->order_by("ID", "asc");
    $akun = $this->db->get ();
    return $akun->result ();
  }



  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_M_D_COMPANY');
  }

  function tambah($data)
  {
    $this->db->insert('T_M_D_COMPANY', $data);
    return TRUE;
  }

}


