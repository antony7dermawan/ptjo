<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_po extends CI_Model {
    


public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_PO', $data);
}





public function select_by_id($id)
  {
    $this->db->select('*');
    $this->db->select('SUM_TOTAL');
    $this->db->from('T_PO');

    $this->db->join("(select \"PO_ID\",sum(\"SUB_TOTAL\")\"SUM_TOTAL\" from \"T_PO_RINCIAN\" group by \"PO_ID\") as t_sum_1", 'T_PO.ID = t_sum_1.PO_ID', 'left');


    $this->db->where('ID',$id);
    $akun = $this->db->get ();
    return $akun->result ();
  }



public function select_for_dashboard()
  {
    $today = date('Y-m-d');
    $this->db->select('*');
    $this->db->select('SUM_TOTAL');
    $this->db->from('T_PO');

    $this->db->join("(select \"PO_ID\",sum(\"SUB_TOTAL\")\"SUM_TOTAL\" from \"T_PO_RINCIAN\" group by \"PO_ID\") as t_sum_1", 'T_PO.ID = t_sum_1.PO_ID', 'left');


    $this->db->where("T_PO.EXPIRE_DATE<='{$today}'");

    $this->db->where("T_PO.ENABLE_EDIT>'0'");
    $this->db->order_by("ID", "desc");
    $akun = $this->db->get ();
    return $akun->result ();
  }


  public function select($date)
  {
    $this->db->select('*');
    $this->db->select('SUM_TOTAL');
    $this->db->from('T_PO');

    $this->db->join("(select \"PO_ID\",sum(\"SUB_TOTAL\")\"SUM_TOTAL\" from \"T_PO_RINCIAN\" group by \"PO_ID\") as t_sum_1", 'T_PO.ID = t_sum_1.PO_ID', 'left');


    $date_before = date('Y-m-d',(strtotime ( '-30 day' , strtotime ( $date) ) ));

    $this->db->where("DATE<='{$date}' and DATE>='{$date_before}'");

    $this->db->order_by("ID", "desc");
    $akun = $this->db->get ();
    return $akun->result ();
  }


  public function select_range_date($date_from,$date_to)
  {
    $this->db->select('*');
    $this->db->select('SUM_TOTAL');
    $this->db->from('T_PO');

    $this->db->join("(select \"PO_ID\",sum(\"SUB_TOTAL\")\"SUM_TOTAL\" from \"T_PO_RINCIAN\" group by \"PO_ID\") as t_sum_1", 'T_PO.ID = t_sum_1.PO_ID', 'left');


    $this->db->where("DATE>='{$date_from}' and DATE<='{$date_to}'");
    $this->db->order_by("ID", "desc");
    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_PO');
  }

  function tambah($data)
  {
        $this->db->insert('T_PO', $data);
        return TRUE;
  }

}


