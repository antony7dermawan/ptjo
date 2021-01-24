<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_ak_jurnal_create extends CI_Model {
    
    

public function update($data, $id)
{
  $this->db->where('ID', $id);
  return $this->db->update('T_AK_JURNAL_CREATE', $data);
}

public function update_all($data)
{
  $this->db->where('CREATED_BY', $this->session->userdata('username'));
  return $this->db->update('T_AK_JURNAL_CREATE', $data);
}





  public function select()
  {
    $this->db->select("T_AK_JURNAL_CREATE.ID");
    $this->db->select("AK_M_COA.NO_AKUN_1");
    $this->db->select("AK_M_COA.NO_AKUN_2");
    $this->db->select("AK_M_COA.NO_AKUN_3");
    $this->db->select("AK_M_COA.NAMA_AKUN");
    $this->db->select("AK_M_COA.FAMILY_ID");
    $this->db->select("T_AK_JURNAL_CREATE.COA_ID");
    $this->db->select("T_AK_JURNAL_CREATE.DEBIT");
    $this->db->select("T_AK_JURNAL_CREATE.KREDIT");
    $this->db->select("T_AK_JURNAL_CREATE.CATATAN");
    $this->db->select("T_AK_JURNAL_CREATE.DEPARTEMEN");
    $this->db->select("T_AK_JURNAL_CREATE.NO_VOUCER");
    $this->db->select("T_AK_JURNAL_CREATE.DATE");
    $this->db->select("T_AK_JURNAL_CREATE.TIME");
    $this->db->select("T_AK_JURNAL_CREATE.CREATED_BY");
    $this->db->select("T_AK_JURNAL_CREATE.UPDATED_BY");

    $this->db->from('T_AK_JURNAL_CREATE');
    $this->db->join('AK_M_COA', 'AK_M_COA.ID = T_AK_JURNAL_CREATE.COA_ID', 'left');

    $this->db->where("T_AK_JURNAL_CREATE.CREATED_BY='{$this->session->userdata('username')}'");
    $this->db->order_by("T_AK_JURNAL_CREATE.ID", "asc");

    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_AK_JURNAL_CREATE');
  }

  function tambah($data)
  {
        $this->db->insert('T_AK_JURNAL_CREATE', $data);
        return TRUE;
  }

}


