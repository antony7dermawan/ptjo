<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_ak_faktur_penjualan extends CI_Model {
    
    

public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_AK_FAKTUR_PENJUALAN', $data);
}


public function select_no_faktur()
{

    $this->db->select("T_AK_FAKTUR_PENJUALAN.ID");
    $this->db->select("T_AK_FAKTUR_PENJUALAN.DATE");
    $this->db->select("T_AK_FAKTUR_PENJUALAN.TIME");
    $this->db->select("T_AK_FAKTUR_PENJUALAN.PKS_ID");
    $this->db->select("T_AK_FAKTUR_PENJUALAN.CREATED_BY");
    $this->db->select("T_AK_FAKTUR_PENJUALAN.UPDATED_BY");
    $this->db->select("T_AK_FAKTUR_PENJUALAN.KETERANGAN");
    $this->db->select("T_AK_FAKTUR_PENJUALAN.NO_FAKTUR");
    $this->db->select("T_AK_FAKTUR_PENJUALAN.ENABLE_EDIT");
    $this->db->select("T_AK_FAKTUR_PENJUALAN.PAYMENT_T");


    $this->db->select("T_M_A_PKS.PKS");


    $this->db->select("T_AK_FAKTUR_PENJUALAN.PAYMENT_T");

    $this->db->select("SUM_TOTAL_PENJUALAN");


    $this->db->from("T_AK_FAKTUR_PENJUALAN");
    $this->db->join('T_AK_TERIMA_PELANGGAN_NO_FAKTUR', 'T_AK_TERIMA_PELANGGAN_NO_FAKTUR.FAKTUR_PENJUALAN_ID = T_AK_FAKTUR_PENJUALAN.ID', 'left');

    $this->db->join('T_M_A_PKS', 'T_M_A_PKS.PKS_ID = T_AK_FAKTUR_PENJUALAN.PKS_ID', 'left');


    $this->db->join("(select \"T_AK_FAKTUR_PENJUALAN_RINCIAN\".\"FAKTUR_PENJUALAN_ID\",sum(\"T_T_A_PENJUALAN_PKS\".\"TOTAL_PENJUALAN\") as \"SUM_TOTAL_PENJUALAN\" from \"T_T_A_PENJUALAN_PKS\" LEFT OUTER JOIN \"T_AK_FAKTUR_PENJUALAN_RINCIAN\" ON \"T_AK_FAKTUR_PENJUALAN_RINCIAN\".\"PENJUALAN_PKS_ID\" = \"T_T_A_PENJUALAN_PKS\".\"ID\" group by \"FAKTUR_PENJUALAN_ID\") as t_sum", 'T_AK_FAKTUR_PENJUALAN.ID = t_sum.FAKTUR_PENJUALAN_ID', 'left');


    $this->db->where('SUM_TOTAL_PENJUALAN>T_AK_FAKTUR_PENJUALAN.PAYMENT_T');

    $akun = $this->db->get ();
    return $akun->result ();
}


 public function read_no_faktur($no_faktur)
 {
    $this->db->select("NO_FAKTUR");
    $this->db->from('T_AK_FAKTUR_PENJUALAN');
    $this->db->where('NO_FAKTUR',$no_faktur);
    $akun = $this->db->get ();
    return $akun->result ();
 }


