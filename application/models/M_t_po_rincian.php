<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_po_rincian extends CI_Model {
    


public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_PO_RINCIAN', $data);
}








  public function select($po_id)
  {
    $this->db->select('*');
    $this->db->from('T_PO_RINCIAN');

    

    $this->db->where('PO_ID',$po_id);
    $this->db->order_by("ID", "desc");
    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_PO_RINCIAN');
  }

  function tambah($data)
  {
        $this->db->insert('T_PO_RINCIAN', $data);
        return TRUE;
  }

}


