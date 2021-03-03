<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Send_t_po extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('m_t_po');
    $this->load->model('m_send_t_po');
    $this->load->model('m_send_t_po_rincian');
  }

  public function index()
  {
    include('db_connection.php');
    if( $conn )
    {
      $read_select = $this->m_send_t_po->select($this->session->userdata('date_po'));
      foreach ($read_select as $key => $value) 
      {
        $read_id = $value->ID;
        $read_date = $value->DATE;
        $read_time = $value->TIME;
        $read_no_po = $value->NO_PO;
        $read_supplier = $value->SUPPLIER;
        $read_ket = $value->KET;
        $read_created_by = $value->CREATED_BY;
        $read_updated_by = $value->UPDATED_BY;
        $read_payment_method = $value->PAYMENT_METHOD;
        $read_nama_bank = $value->NAMA_BANK;
        $read_norek = $value->NOREK;
        $read_atas_nama = $value->ATAS_NAMA;
        $read_cabang = $value->CABANG;
        $read_nama_penerima = $value->NAMA_PENERIMA;
        $read_telp_penerima = $value->TELP_PENERIMA;
        $read_telp_supplier = $value->TELP_SUPPLIER;
        $read_alamat_supplier = $value->ALAMAT_SUPPLIER;
        $read_expire_date = $value->EXPIRE_DATE;
        $read_enable_edit = $value->ENABLE_EDIT;
        $read_lainnya = $value->LAINNYA;
        $read_company_id = $value->COMPANY_ID;
      

        

        $query = pg_query($conn, "INSERT INTO public.\"T_PO\"( \"DATE\", \"TIME\", \"NO_PO\", \"SUPPLIER\", \"KET\", \"CREATED_BY\", \"UPDATED_BY\", \"PAYMENT_METHOD\", \"NAMA_BANK\", \"NOREK\", \"ATAS_NAMA\", \"CABANG\", \"NAMA_PENERIMA\", \"TELP_PENERIMA\", \"TELP_SUPPLIER\", \"ALAMAT_SUPPLIER\", \"EXPIRE_DATE\", \"ENABLE_EDIT\", \"LAINNYA\", \"COMPANY_ID\") VALUES ( '{$read_date}', '{$read_time}', '{$read_no_po}', '{$read_supplier}', '{$read_ket}', '{$read_created_by}', '{$read_updated_by}', '{$read_payment_method}', '{$read_nama_bank}', '{$read_norek}', '{$read_atas_nama}', '{$read_cabang}', '{$read_nama_penerima}', '{$read_telp_penerima}', '{$read_telp_supplier}', '{$read_alamat_supplier}', '{$read_expire_date}', '{$read_enable_edit}', '{$read_lainnya}','{$read_company_id}');");
        if ( $query ) 
        {
            echo  "Record Successfully Added! for ID = {$read_id} / NO PO = {$read_no_po}<br>";
            $data = array(
            'ENABLE_EDIT' => 0
            );
            $this->m_t_po->update($data, $read_id);
        }


        $query = "SELECT * FROM \"T_PO\" order by \"ID\" desc limit 1";
        $result = pg_query($query) or die('Error message: ' . pg_last_error());

        while($value = pg_fetch_row($result))
        {
            $cloud_po_id = ($value[0]);
        }

        $read_select_in = $this->m_send_t_po_rincian->select($read_id);
        foreach ($read_select_in as $key_in => $value_in) 
        {
            $r_in_id = $value_in->ID;
            $r_in_nama_barang = $value_in->NAMA_BARANG;
            $r_in_qty = $value_in->QTY;
            $r_in_satuan = $value_in->SATUAN;
            $r_in_harga = $value_in->HARGA;
            $r_in_created_by = $value_in->CREATED_BY;
            $r_in_updated_by = $value_in->UPDATED_BY;
            $r_in_sub_total = $value_in->SUB_TOTAL;
            $r_in_ppn = $value_in->PPN;

            $query = pg_query($conn, "INSERT INTO public.\"T_PO_RINCIAN\"(\"PO_ID\", \"NAMA_BARANG\", \"QTY\", \"SATUAN\", \"HARGA\", \"CREATED_BY\", \"UPDATED_BY\", \"SUB_TOTAL\", \"PPN\") VALUES ( '{$cloud_po_id}', '{$r_in_nama_barang}', '{$r_in_qty}', '{$r_in_satuan}', '{$r_in_harga}', '{$r_in_created_by}', '{$r_in_updated_by}', '{$r_in_sub_total}', '{$r_in_ppn}');");
            if ( $query ) 
            {
                echo  "Record Successfully Added! for ID = {$r_in_id} / RINCIAN BARANG = {$r_in_nama_barang}<br>";
            }


        }

        





      }//end po
      echo  "Semua Data Sudah Dikirim";
   
    }
    else
    {
      echo "Tidak Ada Internet, Silahkan Periksa Jaringan dan Ulangi Send to Cloud!";
      
    }

     
  }


}
