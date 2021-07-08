<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_t_t_retur_penjualan extends CI_Model {
    
    
public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_T_T_RETUR_PENJUALAN', $data);
}







public function select_range_date($from_date,$to_date)
  {
    $this->db->select("T_T_T_RETUR_PENJUALAN.ID");
    $this->db->select("T_T_T_RETUR_PENJUALAN.DATE");
    $this->db->select("T_T_T_RETUR_PENJUALAN.TIME");

    $this->db->select("T_T_T_RETUR_PENJUALAN.INV");
    $this->db->select("T_T_T_RETUR_PENJUALAN.INV_INT");
    $this->db->select("T_T_T_RETUR_PENJUALAN.COMPANY_ID");
    $this->db->select("T_T_T_RETUR_PENJUALAN.PENJUALAN_ID");
    $this->db->select("T_T_T_RETUR_PENJUALAN.CREATED_BY");
    $this->db->select("T_T_T_RETUR_PENJUALAN.UPDATED_BY");
    $this->db->select("T_T_T_RETUR_PENJUALAN.MARK_FOR_DELETE");
    $this->db->select("T_T_T_RETUR_PENJUALAN.KET");
    $this->db->select("T_T_T_RETUR_PENJUALAN.PRINTED");


    $this->db->select("T_T_T_PENJUALAN.INV as INV_PENJUALAN");


    $this->db->select("SUM_SUB_TOTAL");




    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    $this->db->select("T_M_D_PELANGGAN.PELANGGAN");
    $this->db->select("T_M_D_SALES.SALES");
    $this->db->select("T_M_D_NO_POLISI.NO_POLISI");
    $this->db->select("T_M_D_SUPIR.SUPIR");
    $this->db->select("T_M_D_LOKASI.LOKASI");





    $this->db->from('T_T_T_RETUR_PENJUALAN');


    $this->db->join('T_T_T_PENJUALAN', 'T_T_T_PENJUALAN.ID = T_T_T_RETUR_PENJUALAN.PENJUALAN_ID', 'left');


    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PENJUALAN.PAYMENT_METHOD_ID', 'left');
    $this->db->join('T_M_D_PELANGGAN', 'T_M_D_PELANGGAN.ID = T_T_T_PENJUALAN.PELANGGAN_ID', 'left');
    $this->db->join('T_M_D_SALES', 'T_M_D_SALES.ID = T_T_T_PENJUALAN.SALES_ID', 'left');

    $this->db->join('T_M_D_NO_POLISI', 'T_M_D_NO_POLISI.ID = T_T_T_PENJUALAN.NO_POLISI_ID', 'left');

    $this->db->join('T_M_D_SUPIR', 'T_M_D_SUPIR.ID = T_T_T_PENJUALAN.SUPIR_ID', 'left');

    $this->db->join('T_M_D_LOKASI', 'T_M_D_LOKASI.ID = T_T_T_PENJUALAN.LOKASI_ID', 'left');
    

    $this->db->join("(select \"RETUR_PENJUALAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_RETUR_PENJUALAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"RETUR_PENJUALAN_ID\") as t_sum_1", 'T_T_T_RETUR_PENJUALAN.ID = t_sum_1.RETUR_PENJUALAN_ID', 'left');

  
    if($this->session->userdata('t_t_t_retur_penjualan_delete_logic')==0)
    {
      $this->db->where('T_T_T_RETUR_PENJUALAN.MARK_FOR_DELETE',FALSE);
    }

    $this->db->where("T_T_T_RETUR_PENJUALAN.DATE<='{$to_date}' and T_T_T_RETUR_PENJUALAN.DATE>='{$from_date}'");

    
    $this->db->where("T_T_T_RETUR_PENJUALAN.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function select($date_retur_penjualan)
  {
    $this->db->select("T_T_T_RETUR_PENJUALAN.ID");
    $this->db->select("T_T_T_RETUR_PENJUALAN.DATE");
    $this->db->select("T_T_T_RETUR_PENJUALAN.TIME");

    $this->db->select("T_T_T_RETUR_PENJUALAN.INV");
    $this->db->select("T_T_T_RETUR_PENJUALAN.INV_INT");
    $this->db->select("T_T_T_RETUR_PENJUALAN.COMPANY_ID");
    $this->db->select("T_T_T_RETUR_PENJUALAN.PENJUALAN_ID");
    $this->db->select("T_T_T_RETUR_PENJUALAN.CREATED_BY");
    $this->db->select("T_T_T_RETUR_PENJUALAN.UPDATED_BY");
    $this->db->select("T_T_T_RETUR_PENJUALAN.MARK_FOR_DELETE");
    $this->db->select("T_T_T_RETUR_PENJUALAN.KET");
    $this->db->select("T_T_T_RETUR_PENJUALAN.PRINTED");


    $this->db->select("T_T_T_PENJUALAN.INV as INV_PENJUALAN");


    $this->db->select("SUM_SUB_TOTAL");

   


    $this->db->from('T_T_T_RETUR_PENJUALAN');


    $this->db->join('T_T_T_PENJUALAN', 'T_T_T_PENJUALAN.ID = T_T_T_RETUR_PENJUALAN.PENJUALAN_ID', 'left');


    $this->db->join("(select \"RETUR_PENJUALAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_RETUR_PENJUALAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"RETUR_PENJUALAN_ID\") as t_sum_1", 'T_T_T_RETUR_PENJUALAN.ID = t_sum_1.RETUR_PENJUALAN_ID', 'left');

  
    $date_before = date('Y-m-d',(strtotime ( '-30 day' , strtotime ( $date_retur_penjualan) ) ));

    $this->db->where("T_T_T_RETUR_PENJUALAN.DATE<='{$date_retur_penjualan}' and T_T_T_RETUR_PENJUALAN.DATE>='{$date_before}'");

    
    $this->db->where("T_T_T_RETUR_PENJUALAN.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }



  public function select_by_id($id)
  {
    $this->db->select("T_T_T_RETUR_PENJUALAN.ID");
    $this->db->select("T_T_T_RETUR_PENJUALAN.DATE");
    $this->db->select("T_T_T_RETUR_PENJUALAN.TIME");

    $this->db->select("T_T_T_RETUR_PENJUALAN.INV");
    $this->db->select("T_T_T_RETUR_PENJUALAN.INV_INT");
    $this->db->select("T_T_T_RETUR_PENJUALAN.COMPANY_ID");
    $this->db->select("T_T_T_RETUR_PENJUALAN.PENJUALAN_ID");
    $this->db->select("T_T_T_RETUR_PENJUALAN.CREATED_BY");
    $this->db->select("T_T_T_RETUR_PENJUALAN.UPDATED_BY");
    $this->db->select("T_T_T_RETUR_PENJUALAN.MARK_FOR_DELETE");
    $this->db->select("T_T_T_RETUR_PENJUALAN.KET");
    $this->db->select("T_T_T_RETUR_PENJUALAN.PRINTED");


    $this->db->select("T_T_T_PENJUALAN.INV as INV_PENJUALAN");
    $this->db->select("T_M_D_COMPANY.COMPANY");


    $this->db->select("SUM_SUB_TOTAL");

   
    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    $this->db->select("T_M_D_PELANGGAN.PELANGGAN");
    $this->db->select("T_M_D_SALES.SALES");
    $this->db->select("T_M_D_NO_POLISI.NO_POLISI");
    $this->db->select("T_M_D_SUPIR.SUPIR");
    $this->db->select("T_M_D_LOKASI.LOKASI");

    $this->db->from('T_T_T_RETUR_PENJUALAN');


    $this->db->join('T_T_T_PENJUALAN', 'T_T_T_PENJUALAN.ID = T_T_T_RETUR_PENJUALAN.PENJUALAN_ID', 'left');

    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PENJUALAN.PAYMENT_METHOD_ID', 'left');
    $this->db->join('T_M_D_PELANGGAN', 'T_M_D_PELANGGAN.ID = T_T_T_PENJUALAN.PELANGGAN_ID', 'left');
    $this->db->join('T_M_D_SALES', 'T_M_D_SALES.ID = T_T_T_PENJUALAN.SALES_ID', 'left');

    $this->db->join('T_M_D_NO_POLISI', 'T_M_D_NO_POLISI.ID = T_T_T_PENJUALAN.NO_POLISI_ID', 'left');

    $this->db->join('T_M_D_SUPIR', 'T_M_D_SUPIR.ID = T_T_T_PENJUALAN.SUPIR_ID', 'left');

    $this->db->join('T_M_D_LOKASI', 'T_M_D_LOKASI.ID = T_T_T_PENJUALAN.LOKASI_ID', 'left');



    $this->db->join("(select \"RETUR_PENJUALAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_RETUR_PENJUALAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"RETUR_PENJUALAN_ID\") as t_sum_1", 'T_T_T_RETUR_PENJUALAN.ID = t_sum_1.RETUR_PENJUALAN_ID', 'left');

    
    $this->db->join('T_M_D_COMPANY', 'T_M_D_COMPANY.ID = T_T_T_RETUR_PENJUALAN.COMPANY_ID', 'left');
    
    $this->db->where('T_T_T_RETUR_PENJUALAN.ID',$id);
    $this->db->where("T_T_T_RETUR_PENJUALAN.COMPANY_ID={$this->session->userdata('company_id')}");

    

    $akun = $this->db->get ();
    return $akun->result ();
  }


  public function select_inv_int()
  {
    $this_year = date('Y-m').'-01';
    $this->db->limit(1);
    $this->db->select("INV_INT");
    $this->db->from('T_T_T_RETUR_PENJUALAN');
    $this->db->where("COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->where("DATE>='{$this_year}'");
    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }

   




  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_T_T_RETUR_PENJUALAN');
  }

  function tambah($data)
  {
        $this->db->insert('T_T_T_RETUR_PENJUALAN', $data);
        return TRUE;
  }

}


