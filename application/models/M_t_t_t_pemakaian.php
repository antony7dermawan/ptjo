<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_t_t_pemakaian extends CI_Model {
    
    
public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_T_T_PEMAKAIAN', $data);
}



public function select_inv_pemakaian()
{
    $this->db->limit(100000);
    $this->db->select("ID");
    $this->db->select("INV");
    $this->db->from('T_T_T_PEMAKAIAN');
    $this->db->where('MARK_FOR_DELETE',false);



    $this->db->order_by("ID", "desc");
    $akun = $this->db->get ();
    return $akun->result ();
}







public function select_range_date_by_no_polisi($from_date,$to_date,$no_polisi_id)
  {
    $this->db->select("T_T_T_PEMAKAIAN.ID");
    $this->db->select("T_T_T_PEMAKAIAN.DATE");
    $this->db->select("T_T_T_PEMAKAIAN.TIME");
    $this->db->select("T_T_T_PEMAKAIAN.NEW_DATE");
    $this->db->select("T_T_T_PEMAKAIAN.INV");
    $this->db->select("T_T_T_PEMAKAIAN.INV_INT");

    $this->db->select("T_T_T_PEMAKAIAN.SALES_ID");
    $this->db->select("T_T_T_PEMAKAIAN.ANGGOTA_ID");
    $this->db->select("T_T_T_PEMAKAIAN.NO_POLISI_ID");
    $this->db->select("T_T_T_PEMAKAIAN.SUPIR_ID");


    $this->db->select("T_T_T_PEMAKAIAN.COMPANY_ID");
    $this->db->select("T_T_T_PEMAKAIAN.PAYMENT_METHOD_ID");
    
    $this->db->select("T_T_T_PEMAKAIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMAKAIAN.UPDATED_BY");
    $this->db->select("T_T_T_PEMAKAIAN.MARK_FOR_DELETE");
    $this->db->select("T_T_T_PEMAKAIAN.KET");
    $this->db->select("T_T_T_PEMAKAIAN.PRINTED");
    $this->db->select("T_T_T_PEMAKAIAN.INV_HEAD");
    $this->db->select("T_T_T_PEMAKAIAN.ENABLE_EDIT");

    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    $this->db->select("T_M_D_ANGGOTA.ANGGOTA");

    $this->db->select("T_M_D_SALES.SALES");
    $this->db->select("T_M_A_NO_POLISI.NO_POLISI");
    $this->db->select("T_M_A_SUPIR.SUPIR");

    $this->db->select("T_M_D_LOKASI.LOKASI");
    $this->db->select("T_M_D_PEMAKAI.PEMAKAI");
    $this->db->select("T_M_D_DIVISI.DIVISI");


    $this->db->select("SUM_SUB_TOTAL");

   


    $this->db->from('T_T_T_PEMAKAIAN');


    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PEMAKAIAN.PAYMENT_METHOD_ID', 'left');
    
    $this->db->join('T_M_D_ANGGOTA', 'T_M_D_ANGGOTA.ID = T_T_T_PEMAKAIAN.ANGGOTA_ID', 'left');

    $this->db->join('T_M_D_SALES', 'T_M_D_SALES.ID = T_T_T_PEMAKAIAN.SALES_ID', 'left');

    $this->db->join('T_M_A_NO_POLISI', 'T_M_A_NO_POLISI.ID = T_T_T_PEMAKAIAN.NO_POLISI_ID', 'left');

    $this->db->join('T_M_A_SUPIR', 'T_M_A_SUPIR.ID = T_T_T_PEMAKAIAN.SUPIR_ID', 'left');

    $this->db->join('T_M_D_LOKASI', 'T_M_D_LOKASI.ID = T_T_T_PEMAKAIAN.LOKASI_ID', 'left');
    $this->db->join('T_M_D_PEMAKAI', 'T_M_D_PEMAKAI.ID = T_T_T_PEMAKAIAN.PEMAKAI_ID', 'left');

    $this->db->join('T_M_D_DIVISI', 'T_M_D_DIVISI.ID = T_T_T_PEMAKAIAN.DIVISI_ID', 'left');




    $this->db->join("(select \"PEMAKAIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMAKAIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PEMAKAIAN_ID\") as t_sum_1", 'T_T_T_PEMAKAIAN.ID = t_sum_1.PEMAKAIAN_ID', 'left');

    

 
    $this->db->where('T_T_T_PEMAKAIAN.MARK_FOR_DELETE',FALSE);
    

  
   
    $this->db->where('T_T_T_PEMAKAIAN.NO_POLISI_ID',$no_polisi_id);
    


 

    $this->db->where("T_T_T_PEMAKAIAN.DATE<='{$to_date}' and T_T_T_PEMAKAIAN.DATE>='{$from_date}'");


    $this->db->where("T_T_T_PEMAKAIAN.COMPANY_ID={$this->session->userdata('company_id')}");


    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }






