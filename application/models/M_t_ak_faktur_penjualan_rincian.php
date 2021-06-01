<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_ak_faktur_penjualan_rincian extends CI_Model {
    
    

public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_AK_FAKTUR_PENJUALAN_RINCIAN', $data);
}




  public function select($id)
  {
    $this->db->select("T_AK_FAKTUR_PENJUALAN_RINCIAN.ID");
    $this->db->select("T_AK_FAKTUR_PENJUALAN_RINCIAN.FAKTUR_PENJUALAN_ID");
    $this->db->select("T_AK_FAKTUR_PENJUALAN_RINCIAN.PENJUALAN_PKS_ID");
    $this->db->select("T_AK_FAKTUR_PENJUALAN_RINCIAN.CREATED_BY");
    $this->db->select("T_AK_FAKTUR_PENJUALAN_RINCIAN.UPDATED_BY");
    $this->db->select("T_AK_FAKTUR_PENJUALAN_RINCIAN.KETERANGAN");



    $this->db->select("T_T_A_PENJUALAN_PKS.DATE");
    $this->db->select("T_T_A_PENJUALAN_PKS.TIME");

    $this->db->select("T_T_A_PENJUALAN_PKS.NO_TIKET");
    $this->db->select("T_T_A_PENJUALAN_PKS.NETO");
    $this->db->select("T_T_A_PENJUALAN_PKS.HARGA");
    $this->db->select("T_T_A_PENJUALAN_PKS.TOTAL_PENJUALAN");

    $this->db->select("T_AK_FAKTUR_PENJUALAN.ENABLE_EDIT");


    $this->db->from('T_AK_FAKTUR_PENJUALAN_RINCIAN');

    $this->db->join('T_T_A_PENJUALAN_PKS', 'T_T_A_PENJUALAN_PKS.ID = T_AK_FAKTUR_PENJUALAN_RINCIAN.PENJUALAN_PKS_ID', 'left');

    $this->db->join('T_AK_FAKTUR_PENJUALAN', 'T_AK_FAKTUR_PENJUALAN.ID = T_AK_FAKTUR_PENJUALAN_RINCIAN.FAKTUR_PENJUALAN_ID', 'left');

    
    $this->db->where('T_AK_FAKTUR_PENJUALAN_RINCIAN.FAKTUR_PENJUALAN_ID', $id);


    $this->db->order_by("DATE", "asc");

    $akun = $this->db->get ();
    return $akun->result ();
  }


  public function delete_id($id)
  {
    $this->db->where('FAKTUR_PENJUALAN_ID',$id);
    $this->db->delete('T_AK_FAKTUR_PENJUALAN_RINCIAN');
  }

  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_AK_FAKTUR_PENJUALAN_RINCIAN');
  }

  function tambah($data)
  {
        $this->db->insert('T_AK_FAKTUR_PENJUALAN_RINCIAN', $data);
        return TRUE;
  }

}


