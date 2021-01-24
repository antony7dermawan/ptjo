<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_setting_db_bank_coa extends CI_Model {
    


public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('SETTING_DB_BANK_COA', $data);
}






  public function select($from_date,$to_date)
  {
    $this->db->select("SUM_DEBIT");
    $this->db->select("SUM_KREDIT");


    $this->db->select("SETTING_DB_BANK_COA.ID");
    $this->db->select("AK_M_COA.NO_AKUN_1");
    $this->db->select("AK_M_COA.NO_AKUN_2");
    $this->db->select("AK_M_COA.NO_AKUN_3");
    $this->db->select("AK_M_COA.DB_K_ID");
    $this->db->select("AK_M_COA.TYPE_ID");
    $this->db->select("AK_M_COA.NAMA_AKUN");
    
    $this->db->from('SETTING_DB_BANK_COA');

    $this->db->join('AK_M_COA', 'AK_M_COA.ID = SETTING_DB_BANK_COA.COA_ID', 'left');

    $this->db->join("(select \"COA_ID\",sum(\"DEBIT\")\"SUM_DEBIT\" from \"T_AK_JURNAL\" where \"DATE\">='{$from_date}' and \"DATE\"<='{$to_date}' group by \"COA_ID\") as t_sum_1", 'AK_M_COA.ID = t_sum_1.COA_ID', 'left');

    $this->db->join("(select \"COA_ID\",sum(\"KREDIT\")\"SUM_KREDIT\" from \"T_AK_JURNAL\" where \"DATE\">='{$from_date}' and \"DATE\"<='{$to_date}' group by \"COA_ID\") as t_sum_2", 'AK_M_COA.ID = t_sum_2.COA_ID', 'left');


    $this->db->order_by("ID", "asc");
    $akun = $this->db->get ();
    return $akun->result ();
  }




  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('SETTING_DB_BANK_COA');
  }


 

  function tambah($data)
  {
        $this->db->insert('SETTING_DB_BANK_COA', $data);
        return TRUE;
  }

}