public function select_range_date_by_anggota($from_date,$to_date,$anggota_id)
  {
    $this->db->select("T_T_T_PEMAKAIAN.ID");
    $this->db->select("T_T_T_PEMAKAIAN.DATE");
    $this->db->select("T_T_T_PEMAKAIAN.TIME");
    $this->db->select("T_T_T_PEMAKAIAN.NEW_DATE");
    $this->db->select("T_T_T_PEMAKAIAN.INV");
    $this->db->select("T_T_T_PEMAKAIAN.INV_INT");

    $this->db->select("T_T_T_PEMAKAIAN.SALES_ID");
    $this->db->select("T_T_T_PEMAKAIAN.ANGGOTA_ID");
    $this->db->select("T_T_T_PEMAKAIAN.NO_POLISI_ID");
    $this->db->select("T_T_T_PEMAKAIAN.SUPIR_ID");


    $this->db->select("T_T_T_PEMAKAIAN.COMPANY_ID");
    $this->db->select("T_T_T_PEMAKAIAN.PAYMENT_METHOD_ID");
    
    $this->db->select("T_T_T_PEMAKAIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMAKAIAN.UPDATED_BY");
    $this->db->select("T_T_T_PEMAKAIAN.MARK_FOR_DELETE");
    $this->db->select("T_T_T_PEMAKAIAN.KET");
    $this->db->select("T_T_T_PEMAKAIAN.PRINTED");
    $this->db->select("T_T_T_PEMAKAIAN.INV_HEAD");
    $this->db->select("T_T_T_PEMAKAIAN.ENABLE_EDIT");

    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    $this->db->select("T_M_D_ANGGOTA.ANGGOTA");

    $this->db->select("T_M_D_SALES.SALES");
    $this->db->select("T_M_A_NO_POLISI.NO_POLISI");
    $this->db->select("T_M_A_SUPIR.SUPIR");

    $this->db->select("T_M_D_LOKASI.LOKASI");
    $this->db->select("T_M_D_PEMAKAI.PEMAKAI");
    $this->db->select("T_M_D_DIVISI.DIVISI");


    $this->db->select("SUM_SUB_TOTAL");

   


    $this->db->from('T_T_T_PEMAKAIAN');


    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PEMAKAIAN.PAYMENT_METHOD_ID', 'left');
    
    $this->db->join('T_M_D_ANGGOTA', 'T_M_D_ANGGOTA.ID = T_T_T_PEMAKAIAN.ANGGOTA_ID', 'left');

    $this->db->join('T_M_D_SALES', 'T_M_D_SALES.ID = T_T_T_PEMAKAIAN.SALES_ID', 'left');

    $this->db->join('T_M_A_NO_POLISI', 'T_M_A_NO_POLISI.ID = T_T_T_PEMAKAIAN.NO_POLISI_ID', 'left');

    $this->db->join('T_M_A_SUPIR', 'T_M_A_SUPIR.ID = T_T_T_PEMAKAIAN.SUPIR_ID', 'left');

    $this->db->join('T_M_D_LOKASI', 'T_M_D_LOKASI.ID = T_T_T_PEMAKAIAN.LOKASI_ID', 'left');


    $this->db->join('T_M_D_PEMAKAI', 'T_M_D_PEMAKAI.ID = T_T_T_PEMAKAIAN.PEMAKAI_ID', 'left');

    $this->db->join('T_M_D_DIVISI', 'T_M_D_DIVISI.ID = T_T_T_PEMAKAIAN.DIVISI_ID', 'left');


    $this->db->join("(select \"PEMAKAIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMAKAIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PEMAKAIAN_ID\") as t_sum_1", 'T_T_T_PEMAKAIAN.ID = t_sum_1.PEMAKAIAN_ID', 'left');

    

 
    $this->db->where('T_T_T_PEMAKAIAN.MARK_FOR_DELETE',FALSE);
    

  
   
    $this->db->where('T_T_T_PEMAKAIAN.ANGGOTA_ID',$anggota_id);
    


 

    $this->db->where("T_T_T_PEMAKAIAN.DATE<='{$to_date}' and T_T_T_PEMAKAIAN.DATE>='{$from_date}'");


    $this->db->where("T_T_T_PEMAKAIAN.COMPANY_ID={$this->session->userdata('company_id')}");


    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }












