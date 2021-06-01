<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_ak_jurnal extends CI_Model {
    



public function update($data, $id)
{
  $this->db->where('ID', $id);
  return $this->db->update('T_AK_JURNAL', $data);
}


public function select_no_voucer()
{
    $this->db->limit(1);
    $this->db->select("NO_VOUCER");
    $this->db->from('T_AK_JURNAL');
    $this->db->order_by("ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
}




public function select_used_jurnal($type_id,$from_date,$to_date)
{

    $this->db->select("AK_M_COA.ID");
    $this->db->select("AK_M_COA.NO_AKUN_1");
    $this->db->select("AK_M_COA.NO_AKUN_2");
    $this->db->select("AK_M_COA.NO_AKUN_3");
    $this->db->select("AK_M_COA.DB_K_ID");
    $this->db->select("AK_M_COA.TYPE_ID");
    $this->db->select("AK_M_COA.NAMA_AKUN");

    $this->db->select("T_AK_JURNAL.NO_VOUCER");
    $this->db->select("T_AK_JURNAL.DEBIT");
    $this->db->select("T_AK_JURNAL.KREDIT");

    $this->db->from('AK_M_COA');


    $this->db->join('T_AK_JURNAL', 'AK_M_COA.ID = T_AK_JURNAL.COA_ID', 'left');
    


    
    



    $this->db->where("(T_AK_JURNAL.DEBIT>0 or T_AK_JURNAL.KREDIT>0) and AK_M_COA.TYPE_ID={$type_id} and AK_M_COA.FAMILY_ID=3 and T_AK_JURNAL.DATE>='{$from_date}' and T_AK_JURNAL.DATE<='{$to_date}'");
    $this->db->where("AK_M_COA.CASH_FLOW=true");

    
    $this->db->order_by("NAMA_AKUN", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
}


public function select_sum_kredit_detail($coa_id)
{
    $this->db->select_sum('KREDIT');
    $this->db->from('T_AK_JURNAL');

    $this->db->where("COA_ID='{$coa_id}'");

    $akun = $this->db->get ();
    return $akun->result ();
}

public function select_sum_debit_detail($coa_id)
{
    $this->db->select_sum('DEBIT');
    $this->db->from('T_AK_JURNAL');

    $this->db->where("COA_ID='{$coa_id}'");

    $akun = $this->db->get ();
    return $akun->result ();
}

public function select_created_id($created_id)
  {
    $this->db->select("T_AK_JURNAL.ID");
    $this->db->select("AK_M_COA.NO_AKUN_1");
    $this->db->select("AK_M_COA.NO_AKUN_2");
    $this->db->select("AK_M_COA.NO_AKUN_3");
    $this->db->select("AK_M_COA.NAMA_AKUN");
    $this->db->select("AK_M_COA.FAMILY_ID");
    $this->db->select("T_AK_JURNAL.COA_ID");
    $this->db->select("T_AK_JURNAL.DEBIT");
    $this->db->select("T_AK_JURNAL.KREDIT");
    $this->db->select("T_AK_JURNAL.CATATAN");
    $this->db->select("T_AK_JURNAL.DEPARTEMEN");
    $this->db->select("T_AK_JURNAL.NO_VOUCER");
    $this->db->select("T_AK_JURNAL.DATE");
    $this->db->select("T_AK_JURNAL.TIME");
    $this->db->select("T_AK_JURNAL.CREATED_BY");
    $this->db->select("T_AK_JURNAL.UPDATED_BY");
    $this->db->select("T_AK_JURNAL.CREATED_ID");
    $this->db->select("T_AK_JURNAL.CHECKED_ID");
    $this->db->select("T_AK_JURNAL.SPECIAL_ID");

    $this->db->from('T_AK_JURNAL');
    $this->db->join('AK_M_COA', 'AK_M_COA.ID = T_AK_JURNAL.COA_ID', 'left');

    $this->db->where("T_AK_JURNAL.CREATED_ID='{$created_id}'");


    $this->db->order_by("T_AK_JURNAL.ID", "asc");

    $akun = $this->db->get ();
    return $akun->result ();
  }



  public function select($date_from_select_jurnal,$date_to_select_jurnal)
  {
    $level_user_id = $this->session->userdata('level_user_id');
    $username = $this->session->userdata('username');

    $this->db->select("T_AK_JURNAL.ID");
    $this->db->select("AK_M_COA.NO_AKUN_1");
    $this->db->select("AK_M_COA.NO_AKUN_2");
    $this->db->select("AK_M_COA.NO_AKUN_3");
    $this->db->select("AK_M_COA.NAMA_AKUN");
    $this->db->select("AK_M_COA.FAMILY_ID");
    $this->db->select("AK_M_COA.DB_K_ID");
    $this->db->select("T_AK_JURNAL.COA_ID");
    $this->db->select("T_AK_JURNAL.DEBIT");
    $this->db->select("T_AK_JURNAL.KREDIT");
    $this->db->select("T_AK_JURNAL.CATATAN");
    $this->db->select("T_AK_JURNAL.DEPARTEMEN");
    $this->db->select("T_AK_JURNAL.NO_VOUCER");
    $this->db->select("T_AK_JURNAL.DATE");
    $this->db->select("T_AK_JURNAL.TIME");
    $this->db->select("T_AK_JURNAL.CREATED_BY");
    $this->db->select("T_AK_JURNAL.UPDATED_BY");
    $this->db->select("T_AK_JURNAL.CREATED_ID");

    $this->db->select("T_AK_JURNAL.CHECKED_ID");
    $this->db->select("T_AK_JURNAL.SPECIAL_ID");

    $this->db->from('T_AK_JURNAL');
    $this->db->join('AK_M_COA', 'AK_M_COA.ID = T_AK_JURNAL.COA_ID', 'left');
    $this->db->where("T_AK_JURNAL.DATE>='{$date_from_select_jurnal}'");
    $this->db->where("T_AK_JURNAL.DATE<='{$date_to_select_jurnal}'");

    if($level_user_id==4 or $level_user_id==9)
    {
        $this->db->where("T_AK_JURNAL.CREATED_BY='{$username}'");
    }

    if($level_user_id>=8)
    {
        $this->db->where("T_AK_JURNAL.COMPANY_ID='{$this->session->userdata('company_id')}'");
    }


    
    $this->db->order_by("T_AK_JURNAL.DATE,T_AK_JURNAL.TIME", "asc");

    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function delete($created_id)
  {
    $this->db->where('CREATED_ID',$created_id);
    $this->db->delete('T_AK_JURNAL');
  }

  public function delete_no_voucer($no_voucer)
  {
    $this->db->where('NO_VOUCER',$no_voucer);
    $this->db->delete('T_AK_JURNAL');
  }


  public function delete_created_by()
  {
    $this->db->where('CREATED_BY',$this->session->userdata('username'));
    $this->db->delete('T_AK_JURNAL_EDIT');
  }
  public function delete_created_id($created_id)
  {
    $this->db->where('CREATED_ID',$created_id);
    $this->db->delete('T_AK_JURNAL');
  }

    public function update_tutup_buku($data, $date_from_select_jurnal,$date_to_select_jurnal)
    {
        $this->db->where("DATE>='{$date_from_select_jurnal}'");
        $this->db->where("DATE<='{$date_to_select_jurnal}'");
        return $this->db->update('T_AK_JURNAL', $data);
    }

  

  function tambah($data)
  {
        $this->db->insert('T_AK_JURNAL', $data);
        return TRUE;
  }

}


