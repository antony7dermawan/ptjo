<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_t_t_a_penjualan_pks extends CI_Model {
    
    

public function update($data, $id)
{
    $this->db->where('ID', $id);
    return $this->db->update('T_T_A_PENJUALAN_PKS', $data);
}



  public function select_by_id($id)
  {
    $this->db->select("T_T_A_PENJUALAN_PKS.ID");
    $this->db->select("T_T_A_PENJUALAN_PKS.DATE");
    $this->db->select("T_T_A_PENJUALAN_PKS.TIME");
    $this->db->select("T_M_A_DIVISI.DIVISI_ID");
    $this->db->select("T_M_A_DIVISI.DIVISI");
    $this->db->select("T_M_A_PKS.PKS_ID");
    $this->db->select("T_M_A_PKS.PKS");
    $this->db->select("T_M_A_NO_POLISI.NO_POLISI_ID");
    $this->db->select("T_M_A_NO_POLISI.NO_POLISI");
    $this->db->select("T_M_A_SUPIR.SUPIR_ID");
    $this->db->select("T_M_A_SUPIR.SUPIR");
    $this->db->select("T_M_A_KENDARAAN.KENDARAAN_ID");
    $this->db->select("T_M_A_KENDARAAN.KENDARAAN");
    $this->db->select("T_T_A_PENJUALAN_PKS.NO_TIKET");
    $this->db->select("T_T_A_PENJUALAN_PKS.BRUTO");
    $this->db->select("T_T_A_PENJUALAN_PKS.BRUTO");
    $this->db->select("T_T_A_PENJUALAN_PKS.SORTASE_PERCENTAGE");
    $this->db->select("T_T_A_PENJUALAN_PKS.SORTASE_KG");
    $this->db->select("T_T_A_PENJUALAN_PKS.NETO");
    $this->db->select("T_T_A_PENJUALAN_PKS.R_JO");
    $this->db->select("T_T_A_PENJUALAN_PKS.R_EX");
    $this->db->select("T_T_A_PENJUALAN_PKS.R_DIV_1");
    $this->db->select("T_T_A_PENJUALAN_PKS.R_DIV_2");
    $this->db->select("T_T_A_PENJUALAN_PKS.R_DIV_3");
    $this->db->select("T_T_A_PENJUALAN_PKS.R_DIV_4");
    $this->db->select("T_T_A_PENJUALAN_PKS.RUMUS");
    $this->db->select("T_T_A_PENJUALAN_PKS.UANG_JALAN");
    $this->db->select("T_T_A_PENJUALAN_PKS.TAMBAHAN");
    $this->db->select("T_T_A_PENJUALAN_PKS.TOTAL_UANG_JALAN");
    $this->db->select("T_T_A_PENJUALAN_PKS.HARGA");
    $this->db->select("T_T_A_PENJUALAN_PKS.TOTAL_PENJUALAN");
    $this->db->select("T_T_A_PENJUALAN_PKS.PPN");
    $this->db->select("T_T_A_PENJUALAN_PKS.CREATED_BY");
    $this->db->select("T_T_A_PENJUALAN_PKS.UPDATED_BY");
    $this->db->select("T_T_A_PENJUALAN_PKS.AREA_ID");
    $this->db->select("T_T_A_PENJUALAN_PKS.COMPANY_ID");
    $this->db->select("T_T_A_PENJUALAN_PKS.INV");
    $this->db->select("T_T_A_PENJUALAN_PKS.INV_INT");
    $this->db->select("T_T_A_PENJUALAN_PKS.ENABLE_EDIT");
    $this->db->select("T_T_A_PENJUALAN_PKS.CHECKED_ID");
    $this->db->select("T_T_A_PENJUALAN_PKS.SPECIAL_ID");

    $this->db->from('T_T_A_PENJUALAN_PKS');
    $this->db->join('T_M_A_DIVISI', 'T_M_A_DIVISI.DIVISI_ID = T_T_A_PENJUALAN_PKS.DIVISI_ID', 'left');
    $this->db->join('T_M_A_PKS', 'T_M_A_PKS.PKS_ID = T_T_A_PENJUALAN_PKS.PKS_ID', 'left');
    $this->db->join('T_M_A_NO_POLISI', 'T_M_A_NO_POLISI.NO_POLISI_ID = T_T_A_PENJUALAN_PKS.NO_POLISI_ID', 'left');
    $this->db->join('T_M_A_SUPIR', 'T_M_A_SUPIR.SUPIR_ID = T_T_A_PENJUALAN_PKS.SUPIR_ID', 'left');
    $this->db->join('T_M_A_KENDARAAN', 'T_M_A_KENDARAAN.KENDARAAN_ID = T_T_A_PENJUALAN_PKS.KENDARAAN_ID', 'left');

    #$this->db->where('T_T_A_PENJUALAN_PKS.COMPANY_ID',$this->session->userdata('company_id'));
    #$this->db->where('T_T_A_PENJUALAN_PKS.AREA_ID',$this->session->userdata('area_id'));
    $this->db->where('T_T_A_PENJUALAN_PKS.ID',$id);


    $akun = $this->db->get ();
    return $akun->result ();
  }
  
public function select_inv_int()
{
  $this->db->select("INV_INT");
  $this->db->limit(1);
  $this->db->from('T_T_A_PENJUALAN_PKS');
  $this->db->where('T_T_A_PENJUALAN_PKS.COMPANY_ID',$this->session->userdata('company_id'));
  $this->db->where('T_T_A_PENJUALAN_PKS.AREA_ID',$this->session->userdata('area_id'));
  $this->db->order_by("T_T_A_PENJUALAN_PKS.ID", "desc");
  $akun = $this->db->get ();
  return $akun->result ();
}


  public function select_date($pks_id,$date_from_select_penjualan,$date_to_select_penjualan)
  {
    $this->db->select("*");
    $this->db->from('T_T_A_PENJUALAN_PKS');
    $this->db->where('DATE >=', $date_from_select_penjualan);
    $this->db->where('DATE <=', $date_to_select_penjualan);
    $this->db->where('PKS_ID', $pks_id);
    $this->db->where('ENABLE_EDIT', 1);
    $this->db->where('CHECKED_ID', 1);

    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function select_base_date_pks_id($pks_id,$date_from,$date_to)
  {
    $this->db->select("*");
    $this->db->from('T_T_A_PENJUALAN_PKS');
    $this->db->where('DATE >=', $date_from);
    $this->db->where('DATE <=', $date_to);
    $this->db->where('PKS_ID', $pks_id);
    $this->db->where('ENABLE_EDIT', 0);

    $akun = $this->db->get ();
    return $akun->result ();
  }


  public function select_sum_in_date($from_date,$to_date)
  {
    
    $this->db->select("T_M_A_PKS.PKS_ID");
    $this->db->select("T_M_A_PKS.PKS");



    $this->db->select("SUM_TRIP");
    $this->db->select("SUM_BRUTO");
    $this->db->select("SUM_TOTAL_PENJUALAN");
    $this->db->select("SUM_SORTASE_PERCENTAGE");
    $this->db->select("SUM_NETO");

    $this->db->from('T_M_A_PKS');


    $this->db->join("(select \"PKS_ID\",count(\"ID\")\"SUM_TRIP\" from \"T_T_A_PENJUALAN_PKS\" where \"DATE\">='{$from_date}' and \"DATE\"<='{$to_date}' and \"CHECKED_ID\"=1 group by \"PKS_ID\") as t_sum_3", 'T_M_A_PKS.PKS_ID = t_sum_3.PKS_ID', 'left');

    $this->db->join("(select \"PKS_ID\",sum(\"NETO\")\"SUM_NETO\" from \"T_T_A_PENJUALAN_PKS\" where \"DATE\">='{$from_date}' and \"DATE\"<='{$to_date}' and \"CHECKED_ID\"=1 group by \"PKS_ID\") as t_sum_5", 'T_M_A_PKS.PKS_ID = t_sum_5.PKS_ID', 'left');

    $this->db->join("(select \"PKS_ID\",sum(\"SORTASE_PERCENTAGE\")\"SUM_SORTASE_PERCENTAGE\" from \"T_T_A_PENJUALAN_PKS\" where \"DATE\">='{$from_date}' and \"DATE\"<='{$to_date}' and \"CHECKED_ID\"=1 group by \"PKS_ID\") as t_sum_4", 'T_M_A_PKS.PKS_ID = t_sum_4.PKS_ID', 'left');

    $this->db->join("(select \"PKS_ID\",sum(\"BRUTO\")\"SUM_BRUTO\" from \"T_T_A_PENJUALAN_PKS\" where \"DATE\">='{$from_date}' and \"DATE\"<='{$to_date}' and \"CHECKED_ID\"=1 group by \"PKS_ID\") as t_sum_2", 'T_M_A_PKS.PKS_ID = t_sum_2.PKS_ID', 'left');

    $this->db->join("(select \"PKS_ID\",sum(\"TOTAL_PENJUALAN\")\"SUM_TOTAL_PENJUALAN\" from \"T_T_A_PENJUALAN_PKS\" where \"DATE\">='{$from_date}' and \"DATE\"<='{$to_date}' and \"CHECKED_ID\"=1 group by \"PKS_ID\") as t_sum_1", 'T_M_A_PKS.PKS_ID = t_sum_1.PKS_ID', 'left');


    
    $this->db->order_by("T_M_A_PKS.PKS", "asc");

    $akun = $this->db->get ();
    return $akun->result ();
  }



  public function select($date_penjualan_pks)
  {
    $this->db->select("T_T_A_PENJUALAN_PKS.ID");
    $this->db->select("T_T_A_PENJUALAN_PKS.DATE");
    $this->db->select("T_T_A_PENJUALAN_PKS.TIME");
    $this->db->select("T_M_A_DIVISI.DIVISI_ID");
    $this->db->select("T_M_A_DIVISI.DIVISI");
    $this->db->select("T_M_A_PKS.PKS_ID");
    $this->db->select("T_M_A_PKS.PKS");
    $this->db->select("T_M_A_NO_POLISI.NO_POLISI_ID");
    $this->db->select("T_M_A_NO_POLISI.NO_POLISI");
    $this->db->select("T_M_A_SUPIR.SUPIR_ID");
    $this->db->select("T_M_A_SUPIR.SUPIR");
    $this->db->select("T_M_A_KENDARAAN.KENDARAAN_ID");
    $this->db->select("T_M_A_KENDARAAN.KENDARAAN");
    $this->db->select("T_T_A_PENJUALAN_PKS.NO_TIKET");
    $this->db->select("T_T_A_PENJUALAN_PKS.BRUTO");
    $this->db->select("T_T_A_PENJUALAN_PKS.BRUTO");
    $this->db->select("T_T_A_PENJUALAN_PKS.SORTASE_PERCENTAGE");
    $this->db->select("T_T_A_PENJUALAN_PKS.SORTASE_KG");
    $this->db->select("T_T_A_PENJUALAN_PKS.NETO");
    $this->db->select("T_T_A_PENJUALAN_PKS.R_JO");
    $this->db->select("T_T_A_PENJUALAN_PKS.R_EX");
    $this->db->select("T_T_A_PENJUALAN_PKS.R_DIV_1");
    $this->db->select("T_T_A_PENJUALAN_PKS.R_DIV_2");
    $this->db->select("T_T_A_PENJUALAN_PKS.R_DIV_3");
    $this->db->select("T_T_A_PENJUALAN_PKS.R_DIV_4");
    $this->db->select("T_T_A_PENJUALAN_PKS.RUMUS");
    $this->db->select("T_T_A_PENJUALAN_PKS.UANG_JALAN");
    $this->db->select("T_T_A_PENJUALAN_PKS.TAMBAHAN");
    $this->db->select("T_T_A_PENJUALAN_PKS.TOTAL_UANG_JALAN");
    $this->db->select("T_T_A_PENJUALAN_PKS.HARGA");
    $this->db->select("T_T_A_PENJUALAN_PKS.TOTAL_PENJUALAN");
    $this->db->select("T_T_A_PENJUALAN_PKS.PPN");
    $this->db->select("T_T_A_PENJUALAN_PKS.CREATED_BY");
    $this->db->select("T_T_A_PENJUALAN_PKS.UPDATED_BY");
    $this->db->select("T_T_A_PENJUALAN_PKS.AREA_ID");
    $this->db->select("T_T_A_PENJUALAN_PKS.COMPANY_ID");
    $this->db->select("T_T_A_PENJUALAN_PKS.INV");
    $this->db->select("T_T_A_PENJUALAN_PKS.INV_INT");
    $this->db->select("T_T_A_PENJUALAN_PKS.ENABLE_EDIT");
    $this->db->select("T_T_A_PENJUALAN_PKS.CHECKED_ID");
    $this->db->select("T_T_A_PENJUALAN_PKS.SPECIAL_ID");

    $this->db->from('T_T_A_PENJUALAN_PKS');
    $this->db->join('T_M_A_DIVISI', 'T_M_A_DIVISI.DIVISI_ID = T_T_A_PENJUALAN_PKS.DIVISI_ID', 'left');
    $this->db->join('T_M_A_PKS', 'T_M_A_PKS.PKS_ID = T_T_A_PENJUALAN_PKS.PKS_ID', 'left');
    $this->db->join('T_M_A_NO_POLISI', 'T_M_A_NO_POLISI.NO_POLISI_ID = T_T_A_PENJUALAN_PKS.NO_POLISI_ID', 'left');
    $this->db->join('T_M_A_SUPIR', 'T_M_A_SUPIR.SUPIR_ID = T_T_A_PENJUALAN_PKS.SUPIR_ID', 'left');
    $this->db->join('T_M_A_KENDARAAN', 'T_M_A_KENDARAAN.KENDARAAN_ID = T_T_A_PENJUALAN_PKS.KENDARAAN_ID', 'left');

    #$this->db->where('T_T_A_PENJUALAN_PKS.COMPANY_ID',$this->session->userdata('company_id'));
    #$this->db->where('T_T_A_PENJUALAN_PKS.AREA_ID',$this->session->userdata('area_id'));
    $this->db->where('T_T_A_PENJUALAN_PKS.DATE',$date_penjualan_pks);

    $this->db->order_by("T_T_A_PENJUALAN_PKS.ID", "desc");

    $akun = $this->db->get ();
    return $akun->result ();
  }

  public function delete($id)
  {
    $this->db->where('ID',$id);
    $this->db->delete('T_T_A_PENJUALAN_PKS');
  }

  function tambah($data)
  {
        $this->db->insert('T_T_A_PENJUALAN_PKS', $data);
        return TRUE;
  }

}


