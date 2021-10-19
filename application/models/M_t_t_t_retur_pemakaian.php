<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_t_t_retur_pemakaian extends CI_Model {
    
    
public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_T_T_RETUR_PEMAKAIAN', $data);
}







public function select_range_date($from_date,$to_date)
  {
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.ID");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.DATE");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.TIME");

    $this->db->select("T_T_T_RETUR_PEMAKAIAN.INV");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.INV_INT");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.COMPANY_ID");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.PEMAKAIAN_ID");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.CREATED_BY");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.UPDATED_BY");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.MARK_FOR_DELETE");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.KET");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.PRINTED");


    $this->db->select("T_T_T_PEMAKAIAN.INV as INV_PEMAKAIAN");


    $this->db->select("SUM_SUB_TOTAL");




    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    $this->db->select("T_M_D_PELANGGAN.PELANGGAN");
    $this->db->select("T_M_D_SALES.SALES");
    $this->db->select("T_M_A_NO_POLISI.NO_POLISI");
    $this->db->select("T_M_A_SUPIR.SUPIR");
    $this->db->select("T_M_D_LOKASI.LOKASI");





    $this->db->from('T_T_T_RETUR_PEMAKAIAN');


    $this->db->join('T_T_T_PEMAKAIAN', 'T_T_T_PEMAKAIAN.ID = T_T_T_RETUR_PEMAKAIAN.PEMAKAIAN_ID', 'left');


    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PEMAKAIAN.PAYMENT_METHOD_ID', 'left');
    $this->db->join('T_M_D_PELANGGAN', 'T_M_D_PELANGGAN.ID = T_T_T_PEMAKAIAN.PELANGGAN_ID', 'left');
    $this->db->join('T_M_D_SALES', 'T_M_D_SALES.ID = T_T_T_PEMAKAIAN.SALES_ID', 'left');

    $this->db->join('T_M_A_NO_POLISI', 'T_M_A_NO_POLISI.ID = T_T_T_PEMAKAIAN.NO_POLISI_ID', 'left');

    $this->db->join('T_M_A_SUPIR', 'T_M_A_SUPIR.ID = T_T_T_PEMAKAIAN.SUPIR_ID', 'left');

    $this->db->join('T_M_D_LOKASI', 'T_M_D_LOKASI.ID = T_T_T_PEMAKAIAN.LOKASI_ID', 'left');
    

    $this->db->join("(select \"RETUR_PEMAKAIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_RETUR_PEMAKAIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"RETUR_PEMAKAIAN_ID\") as t_sum_1", 'T_T_T_RETUR_PEMAKAIAN.ID = t_sum_1.RETUR_PEMAKAIAN_ID', 'left');

  
    if($this->session->userdata('t_t_t_retur_pemakaian_delete_logic')==0)
    {
      $this->db->where('T_T_T_RETUR_PEMAKAIAN.MARK_FOR_DELETE',FALSE);
    }

    $this->db->where("T_T_T_RETUR_PEMAKAIAN.DATE<='{$to_date}' and T_T_T_RETUR_PEMAKAIAN.DATE>='{$from_date}'");

    
    $this->db->where("T_T_T_RETUR_PEMAKAIAN.COMPANY_ID={$this->session->userdata('company_id')}");



    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function select($date_retur_pemakaian)
  {
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.ID");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.DATE");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.TIME");

    $this->db->select("T_T_T_RETUR_PEMAKAIAN.INV");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.INV_INT");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.COMPANY_ID");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.PEMAKAIAN_ID");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.CREATED_BY");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.UPDATED_BY");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.MARK_FOR_DELETE");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.KET");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.PRINTED");


    $this->db->select("T_T_T_PEMAKAIAN.INV as INV_PEMAKAIAN");


    $this->db->select("SUM_SUB_TOTAL");

   


    $this->db->from('T_T_T_RETUR_PEMAKAIAN');


    $this->db->join('T_T_T_PEMAKAIAN', 'T_T_T_PEMAKAIAN.ID = T_T_T_RETUR_PEMAKAIAN.PEMAKAIAN_ID', 'left');


    $this->db->join("(select \"RETUR_PEMAKAIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_RETUR_PEMAKAIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"RETUR_PEMAKAIAN_ID\") as t_sum_1", 'T_T_T_RETUR_PEMAKAIAN.ID = t_sum_1.RETUR_PEMAKAIAN_ID', 'left');

  
    $date_before = date('Y-m-d',(strtotime ( '-30 day' , strtotime ( $date_retur_pemakaian) ) ));

    $this->db->where("T_T_T_RETUR_PEMAKAIAN.DATE<='{$date_retur_pemakaian}' and T_T_T_RETUR_PEMAKAIAN.DATE>='{$date_before}'");

    
    $this->db->where("T_T_T_RETUR_PEMAKAIAN.COMPANY_ID={$this->session->userdata('company_id')}");



    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }







  public function select_sum_by_date($from_date,$to_date)
  {
    


    $this->db->select("SUM_SUB_TOTAL");

   


    $this->db->from('T_T_T_RETUR_PEMAKAIAN');


   

    $this->db->join("(select \"RETUR_PEMAKAIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_RETUR_PEMAKAIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"RETUR_PEMAKAIAN_ID\") as t_sum_1", 'T_T_T_RETUR_PEMAKAIAN.ID = t_sum_1.RETUR_PEMAKAIAN_ID', 'left');

  

    $this->db->where("T_T_T_RETUR_PEMAKAIAN.DATE<='{$to_date}' and T_T_T_RETUR_PEMAKAIAN.DATE>='{$from_date}'");

    
    $this->db->where("T_T_T_RETUR_PEMAKAIAN.COMPANY_ID={$this->session->userdata('company_id')}");




    $akun = $this->db->get ();
    return $akun->result ();
  }




  public function select_by_id($id)
  {
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.ID");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.DATE");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.TIME");

    $this->db->select("T_T_T_RETUR_PEMAKAIAN.INV");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.INV_INT");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.COMPANY_ID");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.PEMAKAIAN_ID");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.CREATED_BY");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.UPDATED_BY");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.MARK_FOR_DELETE");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.KET");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.PRINTED");


    $this->db->select("T_T_T_PEMAKAIAN.INV as INV_PEMAKAIAN");
    $this->db->select("T_M_D_COMPANY.COMPANY");



    $this->db->select("SUM_SUB_TOTAL");

   
    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    

    $this->db->select("T_M_D_ANGGOTA.ANGGOTA");
    $this->db->select("T_M_D_SALES.SALES");
    $this->db->select("T_M_A_NO_POLISI.NO_POLISI");
    $this->db->select("T_M_A_SUPIR.SUPIR");
    $this->db->select("T_M_D_LOKASI.LOKASI");
    $this->db->select("T_M_D_PEMAKAI.PEMAKAI");

    $this->db->from('T_T_T_RETUR_PEMAKAIAN');




    

    $this->db->join('T_T_T_PEMAKAIAN', 'T_T_T_PEMAKAIAN.ID = T_T_T_RETUR_PEMAKAIAN.PEMAKAIAN_ID', 'left');

    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PEMAKAIAN.PAYMENT_METHOD_ID', 'left');
    $this->db->join('T_M_D_SALES', 'T_M_D_SALES.ID = T_T_T_PEMAKAIAN.SALES_ID', 'left');

    $this->db->join('T_M_A_NO_POLISI', 'T_M_A_NO_POLISI.ID = T_T_T_PEMAKAIAN.NO_POLISI_ID', 'left');

    $this->db->join('T_M_A_SUPIR', 'T_M_A_SUPIR.ID = T_T_T_PEMAKAIAN.SUPIR_ID', 'left');

    $this->db->join('T_M_D_LOKASI', 'T_M_D_LOKASI.ID = T_T_T_PEMAKAIAN.LOKASI_ID', 'left');

    $this->db->join('T_M_D_ANGGOTA', 'T_M_D_ANGGOTA.ID = T_T_T_PEMAKAIAN.ANGGOTA_ID', 'left');

    $this->db->join('T_M_D_PEMAKAI', 'T_M_D_PEMAKAI.ID = T_T_T_PEMAKAIAN.PEMAKAI_ID', 'left');
    
    
    $this->db->join("(select \"RETUR_PEMAKAIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_RETUR_PEMAKAIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"RETUR_PEMAKAIAN_ID\") as t_sum_1", 'T_T_T_RETUR_PEMAKAIAN.ID = t_sum_1.RETUR_PEMAKAIAN_ID', 'left');

    
    $this->db->join('T_M_D_COMPANY', 'T_M_D_COMPANY.ID = T_T_T_RETUR_PEMAKAIAN.COMPANY_ID', 'left');
    
    $this->db->where('T_T_T_RETUR_PEMAKAIAN.ID',$id);
    $this->db->where("T_T_T_RETUR_PEMAKAIAN.COMPANY_ID={$this->session->userdata('company_id')}");


    

    $akun = $this->db->get ();
    return $akun->result ();
  }


  public function select_inv_int()
  {
    
    $date_before = date('Y-m',(strtotime ( '-30 day' , strtotime ( date('Y-m-d')) ) ));
    $this_year = $date_before.'-01';
    $this->db->limit(1);
    $this->db->select("INV_INT");
    $this->db->from('T_T_T_RETUR_PEMAKAIAN');
    $this->db->where("COMPANY_ID={$this->session->userdata('company_id')}");


    $this->db->where('MARK_FOR_DELETE',false);
    $this->db->where("DATE>='{$this_year}'");
    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }

   




  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_T_T_RETUR_PEMAKAIAN');
  }

  function tambah($data)
  {
        $this->db->insert('T_T_T_RETUR_PEMAKAIAN', $data);
        return TRUE;
  }

}


