<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_send_t_ak_jurnal extends CI_Model {
    




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

    if($level_user_id==4)
    {
        $this->db->where("T_AK_JURNAL.CREATED_BY='{$username}'");
    }

    $this->db->where("T_AK_JURNAL.DATE<='{$date_to_select_jurnal}'");

    $this->db->where('T_AK_JURNAL.CHECKED_ID',0); //nol = yang belum disend to cloud
    
    $this->db->order_by("T_AK_JURNAL.DATE,T_AK_JURNAL.TIME", "asc");

    $akun = $this->db->get ();
    return $akun->result ();
  }

}