public function select_range_date_by_lokasi($from_date,$to_date,$lokasi_id)
  {
    $this->db->select("T_T_T_PEMAKAIAN.ID");
    $this->db->select("T_T_T_PEMAKAIAN.DATE");
    $this->db->select("T_T_T_PEMAKAIAN.TIME");
    $this->db->select("T_T_T_PEMAKAIAN.NEW_DATE");
    $this->db->select("T_T_T_PEMAKAIAN.INV");
    $this->db->select("T_T_T_PEMAKAIAN.INV_INT");

    $this->db->select("T_T_T_PEMAKAIAN.SALES_ID");
    $this->db->select("T_T_T_PEMAKAIAN.ANGGOTA_ID");
    $this->db->select("T_T_T_PEMAKAIAN.NO_POLISI_ID");
    $this->db->select("T_T_T_PEMAKAIAN.SUPIR_ID");


    $this->db->select("T_T_T_PEMAKAIAN.COMPANY_ID");
    $this->db->select("T_T_T_PEMAKAIAN.PAYMENT_METHOD_ID");
    
    $this->db->select("T_T_T_PEMAKAIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMAKAIAN.UPDATED_BY");
    $this->db->select("T_T_T_PEMAKAIAN.MARK_FOR_DELETE");
    $this->db->select("T_T_T_PEMAKAIAN.KET");
    $this->db->select("T_T_T_PEMAKAIAN.PRINTED");
    $this->db->select("T_T_T_PEMAKAIAN.INV_HEAD");
    $this->db->select("T_T_T_PEMAKAIAN.ENABLE_EDIT");

    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    $this->db->select("T_M_D_ANGGOTA.ANGGOTA");

    $this->db->select("T_M_D_SALES.SALES");
    $this->db->select("T_M_A_NO_POLISI.NO_POLISI");
    $this->db->select("T_M_A_SUPIR.SUPIR");

    $this->db->select("T_M_D_LOKASI.LOKASI");
    $this->db->select("T_M_D_PEMAKAI.PEMAKAI");
    $this->db->select("T_M_D_DIVISI.DIVISI");


    $this->db->select("SUM_SUB_TOTAL");

   


    $this->db->from('T_T_T_PEMAKAIAN');


    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PEMAKAIAN.PAYMENT_METHOD_ID', 'left');
    
    $this->db->join('T_M_D_ANGGOTA', 'T_M_D_ANGGOTA.ID = T_T_T_PEMAKAIAN.ANGGOTA_ID', 'left');

    $this->db->join('T_M_D_SALES', 'T_M_D_SALES.ID = T_T_T_PEMAKAIAN.SALES_ID', 'left');

    $this->db->join('T_M_A_NO_POLISI', 'T_M_A_NO_POLISI.ID = T_T_T_PEMAKAIAN.NO_POLISI_ID', 'left');

    $this->db->join('T_M_A_SUPIR', 'T_M_A_SUPIR.ID = T_T_T_PEMAKAIAN.SUPIR_ID', 'left');

    $this->db->join('T_M_D_LOKASI', 'T_M_D_LOKASI.ID = T_T_T_PEMAKAIAN.LOKASI_ID', 'left');


    $this->db->join('T_M_D_PEMAKAI', 'T_M_D_PEMAKAI.ID = T_T_T_PEMAKAIAN.PEMAKAI_ID', 'left');

    $this->db->join('T_M_D_DIVISI', 'T_M_D_DIVISI.ID = T_T_T_PEMAKAIAN.DIVISI_ID', 'left');


    $this->db->join("(select \"PEMAKAIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMAKAIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PEMAKAIAN_ID\") as t_sum_1", 'T_T_T_PEMAKAIAN.ID = t_sum_1.PEMAKAIAN_ID', 'left');

    

 
    $this->db->where('T_T_T_PEMAKAIAN.MARK_FOR_DELETE',FALSE);
    

  
   
    $this->db->where('T_T_T_PEMAKAIAN.LOKASI_ID',$lokasi_id);
    


 

    $this->db->where("T_T_T_PEMAKAIAN.DATE<='{$to_date}' and T_T_T_PEMAKAIAN.DATE>='{$from_date}'");


    $this->db->where("T_T_T_PEMAKAIAN.COMPANY_ID={$this->session->userdata('company_id')}");


    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }




