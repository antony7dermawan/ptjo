<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_ak_terima_pelanggan_diskon extends CI_Model {
    
    




  public function select_by_id($id)
  {
    $this->db->select("T_AK_TERIMA_PELANGGAN_DISKON.ID");
    $this->db->select("T_AK_TERIMA_PELANGGAN_DISKON.TERIMA_PELANGGAN_ID");
    $this->db->select("T_AK_TERIMA_PELANGGAN_DISKON.COA_ID");
    $this->db->select("T_AK_TERIMA_PELANGGAN_DISKON.JUMLAH");
    $this->db->select("T_AK_TERIMA_PELANGGAN_DISKON.CREATED_BY");
    $this->db->select("T_AK_TERIMA_PELANGGAN_DISKON.UPDATED_BY");


    $this->db->select("AK_M_COA.NO_AKUN_1");
    $this->db->select("AK_M_COA.NO_AKUN_2");
    $this->db->select("AK_M_COA.NO_AKUN_3");
    $this->db->select("AK_M_COA.NAMA_AKUN");


    $this->db->from('T_AK_TERIMA_PELANGGAN_DISKON');

    $this->db->join('AK_M_COA', 'AK_M_COA.ID = T_AK_TERIMA_PELANGGAN_DISKON.COA_ID', 'left');


    
    $this->db->where('T_AK_TERIMA_PELANGGAN_DISKON.ID', $id);



    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function select($terima_pelanggan_id)
  {
    $this->db->select("T_AK_TERIMA_PELANGGAN_DISKON.ID");
    $this->db->select("T_AK_TERIMA_PELANGGAN_DISKON.TERIMA_PELANGGAN_ID");
    $this->db->select("T_AK_TERIMA_PELANGGAN_DISKON.COA_ID");
    $this->db->select("T_AK_TERIMA_PELANGGAN_DISKON.JUMLAH");
    $this->db->select("T_AK_TERIMA_PELANGGAN_DISKON.CREATED_BY");
    $this->db->select("T_AK_TERIMA_PELANGGAN_DISKON.UPDATED_BY");


    $this->db->select("AK_M_COA.NO_AKUN_1");
    $this->db->select("AK_M_COA.NO_AKUN_2");
    $this->db->select("AK_M_COA.NO_AKUN_3");
    $this->db->select("AK_M_COA.NAMA_AKUN");


    $this->db->from('T_AK_TERIMA_PELANGGAN_DISKON');

    $this->db->join('AK_M_COA', 'AK_M_COA.ID = T_AK_TERIMA_PELANGGAN_DISKON.COA_ID', 'left');


    
    $this->db->where('T_AK_TERIMA_PELANGGAN_DISKON.TERIMA_PELANGGAN_ID', $terima_pelanggan_id);


    $this->db->order_by("ID", "asc");

    $akun = $this->db->get ();
    return $akun->result ();
  }


  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_AK_TERIMA_PELANGGAN_DISKON');
  }

  function tambah($data)
  {
        $this->db->insert('T_AK_TERIMA_PELANGGAN_DISKON', $data);
        return TRUE;
  }

}


