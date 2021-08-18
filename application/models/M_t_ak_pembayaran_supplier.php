<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_ak_pembayaran_supplier extends CI_Model {
    
    

public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_AK_PEMBAYARAN_SUPPLIER', $data);
}


public function select_inv_int()
  {
    $date_before = date('Y-m',(strtotime ( '-30 day' , strtotime ( date('Y-m-d')) ) ));
    $this_year = $date_before.'-01';

    $this->db->limit(1);
    $this->db->select("INV_INT");
    $this->db->from('T_AK_PEMBAYARAN_SUPPLIER');
    $this->db->where("COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->where("DATE>='{$this_year}'");
    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }



 public function read_no_faktur($no_faktur)
 {
    $this->db->select("NO_FAKTUR");
    $this->db->from('T_AK_PEMBAYARAN_SUPPLIER');
    $this->db->where('NO_FAKTUR',$no_faktur);
    $akun = $this->db->get ();
    return $akun->result ();
 }


/*
public function select_no_faktur()
{

    $this->db->select("ID");
    $this->db->select("NO_FAKTUR");

    $this->db->from('T_AK_PEMBAYARAN_SUPPLIER');

    $akun = $this->db->get ();
    return $akun->result ();
}
*/
  public function select($date_pembayaran_supplier)
  {
    $this->db->select("T_AK_PEMBAYARAN_SUPPLIER.ID");
    $this->db->select("T_AK_PEMBAYARAN_SUPPLIER.DATE");
    $this->db->select("T_AK_PEMBAYARAN_SUPPLIER.TIME");
    $this->db->select("T_AK_PEMBAYARAN_SUPPLIER.CREATED_BY");
    $this->db->select("T_AK_PEMBAYARAN_SUPPLIER.UPDATED_BY");
    $this->db->select("T_AK_PEMBAYARAN_SUPPLIER.KETERANGAN");
    $this->db->select("T_AK_PEMBAYARAN_SUPPLIER.NO_FAKTUR");
    $this->db->select("T_AK_PEMBAYARAN_SUPPLIER.ENABLE_EDIT");
    $this->db->select("T_AK_PEMBAYARAN_SUPPLIER.COA_ID");


    $this->db->select("T_M_D_SUPPLIER.ID as SUPPLIER_ID");
    $this->db->select("T_M_D_SUPPLIER.SUPPLIER");


    
    $this->db->select("AK_M_COA.NAMA_AKUN");


    $this->db->select("SUM_TOTAL_PENJUALAN");
    $this->db->select("SUM_PAYMENT_T");

    $this->db->select("SUM_PPN_VALUE");


    $this->db->select("SUM_JUMLAH");

    $this->db->select("SUM_ADM_BANK");

    $this->db->select("SUM_DISKON");

    $this->db->from('T_AK_PEMBAYARAN_SUPPLIER');

    $this->db->join('T_M_D_SUPPLIER', 'T_M_D_SUPPLIER.ID = T_AK_PEMBAYARAN_SUPPLIER.SUPPLIER_ID', 'left');

    
    $this->db->join('AK_M_COA', 'AK_M_COA.ID = T_AK_PEMBAYARAN_SUPPLIER.COA_ID', 'left');

    

    $this->db->join("(select \"T_AK_PEMBAYARAN_SUPPLIER_RINCIAN\".\"PEMBAYARAN_SUPPLIER_ID\",sum(\"T_T_T_PEMBELIAN_RINCIAN\".\"SUB_TOTAL\")\"SUM_TOTAL_PENJUALAN\" from \"T_T_T_PEMBELIAN_RINCIAN\"LEFT OUTER JOIN \"T_T_T_PEMBELIAN\" ON \"T_T_T_PEMBELIAN\".\"ID\"=\"T_T_T_PEMBELIAN_RINCIAN\".\"PEMBELIAN_ID\" LEFT OUTER JOIN \"T_AK_PEMBAYARAN_SUPPLIER_RINCIAN\" ON \"T_AK_PEMBAYARAN_SUPPLIER_RINCIAN\".\"PEMBELIAN_ID\" = \"T_T_T_PEMBELIAN\".\"ID\" where \"T_T_T_PEMBELIAN_RINCIAN\".\"MARK_FOR_DELETE\"=false and \"T_T_T_PEMBELIAN_RINCIAN\".\"SPECIAL_CASE_ID\"=123 group by \"PEMBAYARAN_SUPPLIER_ID\") as t_sum", 'T_AK_PEMBAYARAN_SUPPLIER.ID = t_sum.PEMBAYARAN_SUPPLIER_ID', 'left');



    $this->db->join("(select \"T_AK_PEMBAYARAN_SUPPLIER_RINCIAN\".\"PEMBAYARAN_SUPPLIER_ID\",sum(\"T_T_T_PEMBELIAN_RINCIAN\".\"PPN_VALUE\")\"SUM_PPN_VALUE\" from \"T_T_T_PEMBELIAN_RINCIAN\"LEFT OUTER JOIN \"T_T_T_PEMBELIAN\" ON \"T_T_T_PEMBELIAN\".\"ID\"=\"T_T_T_PEMBELIAN_RINCIAN\".\"PEMBELIAN_ID\" LEFT OUTER JOIN \"T_AK_PEMBAYARAN_SUPPLIER_RINCIAN\" ON \"T_AK_PEMBAYARAN_SUPPLIER_RINCIAN\".\"PEMBELIAN_ID\" = \"T_T_T_PEMBELIAN\".\"ID\" where \"T_T_T_PEMBELIAN_RINCIAN\".\"MARK_FOR_DELETE\"=false and \"T_T_T_PEMBELIAN_RINCIAN\".\"SPECIAL_CASE_ID\"=123 group by \"PEMBAYARAN_SUPPLIER_ID\") as t_sum_6", 'T_AK_PEMBAYARAN_SUPPLIER.ID = t_sum_6.PEMBAYARAN_SUPPLIER_ID', 'left');



   

    $this->db->join("(select \"T_AK_PEMBAYARAN_SUPPLIER_RINCIAN\".\"PEMBAYARAN_SUPPLIER_ID\",sum(\"T_T_T_PEMBELIAN\".\"PAYMENT_T\")\"SUM_PAYMENT_T\" from \"T_T_T_PEMBELIAN\"  LEFT OUTER JOIN \"T_AK_PEMBAYARAN_SUPPLIER_RINCIAN\" ON \"T_AK_PEMBAYARAN_SUPPLIER_RINCIAN\".\"PEMBELIAN_ID\" = \"T_T_T_PEMBELIAN\".\"ID\"  group by \"PEMBAYARAN_SUPPLIER_ID\") as t_sum2", 'T_AK_PEMBAYARAN_SUPPLIER.ID = t_sum2.PEMBAYARAN_SUPPLIER_ID', 'left');


    $this->db->join("(select \"PEMBAYARAN_SUPPLIER_ID\",sum(\"JUMLAH\")\"SUM_JUMLAH\" from \"T_AK_PEMBAYARAN_SUPPLIER_METODE_BAYAR\" group by \"PEMBAYARAN_SUPPLIER_ID\") as t_sum_3", 'T_AK_PEMBAYARAN_SUPPLIER.ID = t_sum_3.PEMBAYARAN_SUPPLIER_ID', 'left');

    $this->db->join("(select \"PEMBAYARAN_SUPPLIER_ID\",sum(\"ADM_BANK\")\"SUM_ADM_BANK\" from \"T_AK_PEMBAYARAN_SUPPLIER_METODE_BAYAR\" group by \"PEMBAYARAN_SUPPLIER_ID\") as t_sum_4", 'T_AK_PEMBAYARAN_SUPPLIER.ID = t_sum_4.PEMBAYARAN_SUPPLIER_ID', 'left');



    $this->db->join("(select \"PEMBAYARAN_SUPPLIER_ID\",sum(\"JUMLAH\")\"SUM_DISKON\" from \"T_AK_PEMBAYARAN_SUPPLIER_DISKON\" group by \"PEMBAYARAN_SUPPLIER_ID\") as t_sum_5", 'T_AK_PEMBAYARAN_SUPPLIER.ID = t_sum_5.PEMBAYARAN_SUPPLIER_ID', 'left');
    
    
    $date_before = date('Y-m-d',(strtotime ( '-30 day' , strtotime ( $date_pembayaran_supplier) ) ));

    $this->db->where("T_AK_PEMBAYARAN_SUPPLIER.DATE<='{$date_pembayaran_supplier}' and T_AK_PEMBAYARAN_SUPPLIER.DATE>='{$date_before}'");

    $this->db->where("T_AK_PEMBAYARAN_SUPPLIER.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }


  public function select_by_id($id)
  {
    $this->db->select("T_AK_PEMBAYARAN_SUPPLIER.ID");
    $this->db->select("T_AK_PEMBAYARAN_SUPPLIER.DATE");
    $this->db->select("T_AK_PEMBAYARAN_SUPPLIER.TIME");
    $this->db->select("T_AK_PEMBAYARAN_SUPPLIER.CREATED_BY");
    $this->db->select("T_AK_PEMBAYARAN_SUPPLIER.UPDATED_BY");
    $this->db->select("T_AK_PEMBAYARAN_SUPPLIER.KETERANGAN");
    $this->db->select("T_AK_PEMBAYARAN_SUPPLIER.NO_FAKTUR");
    $this->db->select("T_AK_PEMBAYARAN_SUPPLIER.ENABLE_EDIT");
    $this->db->select("T_AK_PEMBAYARAN_SUPPLIER.COA_ID");


    $this->db->select("T_M_D_SUPPLIER.ID as SUPPLIER_ID");
    $this->db->select("T_M_D_SUPPLIER.SUPPLIER");

    $this->db->select("T_M_D_SUPPLIER.ALAMAT");
    $this->db->select("T_M_D_SUPPLIER.NPWP");
    $this->db->select("T_M_D_SUPPLIER.NIK");
    $this->db->select("T_M_D_SUPPLIER.NO_TELP");







    $this->db->select("SUM_TOTAL_PENJUALAN");
    $this->db->select("SUM_PAYMENT_T");


    $this->db->select("SUM_PPN_VALUE");

    $this->db->select("SUM_JUMLAH");

    $this->db->select("SUM_ADM_BANK");

    $this->db->select("SUM_DISKON");


    $this->db->from('T_AK_PEMBAYARAN_SUPPLIER');

    $this->db->join('T_M_D_SUPPLIER', 'T_M_D_SUPPLIER.ID = T_AK_PEMBAYARAN_SUPPLIER.SUPPLIER_ID', 'left');



    $this->db->join("(select \"T_AK_PEMBAYARAN_SUPPLIER_RINCIAN\".\"PEMBAYARAN_SUPPLIER_ID\",sum(\"T_T_T_PEMBELIAN_RINCIAN\".\"SUB_TOTAL\")\"SUM_TOTAL_PENJUALAN\" from \"T_T_T_PEMBELIAN_RINCIAN\"LEFT OUTER JOIN \"T_T_T_PEMBELIAN\" ON \"T_T_T_PEMBELIAN\".\"ID\"=\"T_T_T_PEMBELIAN_RINCIAN\".\"PEMBELIAN_ID\" LEFT OUTER JOIN \"T_AK_PEMBAYARAN_SUPPLIER_RINCIAN\" ON \"T_AK_PEMBAYARAN_SUPPLIER_RINCIAN\".\"PEMBELIAN_ID\" = \"T_T_T_PEMBELIAN\".\"ID\" where \"T_T_T_PEMBELIAN_RINCIAN\".\"MARK_FOR_DELETE\"=false and \"T_T_T_PEMBELIAN_RINCIAN\".\"SPECIAL_CASE_ID\"=123 group by \"PEMBAYARAN_SUPPLIER_ID\") as t_sum", 'T_AK_PEMBAYARAN_SUPPLIER.ID = t_sum.PEMBAYARAN_SUPPLIER_ID', 'left');



    $this->db->join("(select \"T_AK_PEMBAYARAN_SUPPLIER_RINCIAN\".\"PEMBAYARAN_SUPPLIER_ID\",sum(\"T_T_T_PEMBELIAN_RINCIAN\".\"PPN_VALUE\")\"SUM_PPN_VALUE\" from \"T_T_T_PEMBELIAN_RINCIAN\"LEFT OUTER JOIN \"T_T_T_PEMBELIAN\" ON \"T_T_T_PEMBELIAN\".\"ID\"=\"T_T_T_PEMBELIAN_RINCIAN\".\"PEMBELIAN_ID\" LEFT OUTER JOIN \"T_AK_PEMBAYARAN_SUPPLIER_RINCIAN\" ON \"T_AK_PEMBAYARAN_SUPPLIER_RINCIAN\".\"PEMBELIAN_ID\" = \"T_T_T_PEMBELIAN\".\"ID\" where \"T_T_T_PEMBELIAN_RINCIAN\".\"MARK_FOR_DELETE\"=false  and \"T_T_T_PEMBELIAN_RINCIAN\".\"SPECIAL_CASE_ID\"=123 group by \"PEMBAYARAN_SUPPLIER_ID\") as t_sum_6", 'T_AK_PEMBAYARAN_SUPPLIER.ID = t_sum_6.PEMBAYARAN_SUPPLIER_ID', 'left');

   

    $this->db->join("(select \"T_AK_PEMBAYARAN_SUPPLIER_RINCIAN\".\"PEMBAYARAN_SUPPLIER_ID\",sum(\"T_T_T_PEMBELIAN\".\"PAYMENT_T\")\"SUM_PAYMENT_T\" from \"T_T_T_PEMBELIAN\"  LEFT OUTER JOIN \"T_AK_PEMBAYARAN_SUPPLIER_RINCIAN\" ON \"T_AK_PEMBAYARAN_SUPPLIER_RINCIAN\".\"PEMBELIAN_ID\" = \"T_T_T_PEMBELIAN\".\"ID\"  group by \"PEMBAYARAN_SUPPLIER_ID\") as t_sum2", 'T_AK_PEMBAYARAN_SUPPLIER.ID = t_sum2.PEMBAYARAN_SUPPLIER_ID', 'left');


    $this->db->join("(select \"PEMBAYARAN_SUPPLIER_ID\",sum(\"JUMLAH\")\"SUM_JUMLAH\" from \"T_AK_PEMBAYARAN_SUPPLIER_METODE_BAYAR\" group by \"PEMBAYARAN_SUPPLIER_ID\") as t_sum_3", 'T_AK_PEMBAYARAN_SUPPLIER.ID = t_sum_3.PEMBAYARAN_SUPPLIER_ID', 'left');

    $this->db->join("(select \"PEMBAYARAN_SUPPLIER_ID\",sum(\"ADM_BANK\")\"SUM_ADM_BANK\" from \"T_AK_PEMBAYARAN_SUPPLIER_METODE_BAYAR\" group by \"PEMBAYARAN_SUPPLIER_ID\") as t_sum_4", 'T_AK_PEMBAYARAN_SUPPLIER.ID = t_sum_4.PEMBAYARAN_SUPPLIER_ID', 'left');
    

    $this->db->join("(select \"PEMBAYARAN_SUPPLIER_ID\",sum(\"JUMLAH\")\"SUM_DISKON\" from \"T_AK_PEMBAYARAN_SUPPLIER_DISKON\" group by \"PEMBAYARAN_SUPPLIER_ID\") as t_sum_5", 'T_AK_PEMBAYARAN_SUPPLIER.ID = t_sum_5.PEMBAYARAN_SUPPLIER_ID', 'left');


    $this->db->where('T_AK_PEMBAYARAN_SUPPLIER.ID',$id);
    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }



/*

SELECT 
        "T_AK_PEMBAYARAN_SUPPLIER"."ID"  , sum as "SUM_TOTAL_PENJUALAN"
    FROM "T_AK_PEMBAYARAN_SUPPLIER"
    LEFT OUTER JOIN
    "T_AK_PEMBAYARAN_SUPPLIER_RINCIAN"
    ON "T_AK_PEMBAYARAN_SUPPLIER_RINCIAN"."PEMBAYARAN_SUPPLIER_ID" = "T_AK_PEMBAYARAN_SUPPLIER"."ID"
        LEFT OUTER JOIN 
            (select  "ID",sum("TOTAL_PENJUALAN") from "T_T_A_PENJUALAN_PKS" group by "ID") as t_sum 
            ON "T_AK_PEMBAYARAN_SUPPLIER_RINCIAN"."PENJUALAN_PKS_ID" = t_sum."ID" 

*/
  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_AK_PEMBAYARAN_SUPPLIER');
  }

  function tambah($data)
  {
        $this->db->insert('T_AK_PEMBAYARAN_SUPPLIER', $data);
        return TRUE;
  }

}