public function select_range_date_by_pemakai($from_date,$to_date,$pemakai_id)
  {
    $this->db->select("T_T_T_PEMAKAIAN.ID");
    $this->db->select("T_T_T_PEMAKAIAN.DATE");
    $this->db->select("T_T_T_PEMAKAIAN.TIME");
    $this->db->select("T_T_T_PEMAKAIAN.NEW_DATE");
    $this->db->select("T_T_T_PEMAKAIAN.INV");
    $this->db->select("T_T_T_PEMAKAIAN.INV_INT");

    $this->db->select("T_T_T_PEMAKAIAN.SALES_ID");
    $this->db->select("T_T_T_PEMAKAIAN.ANGGOTA_ID");
    $this->db->select("T_T_T_PEMAKAIAN.NO_POLISI_ID");
    $this->db->select("T_T_T_PEMAKAIAN.SUPIR_ID");


    $this->db->select("T_T_T_PEMAKAIAN.COMPANY_ID");
    $this->db->select("T_T_T_PEMAKAIAN.PAYMENT_METHOD_ID");
    
    $this->db->select("T_T_T_PEMAKAIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMAKAIAN.UPDATED_BY");
    $this->db->select("T_T_T_PEMAKAIAN.MARK_FOR_DELETE");
    $this->db->select("T_T_T_PEMAKAIAN.KET");
    $this->db->select("T_T_T_PEMAKAIAN.PRINTED");
    $this->db->select("T_T_T_PEMAKAIAN.INV_HEAD");
    $this->db->select("T_T_T_PEMAKAIAN.ENABLE_EDIT");

    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    $this->db->select("T_M_D_ANGGOTA.ANGGOTA");

    $this->db->select("T_M_D_SALES.SALES");
    $this->db->select("T_M_A_NO_POLISI.NO_POLISI");
    $this->db->select("T_M_A_SUPIR.SUPIR");

    $this->db->select("T_M_D_LOKASI.LOKASI");
    $this->db->select("T_M_D_PEMAKAI.PEMAKAI");
    $this->db->select("T_M_D_DIVISI.DIVISI");


    $this->db->select("SUM_SUB_TOTAL");

   


    $this->db->from('T_T_T_PEMAKAIAN');


    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PEMAKAIAN.PAYMENT_METHOD_ID', 'left');
    
    $this->db->join('T_M_D_ANGGOTA', 'T_M_D_ANGGOTA.ID = T_T_T_PEMAKAIAN.ANGGOTA_ID', 'left');

    $this->db->join('T_M_D_SALES', 'T_M_D_SALES.ID = T_T_T_PEMAKAIAN.SALES_ID', 'left');

    $this->db->join('T_M_A_NO_POLISI', 'T_M_A_NO_POLISI.ID = T_T_T_PEMAKAIAN.NO_POLISI_ID', 'left');

    $this->db->join('T_M_A_SUPIR', 'T_M_A_SUPIR.ID = T_T_T_PEMAKAIAN.SUPIR_ID', 'left');

    $this->db->join('T_M_D_LOKASI', 'T_M_D_LOKASI.ID = T_T_T_PEMAKAIAN.LOKASI_ID', 'left');


    $this->db->join('T_M_D_PEMAKAI', 'T_M_D_PEMAKAI.ID = T_T_T_PEMAKAIAN.PEMAKAI_ID', 'left');

    $this->db->join('T_M_D_DIVISI', 'T_M_D_DIVISI.ID = T_T_T_PEMAKAIAN.DIVISI_ID', 'left');


    $this->db->join("(select \"PEMAKAIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMAKAIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PEMAKAIAN_ID\") as t_sum_1", 'T_T_T_PEMAKAIAN.ID = t_sum_1.PEMAKAIAN_ID', 'left');

    

 
    $this->db->where('T_T_T_PEMAKAIAN.MARK_FOR_DELETE',FALSE);
    

  
   
    $this->db->where('T_T_T_PEMAKAIAN.PEMAKAI_ID',$pemakai_id);
    


 

    $this->db->where("T_T_T_PEMAKAIAN.DATE<='{$to_date}' and T_T_T_PEMAKAIAN.DATE>='{$from_date}'");


    $this->db->where("T_T_T_PEMAKAIAN.COMPANY_ID={$this->session->userdata('company_id')}");


    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }





public function select_date($pelanggan_id,$from_date,$to_date)
  {
    $this->db->select("T_T_T_PEMAKAIAN.ID");
    $this->db->select("T_T_T_PEMAKAIAN.DATE");
    $this->db->select("T_T_T_PEMAKAIAN.TIME");
    $this->db->select("T_T_T_PEMAKAIAN.NEW_DATE");
    $this->db->select("T_T_T_PEMAKAIAN.INV");
    $this->db->select("T_T_T_PEMAKAIAN.INV_INT");

    $this->db->select("T_T_T_PEMAKAIAN.SALES_ID");
    $this->db->select("T_T_T_PEMAKAIAN.PELANGGAN_ID");
    $this->db->select("T_T_T_PEMAKAIAN.NO_POLISI_ID");
    $this->db->select("T_T_T_PEMAKAIAN.SUPIR_ID");


    $this->db->select("T_T_T_PEMAKAIAN.COMPANY_ID");
    $this->db->select("T_T_T_PEMAKAIAN.PAYMENT_METHOD_ID");

    $this->db->select("T_T_T_PEMAKAIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMAKAIAN.UPDATED_BY");
    $this->db->select("T_T_T_PEMAKAIAN.MARK_FOR_DELETE");
    $this->db->select("T_T_T_PEMAKAIAN.KET");
    $this->db->select("T_T_T_PEMAKAIAN.PRINTED");
    $this->db->select("T_T_T_PEMAKAIAN.INV_HEAD");
    $this->db->select("T_T_T_PEMAKAIAN.ENABLE_EDIT");

    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    $this->db->select("T_M_D_PELANGGAN.PELANGGAN");

    $this->db->select("T_M_D_SALES.SALES");
    $this->db->select("T_M_A_NO_POLISI.NO_POLISI");
    $this->db->select("T_M_A_SUPIR.SUPIR");

    $this->db->select("T_M_D_LOKASI.LOKASI");
    $this->db->select("T_M_D_ANGGOTA.ANGGOTA");
    $this->db->select("T_M_D_PEMAKAI.PEMAKAI");
    $this->db->select("T_M_D_DIVISI.DIVISI");


    $this->db->select("SUM_SUB_TOTAL");

   


    $this->db->from('T_T_T_PEMAKAIAN');


    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PEMAKAIAN.PAYMENT_METHOD_ID', 'left');

    $this->db->join('T_M_D_ANGGOTA', 'T_M_D_ANGGOTA.ID = T_T_T_PEMAKAIAN.ANGGOTA_ID', 'left');
    
    $this->db->join('T_M_D_SALES', 'T_M_D_SALES.ID = T_T_T_PEMAKAIAN.SALES_ID', 'left');

    $this->db->join('T_M_A_NO_POLISI', 'T_M_A_NO_POLISI.ID = T_T_T_PEMAKAIAN.NO_POLISI_ID', 'left');

    $this->db->join('T_M_A_SUPIR', 'T_M_A_SUPIR.ID = T_T_T_PEMAKAIAN.SUPIR_ID', 'left');

    $this->db->join('T_M_D_LOKASI', 'T_M_D_LOKASI.ID = T_T_T_PEMAKAIAN.LOKASI_ID', 'left');


    $this->db->join('T_M_D_PEMAKAI', 'T_M_D_PEMAKAI.ID = T_T_T_PEMAKAIAN.PEMAKAI_ID', 'left');

    $this->db->join('T_M_D_DIVISI', 'T_M_D_DIVISI.ID = T_T_T_PEMAKAIAN.DIVISI_ID', 'left');


    $this->db->join("(select \"PEMAKAIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMAKAIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PEMAKAIAN_ID\") as t_sum_1", 'T_T_T_PEMAKAIAN.ID = t_sum_1.PEMAKAIAN_ID', 'left');

    


    $this->db->where('T_T_T_PEMAKAIAN.MARK_FOR_DELETE',FALSE);
    

    $this->db->where('T_T_T_PEMAKAIAN.PELANGGAN_ID',$pelanggan_id);
    
    $this->db->where('T_T_T_PEMAKAIAN.ENABLE_EDIT',1);


 

    $this->db->where("T_T_T_PEMAKAIAN.DATE<='{$to_date}' and T_T_T_PEMAKAIAN.DATE>='{$from_date}'");


    $this->db->where("T_T_T_PEMAKAIAN.COMPANY_ID={$this->session->userdata('company_id')}");


    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }


