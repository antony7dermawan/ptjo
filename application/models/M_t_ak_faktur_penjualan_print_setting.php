<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_ak_faktur_penjualan_print_setting extends CI_Model {
    


public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_AK_FAKTUR_PENJUALAN_PRINT_SETTING', $data);
}



public function select_id($id)
{
  $this->db->select('SETTING_VALUE');
  $this->db->from('T_AK_FAKTUR_PENJUALAN_PRINT_SETTING');
  $this->db->where('SETTING_ID', $id);
  $akun = $this->db->get ();
  return $akun->result ();
}





  public function select()
  {
    $this->db->select('*');
    $this->db->from('T_AK_FAKTUR_PENJUALAN_PRINT_SETTING');
    $this->db->order_by("ID", "asc");
    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_AK_FAKTUR_PENJUALAN_PRINT_SETTING');
  }

  function tambah($data)
  {
        $this->db->insert('T_AK_FAKTUR_PENJUALAN_PRINT_SETTING', $data);
        return TRUE;
  }

}


