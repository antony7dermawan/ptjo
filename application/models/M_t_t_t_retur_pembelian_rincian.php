<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_t_t_retur_pembelian_rincian extends CI_Model {
    
    
public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_T_T_RETUR_PEMBELIAN_RINCIAN', $data);
}

  public function select($retur_pembelian_id)
  {
    


    $this->db->select("T_T_T_RETUR_PEMBELIAN_RINCIAN.ID");
    $this->db->select("T_T_T_RETUR_PEMBELIAN_RINCIAN.RETUR_PEMBELIAN_ID");
    $this->db->select("T_T_T_RETUR_PEMBELIAN_RINCIAN.BARANG_ID");
    $this->db->select("T_T_T_RETUR_PEMBELIAN_RINCIAN.QTY");
    $this->db->select("T_T_T_RETUR_PEMBELIAN_RINCIAN.HARGA");
    $this->db->select("T_T_T_RETUR_PEMBELIAN_RINCIAN.SUB_TOTAL");
    $this->db->select("T_T_T_RETUR_PEMBELIAN_RINCIAN.SISA_QTY_TT");
    $this->db->select("T_T_T_RETUR_PEMBELIAN_RINCIAN.CREATED_BY");
    $this->db->select("T_T_T_RETUR_PEMBELIAN_RINCIAN.UPDATED_BY");
    $this->db->select("T_T_T_RETUR_PEMBELIAN_RINCIAN.MARK_FOR_DELETE");



    $this->db->select('T_M_D_BARANG.KODE_BARANG');
    $this->db->select('T_M_D_BARANG.BARANG');
    $this->db->select('T_M_D_BARANG.PART_NUMBER');
    $this->db->select('T_M_D_BARANG.MERK_BARANG');
    $this->db->select('T_M_D_BARANG.POSISI');
    $this->db->select('T_M_D_BARANG.MINIMUM_STOK');
    
    $this->db->select('T_M_D_SATUAN.SATUAN');


    $this->db->from('T_T_T_RETUR_PEMBELIAN_RINCIAN');


    $this->db->join('T_M_D_BARANG', 'T_M_D_BARANG.BARANG_ID = T_T_T_RETUR_PEMBELIAN_RINCIAN.BARANG_ID', 'left');
    $this->db->join('T_M_D_SATUAN', 'T_M_D_BARANG.SATUAN_ID = T_M_D_SATUAN.ID', 'left');

    if($this->session->userdata('t_t_t_retur_pembelian_delete_logic')==0)
    {
      $this->db->where('T_T_T_RETUR_PEMBELIAN_RINCIAN.MARK_FOR_DELETE',FALSE);
    }

    $this->db->where("T_M_D_BARANG.COMPANY_ID={$this->session->userdata('company_id')}");
    
    $this->db->where('T_T_T_RETUR_PEMBELIAN_RINCIAN.RETUR_PEMBELIAN_ID',$retur_pembelian_id);
    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }




  public function select_qty_before_date($limit_date,$barang_id)
  {
    $this->db->select('SUM_QTY');
    $this->db->from('T_M_D_BARANG');
    $this->db->join("(select \"T_T_T_RETUR_PEMBELIAN_RINCIAN\".\"BARANG_ID\",sum(\"QTY\")\"SUM_QTY\" from \"T_T_T_RETUR_PEMBELIAN_RINCIAN\" LEFT OUTER JOIN \"T_T_T_RETUR_PEMBELIAN\" on \"T_T_T_RETUR_PEMBELIAN\".\"ID\"=\"T_T_T_RETUR_PEMBELIAN_RINCIAN\".\"RETUR_PEMBELIAN_ID\" where  \"T_T_T_RETUR_PEMBELIAN_RINCIAN\".\"MARK_FOR_DELETE\"=false and \"T_T_T_RETUR_PEMBELIAN\".\"DATE\"<'{$limit_date}' group by \"T_T_T_RETUR_PEMBELIAN_RINCIAN\".\"BARANG_ID\") as t_sum_1", 'T_M_D_BARANG.BARANG_ID = t_sum_1.BARANG_ID', 'left');
    $this->db->where('T_M_D_BARANG.BARANG_ID',$barang_id);
    $akun = $this->db->get ();
    return $akun->result ();
  }


  

  public function select_by_id($id)
  {
    


    $this->db->select("T_T_T_RETUR_PEMBELIAN_RINCIAN.ID");
    $this->db->select("T_T_T_RETUR_PEMBELIAN_RINCIAN.RETUR_PEMBELIAN_ID");
    $this->db->select("T_T_T_RETUR_PEMBELIAN_RINCIAN.BARANG_ID");
    $this->db->select("T_T_T_RETUR_PEMBELIAN_RINCIAN.QTY");
    $this->db->select("T_T_T_RETUR_PEMBELIAN_RINCIAN.HARGA");
    $this->db->select("T_T_T_RETUR_PEMBELIAN_RINCIAN.SUB_TOTAL");
    $this->db->select("T_T_T_RETUR_PEMBELIAN_RINCIAN.SISA_QTY_TT");
    $this->db->select("T_T_T_RETUR_PEMBELIAN_RINCIAN.CREATED_BY");
    $this->db->select("T_T_T_RETUR_PEMBELIAN_RINCIAN.UPDATED_BY");
    $this->db->select("T_T_T_RETUR_PEMBELIAN_RINCIAN.MARK_FOR_DELETE");



    $this->db->select('T_M_D_BARANG.KODE_BARANG');
    $this->db->select('T_M_D_BARANG.BARANG');
    $this->db->select('T_M_D_BARANG.PART_NUMBER');
    $this->db->select('T_M_D_BARANG.MERK_BARANG');
    $this->db->select('T_M_D_BARANG.POSISI');
    $this->db->select('T_M_D_BARANG.MINIMUM_STOK');

   


    $this->db->from('T_T_T_RETUR_PEMBELIAN_RINCIAN');


    $this->db->join('T_M_D_BARANG', 'T_M_D_BARANG.BARANG_ID = T_T_T_RETUR_PEMBELIAN_RINCIAN.BARANG_ID', 'left');


    $this->db->where("T_M_D_BARANG.COMPANY_ID={$this->session->userdata('company_id')}");
    
    $this->db->where('T_T_T_RETUR_PEMBELIAN_RINCIAN.ID',$id);

    $akun = $this->db->get ();
    return $akun->result ();
  }








  public function select_barang_id($retur_pembelian_id)
  {
    
    $this->db->select('T_M_D_BARANG.BARANG_ID');
    $this->db->select('T_M_D_BARANG.KODE_BARANG');
    $this->db->select('T_M_D_BARANG.BARANG');
    $this->db->select('T_M_D_BARANG.PART_NUMBER');
    $this->db->select('T_M_D_BARANG.MERK_BARANG');
    $this->db->select('T_M_D_BARANG.POSISI');
    $this->db->select('T_M_D_BARANG.MINIMUM_STOK');

   
    $this->db->select('T_T_T_PEMBELIAN_RINCIAN.SISA_QTY');
    $this->db->select('T_T_T_PEMBELIAN_RINCIAN.SISA_QTY_RB');

    $this->db->from('T_T_T_RETUR_PEMBELIAN');

    $this->db->join('T_T_T_PEMBELIAN', 'T_T_T_PEMBELIAN.ID = T_T_T_RETUR_PEMBELIAN.PEMBELIAN_ID', 'left');


    $this->db->join('T_T_T_PEMBELIAN_RINCIAN', 'T_T_T_PEMBELIAN.ID = T_T_T_PEMBELIAN_RINCIAN.PEMBELIAN_ID', 'left');

    $this->db->join('T_M_D_BARANG', 'T_M_D_BARANG.BARANG_ID = T_T_T_PEMBELIAN_RINCIAN.BARANG_ID', 'left');


    $this->db->where("T_M_D_BARANG.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->where('T_T_T_PEMBELIAN_RINCIAN.SPECIAL_CASE_ID',0);
    $this->db->where('T_T_T_PEMBELIAN_RINCIAN.MARK_FOR_DELETE',FALSE);
    $this->db->where('T_T_T_RETUR_PEMBELIAN.ID',$retur_pembelian_id);


    $akun = $this->db->get ();
    return $akun->result ();
  }




  public function select_barang_id_only_one($retur_pembelian_id,$barang_id)
  {
    
    $this->db->select('T_M_D_BARANG.BARANG_ID');
    $this->db->select('T_M_D_BARANG.KODE_BARANG');
    $this->db->select('T_M_D_BARANG.BARANG');
    $this->db->select('T_M_D_BARANG.PART_NUMBER');
    $this->db->select('T_M_D_BARANG.MERK_BARANG');
    $this->db->select('T_M_D_BARANG.POSISI');
    $this->db->select('T_M_D_BARANG.MINIMUM_STOK');


    $this->db->select('T_T_T_PEMBELIAN_RINCIAN.ID as PEMBELIAN_RINCIAN_ID');
    $this->db->select('T_T_T_PEMBELIAN_RINCIAN.QTY');
    $this->db->select('T_T_T_PEMBELIAN_RINCIAN.HARGA');
    $this->db->select('T_T_T_PEMBELIAN_RINCIAN.SISA_QTY');
    $this->db->select('T_T_T_PEMBELIAN_RINCIAN.SISA_QTY_RB');




    $this->db->from('T_T_T_RETUR_PEMBELIAN');

    $this->db->join('T_T_T_PEMBELIAN', 'T_T_T_PEMBELIAN.ID = T_T_T_RETUR_PEMBELIAN.PEMBELIAN_ID', 'left');


    $this->db->join('T_T_T_PEMBELIAN_RINCIAN', 'T_T_T_PEMBELIAN.ID = T_T_T_PEMBELIAN_RINCIAN.PEMBELIAN_ID', 'left');

    $this->db->join('T_M_D_BARANG', 'T_M_D_BARANG.BARANG_ID = T_T_T_PEMBELIAN_RINCIAN.BARANG_ID', 'left');


    $this->db->where("T_M_D_BARANG.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->where('T_T_T_PEMBELIAN_RINCIAN.BARANG_ID',$barang_id);
    $this->db->where('T_T_T_PEMBELIAN_RINCIAN.MARK_FOR_DELETE',false);
    $this->db->where('T_T_T_PEMBELIAN_RINCIAN.SPECIAL_CASE_ID',0);
    $this->db->where('T_T_T_RETUR_PEMBELIAN.ID',$retur_pembelian_id);


    $akun = $this->db->get ();
    return $akun->result ();
  }







  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_T_T_RETUR_PEMBELIAN_RINCIAN');
  }

  function tambah($data)
  {
        $this->db->insert('T_T_T_RETUR_PEMBELIAN_RINCIAN', $data);
        return TRUE;
  }

}


