<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_t_t_retur_pemakaian_rincian extends CI_Model {
    
    
public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_T_T_RETUR_PEMAKAIAN_RINCIAN', $data);
}

  public function select($retur_pemakaian_id)
  {
    


    $this->db->select("T_T_T_RETUR_PEMAKAIAN_RINCIAN.ID");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN_RINCIAN.RETUR_PEMAKAIAN_ID");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN_RINCIAN.BARANG_ID");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN_RINCIAN.QTY");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN_RINCIAN.HARGA");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN_RINCIAN.SUB_TOTAL");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN_RINCIAN.SISA_QTY_TT");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN_RINCIAN.CREATED_BY");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN_RINCIAN.UPDATED_BY");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN_RINCIAN.MARK_FOR_DELETE");



    $this->db->select('T_M_D_BARANG.KODE_BARANG');
    $this->db->select('T_M_D_BARANG.BARANG');
    $this->db->select('T_M_D_BARANG.PART_NUMBER');
    $this->db->select('T_M_D_BARANG.MERK_BARANG');
    $this->db->select('T_M_D_BARANG.POSISI');
    $this->db->select('T_M_D_BARANG.MINIMUM_STOK');

   
    $this->db->select('T_M_D_SATUAN.SATUAN');

    $this->db->from('T_T_T_RETUR_PEMAKAIAN_RINCIAN');


    $this->db->join('T_M_D_BARANG', 'T_M_D_BARANG.BARANG_ID = T_T_T_RETUR_PEMAKAIAN_RINCIAN.BARANG_ID', 'left');
    $this->db->join('T_M_D_SATUAN', 'T_M_D_BARANG.SATUAN_ID = T_M_D_SATUAN.ID', 'left');

    if($this->session->userdata('t_t_t_retur_pemakaian_delete_logic')==0)
    {
      $this->db->where('T_T_T_RETUR_PEMAKAIAN_RINCIAN.MARK_FOR_DELETE',FALSE);
    }
    

    $this->db->where("T_M_D_BARANG.COMPANY_ID={$this->session->userdata('company_id')}");



    $this->db->where('T_T_T_RETUR_PEMAKAIAN_RINCIAN.RETUR_PEMAKAIAN_ID',$retur_pemakaian_id);
    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }


  public function select_qty_before_date($limit_date,$barang_id)
  {
    $this->db->select('SUM_QTY');
    $this->db->from('T_M_D_BARANG');
    $this->db->join("(select \"T_T_T_RETUR_PEMAKAIAN_RINCIAN\".\"BARANG_ID\",sum(\"QTY\")\"SUM_QTY\" from \"T_T_T_RETUR_PEMAKAIAN_RINCIAN\" LEFT OUTER JOIN \"T_T_T_RETUR_PEMAKAIAN\" on \"T_T_T_RETUR_PEMAKAIAN\".\"ID\"=\"T_T_T_RETUR_PEMAKAIAN_RINCIAN\".\"RETUR_PEMAKAIAN_ID\" where  \"T_T_T_RETUR_PEMAKAIAN_RINCIAN\".\"MARK_FOR_DELETE\"=false and \"T_T_T_RETUR_PEMAKAIAN\".\"DATE\"<'{$limit_date}' group by \"T_T_T_RETUR_PEMAKAIAN_RINCIAN\".\"BARANG_ID\") as t_sum_1", 'T_M_D_BARANG.BARANG_ID = t_sum_1.BARANG_ID', 'left');
    $this->db->where('T_M_D_BARANG.BARANG_ID',$barang_id);


    $akun = $this->db->get ();
    return $akun->result ();
  }

  


  public function select_by_id($id)
  {
    


    $this->db->select("T_T_T_RETUR_PEMAKAIAN_RINCIAN.ID");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN_RINCIAN.RETUR_PEMAKAIAN_ID");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN_RINCIAN.BARANG_ID");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN_RINCIAN.QTY");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN_RINCIAN.HARGA");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN_RINCIAN.SUB_TOTAL");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN_RINCIAN.SISA_QTY_TT");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN_RINCIAN.CREATED_BY");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN_RINCIAN.UPDATED_BY");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN_RINCIAN.MARK_FOR_DELETE");



    $this->db->select('T_M_D_BARANG.KODE_BARANG');
    $this->db->select('T_M_D_BARANG.BARANG');
    $this->db->select('T_M_D_BARANG.PART_NUMBER');
    $this->db->select('T_M_D_BARANG.MERK_BARANG');
    $this->db->select('T_M_D_BARANG.POSISI');
    $this->db->select('T_M_D_BARANG.MINIMUM_STOK');

   


    $this->db->from('T_T_T_RETUR_PEMAKAIAN_RINCIAN');


    $this->db->join('T_M_D_BARANG', 'T_M_D_BARANG.BARANG_ID = T_T_T_RETUR_PEMAKAIAN_RINCIAN.BARANG_ID', 'left');



    $this->db->where("T_M_D_BARANG.COMPANY_ID={$this->session->userdata('company_id')}");



    $this->db->where('T_T_T_RETUR_PEMAKAIAN_RINCIAN.ID',$id);

    $akun = $this->db->get ();
    return $akun->result ();
  }








  public function select_barang_id($retur_pemakaian_id)
  {
    
    $this->db->select('T_M_D_BARANG.BARANG_ID');
    $this->db->select('T_M_D_BARANG.KODE_BARANG');
    $this->db->select('T_M_D_BARANG.BARANG');
    $this->db->select('T_M_D_BARANG.PART_NUMBER');
    $this->db->select('T_M_D_BARANG.MERK_BARANG');
    $this->db->select('T_M_D_BARANG.POSISI');
    $this->db->select('T_M_D_BARANG.MINIMUM_STOK');

    $this->db->select('T_T_T_PEMAKAIAN_RINCIAN.ID');
    $this->db->select('T_T_T_PEMAKAIAN_RINCIAN.SISA_QTY');
    $this->db->select('T_T_T_PEMAKAIAN_RINCIAN.HARGA');

    $this->db->from('T_T_T_RETUR_PEMAKAIAN');

    $this->db->join('T_T_T_PEMAKAIAN', 'T_T_T_PEMAKAIAN.ID = T_T_T_RETUR_PEMAKAIAN.PEMAKAIAN_ID', 'left');


    $this->db->join('T_T_T_PEMAKAIAN_RINCIAN', 'T_T_T_PEMAKAIAN.ID = T_T_T_PEMAKAIAN_RINCIAN.PEMAKAIAN_ID', 'left');

    $this->db->join('T_M_D_BARANG', 'T_M_D_BARANG.BARANG_ID = T_T_T_PEMAKAIAN_RINCIAN.BARANG_ID', 'left');


    $this->db->where("T_M_D_BARANG.COMPANY_ID={$this->session->userdata('company_id')}");



    $this->db->where('T_T_T_PEMAKAIAN_RINCIAN.MARK_FOR_DELETE',FALSE);
    $this->db->where('T_T_T_RETUR_PEMAKAIAN.ID',$retur_pemakaian_id);


    $akun = $this->db->get ();
    return $akun->result ();
  }




  public function select_barang_id_only_one($retur_pemakaian_id,$barang_id)
  {
    
    $this->db->select('T_M_D_BARANG.BARANG_ID');
    $this->db->select('T_M_D_BARANG.KODE_BARANG');
    $this->db->select('T_M_D_BARANG.BARANG');
    $this->db->select('T_M_D_BARANG.PART_NUMBER');
    $this->db->select('T_M_D_BARANG.MERK_BARANG');
    $this->db->select('T_M_D_BARANG.POSISI');
    $this->db->select('T_M_D_BARANG.MINIMUM_STOK');


    $this->db->select('T_T_T_PEMAKAIAN_RINCIAN.ID as PEMAKAIAN_RINCIAN_ID');
    $this->db->select('T_T_T_PEMAKAIAN_RINCIAN.QTY');
    $this->db->select('T_T_T_PEMAKAIAN_RINCIAN.HARGA');
    $this->db->select('T_T_T_PEMAKAIAN_RINCIAN.SISA_QTY');




    $this->db->from('T_T_T_RETUR_PEMAKAIAN');

    $this->db->join('T_T_T_PEMAKAIAN', 'T_T_T_PEMAKAIAN.ID = T_T_T_RETUR_PEMAKAIAN.PEMAKAIAN_ID', 'left');


    $this->db->join('T_T_T_PEMAKAIAN_RINCIAN', 'T_T_T_PEMAKAIAN.ID = T_T_T_PEMAKAIAN_RINCIAN.PEMAKAIAN_ID', 'left');

    $this->db->join('T_M_D_BARANG', 'T_M_D_BARANG.BARANG_ID = T_T_T_PEMAKAIAN_RINCIAN.BARANG_ID', 'left');


    $this->db->where('T_T_T_PEMAKAIAN_RINCIAN.BARANG_ID',$barang_id);
    
    $this->db->where("T_M_D_BARANG.COMPANY_ID={$this->session->userdata('company_id')}");


    
    $this->db->where('T_T_T_PEMAKAIAN_RINCIAN.MARK_FOR_DELETE',false);
    $this->db->where('T_T_T_RETUR_PEMAKAIAN.ID',$retur_pemakaian_id);


    $akun = $this->db->get ();
    return $akun->result ();
  }







  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_T_T_RETUR_PEMAKAIAN_RINCIAN');
  }

  function tambah($data)
  {
        $this->db->insert('T_T_T_RETUR_PEMAKAIAN_RINCIAN', $data);
        return TRUE;
  }

}


