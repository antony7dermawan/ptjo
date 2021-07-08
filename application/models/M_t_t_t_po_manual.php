<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_t_t_po_manual extends CI_Model {
    
    
public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_T_T_PEMBELIAN', $data);
}


public function select_inv_pembelian()
{
    $this->db->limit(100000);
    $this->db->select("ID");
    $this->db->select("INV");
    $this->db->from('T_T_T_PEMBELIAN');
    $this->db->order_by("ID", "desc");
    $akun = $this->db->get ();
    return $akun->result ();
}   
  public function select($date_po_manual)
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
    $this->db->select("T_T_T_PEMBELIAN.T_STATUS");

    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    $this->db->select("T_M_D_SUPPLIER.SUPPLIER");


    $this->db->select("SUM_SUB_TOTAL");

   


    $this->db->from('T_T_T_PEMBELIAN');


    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PEMBELIAN.PAYMENT_METHOD_ID', 'left');
    $this->db->join('T_M_D_SUPPLIER', 'T_M_D_SUPPLIER.ID = T_T_T_PEMBELIAN.SUPPLIER_ID', 'left');

    $this->db->join("(select \"PEMBELIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMBELIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PEMBELIAN_ID\") as t_sum_1", 'T_T_T_PEMBELIAN.ID = t_sum_1.PEMBELIAN_ID', 'left');

    

    $this->db->where("(T_T_T_PEMBELIAN.T_STATUS=10 or T_T_T_PEMBELIAN.T_STATUS=1)");

    $date_before = date('Y-m-d',(strtotime ( '-30 day' , strtotime ( $date_po_manual) ) ));

    $this->db->where("T_T_T_PEMBELIAN.NEW_DATE<='{$date_po_manual}' and T_T_T_PEMBELIAN.NEW_DATE>='{$date_before}'");

    
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
    $this->db->select("T_T_T_PEMBELIAN.PAYMENT_METHOD_ID");
    $this->db->select("T_T_T_PEMBELIAN.SUPPLIER_ID");
    $this->db->select("T_T_T_PEMBELIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMBELIAN.UPDATED_BY");
    $this->db->select("T_T_T_PEMBELIAN.MARK_FOR_DELETE");
    $this->db->select("T_T_T_PEMBELIAN.KET");
    $this->db->select("T_T_T_PEMBELIAN.PRINTED");
    $this->db->select("T_T_T_PEMBELIAN.INV_SUPPLIER");
    $this->db->select("T_T_T_PEMBELIAN.T_STATUS");

    $this->db->select("T_M_D_PAYMENT_METHOD.PAYMENT_METHOD");
    $this->db->select("T_M_D_SUPPLIER.SUPPLIER");


    $this->db->select("SUM_SUB_TOTAL");

   


    $this->db->from('T_T_T_PEMBELIAN');


    $this->db->join('T_M_D_PAYMENT_METHOD', 'T_M_D_PAYMENT_METHOD.ID = T_T_T_PEMBELIAN.PAYMENT_METHOD_ID', 'left');
    $this->db->join('T_M_D_SUPPLIER', 'T_M_D_SUPPLIER.ID = T_T_T_PEMBELIAN.SUPPLIER_ID', 'left');

    $this->db->join("(select \"PEMBELIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMBELIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false group by \"PEMBELIAN_ID\") as t_sum_1", 'T_T_T_PEMBELIAN.ID = t_sum_1.PEMBELIAN_ID', 'left');

    

    
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


