<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_t_t_pembelian extends CI_Model {
    
    
public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_T_T_PEMBELIAN', $data);
}







public function select_range_date_per_supplier($from_date,$to_date,$supplier_id)
  {
    $this->db->select("T_T_T_PEMBELIAN.ID");
    $this->db->select("T_T_T_PEMBELIAN.DATE");
    $this->db->select("T_T_T_PEMBELIAN.TIME");
    $this->db->select("T_T_T_PEMBELIAN.NEW_DATE");
    $this->db->select("T_T_T_PEMBELIAN.INV");
    $this->db->select("T_T_T_PEMBELIAN.INV_INT");
    $this->db->select("T_T_T_PEMBELIAN.COMPANY_ID");
    $this->db->select("T_T_T_PEMBELIAN.PAYMENT_METHOD_ID");
    $this->db->select("T_T_T_PEMBELIAN.SUPPLIER_ID");
    $this->db->select("T_T_T_PEMBELIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMBELIAN.UPDATED_BY");
    $this->db->select("T_T_T_PEMBELIAN.MARK_FOR_DELETE");
    $this->db->select("T_T_T_PEMBELIAN.KET");
    $this->db->select("T_T_T_PEMBELIAN.PRINTED");
    $this->db->select("T_T_T_PEMBELIAN.INV_SUPPLIER");
    $this->db->select("T_T_T_PEMBELIAN.PAYMENT_T");

    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    $this->db->select("T_M_D_SUPPLIER.SUPPLIER");


    $this->db->select("SUM_SUB_TOTAL");

   


    $this->db->from('T_T_T_PEMBELIAN');


    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PEMBELIAN.PAYMENT_METHOD_ID', 'left');
    $this->db->join('T_M_D_SUPPLIER', 'T_M_D_SUPPLIER.ID = T_T_T_PEMBELIAN.SUPPLIER_ID', 'left');

    $this->db->join("(select \"PEMBELIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMBELIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PEMBELIAN_ID\") as t_sum_1", 'T_T_T_PEMBELIAN.ID = t_sum_1.PEMBELIAN_ID', 'left');

    if($this->session->userdata('t_t_t_pembelian_delete_logic')==0)
    {
      $this->db->where('T_T_T_PEMBELIAN.MARK_FOR_DELETE',FALSE);
    }


    $this->db->where('T_T_T_PEMBELIAN.SUPPLIER_ID',$supplier_id);
    


    $this->db->where("(T_T_T_PEMBELIAN.T_STATUS=0 or T_T_T_PEMBELIAN.T_STATUS=1 or T_T_T_PEMBELIAN.T_STATUS=2)");


   

    $this->db->where("T_T_T_PEMBELIAN.DATE<='{$to_date}' and T_T_T_PEMBELIAN.DATE>='{$from_date}'");

    $this->db->where("T_T_T_PEMBELIAN.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }







  public function select_pinlok($date_pembelian)
  {
    $this->db->select("T_T_T_PEMBELIAN.ID");
    $this->db->select("T_T_T_PEMBELIAN.DATE");
    $this->db->select("T_T_T_PEMBELIAN.TIME");
    $this->db->select("T_T_T_PEMBELIAN.NEW_DATE");
    $this->db->select("T_T_T_PEMBELIAN.INV");
    $this->db->select("T_T_T_PEMBELIAN.INV_INT");
    $this->db->select("T_T_T_PEMBELIAN.COMPANY_ID");
    $this->db->select("T_T_T_PEMBELIAN.PAYMENT_METHOD_ID");
    
    $this->db->select("T_T_T_PEMBELIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMBELIAN.UPDATED_BY");
    $this->db->select("T_T_T_PEMBELIAN.MARK_FOR_DELETE");
    $this->db->select("T_T_T_PEMBELIAN.KET");
    $this->db->select("T_T_T_PEMBELIAN.PRINTED");
    $this->db->select("T_T_T_PEMBELIAN.INV_SUPPLIER");

    $this->db->select("T_T_T_PEMBELIAN.NAMA_BANK");
    $this->db->select("T_T_T_PEMBELIAN.CABANG");
    $this->db->select("T_T_T_PEMBELIAN.NOREK");
    $this->db->select("T_T_T_PEMBELIAN.ATAS_NAMA");

    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    

    $this->db->select("T_M_D_NO_POLISI.NO_POLISI");
    $this->db->select("T_M_D_SUPIR.SUPIR");

    $this->db->select("T_M_D_LOKASI.LOKASI");



    $this->db->select("T_M_D_COMPANY.COMPANY");
    $this->db->select("T_M_D_ANGGOTA.ANGGOTA");

    $this->db->select("SUM_SUB_TOTAL");

   


    $this->db->from('T_T_T_PEMBELIAN');


    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PEMBELIAN.PAYMENT_METHOD_ID', 'left');
    
    $this->db->join('T_M_D_ANGGOTA', 'T_M_D_ANGGOTA.ID = T_T_T_PEMBELIAN.ANGGOTA_ID', 'left');

    $this->db->join("(select \"PEMBELIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMBELIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PEMBELIAN_ID\") as t_sum_1", 'T_T_T_PEMBELIAN.ID = t_sum_1.PEMBELIAN_ID', 'left');


    

    $this->db->join('T_M_D_NO_POLISI', 'T_M_D_NO_POLISI.ID = T_T_T_PEMBELIAN.NO_POLISI_ID', 'left');

    $this->db->join('T_M_D_SUPIR', 'T_M_D_SUPIR.ID = T_T_T_PEMBELIAN.SUPIR_ID', 'left');

    $this->db->join('T_M_D_LOKASI', 'T_M_D_LOKASI.ID = T_T_T_PEMBELIAN.LOKASI_ID', 'left');
    
    $this->db->join('T_M_D_COMPANY', 'T_M_D_COMPANY.ID = T_T_T_PEMBELIAN.COMPANY_ID', 'left');



    $this->db->where("(T_T_T_PEMBELIAN.T_STATUS=50) or (T_T_T_PEMBELIAN.T_STATUS=5)");


    $date_before = date('Y-m-d',(strtotime ( '-30 day' , strtotime ( $date_pembelian) ) ));

    $this->db->where("T_T_T_PEMBELIAN.NEW_DATE<='{$date_pembelian}' and T_T_T_PEMBELIAN.NEW_DATE>='{$date_before}'");

    $this->db->where("T_T_T_PEMBELIAN.COMPANY_ID_FROM={$this->session->userdata('company_id')}");
    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }















  public function select_pinlok_in($date_pembelian)
  {
    $this->db->select("T_T_T_PEMBELIAN.ID");
    $this->db->select("T_T_T_PEMBELIAN.DATE");
    $this->db->select("T_T_T_PEMBELIAN.TIME");
    $this->db->select("T_T_T_PEMBELIAN.NEW_DATE");
    $this->db->select("T_T_T_PEMBELIAN.INV");
    $this->db->select("T_T_T_PEMBELIAN.INV_INT");
    $this->db->select("T_T_T_PEMBELIAN.COMPANY_ID");
    $this->db->select("T_T_T_PEMBELIAN.PAYMENT_METHOD_ID");
    $this->db->select("T_T_T_PEMBELIAN.T_STATUS");


    $this->db->select("T_T_T_PEMBELIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMBELIAN.UPDATED_BY");
    $this->db->select("T_T_T_PEMBELIAN.MARK_FOR_DELETE");
    $this->db->select("T_T_T_PEMBELIAN.KET");
    $this->db->select("T_T_T_PEMBELIAN.PRINTED");
    $this->db->select("T_T_T_PEMBELIAN.INV_SUPPLIER");

    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    

    $this->db->select("T_M_D_NO_POLISI.NO_POLISI");
    $this->db->select("T_M_D_SUPIR.SUPIR");

    $this->db->select("T_M_D_LOKASI.LOKASI");



    $this->db->select("T_M_D_COMPANY.COMPANY");

    $this->db->select("SUM_SUB_TOTAL");

   


    $this->db->from('T_T_T_PEMBELIAN');


    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PEMBELIAN.PAYMENT_METHOD_ID', 'left');
    

    $this->db->join("(select \"PEMBELIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMBELIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PEMBELIAN_ID\") as t_sum_1", 'T_T_T_PEMBELIAN.ID = t_sum_1.PEMBELIAN_ID', 'left');


    

    $this->db->join('T_M_D_NO_POLISI', 'T_M_D_NO_POLISI.ID = T_T_T_PEMBELIAN.NO_POLISI_ID', 'left');

    $this->db->join('T_M_D_SUPIR', 'T_M_D_SUPIR.ID = T_T_T_PEMBELIAN.SUPIR_ID', 'left');

    $this->db->join('T_M_D_LOKASI', 'T_M_D_LOKASI.ID = T_T_T_PEMBELIAN.LOKASI_ID', 'left');
    
    $this->db->join('T_M_D_COMPANY', 'T_M_D_COMPANY.ID = T_T_T_PEMBELIAN.COMPANY_ID_FROM', 'left');



    $this->db->where("(T_T_T_PEMBELIAN.T_STATUS=50 or T_T_T_PEMBELIAN.T_STATUS=5)");


    $date_before = date('Y-m-d',(strtotime ( '-30 day' , strtotime ( $date_pembelian) ) ));

    $this->db->where("T_T_T_PEMBELIAN.DATE<='{$date_pembelian}' and T_T_T_PEMBELIAN.DATE>='{$date_before}'");

    $this->db->where("T_T_T_PEMBELIAN.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }






public function select_date($supplier_id,$from_date,$to_date)
{
    $this->db->select("T_T_T_PEMBELIAN.ID");
    $this->db->select("T_T_T_PEMBELIAN.DATE");
    $this->db->select("T_T_T_PEMBELIAN.TIME");
    $this->db->select("T_T_T_PEMBELIAN.NEW_DATE");
    $this->db->select("T_T_T_PEMBELIAN.INV");
    $this->db->select("T_T_T_PEMBELIAN.INV_INT");
    $this->db->select("T_T_T_PEMBELIAN.COMPANY_ID");
    $this->db->select("T_T_T_PEMBELIAN.PAYMENT_METHOD_ID");
    $this->db->select("T_T_T_PEMBELIAN.SUPPLIER_ID");
    $this->db->select("T_T_T_PEMBELIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMBELIAN.UPDATED_BY");
    $this->db->select("T_T_T_PEMBELIAN.MARK_FOR_DELETE");
    $this->db->select("T_T_T_PEMBELIAN.KET");
    $this->db->select("T_T_T_PEMBELIAN.PRINTED");
    $this->db->select("T_T_T_PEMBELIAN.INV_SUPPLIER");
    $this->db->select("T_T_T_PEMBELIAN.PAYMENT_T");
    $this->db->select("T_T_T_PEMBELIAN.TABLE_CODE");

    $this->db->select("T_T_T_PEMBELIAN.NAMA_BANK");
    $this->db->select("T_T_T_PEMBELIAN.CABANG");
    $this->db->select("T_T_T_PEMBELIAN.NOREK");
    $this->db->select("T_T_T_PEMBELIAN.ATAS_NAMA");

    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    $this->db->select("T_M_D_SUPPLIER.SUPPLIER");

    $this->db->select("T_M_D_ANGGOTA.ANGGOTA");

    $this->db->select("SUM_SUB_TOTAL");
    $this->db->select("SUM_PPN");

   


    $this->db->from('T_T_T_PEMBELIAN');


    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PEMBELIAN.PAYMENT_METHOD_ID', 'left');
    $this->db->join('T_M_D_SUPPLIER', 'T_M_D_SUPPLIER.ID = T_T_T_PEMBELIAN.SUPPLIER_ID', 'left');

    $this->db->join('T_M_D_ANGGOTA', 'T_M_D_ANGGOTA.ID = T_T_T_PEMBELIAN.ANGGOTA_ID', 'left');


    $this->db->join("(select \"PEMBELIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMBELIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PEMBELIAN_ID\") as t_sum_1", 'T_T_T_PEMBELIAN.ID = t_sum_1.PEMBELIAN_ID', 'left');

    $this->db->join("(select \"PEMBELIAN_ID\",sum(\"PPN_VALUE\")\"SUM_PPN\" from \"T_T_T_PEMBELIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PEMBELIAN_ID\") as t_sum_2", 'T_T_T_PEMBELIAN.ID = t_sum_2.PEMBELIAN_ID', 'left');

    


    $this->db->where("(T_T_T_PEMBELIAN.T_STATUS=0 or T_T_T_PEMBELIAN.T_STATUS=1 or T_T_T_PEMBELIAN.T_STATUS=2)");

    $this->db->where('T_T_T_PEMBELIAN.ENABLE_EDIT',1);
    

    $this->db->where("T_T_T_PEMBELIAN.DATE<='{$to_date}' and T_T_T_PEMBELIAN.DATE>='{$from_date}'");

    $this->db->where("T_T_T_PEMBELIAN.COMPANY_ID={$this->session->userdata('company_id')}");

    $this->db->where("T_T_T_PEMBELIAN.SUPPLIER_ID={$supplier_id}");

    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
}

public function select_inv_po_auto_in_that_day($date,$supplier_id)
{
    $this->db->limit(1);
    $this->db->select("*");
    $this->db->from('T_T_T_PEMBELIAN');

    $this->db->where("COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->where("SUPPLIER_ID={$supplier_id}");
    $this->db->where('MARK_FOR_DELETE',false);
    $this->db->where('T_STATUS',20);
    $this->db->where("INV_SUPPLIER=''");
    $this->db->where("DATE='{$date}'");

    $this->db->order_by("ID", "desc");
    $akun = $this->db->get ();
    return $akun->result ();
}



public function select_inv_pembelian()
{
    $this->db->limit(100000);
    $this->db->select("ID");
    $this->db->select("INV");
    $this->db->from('T_T_T_PEMBELIAN');
    $this->db->where('MARK_FOR_DELETE',false);
    $this->db->order_by("ID", "desc");
    $akun = $this->db->get ();
    return $akun->result ();
}





public function select_range_date($from_date,$to_date,$kredit_logic)
  {
    $this->db->select("T_T_T_PEMBELIAN.ID");
    $this->db->select("T_T_T_PEMBELIAN.DATE");
    $this->db->select("T_T_T_PEMBELIAN.TIME");
    $this->db->select("T_T_T_PEMBELIAN.NEW_DATE");
    $this->db->select("T_T_T_PEMBELIAN.INV");
    $this->db->select("T_T_T_PEMBELIAN.INV_INT");
    $this->db->select("T_T_T_PEMBELIAN.COMPANY_ID");
    $this->db->select("T_T_T_PEMBELIAN.PAYMENT_METHOD_ID");
    $this->db->select("T_T_T_PEMBELIAN.SUPPLIER_ID");
    $this->db->select("T_T_T_PEMBELIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMBELIAN.UPDATED_BY");
    $this->db->select("T_T_T_PEMBELIAN.MARK_FOR_DELETE");
    $this->db->select("T_T_T_PEMBELIAN.KET");
    $this->db->select("T_T_T_PEMBELIAN.PRINTED");
    $this->db->select("T_T_T_PEMBELIAN.INV_SUPPLIER");

    $this->db->select("T_T_T_PEMBELIAN.NAMA_BANK");
    $this->db->select("T_T_T_PEMBELIAN.CABANG");
    $this->db->select("T_T_T_PEMBELIAN.NOREK");
    $this->db->select("T_T_T_PEMBELIAN.ATAS_NAMA");

    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    $this->db->select("T_M_D_SUPPLIER.SUPPLIER");

    $this->db->select("T_M_D_ANGGOTA.ANGGOTA");

    $this->db->select("SUM_SUB_TOTAL");
    $this->db->select("SUM_PPN");

   


    $this->db->from('T_T_T_PEMBELIAN');


    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PEMBELIAN.PAYMENT_METHOD_ID', 'left');
    $this->db->join('T_M_D_SUPPLIER', 'T_M_D_SUPPLIER.ID = T_T_T_PEMBELIAN.SUPPLIER_ID', 'left');

    $this->db->join('T_M_D_ANGGOTA', 'T_M_D_ANGGOTA.ID = T_T_T_PEMBELIAN.ANGGOTA_ID', 'left');


    $this->db->join("(select \"PEMBELIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMBELIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PEMBELIAN_ID\") as t_sum_1", 'T_T_T_PEMBELIAN.ID = t_sum_1.PEMBELIAN_ID', 'left');

    $this->db->join("(select \"PEMBELIAN_ID\",sum(\"PPN_VALUE\")\"SUM_PPN\" from \"T_T_T_PEMBELIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PEMBELIAN_ID\") as t_sum_2", 'T_T_T_PEMBELIAN.ID = t_sum_2.PEMBELIAN_ID', 'left');



    if($this->session->userdata('t_t_t_pembelian_delete_logic')==0)
    {
      $this->db->where('T_T_T_PEMBELIAN.MARK_FOR_DELETE',FALSE);
    }

    if($kredit_logic==1)
    {
        $this->db->where('T_T_T_PEMBELIAN.PAYMENT_METHOD_ID',2);
    }


    $this->db->where("(T_T_T_PEMBELIAN.T_STATUS=0 or T_T_T_PEMBELIAN.T_STATUS=1 or T_T_T_PEMBELIAN.T_STATUS=2)");


   

    $this->db->where("T_T_T_PEMBELIAN.DATE<='{$to_date}' and T_T_T_PEMBELIAN.DATE>='{$from_date}'");

    $this->db->where("T_T_T_PEMBELIAN.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }





  public function select_dashboard()
  {
    $this->db->select("T_T_T_PEMBELIAN.ID");
    $this->db->select("T_T_T_PEMBELIAN.DATE");
    $this->db->select("T_T_T_PEMBELIAN.TIME");
    $this->db->select("T_T_T_PEMBELIAN.NEW_DATE");
    $this->db->select("T_T_T_PEMBELIAN.INV");
    $this->db->select("T_T_T_PEMBELIAN.INV_INT");
    $this->db->select("T_T_T_PEMBELIAN.COMPANY_ID");
    $this->db->select("T_T_T_PEMBELIAN.PAYMENT_METHOD_ID");
    $this->db->select("T_T_T_PEMBELIAN.SUPPLIER_ID");
    $this->db->select("T_T_T_PEMBELIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMBELIAN.UPDATED_BY");
    $this->db->select("T_T_T_PEMBELIAN.MARK_FOR_DELETE");
    $this->db->select("T_T_T_PEMBELIAN.KET");
    $this->db->select("T_T_T_PEMBELIAN.PRINTED");
    $this->db->select("T_T_T_PEMBELIAN.INV_SUPPLIER");
    $this->db->select("T_T_T_PEMBELIAN.PAYMENT_T");

    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    $this->db->select("T_M_D_SUPPLIER.SUPPLIER");


    $this->db->select("SUM_SUB_TOTAL");
    $this->db->select("SUM_PPN");

   


    $this->db->from('T_T_T_PEMBELIAN');


    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PEMBELIAN.PAYMENT_METHOD_ID', 'left');
    $this->db->join('T_M_D_SUPPLIER', 'T_M_D_SUPPLIER.ID = T_T_T_PEMBELIAN.SUPPLIER_ID', 'left');

    $this->db->join("(select \"PEMBELIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMBELIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PEMBELIAN_ID\") as t_sum_1", 'T_T_T_PEMBELIAN.ID = t_sum_1.PEMBELIAN_ID', 'left');

    $this->db->join("(select \"PEMBELIAN_ID\",sum(\"PPN_VALUE\")\"SUM_PPN\" from \"T_T_T_PEMBELIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PEMBELIAN_ID\") as t_sum_2", 'T_T_T_PEMBELIAN.ID = t_sum_2.PEMBELIAN_ID', 'left');


    $this->db->where("(T_T_T_PEMBELIAN.T_STATUS=0 or T_T_T_PEMBELIAN.T_STATUS=10 or T_T_T_PEMBELIAN.T_STATUS=1 or T_T_T_PEMBELIAN.T_STATUS=2)");

    $this->db->where(" \"T_T_T_PEMBELIAN\".\"PAYMENT_T\" <> (\"SUM_SUB_TOTAL\"  + \"SUM_PPN\")");


    $this->db->where("T_T_T_PEMBELIAN.MARK_FOR_DELETE='false' ");

    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }















  public function select_hutang_supplier()
  {
    
    $this->db->select("T_M_D_SUPPLIER.ID");
    $this->db->select("T_M_D_SUPPLIER.SUPPLIER");


    $this->db->select("SUM_SUB_TOTAL");
    $this->db->select("SUM_PPN");
    $this->db->select("SUM_PAYMENT_T");

    $this->db->from('T_M_D_SUPPLIER');


    $this->db->join("(select \"T_T_T_PEMBELIAN\".\"SUPPLIER_ID\",sum(\"T_T_T_PEMBELIAN_RINCIAN\".\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMBELIAN_RINCIAN\" LEFT OUTER JOIN \"T_T_T_PEMBELIAN\" on \"T_T_T_PEMBELIAN\".\"ID\"=\"T_T_T_PEMBELIAN_RINCIAN\".\"PEMBELIAN_ID\" where \"T_T_T_PEMBELIAN_RINCIAN\".\"MARK_FOR_DELETE\"=false  group by \"T_T_T_PEMBELIAN\".\"SUPPLIER_ID\") as t_sum_5", 'T_M_D_SUPPLIER.ID = t_sum_5.SUPPLIER_ID', 'left');

    $this->db->join("(select \"T_T_T_PEMBELIAN\".\"SUPPLIER_ID\",sum(\"T_T_T_PEMBELIAN_RINCIAN\".\"PPN_VALUE\")\"SUM_PPN\" from \"T_T_T_PEMBELIAN_RINCIAN\" LEFT OUTER JOIN \"T_T_T_PEMBELIAN\" on \"T_T_T_PEMBELIAN\".\"ID\"=\"T_T_T_PEMBELIAN_RINCIAN\".\"PEMBELIAN_ID\" where \"T_T_T_PEMBELIAN_RINCIAN\".\"MARK_FOR_DELETE\"=false group by \"T_T_T_PEMBELIAN\".\"SUPPLIER_ID\") as t_sum_1", 'T_M_D_SUPPLIER.ID = t_sum_1.SUPPLIER_ID', 'left');

    $this->db->join("(select \"SUPPLIER_ID\",sum(\"PAYMENT_T\")\"SUM_PAYMENT_T\" from \"T_T_T_PEMBELIAN\" where \"MARK_FOR_DELETE\"=false group by \"SUPPLIER_ID\") as t_sum_2", 'T_M_D_SUPPLIER.ID = t_sum_2.SUPPLIER_ID', 'left');

    $this->db->where(" \"SUM_PAYMENT_T\" <> (\"SUM_SUB_TOTAL\"  + \"SUM_PPN\")");

    $akun = $this->db->get ();
    return $akun->result ();
  }




  public function select($date_pembelian)
  {
    $this->db->select("T_T_T_PEMBELIAN.ID");
    $this->db->select("T_T_T_PEMBELIAN.DATE");
    $this->db->select("T_T_T_PEMBELIAN.TIME");
    $this->db->select("T_T_T_PEMBELIAN.NEW_DATE");
    $this->db->select("T_T_T_PEMBELIAN.INV");
    $this->db->select("T_T_T_PEMBELIAN.INV_INT");
    $this->db->select("T_T_T_PEMBELIAN.COMPANY_ID");
    $this->db->select("T_T_T_PEMBELIAN.PAYMENT_METHOD_ID");
    $this->db->select("T_T_T_PEMBELIAN.SUPPLIER_ID");
    $this->db->select("T_T_T_PEMBELIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMBELIAN.UPDATED_BY");
    $this->db->select("T_T_T_PEMBELIAN.MARK_FOR_DELETE");
    $this->db->select("T_T_T_PEMBELIAN.KET");
    $this->db->select("T_T_T_PEMBELIAN.PRINTED");
    $this->db->select("T_T_T_PEMBELIAN.INV_SUPPLIER");
    $this->db->select("T_T_T_PEMBELIAN.PAYMENT_T");
    $this->db->select("T_T_T_PEMBELIAN.COMPANY_ID_FROM");

    $this->db->select("T_T_T_PEMBELIAN.NAMA_BANK");
    $this->db->select("T_T_T_PEMBELIAN.CABANG");
    $this->db->select("T_T_T_PEMBELIAN.NOREK");
    $this->db->select("T_T_T_PEMBELIAN.ATAS_NAMA");

    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    $this->db->select("T_M_D_SUPPLIER.SUPPLIER");

    $this->db->select("T_M_D_ANGGOTA.ANGGOTA");

    $this->db->select("SUM_SUB_TOTAL");
    $this->db->select("SUM_PPN");

   


    $this->db->from('T_T_T_PEMBELIAN');


    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PEMBELIAN.PAYMENT_METHOD_ID', 'left');
    $this->db->join('T_M_D_SUPPLIER', 'T_M_D_SUPPLIER.ID = T_T_T_PEMBELIAN.SUPPLIER_ID', 'left');


    $this->db->join('T_M_D_ANGGOTA', 'T_M_D_ANGGOTA.ID = T_T_T_PEMBELIAN.ANGGOTA_ID', 'left');

    $this->db->join("(select \"PEMBELIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMBELIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PEMBELIAN_ID\") as t_sum_1", 'T_T_T_PEMBELIAN.ID = t_sum_1.PEMBELIAN_ID', 'left');

    $this->db->join("(select \"PEMBELIAN_ID\",sum(\"PPN_VALUE\")\"SUM_PPN\" from \"T_T_T_PEMBELIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PEMBELIAN_ID\") as t_sum_2", 'T_T_T_PEMBELIAN.ID = t_sum_2.PEMBELIAN_ID', 'left');


    $this->db->where("(T_T_T_PEMBELIAN.T_STATUS=0 or T_T_T_PEMBELIAN.T_STATUS=1 or T_T_T_PEMBELIAN.T_STATUS=2)");


    $date_before = date('Y-m-d',(strtotime ( '-30 day' , strtotime ( $date_pembelian) ) ));

    $this->db->where("T_T_T_PEMBELIAN.DATE<='{$date_pembelian}' and T_T_T_PEMBELIAN.DATE>='{$date_before}'");

    $this->db->where("T_T_T_PEMBELIAN.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }



  public function select_by_id($id)
  {
    $this->db->select("T_T_T_PEMBELIAN.ID");
    $this->db->select("T_T_T_PEMBELIAN.DATE");
    $this->db->select("T_T_T_PEMBELIAN.TIME");
    $this->db->select("T_T_T_PEMBELIAN.NEW_DATE");
    $this->db->select("T_T_T_PEMBELIAN.INV");
    $this->db->select("T_T_T_PEMBELIAN.INV_INT");
    $this->db->select("T_T_T_PEMBELIAN.COMPANY_ID");
    $this->db->select("T_T_T_PEMBELIAN.COMPANY_ID_FROM");
    $this->db->select("T_T_T_PEMBELIAN.PAYMENT_METHOD_ID");
    $this->db->select("T_T_T_PEMBELIAN.SUPPLIER_ID");
    $this->db->select("T_T_T_PEMBELIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMBELIAN.UPDATED_BY");
    $this->db->select("T_T_T_PEMBELIAN.MARK_FOR_DELETE");
    $this->db->select("T_T_T_PEMBELIAN.KET");
    $this->db->select("T_T_T_PEMBELIAN.PRINTED");
    $this->db->select("T_T_T_PEMBELIAN.INV_SUPPLIER");
    $this->db->select("T_T_T_PEMBELIAN.PAYMENT_T");
    $this->db->select("T_T_T_PEMBELIAN.COMPANY_ID_FROM");

    $this->db->select("T_T_T_PEMBELIAN.NAMA_BANK");
    $this->db->select("T_T_T_PEMBELIAN.CABANG");
    $this->db->select("T_T_T_PEMBELIAN.NOREK");
    $this->db->select("T_T_T_PEMBELIAN.ATAS_NAMA");

    
    $this->db->select("T_M_D_ANGGOTA.ANGGOTA");

    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    $this->db->select("T_M_D_SUPPLIER.SUPPLIER");

    $this->db->select("T_M_D_COMPANY.COMPANY");
    $this->db->select("SUM_SUB_TOTAL");

    $this->db->select("T_M_D_NO_POLISI.NO_POLISI");
    $this->db->select("T_M_D_SUPIR.SUPIR");

    $this->db->select("T_M_D_LOKASI.LOKASI");


    $this->db->from('T_T_T_PEMBELIAN');

    $this->db->join('T_M_D_COMPANY', 'T_M_D_COMPANY.ID = T_T_T_PEMBELIAN.COMPANY_ID', 'left');

    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PEMBELIAN.PAYMENT_METHOD_ID', 'left');
    $this->db->join('T_M_D_SUPPLIER', 'T_M_D_SUPPLIER.ID = T_T_T_PEMBELIAN.SUPPLIER_ID', 'left');


    $this->db->join('T_M_D_NO_POLISI', 'T_M_D_NO_POLISI.ID = T_T_T_PEMBELIAN.NO_POLISI_ID', 'left');
    $this->db->join('T_M_D_ANGGOTA', 'T_M_D_ANGGOTA.ID = T_T_T_PEMBELIAN.ANGGOTA_ID', 'left');

    $this->db->join('T_M_D_SUPIR', 'T_M_D_SUPIR.ID = T_T_T_PEMBELIAN.SUPIR_ID', 'left');

    $this->db->join('T_M_D_LOKASI', 'T_M_D_LOKASI.ID = T_T_T_PEMBELIAN.LOKASI_ID', 'left');

    
    $this->db->join("(select \"PEMBELIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMBELIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PEMBELIAN_ID\") as t_sum_1", 'T_T_T_PEMBELIAN.ID = t_sum_1.PEMBELIAN_ID', 'left');

    if($this->session->userdata('t_t_t_pembelian_delete_logic')==0)
    {
      $this->db->where('T_T_T_PEMBELIAN.MARK_FOR_DELETE',FALSE);
    }

    
    $this->db->where('T_T_T_PEMBELIAN.ID',$id);
    

    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function select_inv_int()
  {
    $this_year = date('Y-m').'-01';
    $this->db->limit(1);
    $this->db->select("INV_INT");
    $this->db->from('T_T_T_PEMBELIAN');
    $this->db->where("COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->where("DATE>='{$this_year}'");
    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }

   




  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_T_T_PEMBELIAN');
  }

  function tambah($data)
  {
        $this->db->insert('T_T_T_PEMBELIAN', $data);
        return TRUE;
  }

}


