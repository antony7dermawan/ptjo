<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_t_t_penjualan_jasa extends CI_Model {
    
    
public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_T_T_PENJUALAN_JASA', $data);
}



public function select_inv_penjualan_jasa()
{
    $this->db->limit(100000);
    $this->db->select("ID");
    $this->db->select("INV");
    $this->db->from('T_T_T_PENJUALAN_JASA');
    $this->db->where('MARK_FOR_DELETE',false);
    $this->db->order_by("ID", "desc");
    $akun = $this->db->get ();
    return $akun->result ();
}





public function select_date($pelanggan_id,$from_date,$to_date)
  {
    $this->db->select("T_T_T_PENJUALAN_JASA.ID");
    $this->db->select("T_T_T_PENJUALAN_JASA.DATE");
    $this->db->select("T_T_T_PENJUALAN_JASA.TIME");
    $this->db->select("T_T_T_PENJUALAN_JASA.NEW_DATE");
    $this->db->select("T_T_T_PENJUALAN_JASA.INV");
    $this->db->select("T_T_T_PENJUALAN_JASA.INV_INT");

    $this->db->select("T_T_T_PENJUALAN_JASA.PELANGGAN_ID");
   


    $this->db->select("T_T_T_PENJUALAN_JASA.COMPANY_ID");
    $this->db->select("T_T_T_PENJUALAN_JASA.PAYMENT_METHOD_ID");

    $this->db->select("T_T_T_PENJUALAN_JASA.CREATED_BY");
    $this->db->select("T_T_T_PENJUALAN_JASA.UPDATED_BY");
    $this->db->select("T_T_T_PENJUALAN_JASA.MARK_FOR_DELETE");
    $this->db->select("T_T_T_PENJUALAN_JASA.KET");
    $this->db->select("T_T_T_PENJUALAN_JASA.PRINTED");
    $this->db->select("T_T_T_PENJUALAN_JASA.INV_HEAD");
    $this->db->select("T_T_T_PENJUALAN_JASA.ENABLE_EDIT");

    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    $this->db->select("T_M_D_PELANGGAN.PELANGGAN");



    $this->db->select("SUM_SUB_TOTAL");

   


    $this->db->from('T_T_T_PENJUALAN_JASA');


    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PENJUALAN_JASA.PAYMENT_METHOD_ID', 'left');
    $this->db->join('T_M_D_PELANGGAN', 'T_M_D_PELANGGAN.ID = T_T_T_PENJUALAN_JASA.PELANGGAN_ID', 'left');
   



    $this->db->join("(select \"PENJUALAN_JASA_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PENJUALAN_JASA_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PENJUALAN_JASA_ID\") as t_sum_1", 'T_T_T_PENJUALAN_JASA.ID = t_sum_1.PENJUALAN_JASA_ID', 'left');

    


    $this->db->where('T_T_T_PENJUALAN_JASA.MARK_FOR_DELETE',FALSE);
    

    $this->db->where('T_T_T_PENJUALAN_JASA.PELANGGAN_ID',$pelanggan_id);
    
    $this->db->where('T_T_T_PENJUALAN_JASA.ENABLE_EDIT',1);


 

    $this->db->where("T_T_T_PENJUALAN_JASA.DATE<='{$to_date}' and T_T_T_PENJUALAN_JASA.DATE>='{$from_date}'");


    $this->db->where("T_T_T_PENJUALAN_JASA.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }


public function select_range_date($from_date,$to_date,$kredit_logic,$sales_id,$pelanggan_id)
  {
    $this->db->select("T_T_T_PENJUALAN_JASA.ID");
    $this->db->select("T_T_T_PENJUALAN_JASA.DATE");
    $this->db->select("T_T_T_PENJUALAN_JASA.TIME");
    $this->db->select("T_T_T_PENJUALAN_JASA.NEW_DATE");
    $this->db->select("T_T_T_PENJUALAN_JASA.INV");
    $this->db->select("T_T_T_PENJUALAN_JASA.INV_INT");

    $this->db->select("T_T_T_PENJUALAN_JASA.SALES_ID");
    $this->db->select("T_T_T_PENJUALAN_JASA.PELANGGAN_ID");
    $this->db->select("T_T_T_PENJUALAN_JASA.NO_POLISI_ID");
    $this->db->select("T_T_T_PENJUALAN_JASA.SUPIR_ID");


    $this->db->select("T_T_T_PENJUALAN_JASA.COMPANY_ID");
    $this->db->select("T_T_T_PENJUALAN_JASA.PAYMENT_METHOD_ID");
    
    $this->db->select("T_T_T_PENJUALAN_JASA.CREATED_BY");
    $this->db->select("T_T_T_PENJUALAN_JASA.UPDATED_BY");
    $this->db->select("T_T_T_PENJUALAN_JASA.MARK_FOR_DELETE");
    $this->db->select("T_T_T_PENJUALAN_JASA.KET");
    $this->db->select("T_T_T_PENJUALAN_JASA.PRINTED");
    $this->db->select("T_T_T_PENJUALAN_JASA.INV_HEAD");
    $this->db->select("T_T_T_PENJUALAN_JASA.ENABLE_EDIT");

    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    $this->db->select("T_M_D_PELANGGAN.PELANGGAN");

    $this->db->select("T_M_D_SALES.SALES");
    $this->db->select("T_M_A_NO_POLISI.NO_POLISI");
    $this->db->select("T_M_A_SUPIR.SUPIR");

    $this->db->select("T_M_D_LOKASI.LOKASI");


    $this->db->select("SUM_SUB_TOTAL");

   


    $this->db->from('T_T_T_PENJUALAN_JASA');


    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PENJUALAN_JASA.PAYMENT_METHOD_ID', 'left');
    $this->db->join('T_M_D_PELANGGAN', 'T_M_D_PELANGGAN.ID = T_T_T_PENJUALAN_JASA.PELANGGAN_ID', 'left');
    $this->db->join('T_M_D_SALES', 'T_M_D_SALES.ID = T_T_T_PENJUALAN_JASA.SALES_ID', 'left');

    $this->db->join('T_M_A_NO_POLISI', 'T_M_A_NO_POLISI.ID = T_T_T_PENJUALAN_JASA.NO_POLISI_ID', 'left');

    $this->db->join('T_M_A_SUPIR', 'T_M_A_SUPIR.ID = T_T_T_PENJUALAN_JASA.SUPIR_ID', 'left');

    $this->db->join('T_M_D_LOKASI', 'T_M_D_LOKASI.ID = T_T_T_PENJUALAN_JASA.LOKASI_ID', 'left');




    $this->db->join("(select \"PENJUALAN_JASA_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PENJUALAN_JASA_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PENJUALAN_JASA_ID\") as t_sum_1", 'T_T_T_PENJUALAN_JASA.ID = t_sum_1.PENJUALAN_JASA_ID', 'left');

    

    if($this->session->userdata('t_t_t_penjualan_jasa_delete_logic')==0)
    {
      $this->db->where('T_T_T_PENJUALAN_JASA.MARK_FOR_DELETE',FALSE);
    }

    if($kredit_logic==1)
    {
        $this->db->where('T_T_T_PENJUALAN_JASA.PAYMENT_METHOD_ID',2);
    }

    if($sales_id!=0)
    {
        $this->db->where('T_T_T_PENJUALAN_JASA.SALES_ID',$sales_id);
    }

    if($pelanggan_id!=0)
    {
        $this->db->where('T_T_T_PENJUALAN_JASA.PELANGGAN_ID',$pelanggan_id);
    }


 

    $this->db->where("T_T_T_PENJUALAN_JASA.DATE<='{$to_date}' and T_T_T_PENJUALAN_JASA.DATE>='{$from_date}'");


    $this->db->where("T_T_T_PENJUALAN_JASA.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }




  public function select($date_penjualan_jasa)
  {
    $this->db->select("T_T_T_PENJUALAN_JASA.ID");
    $this->db->select("T_T_T_PENJUALAN_JASA.DATE");
    $this->db->select("T_T_T_PENJUALAN_JASA.TIME");
    $this->db->select("T_T_T_PENJUALAN_JASA.NEW_DATE");
    $this->db->select("T_T_T_PENJUALAN_JASA.INV");
    $this->db->select("T_T_T_PENJUALAN_JASA.INV_INT");

    $this->db->select("T_T_T_PENJUALAN_JASA.PELANGGAN_ID");


    $this->db->select("T_T_T_PENJUALAN_JASA.COMPANY_ID");
    $this->db->select("T_T_T_PENJUALAN_JASA.PAYMENT_METHOD_ID");

    $this->db->select("T_T_T_PENJUALAN_JASA.CREATED_BY");
    $this->db->select("T_T_T_PENJUALAN_JASA.UPDATED_BY");
    $this->db->select("T_T_T_PENJUALAN_JASA.MARK_FOR_DELETE");
    $this->db->select("T_T_T_PENJUALAN_JASA.KET");
    $this->db->select("T_T_T_PENJUALAN_JASA.PRINTED");
    $this->db->select("T_T_T_PENJUALAN_JASA.INV_HEAD");

    $this->db->select("T_T_T_PENJUALAN_JASA.ENABLE_EDIT");


    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    $this->db->select("T_M_D_PELANGGAN.PELANGGAN");

    $this->db->select("T_T_T_PENJUALAN_JASA.NO_FAKTUR_PAJAK");
    $this->db->select("T_T_T_PENJUALAN_JASA.BLOK");
    $this->db->select("T_T_T_PENJUALAN_JASA.NO_SPK");
    $this->db->select("T_T_T_PENJUALAN_JASA.NO_BAP");





    $this->db->select("SUM_SUB_TOTAL");

   


    $this->db->from('T_T_T_PENJUALAN_JASA');


    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PENJUALAN_JASA.PAYMENT_METHOD_ID', 'left');
    $this->db->join('T_M_D_PELANGGAN', 'T_M_D_PELANGGAN.ID = T_T_T_PENJUALAN_JASA.PELANGGAN_ID', 'left');





    $this->db->join("(select \"PENJUALAN_JASA_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PENJUALAN_JASA_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PENJUALAN_JASA_ID\") as t_sum_1", 'T_T_T_PENJUALAN_JASA.ID = t_sum_1.PENJUALAN_JASA_ID', 'left');

    

    $date_before = date('Y-m-d',(strtotime ( '-30 day' , strtotime ( $date_penjualan_jasa) ) ));

    $this->db->where("T_T_T_PENJUALAN_JASA.DATE<='{$date_penjualan_jasa}' and T_T_T_PENJUALAN_JASA.DATE>='{$date_before}'");

    $this->db->where("T_T_T_PENJUALAN_JASA.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }



  public function select_by_id($id)
  {
    $this->db->select("T_T_T_PENJUALAN_JASA.ID");
    $this->db->select("T_T_T_PENJUALAN_JASA.DATE");
    $this->db->select("T_T_T_PENJUALAN_JASA.TIME");
    $this->db->select("T_T_T_PENJUALAN_JASA.NEW_DATE");
    $this->db->select("T_T_T_PENJUALAN_JASA.INV");
    $this->db->select("T_T_T_PENJUALAN_JASA.INV_INT");

    $this->db->select("T_T_T_PENJUALAN_JASA.PELANGGAN_ID");


    $this->db->select("T_T_T_PENJUALAN_JASA.COMPANY_ID");
    $this->db->select("T_T_T_PENJUALAN_JASA.PAYMENT_METHOD_ID");

    $this->db->select("T_T_T_PENJUALAN_JASA.CREATED_BY");
    $this->db->select("T_T_T_PENJUALAN_JASA.UPDATED_BY");
    $this->db->select("T_T_T_PENJUALAN_JASA.MARK_FOR_DELETE");
    $this->db->select("T_T_T_PENJUALAN_JASA.KET");
    $this->db->select("T_T_T_PENJUALAN_JASA.PRINTED");
    $this->db->select("T_T_T_PENJUALAN_JASA.INV_HEAD");
    $this->db->select("T_T_T_PENJUALAN_JASA.ENABLE_EDIT");

    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    $this->db->select("T_M_D_PELANGGAN.PELANGGAN");
    $this->db->select("T_M_D_PELANGGAN.ALAMAT");
    $this->db->select("T_M_D_PELANGGAN.NO_TELP");
    $this->db->select("T_M_D_PELANGGAN.NPWP");

    $this->db->select("T_M_D_COMPANY.COMPANY");
    
    $this->db->select("T_T_T_PENJUALAN_JASA.NO_FAKTUR_PAJAK");
    $this->db->select("T_T_T_PENJUALAN_JASA.BLOK");
    $this->db->select("T_T_T_PENJUALAN_JASA.NO_SPK");
    $this->db->select("T_T_T_PENJUALAN_JASA.NO_BAP");


    $this->db->select("SUM_SUB_TOTAL");

   


    $this->db->from('T_T_T_PENJUALAN_JASA');


    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PENJUALAN_JASA.PAYMENT_METHOD_ID', 'left');
    $this->db->join('T_M_D_PELANGGAN', 'T_M_D_PELANGGAN.ID = T_T_T_PENJUALAN_JASA.PELANGGAN_ID', 'left');


    $this->db->join('T_M_D_COMPANY', 'T_M_D_COMPANY.ID = T_T_T_PENJUALAN_JASA.COMPANY_ID', 'left');



    $this->db->join("(select \"PENJUALAN_JASA_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PENJUALAN_JASA_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PENJUALAN_JASA_ID\") as t_sum_1", 'T_T_T_PENJUALAN_JASA.ID = t_sum_1.PENJUALAN_JASA_ID', 'left');

    
    if($this->session->userdata('t_t_t_penjualan_jasa_delete_logic')==0)
    {
      $this->db->where('T_T_T_PENJUALAN_JASA.MARK_FOR_DELETE',FALSE);
    }

    
    $this->db->where('T_T_T_PENJUALAN_JASA.ID',$id);
    

    $akun = $this->db->get ();
    return $akun->result ();
  }


  public function select_inv_int()
  {
    $this_year = date('Y-m').'-01';
    $this->db->limit(1);
    $this->db->select("INV_INT");
    $this->db->from('T_T_T_PENJUALAN_JASA');
    $this->db->where("COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->where("DATE>='{$this_year}'");
    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }

   




  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_T_T_PENJUALAN_JASA');
  }

  function tambah($data)
  {
        $this->db->insert('T_T_T_PENJUALAN_JASA', $data);
        return TRUE;
  }

}


