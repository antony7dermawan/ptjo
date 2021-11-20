<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_t_t_pemakaian_rincian extends CI_Model {
    
    
public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_T_T_PEMAKAIAN_RINCIAN', $data);
}




public function select_lap_barang_id($pemakaian_id,$barang_id)
  {
    


    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.ID");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.PEMAKAIAN_ID");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.BARANG_ID");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.QTY");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.SISA_QTY");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.HARGA");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.SUB_TOTAL");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.SISA_QTY_TT");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.UPDATED_BY");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.MARK_FOR_DELETE");




    $this->db->select('T_M_D_BARANG.KODE_BARANG');
    $this->db->select('T_M_D_BARANG.BARANG');
    $this->db->select('T_M_D_BARANG.PART_NUMBER');
    $this->db->select('T_M_D_BARANG.MERK_BARANG');
    $this->db->select('T_M_D_BARANG.POSISI');
    $this->db->select('T_M_D_BARANG.MINIMUM_STOK');


    $this->db->select('T_M_D_SATUAN.SATUAN');
   


    $this->db->from('T_T_T_PEMAKAIAN_RINCIAN');


    $this->db->join('T_M_D_BARANG', 'T_M_D_BARANG.BARANG_ID = T_T_T_PEMAKAIAN_RINCIAN.BARANG_ID', 'left');

    $this->db->join('T_M_D_SATUAN', 'T_M_D_BARANG.SATUAN_ID = T_M_D_SATUAN.ID', 'left');

    
    $this->db->where("T_M_D_BARANG.COMPANY_ID=T_T_T_PEMAKAIAN_RINCIAN.COMPANY_ID");



    if($this->session->userdata('t_t_t_pemakaian_delete_logic')==0)
    {
      $this->db->where('T_T_T_PEMAKAIAN_RINCIAN.MARK_FOR_DELETE',FALSE);
    }

    
    $this->db->where('T_T_T_PEMAKAIAN_RINCIAN.PEMAKAIAN_ID',$pemakaian_id);

    $this->db->where('T_T_T_PEMAKAIAN_RINCIAN.BARANG_ID',$barang_id);

    


    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }




  public function select($pemakaian_id)
  {
    


    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.ID");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.PEMAKAIAN_ID");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.BARANG_ID");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.QTY");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.SISA_QTY");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.HARGA");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.SUB_TOTAL");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.SISA_QTY_TT");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.UPDATED_BY");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.MARK_FOR_DELETE");




    $this->db->select('T_M_D_BARANG.KODE_BARANG');
    $this->db->select('T_M_D_BARANG.BARANG');
    $this->db->select('T_M_D_BARANG.PART_NUMBER');
    $this->db->select('T_M_D_BARANG.MERK_BARANG');
    $this->db->select('T_M_D_BARANG.POSISI');
    $this->db->select('T_M_D_BARANG.MINIMUM_STOK');


    $this->db->select('T_M_D_SATUAN.SATUAN');
   


    $this->db->from('T_T_T_PEMAKAIAN_RINCIAN');


    $this->db->join('T_M_D_BARANG', 'T_M_D_BARANG.BARANG_ID = T_T_T_PEMAKAIAN_RINCIAN.BARANG_ID', 'left');

    $this->db->join('T_M_D_SATUAN', 'T_M_D_BARANG.SATUAN_ID = T_M_D_SATUAN.ID', 'left');

    
    $this->db->where("T_M_D_BARANG.COMPANY_ID=T_T_T_PEMAKAIAN_RINCIAN.COMPANY_ID");

    $this->db->where("T_M_D_BARANG.MARK_FOR_DELETE=FALSE");



    if($this->session->userdata('t_t_t_pemakaian_delete_logic')==0)
    {
      $this->db->where('T_T_T_PEMAKAIAN_RINCIAN.MARK_FOR_DELETE',FALSE);
    }

    
    $this->db->where('T_T_T_PEMAKAIAN_RINCIAN.PEMAKAIAN_ID',$pemakaian_id);

    


    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }



