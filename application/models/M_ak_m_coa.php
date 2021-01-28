<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_ak_m_coa extends CI_Model {
    
    

public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('AK_M_COA', $data);
}






  public function select_no_akun()
  {
    $this->db->select("ID");
    $this->db->select("NO_AKUN_1");
    $this->db->select("NO_AKUN_2");
    $this->db->select("NO_AKUN_3");
    $this->db->select("NAMA_AKUN");
    $this->db->from('AK_M_COA');
    $this->db->where("FAMILY_ID=3");

    $akun = $this->db->get ();
    return $akun->result ();
  }


  public function read_coa_id_from_no_akun($no_akun)
  {
    $this->db->select("ID");
    $this->db->select("DB_K_ID");
    $this->db->from('AK_M_COA');
    $this->db->where("FAMILY_ID=3 and (NO_AKUN_3='{$no_akun}' or NO_AKUN_2='{$no_akun}' or NO_AKUN_1='{$no_akun}')");

    $akun = $this->db->get ();
    return $akun->result ();
  }


  public function select_coa_id($coa_id)
  {
    $this->db->select("NO_AKUN_1");
    $this->db->select("NO_AKUN_2");
    $this->db->select("NO_AKUN_3");
    $this->db->select("DB_K_ID");
    $this->db->from('AK_M_COA');
    $this->db->where("ID='{$coa_id}'");

    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function select_sum_saldo_no_akun_3($no_akun_2)
  {
    $this->db->select_sum("SALDO");
    $this->db->from('AK_M_COA');
    $this->db->where("NO_AKUN_2='{$no_akun_2}' and NO_AKUN_3<>'' and NO_AKUN_1<>''");

    $akun = $this->db->get ();
    return $akun->result ();
  }

  
  public function update_saldo_parent_2($data, $no_akun_2)
  {
      $this->db->where("NO_AKUN_2='{$no_akun_2}' and NO_AKUN_3='' and NO_AKUN_1<>''");
      return $this->db->update('AK_M_COA', $data);
  }

  public function select_sum_saldo_no_akun_2($no_akun_1)
  {
    $this->db->select_sum("SALDO");
    $this->db->from('AK_M_COA');
    $this->db->where("NO_AKUN_1='{$no_akun_1}' and NO_AKUN_2<>'' and NO_AKUN_3<>''");

    $akun = $this->db->get ();
    return $akun->result ();
  }


  public function select_sum_saldo_no_akun_4($no_akun_1)
  {
    $this->db->select_sum("SALDO");
    $this->db->from('AK_M_COA');
    $this->db->where("NO_AKUN_1='{$no_akun_1}' and NO_AKUN_2='' and NO_AKUN_3<>''");

    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function select_sum_saldo_no_akun_5($no_akun_1)
  {
    $this->db->select_sum("SALDO");
    $this->db->from('AK_M_COA');
    $this->db->where("NO_AKUN_1='{$no_akun_1}' and NO_AKUN_2<>'' and NO_AKUN_3=''");

    $akun = $this->db->get ();
    return $akun->result ();
  }

  
  public function update_saldo_parent_1($data, $no_akun_1)
  {
      $this->db->where("NO_AKUN_1='{$no_akun_1}' and NO_AKUN_2='' and NO_AKUN_3='' ");
      return $this->db->update('AK_M_COA', $data);
  }

  public function select()
  {
    $this->db->select("AK_M_COA.ID");
    $this->db->select("AK_M_COA.NO_AKUN_1");
    $this->db->select("AK_M_COA.NO_AKUN_2");
    $this->db->select("AK_M_COA.NO_AKUN_3");
    $this->db->select("AK_M_COA.NAMA_AKUN");
    $this->db->select("AK_M_TYPE.TYPE_ID");
    $this->db->select("AK_M_TYPE.TYPE");
    $this->db->select("AK_M_DB_K.DB_K_ID");
    $this->db->select("AK_M_DB_K.DB_K");
    $this->db->select("AK_M_FAMILY.FAMILY_ID");
    $this->db->select("AK_M_FAMILY.FAMILY");
    $this->db->select("AK_M_COA.SALDO");

    $this->db->from('AK_M_COA');
    $this->db->join('AK_M_TYPE', 'AK_M_TYPE.TYPE_ID = AK_M_COA.TYPE_ID', 'left');
    $this->db->join('AK_M_DB_K', 'AK_M_DB_K.DB_K_ID = AK_M_COA.DB_K_ID', 'left');
    $this->db->join('AK_M_FAMILY', 'AK_M_FAMILY.FAMILY_ID = AK_M_COA.FAMILY_ID', 'left');

    $this->db->order_by("AK_M_COA.NO_AKUN_1,AK_M_COA.NO_AKUN_2,AK_M_COA.NO_AKUN_3", "asc");

    $akun = $this->db->get ();
    return $akun->result ();
  }


  public function select_type($type_id,$from_date,$to_date)
  {
    $this->db->select("AK_M_COA.ID");
    $this->db->select("AK_M_COA.NO_AKUN_1");
    $this->db->select("AK_M_COA.NO_AKUN_2");
    $this->db->select("AK_M_COA.NO_AKUN_3");
    $this->db->select("AK_M_COA.NAMA_AKUN");
    $this->db->select("AK_M_TYPE.TYPE_ID");
    $this->db->select("AK_M_TYPE.TYPE");
    $this->db->select("AK_M_DB_K.DB_K_ID");
    $this->db->select("AK_M_DB_K.DB_K");
    $this->db->select("AK_M_FAMILY.FAMILY_ID");
    $this->db->select("AK_M_FAMILY.FAMILY");




    $this->db->from('AK_M_COA');
    $this->db->join('AK_M_TYPE', 'AK_M_TYPE.TYPE_ID = AK_M_COA.TYPE_ID', 'left');
    $this->db->join('AK_M_DB_K', 'AK_M_DB_K.DB_K_ID = AK_M_COA.DB_K_ID', 'left');
    $this->db->join('AK_M_FAMILY', 'AK_M_FAMILY.FAMILY_ID = AK_M_COA.FAMILY_ID', 'left');


    
    $this->db->where(" AK_M_COA.TYPE_ID={$type_id}");
    

    $this->db->order_by("AK_M_COA.NO_AKUN_1,AK_M_COA.NO_AKUN_2,AK_M_COA.NO_AKUN_3", "asc");

    $akun = $this->db->get ();
    return $akun->result ();
  }


  public function select_sum_family_id_3($coa_id,$from_date,$to_date)
  {
    $this->db->select("SUM_DEBIT");
    $this->db->select("SUM_KREDIT");




    $this->db->from('AK_M_COA');


    
    $this->db->join("(select \"COA_ID\",sum(\"DEBIT\")\"SUM_DEBIT\" from \"T_AK_JURNAL\" where \"DATE\">='{$from_date}' and \"DATE\"<='{$to_date}' group by \"COA_ID\") as t_sum_1", 'AK_M_COA.ID = t_sum_1.COA_ID', 'left');

    $this->db->join("(select \"COA_ID\",sum(\"KREDIT\")\"SUM_KREDIT\" from \"T_AK_JURNAL\" where \"DATE\">='{$from_date}' and \"DATE\"<='{$to_date}' group by \"COA_ID\") as t_sum_2", 'AK_M_COA.ID = t_sum_2.COA_ID', 'left');
    
    $this->db->where(" AK_M_COA.ID={$coa_id}");
    


    $akun = $this->db->get ();
    return $akun->result ();
  }


  public function select_sum_family_id_2($coa_id,$from_date,$to_date)
  {
    $this->db->select("SUM_DEBIT");
    $this->db->select("SUM_KREDIT");


    $this->db->from('AK_M_COA');

    $this->db->join("(select \"AK_M_COA\".\"NO_AKUN_2\",sum(\"T_AK_JURNAL\".\"DEBIT\")\"SUM_DEBIT\" from \"T_AK_JURNAL\" LEFT OUTER JOIN \"AK_M_COA\" ON \"AK_M_COA\".\"ID\" = \"T_AK_JURNAL\".\"COA_ID\" where \"T_AK_JURNAL\".\"DATE\">='{$from_date}' and \"T_AK_JURNAL\".\"DATE\"<='{$to_date}' group by \"AK_M_COA\".\"NO_AKUN_2\") as t_sum", 'AK_M_COA.NO_AKUN_2 = t_sum.NO_AKUN_2', 'left');

    $this->db->join("(select \"AK_M_COA\".\"NO_AKUN_2\",sum(\"T_AK_JURNAL\".\"KREDIT\")\"SUM_KREDIT\" from \"T_AK_JURNAL\" LEFT OUTER JOIN \"AK_M_COA\" ON \"AK_M_COA\".\"ID\" = \"T_AK_JURNAL\".\"COA_ID\" where \"T_AK_JURNAL\".\"DATE\">='{$from_date}' and \"T_AK_JURNAL\".\"DATE\"<='{$to_date}' group by \"AK_M_COA\".\"NO_AKUN_2\") as t_sum_2", 'AK_M_COA.NO_AKUN_2 = t_sum_2.NO_AKUN_2', 'left');
    



    
    $this->db->where(" AK_M_COA.ID={$coa_id}");
    
    

    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function select_sum_family_id_1($coa_id,$from_date,$to_date)
  {
    $this->db->select("SUM_DEBIT");
    $this->db->select("SUM_KREDIT");


    $this->db->from('AK_M_COA');

    $this->db->join("(select \"AK_M_COA\".\"NO_AKUN_1\",sum(\"T_AK_JURNAL\".\"DEBIT\")\"SUM_DEBIT\" from \"T_AK_JURNAL\" LEFT OUTER JOIN \"AK_M_COA\" ON \"AK_M_COA\".\"ID\" = \"T_AK_JURNAL\".\"COA_ID\" where \"T_AK_JURNAL\".\"DATE\">='{$from_date}' and \"T_AK_JURNAL\".\"DATE\"<='{$to_date}' group by \"AK_M_COA\".\"NO_AKUN_1\") as t_sum", 'AK_M_COA.NO_AKUN_1 = t_sum.NO_AKUN_1', 'left');

    $this->db->join("(select \"AK_M_COA\".\"NO_AKUN_1\",sum(\"T_AK_JURNAL\".\"KREDIT\")\"SUM_KREDIT\" from \"T_AK_JURNAL\" LEFT OUTER JOIN \"AK_M_COA\" ON \"AK_M_COA\".\"ID\" = \"T_AK_JURNAL\".\"COA_ID\" where \"T_AK_JURNAL\".\"DATE\">='{$from_date}' and \"T_AK_JURNAL\".\"DATE\"<='{$to_date}' group by \"AK_M_COA\".\"NO_AKUN_1\") as t_sum_2", 'AK_M_COA.NO_AKUN_1 = t_sum_2.NO_AKUN_1', 'left');
    



    
    $this->db->where(" AK_M_COA.ID={$coa_id}");
    
    

    $akun = $this->db->get ();
    return $akun->result ();
  }



  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('AK_M_COA');
  }

  function tambah($data)
  {
        $this->db->insert('AK_M_COA', $data);
        return TRUE;
  }

}


