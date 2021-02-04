<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_send_t_t_a_penjualan_pks extends CI_Model {
    
    





  public function select($date_penjualan_pks)
  {
    $this->db->select("ID");
    $this->db->select("DATE");
    $this->db->select("TIME");
    $this->db->select("DIVISI_ID");
    $this->db->select("PKS_ID");
    $this->db->select("NO_POLISI_ID");
    $this->db->select("SUPIR_ID");
    $this->db->select("KENDARAAN_ID");
    $this->db->select("NO_TIKET");
    $this->db->select("BRUTO");
    $this->db->select("SORTASE_PERCENTAGE");
    $this->db->select("SORTASE_KG");
    $this->db->select("NETO");
    $this->db->select("R_JO");
    $this->db->select("R_EX");
    $this->db->select("R_DIV_1");
    $this->db->select("R_DIV_2");
    $this->db->select("R_DIV_3");
    $this->db->select("R_DIV_4");
    $this->db->select("RUMUS");
    $this->db->select("UANG_JALAN");
    $this->db->select("TAMBAHAN");
    $this->db->select("TOTAL_UANG_JALAN");
    $this->db->select("HARGA");
    $this->db->select("TOTAL_PENJUALAN");
    $this->db->select("PPN");
    $this->db->select("CREATED_BY");
    $this->db->select("UPDATED_BY");
    $this->db->select("AREA_ID");
    $this->db->select("COMPANY_ID");
    $this->db->select("INV");
    $this->db->select("INV_INT");
    $this->db->select("ENABLE_EDIT");
    $this->db->select("CHECKED_ID");
    $this->db->select("SPECIAL_ID");

    $this->db->from('T_T_A_PENJUALAN_PKS');
    
    $this->db->where('DATE',$date_penjualan_pks);
    $this->db->where('CHECKED_ID',0); //nol = yang belum disend to cloud

    $this->db->order_by("T_T_A_PENJUALAN_PKS.ID", "asc");

    $akun = $this->db->get ();
    return $akun->result ();
  }



}


