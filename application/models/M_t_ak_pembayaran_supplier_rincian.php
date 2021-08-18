<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_ak_pembayaran_supplier_rincian extends CI_Model {
    
    

public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_AK_PEMBAYARAN_SUPPLIER_RINCIAN', $data);
}




  public function select($id)
  {
    $this->db->select("T_AK_PEMBAYARAN_SUPPLIER_RINCIAN.ID");
    $this->db->select("T_AK_PEMBAYARAN_SUPPLIER_RINCIAN.PEMBAYARAN_SUPPLIER_ID");
    $this->db->select("T_AK_PEMBAYARAN_SUPPLIER_RINCIAN.PEMBELIAN_ID");
    $this->db->select("T_AK_PEMBAYARAN_SUPPLIER_RINCIAN.CREATED_BY");
    $this->db->select("T_AK_PEMBAYARAN_SUPPLIER_RINCIAN.UPDATED_BY");
    $this->db->select("T_AK_PEMBAYARAN_SUPPLIER_RINCIAN.KETERANGAN");
    $this->db->select("T_AK_PEMBAYARAN_SUPPLIER_RINCIAN.ENABLE_EDIT");



    $this->db->select("T_T_T_PEMBELIAN.DATE");
    $this->db->select("T_T_T_PEMBELIAN.TIME");

    $this->db->select("T_T_T_PEMBELIAN.INV");
    $this->db->select("T_T_T_PEMBELIAN.PAYMENT_T");

    $this->db->select("T_T_T_PEMBELIAN.INV_SUPPLIER");


    $this->db->select("SUM_SUB_TOTAL");
    $this->db->select("SUM_PPN");

    
    $this->db->from('T_AK_PEMBAYARAN_SUPPLIER_RINCIAN');

    $this->db->join('T_T_T_PEMBELIAN', 'T_T_T_PEMBELIAN.ID = T_AK_PEMBAYARAN_SUPPLIER_RINCIAN.PEMBELIAN_ID', 'left');

    $this->db->join('T_AK_PEMBAYARAN_SUPPLIER', 'T_AK_PEMBAYARAN_SUPPLIER.ID = T_AK_PEMBAYARAN_SUPPLIER_RINCIAN.PEMBAYARAN_SUPPLIER_ID', 'left');


    $this->db->join("(select \"PEMBELIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMBELIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false and \"SPECIAL_CASE_ID\"=123 group by \"PEMBELIAN_ID\") as t_sum_1", 'T_T_T_PEMBELIAN.ID = t_sum_1.PEMBELIAN_ID', 'left');


    $this->db->join("(select \"PEMBELIAN_ID\",sum(\"PPN_VALUE\")\"SUM_PPN\" from \"T_T_T_PEMBELIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false and \"SPECIAL_CASE_ID\"=123 group by \"PEMBELIAN_ID\") as t_sum_2", 'T_T_T_PEMBELIAN.ID = t_sum_2.PEMBELIAN_ID', 'left');

    
    $this->db->where('T_AK_PEMBAYARAN_SUPPLIER_RINCIAN.PEMBAYARAN_SUPPLIER_ID', $id);


    $this->db->order_by("ID", "asc");

    $akun = $this->db->get ();
    return $akun->result ();
  }


  public function delete_id($id)
  {
    $this->db->where('PEMBAYARAN_SUPPLIER_ID',$id);
    $this->db->delete('T_AK_PEMBAYARAN_SUPPLIER_RINCIAN');
  }

  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_AK_PEMBAYARAN_SUPPLIER_RINCIAN');
  }

  function tambah($data)
  {
        $this->db->insert('T_AK_PEMBAYARAN_SUPPLIER_RINCIAN', $data);
        return TRUE;
  }

}