public function select_range_date($from_date,$to_date,$kredit_logic,$sales_id,$pelanggan_id)
  {
    $this->db->select("T_T_T_PEMAKAIAN.ID");
    $this->db->select("T_T_T_PEMAKAIAN.DATE");
    $this->db->select("T_T_T_PEMAKAIAN.TIME");
    $this->db->select("T_T_T_PEMAKAIAN.NEW_DATE");
    $this->db->select("T_T_T_PEMAKAIAN.INV");
    $this->db->select("T_T_T_PEMAKAIAN.INV_INT");

    $this->db->select("T_T_T_PEMAKAIAN.SALES_ID");
    $this->db->select("T_T_T_PEMAKAIAN.PELANGGAN_ID");
    $this->db->select("T_T_T_PEMAKAIAN.NO_POLISI_ID");
    $this->db->select("T_T_T_PEMAKAIAN.SUPIR_ID");


    $this->db->select("T_T_T_PEMAKAIAN.COMPANY_ID");
    $this->db->select("T_T_T_PEMAKAIAN.PAYMENT_METHOD_ID");
    
    $this->db->select("T_T_T_PEMAKAIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMAKAIAN.UPDATED_BY");
    $this->db->select("T_T_T_PEMAKAIAN.MARK_FOR_DELETE");
    $this->db->select("T_T_T_PEMAKAIAN.KET");
    $this->db->select("T_T_T_PEMAKAIAN.PRINTED");
    $this->db->select("T_T_T_PEMAKAIAN.INV_HEAD");
    $this->db->select("T_T_T_PEMAKAIAN.ENABLE_EDIT");

    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    $this->db->select("T_M_D_PELANGGAN.PELANGGAN");

    $this->db->select("T_M_D_SALES.SALES");
    $this->db->select("T_M_A_NO_POLISI.NO_POLISI");
    $this->db->select("T_M_A_SUPIR.SUPIR");

    $this->db->select("T_M_D_LOKASI.LOKASI");
    $this->db->select("T_M_D_ANGGOTA.ANGGOTA");
    $this->db->select("T_M_D_PEMAKAI.PEMAKAI");
    $this->db->select("T_M_D_DIVISI.DIVISI");


    $this->db->select("SUM_SUB_TOTAL");

   


    $this->db->from('T_T_T_PEMAKAIAN');


    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PEMAKAIAN.PAYMENT_METHOD_ID', 'left');


    $this->db->join('T_M_D_ANGGOTA', 'T_M_D_ANGGOTA.ID = T_T_T_PEMAKAIAN.ANGGOTA_ID', 'left');


    $this->db->join('T_M_D_SALES', 'T_M_D_SALES.ID = T_T_T_PEMAKAIAN.SALES_ID', 'left');

    $this->db->join('T_M_A_NO_POLISI', 'T_M_A_NO_POLISI.ID = T_T_T_PEMAKAIAN.NO_POLISI_ID', 'left');

    $this->db->join('T_M_A_SUPIR', 'T_M_A_SUPIR.ID = T_T_T_PEMAKAIAN.SUPIR_ID', 'left');

    $this->db->join('T_M_D_LOKASI', 'T_M_D_LOKASI.ID = T_T_T_PEMAKAIAN.LOKASI_ID', 'left');


    $this->db->join('T_M_D_PEMAKAI', 'T_M_D_PEMAKAI.ID = T_T_T_PEMAKAIAN.PEMAKAI_ID', 'left');
    
    $this->db->join('T_M_D_DIVISI', 'T_M_D_DIVISI.ID = T_T_T_PEMAKAIAN.DIVISI_ID', 'left');


    $this->db->join("(select \"PEMAKAIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMAKAIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PEMAKAIAN_ID\") as t_sum_1", 'T_T_T_PEMAKAIAN.ID = t_sum_1.PEMAKAIAN_ID', 'left');

    

    if($this->session->userdata('t_t_t_pemakaian_delete_logic')==0)
    {
      $this->db->where('T_T_T_PEMAKAIAN.MARK_FOR_DELETE',FALSE);
    }

    if($kredit_logic==1)
    {
        $this->db->where('T_T_T_PEMAKAIAN.PAYMENT_METHOD_ID',2);
    }

    if($sales_id!=0)
    {
        $this->db->where('T_T_T_PEMAKAIAN.SALES_ID',$sales_id);
    }

    if($pelanggan_id!=0)
    {
        $this->db->where('T_T_T_PEMAKAIAN.PELANGGAN_ID',$pelanggan_id);
    }


 

    $this->db->where("T_T_T_PEMAKAIAN.DATE<='{$to_date}' and T_T_T_PEMAKAIAN.DATE>='{$from_date}'");


    $this->db->where("T_T_T_PEMAKAIAN.COMPANY_ID={$this->session->userdata('company_id')}");


    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }




  public function select($date_pemakaian)
  {
    $this->db->select("T_T_T_PEMAKAIAN.ID");
    $this->db->select("T_T_T_PEMAKAIAN.DATE");
    $this->db->select("T_T_T_PEMAKAIAN.TIME");
    $this->db->select("T_T_T_PEMAKAIAN.NEW_DATE");
    $this->db->select("T_T_T_PEMAKAIAN.INV");
    $this->db->select("T_T_T_PEMAKAIAN.INV_INT");

    $this->db->select("T_T_T_PEMAKAIAN.SALES_ID");
    $this->db->select("T_T_T_PEMAKAIAN.ANGGOTA_ID");
    $this->db->select("T_T_T_PEMAKAIAN.NO_POLISI_ID");
    $this->db->select("T_T_T_PEMAKAIAN.SUPIR_ID");


    $this->db->select("T_T_T_PEMAKAIAN.COMPANY_ID");
    $this->db->select("T_T_T_PEMAKAIAN.PAYMENT_METHOD_ID");

    $this->db->select("T_T_T_PEMAKAIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMAKAIAN.UPDATED_BY");
    $this->db->select("T_T_T_PEMAKAIAN.MARK_FOR_DELETE");
    $this->db->select("T_T_T_PEMAKAIAN.KET");
    $this->db->select("T_T_T_PEMAKAIAN.PRINTED");
    $this->db->select("T_T_T_PEMAKAIAN.INV_HEAD");

    $this->db->select("T_T_T_PEMAKAIAN.ENABLE_EDIT");


    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    $this->db->select("T_M_D_ANGGOTA.ANGGOTA");

    $this->db->select("T_M_D_SALES.SALES");
    $this->db->select("T_M_A_NO_POLISI.NO_POLISI");
    $this->db->select("T_M_A_SUPIR.SUPIR");


    $this->db->select("T_M_D_LOKASI.LOKASI");
    $this->db->select("T_M_D_PEMAKAI.PEMAKAI");
    $this->db->select("T_M_D_DIVISI.DIVISI");


    $this->db->select("SUM_SUB_TOTAL");

   


    $this->db->from('T_T_T_PEMAKAIAN');


    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PEMAKAIAN.PAYMENT_METHOD_ID', 'left');
    
    $this->db->join('T_M_D_SALES', 'T_M_D_SALES.ID = T_T_T_PEMAKAIAN.SALES_ID', 'left');

    $this->db->join('T_M_A_NO_POLISI', 'T_M_A_NO_POLISI.ID = T_T_T_PEMAKAIAN.NO_POLISI_ID', 'left');

    $this->db->join('T_M_A_SUPIR', 'T_M_A_SUPIR.ID = T_T_T_PEMAKAIAN.SUPIR_ID', 'left');

    $this->db->join('T_M_D_LOKASI', 'T_M_D_LOKASI.ID = T_T_T_PEMAKAIAN.LOKASI_ID', 'left');



    $this->db->join('T_M_D_ANGGOTA', 'T_M_D_ANGGOTA.ID = T_T_T_PEMAKAIAN.ANGGOTA_ID', 'left');

    $this->db->join('T_M_D_PEMAKAI', 'T_M_D_PEMAKAI.ID = T_T_T_PEMAKAIAN.PEMAKAI_ID', 'left');
    
    $this->db->join('T_M_D_DIVISI', 'T_M_D_DIVISI.ID = T_T_T_PEMAKAIAN.DIVISI_ID', 'left');


    $this->db->join("(select \"PEMAKAIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMAKAIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PEMAKAIAN_ID\") as t_sum_1", 'T_T_T_PEMAKAIAN.ID = t_sum_1.PEMAKAIAN_ID', 'left');

    

    $date_before = date('Y-m-d',(strtotime ( '-30 day' , strtotime ( $date_pemakaian) ) ));

    $this->db->where("T_T_T_PEMAKAIAN.DATE<='{$date_pemakaian}' and T_T_T_PEMAKAIAN.DATE>='{$date_before}'");

    $this->db->where("T_T_T_PEMAKAIAN.COMPANY_ID={$this->session->userdata('company_id')}");



    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }














  public function select_dashboard($date_pemakaian)
  {
    $this->db->select("T_T_T_PEMAKAIAN.ID");
    $this->db->select("T_T_T_PEMAKAIAN.DATE");
    $this->db->select("T_T_T_PEMAKAIAN.TIME");
    $this->db->select("T_T_T_PEMAKAIAN.NEW_DATE");
    $this->db->select("T_T_T_PEMAKAIAN.INV");
    $this->db->select("T_T_T_PEMAKAIAN.INV_INT");

    $this->db->select("T_T_T_PEMAKAIAN.SALES_ID");
    $this->db->select("T_T_T_PEMAKAIAN.ANGGOTA_ID");
    $this->db->select("T_T_T_PEMAKAIAN.NO_POLISI_ID");
    $this->db->select("T_T_T_PEMAKAIAN.SUPIR_ID");


    $this->db->select("T_T_T_PEMAKAIAN.COMPANY_ID");
    $this->db->select("T_T_T_PEMAKAIAN.PAYMENT_METHOD_ID");

    $this->db->select("T_T_T_PEMAKAIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMAKAIAN.UPDATED_BY");
    $this->db->select("T_T_T_PEMAKAIAN.MARK_FOR_DELETE");
    $this->db->select("T_T_T_PEMAKAIAN.KET");
    $this->db->select("T_T_T_PEMAKAIAN.PRINTED");
    $this->db->select("T_T_T_PEMAKAIAN.INV_HEAD");

    $this->db->select("T_T_T_PEMAKAIAN.ENABLE_EDIT");


    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    $this->db->select("T_M_D_ANGGOTA.ANGGOTA");

    $this->db->select("T_M_D_SALES.SALES");
    $this->db->select("T_M_A_NO_POLISI.NO_POLISI");
    $this->db->select("T_M_A_SUPIR.SUPIR");


    $this->db->select("T_M_D_LOKASI.LOKASI");
    $this->db->select("T_M_D_PEMAKAI.PEMAKAI");
    $this->db->select("T_M_D_DIVISI.DIVISI");


    $this->db->select("SUM_SUB_TOTAL");

   


    $this->db->from('T_T_T_PEMAKAIAN');


    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PEMAKAIAN.PAYMENT_METHOD_ID', 'left');
    
    $this->db->join('T_M_D_SALES', 'T_M_D_SALES.ID = T_T_T_PEMAKAIAN.SALES_ID', 'left');

    $this->db->join('T_M_A_NO_POLISI', 'T_M_A_NO_POLISI.ID = T_T_T_PEMAKAIAN.NO_POLISI_ID', 'left');

    $this->db->join('T_M_A_SUPIR', 'T_M_A_SUPIR.ID = T_T_T_PEMAKAIAN.SUPIR_ID', 'left');

    $this->db->join('T_M_D_LOKASI', 'T_M_D_LOKASI.ID = T_T_T_PEMAKAIAN.LOKASI_ID', 'left');



    $this->db->join('T_M_D_ANGGOTA', 'T_M_D_ANGGOTA.ID = T_T_T_PEMAKAIAN.ANGGOTA_ID', 'left');

    $this->db->join('T_M_D_PEMAKAI', 'T_M_D_PEMAKAI.ID = T_T_T_PEMAKAIAN.PEMAKAI_ID', 'left');

    $this->db->join('T_M_D_DIVISI', 'T_M_D_DIVISI.ID = T_T_T_PEMAKAIAN.DIVISI_ID', 'left');
    
    $this->db->join("(select \"PEMAKAIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMAKAIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PEMAKAIAN_ID\") as t_sum_1", 'T_T_T_PEMAKAIAN.ID = t_sum_1.PEMAKAIAN_ID', 'left');

    

  
    $this->db->where("T_T_T_PEMAKAIAN.DATE='{$date_pemakaian}'");
    $this->db->where("T_T_T_PEMAKAIAN.MARK_FOR_DELETE=false");




    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }








  public function select_by_id($id)
  {
    $this->db->select("T_T_T_PEMAKAIAN.ID");
    $this->db->select("T_T_T_PEMAKAIAN.DATE");
    $this->db->select("T_T_T_PEMAKAIAN.TIME");
    $this->db->select("T_T_T_PEMAKAIAN.NEW_DATE");
    $this->db->select("T_T_T_PEMAKAIAN.INV");
    $this->db->select("T_T_T_PEMAKAIAN.INV_INT");

    $this->db->select("T_T_T_PEMAKAIAN.SALES_ID");
    $this->db->select("T_T_T_PEMAKAIAN.ANGGOTA_ID");
    $this->db->select("T_T_T_PEMAKAIAN.NO_POLISI_ID");
    $this->db->select("T_T_T_PEMAKAIAN.SUPIR_ID");


    $this->db->select("T_T_T_PEMAKAIAN.COMPANY_ID");
    $this->db->select("T_T_T_PEMAKAIAN.PAYMENT_METHOD_ID");

    $this->db->select("T_T_T_PEMAKAIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMAKAIAN.UPDATED_BY");
    $this->db->select("T_T_T_PEMAKAIAN.MARK_FOR_DELETE");
    $this->db->select("T_T_T_PEMAKAIAN.KET");
    $this->db->select("T_T_T_PEMAKAIAN.PRINTED");
    $this->db->select("T_T_T_PEMAKAIAN.INV_HEAD");
    $this->db->select("T_T_T_PEMAKAIAN.ENABLE_EDIT");

    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    $this->db->select("T_M_D_ANGGOTA.ANGGOTA");

    $this->db->select("T_M_D_SALES.SALES");
    $this->db->select("T_M_A_NO_POLISI.NO_POLISI");
    $this->db->select("T_M_A_SUPIR.SUPIR");
    $this->db->select("T_M_D_COMPANY.COMPANY");


    $this->db->select("T_M_D_LOKASI.LOKASI");
    $this->db->select("T_M_D_PEMAKAI.PEMAKAI");
    $this->db->select("T_M_D_DIVISI.DIVISI");

    $this->db->select("SUM_SUB_TOTAL");

   


    $this->db->from('T_T_T_PEMAKAIAN');


    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PEMAKAIAN.PAYMENT_METHOD_ID', 'left');
    $this->db->join('T_M_D_ANGGOTA', 'T_M_D_ANGGOTA.ID = T_T_T_PEMAKAIAN.ANGGOTA_ID', 'left');
    $this->db->join('T_M_D_SALES', 'T_M_D_SALES.ID = T_T_T_PEMAKAIAN.SALES_ID', 'left');

    $this->db->join('T_M_A_NO_POLISI', 'T_M_A_NO_POLISI.ID = T_T_T_PEMAKAIAN.NO_POLISI_ID', 'left');

    $this->db->join('T_M_D_COMPANY', 'T_M_D_COMPANY.ID = T_T_T_PEMAKAIAN.COMPANY_ID', 'left');

    $this->db->join('T_M_A_SUPIR', 'T_M_A_SUPIR.ID = T_T_T_PEMAKAIAN.SUPIR_ID', 'left');

    $this->db->join('T_M_D_LOKASI', 'T_M_D_LOKASI.ID = T_T_T_PEMAKAIAN.LOKASI_ID', 'left');
    $this->db->join('T_M_D_PEMAKAI', 'T_M_D_PEMAKAI.ID = T_T_T_PEMAKAIAN.PEMAKAI_ID', 'left');


    $this->db->join('T_M_D_DIVISI', 'T_M_D_DIVISI.ID = T_T_T_PEMAKAIAN.DIVISI_ID', 'left');
    

    $this->db->join("(select \"PEMAKAIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMAKAIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PEMAKAIAN_ID\") as t_sum_1", 'T_T_T_PEMAKAIAN.ID = t_sum_1.PEMAKAIAN_ID', 'left');

    
    if($this->session->userdata('t_t_t_pemakaian_delete_logic')==0)
    {
      $this->db->where('T_T_T_PEMAKAIAN.MARK_FOR_DELETE',FALSE);
    }

    
    $this->db->where('T_T_T_PEMAKAIAN.ID',$id);

    

    $akun = $this->db->get ();
    return $akun->result ();
  }


  public function select_inv_int()
  {
    $date_before = date('Y-m',(strtotime ( '-30 day' , strtotime ( date('Y-m-d')) ) ));
    $this_year = $date_before.'-01';

    $this->db->limit(1);
    $this->db->select("INV_INT");
    $this->db->from('T_T_T_PEMAKAIAN');
    $this->db->where("COMPANY_ID={$this->session->userdata('company_id')}");


    
    $this->db->where("DATE>='{$this_year}'");
    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }

   




  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_T_T_PEMAKAIAN');
  }

  function tambah($data)
  {
        $this->db->insert('T_T_T_PEMAKAIAN', $data);
        return TRUE;
  }

}


