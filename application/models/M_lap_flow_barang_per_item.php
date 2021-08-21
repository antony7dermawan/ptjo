<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_lap_flow_barang_per_item extends CI_Model {
    




public function select_range_date($from_date,$to_date,$barang_id,$kategori_id)
  {

    $this->db->select('T_M_D_BARANG.KODE_BARANG');
    $this->db->select('T_M_D_BARANG.BARANG');
    $this->db->select('T_M_D_BARANG.PART_NUMBER');
    $this->db->select('T_M_D_BARANG.MERK_BARANG');



    $this->db->select("T_T_T_PEMBELIAN.ID");
    $this->db->select("T_T_T_PEMBELIAN.INV");
    $this->db->select("T_T_T_PEMBELIAN_RINCIAN.DATE");
    $this->db->select("T_T_T_PEMBELIAN_RINCIAN.TIME");
    $this->db->select("T_T_T_PEMBELIAN.KET");
    $this->db->select("T_T_T_PEMBELIAN.TABLE_CODE");


    $this->db->select("T_T_T_PEMBELIAN_RINCIAN.SUB_TOTAL as SUM_SUB_TOTAL");
    $this->db->select("T_T_T_PEMBELIAN_RINCIAN.QTY as SUM_QTY");
    $this->db->select("T_T_T_PEMBELIAN_RINCIAN.HARGA as AVG_HARGA");



    $this->db->select("T_T_T_PEMBELIAN_RINCIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMBELIAN_RINCIAN.UPDATED_BY");




    $this->db->from('T_M_D_BARANG');


    $this->db->join('T_T_T_PEMBELIAN_RINCIAN', 'T_M_D_BARANG.BARANG_ID = T_T_T_PEMBELIAN_RINCIAN.BARANG_ID', 'left');

    $this->db->join('T_T_T_PEMBELIAN', 'T_T_T_PEMBELIAN_RINCIAN.PEMBELIAN_ID = T_T_T_PEMBELIAN.ID', 'left');


    



    $this->db->where("(T_T_T_PEMBELIAN.T_STATUS=0 or T_T_T_PEMBELIAN.T_STATUS=1 or T_T_T_PEMBELIAN.T_STATUS=2)");

    $this->db->where("(T_T_T_PEMBELIAN_RINCIAN.SPECIAL_CASE_ID=0)");


    $this->db->where("T_T_T_PEMBELIAN.DATE<='{$to_date}' and T_T_T_PEMBELIAN.DATE>='{$from_date}'");

    $this->db->where("T_M_D_BARANG.BARANG_ID='{$barang_id}'");

    if($kategori_id!=0)
    {
        $this->db->where("T_M_D_BARANG.KATEGORI_ID='{$kategori_id}'");
    }


    $this->db->where("T_M_D_BARANG.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->where("T_T_T_PEMBELIAN.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->where('T_T_T_PEMBELIAN_RINCIAN.MARK_FOR_DELETE',FALSE);

    $query1 = $this->db->get_compiled_select();







    $this->db->select('T_M_D_BARANG.KODE_BARANG');
    $this->db->select('T_M_D_BARANG.BARANG');
    $this->db->select('T_M_D_BARANG.PART_NUMBER');
    $this->db->select('T_M_D_BARANG.MERK_BARANG');



    $this->db->select("T_T_T_RETUR_PEMBELIAN.ID");
    $this->db->select("T_T_T_RETUR_PEMBELIAN.INV");
    $this->db->select("T_T_T_RETUR_PEMBELIAN.DATE");
    $this->db->select("T_T_T_RETUR_PEMBELIAN.TIME");
    $this->db->select("T_T_T_RETUR_PEMBELIAN.KET");
    $this->db->select("T_T_T_RETUR_PEMBELIAN.TABLE_CODE");

    $this->db->select("SUM_SUB_TOTAL");
    $this->db->select("SUM_QTY");
    $this->db->select("AVG_HARGA");



    $this->db->select("T_T_T_RETUR_PEMBELIAN_RINCIAN.CREATED_BY");
    $this->db->select("T_T_T_RETUR_PEMBELIAN_RINCIAN.UPDATED_BY");

   


    $this->db->from('T_M_D_BARANG');


    $this->db->join('T_T_T_RETUR_PEMBELIAN_RINCIAN', 'T_M_D_BARANG.BARANG_ID = T_T_T_RETUR_PEMBELIAN_RINCIAN.BARANG_ID', 'left');

    $this->db->join('T_T_T_RETUR_PEMBELIAN', 'T_T_T_RETUR_PEMBELIAN_RINCIAN.RETUR_PEMBELIAN_ID = T_T_T_RETUR_PEMBELIAN.ID', 'left');


    $this->db->join("(select \"RETUR_PEMBELIAN_ID\",avg(\"HARGA\")\"AVG_HARGA\" from \"T_T_T_RETUR_PEMBELIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false and \"BARANG_ID\"='{$barang_id}' group by \"RETUR_PEMBELIAN_ID\") as t_sum_3", 'T_T_T_RETUR_PEMBELIAN.ID = t_sum_3.RETUR_PEMBELIAN_ID', 'left');

    $this->db->join("(select \"RETUR_PEMBELIAN_ID\",sum(\"QTY\")\"SUM_QTY\" from \"T_T_T_RETUR_PEMBELIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false and \"BARANG_ID\"='{$barang_id}' group by \"RETUR_PEMBELIAN_ID\") as t_sum_2", 'T_T_T_RETUR_PEMBELIAN.ID = t_sum_2.RETUR_PEMBELIAN_ID', 'left');

    $this->db->join("(select \"RETUR_PEMBELIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_RETUR_PEMBELIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false and \"BARANG_ID\"='{$barang_id}' group by \"RETUR_PEMBELIAN_ID\") as t_sum_1", 'T_T_T_RETUR_PEMBELIAN.ID = t_sum_1.RETUR_PEMBELIAN_ID', 'left');

    $this->db->where("T_T_T_RETUR_PEMBELIAN.DATE<='{$to_date}' and T_T_T_RETUR_PEMBELIAN.DATE>='{$from_date}'");

    $this->db->where("T_M_D_BARANG.BARANG_ID='{$barang_id}'");

    if($kategori_id!=0)
    {
        $this->db->where("T_M_D_BARANG.KATEGORI_ID='{$kategori_id}'");
    }

    $this->db->where("T_M_D_BARANG.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->where("T_T_T_RETUR_PEMBELIAN.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->where('T_T_T_RETUR_PEMBELIAN_RINCIAN.MARK_FOR_DELETE',FALSE);

    $query2 = $this->db->get_compiled_select();

















    $this->db->select('T_M_D_BARANG.KODE_BARANG');
    $this->db->select('T_M_D_BARANG.BARANG');
    $this->db->select('T_M_D_BARANG.PART_NUMBER');
    $this->db->select('T_M_D_BARANG.MERK_BARANG');



    $this->db->select("T_T_T_PENJUALAN.ID");
    $this->db->select("T_T_T_PENJUALAN.INV");
    $this->db->select("T_T_T_PENJUALAN.DATE");
    $this->db->select("T_T_T_PENJUALAN.TIME");
    $this->db->select("T_T_T_PENJUALAN.KET");
    $this->db->select("T_T_T_PENJUALAN.TABLE_CODE");


    $this->db->select("SUM_SUB_TOTAL");
    $this->db->select("SUM_QTY");
    $this->db->select("AVG_HARGA");



    $this->db->select("T_T_T_PENJUALAN_RINCIAN.CREATED_BY");
    $this->db->select("T_T_T_PENJUALAN_RINCIAN.UPDATED_BY");

   


    $this->db->from('T_M_D_BARANG');


    $this->db->join('T_T_T_PENJUALAN_RINCIAN', 'T_M_D_BARANG.BARANG_ID = T_T_T_PENJUALAN_RINCIAN.BARANG_ID', 'left');

    $this->db->join('T_T_T_PENJUALAN', 'T_T_T_PENJUALAN_RINCIAN.PENJUALAN_ID = T_T_T_PENJUALAN.ID', 'left');

    $this->db->join("(select \"PENJUALAN_ID\",avg(\"HARGA\")\"AVG_HARGA\" from \"T_T_T_PENJUALAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false and \"BARANG_ID\"='{$barang_id}' group by \"PENJUALAN_ID\") as t_sum_3", 'T_T_T_PENJUALAN.ID = t_sum_3.PENJUALAN_ID', 'left');

    $this->db->join("(select \"PENJUALAN_ID\",sum(\"QTY\")\"SUM_QTY\" from \"T_T_T_PENJUALAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false and \"BARANG_ID\"='{$barang_id}' group by \"PENJUALAN_ID\") as t_sum_2", 'T_T_T_PENJUALAN.ID = t_sum_2.PENJUALAN_ID', 'left');

    $this->db->join("(select \"PENJUALAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PENJUALAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false and \"BARANG_ID\"='{$barang_id}' group by \"PENJUALAN_ID\") as t_sum_1", 'T_T_T_PENJUALAN.ID = t_sum_1.PENJUALAN_ID', 'left');

    $this->db->where("T_T_T_PENJUALAN.DATE<='{$to_date}' and T_T_T_PENJUALAN.DATE>='{$from_date}'");

    $this->db->where("T_M_D_BARANG.BARANG_ID='{$barang_id}'");

    if($kategori_id!=0)
    {
        $this->db->where("T_M_D_BARANG.KATEGORI_ID='{$kategori_id}'");
    }

    $this->db->where("T_M_D_BARANG.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->where("T_T_T_PENJUALAN.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->where('T_T_T_PENJUALAN_RINCIAN.MARK_FOR_DELETE',FALSE);

    $query3 = $this->db->get_compiled_select();














    $this->db->select('T_M_D_BARANG.KODE_BARANG');
    $this->db->select('T_M_D_BARANG.BARANG');
    $this->db->select('T_M_D_BARANG.PART_NUMBER');
    $this->db->select('T_M_D_BARANG.MERK_BARANG');



    $this->db->select("T_T_T_RETUR_PENJUALAN.ID");
    $this->db->select("T_T_T_RETUR_PENJUALAN.INV");
    $this->db->select("T_T_T_RETUR_PENJUALAN.DATE");
    $this->db->select("T_T_T_RETUR_PENJUALAN.TIME");
    $this->db->select("T_T_T_RETUR_PENJUALAN.KET");
    $this->db->select("T_T_T_RETUR_PENJUALAN.TABLE_CODE");


    $this->db->select("SUM_SUB_TOTAL");
    $this->db->select("SUM_QTY");
    $this->db->select("AVG_HARGA");


    $this->db->select("T_T_T_RETUR_PENJUALAN_RINCIAN.CREATED_BY");
    $this->db->select("T_T_T_RETUR_PENJUALAN_RINCIAN.UPDATED_BY");

   


    $this->db->from('T_M_D_BARANG');


    $this->db->join('T_T_T_RETUR_PENJUALAN_RINCIAN', 'T_M_D_BARANG.BARANG_ID = T_T_T_RETUR_PENJUALAN_RINCIAN.BARANG_ID', 'left');

    $this->db->join('T_T_T_RETUR_PENJUALAN', 'T_T_T_RETUR_PENJUALAN_RINCIAN.RETUR_PENJUALAN_ID = T_T_T_RETUR_PENJUALAN.ID', 'left');

    $this->db->join("(select \"RETUR_PENJUALAN_ID\",avg(\"HARGA\")\"AVG_HARGA\" from \"T_T_T_RETUR_PENJUALAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false and \"BARANG_ID\"='{$barang_id}' group by \"RETUR_PENJUALAN_ID\") as t_sum_3", 'T_T_T_RETUR_PENJUALAN.ID = t_sum_3.RETUR_PENJUALAN_ID', 'left');

    $this->db->join("(select \"RETUR_PENJUALAN_ID\",sum(\"QTY\")\"SUM_QTY\" from \"T_T_T_RETUR_PENJUALAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false and \"BARANG_ID\"='{$barang_id}' group by \"RETUR_PENJUALAN_ID\") as t_sum_2", 'T_T_T_RETUR_PENJUALAN.ID = t_sum_2.RETUR_PENJUALAN_ID', 'left');

    $this->db->join("(select \"RETUR_PENJUALAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_RETUR_PENJUALAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false and \"BARANG_ID\"='{$barang_id}' group by \"RETUR_PENJUALAN_ID\") as t_sum_1", 'T_T_T_RETUR_PENJUALAN.ID = t_sum_1.RETUR_PENJUALAN_ID', 'left');

    $this->db->where("T_T_T_RETUR_PENJUALAN.DATE<='{$to_date}' and T_T_T_RETUR_PENJUALAN.DATE>='{$from_date}'");

    $this->db->where("T_M_D_BARANG.BARANG_ID='{$barang_id}'");

    if($kategori_id!=0)
    {
        $this->db->where("T_M_D_BARANG.KATEGORI_ID='{$kategori_id}'");
    }

    $this->db->where("T_M_D_BARANG.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->where("T_T_T_RETUR_PENJUALAN.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->where('T_T_T_RETUR_PENJUALAN_RINCIAN.MARK_FOR_DELETE',FALSE);

    $query4 = $this->db->get_compiled_select();








    $this->db->select('T_M_D_BARANG.KODE_BARANG');
    $this->db->select('T_M_D_BARANG.BARANG');
    $this->db->select('T_M_D_BARANG.PART_NUMBER');
    $this->db->select('T_M_D_BARANG.MERK_BARANG');



    $this->db->select("T_T_T_PEMAKAIAN.ID");
    $this->db->select("T_T_T_PEMAKAIAN.INV");
    $this->db->select("T_T_T_PEMAKAIAN.DATE");
    $this->db->select("T_T_T_PEMAKAIAN.TIME");
    $this->db->select("T_T_T_PEMAKAIAN.KET");
    $this->db->select("T_T_T_PEMAKAIAN.TABLE_CODE");


    $this->db->select("SUM_SUB_TOTAL");
    $this->db->select("SUM_QTY");
    $this->db->select("AVG_HARGA");



    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMAKAIAN_RINCIAN.UPDATED_BY");

   


    $this->db->from('T_M_D_BARANG');


    $this->db->join('T_T_T_PEMAKAIAN_RINCIAN', 'T_M_D_BARANG.BARANG_ID = T_T_T_PEMAKAIAN_RINCIAN.BARANG_ID', 'left');

    $this->db->join('T_T_T_PEMAKAIAN', 'T_T_T_PEMAKAIAN_RINCIAN.PEMAKAIAN_ID = T_T_T_PEMAKAIAN.ID', 'left');

    $this->db->join("(select \"PEMAKAIAN_ID\",avg(\"HARGA\")\"AVG_HARGA\" from \"T_T_T_PEMAKAIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false and \"BARANG_ID\"='{$barang_id}' group by \"PEMAKAIAN_ID\") as t_sum_3", 'T_T_T_PEMAKAIAN.ID = t_sum_3.PEMAKAIAN_ID', 'left');

    $this->db->join("(select \"PEMAKAIAN_ID\",sum(\"QTY\")\"SUM_QTY\" from \"T_T_T_PEMAKAIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false and \"BARANG_ID\"='{$barang_id}' group by \"PEMAKAIAN_ID\") as t_sum_2", 'T_T_T_PEMAKAIAN.ID = t_sum_2.PEMAKAIAN_ID', 'left');

    $this->db->join("(select \"PEMAKAIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMAKAIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false and \"BARANG_ID\"='{$barang_id}' group by \"PEMAKAIAN_ID\") as t_sum_1", 'T_T_T_PEMAKAIAN.ID = t_sum_1.PEMAKAIAN_ID', 'left');

    $this->db->where("T_T_T_PEMAKAIAN.DATE<='{$to_date}' and T_T_T_PEMAKAIAN.DATE>='{$from_date}'");

    $this->db->where("T_M_D_BARANG.BARANG_ID='{$barang_id}'");

    if($kategori_id!=0)
    {
        $this->db->where("T_M_D_BARANG.KATEGORI_ID='{$kategori_id}'");
    }

    $this->db->where("T_M_D_BARANG.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->where("T_T_T_PEMAKAIAN.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->where('T_T_T_PEMAKAIAN_RINCIAN.MARK_FOR_DELETE',FALSE);

    $query5 = $this->db->get_compiled_select();













    $this->db->select('T_M_D_BARANG.KODE_BARANG');
    $this->db->select('T_M_D_BARANG.BARANG');
    $this->db->select('T_M_D_BARANG.PART_NUMBER');
    $this->db->select('T_M_D_BARANG.MERK_BARANG');



    $this->db->select("T_T_T_RETUR_PEMAKAIAN.ID");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.INV");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.DATE");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.TIME");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.KET");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN.TABLE_CODE");


    $this->db->select("SUM_SUB_TOTAL");
    $this->db->select("SUM_QTY");
    $this->db->select("AVG_HARGA");



    $this->db->select("T_T_T_RETUR_PEMAKAIAN_RINCIAN.CREATED_BY");
    $this->db->select("T_T_T_RETUR_PEMAKAIAN_RINCIAN.UPDATED_BY");

   


    $this->db->from('T_M_D_BARANG');


    $this->db->join('T_T_T_RETUR_PEMAKAIAN_RINCIAN', 'T_M_D_BARANG.BARANG_ID = T_T_T_RETUR_PEMAKAIAN_RINCIAN.BARANG_ID', 'left');

    $this->db->join('T_T_T_RETUR_PEMAKAIAN', 'T_T_T_RETUR_PEMAKAIAN_RINCIAN.RETUR_PEMAKAIAN_ID = T_T_T_RETUR_PEMAKAIAN.ID', 'left');

    $this->db->join("(select \"RETUR_PEMAKAIAN_ID\",avg(\"HARGA\")\"AVG_HARGA\" from \"T_T_T_RETUR_PEMAKAIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false and \"BARANG_ID\"='{$barang_id}' group by \"RETUR_PEMAKAIAN_ID\") as t_sum_3", 'T_T_T_RETUR_PEMAKAIAN.ID = t_sum_3.RETUR_PEMAKAIAN_ID', 'left');

    $this->db->join("(select \"RETUR_PEMAKAIAN_ID\",sum(\"QTY\")\"SUM_QTY\" from \"T_T_T_RETUR_PEMAKAIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false and \"BARANG_ID\"='{$barang_id}' group by \"RETUR_PEMAKAIAN_ID\") as t_sum_2", 'T_T_T_RETUR_PEMAKAIAN.ID = t_sum_2.RETUR_PEMAKAIAN_ID', 'left');

    $this->db->join("(select \"RETUR_PEMAKAIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_RETUR_PEMAKAIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false and \"BARANG_ID\"='{$barang_id}' group by \"RETUR_PEMAKAIAN_ID\") as t_sum_1", 'T_T_T_RETUR_PEMAKAIAN.ID = t_sum_1.RETUR_PEMAKAIAN_ID', 'left');

    $this->db->where("T_T_T_RETUR_PEMAKAIAN.DATE<='{$to_date}' and T_T_T_RETUR_PEMAKAIAN.DATE>='{$from_date}'");

    $this->db->where("T_M_D_BARANG.BARANG_ID='{$barang_id}'");

    if($kategori_id!=0)
    {
        $this->db->where("T_M_D_BARANG.KATEGORI_ID='{$kategori_id}'");
    }

    $this->db->where("T_M_D_BARANG.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->where("T_T_T_RETUR_PEMAKAIAN.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->where('T_T_T_RETUR_PEMAKAIAN_RINCIAN.MARK_FOR_DELETE',FALSE);

    $query6 = $this->db->get_compiled_select();










    $this->db->select('T_M_D_BARANG.KODE_BARANG');
    $this->db->select('T_M_D_BARANG.BARANG');
    $this->db->select('T_M_D_BARANG.PART_NUMBER');
    $this->db->select('T_M_D_BARANG.MERK_BARANG');



    $this->db->select("T_T_T_PEMBELIAN.ID");
    $this->db->select("T_T_T_PEMBELIAN.INV");
    $this->db->select("T_T_T_PEMBELIAN.DATE");
    $this->db->select("T_T_T_PEMBELIAN.TIME");
    $this->db->select("T_T_T_PEMBELIAN.KET");
    $this->db->select("CASE WHEN \"T_T_T_PEMBELIAN\".\"TABLE_CODE\" = 'PINLOK' THEN 'PINLOK_OUT' ELSE '' END AS \"TABLE_CODE\"");


    $this->db->select("SUM_SUB_TOTAL");
    $this->db->select("SUM_QTY");
    $this->db->select("AVG_HARGA");



    $this->db->select("T_T_T_PEMBELIAN_RINCIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMBELIAN_RINCIAN.UPDATED_BY");




    $this->db->from('T_M_D_BARANG');


    $this->db->join('T_T_T_PEMBELIAN_RINCIAN', 'T_M_D_BARANG.BARANG_ID = T_T_T_PEMBELIAN_RINCIAN.BARANG_ID', 'left');

    $this->db->join('T_T_T_PEMBELIAN', 'T_T_T_PEMBELIAN_RINCIAN.PEMBELIAN_ID = T_T_T_PEMBELIAN.ID', 'left');


    $this->db->join("(select \"PEMBELIAN_ID\",avg(\"HARGA\")\"AVG_HARGA\" from \"T_T_T_PEMBELIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false and \"BARANG_ID\"='{$barang_id}' group by \"PEMBELIAN_ID\") as t_sum_3", 'T_T_T_PEMBELIAN.ID = t_sum_3.PEMBELIAN_ID', 'left');

    $this->db->join("(select \"PEMBELIAN_ID\",sum(\"QTY\")\"SUM_QTY\" from \"T_T_T_PEMBELIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false and \"BARANG_ID\"='{$barang_id}' group by \"PEMBELIAN_ID\") as t_sum_2", 'T_T_T_PEMBELIAN.ID = t_sum_2.PEMBELIAN_ID', 'left');

    $this->db->join("(select \"PEMBELIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMBELIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false and \"BARANG_ID\"='{$barang_id}' group by \"PEMBELIAN_ID\") as t_sum_1", 'T_T_T_PEMBELIAN.ID = t_sum_1.PEMBELIAN_ID', 'left');



    $this->db->where("(T_T_T_PEMBELIAN.T_STATUS=50 or T_T_T_PEMBELIAN.T_STATUS=5)");


    $this->db->where("T_T_T_PEMBELIAN.DATE<='{$to_date}' and T_T_T_PEMBELIAN.DATE>='{$from_date}'");

    $this->db->where("T_M_D_BARANG.BARANG_ID='{$barang_id}'");

    if($kategori_id!=0)
    {
        $this->db->where("T_M_D_BARANG.KATEGORI_ID='{$kategori_id}'");
    }


    $this->db->where("T_M_D_BARANG.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->where("T_T_T_PEMBELIAN.COMPANY_ID_FROM={$this->session->userdata('company_id')}");
    $this->db->where('T_T_T_PEMBELIAN_RINCIAN.MARK_FOR_DELETE',FALSE);

    $query7 = $this->db->get_compiled_select();











    $this->db->select('T_M_D_BARANG.KODE_BARANG');
    $this->db->select('T_M_D_BARANG.BARANG');
    $this->db->select('T_M_D_BARANG.PART_NUMBER');
    $this->db->select('T_M_D_BARANG.MERK_BARANG');



    $this->db->select("T_T_T_PEMBELIAN.ID");
    $this->db->select("T_T_T_PEMBELIAN.INV");
    $this->db->select("T_T_T_PEMBELIAN.DATE");
    $this->db->select("T_T_T_PEMBELIAN.TIME");
    $this->db->select("T_T_T_PEMBELIAN.KET");
    $this->db->select("CASE WHEN \"T_T_T_PEMBELIAN\".\"TABLE_CODE\" = 'PINLOK' THEN 'PINLOK_IN' ELSE '' END AS \"TABLE_CODE\"");


    $this->db->select("SUM_SUB_TOTAL");
    $this->db->select("SUM_QTY");
    $this->db->select("AVG_HARGA");



    $this->db->select("T_T_T_PEMBELIAN_RINCIAN.CREATED_BY");
    $this->db->select("T_T_T_PEMBELIAN_RINCIAN.UPDATED_BY");




    $this->db->from('T_M_D_BARANG');


    $this->db->join('T_T_T_PEMBELIAN_RINCIAN', 'T_M_D_BARANG.BARANG_ID = T_T_T_PEMBELIAN_RINCIAN.BARANG_ID', 'left');

    $this->db->join('T_T_T_PEMBELIAN', 'T_T_T_PEMBELIAN_RINCIAN.PEMBELIAN_ID = T_T_T_PEMBELIAN.ID', 'left');


    $this->db->join("(select \"PEMBELIAN_ID\",avg(\"HARGA\")\"AVG_HARGA\" from \"T_T_T_PEMBELIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false and \"BARANG_ID\"='{$barang_id}' group by \"PEMBELIAN_ID\") as t_sum_3", 'T_T_T_PEMBELIAN.ID = t_sum_3.PEMBELIAN_ID', 'left');

    $this->db->join("(select \"PEMBELIAN_ID\",sum(\"QTY\")\"SUM_QTY\" from \"T_T_T_PEMBELIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false and \"BARANG_ID\"='{$barang_id}' group by \"PEMBELIAN_ID\") as t_sum_2", 'T_T_T_PEMBELIAN.ID = t_sum_2.PEMBELIAN_ID', 'left');

    $this->db->join("(select \"PEMBELIAN_ID\",sum(\"SUB_TOTAL\")\"SUM_SUB_TOTAL\" from \"T_T_T_PEMBELIAN_RINCIAN\" where \"MARK_FOR_DELETE\"=false and \"BARANG_ID\"='{$barang_id}' group by \"PEMBELIAN_ID\") as t_sum_1", 'T_T_T_PEMBELIAN.ID = t_sum_1.PEMBELIAN_ID', 'left');



    $this->db->where("(T_T_T_PEMBELIAN.T_STATUS=50 or T_T_T_PEMBELIAN.T_STATUS=5)");


    $this->db->where("T_T_T_PEMBELIAN.DATE<='{$to_date}' and T_T_T_PEMBELIAN.DATE>='{$from_date}'");

    $this->db->where("T_M_D_BARANG.BARANG_ID='{$barang_id}'");

    if($kategori_id!=0)
    {
        $this->db->where("T_M_D_BARANG.KATEGORI_ID='{$kategori_id}'");
    }


    $this->db->where("T_M_D_BARANG.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->where("T_T_T_PEMBELIAN.COMPANY_ID={$this->session->userdata('company_id')}");
    $this->db->where('T_T_T_PEMBELIAN_RINCIAN.MARK_FOR_DELETE',FALSE);

    $query8 = $this->db->get_compiled_select();






    $query = $this->db->query($query1." UNION ".$query2." UNION ".$query3." UNION ".$query4." UNION ".$query5." UNION ".$query6." UNION ".$query7." UNION ".$query8." order by \"DATE\",\"TIME\" asc");



    return $query->result();


  }


}