/*
public function select_no_faktur()
{

    $this->db->select("ID");
    $this->db->select("NO_FAKTUR");

    $this->db->from('T_AK_FAKTUR_PENJUALAN');

    $akun = $this->db->get ();
    return $akun->result ();
}
*/
  public function select($date_faktur_penjualan)
  {
    $this->db->select("T_AK_FAKTUR_PENJUALAN.ID");
    $this->db->select("T_AK_FAKTUR_PENJUALAN.DATE");
    $this->db->select("T_AK_FAKTUR_PENJUALAN.TIME");
    $this->db->select("T_AK_FAKTUR_PENJUALAN.PKS_ID");
    $this->db->select("T_AK_FAKTUR_PENJUALAN.CREATED_BY");
    $this->db->select("T_AK_FAKTUR_PENJUALAN.UPDATED_BY");
    $this->db->select("T_AK_FAKTUR_PENJUALAN.KETERANGAN");
    $this->db->select("T_AK_FAKTUR_PENJUALAN.NO_FAKTUR");
    $this->db->select("T_AK_FAKTUR_PENJUALAN.ENABLE_EDIT");

    $this->db->select("T_M_A_PKS.NO_PELANGGAN");
    $this->db->select("T_M_A_PKS.NAMA");
    $this->db->select("T_M_A_PKS.PKS");
    $this->db->select("T_M_A_PKS.ALAMAT");
    $this->db->select("T_M_A_PKS.NPWP");
    $this->db->select("T_M_A_PKS.TELEPON");


    $this->db->select("T_AK_FAKTUR_PENJUALAN.PAYMENT_T");


    $this->db->select("sum as \"SUM_TOTAL_PENJUALAN\"");

    $this->db->from('T_AK_FAKTUR_PENJUALAN');

    $this->db->join('T_M_A_PKS', 'T_M_A_PKS.PKS_ID = T_AK_FAKTUR_PENJUALAN.PKS_ID', 'left');

    $this->db->join('T_AK_TERIMA_PELANGGAN_NO_FAKTUR', 'T_AK_FAKTUR_PENJUALAN.ID = T_AK_TERIMA_PELANGGAN_NO_FAKTUR.FAKTUR_PENJUALAN_ID', 'left');

    

    $this->db->join("(select \"T_AK_FAKTUR_PENJUALAN_RINCIAN\".\"FAKTUR_PENJUALAN_ID\",sum(\"T_T_A_PENJUALAN_PKS\".\"TOTAL_PENJUALAN\") from \"T_T_A_PENJUALAN_PKS\" LEFT OUTER JOIN \"T_AK_FAKTUR_PENJUALAN_RINCIAN\" ON \"T_AK_FAKTUR_PENJUALAN_RINCIAN\".\"PENJUALAN_PKS_ID\" = \"T_T_A_PENJUALAN_PKS\".\"ID\" group by \"FAKTUR_PENJUALAN_ID\") as t_sum", 'T_AK_FAKTUR_PENJUALAN.ID = t_sum.FAKTUR_PENJUALAN_ID', 'left');
    
    
    $date_before = date('Y-m-d',(strtotime ( '-30 day' , strtotime ( $date_faktur_penjualan) ) ));

    $this->db->where("T_AK_FAKTUR_PENJUALAN.DATE<='{$date_faktur_penjualan}' and T_AK_FAKTUR_PENJUALAN.DATE>='{$date_before}'");
    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }


  public function select_by_id($id)
  {
    $this->db->select("T_AK_FAKTUR_PENJUALAN.ID");
    $this->db->select("T_AK_FAKTUR_PENJUALAN.DATE");
    $this->db->select("T_AK_FAKTUR_PENJUALAN.TIME");
    $this->db->select("T_AK_FAKTUR_PENJUALAN.PKS_ID");
    $this->db->select("T_AK_FAKTUR_PENJUALAN.CREATED_BY");
    $this->db->select("T_AK_FAKTUR_PENJUALAN.UPDATED_BY");
    $this->db->select("T_AK_FAKTUR_PENJUALAN.KETERANGAN");
    $this->db->select("T_AK_FAKTUR_PENJUALAN.NO_FAKTUR");
    $this->db->select("T_AK_FAKTUR_PENJUALAN.ENABLE_EDIT");

    $this->db->select("T_M_A_PKS.NO_PELANGGAN");
    $this->db->select("T_M_A_PKS.NAMA");
    $this->db->select("T_M_A_PKS.ALAMAT");
    $this->db->select("T_M_A_PKS.NPWP");
    $this->db->select("T_M_A_PKS.TELEPON");


    $this->db->select("sum as \"SUM_TOTAL_PENJUALAN\"");

    $this->db->from('T_AK_FAKTUR_PENJUALAN');

    $this->db->join('T_M_A_PKS', 'T_M_A_PKS.PKS_ID = T_AK_FAKTUR_PENJUALAN.PKS_ID', 'left');

    

    $this->db->join("(select \"T_AK_FAKTUR_PENJUALAN_RINCIAN\".\"FAKTUR_PENJUALAN_ID\",sum(\"T_T_A_PENJUALAN_PKS\".\"TOTAL_PENJUALAN\") from \"T_T_A_PENJUALAN_PKS\" LEFT OUTER JOIN \"T_AK_FAKTUR_PENJUALAN_RINCIAN\" ON \"T_AK_FAKTUR_PENJUALAN_RINCIAN\".\"PENJUALAN_PKS_ID\" = \"T_T_A_PENJUALAN_PKS\".\"ID\" group by \"FAKTUR_PENJUALAN_ID\") as t_sum", 'T_AK_FAKTUR_PENJUALAN.ID = t_sum.FAKTUR_PENJUALAN_ID', 'left');
    
    $this->db->where('T_AK_FAKTUR_PENJUALAN.ID',$id);
    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }



/*

SELECT 
        "T_AK_FAKTUR_PENJUALAN"."ID"  , sum as "SUM_TOTAL_PENJUALAN"
    FROM "T_AK_FAKTUR_PENJUALAN"
    LEFT OUTER JOIN
    "T_AK_FAKTUR_PENJUALAN_RINCIAN"
    ON "T_AK_FAKTUR_PENJUALAN_RINCIAN"."FAKTUR_PENJUALAN_ID" = "T_AK_FAKTUR_PENJUALAN"."ID"
        LEFT OUTER JOIN 
            (select  "ID",sum("TOTAL_PENJUALAN") from "T_T_A_PENJUALAN_PKS" group by "ID") as t_sum 
            ON "T_AK_FAKTUR_PENJUALAN_RINCIAN"."PENJUALAN_PKS_ID" = t_sum."ID" 

*/
  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_AK_FAKTUR_PENJUALAN');
  }

  function tambah($data)
  {
        $this->db->insert('T_AK_FAKTUR_PENJUALAN', $data);
        return TRUE;
  }

}