public function select_qty_before_date($limit_date,$barang_id)
  {
    $this->db->select('SUM_QTY');
    $this->db->from('T_M_D_BARANG');
    $this->db->join("(select \"T_T_T_PEMAKAIAN_RINCIAN\".\"BARANG_ID\",sum(\"QTY\")\"SUM_QTY\" from \"T_T_T_PEMAKAIAN_RINCIAN\" LEFT OUTER JOIN \"T_T_T_PEMAKAIAN\" on \"T_T_T_PEMAKAIAN\".\"ID\"=\"T_T_T_PEMAKAIAN_RINCIAN\".\"PEMAKAIAN_ID\" where  \"T_T_T_PEMAKAIAN_RINCIAN\".\"MARK_FOR_DELETE\"=false and \"T_T_T_PEMAKAIAN\".\"DATE\"<'{$limit_date}' and \"T_T_T_PEMAKAIAN\".\"COMPANY_ID\"='{$this->session->userdata('company_id')}'  group by \"T_T_T_PEMAKAIAN_RINCIAN\".\"BARANG_ID\") as t_sum_1", 'T_M_D_BARANG.BARANG_ID = t_sum_1.BARANG_ID', 'left');
    $this->db->where('T_M_D_BARANG.BARANG_ID',$barang_id);



    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function select_qty_before_date_pinlok_out($limit_date,$barang_id)
  {
    $this->db->select('SUM_QTY');
    $this->db->from('T_M_D_BARANG');
    $this->db->join("(select \"T_T_T_PEMBELIAN_RINCIAN\".\"BARANG_ID\",sum(\"QTY\")\"SUM_QTY\" from \"T_T_T_PEMBELIAN_RINCIAN\" LEFT OUTER JOIN \"T_T_T_PEMBELIAN\" on \"T_T_T_PEMBELIAN\".\"ID\"=\"T_T_T_PEMBELIAN_RINCIAN\".\"PEMBELIAN_ID\"  where  \"T_T_T_PEMBELIAN_RINCIAN\".\"MARK_FOR_DELETE\"=false and \"T_T_T_PEMBELIAN\".\"DATE\"<'{$limit_date}' and \"T_T_T_PEMBELIAN\".\"COMPANY_ID_FROM\"='{$this->session->userdata('company_id')}' group by \"T_T_T_PEMBELIAN_RINCIAN\".\"BARANG_ID\") as t_sum_1", 'T_M_D_BARANG.BARANG_ID = t_sum_1.BARANG_ID', 'left');
    $this->db->where('T_M_D_BARANG.BARANG_ID',$barang_id);
    $akun = $this->db->get ();
    return $akun->result ();
  }



  
  public function select_by_pemakaian_id_and_barang_id($pemakaian_id,$barang_id)
  {
    $this->db->select("SISA_QTY");
    $this->db->from('T_T_T_PEMAKAIAN_RINCIAN');

    $this->db->where('T_T_T_PEMAKAIAN_RINCIAN.PEMAKAIAN_ID',$pemakaian_id);
    $this->db->where('T_T_T_PEMAKAIAN_RINCIAN.BARANG_ID',$barang_id);


    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function select_by_id($id)
  {
    


    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.ID");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.PEMAKAIAN_ID");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.BARANG_ID");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.QTY");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.SISA_QTY");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.HARGA");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.SUB_TOTAL");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.SISA_QTY_TT");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.UPDATED_BY");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.MARK_FOR_DELETE");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.PEMBELIAN_RINCIAN_ID");



    $this->db->select('T_M_D_BARANG.KODE_BARANG');
    $this->db->select('T_M_D_BARANG.BARANG');
    $this->db->select('T_M_D_BARANG.PART_NUMBER');
    $this->db->select('T_M_D_BARANG.MERK_BARANG');
    $this->db->select('T_M_D_BARANG.POSISI');
    $this->db->select('T_M_D_BARANG.MINIMUM_STOK');

   


    $this->db->from('T_T_T_PEMAKAIAN_RINCIAN');


    $this->db->join('T_M_D_BARANG', 'T_M_D_BARANG.BARANG_ID = T_T_T_PEMAKAIAN_RINCIAN.BARANG_ID', 'left');

    $this->db->where("T_M_D_BARANG.COMPANY_ID={$this->session->userdata('company_id')}");
    
    $this->db->where('T_T_T_PEMAKAIAN_RINCIAN.ID',$id);

    $akun = $this->db->get ();
    return $akun->result ();
  }



  public function select_rekap_pelanggan($from_date,$to_date)
  {
    $this->db->select("T_M_D_PELANGGAN.ID");
    $this->db->select("T_M_D_PELANGGAN.PELANGGAN");
   
    $this->db->select("SUM_QTY");

    $this->db->select("SUM_SUB_TOTAL");

    


    $this->db->from('T_M_D_PELANGGAN');


 

    $this->db->join("(select \"T_T_T_PEMAKAIAN\".\"PELANGGAN_ID\",sum(\"T_T_T_PEMAKAIAN_RINCIAN\".\"QTY\")\"SUM_QTY\" from \"T_T_T_PEMAKAIAN_RINCIAN\" LEFT OUTER JOIN \"T_T_T_PEMAKAIAN\" on \"T_T_T_PEMAKAIAN\".\"ID\"=\"T_T_T_PEMAKAIAN_RINCIAN\".\"PEMAKAIAN_ID\" where \"T_T_T_PEMAKAIAN\".\"DATE\">='{$from_date}' and \"T_T_T_PEMAKAIAN\".\"DATE\"<='{$to_date}' and \"T_T_T_PEMAKAIAN_RINCIAN\".\"MARK_FOR_DELETE\"=false group by \"T_T_T_PEMAKAIAN\".\"PELANGGAN_ID\") as t_sum_1", 'T_M_D_PELANGGAN.ID = t_sum_1.PELANGGAN_ID', 'left');


    $this->db->join("(select \"T_T_T_PEMAKAIAN\".\"PELANGGAN_ID\",sum(\"T_T_T_PEMAKAIAN_RINCIAN\".\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMAKAIAN_RINCIAN\" LEFT OUTER JOIN \"T_T_T_PEMAKAIAN\" on \"T_T_T_PEMAKAIAN\".\"ID\"=\"T_T_T_PEMAKAIAN_RINCIAN\".\"PEMAKAIAN_ID\" where \"T_T_T_PEMAKAIAN\".\"DATE\">='{$from_date}' and \"T_T_T_PEMAKAIAN\".\"DATE\"<='{$to_date}' and \"T_T_T_PEMAKAIAN_RINCIAN\".\"MARK_FOR_DELETE\"=false group by \"T_T_T_PEMAKAIAN\".\"PELANGGAN_ID\") as t_sum_2", 'T_M_D_PELANGGAN.ID = t_sum_2.PELANGGAN_ID', 'left');

    
    $this->db->where('T_M_D_PELANGGAN.MARK_FOR_DELETE',false);


    $this->db->order_by("PELANGGAN", "asc");

    $akun = $this->db->get ();
    return $akun->result ();
  }




  public function select_rekap_sales($from_date,$to_date)
  {
    $this->db->select("T_M_D_SALES.ID");
    $this->db->select("T_M_D_SALES.SALES");
   
    $this->db->select("SUM_QTY");

    $this->db->select("SUM_SUB_TOTAL");

    


    $this->db->from('T_M_D_SALES');


 

    $this->db->join("(select \"T_T_T_PEMAKAIAN\".\"SALES_ID\",sum(\"T_T_T_PEMAKAIAN_RINCIAN\".\"QTY\")\"SUM_QTY\" from \"T_T_T_PEMAKAIAN_RINCIAN\" LEFT OUTER JOIN \"T_T_T_PEMAKAIAN\" on \"T_T_T_PEMAKAIAN\".\"ID\"=\"T_T_T_PEMAKAIAN_RINCIAN\".\"PEMAKAIAN_ID\" where \"T_T_T_PEMAKAIAN\".\"DATE\">='{$from_date}' and \"T_T_T_PEMAKAIAN\".\"DATE\"<='{$to_date}' and \"T_T_T_PEMAKAIAN_RINCIAN\".\"MARK_FOR_DELETE\"=false group by \"T_T_T_PEMAKAIAN\".\"SALES_ID\") as t_sum_1", 'T_M_D_SALES.ID = t_sum_1.SALES_ID', 'left');


    $this->db->join("(select \"T_T_T_PEMAKAIAN\".\"SALES_ID\",sum(\"T_T_T_PEMAKAIAN_RINCIAN\".\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMAKAIAN_RINCIAN\" LEFT OUTER JOIN \"T_T_T_PEMAKAIAN\" on \"T_T_T_PEMAKAIAN\".\"ID\"=\"T_T_T_PEMAKAIAN_RINCIAN\".\"PEMAKAIAN_ID\" where \"T_T_T_PEMAKAIAN\".\"DATE\">='{$from_date}' and \"T_T_T_PEMAKAIAN\".\"DATE\"<='{$to_date}' and \"T_T_T_PEMAKAIAN_RINCIAN\".\"MARK_FOR_DELETE\"=false group by \"T_T_T_PEMAKAIAN\".\"SALES_ID\") as t_sum_2", 'T_M_D_SALES.ID = t_sum_2.SALES_ID', 'left');

    
    $this->db->where('T_M_D_SALES.MARK_FOR_DELETE',false);



    $this->db->order_by("SALES", "asc");

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

    $this->db->from('T_T_T_PEMAKAIAN');

    $this->db->join('T_T_T_PEMBELIAN', 'T_T_T_PEMBELIAN.ID = T_T_T_PEMAKAIAN.PEMBELIAN_ID', 'left');


    $this->db->join('T_T_T_PEMBELIAN_RINCIAN', 'T_T_T_PEMBELIAN.ID = T_T_T_PEMBELIAN_RINCIAN.PEMBELIAN_ID', 'left');

    $this->db->join('T_M_D_BARANG', 'T_M_D_BARANG.BARANG_ID = T_T_T_PEMBELIAN_RINCIAN.BARANG_ID', 'left');

    $this->db->where("T_M_D_BARANG.COMPANY_ID={$this->session->userdata('company_id')}");

    $this->db->where('T_T_T_PEMBELIAN_RINCIAN.MARK_FOR_DELETE',FALSE);
    $this->db->where('T_T_T_PEMAKAIAN.ID',$retur_pembelian_id);


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




    $this->db->from('T_T_T_PEMAKAIAN');

    $this->db->join('T_T_T_PEMBELIAN', 'T_T_T_PEMBELIAN.ID = T_T_T_PEMAKAIAN.PEMBELIAN_ID', 'left');


    $this->db->join('T_T_T_PEMBELIAN_RINCIAN', 'T_T_T_PEMBELIAN.ID = T_T_T_PEMBELIAN_RINCIAN.PEMBELIAN_ID', 'left');

    $this->db->join('T_M_D_BARANG', 'T_M_D_BARANG.BARANG_ID = T_T_T_PEMBELIAN_RINCIAN.BARANG_ID', 'left');


    $this->db->where("T_M_D_BARANG.COMPANY_ID={$this->session->userdata('company_id')}");

    

    $this->db->where('T_T_T_PEMBELIAN_RINCIAN.BARANG_ID',$barang_id);
    
    $this->db->where('T_T_T_PEMAKAIAN.ID',$retur_pembelian_id);


    $akun = $this->db->get ();
    return $akun->result ();
  }







  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_T_T_PEMAKAIAN_RINCIAN');
  }

  function tambah($data)
  {
        $this->db->insert('T_T_T_PEMAKAIAN_RINCIAN', $data);
        return TRUE;
  }

}


