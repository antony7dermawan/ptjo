<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_m_a_uang_jalan extends CI_Model {
    
    

public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_M_A_UANG_JALAN', $data);
}

public function select_by_id($id)
{
  $this->db->select('*');
  $this->db->from('T_M_A_UANG_JALAN');
  $this->db->where('ID', $id);
  $akun = $this->db->get ();
  return $akun->result ();
}




  public function select_uang_jalan($no_polisi_id,$pks_id,$divisi_id,$kendaraan_id)
  {
    $this->db->select("UANG_JALAN");
    $this->db->from('T_M_A_UANG_JALAN');
    
    $this->db->where('NO_POLISI_ID',$no_polisi_id);
    $this->db->where('PKS_ID',$pks_id);
    //$this->db->where('DIVISI_ID',$divisi_id);
    $this->db->where('KENDARAAN_ID',$kendaraan_id);

    $akun = $this->db->get ();
    return $akun->result ();
  }


  public function select()
  {
    $this->db->select("T_M_A_UANG_JALAN.ID,T_M_A_UANG_JALAN.UANG_JALAN,T_M_A_NO_POLISI.NO_POLISI_ID,T_M_A_NO_POLISI.NO_POLISI,T_M_A_PKS.PKS_ID,T_M_A_PKS.PKS,T_M_A_KENDARAAN.KENDARAAN_ID,T_M_A_KENDARAAN.KENDARAAN");
    $this->db->from('T_M_A_UANG_JALAN');
    $this->db->join('T_M_A_NO_POLISI', 'T_M_A_NO_POLISI.NO_POLISI_ID = T_M_A_UANG_JALAN.NO_POLISI_ID', 'left');
    $this->db->join('T_M_A_PKS', 'T_M_A_PKS.PKS_ID = T_M_A_UANG_JALAN.PKS_ID', 'left');
    //$this->db->join('T_M_A_DIVISI', 'T_M_A_DIVISI.DIVISI_ID = T_M_A_UANG_JALAN.DIVISI_ID', 'left');
    $this->db->join('T_M_A_KENDARAAN', 'T_M_A_KENDARAAN.KENDARAAN_ID = T_M_A_UANG_JALAN.KENDARAAN_ID', 'left');

    $this->db->order_by("T_M_A_UANG_JALAN.ID", "asc");

    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_M_A_UANG_JALAN');
  }

  function tambah($data)
  {
        $this->db->insert('T_M_A_UANG_JALAN', $data);
        return TRUE;
  }

}


