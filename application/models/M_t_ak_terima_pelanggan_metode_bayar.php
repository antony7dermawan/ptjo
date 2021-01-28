<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_ak_terima_pelanggan_metode_bayar extends CI_Model {
    
    




  public function select_by_id($id)
  {
    $this->db->select("T_AK_TERIMA_PELANGGAN_METODE_BAYAR.ID");
    $this->db->select("T_AK_TERIMA_PELANGGAN_METODE_BAYAR.TERIMA_PELANGGAN_ID");
    $this->db->select("T_AK_TERIMA_PELANGGAN_METODE_BAYAR.COA_ID");
    $this->db->select("T_AK_TERIMA_PELANGGAN_METODE_BAYAR.JUMLAH");
    $this->db->select("T_AK_TERIMA_PELANGGAN_METODE_BAYAR.CREATED_BY");
    $this->db->select("T_AK_TERIMA_PELANGGAN_METODE_BAYAR.UPDATED_BY");
    $this->db->select("T_AK_TERIMA_PELANGGAN_METODE_BAYAR.ADM_BANK");


    $this->db->select("AK_M_COA.NO_AKUN_1");
    $this->db->select("AK_M_COA.NO_AKUN_2");
    $this->db->select("AK_M_COA.NO_AKUN_3");
    $this->db->select("AK_M_COA.NAMA_AKUN");


    $this->db->from('T_AK_TERIMA_PELANGGAN_METODE_BAYAR');

    $this->db->join('AK_M_COA', 'AK_M_COA.ID = T_AK_TERIMA_PELANGGAN_METODE_BAYAR.COA_ID', 'left');


    
    $this->db->where('T_AK_TERIMA_PELANGGAN_METODE_BAYAR.ID', $id);



    $akun = $this->db->get ();
    return $akun->result ();
  }
  public function select($terima_pelanggan_id)
  {
    $this->db->select("T_AK_TERIMA_PELANGGAN_METODE_BAYAR.ID");
    $this->db->select("T_AK_TERIMA_PELANGGAN_METODE_BAYAR.TERIMA_PELANGGAN_ID");
    $this->db->select("T_AK_TERIMA_PELANGGAN_METODE_BAYAR.COA_ID");
    $this->db->select("T_AK_TERIMA_PELANGGAN_METODE_BAYAR.JUMLAH");
    $this->db->select("T_AK_TERIMA_PELANGGAN_METODE_BAYAR.CREATED_BY");
    $this->db->select("T_AK_TERIMA_PELANGGAN_METODE_BAYAR.UPDATED_BY");
    $this->db->select("T_AK_TERIMA_PELANGGAN_METODE_BAYAR.ADM_BANK");


    $this->db->select("AK_M_COA.NO_AKUN_1");
    $this->db->select("AK_M_COA.NO_AKUN_2");
    $this->db->select("AK_M_COA.NO_AKUN_3");
    $this->db->select("AK_M_COA.NAMA_AKUN");


    $this->db->from('T_AK_TERIMA_PELANGGAN_METODE_BAYAR');

    $this->db->join('AK_M_COA', 'AK_M_COA.ID = T_AK_TERIMA_PELANGGAN_METODE_BAYAR.COA_ID', 'left');


    
    $this->db->where('T_AK_TERIMA_PELANGGAN_METODE_BAYAR.TERIMA_PELANGGAN_ID', $terima_pelanggan_id);


    $this->db->order_by("ID", "asc");

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
    $this->db->delete('T_AK_TERIMA_PELANGGAN_METODE_BAYAR');
  }

  function tambah($data)
  {
        $this->db->insert('T_AK_TERIMA_PELANGGAN_METODE_BAYAR', $data);
        return TRUE;
  }

}


