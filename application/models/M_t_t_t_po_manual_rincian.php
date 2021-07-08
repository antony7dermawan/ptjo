<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_t_t_po_manual_rincian extends CI_Model {
    
    
public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_T_T_PEMBELIAN_RINCIAN', $data);
}
public function update_by_pembelian_id($data, $pembelian_id)
{
    $this->db->where('PEMBELIAN_ID', $pembelian_id);
    return $this->db->update('T_T_T_PEMBELIAN_RINCIAN', $data);
}

public function select_sisa_qty($barang_id)
{
    $this->db->select('*');




    $this->db->from('T_T_T_PEMBELIAN_RINCIAN');

    

    $this->db->where("COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->where('BARANG_ID',$barang_id);
    $this->db->where('MARK_FOR_DELETE',false);


    $this->db->order_by("ID", "asc");



    $akun = $this->db->get ();
    return $akun->result ();
}
public function select_barang_with_supplier($barang_id)
  {
    

    $this->db->limit(20);
    $this->db->distinct("T_M_D_BARANG.ID");
    $this->db->select("T_M_D_BARANG.ID");
    $this->db->select('T_M_D_BARANG.KODE_BARANG');
    $this->db->select('T_M_D_BARANG.BARANG');
    $this->db->select('T_M_D_BARANG.PART_NUMBER');
    $this->db->select('T_M_D_BARANG.MERK_BARANG');
    $this->db->select('T_M_D_BARANG.POSISI');
    $this->db->select('T_M_D_BARANG.MINIMUM_STOK');


    $this->db->select('T_M_D_SUPPLIER.SUPPLIER');
    $this->db->select('T_T_T_PEMBELIAN_RINCIAN.HARGA');


    $this->db->select('T_T_T_PEMBELIAN.DATE');
   


    $this->db->from('T_M_D_BARANG');

    $this->db->join('T_T_T_PEMBELIAN_RINCIAN', 'T_M_D_BARANG.BARANG_ID = T_T_T_PEMBELIAN_RINCIAN.BARANG_ID', 'left');
    $this->db->join('T_M_D_SUPPLIER', 'T_M_D_SUPPLIER.ID = T_T_T_PEMBELIAN_RINCIAN.SUPPLIER_ID', 'left');

    $this->db->join('T_T_T_PEMBELIAN', 'T_T_T_PEMBELIAN.ID = T_T_T_PEMBELIAN_RINCIAN.PEMBELIAN_ID', 'left');


    $this->db->where("T_M_D_BARANG.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->where("T_T_T_PEMBELIAN_RINCIAN.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->where('T_M_D_BARANG.BARANG_ID',$barang_id);


    $this->db->order_by("ID", "desc");



    $akun = $this->db->get ();
    return $akun->result ();
  }
  public function select($pembelian_id)
  {
    


    $this->db->select("T_T_T_PEMBELIAN_RINCIAN.ID");
    $this->db->select("T_T_T_PEMBELIAN_RINCIAN.PEMBELIAN_ID");
    $this->db->select("T_T_T_PEMBELIAN_RINCIAN.BARANG_ID");
    $this->db->select("T_T_T_PEMBELIAN_RINCIAN.QTY");
    $this->db->select("T_T_T_PEMBELIAN_RINCIAN.SISA_QTY");
    $this->db->select("T_T_T_PEMBELIAN_RINCIAN.HARGA");
    $this->db->select("T_T_T_PEMBELIAN_RINCIAN.SUB_TOTAL");
    $this->db->select("T_T_T_PEMBELIAN_RINCIAN.SISA_QTY_TT");
    $this->db->select("T_T_T_PEMBELIAN_RINCIAN.SPECIAL_CASE_ID");
    $this->db->select("T_T_T_PEMBELIAN_RINCIAN.SUPPLIER_ID");
    $this->db->select("T_T_T_PEMBELIAN_RINCIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMBELIAN_RINCIAN.UPDATED_BY");
    $this->db->select("T_T_T_PEMBELIAN_RINCIAN.MARK_FOR_DELETE");



    $this->db->select('T_M_D_BARANG.KODE_BARANG');
    $this->db->select('T_M_D_BARANG.BARANG');
    $this->db->select('T_M_D_BARANG.PART_NUMBER');
    $this->db->select('T_M_D_BARANG.MERK_BARANG');
    $this->db->select('T_M_D_BARANG.POSISI');
    $this->db->select('T_M_D_BARANG.MINIMUM_STOK');

   


    $this->db->from('T_T_T_PEMBELIAN_RINCIAN');


    $this->db->join('T_M_D_BARANG', 'T_M_D_BARANG.BARANG_ID = T_T_T_PEMBELIAN_RINCIAN.BARANG_ID', 'left');

    if($this->session->userdata('t_t_t_po_manual_delete_logic')==0)
    {
      $this->db->where('T_T_T_PEMBELIAN_RINCIAN.MARK_FOR_DELETE',FALSE);
    }


    $this->db->where("T_M_D_BARANG.COMPANY_ID={$this->session->userdata('company_id')}");
    
    $this->db->where('T_T_T_PEMBELIAN_RINCIAN.PEMBELIAN_ID',$pembelian_id);
    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }





  public function select_sisa_qty_for_1_barang_id($barang_id)
  {
    $this->db->select('SUM_SISA_QTY');
    $this->db->from('T_M_D_BARANG');
    $this->db->join("(select \"BARANG_ID\",sum(\"SISA_QTY\")\"SUM_SISA_QTY\" from \"T_T_T_PEMBELIAN_RINCIAN\" where \"SPECIAL_CASE_ID\"=0 and \"MARK_FOR_DELETE\"=false group by \"BARANG_ID\") as t_sum_1", 'T_M_D_BARANG.BARANG_ID = t_sum_1.BARANG_ID', 'left');
    $this->db->where('T_M_D_BARANG.BARANG_ID',$barang_id);
    $akun = $this->db->get ();
    return $akun->result ();
  }




  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_T_T_PEMBELIAN_RINCIAN');
  }

  function tambah($data)
  {
        $this->db->insert('T_T_T_PEMBELIAN_RINCIAN', $data);
        return TRUE;
  }

}


